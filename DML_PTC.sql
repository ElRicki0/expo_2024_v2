use db_quiropractica;

INSERT INTO tb_clientes (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, contrasenia_cliente, telefono_cliente, nacimiento_cliente, estado_cliente) 
VALUES 
('Alice', 'Johnson', '1234567890', 'alice.johnson@example.com', 'pass123', '123456789', '1990-05-15', 1),
('Bob', 'Smith', '2345678901', 'bob.smith@example.com', 'password456', '234567890', '1985-08-20', 1),
('Charlie', 'Williams', '3456789012', 'charlie.williams@example.com', 'abc123', '345678901', '1988-11-25', 1),
('David', 'Brown', '4567890123', 'david.brown@example.com', 'securepwd', '456789012', '1992-02-10', 1),
('Emily', 'Davis', '5678901234', 'emily.davis@example.com', 'davis456', '567890123', '1995-04-05', 1),
('Frank', 'Moore', '6789012345', 'frank.moore@example.com', 'pass456', '678901234', '1982-07-18', 1),
('Grace', 'Taylor', '7890123456', 'grace.taylor@example.com', 'taylorpass', '789012345', '1990-10-12', 1),
('Henry', 'Anderson', '8901234567', 'henry.anderson@example.com', 'anderson123', '890123456', '1987-03-29', 1),
('Ivy', 'Thomas', '9012345678', 'ivy.thomas@example.com', 'thomasivy', '901234567', '1998-06-17', 1),
('Jack', 'Roberts', '0123456789', 'jack.roberts@example.com', 'jack123', '012345678', '1993-09-22', 1);


INSERT INTO tb_testimonios (titulo_testimonio, contenido_testimonio, id_cliente, estado_testimonio) 
VALUES 
('Experiencia Positiva', '¡El servicio fue excelente y muy profesional!', 1, 1),
('Recomendación Destacada', 'Recomendaría esta empresa a todos mis amigos.', 2, 1),
('Comentario Satisfactorio', 'Estoy muy contento con los productos que adquirí.', 3, 1),
('Opinión Reconfortante', 'El equipo de atención al cliente fue muy atento.', 4, 1),
('Gran Calidad', 'Los productos superaron mis expectativas en calidad.', 5, 1),
('Servicio Impecable', 'La atención al cliente fue impecable y rápida.', 6, 1),
('Cliente Satisfecho', 'Definitivamente volveré a hacer negocios con ellos.', 7, 1),
('Experiencia Inolvidable', 'La experiencia de compra fue excelente de principio a fin.', 8, 1),
('Opinión Positiva', 'Recomendaría esta empresa a cualquier persona.', 9, 1),
('Comentario Aclamado', '¡La mejor empresa con la que he trabajado!', 10, 1);

INSERT INTO tb_empleado (nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, nacimiento_empleado, estado_empleado) 
VALUES 
('Juan', 'Perez', '0123456789', 'juan.perez@example.com', '1990-05-15', 1),
('Maria', 'Gonzalez', '9876543210', 'maria.gonzalez@example.com', '1985-09-20', 1),
('Carlos', 'Lopez', '4567890123', 'carlos.lopez@example.com', '1988-02-10', 1),
('Ana', 'Martinez', '7890123456', 'ana.martinez@example.com', '1992-11-30', 1),
('Pedro', 'Rodriguez', '3210987654', 'pedro.rodriguez@example.com', '1987-07-25', 1),
('Laura', 'Sanchez', '6543210987', 'laura.sanchez@example.com', '1995-03-05', 1),
('Luis', 'Hernandez', '2345678901', 'luis.hernandez@example.com', '1991-12-12', 1),
('Sofia', 'Diaz', '5678901234', 'sofia.diaz@example.com', '1989-08-18', 1),
('Jorge', 'Ramirez', '8901234567', 'jorge.ramirez@example.com', '1993-06-08', 1),
('Elena', 'Torres', '0987654321', 'elena.torres@example.com', '1994-04-17', 1);

INSERT INTO tb_fotos (nombre_foto, foto) 
VALUES 
('Foto 1', 'https://example.com/foto1.jpg'),
('Foto 2', 'https://example.com/foto2.jpg'),
('Foto 3', 'https://example.com/foto3.jpg'),
('Foto 4', 'https://example.com/foto4.jpg'),
('Foto 5', 'https://example.com/foto5.jpg'),
('Foto 6', 'https://example.com/foto6.jpg'),
('Foto 7', 'https://example.com/foto7.jpg'),
('Foto 8', 'https://example.com/foto8.jpg'),
('Foto 9', 'https://example.com/foto9.jpg'),
('Foto 10', 'https://example.com/foto10.jpg');

INSERT INTO tb_servicios (tipo_servicio, descripcion_servicio, id_foto) VALUES
('Service A', 'Description for Service A', 1),
('Service B', 'Description for Service B', 2),
('Service C', 'Description for Service C', 3),
('Service D', 'Description for Service D', 4),
('Service E', 'Description for Service E', 5),
('Service F', 'Description for Service F', 6),
('Service G', 'Description for Service G', 7),
('Service H', 'Description for Service H', 8),
('Service I', 'Description for Service I', 9),
('Service J', 'Description for Service J', 10);

INSERT INTO tb_beneficios (titulo_beneficio, contenido_beneficio, id_servicio) VALUES
('Benefit A', 'Benefit A description', 1),
('Benefit B', 'Benefit B description', 2),
('Benefit C', 'Benefit C description', 3),
('Benefit D', 'Benefit D description', 4),
('Benefit E', 'Benefit E description', 5),
('Benefit F', 'Benefit F description', 6),
('Benefit G', 'Benefit G description', 7),
('Benefit H', 'Benefit H description', 8),
('Benefit I', 'Benefit I description', 9),
('Benefit J', 'Benefit J description', 10);

INSERT INTO tb_preguntas (nombre_pregunta, contenido_pregunta, imagen_pregunta, id_cliente) 
VALUES 
('Pregunta 1', 'Contenido de la Pregunta 1', 'imagen1.jpg', 1),
('Pregunta 2', 'Contenido de la Pregunta 2', 'imagen2.jpg', 2),
('Pregunta 3', 'Contenido de la Pregunta 3', 'imagen3.jpg', 3),
('Pregunta 4', 'Contenido de la Pregunta 4', 'imagen4.jpg', 4),
('Pregunta 5', 'Contenido de la Pregunta 5', 'imagen5.jpg', 5),
('Pregunta 6', 'Contenido de la Pregunta 6', 'imagen6.jpg', 6),
('Pregunta 7', 'Contenido de la Pregunta 7', 'imagen7.jpg', 7),
('Pregunta 8', 'Contenido de la Pregunta 8', 'imagen8.jpg', 8),
('Pregunta 9', 'Contenido de la Pregunta 9', 'imagen9.jpg', 9),
('Pregunta 10', 'Contenido de la Pregunta 10', 'imagen10.jpg', 10);

INSERT INTO tb_citas (fecha_cita, estado_cita, numero_seciones, id_cliente, id_servicio, id_empleado) 
VALUES 
('2023-08-15 09:00:00', 1, 3, 1, 1, 1),
('2023-08-16 10:30:00', 1, 4, 2, 2, 2),
('2023-08-17 11:45:00', 1, 2, 3, 3, 3),
('2023-08-18 13:15:00', 1, 5, 4, 4, 4),
('2023-08-19 14:30:00', 1, 1, 5, 5, 5),
('2023-08-20 15:45:00', 1, 3, 6, 6, 6),
('2023-08-21 16:00:00', 1, 4, 7, 7, 7),
('2023-08-22 17:30:00', 1, 2, 8, 8, 8),
('2023-08-23 18:45:00', 1, 1, 9, 9, 9),
('2023-08-24 19:00:00', 1, 2, 10, 10, 10);

INSERT INTO tb_nombres_tratamientos (nombre_tratamiento, notas_adicionales, id_cita) 
VALUES 
('Tratamiento 1', 'Notas adicionales para Tratamiento 1', 1),
('Tratamiento 2', 'Notas adicionales para Tratamiento 2', 2),
('Tratamiento 3', 'Notas adicionales para Tratamiento 3', 3),
('Tratamiento 4', 'Notas adicionales para Tratamiento 4', 4),
('Tratamiento 5', 'Notas adicionales para Tratamiento 5', 5),
('Tratamiento 6', 'Notas adicionales para Tratamiento 6', 6),
('Tratamiento 7', 'Notas adicionales para Tratamiento 7', 7),
('Tratamiento 8', 'Notas adicionales para Tratamiento 8', 8),
('Tratamiento 9', 'Notas adicionales para Tratamiento 9', 9),
('Tratamiento 10', 'Notas adicionales para Tratamiento 10', 10);

INSERT INTO tb_comentarios (contenido_comentario, id_cliente, id_servicio, estado_comentario) 
VALUES 
('Excelente servicio.', 1, 1, 1),
('Muy satisfecho con el tratamiento.', 2, 2, 1),
('El personal fue muy amable.', 3, 3, 1),
('Recomendaría este lugar a mis amigos.', 4, 4, 1),
('Gran experiencia en general.', 5, 5, 1);