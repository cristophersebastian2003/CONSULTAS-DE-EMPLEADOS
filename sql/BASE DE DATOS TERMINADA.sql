CREATE DATABASE SENATI;
USE SENATI;
-- Crear tabla sede
CREATE TABLE sede (
    idsede 				INT PRIMARY KEY,
    sede 				VARCHAR(255) NOT NULL,
    create_at  			DATETIME	NOT NULL default now(),
    inactive_at 		DATETIME 	NULL,
    update_at   		DATETIME	NULL
);

-- Crear tabla empleados
CREATE TABLE empleados (
    idempleado 		INT AUTO_INCREMENT PRIMARY KEY,
    idsede 			INT,
    apellidos 		VARCHAR(255) NOT NULL,
    nombres 		VARCHAR(255) NOT NULL,
    nrodocumento 	VARCHAR(8) NOT NULL,
    fechanac 		DATE NOT NULL,
    telefono 		VARCHAR(20),
    create_at  			DATETIME	NOT NULL default now(),
    inactive_at 		DATETIME 	NULL,
    update_at   		DATETIME	NULL,
    FOREIGN KEY (idsede) REFERENCES sede(idsede)
);

DELIMITER //

CREATE PROCEDURE spu_empleados_listar()
BEGIN
    SELECT * FROM empleados;
END //

DELIMITER ;


DELIMITER //

CREATE PROCEDURE spu_empleados_registrar(
    in_idempleado 		INT,
    in_idsede 			INT,
    in_apellidos 		VARCHAR(255),
    in_nombres 			VARCHAR(255),
    in_nrodocumento 	VARCHAR(8),
    in_fechanac 		DATE,
    in_telefono 		VARCHAR(20)
)
BEGIN
    INSERT INTO empleados (idempleado, idsede, apellidos, nombres, nrodocumento, fechanac, telefono)
    VALUES (in_idempleado, in_idsede, in_apellidos, in_nombres, in_nrodocumento, in_fechanac, in_telefono);
END //

DELIMITER ;


DELIMITER //

CREATE PROCEDURE spu_empleados_buscar(in_idempleado INT)
BEGIN
    SELECT * FROM empleados WHERE idempleado = in_idempleado;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE spu_sedes_listar()
BEGIN
    SELECT * FROM sede;
END //

DELIMITER ;


-- Insertar 4 sedes
INSERT INTO sede (idsede, sede) VALUES
    (1, 'Sede Lima'),
    (2, 'Sede Chincha'),
    (3, 'Sede Libertad'),
    (4, 'Sede Grocio Prado');

-- Insertar 10 empleados con nombres al azar
INSERT INTO empleados (idempleado, idsede, apellidos, nombres, nrodocumento, fechanac, telefono) VALUES
    (1, 1, 'Lopez', 'Juan', '12345678', '1990-05-15', '123456789'),
    (2, 2, 'Gomez', 'Maria', '98765432', '1985-08-22', '987654321'),
    (3, 3, 'Rodriguez', 'Carlos', '56789012', '1992-11-10', '567890123'),
    (4, 1, 'Martinez', 'Laura', '34567890', '1988-04-02', '345678901'),
    (5, 4, 'Gutierrez', 'Pedro', '87654321', '1995-07-18', '876543210'),
    (6, 2, 'Perez', 'Ana', '23456789', '1991-02-25', '234567890'),
    (7, 3, 'Diaz', 'Javier', '65432109', '1987-09-14', '654321098'),
    (8, 4, 'Sanchez', 'Silvia', '89012345', '1993-12-07', '890123456'),
    (9, 1, 'Ramirez', 'Diego', '43210987', '1986-06-30', '432109876'),
    (10, 2, 'Fernandez', 'Elena', '21098765', '1994-03-05', '210987654');


CALL spu_empleados_listar();
CALL spu_empleados_registrar(
    11, 
    3, 
    'Gonzalez', 
    'Roberto', 
    '54321098', 
    '1998-09-20', 
    '555555555' 
);
CALL spu_empleados_buscar('12'); 
CALL spu_sedes_listar();

DELIMITER //

CREATE PROCEDURE spu_empleados_obtener_por_documento(IN p_nrodocumento VARCHAR(8))
BEGIN
    SELECT idsede, nombres, apellidos, nrodocumento, fechanac, telefono
    FROM empleados
    WHERE nrodocumento = p_nrodocumento;
END //

DELIMITER ;


CALL spu_empleados_obtener_por_documento('12345678')