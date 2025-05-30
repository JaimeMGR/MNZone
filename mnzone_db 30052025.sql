-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-05-2025 a las 16:59:52
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
(2, 'Simulador racing', 'Volante + pedales: Logitech G29  Driving Force<br>Palanca de cambios: Logitech Driving Force Shifter', 'conjunto_volante.webp');

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
(27, 'GTA 6 no debería tener nuevo tráiler antes de su lanzamiento y un ex de Rockstar explica por qué', 'Obbe Vermeij, exdirector técnico en el estudio, da su opinión sobre la campaña de marketing de Grand Theft Auto VI y la decisión que él tomaría para aumentar más el hype del sandbox.Sí, estamos a punto de llegar a mayo de 2025 y aún no tenemos nueva información sobre Grand Theft Auto VI, el que es sin duda el juego más esperado del año del que, por ahora, solo tenemos un primer tráiler y la reconfirmación de Take Two de que llegará en otoño del 2025. Mientras la ausencia de información tiene como locos a los aficionados hay gente de la industria apuntando a que Take Two ha cambiado el enfoque de su estrategia de marketing e incluso un ex de Rockstar ha salido a la palestra para asegurar que, si él tuviese que tomar la decisión, no publicaría ningún tráiler más del juego hasta el lanzamiento para aumentar la expectación del juego.', 'grand-theft-auto-vi-20231251505956_1.jpg.webp', '2025-04-29');

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
(175, '24 horas - Volante', 'MNZone', 'productos/1fbfbe18140c7f60fde8d2f2f1c906c4.jpg', 40.00, 'Simulador_coches', 86400);

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
(1, 47, 'Sala_principal', '2025-05-22 19:15:59', '2025-05-22 19:16:16', 13),
(2, 46, 'Sala_principal', '2025-05-22 19:17:45', '2025-05-22 19:17:58', 11);

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
(4, 'Sala VIP', 'Un espacio exclusivo con iluminación LED, equipos de alto rendimiento y ambiente más privado. Perfecta para gamers exigentes, equipos competitivos o sesiones de juego sin interrupciones.\n\n', '../../imagenes/Sala-vip.webp'),
(8, 'Sala VR', 'Sumérgete en la realidad virtual con nuestros dispositivos VR de última generación. Espacio amplio, sensores de movimiento y una selección de juegos inmersivos para vivir una experiencia única. ¡Juega, muévete y siente el juego!\n\n', '../../imagenes/Sala-vr.avif');

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
(47, 'Jaime', 22, 'molina2002', 'Mambanegra', '+34123456789', '1747775255_R.jpg', 'socio'),
(48, 'Jaime', 22, '$2y$10$FDlaZjgQpR6sgLV9Os.rLOAaFIE5AdRDPrlQE53WDGWcWM4G0zcU2', 'Jaime2', '+34102938475', '1747936105_Imagen de WhatsApp 2025-05-11 a las 22.04.30_e910a75f.jpg', 'socio'),
(49, 'JaimeGuapo', 22, '$2y$10$ogAPcagzSs86Y0reR8F3oOqi39CTdzaAGc8hZH18y3XNJ749Jx9WG', 'Jaime3', '+34867554322', '1747936252_EnTTOtyXIAI8Ckc.jpeg', 'socio'),
(50, 'JaimeGuapo', 22, '$2y$10$EB286i5FcLSpAKRf9s.liu0smu0jdawgQN5JpcYxouRg9WvRfjABW', 'Jaime34', '+34867554323', '1747936309_EnTTOtyXIAI8Ckc.jpeg', 'socio');

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
(1, 46, 'JaimeMGR', 'Sala_principal', 10789),
(2, 47, 'Mambanegra', 'Sala_principal', 14387),
(3, 47, 'Mambanegra', 'Sala_VIP', 43200),
(7, 47, 'Mambanegra', 'Play_Station_5', 3600),
(8, 47, 'Mambanegra', 'Simulador_coches', 43200);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mensajes_contacto`
--
ALTER TABLE `mensajes_contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id_noticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT de la tabla `registros_uso`
--
ALTER TABLE `registros_uso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `codigo_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `socio`
--
ALTER TABLE `socio`
  MODIFY `id_socio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  MODIFY `id_testimonio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `tiempos_sala`
--
ALTER TABLE `tiempos_sala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
