use db_quiropractica;

INSERT INTO tb_clientes (nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, contrasenia_cliente, telefono_cliente, nacimiento_cliente, estado_cliente, codigo_cliente) 
VALUES 
('Bob', 'Smith', '2345678901', 'bob.smith@example.com', 'password456', '234567890', '1985-08-20', 1, '111111'),
('Charlie', 'Williams', '3456789012', 'charlie.williams@example.com', 'abc123', '345678901', '1988-11-25', 1, '111112'),
('David', 'Brown', '4567890123', 'david.brown@example.com', 'securepwd', '456789012', '1992-02-10', 1, '111113'),
('Emily', 'Davis', '5678901234', 'emily.davis@example.com', 'davis456', '567890123', '1995-04-05', 1, '111114'),
('Frank', 'Moore', '6789012345', 'frank.moore@example.com', 'pass456', '678901234', '1982-07-18', 1, '111115'),
('Grace', 'Taylor', '7890123456', 'grace.taylor@example.com', 'taylorpass', '789012345', '1990-10-12', 1, '111116'),
('Henry', 'Anderson', '8901234567', 'henry.anderson@example.com', 'anderson123', '890123456', '1987-03-29', 1, '111117'),
('Ivy', 'Thomas', '9012345678', 'ivy.thomas@example.com', 'thomasivy', '901234567', '1998-06-17', 1, '111118'),
('Jack', 'Roberts', '0123456789', 'jack.roberts@example.com', 'jack123', '012345678', '1993-09-22', 1, '111119');


-- INSERT INTO tb_testimonios (titulo_testimonio, contenido_testimonio, id_cliente, estado_testimonio) 
-- VALUES 
-- ('Experiencia Positiva', '¡El servicio fue excelente y muy profesional!', 1, 1),
-- ('Recomendación Destacada', 'Recomendaría esta empresa a todos mis amigos.', 2, 1),
-- ('Comentario Satisfactorio', 'Estoy muy contento con los productos que adquirí.', 3, 1),
-- ('Opinión Reconfortante', 'El equipo de atención al cliente fue muy atento.', 4, 1),
-- ('Gran Calidad', 'Los productos superaron mis expectativas en calidad.', 5, 1),
-- ('Servicio Impecable', 'La atención al cliente fue impecable y rápida.', 6, 1),
-- ('Cliente Satisfecho', 'Definitivamente volveré a hacer negocios con ellos.', 7, 1),
-- ('Experiencia Inolvidable', 'La experiencia de compra fue excelente de principio a fin.', 8, 1),
-- ('Opinión Positiva', 'Recomendaría esta empresa a cualquier persona.', 9, 1),
-- ('Comentario Aclamado', '¡La mejor empresa con la que he trabajado!', 10, 1);

INSERT INTO tb_empleados (nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, nacimiento_empleado, estado_empleado) 
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

 
INSERT INTO tb_servicios (tipo_servicio, descripcion_servicio, imagen_servicio) 
VALUES 
('Quiropráctica General', 'Servicio de quiropráctica para el cuidado de la salud de la columna vertebral', '668d57610556f.png'),
('Masaje Terapéutico', 'Masaje especializado para aliviar dolores musculares y tensiones', '668d57610556f.png'),
('Yoga y Meditación', 'Clases de yoga y meditación para el equilibrio cuerpo-mente', '668d57610556f.png'),
('Rehabilitación Física', 'Programa de rehabilitación física para lesiones y recuperación post-operatoria', '668d57610556f.png'),
('Nutrición Personalizada', 'Asesoramiento nutricional personalizado para una alimentación saludable', '668d57610556f.png');


INSERT INTO tb_beneficios (titulo_beneficio, contenido_beneficio, id_servicio) 
VALUES 
('Descuento Especial', 'Obtén un 10% de descuento en tu primera sesión de quiropráctica', 1),
('Consulta Gratuita', 'Recibe una consulta gratuita de evaluación para nuevos clientes', 2),
('Paquetes Promocionales', 'Descubre nuestros paquetes promocionales para tratamientos completos', 3),
('Atención Personalizada', 'Brindamos atención personalizada según tus necesidades y objetivos', 4),
('Programas de Bienestar', 'Descubre nuestros programas de bienestar integral para una vida saludable', 5);


INSERT INTO tb_preguntas (nombre_pregunta, contenido_pregunta, imagen_pregunta, id_empleado) 
VALUES 
('Pregunta 1', 'Contenido de la Pregunta 1', 'pregunta.jpg', 1),
('Pregunta 2', 'Contenido de la Pregunta 2', 'pregunta.jpg', 2),
('Pregunta 3', 'Contenido de la Pregunta 3', 'pregunta.jpg', 3),
('Pregunta 4', 'Contenido de la Pregunta 4', 'pregunta.jpg', 4),
('Pregunta 5', 'Contenido de la Pregunta 5', 'pregunta.jpg', 5);

INSERT INTO tb_citas (id_cliente, id_servicio) 
VALUES 
    (1, 2),
    (1, 1),
    (1, 3),
    (1, 1),
    (1, 2);

INSERT INTO tb_nombres_tratamientos (nombre_tratamiento, notas_adicionales, id_cita) 
VALUES 
('Tratamiento 1', 'Notas adicionales para Tratamiento 1', 1),
('Tratamiento 2', 'Notas adicionales para Tratamiento 2', 2),
('Tratamiento 3', 'Notas adicionales para Tratamiento 3', 3),
('Tratamiento 4', 'Notas adicionales para Tratamiento 4', 4),
('Tratamiento 5', 'Notas adicionales para Tratamiento 5', 5);

INSERT INTO tb_comentarios (contenido_comentario, id_cliente, id_servicio, estado_comentario) 
VALUES 
('Excelente servicio.', 1, 1, 1),
('Muy satisfecho con el tratamiento.', 2, 2, 1),
('El personal fue muy amable.', 3, 3, 1),
('Recomendaría este lugar a mis amigos.', 4, 4, 1),
('Gran experiencia en general.', 5, 5, 1);


INSERT INTO tb_citas (id_cliente, id_servicio, fecha_asignacion_cita, estado_cita, numero_seciones) 
VALUES 
    (1, 1, '2024-08-21 10:00:00', 'pendiente', 2),  -- Quiropráctica General
    (2, 2, '2024-08-22 11:00:00', 'pendiente', 1),  -- Masaje Terapéutico
    (3, 3, '2024-08-23 14:00:00', 'pendiente', 3),  -- Yoga y Meditación
    (4, 4, '2024-08-24 15:00:00', 'pendiente', 1),  -- Rehabilitación Física
    (5, 5, '2024-08-25 16:00:00', 'pendiente', 2),  -- Nutrición Personalizada
    (1, 2, '2024-08-26 09:00:00', 'pendiente', 1),  -- Masaje Terapéutico
    (2, 3, '2024-08-27 10:30:00', 'pendiente', 2),  -- Yoga y Meditación
    (3, 4, '2024-08-28 12:00:00', 'pendiente', 3),  -- Rehabilitación Física
    (4, 5, '2024-08-29 13:00:00', 'pendiente', 2),  -- Nutrición Personalizada
    (5, 1, '2024-08-30 14:30:00', 'pendiente', 1);  -- Quiropráctica General
