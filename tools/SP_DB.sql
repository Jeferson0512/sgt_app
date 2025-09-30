DELIMITER $ $ DROP PROCEDURE IF EXISTS sp_productos_crear $ $ CREATE PROCEDURE sp_productos_crear(
    IN p_nombre VARCHAR(100),
    IN p_cantidad_actual INT,
    IN p_descripcion TEXT,
    IN p_codcategoria VARCHAR(9),
    IN p_codmarca VARCHAR(9),
    IN p_codmodelo VARCHAR(9),
    IN p_codumedida VARCHAR(9),
    IN p_preciounitario DECIMAL(10, 2),
    IN p_ubicacion VARCHAR(100),
    IN p_fechaingreso DATE,
    IN p_codestadropuesto VARCHAR(9),
    IN p_codproveedor VARCHAR(9),
    IN p_observaciones TEXT,
    OUT o_codigo VARCHAR(12)
) BEGIN -- Normalización y validaciones mínimas
SET
    p_nombre = NULLIF(TRIM(p_nombre), '');

IF p_nombre IS NULL THEN SIGNAL SQLSTATE '45000'
SET
    MESSAGE_TEXT = 'nombre es requerido';

END IF;

IF p_preciounitario IS NULL
OR p_preciounitario < 0 THEN SIGNAL SQLSTATE '45000'
SET
    MESSAGE_TEXT = 'preciounitario inválido';

END IF;

IF p_cantidad_actual IS NULL
OR p_cantidad_actual < 0 THEN
SET
    p_cantidad_actual = 0;

END IF;

-- Limpia la variable de sesión usada por el trigger
SET
    @codigo_generado := NULL;

START TRANSACTION;

INSERT INTO
    productos(
        nombre,
        cantidad_actual,
        descripcion,
        codcategoria,
        codmarca,
        codmodelo,
        codumedida,
        preciounitario,
        ubicacion,
        fechaingreso,
        codestadropuesto,
        codproveedor,
        observaciones
    )
VALUES
    (
        p_nombre,
        p_cantidad_actual,
        p_descripcion,
        p_codcategoria,
        p_codmarca,
        p_codmodelo,
        p_codumedida,
        p_preciounitario,
        p_ubicacion,
        COALESCE(p_fechaingreso, CURRENT_DATE),
        p_codestadropuesto,
        p_codproveedor,
        p_observaciones
    );

-- El trigger asignó @codigo_generado
SET
    o_codigo := @codigo_generado;

-- Seguridad: si por alguna razón no se seteó, intenta recuperar (menos fiable)
IF o_codigo IS NULL THEN
SELECT
    codigo INTO o_codigo
FROM
    productos
WHERE
    nombre = p_nombre
    AND codmarca = p_codmarca
    AND codmodelo = p_codmodelo
ORDER BY
    codigo DESC
LIMIT
    1;

END IF;

COMMIT;

-- Devuelve la fila insertada
SELECT
    *
FROM
    productos
WHERE
    codigo = o_codigo;

END $ $ DELIMITER;

-- MySQL 8+
DELIMITER $$
	
DROP PROCEDURE IF EXISTS sp_agregarCorrectivoRepuesto;
DELIMITER $$

CREATE PROCEDURE sp_agregarCorrectivoRepuesto(
    IN  p_codcorrectivo        VARCHAR(12),
    IN  p_codrepuestos         VARCHAR(12),
    IN  p_codunidad            VARCHAR(9),
    IN  p_descripcion          VARCHAR(250),
    IN  p_descripcion_unidad   VARCHAR(250),
    IN  p_abreviatura_unidad   VARCHAR(5),
    IN  p_cantidad             DECIMAL(18,2),
    IN  p_observacion          VARCHAR(250)
)
BEGIN
    -- Normalización ligera
    SET p_codcorrectivo       = NULLIF(TRIM(p_codcorrectivo), '');
    SET p_codrepuestos        = NULLIF(TRIM(p_codrepuestos), '');
    SET p_descripcion         = NULLIF(TRIM(p_descripcion), '');
    SET p_codunidad           = NULLIF(TRIM(p_codunidad), '');
    SET p_descripcion_unidad  = NULLIF(TRIM(p_descripcion_unidad), '');
    SET p_abreviatura_unidad  = NULLIF(TRIM(p_abreviatura_unidad), '');
    SET p_observacion         = NULLIF(TRIM(p_observacion), '');

    -- Validaciones mínimas
    IF p_codcorrectivo IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'codcorrectivo es requerido';
    END IF;
    IF p_codrepuestos IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'codrepuestos es requerido';
    END IF;
    IF p_codunidad IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'codunidad es requerido';
    END IF;
    IF p_cantidad IS NULL OR p_cantidad < 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'cantidad inválida';
    END IF;

    START TRANSACTION;

    INSERT INTO correctivo_material (
        codcorrectivo, codrepuestos, descripcion, codunidad, descripcion_unidad,
        abreviatura_unidad, cantidad, Observacion
    ) VALUES (
        p_codcorrectivo, p_codrepuestos, p_descripcion, p_codunidad, p_descripcion_unidad,
        p_abreviatura_unidad, p_cantidad, p_observacion
    );

    COMMIT;

    -- Devuelve la fila creada
    SELECT *
    FROM correctivo_material
    WHERE codcorrectivo = p_codcorrectivo;
END$$

DELIMITER ;


DROP PROCEDURE IF EXISTS sp_listarCorrectivoRepuesto;
DELIMITER $$

CREATE PROCEDURE sp_listarCorrectivoRepuesto(
    IN  p_codcorrectivo        VARCHAR(12)
)
BEGIN
    -- Normalización ligera
    SET p_codcorrectivo       = NULLIF(TRIM(p_codcorrectivo), '');

    -- Validaciones mínimas
    IF p_codcorrectivo IS NULL THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'codcorrectivo es requerido';
    END IF;

    START TRANSACTION;

	SELECT  cr.codcorrectivo,
    		cr.codrepuestos,
            cr.codunidad,
            cr.descripcion AS cr_descripcion,
            cr.descripcion_unidad AS cr_descripcion_unidad,
            cr.abreviatura_unidad AS cr_abreviatura_unidad,
            cr.cantidad,
            cr.Observacion,
            r.nombre AS r_nombre,
            r.descripcion AS r_descripcion,
            um.nombre AS um_nombre,
            um.tipo AS um_tipo,
            um.simbolo AS um_simbolo
    FROM correctivo_material cr 
    INNER JOIN repuestos r ON cr.codrepuestos = r.codigo
    INNER JOIN unidad_medida um ON cr.codunidad = um.codigo
    WHERE cr.codcorrectivo = p_codcorrectivo;
    
    COMMIT;
END$$

DELIMITER ;



DELIMITER $$
CREATE OR REPLACE PROCEDURE `sp_agregarCorrectivoArchivo`(
    IN p_codcorrectivo VARCHAR(12),
    IN p_tipo VARCHAR(100),
    IN p_extension VARCHAR(10),
    IN p_size VARCHAR(100),
    IN p_estado VARCHAR(1),
    IN p_usercreate VARCHAR(100),
    IN p_ruta_base VARCHAR(300), -- Carpeta donde se guardará
    OUT p_codigo_salida VARCHAR(20),
    OUT p_nombre_archivo VARCHAR(300),
    OUT p_nombre_archivo_sin VARCHAR(300),
    OUT p_ruta VARCHAR(300)
)
BEGIN
    DECLARE fecha_actual VARCHAR(8);
    DECLARE aleatorio VARCHAR(16);
    DECLARE nombre_archivo VARCHAR(500);
    DECLARE nombre_archivo_sin_extension VARCHAR(500);
    
    -- Obtener fecha actual en formato YYYYMMDD
    SET fecha_actual = DATE_FORMAT(NOW(), '%Y%m%d');

    -- Generar string aleatorio (16 caracteres usando UUID)
    SET aleatorio = SUBSTRING(REPLACE(UUID(), '-', ''), 1, 16);

    -- Formar nombre final del archivo
    SET nombre_archivo = CONCAT(
        fecha_actual, '_', @codigo_generado, '_', p_tipo, '_', aleatorio, '.', p_extension
    );
    SET nombre_archivo_sin_extension = CONCAT(
        fecha_actual, '_', @codigo_generado, '_', p_tipo, '_', aleatorio
    );

    -- Insertar el nuevo registro
    INSERT INTO correctivo_archivo (
        codcorrectivo, nombre, nombreGuardado, ruta, extension, tipo, size, estado, fregistro, usercreate
    ) VALUES (
        p_codcorrectivo, nombre_archivo, nombre_archivo_sin_extension, CONCAT(p_ruta_base, '/', nombre_archivo),
        p_extension, p_tipo, p_size, p_estado, NOW(), p_usercreate
    );
    SET p_codigo_salida = @codigo_generado;
    
    -- Generar nombre del archivo utilizando el código generado
    SET nombre_archivo = CONCAT(
        fecha_actual, '_', p_codigo_salida, '_', p_tipo, '_', aleatorio, '.', p_extension
    );
    SET nombre_archivo_sin_extension = CONCAT(
        fecha_actual, '_', p_codigo_salida, '_', p_tipo, '_', aleatorio
    );

    -- Actualizar el registro insertado con los nombres generados y la ruta
    UPDATE correctivo_archivo
    SET nombre = nombre_archivo,
        nombreGuardado = nombre_archivo_sin_extension,
        ruta = CONCAT(p_ruta_base, '/', nombre_archivo)
    WHERE codigo = p_codigo_salida;

    -- Devolver el código generado
    -- Tiene que ser la misma que esta en OUT
    SET p_nombre_archivo = nombre_archivo;
    SET p_nombre_archivo_sin = nombre_archivo_sin_extension;
    SET p_ruta = CONCAT(p_ruta_base, '/', nombre_archivo);

    SELECT p_codigo_salida, p_nombre_archivo, p_nombre_archivo_sin, p_ruta;

END$$
DELIMITER ;
-- ==============================
-- Generar CREATE Actividad
-- ==============================
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_agregarCorrectivoActividad $$

CREATE PROCEDURE sp_agregarCorrectivoActividad (
    IN p_codcorrectivo VARCHAR(12),
    IN p_codpersonal VARCHAR(9),
    IN p_fecha_inicio DATE,
    -- IN p_fecha_fin DATE,
    IN p_hora_inicio TIME,
    IN p_hora_fin TIME,
    IN p_descripcion TEXT,
    IN p_estado VARCHAR(1),
    IN p_usercreate VARCHAR(100),
    OUT p_codigo_generado VARCHAR(12)
)
BEGIN
    -- Validaciones
    IF p_codcorrectivo IS NULL OR p_codcorrectivo = '' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El campo codcorrectivo es obligatorio';
    END IF;

    IF p_codpersonal IS NULL OR p_codpersonal = '' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El campo codpersonal es obligatorio';
    END IF;

    -- Insertar (trigger genera el código)
    INSERT INTO correctivo_actividad (
        codcorrectivo, codpersonal,
        fecha_inicio, hora_inicio, 
        hora_fin, descripcion, estado,
        fregistro, usercreate
    )
    VALUES (
        p_codcorrectivo, p_codpersonal,
        p_fecha_inicio, p_hora_inicio,
        p_hora_fin, p_descripcion, p_estado,
        NOW(), p_usercreate
    );

    -- Asignar el código generado del trigger a OUT
    SET p_codigo_generado = @codigo_generado;

    -- También puedes devolver el registro si lo deseas
    SELECT * FROM correctivo_actividad WHERE codigo = p_codigo_generado;
END $$
DELIMITER ;
-- ==============================
-- Generar DELETE Actividad
-- ==============================
DELIMITER $$

DROP PROCEDURE IF EXISTS sp_eliminarCorrectivoActividad $$

CREATE PROCEDURE sp_eliminarCorrectivoActividad (
    IN p_codigo VARCHAR(12),
    IN p_userupdate VARCHAR(100)
)
BEGIN
    -- Validación
    IF p_codigo IS NULL OR p_codigo = '' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El código es obligatorio para eliminar';
    END IF;

    -- Verifica existencia
    IF NOT EXISTS (SELECT 1 FROM correctivo_actividad WHERE codigo = p_codigo) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La actividad no existe';
    END IF;

    -- Actualizar estado a "eliminado"
    UPDATE correctivo_actividad
    SET estado = '0',
        userupdate = p_userupdate,
        fupdate = NOW()
    WHERE codigo = p_codigo;
END $$

DELIMITER ;
