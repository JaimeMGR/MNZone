-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-06-2025 a las 20:53:15
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mnzone_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `caracteristicas` varchar(1000) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `nombre`, `caracteristicas`, `foto`) VALUES
(1, 'PC Gamer', 'Caja: Tempest Mirage RGB Mesh Torre ATX Negra<br>\nFuente de alimentación: Forgeon SI Series PSU 650W 80+ Bronze<br>\nProcesador: Intel Core i5-12400F 2.5 GHz<br>\nPlaca base: Gigabyte B760M DS3H DDR4<br>\nDisco duro: WD Blue SN580 1TB SSD M.2 PCIe 4.0 NVMe<br>\nMemoria RAM: Kingston FURY Beast DDR4 3200 MHz 32GB 2x16GB CL16<br>\nTarjeta gráfica: GeForce RTX 4060 WINDFORCE 8GB GDDR6 DLSS3<br>\nTarjeta de sonido: Integrada<br>\nRefrigeración CPU: Tempest Cooler 4Pipes 120mm RGB Ventilador CPU Negro<br>\nTarjeta de Red: ASUS PCE-AX1800 Adaptador PCIe AX1800 WiFi 6 + Bluetooth 5.2', 'pc.webp'),
(2, 'Simulador racing', 'Volante + pedales: Logitech G29  Driving Force<br>Palanca de cambios: Logitech Driving Force Shifter', 'conjunto_volante.webp'),
(4, 'Play Station 5', 'La PlayStation 5 (PS5) es la última consola de videojuegos de sobremesa de Sony Interactive Entertainment. Ofrece una experiencia de juego más inmersiva y rápida gracias a su SSD de velocidad ultrarrápida, retroalimentación háptica, gatillos adaptativos y audio 3D. Además, cuenta con gráficos espectaculares y compatibilidad con una amplia gama de juegos, tanto de PS5 como de generaciones anteriores. ', 'play5.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes_contacto`
--

CREATE TABLE `mensajes_contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id_noticia` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id_noticia`, `titulo`, `contenido`, `imagen`, `fecha_publicacion`) VALUES
(27, 'GTA 6 no debería tener nuevo tráiler antes de su lanzamiento y un ex de Rockstar explica por qué', 'Obbe Vermeij, exdirector técnico en el estudio, da su opinión sobre la campaña de marketing de Grand Theft Auto VI y la decisión que él tomaría para aumentar más el hype del sandbox.Sí, estamos a punto de llegar a mayo de 2025 y aún no tenemos nueva información sobre Grand Theft Auto VI, el que es sin duda el juego más esperado del año del que, por ahora, solo tenemos un primer tráiler y la reconfirmación de Take Two de que llegará en otoño del 2025. Mientras la ausencia de información tiene como locos a los aficionados hay gente de la industria apuntando a que Take Two ha cambiado el enfoque de su estrategia de marketing e incluso un ex de Rockstar ha salido a la palestra para asegurar que, si él tuviese que tomar la decisión, no publicaría ningún tráiler más del juego hasta el lanzamiento para aumentar la expectación del juego.', 'grand-theft-auto-vi-20231251505956_1.jpg.webp', '2025-04-29'),
(32, 'Esta PS5 parece una PS2, pero no es oficial: Modifica la consola de Sony con un espectacular aspecto retro', 'Un usuario ha personalizado el aspecto de su PlayStation 5 utilizando cubiertas no oficiales y otras modificaciones para que se parezca a la PlayStation 2 estándar.   PlayStation 2 es la consola más vendida de la historia con más de 160 millones de unidades distribuidas en todo el mundo, por lo que no es de extrañar que haya videojugadores que recuerdan con cariño la segunda consola de sobremesa de Sony. Ese es el caso de un usuario que ha mostrado en Reddit su PlayStation 5 modificada al estilo de PS2, un trabajo que recuerda al que la empresa japonesa hizo para conmemorar el 30 aniversario de la marca PlayStation.  En el subreddit dedicado a las videoconsolas, los juegos y todo lo relacionado con los productos de Sony Interactive Entertainment, el usuario \"Gokeez\" enseña un par de fotografías de su PlayStation 5 al lado de una PS2, el modelo original lanzado en el 2000, también conocido extraoficialmente como \"PS2 FAT\".La PS5 (el modelo estrenado en 2020 con lector de discos Blu-ray) es de un color negro mate casi idéntico al de PS2, también en la franja de plástico negro que recorre el centro de la consola; dicho plástico es reflectante en una PlayStation 5 sin modificar. En esa zona aparece el logo de Sony de la misma manera en la que se mostraba en PS2, así como el icono clásico de PlayStation (con los colores rojo, azul y amarillo), que el usuario ha extraído de un DualSense del 30º Aniversario de la marca.  Las cubiertas utilizadas no son oficiales, sino de la marca DBrand: el círculo que deja a la vista el ventilador no es una modificación del usuario. En dicha cubierta ha replicado la tipografía de PS2, aquella de bordes pronunciados y con una gama de azules, para poner: \"PS5\". También ha modificado un DualSense para que sea de color negro reflectante y para que los botones frontales tengan colores (el triángulo verde, la cruz azul, etcétera).', 'i-customized-my-ps5-to-look-like-a-ps2-v0-rlinmknt2v1f1.webp', '2025-06-15'),
(33, 'Recuerda a los Resident Evil clásicos y ya puedes probarlo gratis en Steam: Así es PHASE ZERO', 'Si recuerdas con nostalgia los primeros Resident Evil, esto te interesa, porque la desarrolladora independiente SPINE ha lanzado una demostración jugable de su próximo proyecto: un survival horror que recuerda a los clásicos de Capcom de los años 90. Se trata de PHASE ZERO, con dinámicas de juego old-school y un apartado gráfico que nos trae las sensaciones de la era de los 32 bits.  PHASE ZERO se basa en los ángulos de cámara fijos tan habituales por aquel entonces en este género, además los entornos prerrenderizados y un control muy característico, con el uso de objetos, una exploración laberíntica y la resolución de algunos puzles. Tiene todo eso que tanto nos gustó de otros videojuegos tan conocidos e importantes como Dino Crisis o Parasite Eve.', '202561016254726_1.jpg.webp', '2025-06-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `compania` varchar(100) NOT NULL,
  `imagen` varchar(500) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria` enum('Comida','Bebida','Sala_principal','Sala_VIP','Play_Station_5','Simulador_coches','Sala_VR') NOT NULL DEFAULT 'Sala_principal',
  `duracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `compania`, `imagen`, `precio`, `categoria`, `duracion`) VALUES
(143, '1 hora - Sala Principal', 'MNZone', 'productos/c71b25040ec3cadbe0f6d03b4bafba43.jpg', 3.00, 'Sala_principal', 3600),
(145, '2 horas - Sala Principal', 'MNZone', 'productos/07a5ba631de31489d245417607ed6c01.jpg', 5.00, 'Sala_principal', 7200),
(157, '5 horas - Sala Principal', 'MNZone', 'productos/4cc32e36853445cb3744591996bade9a.jpg', 10.00, 'Sala_principal', 18000),
(158, '12 horas - Sala Principal', 'MNZone', 'productos/86e9736efb0bedd65dfaef8045158d59.jpg', 20.00, 'Sala_principal', 43200),
(159, '24 horas - Sala Principal', 'MNZone', 'productos/de092c629b707879053336d471840983.jpg', 40.00, 'Sala_principal', 86400),
(160, '1 hora - Sala VIP', 'MNZone', 'productos/0c3a8897ba29f5c1555e4f9a3b54c017.jpg', 5.00, 'Sala_VIP', 3600),
(161, '2 horas - Sala VIP', 'MNZone', 'productos/5c64482565632fc384d3d868efe2f1c1.jpg', 8.00, 'Sala_VIP', 7200),
(162, '5 horas - Sala VIP', 'MNZone', 'productos/6ffbb474399cf704c2baab4e706b000c.jpg', 15.00, 'Sala_VIP', 18000),
(163, '12 horas - Sala VIP', 'MNZone', 'productos/03bc57cf7615024f45e215fffe369961.jpg', 30.00, 'Sala_VIP', 43200),
(164, '24 horas - Sala VIP', 'MNZone', 'productos/fdae6bb377d358cbac6ffe15d99279cf.jpg', 60.00, 'Sala_VIP', 86400),
(166, '1 hora - PS5', 'MNZone', 'productos/5e4b755d1220815faced308cfd1b1089.jpg', 3.00, 'Play_Station_5', 3600),
(167, '2 horas - PS5', 'MNZone', 'productos/8d6a814a9193023d219745130d755ef8.jpg', 5.00, 'Play_Station_5', 7200),
(168, '5 horas - PS5', 'MNZone', 'productos/13604bcfddd4b2e4a523906f4f4224ff.jpg', 10.00, 'Play_Station_5', 18000),
(169, '12 horas - PS5', 'MNZone', 'productos/0fa0d8a08a8f60350c0cef0c6fc4da34.jpg', 20.00, 'Play_Station_5', 43200),
(170, '24 horas - PS5', 'MNZone', 'productos/75fed8b77a4fa882d7297e2eb863b592.jpg', 40.00, 'Play_Station_5', 86400),
(171, '1 hora - Volante', 'MNZone', 'productos/4631b316c7ff48208578e956c03588a4.jpg', 3.00, 'Simulador_coches', 3600),
(172, '2 horas - Volante', 'MNZone', 'productos/f3c2e209d069a2e7c5460a395220548c.jpg', 5.00, 'Simulador_coches', 7200),
(173, '5 horas - Volante', 'MNZone', 'productos/fb76e81d07c708937b804bf871e02fee.jpg', 10.00, 'Simulador_coches', 18000),
(174, '12 horas - Volante', 'MNZone', 'productos/2b60875c4c51d9c5738927d9af125375.jpg', 20.00, 'Simulador_coches', 43200),
(175, '24 horas - Volante', 'MNZone', 'productos/1fbfbe18140c7f60fde8d2f2f1c906c4.jpg', 40.00, 'Simulador_coches', 86400),
(176, 'Monster Energy Zero', 'Monster', 'productos/1899bf9f546964939cd4c1c0be0b21a7.jpg', 2.00, 'Bebida', 0),
(177, 'Monster mango loco', 'Monster', 'productos/0e56135f7a09b53654451ed1a0885ac8.jpg', 2.00, 'Bebida', 0),
(178, 'Monster ultra white', 'monster', 'productos/e5e5ca003d79194b1382570530cc94b3.jpg', 2.00, 'Bebida', 0),
(179, 'Monster ultra strawberry dreams', 'Monster', 'productos/3f928282f799602d6e974aa0129614e8.jpg', 2.00, 'Bebida', 0),
(180, 'Eneryeti sabor coco', 'Eneryeti', 'productos/88882b41565a43250faf9abfda576514.jpg', 2.00, 'Bebida', 0),
(181, 'Cheetos Pandilla', 'Cheetos', 'productos/dd3448e8e938aba479861577eedb9a42.jpg', 2.00, 'Comida', 0),
(182, 'Ruffles sabor a jamón', 'Ruffles', 'productos/94da1aa8438f00ac0acc81ea717b3d33.jpg', 2.00, 'Comida', 0),
(183, 'Ruffles sabor a jamón y queso', 'Ruffles', 'productos/d43d7c35d2a4ca652be13f4e8abe9750.jpg', 2.00, 'Comida', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros_uso`
--

CREATE TABLE `registros_uso` (
  `id` int(11) NOT NULL,
  `id_socio` int(11) NOT NULL,
  `categoria` varchar(20) NOT NULL,
  `inicio` datetime NOT NULL,
  `fin` datetime NOT NULL,
  `segundos_utilizados` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registros_uso`
--

INSERT INTO `registros_uso` (`id`, `id_socio`, `categoria`, `inicio`, `fin`, `segundos_utilizados`) VALUES
(2, 46, 'Sala_principal', '2025-05-22 19:17:45', '2025-05-22 19:17:58', 11),
(3, 46, 'Sala_principal', '2025-06-12 16:56:25', '2025-06-12 16:56:29', 2),
(4, 46, 'Sala_principal', '2025-06-14 00:36:33', '2025-06-14 00:36:37', 2),
(5, 46, 'Sala_principal', '2025-06-14 15:09:25', '2025-06-14 15:10:42', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `codigo_socio` int(11) DEFAULT NULL,
  `codigo_servicio` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `codigo_socio`, `codigo_servicio`, `fecha`, `hora`, `estado`) VALUES
(73, 46, 2, '2025-05-15', '19:50:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `codigo_servicio` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`codigo_servicio`, `nombre`, `descripcion`, `imagen`) VALUES
(1, 'Sala principal', 'Nuestra sala principal está equipada con potentes ordenadores gaming, periféricos de alta gama y conexión de alta velocidad. Ideal para jugar en grupo, participar en torneos o simplemente disfrutar de tus videojuegos favoritos con la mejor experiencia.\n\n', '../../imagenes/Salaciber.webp'),
(2, 'PS5', 'Disfruta de la última generación de consolas con nuestra zona exclusiva de PS5. Vive una experiencia envolvente con títulos de alto nivel gráfico, mandos DualSense y pantallas de gran tamaño. ¡Perfecto para jugar solo o en compañía!\n\n', '../../imagenes/juegos-ps5.webp'),
(3, 'Volante', '¿Te apasiona la velocidad? Ponte al volante con nuestro simulador de carreras profesional. Volante con retroalimentación, pedales y asiento ergonómico para una experiencia de conducción ultra realista. Ideal para los fanáticos del automovilismo.\n\n', '../../imagenes/Racing.webp'),
(4, 'Sala VIP', 'Un espacio exclusivo con iluminación LED, equipos de alto rendimiento y ambiente más privado. Perfecta para gamers exigentes, equipos competitivos o sesiones de juego sin interrupciones.\n\n', '../../imagenes/Sala-vip.webp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `id_socio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `contrasena` varchar(255) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tipo` enum('socio','admin') NOT NULL DEFAULT 'socio'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`id_socio`, `nombre`, `edad`, `contrasena`, `usuario`, `telefono`, `foto`, `tipo`) VALUES
(0, 'Administrador', 22, '$2y$10$ARmorzzYJD1t3NMdqGBm1.IEtSHnZ6NFnNDcL2H2UEg8G9QrG1la2', 'Admin', '+34668533704', '453348409_695213336114147_1710011270050425164_n.jpeg', 'admin'),
(46, 'Jaime Molina Granados', 22, '$2y$10$HiY.jLECSmgRhtv2DNMkPuKar7bMmJSHDGwHFvX6lIu77fTk9J/am', 'JaimeMGR', '+34666777888', 'jaime.jpg', 'socio'),
(51, 'Carmelo Molina Granados', 25, '$2y$10$LQ04.PgRZF4mWI0B4wD/PuCnsoLU.3S7F5WU4PfLi0mSZd7Q7n.F2', 'CarmeloMGR', '+34785432612', '1750012673_Goku.jpg', 'socio'),
(52, 'Alex Arrabal Cano', 21, '$2y$10$zrwsdvjdjZCK0plGYLVGb.mQWeWICNfcwJDwd888FgCa03mGN.W3K', 'AlexGinger0', '+34827364098', '1750013471_4.jpg', 'socio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonio`
--

CREATE TABLE `testimonio` (
  `id_testimonio` int(11) NOT NULL,
  `autor` int(11) DEFAULT NULL,
  `contenido` text NOT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `testimonio`
--

INSERT INTO `testimonio` (`id_testimonio`, `autor`, `contenido`, `fecha`) VALUES
(52, 46, 'Muy contento con el servicio', '2025-06-13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempos_sala`
--

CREATE TABLE `tiempos_sala` (
  `id` int(11) NOT NULL,
  `id_socio` int(11) NOT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `categoria` enum('Sala_principal','Sala_VIP','Play_Station_5','Simulador_coches') NOT NULL,
  `tiempo_total` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tiempos_sala`
--

INSERT INTO `tiempos_sala` (`id`, `id_socio`, `usuario`, `categoria`, `tiempo_total`) VALUES
(22, 46, 'JaimeMGR', 'Sala_principal', 14387),
(66, 46, 'JaimeMGR', 'Simulador_coches', 86400);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id_noticia`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `registros_uso`
--
ALTER TABLE `registros_uso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_socio` (`id_socio`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `codigo_socio` (`codigo_socio`),
  ADD KEY `codigo_servicio` (`codigo_servicio`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`codigo_servicio`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`id_socio`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `telefono` (`telefono`);

--
-- Indices de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD PRIMARY KEY (`id_testimonio`),
  ADD KEY `autor` (`autor`);

--
-- Indices de la tabla `tiempos_sala`
--
ALTER TABLE `tiempos_sala`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_socio` (`id_socio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id_noticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT de la tabla `registros_uso`
--
ALTER TABLE `registros_uso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `codigo_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `socio`
--
ALTER TABLE `socio`
  MODIFY `id_socio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  MODIFY `id_testimonio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `tiempos_sala`
--
ALTER TABLE `tiempos_sala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `registros_uso`
--
ALTER TABLE `registros_uso`
  ADD CONSTRAINT `registros_uso_ibfk_1` FOREIGN KEY (`id_socio`) REFERENCES `socio` (`id_socio`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`codigo_socio`) REFERENCES `socio` (`id_socio`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`codigo_servicio`) REFERENCES `servicio` (`codigo_servicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD CONSTRAINT `testimonio_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `socio` (`id_socio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tiempos_sala`
--
ALTER TABLE `tiempos_sala`
  ADD CONSTRAINT `tiempos_sala_ibfk_1` FOREIGN KEY (`id_socio`) REFERENCES `socio` (`id_socio`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
