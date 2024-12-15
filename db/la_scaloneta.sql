-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-12-2024 a las 17:41:46
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `la_scaloneta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `compra_id` int(10) UNSIGNED NOT NULL,
  `usuario_fk` int(10) UNSIGNED NOT NULL,
  `fecha_compra` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `detalle_compra_id` int(10) UNSIGNED NOT NULL,
  `compra_fk` int(10) UNSIGNED NOT NULL,
  `jugador_fk` int(10) UNSIGNED NOT NULL,
  `cantidad` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_publicacion`
--

CREATE TABLE `estados_publicacion` (
  `estado_publicacion_id` tinyint(3) UNSIGNED NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estados_publicacion`
--

INSERT INTO `estados_publicacion` (`estado_publicacion_id`, `estado`) VALUES
(1, 'publicada'),
(2, 'no publicada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `jugador_id` int(10) UNSIGNED NOT NULL,
  `usuario_fk` int(10) UNSIGNED NOT NULL,
  `estado_publicacion_fk` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `club` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen_jugador` varchar(255) NOT NULL,
  `alt_imagen_jugador` varchar(255) NOT NULL,
  `imagen_camiseta` varchar(255) NOT NULL,
  `alt_imagen_camiseta` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`jugador_id`, `usuario_fk`, `estado_publicacion_fk`, `nombre`, `apellido`, `club`, `descripcion`, `imagen_jugador`, `alt_imagen_jugador`, `imagen_camiseta`, `alt_imagen_camiseta`, `precio`) VALUES
(1, 1, 1, 'Franco', 'Armani', 'River Plate', 'Arquero argentino que nació en Casilda en 1986. Jugó en Ferro Carril Oeste, Deportivo Merlo y Atlético Nacional de Colombia, antes de llegar a River Plate en 2018. Con River ganó 12 títulos, incluyendo dos Copas Libertadores. Con Argentina fue campeón del mundo en Catar 2022, siendo el suplente de Martínez. También fue campeón de la Copa América 2021 y la Finalíssima 2022. Su apodo, Pulpo, se debe a sus reflejos.', 'franco-armani.png', 'Franco Armani', 'camiseta-armani.png', 'Camiseta Franco Armani', 75000.00),
(2, 1, 1, 'Juan', 'Foyth', 'Villareal', 'Defensor, mediocampista o delantero argentino que nació en La Plata en 1998. Se formó y debutó en Estudiantes de La Plata, antes de ser comprado por el Tottenham Hotspur de Inglaterra en 2017. En 2020 se fue al Villarreal de España, donde ganó la Europa League en 2021. Con Argentina fue campeón del mundo en Catar 2022, siendo el jugador más polivalente del equipo, capaz de jugar en cualquier posición. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'juan-foyth.png', 'Juan Foyth', 'camiseta-foyth.png', 'Camiseta Juan Foyth', 80000.00),
(3, 1, 1, 'Nicolas', 'Tagliafico', 'Olympique de Lyon', 'Defensor o mediocampista argentino que nació en Rafael Calzada en 1992. Jugó en Banfield, Real Murcia e Independiente, antes de irse al Ajax de Holanda en 2018. Con el Ajax ganó cuatro títulos, incluyendo dos Eredivisie. Con Argentina fue campeón del mundo en Catar 2022, siendo el suplente de Acuña en el lateral izquierdo. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'nicolas-tagliafico.png', 'Nicolas Tagliafico', 'camiseta-tagliafico.png', 'Camiseta Nicolas Tagliafico', 70000.00),
(4, 1, 1, 'Gonzalo', 'Montiel', 'Nottingham Forest', 'Defensor argentino que nació en González Catán en 1997. Se formó y debutó en River Plate, donde ganó 10 títulos, incluyendo dos Copas Libertadores. En 2021 se fue al Sevilla de España, donde se consolidó como uno de los mejores laterales derechos del mundo. Con Argentina fue campeón del mundo en Catar 2022, siendo el suplente de Molina. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'gonzalo-montiel.png', 'Gonzalo Montiel', 'camiseta-montiel.png', 'Camiseta Gonzalo Montiel', 75000.00),
(5, 1, 1, 'Leandro', 'Paredes', 'Roma', 'Mediocampista o delantero argentino que nació en San Justo en 1994. Jugó en Boca Juniors, Chievo Verona, Roma, Zenit y Paris Saint-Germain. Con el Paris Saint-Germain ganó siete títulos, incluyendo tres Ligue 1. Con Argentina fue campeón del mundo en Catar 2022, siendo el volante central titular del equipo, encargado de recuperar y distribuir el balón. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'leandro-paredes.png', 'Leandro Paredes', 'camiseta-paredes.png', 'Camiseta Leandro Paredes', 70000.00),
(6, 1, 1, 'Germán', 'Pezzella', 'Real Betis', 'Defensor argentino que nació en Bahía Blanca en 1991. Jugó en River Plate, Real Betis y Fiorentina, antes de volver al Real Betis en 2021. Con River ganó cuatro títulos, incluyendo una Copa Sudamericana. Con Argentina fue campeón del mundo en Catar 2022, siendo el compañero de Romero en la zaga central. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'german-pezzella.png', 'German Pezzella', 'camiseta-pezzella.png', 'Camiseta German Pezzella', 75000.00),
(7, 1, 1, 'Rodrigo', 'De Paul', 'Atletico Madrid', 'Mediocampista o delantero argentino que nació en Sarandí en 1994. Jugó en Racing Club, Valencia y Udinese, antes de ser contratado por el Atlético Madrid de España en 2021. Con el Atlético Madrid ganó la Liga Española en su primera temporada. Con Argentina fue campeón del mundo en Catar 2022, siendo el cerebro del equipo, encargado de generar juego y asistir a los atacantes. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'rodrigo-de-paul.png', 'Rodrigo De Paul', 'camiseta-de-paul.png', 'Camiseta Rodrigo De Paul', 85000.00),
(8, 1, 1, 'Marcos', 'Acuña', 'Sevilla', 'Defensor o mediocampista argentino que nació en Zapala en 1991. Jugó en Ferro Carril Oeste, Racing Club y Sporting de Lisboa, antes de fichar por el Sevilla de España en 2020. Con el Sevilla ganó la Europa League en 2021. Con Argentina fue campeón del mundo en Catar 2022, siendo el lateral izquierdo titular del equipo. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'marcos-acuna.png', 'Marcos Acuña', 'camiseta-acuna.png', 'Camiseta Marcos Acuña', 80000.00),
(9, 1, 1, 'Julián', 'Álvarez', 'Manchester City', 'Delantero argentino que nació en Calchín en 2000. Se formó y debutó en River Plate, donde ganó cinco títulos, incluyendo una Copa Libertadores. Con Argentina fue campeón del mundo en Catar 2022, siendo el sexto delantero del equipo, jugando solo unos minutos en el torneo, pero con mucha ilusión y futuro. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'julian-alvarez.png', 'Julian Alvarez', 'camiseta-alvarez.png', 'Camiseta Julian Alvarez', 90000.00),
(10, 1, 1, 'Lionel', 'Messi', 'Inter Miami', 'Mediocampista o delantero argentino que nació en Rosario en 1987. Jugó en Newell’s Old Boys y Barcelona, antes de irse al Paris Saint-Germain en 2021. Con el Barcelona ganó 35 títulos, incluyendo cuatro Champions League. Con el Paris Saint-Germain ganó la Ligue 1 en su primera temporada. Con Argentina fue campeón del mundo en Catar 2022, siendo el capitán y líder del equipo, encargado de marcar la diferencia con su magia y talento. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'lionel-messi.png', 'Lionel Messi', 'camiseta-messi.png', 'Camiseta Lionel Messi', 100000.00),
(11, 1, 1, 'Ángel', 'Di María', 'Benfica', 'Mediocampista o delantero argentino que nació en Rosario en 1988. Jugó en Rosario Central, Benfica, Real Madrid, Manchester United y Paris Saint-Germain. Con el Real Madrid ganó 10 títulos, incluyendo una Champions League. Con el Paris Saint-Germain ganó 18 títulos, incluyendo seis Ligue 1. Con Argentina fue campeón del mundo en Catar 2022, siendo el goleador del equipo con seis tantos, incluyendo el gol de la victoria en la final contra Francia. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'angel-di-maria.png', 'Angel Di Maria', 'camiseta-di-maria.png', 'Camiseta Angel Di Maria', 95000.00),
(12, 1, 1, 'Gerónimo', 'Rulli', 'Villareal', 'Arquero argentino que nació en La Plata en 1992. Jugó en Estudiantes de La Plata, Real Sociedad y Montpellier, antes de fichar por el Villarreal en 2020. Con el Villarreal ganó la Europa League en 2021, atajando el penal decisivo en la final contra el Manchester United. Con Argentina fue campeón del mundo en Catar 2022, siendo el tercer arquero del equipo. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'geronimo-rulli.png', 'Geronimo Rulli', 'camiseta-rulli.png', 'Camiseta Geronimo Rulli', 75000.00),
(13, 1, 1, 'Cristian', 'Romero', 'Tottenham', 'Defensor argentino que nació en Córdoba en 1998. Jugó en Belgrano, Genoa y Atalanta, antes de ser transferido al Tottenham Hotspur de Inglaterra en 2021. Con el Atalanta llegó a los cuartos de final de la Champions League en 2020 y 2021. Con Argentina fue campeón del mundo en Catar 2022, siendo el líder de la defensa central junto a Pezzella. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'cristian-romero.png', 'Cristian Romero', 'camiseta-romero.png', 'Camiseta Cristian Romero', 85000.00),
(14, 1, 1, 'Exequiel', 'Palacios', 'Bayer Leverkusen', 'Mediocampista o delantero argentino que nació en Famaillá en 1998. Jugó en River Plate y Bayer Leverkusen. Con River ganó seis títulos, incluyendo una Copa Libertadores. Con Argentina fue campeón del mundo en Catar 2022, siendo el suplente de Fernández como volante creativo. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'exequiel-palacios.png', 'Exequiel Palacios', 'camiseta-palacios.png', 'Camiseta Exequiel Palacios', 70000.00),
(15, 1, 1, 'Ángel', 'Correa', 'Atlético Madrid', 'Delantero argentino que nació en Rosario en 1995. Jugó en San Lorenzo, Atlético Madrid e Inter de Milán. Con San Lorenzo ganó el Torneo Inicial y la Copa Libertadores. Con Atlético Madrid ganó la Liga 2020-21, siendo una pieza clave del equipo de Simeone. Con Argentina fue campeón del mundo en Catar 2022, siendo el revulsivo del equipo, capaz de cambiar el ritmo y desequilibrar con su velocidad y gambeta. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'angel-correa.png', 'Angel Correa', 'camiseta-correa.png', 'Camiseta Angel Correa', 75000.00),
(16, 1, 1, 'Thiago', 'Almada', 'Atlanta United', 'Mediocampista o delantero argentino que nació en Ciudadela en 2001. Jugó en Vélez Sarsfield y Atlanta United. Con Vélez se destacó por su habilidad, velocidad y regate. Con Atlanta se convirtió en el fichaje más caro de la MLS. Con Argentina fue campeón del mundo en Catar 2022, siendo el juvenil revelación del equipo, aportando frescura y calidad en el mediocampo. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'thiago-almada.png', 'Thiago Almada', 'camiseta-almada.png', 'Camiseta Thiago Almada', 75000.00),
(17, 1, 1, 'Alejandro', 'Gómez', 'Sevilla', 'Mediocampista o delantero argentino que nació en Buenos Aires en 1988. Jugó en Arsenal de Sarandí, San Lorenzo, Catania, Metalist y Atalanta, antes de fichar por el Sevilla de España en 2021. Con el Atalanta llegó a los cuartos de final de la Champions League en 2020 y 2021. Con Argentina fue campeón del mundo en Catar 2022, siendo el revulsivo del equipo, capaz de cambiar el ritmo y desequilibrar con su velocidad y gambeta. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'alejandro-gomez.png', 'Alejandro Gomez', 'camiseta-gomez.png', 'Camiseta Alejandro Gomez', 75000.00),
(18, 1, 1, 'Guido', 'Rodriguez', 'Real Betiz', 'Mediocampista o delantero argentino que nació en Saenz Peña en 1994. Jugó en River Plate, Defensa y Justicia, Tijuana y América de México, antes de llegar al Real Betis de España en 2020. Con el Betis se ganó la titularidad y el cariño de la afición. Con Argentina fue campeón del mundo en Catar 2022, siendo el suplente de Paredes como volante central. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'guido-rodriguez.png', 'Guido Rodriguez', 'camiseta-rodriguez.png', 'Camiseta Guido Rodriguez', 75000.00),
(19, 1, 1, 'Nicolas', 'Otamendi', 'Benfica', 'Defensor argentino que nació en Buenos Aires en 1988. Jugó en Vélez Sarsfield, Porto, Valencia, Manchester City y Benfica. Con el Manchester City ganó nueve títulos, incluyendo cuatro Premier League. Con Argentina fue campeón del mundo en Catar 2022, siendo el tercer defensor central del equipo. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'nicolas-otamendi.png', 'Nicolas Otamendi', 'camiseta-otamendi.png', 'Camiseta Nicolas Otamendi', 75000.00),
(20, 1, 1, 'Alexis', 'Mac Allister', 'Liverpool', 'Mediocampista o delantero argentino que nació en Santa Rosa en 1998. Jugó en Argentinos Juniors y Boca Juniors, antes de irse al Brighton & Hove Albion de Inglaterra en 2019. Con Brighton se afianzó como uno de los mejores jugadores del equipo. Con Argentina fue campeón del mundo en Catar 2022, siendo el suplente natural de De Paul como enganche. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'alexis-mac-allister.png', 'Alexis Mac Allister', 'camiseta-mac-allister.png', 'Camiseta Alexis Mac Allister', 75000.00),
(21, 1, 1, 'Paulo', 'Dybala', 'Roma', 'Delantero argentino que nació en Laguna Larga en 1993. Jugó en Instituto de Córdoba, Palermo y Juventus. Con la Juventus ganó 10 títulos, incluyendo cinco Serie A. Con Argentina fue campeón del mundo en Catar 2022, siendo el cuarto delantero del equipo, aportando su calidad técnica y visión de juego cuando le tocó jugar. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'paulo-dybala.png', 'Paulo Dybala', 'camiseta-dybala.png', 'Camiseta Paulo Dybala', 75000.00),
(22, 1, 1, 'Lautaro', 'Martínez', 'Inter', 'Delantero argentino que nació en Bahía Blanca en 1997. Jugó en Racing Club e Inter de Milán. Con Racing ganó una Superliga Argentina. Con Inter ganó una Serie A y una Europa League. Con Argentina fue campeón del mundo en Catar 2022, siendo el socio ideal de Messi en el ataque, aportando movilidad, presión y definición. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'lautaro-martinez.png', 'Lautaro Martinez', 'camiseta-lautaro.png', 'Camiseta Lautaro Martinez', 90000.00),
(23, 1, 1, 'Emiliano', 'Martinez', 'Aston Villa', 'Arquero argentino que nació en Mar del Plata en 1992. Se formó en Independiente, pero brilló en el Aston Villa de Inglaterra. Con Argentina fue campeón del mundo en Catar 2022, donde atajó tres penales en la final ante Francia y recibió el Guante de Oro y el premio The Best al Guardameta. También ganó la Copa América 2021 y la Finalíssima 2022. Su apodo, Dibu, se debe a un personaje de TV.', 'emiliano-martinez.png', 'Emiliano Martinez', 'camiseta-e-martinez.png', 'Camiseta Emiliano Martinez', 85000.00),
(24, 1, 1, 'Enzo', 'Fernandez', 'Chelsea', 'Mediocampista o delantero argentino que nació en Buenos Aires en 2000. Se formó y debutó en River Plate, donde ganó cuatro títulos, incluyendo una Copa Libertadores. En 2021 se fue a préstamo a Defensa y Justicia, donde se consagró como uno de los mejores jugadores del fútbol argentino. Con Argentina fue campeón del mundo en Catar 2022, siendo el juvenil revelación del equipo, aportando frescura y calidad en el mediocampo. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'enzo-fernandez.png', 'Enzo Fernandez', 'camiseta-fernandez.png', 'Camiseta Enzo Fernandez', 90000.00),
(25, 1, 1, 'Lisandro', 'Martínez', 'Manchester United', 'Defensor o mediocampista argentino que nació en Gualeguay en 1998. Jugó en Newell’s Old Boys y Defensa y Justicia, antes de irse al Ajax de Holanda en 2019. Con el Ajax ganó cuatro títulos, incluyendo dos Eredivisie. Con Argentina fue campeón del mundo en Catar 2022, siendo el comodín del equipo, capaz de jugar en varias posiciones. También fue campeón de la Copa América 2021 y la Finalíssima 2022.', 'lisandro-martinez.png', 'Lisandro Martinez', 'camiseta-l-martinez.png', 'Camiseta Lisandro Martinez', 75000.00),
(26, 1, 1, 'Nahuel', 'Molina', 'Atletico Madrid', 'Defensor argentino que nació en Córdoba en 1997. Se formó en Boca Juniors, pero debutó en Rosario Central. En 2020 se fue al Udinese de Italia, donde se destacó como lateral derecho. Con Argentina fue campeón del mundo en Catar 2022, siendo el titular indiscutido en su posición. También fue campeón de la Copa América 2021 y la Finalíssima 2022. Su apodo, El Puma, se debe a su velocidad y garra.', 'nahuel-molina.png', 'Nahuel Molina', 'camiseta-molina.png', 'Camiseta Nahuel Molina', 80000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores_tienen_posiciones`
--

CREATE TABLE `jugadores_tienen_posiciones` (
  `jugador_fk` int(10) UNSIGNED NOT NULL,
  `posicion_fk` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `jugadores_tienen_posiciones`
--

INSERT INTO `jugadores_tienen_posiciones` (`jugador_fk`, `posicion_fk`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 2),
(5, 3),
(6, 2),
(7, 3),
(8, 2),
(9, 4),
(10, 4),
(11, 4),
(12, 1),
(13, 2),
(14, 3),
(15, 3),
(16, 3),
(17, 3),
(18, 3),
(19, 2),
(20, 3),
(21, 4),
(22, 4),
(23, 1),
(24, 3),
(25, 2),
(26, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posiciones`
--

CREATE TABLE `posiciones` (
  `posicion_id` tinyint(3) UNSIGNED NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `posiciones`
--

INSERT INTO `posiciones` (`posicion_id`, `nombre`) VALUES
(1, 'arquero'),
(2, 'defensor'),
(3, 'mediocampista'),
(4, 'delantero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `rol_id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rol_id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Normal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `rol_fk` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `email`, `password`, `nombre`, `apellido`, `rol_fk`) VALUES
(1, 'admin@scaloneta.com', '$2y$10$G7z7Qsj81tgZ3LnKxnYOGOK.N3t4D9f/LEOW0wFhQzonMscPLInxO', 'Lara', 'Crupnicoff', 1),
(3, 'lioben@gmail.com', '$2y$10$sY6dr27249RMYiW8ndrEWe9vAxFP8CJGwAXYzupCM2jYaPzvE3782', 'lio', 'ben', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`compra_id`),
  ADD KEY `fk_compras_usuarios_idx` (`usuario_fk`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`detalle_compra_id`),
  ADD KEY `fk_detalle_compras_compras_idx` (`compra_fk`),
  ADD KEY `fk_detalle_compras_jugadores_idx` (`jugador_fk`);

--
-- Indices de la tabla `estados_publicacion`
--
ALTER TABLE `estados_publicacion`
  ADD PRIMARY KEY (`estado_publicacion_id`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`jugador_id`),
  ADD KEY `fk_jugadores_usuarios_idx` (`usuario_fk`),
  ADD KEY `fk_jugadores_estados_publicacion1_idx` (`estado_publicacion_fk`);

--
-- Indices de la tabla `jugadores_tienen_posiciones`
--
ALTER TABLE `jugadores_tienen_posiciones`
  ADD PRIMARY KEY (`jugador_fk`,`posicion_fk`),
  ADD KEY `fk_jugadores_has_posiciones_posiciones1_idx` (`posicion_fk`),
  ADD KEY `fk_jugadores_has_posiciones_jugadores1_idx` (`jugador_fk`);

--
-- Indices de la tabla `posiciones`
--
ALTER TABLE `posiciones`
  ADD PRIMARY KEY (`posicion_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rol_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_usuarios_roles1_idx` (`rol_fk`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `compra_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `detalle_compra_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estados_publicacion`
--
ALTER TABLE `estados_publicacion`
  MODIFY `estado_publicacion_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `posiciones`
--
ALTER TABLE `posiciones`
  MODIFY `posicion_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `rol_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_compras_usuarios` FOREIGN KEY (`usuario_fk`) REFERENCES `usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `fk_detalle_compras_compras` FOREIGN KEY (`compra_fk`) REFERENCES `compras` (`compra_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detalle_compras_jugadores` FOREIGN KEY (`jugador_fk`) REFERENCES `jugadores` (`jugador_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD CONSTRAINT `fk_jugadores_estados_publicacion1` FOREIGN KEY (`estado_publicacion_fk`) REFERENCES `estados_publicacion` (`estado_publicacion_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jugadores_usuarios` FOREIGN KEY (`usuario_fk`) REFERENCES `usuarios` (`usuario_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `jugadores_tienen_posiciones`
--
ALTER TABLE `jugadores_tienen_posiciones`
  ADD CONSTRAINT `fk_jugadores_has_posiciones_jugadores1` FOREIGN KEY (`jugador_fk`) REFERENCES `jugadores` (`jugador_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_jugadores_has_posiciones_posiciones1` FOREIGN KEY (`posicion_fk`) REFERENCES `posiciones` (`posicion_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles1` FOREIGN KEY (`rol_fk`) REFERENCES `roles` (`rol_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
