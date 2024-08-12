DROP DATABASE if EXISTS db_quiropractica;

CREATE DATABASE db_quiropractica;

USE db_quiropractica;

CREATE TABLE tb_clientes(
    id_cliente INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombre_cliente VARCHAR (50) NOT NULL unique,
    apellido_cliente VARCHAR (50) NOT NULL unique,
    dui_cliente VARCHAR (10) unique,
    correo_cliente VARCHAR (100) NOT NULL,
    contrasenia_cliente VARCHAR(200) not null,
    telefono_cliente VARCHAR (9) NOT NULL,
    nacimiento_cliente DATE NOT NULL,
    estado_cliente tinyint(1) NOT NULL DEFAULT 1
);

-- proximamente
-- CREATE TABLE tb_testimonios(
-- id_testimonio INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
-- titulo_testimonio VARCHAR(50) NOT NULL,
-- contenido_testimonio VARCHAR(200)NOT NULL,
-- id_cliente INT ,
-- estado_testimonio tinyint(1) NOT NULL,
-- FOREIGN KEY (id_cliente) REFERENCES tb_clientes (id_cliente)
-- );
CREATE TABLE tb_empleados(
    id_empleado INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombre_empleado VARCHAR (50) NOT NULL unique,
    apellido_empleado VARCHAR (50) NOT NULL unique,
    dui_empleado VARCHAR (10) NOT NULL unique,
    correo_empleado VARCHAR (100) NOT NULL unique,
    nacimiento_empleado DATE NOT NULL,
    estado_empleado TINYINT(1) NOT NULL
);

CREATE TABLE tb_admin(
    id_admin INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombre_admin VARCHAR(50) UNIQUE NOT NULL,
    correo_admin VARCHAR (100) unique NOT NULL,
    contraseña_admin VARCHAR(500) NOT NULL,
    id_empleado INT,
    FOREIGN KEY (id_empleado) REFERENCES tb_empleados (id_empleado)
);

-- CREATE TABLE tb_fotos (
-- id_foto INT PRIMARY KEY AUTO_INCREMENT NOT NULL, 
-- nombre_foto VARCHAR (100) not null,
-- foto VARCHAR (250) NOT NULL
-- );
CREATE TABLE tb_servicios(
    id_servicio INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    tipo_servicio VARCHAR (45) NOT NULL unique,
    descripcion_servicio VARCHAR (250) NOT NULL,
    imagen_servicio varchar(300) -- id_foto INT ,
    -- FOREIGN KEY (id_foto) REFERENCES tb_fotos (id_foto)
);

CREATE TABLE tb_beneficios (
    id_beneficio INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    titulo_beneficio VARCHAR(30) unique,
    contenido_beneficio VARCHAR(200),
    id_servicio INT,
    FOREIGN KEY (id_servicio) REFERENCES tb_servicios (id_servicio)
);

CREATE TABLE tb_preguntas(
    id_pregunta INT AUTO_INCREMENT PRIMARY KEY,
    nombre_pregunta VARCHAR (250) NOT NULL unique,
    contenido_pregunta VARCHAR (255) NOT NULL,
    imagen_pregunta VARCHAR(100) NOT NULL,
    id_cliente INT,
    FOREIGN KEY (id_cliente) REFERENCES tb_clientes (id_cliente)
);

CREATE TABLE tb_citas(
    id_cita INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombre_cita VARCHAR(100) DEFAULT 'cita predeterminada',
    fecha_creacion_cita DATETIME NOT NULL DEFAULT current_timestamp(),
    fecha_asignacion_cita DATETIME NULL,
    estado_cita ENUM('pendiente', 'proceso', 'terminado') NOT NULL DEFAULT 'pendiente',
    numero_seciones INT,
    id_cliente INT,
    FOREIGN KEY (id_cliente) REFERENCES tb_clientes (id_cliente),
    id_servicio INT,
    FOREIGN KEY (id_servicio) REFERENCES tb_servicios (id_servicio),
    id_empleado INT NULL,
    FOREIGN KEY (id_empleado) REFERENCES tb_empleados (id_empleado)
);

CREATE TABLE tb_nombres_tratamientos (
    id_tratamiento INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    nombre_tratamiento VARCHAR (75) NOT NULL,
    notas_adicionales VARCHAR (250),
    id_cita INT,
    FOREIGN KEY (id_cita) REFERENCES tb_citas(id_cita)
);

CREATE TABLE tb_comentarios(
    id_comentario INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    contenido_comentario VARCHAR (250) NOT NULL,
    id_cliente INT,
    FOREIGN KEY (id_cliente) REFERENCES tb_clientes (id_cliente),
    id_servicio INT,
    FOREIGN KEY (id_servicio) REFERENCES tb_servicios (id_servicio),
    estado_comentario tinyint(1) NOT NULL
);