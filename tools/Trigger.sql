-- 1) Tabla de secuencias (una fila por prefijo) 
CREATE TABLE IF NOT EXISTS sequences (
  name VARCHAR(50) PRIMARY KEY,
  curr BIGINT UNSIGNED NOT NULL
) ENGINE = InnoDB;
INSERT INTO sequences (name, curr)
VALUES ('CODCOR', 0) ON DUPLICATE KEY
UPDATE curr = curr;
-- 2
) Trigger que construye el codigo DROP TRIGGER IF EXISTS trg_correctivo_bi;
DELIMITER / / CREATE TRIGGER trg_correctivo_bi BEFORE
INSERT ON correctivo FOR EACH ROW BEGIN
DECLARE vNext BIGINT UNSIGNED;
/* Incremento atómico y recuperable con LAST_INSERT_ID() */
INSERT INTO sequences (name, curr)
VALUES ('CODCOR', 1) ON DUPLICATE KEY
UPDATE curr = LAST_INSERT_ID(curr + 1);
SET vNext = LAST_INSERT_ID();
SET NEW.codigo = CONCAT('CODCOR', LPAD(vNext, 6, '0'));
END / / DELIMITER;
- - 3
) Asegura unicidad (tu PK ya lo hace).Si cambiaras PK:
ALTER TABLE correctivo
ADD UNIQUE KEY uq_correctivo_codigo (codigo);
DELIMITER / / CREATE TRIGGER trg_equipo_bi BEFORE
INSERT ON equipo FOR EACH ROW BEGIN
DECLARE vNext BIGINT UNSIGNED;
/* Incremento seguro para 'CODEQUIPO' */
INSERT INTO sequences (name, curr)
VALUES ('CODEQUIPO', 1) ON DUPLICATE KEY
UPDATE curr = LAST_INSERT_ID(curr + 1);
SET vNext = LAST_INSERT_ID();
SET NEW.codigo = CONCAT('CODEQUIPO', LPAD(vNext, 6, '0'));
END;
/ / DELIMITER;
DELIMITER / / CREATE TRIGGER trg_marca_bi BEFORE
INSERT ON marca FOR EACH ROW BEGIN
DECLARE vNext BIGINT UNSIGNED;
/* Incremento seguro para 'CODMAR' */
INSERT INTO sequences (name, curr)
VALUES ('CODMAR', 1) ON DUPLICATE KEY
UPDATE curr = LAST_INSERT_ID(curr + 1);
SET vNext = LAST_INSERT_ID();
SET NEW.codigo = CONCAT('CODMAR', LPAD(vNext, 3, '0'));
END;
/ / DELIMITER;
DELIMITER / / CREATE TRIGGER trg_modelo_bi BEFORE
INSERT ON modelo FOR EACH ROW BEGIN
DECLARE vNext BIGINT UNSIGNED;
/* Incremento seguro para 'CODMOD' */
INSERT INTO sequences (name, curr)
VALUES ('CODMOD', 1) ON DUPLICATE KEY
UPDATE curr = LAST_INSERT_ID(curr + 1);
SET vNext = LAST_INSERT_ID();
SET NEW.codigo = CONCAT('CODMOD', LPAD(vNext, 3, '0'));
END;
/ / DELIMITER;
DELIMITER / / CREATE TRIGGER trg_categoria_bi BEFORE
INSERT ON categoria FOR EACH ROW BEGIN
DECLARE vNext BIGINT UNSIGNED;
/* Incremento seguro para 'CODCAT' */
INSERT INTO sequences (name, curr)
VALUES ('CODCAT', 1) ON DUPLICATE KEY
UPDATE curr = LAST_INSERT_ID(curr + 1);
SET vNext = LAST_INSERT_ID();
SET NEW.codigo = CONCAT('CODCAT', LPAD(vNext, 3, '0'));
END;
/ / DELIMITER;



DELIMITER $$

CREATE TRIGGER trg_correctivo_archivo_bi
BEFORE INSERT ON correctivo_archivo
FOR EACH ROW
BEGIN
    DECLARE vNext BIGINT UNSIGNED;

    -- Incremento seguro para 'CODARC'
    INSERT INTO sequences (name, curr)
    VALUES ('CODARC', 1)
    ON DUPLICATE KEY UPDATE curr = LAST_INSERT_ID(curr + 1);

    SET vNext = LAST_INSERT_ID();
    SET NEW.codigo = CONCAT('CODARC', LPAD(vNext, 6, '0'));

    -- Exponer el código generado a la sesión
    SET @codigo_generado = NEW.codigo;
END$$

DELIMITER ;

DELIMITER $$
CREATE TRIGGER `trg_correctivo_actividad_bi`
BEFORE INSERT ON `correctivo_actividad`
 FOR EACH ROW BEGIN
    DECLARE vNext BIGINT UNSIGNED;

    -- Incremento seguro para 'CODARC'
    INSERT INTO sequences (name, curr)
    VALUES ('CODCAC', 1)
    ON DUPLICATE KEY UPDATE curr = LAST_INSERT_ID(curr + 1);

    SET vNext = LAST_INSERT_ID();
    SET NEW.codigo = CONCAT('CODCAC', LPAD(vNext, 6, '0'));

    -- Exponer el código generado a la sesión
    SET @codigo_generado = NEW.codigo;
END$$

DELIMITER ;