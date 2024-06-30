DROP DATABASE if EXISTS db_quiropractica;

CREATE DATABASE db_quiropractica;

USE db_quiropractica;

CREATE TABLE tb_clientes(
id_cliente int primary key auto_increment not null,
nombre_cliente VARCHAR (50) NOT NULL,
apellido_cliente VARCHAR (50) NOT NULL,
dui_cliente VARCHAR (10), 
correo_cliente VARCHAR (100) NOT NULL,
telefono_cliente VARCHAR (9) NOT NULL, 
nacimiento_cliente DATE NOT NULL,
responsable_cliente varchar(50)
); 
 
 CREATE TABLE tb_testimonios(
 id_testimonio	int primary key auto_increment not null,
 titulo_testimonio varchar(50) not null,
 contenido_testimonio	varchar(200)not null,
 id_cliente INT ,
FOREIGN KEY (id_cliente) REFERENCES tb_clientes (id_cliente)
 );
 
CREATE TABLE tb_empleado(
id_empleado INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
nombre_empleado VARCHAR (50) NOT NULL,
dui_empleado VARCHAR (10) NOT NULL, 
correo_empleado VARCHAR (100) NOT NULL,
telefono_empleado VARCHAR (9) NOT NULL,
nacimiento_empleado DATE NOT NULL,
estado_empleado	bool
); 

create table tb_admin(
id_usuario	int auto_increment key,
nombre_admin	varchar(50) unique not null,
contrasenia		varchar(500) not null,
foto_admin	varchar(200),
id_empleado INT ,
FOREIGN KEY (id_empleado) REFERENCES tb_empleado (id_empleado)
);

 CREATE TABLE tb_fotos (
id_foto INT PRIMARY KEY AUTO_INCREMENT NOT NULL, 
imagen VARCHAR (250) NOT NULL
);

CREATE TABLE tb_servicios(
id_servicio INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
tipo_servicio VARCHAR (45) NOT NULL,
descripcion_servicio VARCHAR (250) NOT NULL,
id_foto INT ,
FOREIGN KEY (id_foto) REFERENCES tb_fotos (id_foto)
);

CREATE TABLE tb_beneficios (
id_beneficio	int primary key auto_increment not null,
titulo_beneficio	varchar(30),
contenido_beneficio	varchar(200),
id_servicio INT ,
FOREIGN KEY (id_servicio) REFERENCES tb_servicios (id_servicio)
);

CREATE TABLE tb_preguntas(
id_pregunta INT  AUTO_INCREMENT PRIMARY KEY,
nombre_pregunta VARCHAR (250) NOT NULL,
contenido_pregunta VARCHAR (255) NOT NULL,
imagen_pregunta VARCHAR(100)NOT NULL,
id_cliente INT ,
FOREIGN KEY (id_cliente) REFERENCES tb_clientes (id_cliente)
);

CREATE TABLE tb_citas(
id_cita INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
fecha_cita datetime not null,
estado_cita	bool,
numero_seciones int,
id_cliente INT ,
FOREIGN KEY (id_cliente) REFERENCES tb_clientes (id_cliente), 
id_servicio int, 
FOREIGN KEY (id_servicio) REFERENCES tb_servicios (id_servicio),
id_empleado INT ,
FOREIGN KEY (id_empleado) REFERENCES tb_empleado (id_empleado)
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
id_cliente INT ,
FOREIGN KEY (id_cliente) REFERENCES tb_clientes (id_cliente)
);
