use db_quiropractica;
-- Inserciones para la tabla tb_clientes
INSERT INTO tb_clientes (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, contrasenia_cliente, fecha_contrasenia, telefono_cliente, nacimiento_cliente, estado_cliente, codigo_cliente, imagen_cliente)
VALUES
('Juan', 'Pérez', '12345678-9', 'juan.perez@gmail.com', 'hashed_password1', '2024-01-15', '789123456', '1985-05-12', 1, 'CL1234', 'juan.jpg'),
('Ana', 'González', '23456789-0', 'ana.gonzalez@gmail.com', 'hashed_password2', '2024-02-18', '789654123', '1990-07-23', 1, 'CL5678', 'ana.jpg');

-- Inserciones para la tabla tb_empleados
INSERT INTO tb_empleados (nombre_empleado, apellido_empleado, especialidad_empleado, dui_empleado, correo_empleado, nacimiento_empleado, estado_empleado, imagen_empleado)
VALUES
('Carlos', 'Ramírez', 'Quiropráctico', '34567890-1', 'carlos.ramirez@gmail.com', '1980-03-21', 1, 'carlos.jpg'),
('Lucía', 'Martínez', 'Fisioterapeuta', '45678901-2', 'lucia.martinez@gmail.com', '1978-09-15', 1, 'lucia.jpg');

-- Inserciones para la tabla tb_admin
INSERT INTO tb_admin (nombre_admin, correo_admin, contrasenia_admin, fecha_contrasenia, id_empleado, codigo_admin)
VALUES
('admin1', 'admin1@quiropractica.com', 'hashed_password_admin1', '2024-03-01', 1, 'ADM001'),
('admin2', 'admin2@quiropractica.com', 'hashed_password_admin2', '2024-04-01', 2, 'ADM002');

-- Inserciones para la tabla tb_imagenes
INSERT INTO tb_imagenes (nombre_imagen, imagen_1, imagen_2, imagen_3)
VALUES
('Servicio Quiropráctico', 'imagen1.jpg', 'imagen2.jpg', 'imagen3.jpg'),
('Terapia Física', 'imagen4.jpg', NULL, 'imagen5.jpg');

-- Inserciones para la tabla tb_servicios
INSERT INTO tb_servicios (tipo_servicio, descripcion_servicio, id_empleado, id_imagen)
VALUES
('Ajuste Quiropráctico', 'Ajustes vertebrales para mejorar el bienestar.', 1, 1),
('Terapia Física', 'Ejercicios y tratamientos para la rehabilitación.', 2, 2);

-- Inserciones para la tabla tb_beneficios
INSERT INTO tb_beneficios (titulo_beneficio, contenido_beneficio, id_servicio)
VALUES
('Mejora la movilidad', 'Aumenta la capacidad de movimiento de las articulaciones.', 1),
('Reducción del dolor', 'Ayuda a disminuir el dolor muscular y articular.', 2);

-- Inserciones para la tabla tb_preguntas
INSERT INTO tb_preguntas (nombre_pregunta, contenido_pregunta, id_empleado, id_imagen)
VALUES
('¿Qué es un ajuste quiropráctico?', 'Un ajuste quiropráctico es una técnica de manipulación de la columna vertebral.', 1, 1),
('¿Cuáles son los beneficios de la terapia física?', 'La terapia física ayuda a mejorar la fuerza y flexibilidad.', 2, 2);

-- Inserciones para la tabla tb_citas
INSERT INTO tb_citas (nombre_cita, fecha_creacion_cita, fecha_asignacion_cita, estado_cita, numero_seciones, id_cliente, id_servicio, id_empleado)
VALUES
('Cita Inicial', '2024-05-10 10:00:00', '2024-05-12 15:00:00', 'pendiente', 5, 1, 1, 1),
('Cita de Seguimiento', '2024-06-01 09:00:00', NULL, 'proceso', 3, 2, 2, 2);

-- Inserciones para la tabla tb_nombres_tratamientos
INSERT INTO tb_nombres_tratamientos (nombre_tratamiento, notas_adicionales, id_cita)
VALUES
('Tratamiento Espinal', 'Incluye técnicas de estiramiento.', 1),
('Rehabilitación Física', 'Ejercicios de fortalecimiento.', 2);

-- Inserciones para la tabla tb_comentarios
INSERT INTO tb_comentarios (contenido_comentario, id_cliente, id_servicio, estado_comentario)
VALUES
('Muy buen servicio, me siento mejor.', 1, 1, 1),
('El personal es muy amable y profesional.', 2, 2, 0);
