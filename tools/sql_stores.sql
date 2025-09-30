-- Elimina el STORE si existe
DROP PROCEDURE IF EXISTS sp_agregarCorrectivoArchivo;

DELIMITER $$
-- Crea el STORE 
CREATE PROCEDURE sp_agregarCorrectivoArchivo (
    IN p_codcorrectivo VARCHAR(9),
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
    DECLARE ultimo_codigo VARCHAR(12);
    DECLARE nuevo_num INT;
    DECLARE nuevo_codigo VARCHAR(12);
    DECLARE fecha_actual VARCHAR(8);
    DECLARE aleatorio VARCHAR(16);
    DECLARE nombre_archivo VARCHAR(500);
    DECLARE nombre_archivo_sin_extension VARCHAR(500);
    
    -- Obtener el último código correlativo
    SELECT MAX(codigo) INTO ultimo_codigo
    FROM correctivo_archivo
    WHERE codigo LIKE 'CODARC%';

    -- Generar nuevo número correlativo
    IF ultimo_codigo IS NOT NULL THEN
        SET nuevo_num = CAST(SUBSTRING(ultimo_codigo, 7, 6) AS UNSIGNED) + 1;
    ELSE
        SET nuevo_num = 1;
    END IF;

    -- Formar nuevo código
    SET nuevo_codigo = CONCAT('CODARC', LPAD(nuevo_num, 6, '0'));

    -- Obtener fecha actual en formato YYYYMMDD
    SET fecha_actual = DATE_FORMAT(NOW(), '%Y%m%d');

    -- Generar string aleatorio (16 caracteres usando UUID)
    SET aleatorio = SUBSTRING(REPLACE(UUID(), '-', ''), 1, 16);

    -- Formar nombre final del archivo
    SET nombre_archivo = CONCAT(
        fecha_actual, '_', nuevo_codigo, '_', p_tipo, '_', aleatorio, '.', p_extension
    );
    SET nombre_archivo_sin_extension = CONCAT(
        fecha_actual, '_', nuevo_codigo, '_', p_tipo, '_', aleatorio
    );

    -- Insertar el nuevo registro
    INSERT INTO correctivo_archivo (
        codigo, codcorrectivo, nombre, nombreGuardado, ruta, extension, tipo, size, estado, fregistro, usercreate
    ) VALUES (
        nuevo_codigo, p_codcorrectivo, nombre_archivo, nombre_archivo_sin_extension, CONCAT(p_ruta_base, '/', nombre_archivo),
        p_extension, p_tipo, p_size, p_estado, NOW(), p_usercreate
    );

    -- Devolver el código generado
    -- Tiene que ser la misma que esta en OUT
    SET p_codigo_salida = nuevo_codigo;
    SET p_nombre_archivo = nombre_archivo;
    SET p_nombre_archivo_sin = nombre_archivo_sin_extension;
    SET p_ruta = CONCAT(p_ruta_base, '/', nombre_archivo);

    SELECT nuevo_codigo, p_nombre_archivo, p_nombre_archivo_sin, p_ruta;


DELIMITER ;


-- VERSION MEJORADA de CREAR CORRECTIVOS CON TRIGGERS
-- TRIGERS
-- 1) Tabla de secuencias (una fila por prefijo)
CREATE TABLE IF NOT EXISTS sequences (
  name VARCHAR(50) PRIMARY KEY,
  curr BIGINT UNSIGNED NOT NULL
) ENGINE=InnoDB;

INSERT INTO sequences (name, curr) VALUES ('CODCOR', 0)
  ON DUPLICATE KEY UPDATE curr = curr;

-- 2) Trigger que construye el codigo
DROP TRIGGER IF EXISTS trg_correctivo_bi;
DELIMITER //
CREATE TRIGGER trg_correctivo_bi
BEFORE INSERT ON correctivo
FOR EACH ROW
BEGIN
  DECLARE vNext BIGINT UNSIGNED;

  /* Incremento atómico y recuperable con LAST_INSERT_ID() */
  INSERT INTO sequences (name, curr) VALUES ('CODCOR', 1)
  ON DUPLICATE KEY UPDATE curr = LAST_INSERT_ID(curr + 1);

  SET vNext = LAST_INSERT_ID();
  SET NEW.codigo = CONCAT('CODCOR', LPAD(vNext, 6, '0'));
END//
DELIMITER ;

-- 3) Asegura unicidad (tu PK ya lo hace). Si cambiaras PK:
ALTER TABLE correctivo ADD UNIQUE KEY uq_correctivo_codigo (codigo);

-- SP PARA CORRECTIVOS INSERT
-- Elimina el STORE si existe
DROP PROCEDURE IF EXISTS sp_registrarManttoCorrectivo;

DELIMITER $$
CREATE PROCEDURE `sp_registrarManttoCorrectivo`(
  IN `v_FechaMantto`      DATETIME,
  IN `v_CodTurno`         VARCHAR(9),
  IN `v_CodSentido`       VARCHAR(9),
  IN `v_CodSistema`       VARCHAR(9),
  IN `v_CodTipoEquipo`    VARCHAR(9),
  IN `v_CodEquipo`        VARCHAR(10),
  IN `v_CodPersonal`      VARCHAR(50),
  IN `v_CodEstadoEquipo`  VARCHAR(9),
  IN `v_CodObservaciones` TEXT,
  IN `v_Estado`           VARCHAR(1),
  IN `v_User_Registro`    VARCHAR(100)
)
BEGIN
  /* NO poner 'codigo' en el INSERT: el trigger lo genera */
  INSERT INTO correctivo(
      fecha, codturno, codsentido, codsistema, codtequipo, codequipo,
      codestadoe, codpersonal, observaciones, estado, fregistro, usercreate
  ) VALUES (
      v_FechaMantto, v_CodTurno, v_CodSentido, v_CodSistema, v_CodTipoEquipo, v_CodEquipo,
      v_CodEstadoEquipo, v_CodPersonal, v_CodObservaciones, v_Estado, NOW(), v_User_Registro
  );

  /* El trigger incrementó la secuencia con LAST_INSERT_ID().
     Usamos ese valor para construir y devolver el código. */
  SELECT CONCAT('CODCOR', LPAD(LAST_INSERT_ID(), 6, '0')) AS codigo;
END$$
DELIMITER ;


-- as INICIA EL LISTAR ARCHIVOS

DROP PROCEDURE IF EXISTS sp_listarCorrectivoArchivos;

DELIMITER $$

CREATE PROCEDURE sp_listarCorrectivoArchivos(
    IN p_codcorrectivo VARCHAR(20),
    IN p_tipo VARCHAR(10)
)
BEGIN
    SELECT 
        codigo,
        codcorrectivo,
        nombre,
        nombreGuardado,
        ruta,
        extension,
        tipo,
        size,
        estado,
        fregistro,
        usercreate,
        frupdate,
        userupdate
    FROM correctivo_archivo
    WHERE codcorrectivo = p_codcorrectivo
      AND (p_tipo IS NULL OR tipo = p_tipo)
      AND estado = 1
    ORDER BY codigo DESC;
END$$
DELIMITER ;


// ELIMINACION de archivo, pero solo actualiza
DROP PROCEDURE IF EXISTS sp_eliminarCorrectivoArchivo;
DELIMITER $$

CREATE PROCEDURE sp_eliminarCorrectivoArchivo(
  IN p_CodCorrectivo VARCHAR(20),
  IN p_CodArchivo    VARCHAR(20),
  IN p_User    VARCHAR(100)
)
BEGIN
  /* Solo cambia si está activo (estado=1). Si ya está inactivo, no hace nada. */
  UPDATE correctivo_archivo
     SET estado     = 0,
         userupdate  = p_User,   -- quita si no tienes estas columnas
         frupdate = NOW()
   WHERE codcorrectivo = p_CodCorrectivo
     AND codigo        = p_CodArchivo
     AND estado        = 1;

  /* Devuelve filas afectadas para que la app sepa si hizo cambio (1) o no (0) */
  SELECT ROW_COUNT() AS filas_afectadas;
END$$

DELIMITER ;