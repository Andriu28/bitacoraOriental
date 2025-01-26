-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-01-2025 a las 03:46:54
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bitacora_oriental`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `authenticationcode`
--

CREATE TABLE `authenticationcode` (
  `id` int(11) NOT NULL COMMENT 'clave primaria de las autentificaciones',
  `idUser` int(11) NOT NULL COMMENT 'clave foranea para acceder a la tabla usuario(user).',
  `code` varchar(6) NOT NULL COMMENT 'codigo de verificacion via correo electronico',
  `hash` varchar(62) NOT NULL COMMENT 'toquen para identificar cada código de verificación para que sea único',
  `date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora en la que se realizó el registro\r\ny manjar un tiempo de expiración del código',
  `status` varchar(1) NOT NULL COMMENT 'indicador para saber si el codigo ha sido usado o no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `authenticationcode`
--

INSERT INTO `authenticationcode` (`id`, `idUser`, `code`, `hash`, `date`, `status`) VALUES
(1, 1, '726793', 'a42b4dde8771da0b852889d591002ad6', '2025-01-20 07:27:23', '0'),
(2, 2, '403049', 'd8e1344e27a5b08cdfd5d027d9b8d6de', '2025-01-20 07:29:42', '0'),
(3, 3, '322203', 'e254457f7497c00fbb0d2bb4ac36487b', '2025-01-20 07:35:52', '0'),
(4, 4, '178125', '08f38e0434442128fab5ead6217ca759', '2025-01-20 07:38:09', '0'),
(5, 7, '229834', 'dfc7defac6624a80f02b02e22b14e8fd', '2025-01-20 07:45:34', '0'),
(6, 8, '808680', '606c90a06173d69682feb83037a68fec', '2025-01-20 07:46:41', '0'),
(7, 9, '636609', '5705e1164a8394aace6018e27d20d237', '2025-01-20 10:21:35', '0'),
(8, 9, '178648', 'a8ed71126b12732b838cee58de4efe3f', '2025-01-20 10:29:58', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

CREATE TABLE `comment` (
  `idComment` int(11) NOT NULL COMMENT 'identificador unico del resgistro del comentario',
  `idWebLog` int(11) NOT NULL COMMENT 'clave foranea que vincula un comentario a una bitacora especifica con la tabla de bitacora(weblog)',
  `message` varchar(350) NOT NULL COMMENT 'mensaje escrito por un usuario de sistema, relacionado a una bitacora',
  `status` varchar(1) NOT NULL COMMENT 'diferencia si el comentario fue aceptado , rechazado o esta sin procesar',
  `dataTime` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Fecha y hora en la que se realizó el registro del comentario',
  `idUser` int(11) NOT NULL COMMENT 'clave foranea pare vincular al comentraio con un usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `comment`
--

INSERT INTO `comment` (`idComment`, `idWebLog`, `message`, `status`, `dataTime`, `idUser`) VALUES
(1, 1, 'muy bien servicio lo recominedo mucho', 'A', '2025-01-20 00:12:22', 3),
(2, 1, 'verdaderamente es un muy buen servicio', 'A', '2025-01-20 00:12:35', 3),
(3, 1, 'hola todos me gusto mucho su servicio de viajes, lo voy recomendar a mis amigos', 'A', '2025-01-20 00:14:30', 3),
(4, 1, 'lla experiencia es unica', 'A', '2025-01-20 00:15:32', 3),
(5, 1, 'los viajes de bitacora oriental son lo maximo', 'R', '2025-01-20 10:29:03', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_e` int(11) NOT NULL COMMENT 'identificador unico de cada estado ',
  `estado` varchar(100) NOT NULL COMMENT 'nombre propio de los estados de venezuela'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_e`, `estado`) VALUES
(1, 'DTTO. CAPITAL'),
(2, 'ANZOATEGUI'),
(3, 'APURE'),
(4, 'ARAGUA'),
(5, 'BARINAS'),
(6, 'BOLIVAR'),
(7, 'CARABOBO'),
(8, 'COJEDES'),
(9, 'FALCON'),
(10, 'GUARICO'),
(11, 'LARA'),
(12, 'MERIDA'),
(13, 'MIRANDA'),
(14, 'MONAGAS'),
(15, 'NUEVA ESPARTA'),
(16, 'PORTUGUESA'),
(17, 'SUCRE'),
(18, 'TACHIRA'),
(19, 'TRUJILLO'),
(20, 'YARACUY'),
(21, 'ZULIA'),
(22, 'AMAZONAS'),
(23, 'DELTA AMACURO'),
(24, 'VARGAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faq`
--

CREATE TABLE `faq` (
  `id_preg_frecuente` int(11) NOT NULL COMMENT 'identificador unico de una pregunta frecuente',
  `query` varchar(255) NOT NULL COMMENT 'pregunta frecuente de los clientes de la institucion',
  `respond` text NOT NULL COMMENT 'respuesta precisa',
  `status` varchar(1) NOT NULL COMMENT 'indicador del registro, en relacion a estar habilitado en el portal o inhabilitado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `faq`
--

INSERT INTO `faq` (`id_preg_frecuente`, `query`, `respond`, `status`) VALUES
(1, '¿Dónde estamos ubicados?', 'Concretamente nos residenciamos en guayacan, pero No tenemos sector fisico, pero laboramos en espacios virtuales.', '1'),
(2, '¿Cada cuanto salimos de Viajes?', 'Depende mucho de la temporada de año, aunque la frecuencia media es cada 10 dias', '1'),
(3, '¿Cuáles son nuestros métodos de pago?', 'Trabajamos con, divisas, efectivo, pagomovil y punto de venta', '1'),
(4, '¿Cuántos años llevamos laborando?', 'Tenemos 11 años en el medio turístico.', '1'),
(5, '¿Tenemos redes sociales?', 'Si, y las puedes encontrar en un enlace al final de la página', '1'),
(6, '¿Cómo puedo usar la pagina?', 'Es fácil, solo debes registrarte como usuario y podrás, hacer reservaciones, y hacer comentarios.', '1'),
(7, '¿Cómo puedo hacer una reservación?', 'Desde la pagina selecciona el viaje, llena el formulario y comunícate con nosotros. o espera que nos comuniquemos contigo, debes reportar una parte del pago para garantizarte el cupo', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `history`
--

CREATE TABLE `history` (
  `idHistory` int(11) NOT NULL COMMENT 'identificador unico del registro del historial',
  `idUser` int(11) NOT NULL COMMENT 'clave forania que identifica al usuario que ha realizado una accion',
  `module` varchar(20) NOT NULL COMMENT 'modulo correspondiente a la accion',
  `action` varchar(200) NOT NULL COMMENT 'funcionalidad usada en el sistema ',
  `registrationDate` date NOT NULL COMMENT 'Fecha en la que se realizó el registro de la accion',
  `registrationTime` time NOT NULL COMMENT 'Hora en la que se realizó el registro de la accion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `history`
--

INSERT INTO `history` (`idHistory`, `idUser`, `module`, `action`, `registrationDate`, `registrationTime`) VALUES
(1, 2, 'Usuario', 'el usuario inicio sesión', '2025-01-20', '07:30:58'),
(2, 2, 'Usuario', 'el usuario cerro sesión', '2025-01-20', '07:34:40'),
(3, 2, 'Usuario', 'el usuario inicio sesión', '2025-01-20', '07:38:33'),
(4, 2, 'Usuario', 'Insertó un usuario publicista.', '2025-01-20', '07:40:57'),
(5, 2, 'Usuario', 'Insertó un usuario publicista.', '2025-01-20', '07:43:33'),
(6, 2, 'Usuario', 'el usuario cerro sesión', '2025-01-20', '07:44:44'),
(7, 1, 'Usuario', 'el usuario inicio sesión', '2025-01-20', '07:51:16'),
(8, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '07:52:55'),
(9, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '07:54:48'),
(10, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '07:56:07'),
(11, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '07:58:27'),
(12, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '08:00:49'),
(13, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '08:09:51'),
(14, 1, 'Ruta', 'El usuario inhabilitó.', '2025-01-20', '08:10:24'),
(15, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '08:12:03'),
(16, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '08:12:53'),
(17, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '08:15:43'),
(18, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '08:18:31'),
(19, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '08:19:34'),
(20, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '08:22:34'),
(21, 1, 'Preguntas Frecuente', 'El usuario insertó.', '2025-01-20', '08:24:50'),
(22, 1, 'Preguntas Frecuente', 'El usuario insertó.', '2025-01-20', '08:25:54'),
(23, 1, 'Preguntas Frecuente', 'El usuario insertó.', '2025-01-20', '08:26:54'),
(24, 1, 'Preguntas Frecuente', 'El usuario insertó.', '2025-01-20', '08:27:43'),
(25, 1, 'Preguntas Frecuente', 'El usuario insertó.', '2025-01-20', '08:28:24'),
(26, 1, 'Preguntas Frecuente', 'El usuario insertó.', '2025-01-20', '08:28:49'),
(27, 1, 'Preguntas Frecuente', 'El usuario editó.', '2025-01-20', '08:29:59'),
(28, 1, 'Preguntas Frecuente', 'El usuario insertó.', '2025-01-20', '08:32:46'),
(29, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '08:35:05'),
(30, 1, 'Ruta', 'El usuario insertó.', '2025-01-20', '08:37:07'),
(31, 1, 'Publicaciones Especi', 'El usuario insertó.', '2025-01-20', '08:40:21'),
(32, 1, 'Publicaciones Especi', 'El usuario insertó.', '2025-01-20', '08:41:23'),
(33, 1, 'Publicaciones Especi', 'El usuario insertó.', '2025-01-20', '08:42:10'),
(34, 1, 'Publicaciones Especi', 'El usuario insertó.', '2025-01-20', '08:43:45'),
(35, 1, 'Publicaciones Especi', 'El usuario insertó.', '2025-01-20', '08:46:05'),
(36, 1, 'Publicaciones Especi', 'El usuario insertó.', '2025-01-20', '08:47:18'),
(37, 1, 'Paquete de viaje', 'El usuario insertó.', '2025-01-20', '08:50:53'),
(38, 1, 'Paquete de viaje', 'El usuario insertó.', '2025-01-20', '08:52:05'),
(39, 1, 'Paquete de viaje', 'El usuario insertó.', '2025-01-20', '08:53:46'),
(40, 1, 'Paquete de viaje', 'El usuario insertó.', '2025-01-20', '08:54:41'),
(41, 1, 'Oferta de Viaje', 'El usuario insertó.', '2025-01-20', '08:55:35'),
(42, 1, 'Oferta de Viaje', 'El usuario insertó.', '2025-01-20', '08:57:05'),
(43, 1, 'Paquete de viaje', 'El usuario insertó.', '2025-01-20', '08:57:52'),
(44, 1, 'Oferta de Viaje', 'El usuario editó.', '2025-01-20', '08:58:00'),
(45, 1, 'Bitácora de viaje', 'El usuario insertó.', '2025-01-20', '08:59:55'),
(46, 1, 'Oferta de Viaje', 'El usuario insertó.', '2025-01-20', '09:01:10'),
(47, 1, 'Bitácora de viaje', 'El usuario insertó.', '2025-01-20', '09:02:55'),
(48, 1, 'Oferta de Viaje', 'El usuario insertó.', '2025-01-20', '09:03:55'),
(49, 1, 'Usuario', 'el usuario cerro sesión', '2025-01-20', '09:04:01'),
(50, 1, 'Usuario', 'el usuario inicio sesión', '2025-01-20', '09:05:06'),
(51, 1, 'Ruta', 'El usuario editó.', '2025-01-20', '09:05:42'),
(52, 1, 'Ruta', 'El usuario editó.', '2025-01-20', '09:06:11'),
(53, 1, 'Ruta', 'El usuario editó.', '2025-01-20', '09:08:14'),
(54, 1, 'Ruta', 'El usuario editó.', '2025-01-20', '09:08:32'),
(55, 1, 'Usuario', 'el usuario cerro sesión', '2025-01-20', '09:09:24'),
(56, 1, 'Usuario', 'el usuario cerro sesión', '2025-01-20', '00:08:55'),
(57, 2, 'Usuario', 'el usuario inicio sesión', '2025-01-20', '00:16:32'),
(58, 2, 'Comentarios', 'El usuario aceptó el comentario.', '2025-01-20', '00:16:40'),
(59, 2, 'Comentarios', 'El usuario aceptó el comentario.', '2025-01-20', '00:16:43'),
(60, 2, 'Comentarios', 'El usuario aceptó el comentario.', '2025-01-20', '00:16:46'),
(61, 2, 'Usuario', 'el usuario cerro sesión', '2025-01-20', '00:16:55'),
(62, 2, 'Usuario', 'el usuario inicio sesión', '2025-01-20', '00:17:37'),
(63, 2, 'Ruta', 'El usuario insertó.', '2025-01-20', '00:17:58'),
(64, 2, 'Ruta', 'El usuario inhabilitó.', '2025-01-20', '00:18:15'),
(65, 2, 'Ruta', 'El usuario inhabilitó.', '2025-01-20', '09:50:44'),
(66, 2, 'Usuario', 'La sesión del usuario fue cerrada por inactividad.', '2025-01-20', '09:50:44'),
(67, 5, 'Usuario', 'el usuario inicio sesión', '2025-01-20', '10:34:18'),
(68, 5, 'Comentarios', 'El usuario aceptó el comentario.', '2025-01-20', '10:38:07'),
(69, 5, 'Comentarios', 'El usuario rechazó el comentario.', '2025-01-20', '10:39:40'),
(70, 5, 'Usuario', 'el usuario cerro sesión', '2025-01-20', '10:48:55'),
(71, 1, 'Usuario', 'el usuario inicio sesión', '2025-01-20', '10:49:09'),
(72, 1, 'Usuario', 'el usuario cerro sesión', '2025-01-20', '11:05:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `image`
--

CREATE TABLE `image` (
  `idImage` int(11) NOT NULL COMMENT 'identificador unico de la imagen',
  `imageUrl` varchar(500) NOT NULL COMMENT 'url de la direccion fisica de la imagen '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `image`
--

INSERT INTO `image` (`idImage`, `imageUrl`) VALUES
(1, 'asset/img/449166617_877206384423763_111273298383339583_n.jpg'),
(2, 'asset/img/ruta2.jpg'),
(3, 'asset/img/468246956_981609670650100_4691093884191597915_n (1).jpg'),
(4, 'asset/img/472957957_18265505149265939_7194234464590890351_n.jpg'),
(5, 'asset/img/manare.jpg'),
(6, 'asset/img/CRUZ-SALMERON-palyablanca.jpg'),
(7, 'asset/img/473046604_18265505164265939_5515580270403994862_n.jpg'),
(8, 'asset/img/468839181_987695783374822_7443088294684718955_n.jpg'),
(9, 'asset/img/isla de pala.jpg'),
(10, 'asset/img/puerta de miraflores.jpg'),
(11, 'asset/img/460199778_18250943113265939_4567588762661529898_n.jpg'),
(12, 'asset/img/Chichiriviche Falcón.jpg'),
(13, 'asset/img/kokoland.jpg'),
(14, 'asset/img/_31926414-a5f1-4d35-a859-c6e95c4ed6ec - copia.jfif'),
(15, 'asset/img/amigos.jpg'),
(16, 'asset/img/565.jfif'),
(17, 'asset/img/th.jfif'),
(18, 'asset/img/imgPortal.jfif'),
(19, 'asset/img/publEspecial.jpg'),
(20, 'asset/img/WhatsApp Image 2024-06-11 at 8.50.52 PM (1).jpeg'),
(21, 'asset/bitacora/img_678e48cb406408.52167266.jfif'),
(22, 'asset/bitacora/img_678e48cb422f25.12629839.jfif'),
(23, 'asset/bitacora/img_678e48cb4324a3.65585439.jfif'),
(24, 'asset/bitacora/img_678e48cb448721.07618098.jfif'),
(25, 'asset/bitacora/img_678e48cb453d75.66463449.jpg'),
(26, 'asset/bitacora/img_678e48cb45f524.79195104.jfif'),
(27, 'asset/bitacora/img_678e497f5a74e4.09778905.jfif'),
(28, 'asset/bitacora/img_678e497f5b75c4.84812365.jfif'),
(29, 'asset/bitacora/img_678e497f5c0729.97919864.jfif'),
(30, 'asset/bitacora/img_678e497f5d09d9.97458928.png'),
(31, 'asset/img/ruta2.jpg'),
(32, 'asset/img/468286558_981609680650099_6871231238749345033_n.jpg'),
(33, 'asset/img/manare.jpg'),
(34, 'asset/img/449166617_877206384423763_111273298383339583_n.jpg'),
(35, 'asset/img/wallpaperflare.com_wallpaper (2).jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imageweblog`
--

CREATE TABLE `imageweblog` (
  `idImage` int(11) NOT NULL COMMENT 'clave foranea de la imagen extraida de la tabla image',
  `idWebLog` int(11) NOT NULL COMMENT 'clave foranea de la bitacora segun se relacione con una imagen particular',
  `status` varchar(5) NOT NULL COMMENT 'indicador para saber si la imagen esta en uso o no lo esta'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `imageweblog`
--

INSERT INTO `imageweblog` (`idImage`, `idWebLog`, `status`) VALUES
(21, 1, '1'),
(22, 1, '1'),
(23, 1, '1'),
(24, 1, '1'),
(25, 1, '1'),
(26, 1, '1'),
(27, 2, '1'),
(28, 2, '1'),
(29, 2, '1'),
(30, 2, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

CREATE TABLE `municipio` (
  `id_m` int(11) NOT NULL COMMENT 'identificador unico del registro del municipio',
  `municipio` varchar(100) NOT NULL COMMENT 'nombre propio del municipio',
  `estado_id` int(11) NOT NULL COMMENT 'clave foranea que relaciona este registro  con un estado '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`id_m`, `municipio`, `estado_id`) VALUES
(1, 'LIBERTADOR', 1),
(2, 'ANACO', 2),
(3, 'ARAGUA', 2),
(4, 'BOLIVAR', 2),
(5, 'BRUZUAL', 2),
(6, 'CAJIGAL', 2),
(7, 'FREITES', 2),
(8, 'INDEPENDENCIA', 2),
(9, 'LIBERTAD', 2),
(10, 'MIRANDA', 2),
(11, 'MONAGAS', 2),
(12, 'PEÑALVER', 2),
(13, 'SIMON RODRIGUEZ', 2),
(14, 'SOTILLO', 2),
(15, 'GUANIPA', 2),
(16, 'GUANTA', 2),
(17, 'PIRITU', 2),
(18, 'M.L/DIEGO BAUTISTA U', 2),
(19, 'CARVAJAL', 2),
(20, 'SANTA ANA', 2),
(21, 'MC GREGOR', 2),
(22, 'S JUAN CAPISTRANO', 2),
(23, 'ACHAGUAS', 3),
(24, 'MUÑOZ', 3),
(25, 'PAEZ', 3),
(26, 'PEDRO CAMEJO', 3),
(27, 'ROMULO GALLEGOS', 3),
(28, 'SAN FERNANDO', 3),
(29, 'BIRUACA', 3),
(30, 'GIRARDOT', 4),
(31, 'SANTIAGO MARIÑO', 4),
(32, 'JOSE FELIX RIVAS', 4),
(33, 'SAN CASIMIRO', 4),
(34, 'SAN SEBASTIAN', 4),
(35, 'SUCRE', 4),
(36, 'URDANETA', 4),
(37, 'ZAMORA', 4),
(38, 'LIBERTADOR', 4),
(39, 'JOSE ANGEL LAMAS', 4),
(40, 'BOLIVAR', 4),
(41, 'SANTOS MICHELENA', 4),
(42, 'MARIO B IRAGORRY', 4),
(43, 'TOVAR', 4),
(44, 'CAMATAGUA', 4),
(45, 'JOSE R REVENGA', 4),
(46, 'FRANCISCO LINARES A.', 4),
(47, 'M.OCUMARE D LA COSTA', 4),
(48, 'ARISMENDI', 5),
(49, 'BARINAS', 5),
(50, 'BOLIVAR', 5),
(51, 'EZEQUIEL ZAMORA', 5),
(52, 'OBISPOS', 5),
(53, 'PEDRAZA', 5),
(54, 'ROJAS', 5),
(55, 'SOSA', 5),
(56, 'ALBERTO ARVELO T', 5),
(57, 'A JOSE DE SUCRE', 5),
(58, 'CRUZ PAREDES', 5),
(59, 'ANDRES E. BLANCO', 5),
(60, 'CARONI', 6),
(61, 'CEDEÑO', 6),
(62, 'HERES', 6),
(63, 'PIAR', 6),
(64, 'ROSCIO', 6),
(65, 'SUCRE', 6),
(66, 'SIFONTES', 6),
(67, 'RAUL LEONI', 6),
(68, 'GRAN SABANA', 6),
(69, 'EL CALLAO', 6),
(70, 'PADRE PEDRO CHIEN', 6),
(71, 'BEJUMA', 7),
(72, 'CARLOS ARVELO', 7),
(73, 'DIEGO IBARRA', 7),
(74, 'GUACARA', 7),
(75, 'MONTALBAN', 7),
(76, 'JUAN JOSE MORA', 7),
(77, 'PUERTO CABELLO', 7),
(78, 'SAN JOAQUIN', 7),
(79, 'VALENCIA', 7),
(80, 'MIRANDA', 7),
(81, 'LOS GUAYOS', 7),
(82, 'NAGUANAGUA', 7),
(83, 'SAN DIEGO', 7),
(84, 'LIBERTADOR', 7),
(85, 'ANZOATEGUI', 8),
(86, 'FALCON', 8),
(87, 'GIRARDOT', 8),
(88, 'MP PAO SN J BAUTISTA', 8),
(89, 'RICAURTE', 8),
(90, 'SAN CARLOS', 8),
(91, 'TINACO', 8),
(92, 'LIMA BLANCO', 8),
(93, 'ROMULO GALLEGOS', 8),
(94, 'ACOSTA', 9),
(95, 'BOLIVAR', 9),
(96, 'BUCHIVACOA', 9),
(97, 'CARIRUBANA', 9),
(98, 'COLINA', 9),
(99, 'DEMOCRACIA', 9),
(100, 'FALCON', 9),
(101, 'FEDERACION', 9),
(102, 'MAUROA', 9),
(103, 'MIRANDA', 9),
(104, 'PETIT', 9),
(105, 'SILVA', 9),
(106, 'ZAMORA', 9),
(107, 'DABAJURO', 9),
(108, 'MONS. ITURRIZA', 9),
(109, 'LOS TAQUES', 9),
(110, 'PIRITU', 9),
(111, 'UNION', 9),
(112, 'SAN FRANCISCO', 9),
(113, 'JACURA', 9),
(114, 'CACIQUE MANAURE', 9),
(115, 'PALMA SOLA', 9),
(116, 'SUCRE', 9),
(117, 'URUMACO', 9),
(118, 'TOCOPERO', 9),
(119, 'INFANTE', 10),
(120, 'MELLADO', 10),
(121, 'MIRANDA', 10),
(122, 'MONAGAS', 10),
(123, 'RIBAS', 10),
(124, 'ROSCIO', 10),
(125, 'ZARAZA', 10),
(126, 'CAMAGUAN', 10),
(127, 'S JOSE DE GUARIBE', 10),
(128, 'LAS MERCEDES', 10),
(129, 'EL SOCORRO', 10),
(130, 'ORTIZ', 10),
(131, 'S MARIA DE IPIRE', 10),
(132, 'CHAGUARAMAS', 10),
(133, 'SAN GERONIMO DE G', 10),
(134, 'CRESPO', 11),
(135, 'IRIBARREN', 11),
(136, 'JIMENEZ', 11),
(137, 'MORAN', 11),
(138, 'PALAVECINO', 11),
(139, 'TORRES', 11),
(140, 'URDANETA', 11),
(141, 'ANDRES E BLANCO', 11),
(142, 'SIMON PLANAS', 11),
(143, 'ALBERTO ADRIANI', 12),
(144, 'ANDRES BELLO', 12),
(145, 'ARZOBISPO CHACON', 12),
(146, 'CAMPO ELIAS', 12),
(147, 'GUARAQUE', 12),
(148, 'JULIO CESAR SALAS', 12),
(149, 'JUSTO BRICEÑO', 12),
(150, 'LIBERTADOR', 12),
(151, 'SANTOS MARQUINA', 12),
(152, 'MIRANDA', 12),
(153, 'ANTONIO PINTO S.', 12),
(154, 'OB. RAMOS DE LORA', 12),
(155, 'CARACCIOLO PARRA', 12),
(156, 'CARDENAL QUINTERO', 12),
(157, 'PUEBLO LLANO', 12),
(158, 'RANGEL', 12),
(159, 'RIVAS DAVILA', 12),
(160, 'SUCRE', 12),
(161, 'TOVAR', 12),
(162, 'TULIO F CORDERO', 12),
(163, 'PADRE NOGUERA', 12),
(164, 'ARICAGUA', 12),
(165, 'ZEA', 12),
(166, 'ACEVEDO', 13),
(167, 'BRION', 13),
(168, 'GUAICAIPURO', 13),
(169, 'INDEPENDENCIA', 13),
(170, 'LANDER', 13),
(171, 'PAEZ', 13),
(172, 'PAZ CASTILLO', 13),
(173, 'PLAZA', 13),
(174, 'SUCRE', 13),
(175, 'URDANETA', 13),
(176, 'ZAMORA', 13),
(177, 'CRISTOBAL ROJAS', 13),
(178, 'LOS SALIAS', 13),
(179, 'ANDRES BELLO', 13),
(180, 'SIMON BOLIVAR', 13),
(181, 'BARUTA', 13),
(182, 'CARRIZAL', 13),
(183, 'CHACAO', 13),
(184, 'EL HATILLO', 13),
(185, 'BUROZ', 13),
(186, 'PEDRO GUAL', 13),
(187, 'ACOSTA', 14),
(188, 'BOLIVAR', 14),
(189, 'CARIPE', 14),
(190, 'CEDEÑO', 14),
(191, 'EZEQUIEL ZAMORA', 14),
(192, 'LIBERTADOR', 14),
(193, 'MATURIN', 14),
(194, 'PIAR', 14),
(195, 'PUNCERES', 14),
(196, 'SOTILLO', 14),
(197, 'AGUASAY', 14),
(198, 'SANTA BARBARA', 14),
(199, 'URACOA', 14),
(200, 'ARISMENDI', 15),
(201, 'DIAZ', 15),
(202, 'GOMEZ', 15),
(203, 'MANEIRO', 15),
(204, 'MARCANO', 15),
(205, 'MARIÑO', 15),
(206, 'PENIN. DE MACANAO', 15),
(207, 'VILLALBA(I.COCHE)', 15),
(208, 'TUBORES', 15),
(209, 'ANTOLIN DEL CAMPO', 15),
(210, 'GARCIA', 15),
(211, 'ARAURE', 16),
(212, 'ESTELLER', 16),
(213, 'GUANARE', 16),
(214, 'GUANARITO', 16),
(215, 'OSPINO', 16),
(216, 'PAEZ', 16),
(217, 'SUCRE', 16),
(218, 'TUREN', 16),
(219, 'M.JOSE V DE UNDA', 16),
(220, 'AGUA BLANCA', 16),
(221, 'PAPELON', 16),
(222, 'GENARO BOCONOITO', 16),
(223, 'S RAFAEL DE ONOTO', 16),
(224, 'SANTA ROSALIA', 16),
(225, 'ARISMENDI', 17),
(226, 'BENITEZ', 17),
(227, 'BERMUDEZ', 17),
(228, 'CAJIGAL', 17),
(229, 'MARIÑO', 17),
(230, 'MEJIA', 17),
(231, 'MONTES', 17),
(232, 'RIBERO', 17),
(233, 'SUCRE', 17),
(234, 'VALDEZ', 17),
(235, 'ANDRES E BLANCO', 17),
(236, 'LIBERTADOR', 17),
(237, 'ANDRES MATA', 17),
(238, 'BOLIVAR', 17),
(239, 'CRUZ S ACOSTA', 17),
(240, 'AYACUCHO', 18),
(241, 'BOLIVAR', 18),
(242, 'INDEPENDENCIA', 18),
(243, 'CARDENAS', 18),
(244, 'JAUREGUI', 18),
(245, 'JUNIN', 18),
(246, 'LOBATERA', 18),
(247, 'SAN CRISTOBAL', 18),
(248, 'URIBANTE', 18),
(249, 'CORDOBA', 18),
(250, 'GARCIA DE HEVIA', 18),
(251, 'GUASIMOS', 18),
(252, 'MICHELENA', 18),
(253, 'LIBERTADOR', 18),
(254, 'PANAMERICANO', 18),
(255, 'PEDRO MARIA UREÑA', 18),
(256, 'SUCRE', 18),
(257, 'ANDRES BELLO', 18),
(258, 'FERNANDEZ FEO', 18),
(259, 'LIBERTAD', 18),
(260, 'SAMUEL MALDONADO', 18),
(261, 'SEBORUCO', 18),
(262, 'ANTONIO ROMULO C', 18),
(263, 'FCO DE MIRANDA', 18),
(264, 'JOSE MARIA VARGA', 18),
(265, 'RAFAEL URDANETA', 18),
(266, 'SIMON RODRIGUEZ', 18),
(267, 'TORBES', 18),
(268, 'SAN JUDAS TADEO', 18),
(269, 'RAFAEL RANGEL', 19),
(270, 'BOCONO', 19),
(271, 'CARACHE', 19),
(272, 'ESCUQUE', 19),
(273, 'TRUJILLO', 19),
(274, 'URDANETA', 19),
(275, 'VALERA', 19),
(276, 'CANDELARIA', 19),
(277, 'MIRANDA', 19),
(278, 'MONTE CARMELO', 19),
(279, 'MOTATAN', 19),
(280, 'PAMPAN', 19),
(281, 'S RAFAEL CARVAJAL', 19),
(282, 'SUCRE', 19),
(283, 'ANDRES BELLO', 19),
(284, 'BOLIVAR', 19),
(285, 'JOSE F M CAÑIZAL', 19),
(286, 'JUAN V CAMPO ELI', 19),
(287, 'LA CEIBA', 19),
(288, 'PAMPANITO', 19),
(289, 'BOLIVAR', 20),
(290, 'BRUZUAL', 20),
(291, 'NIRGUA', 20),
(292, 'SAN FELIPE', 20),
(293, 'SUCRE', 20),
(294, 'URACHICHE', 20),
(295, 'PEÑA', 20),
(296, 'JOSE ANTONIO PAEZ', 20),
(297, 'LA TRINIDAD', 20),
(298, 'COCOROTE', 20),
(299, 'INDEPENDENCIA', 20),
(300, 'ARISTIDES BASTID', 20),
(301, 'MANUEL MONGE', 20),
(302, 'VEROES', 20),
(303, 'BARALT', 21),
(304, 'SANTA RITA', 21),
(305, 'COLON', 21),
(306, 'MARA', 21),
(307, 'MARACAIBO', 21),
(308, 'MIRANDA', 21),
(309, 'PAEZ', 21),
(310, 'MACHIQUES DE P', 21),
(311, 'SUCRE', 21),
(312, 'LA CAÑADA DE U.', 21),
(313, 'LAGUNILLAS', 21),
(314, 'CATATUMBO', 21),
(315, 'M/ROSARIO DE PERIJA', 21),
(316, 'CABIMAS', 21),
(317, 'VALMORE RODRIGUEZ', 21),
(318, 'JESUS E LOSSADA', 21),
(319, 'ALMIRANTE P', 21),
(320, 'SAN FRANCISCO', 21),
(321, 'JESUS M SEMPRUN', 21),
(322, 'FRANCISCO J PULG', 21),
(323, 'SIMON BOLIVAR', 21),
(324, 'ATURES', 22),
(325, 'ATABAPO', 22),
(326, 'MAROA', 22),
(327, 'RIO NEGRO', 22),
(328, 'AUTANA', 22),
(329, 'MANAPIARE', 22),
(330, 'ALTO ORINOCO', 22),
(331, 'TUCUPITA', 23),
(332, 'PEDERNALES', 23),
(333, 'ANTONIO DIAZ', 23),
(334, 'CASACOIMA', 23),
(335, 'VARGAS', 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `packages`
--

CREATE TABLE `packages` (
  `idPackages` int(11) NOT NULL COMMENT 'identificador unico de un paquete de viaje',
  `title` varchar(30) NOT NULL COMMENT 'titulo distintivo del paquete de viaje',
  `description` varchar(200) NOT NULL COMMENT 'decripcion particular del paquete de viajes',
  `transport` varchar(2) NOT NULL COMMENT 'indicador para saber si habra o no habra transporte incluido',
  `food` varchar(2) NOT NULL COMMENT 'indicador para saber si habra o no habra comida incluida',
  `lodging` varchar(2) NOT NULL COMMENT 'indicador para saber si habra o no habra hospedaje incluido',
  `price` float NOT NULL COMMENT 'costo del paquete de viaje',
  `status` varchar(1) NOT NULL COMMENT 'indicador para saber si el paquete de viaje esta habilitado o deshabilitado en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `packages`
--

INSERT INTO `packages` (`idPackages`, `title`, `description`, `transport`, `food`, `lodging`, `price`, `status`) VALUES
(1, 'Escursion', 'Solo ofrece el almuerzo, transporte ida y vuelta y la guia por el sector', 'SI', 'SI', 'NO', 100, '1'),
(2, 'Vip', 'Ofrecemos Las comidad(desayuno, almuerzo y cena más meriendas), viaje ida y vuelta a la puerta de tu casa y alojamiento personal', 'SI', 'SI', 'SI', 1000, '1'),
(3, 'Full finde semana', 'Incluye hospedaje para pasar el fin de semana, las comidas de los dos días, y transporte ida y vuelta al punto de retorno', 'SI', 'SI', 'SI', 1200, '1'),
(4, 'Full simple', 'Te llevamos ida y vuelta a los puntos de retorno, no incluye comida ni hospedaje del viaje', 'SI', 'NO', 'NO', 800, '1'),
(5, 'Simple', 'Vamos ida y vuelta en un viaje corto, para que pases un dia relax, llevmos eel almuerzo', 'SI', 'SI', 'NO', 200, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parroquia`
--

CREATE TABLE `parroquia` (
  `id_p` int(11) NOT NULL COMMENT 'identificador uncio de la parroquia',
  `parroquia` varchar(100) NOT NULL COMMENT 'nombre propio de la parroquia',
  `municipio_id` int(11) NOT NULL COMMENT 'clave foranea que relaciona la parroquia con un municipio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `parroquia`
--

INSERT INTO `parroquia` (`id_p`, `parroquia`, `municipio_id`) VALUES
(1, 'ALTAGRACIA', 1),
(2, 'CANDELARIA', 1),
(3, 'CATEDRAL', 1),
(4, 'LA PASTORA', 1),
(5, 'SAN AGUSTIN', 1),
(6, 'SAN JOSE', 1),
(7, 'SAN JUAN', 1),
(8, 'SANTA ROSALIA', 1),
(9, 'SANTA TERESA', 1),
(10, 'SUCRE', 1),
(11, '23 DE ENERO', 1),
(12, 'ANTIMANO', 1),
(13, 'EL RECREO', 1),
(14, 'EL VALLE', 1),
(15, 'LA VEGA', 1),
(16, 'MACARAO', 1),
(17, 'CARICUAO', 1),
(18, 'EL JUNQUITO', 1),
(19, 'COCHE', 1),
(20, 'SAN PEDRO', 1),
(21, 'SAN BERNARDINO', 1),
(22, 'EL PARAISO', 1),
(23, 'ANACO', 2),
(24, 'SAN JOAQUIN', 2),
(25, 'CM. ARAGUA DE BARCELONA', 3),
(26, 'CACHIPO', 3),
(27, 'EL CARMEN', 4),
(28, 'SAN CRISTOBAL', 4),
(29, 'BERGANTIN', 4),
(30, 'CAIGUA', 4),
(31, 'EL PILAR', 4),
(32, 'NARICUAL', 4),
(33, 'CM. CLARINES', 5),
(34, 'GUANAPE', 5),
(35, 'SABANA DE UCHIRE', 5),
(36, 'CM. ONOTO', 6),
(37, 'SAN PABLO', 6),
(38, 'CM. CANTAURA', 7),
(39, 'LIBERTADOR', 7),
(40, 'SANTA ROSA', 7),
(41, 'URICA', 7),
(42, 'CM. SOLEDAD', 8),
(43, 'MAMO', 8),
(44, 'CM. SAN MATEO', 9),
(45, 'EL CARITO', 9),
(46, 'SANTA INES', 9),
(47, 'CM. PARIAGUAN', 10),
(48, 'ATAPIRIRE', 10),
(49, 'BOCA DEL PAO', 10),
(50, 'EL PAO', 10),
(51, 'CM. MAPIRE', 11),
(52, 'PIAR', 11),
(53, 'SN DIEGO DE CABRUTICA', 11),
(54, 'SANTA CLARA', 11),
(55, 'UVERITO', 11),
(56, 'ZUATA', 11),
(57, 'CM. PUERTO PIRITU', 12),
(58, 'SAN MIGUEL', 12),
(59, 'SUCRE', 12),
(60, 'CM. EL TIGRE', 13),
(61, 'POZUELOS', 14),
(62, 'CM PTO. LA CRUZ', 14),
(63, 'CM. SAN JOSE DE GUANIPA', 15),
(64, 'GUANTA', 16),
(65, 'CHORRERON', 16),
(66, 'PIRITU', 17),
(67, 'SAN FRANCISCO', 17),
(68, 'LECHERIAS', 18),
(69, 'EL MORRO', 18),
(70, 'VALLE GUANAPE', 19),
(71, 'SANTA BARBARA', 19),
(72, 'SANTA ANA', 20),
(73, 'PUEBLO NUEVO', 20),
(74, 'EL CHAPARRO', 21),
(75, 'TOMAS ALFARO CALATRAVA', 21),
(76, 'BOCA UCHIRE', 22),
(77, 'BOCA DE CHAVEZ', 22),
(78, 'ACHAGUAS', 23),
(79, 'APURITO', 23),
(80, 'EL YAGUAL', 23),
(81, 'GUACHARA', 23),
(82, 'MUCURITAS', 23),
(83, 'QUESERAS DEL MEDIO', 23),
(84, 'BRUZUAL', 24),
(85, 'MANTECAL', 24),
(86, 'QUINTERO', 24),
(87, 'SAN VICENTE', 24),
(88, 'RINCON HONDO', 24),
(89, 'GUASDUALITO', 25),
(90, 'ARAMENDI', 25),
(91, 'EL AMPARO', 25),
(92, 'SAN CAMILO', 25),
(93, 'URDANETA', 25),
(94, 'SAN JUAN DE PAYARA', 26),
(95, 'CODAZZI', 26),
(96, 'CUNAVICHE', 26),
(97, 'ELORZA', 27),
(98, 'LA TRINIDAD', 27),
(99, 'SAN FERNANDO', 28),
(100, 'PEÑALVER', 28),
(101, 'EL RECREO', 28),
(102, 'SN RAFAEL DE ATAMAICA', 28),
(103, 'BIRUACA', 29),
(104, 'CM. LAS DELICIAS', 30),
(105, 'CHORONI', 30),
(106, 'MADRE MA DE SAN JOSE', 30),
(107, 'JOAQUIN CRESPO', 30),
(108, 'PEDRO JOSE OVALLES', 30),
(109, 'JOSE CASANOVA GODOY', 30),
(110, 'ANDRES ELOY BLANCO', 30),
(111, 'LOS TACARIGUAS', 30),
(112, 'CM. TURMERO', 31),
(113, 'SAMAN DE GUERE', 31),
(114, 'ALFREDO PACHECO M', 31),
(115, 'CHUAO', 31),
(116, 'AREVALO APONTE', 31),
(117, 'CM. LA VICTORIA', 32),
(118, 'ZUATA', 32),
(119, 'PAO DE ZARATE', 32),
(120, 'CASTOR NIEVES RIOS', 32),
(121, 'LAS GUACAMAYAS', 32),
(122, 'CM. SAN CASIMIRO', 33),
(123, 'VALLE MORIN', 33),
(124, 'GUIRIPA', 33),
(125, 'OLLAS DE CARAMACATE', 33),
(126, 'CM. SAN SEBASTIAN', 34),
(127, 'CM. CAGUA', 35),
(128, 'BELLA VISTA', 35),
(129, 'CM. BARBACOAS', 36),
(130, 'SAN FRANCISCO DE CARA', 36),
(131, 'TAGUAY', 36),
(132, 'LAS PEÑITAS', 36),
(133, 'CM. VILLA DE CURA', 37),
(134, 'MAGDALENO', 37),
(135, 'SAN FRANCISCO DE ASIS', 37),
(136, 'VALLES DE TUCUTUNEMO', 37),
(137, 'PQ AUGUSTO MIJARES', 37),
(138, 'CM. PALO NEGRO', 38),
(139, 'SAN MARTIN DE PORRES', 38),
(140, 'CM. SANTA CRUZ', 39),
(141, 'CM. SAN MATEO', 40),
(142, 'CM. LAS TEJERIAS', 41),
(143, 'TIARA', 41),
(144, 'CM. EL LIMON', 42),
(145, 'CA A DE AZUCAR', 42),
(146, 'CM. COLONIA TOVAR', 43),
(147, 'CM. CAMATAGUA', 44),
(148, 'CARMEN DE CURA', 44),
(149, 'CM. EL CONSEJO', 45),
(150, 'CM. SANTA RITA', 46),
(151, 'FRANCISCO DE MIRANDA', 46),
(152, 'MONS FELICIANO G', 46),
(153, 'OCUMARE DE LA COSTA', 47),
(154, 'ARISMENDI', 48),
(155, 'GUADARRAMA', 48),
(156, 'LA UNION', 48),
(157, 'SAN ANTONIO', 48),
(158, 'ALFREDO A LARRIVA', 49),
(159, 'BARINAS', 49),
(160, 'SAN SILVESTRE', 49),
(161, 'SANTA INES', 49),
(162, 'SANTA LUCIA', 49),
(163, 'TORUNOS', 49),
(164, 'EL CARMEN', 49),
(165, 'ROMULO BETANCOURT', 49),
(166, 'CORAZON DE JESUS', 49),
(167, 'RAMON I MENDEZ', 49),
(168, 'ALTO BARINAS', 49),
(169, 'MANUEL P FAJARDO', 49),
(170, 'JUAN A RODRIGUEZ D', 49),
(171, 'DOMINGA ORTIZ P', 49),
(172, 'ALTAMIRA', 50),
(173, 'BARINITAS', 50),
(174, 'CALDERAS', 50),
(175, 'SANTA BARBARA', 51),
(176, 'JOSE IGNACIO DEL PUMAR', 51),
(177, 'RAMON IGNACIO MENDEZ', 51),
(178, 'PEDRO BRICEÑO MENDEZ', 51),
(179, 'EL REAL', 52),
(180, 'LA LUZ', 52),
(181, 'OBISPOS', 52),
(182, 'LOS GUASIMITOS', 52),
(183, 'CIUDAD BOLIVIA', 53),
(184, 'IGNACIO BRICEÑO', 53),
(185, 'PAEZ', 53),
(186, 'JOSE FELIX RIBAS', 53),
(187, 'DOLORES', 54),
(188, 'LIBERTAD', 54),
(189, 'PALACIO FAJARDO', 54),
(190, 'SANTA ROSA', 54),
(191, 'CIUDAD DE NUTRIAS', 55),
(192, 'EL REGALO', 55),
(193, 'PUERTO DE NUTRIAS', 55),
(194, 'SANTA CATALINA', 55),
(195, 'RODRIGUEZ DOMINGUEZ', 56),
(196, 'SABANETA', 56),
(197, 'TICOPORO', 57),
(198, 'NICOLAS PULIDO', 57),
(199, 'ANDRES BELLO', 57),
(200, 'BARRANCAS', 58),
(201, 'EL SOCORRO', 58),
(202, 'MASPARRITO', 58),
(203, 'EL CANTON', 59),
(204, 'SANTA CRUZ DE GUACAS', 59),
(205, 'PUERTO VIVAS', 59),
(206, 'SIMON BOLIVAR', 60),
(207, 'ONCE DE ABRIL', 60),
(208, 'VISTA AL SOL', 60),
(209, 'CHIRICA', 60),
(210, 'DALLA COSTA', 60),
(211, 'CACHAMAY', 60),
(212, 'UNIVERSIDAD', 60),
(213, 'UNARE', 60),
(214, 'YOCOIMA', 60),
(215, 'POZO VERDE', 60),
(216, 'CM. CAICARA DEL ORINOCO', 61),
(217, 'ASCENSION FARRERAS', 61),
(218, 'ALTAGRACIA', 61),
(219, 'LA URBANA', 61),
(220, 'GUANIAMO', 61),
(221, 'PIJIGUAOS', 61),
(222, 'CATEDRAL', 62),
(223, 'AGUA SALADA', 62),
(224, 'LA SABANITA', 62),
(225, 'VISTA HERMOSA', 62),
(226, 'MARHUANTA', 62),
(227, 'JOSE ANTONIO PAEZ', 62),
(228, 'ORINOCO', 62),
(229, 'PANAPANA', 62),
(230, 'ZEA', 62),
(231, 'CM. UPATA', 63),
(232, 'ANDRES ELOY BLANCO', 63),
(233, 'PEDRO COVA', 63),
(234, 'CM. GUASIPATI', 64),
(235, 'SALOM', 64),
(236, 'CM. MARIPA', 65),
(237, 'ARIPAO', 65),
(238, 'LAS MAJADAS', 65),
(239, 'MOITACO', 65),
(240, 'GUARATARO', 65),
(241, 'CM. TUMEREMO', 66),
(242, 'DALLA COSTA', 66),
(243, 'SAN ISIDRO', 66),
(244, 'CM. CIUDAD PIAR', 67),
(245, 'SAN FRANCISCO', 67),
(246, 'BARCELONETA', 67),
(247, 'SANTA BARBARA', 67),
(248, 'CM. SANTA ELENA DE UAIREN', 68),
(249, 'IKABARU', 68),
(250, 'CM. EL CALLAO', 69),
(251, 'CM. EL PALMAR', 70),
(252, 'BEJUMA', 71),
(253, 'CANOABO', 71),
(254, 'SIMON BOLIVAR', 71),
(255, 'GUIGUE', 72),
(256, 'BELEN', 72),
(257, 'TACARIGUA', 72),
(258, 'MARIARA', 73),
(259, 'AGUAS CALIENTES', 73),
(260, 'GUACARA', 74),
(261, 'CIUDAD ALIANZA', 74),
(262, 'YAGUA', 74),
(263, 'MONTALBAN', 75),
(264, 'MORON', 76),
(265, 'URAMA', 76),
(266, 'DEMOCRACIA', 77),
(267, 'FRATERNIDAD', 77),
(268, 'GOAIGOAZA', 77),
(269, 'JUAN JOSE FLORES', 77),
(270, 'BARTOLOME SALOM', 77),
(271, 'UNION', 77),
(272, 'BORBURATA', 77),
(273, 'PATANEMO', 77),
(274, 'SAN JOAQUIN', 78),
(275, 'CANDELARIA', 79),
(276, 'CATEDRAL', 79),
(277, 'EL SOCORRO', 79),
(278, 'MIGUEL PEÑA', 79),
(279, 'SAN BLAS', 79),
(280, 'SAN JOSE', 79),
(281, 'SANTA ROSA', 79),
(282, 'RAFAEL URDANETA', 79),
(283, 'NEGRO PRIMERO', 79),
(284, 'MIRANDA', 80),
(285, 'U LOS GUAYOS', 81),
(286, 'NAGUANAGUA', 82),
(287, 'URB SAN DIEGO', 83),
(288, 'U TOCUYITO', 84),
(289, 'U INDEPENDENCIA', 84),
(290, 'COJEDES', 85),
(291, 'JUAN DE MATA SUAREZ', 85),
(292, 'TINAQUILLO', 86),
(293, 'EL BAUL', 87),
(294, 'SUCRE', 87),
(295, 'EL PAO', 88),
(296, 'LIBERTAD DE COJEDES', 89),
(297, 'EL AMPARO', 89),
(298, 'SAN CARLOS DE AUSTRIA', 90),
(299, 'JUAN ANGEL BRAVO', 90),
(300, 'MANUEL MANRIQUE', 90),
(301, 'GRL/JEFE JOSE L SILVA', 91),
(302, 'MACAPO', 92),
(303, 'LA AGUADITA', 92),
(304, 'ROMULO GALLEGOS', 93),
(305, 'SAN JUAN DE LOS CAYOS', 94),
(306, 'CAPADARE', 94),
(307, 'LA PASTORA', 94),
(308, 'LIBERTADOR', 94),
(309, 'SAN LUIS', 95),
(310, 'ARACUA', 95),
(311, 'LA PEÑA', 95),
(312, 'CAPATARIDA', 96),
(313, 'BOROJO', 96),
(314, 'SEQUE', 96),
(315, 'ZAZARIDA', 96),
(316, 'BARIRO', 96),
(317, 'GUAJIRO', 96),
(318, 'NORTE', 97),
(319, 'CARIRUBANA', 97),
(320, 'PUNTA CARDON', 97),
(321, 'SANTA ANA', 97),
(322, 'LA VELA DE CORO', 98),
(323, 'ACURIGUA', 98),
(324, 'GUAIBACOA', 98),
(325, 'MACORUCA', 98),
(326, 'LAS CALDERAS', 98),
(327, 'PEDREGAL', 99),
(328, 'AGUA CLARA', 99),
(329, 'AVARIA', 99),
(330, 'PIEDRA GRANDE', 99),
(331, 'PURURECHE', 99),
(332, 'PUEBLO NUEVO', 100),
(333, 'ADICORA', 100),
(334, 'BARAIVED', 100),
(335, 'BUENA VISTA', 100),
(336, 'JADACAQUIVA', 100),
(337, 'MORUY', 100),
(338, 'EL VINCULO', 100),
(339, 'EL HATO', 100),
(340, 'ADAURE', 100),
(341, 'CHURUGUARA', 101),
(342, 'AGUA LARGA', 101),
(343, 'INDEPENDENCIA', 101),
(344, 'MAPARARI', 101),
(345, 'EL PAUJI', 101),
(346, 'MENE DE MAUROA', 102),
(347, 'CASIGUA', 102),
(348, 'SAN FELIX', 102),
(349, 'SAN ANTONIO', 103),
(350, 'SAN GABRIEL', 103),
(351, 'SANTA ANA', 103),
(352, 'GUZMAN GUILLERMO', 103),
(353, 'MITARE', 103),
(354, 'SABANETA', 103),
(355, 'RIO SECO', 103),
(356, 'CABURE', 104),
(357, 'CURIMAGUA', 104),
(358, 'COLINA', 104),
(359, 'TUCACAS', 105),
(360, 'BOCA DE AROA', 105),
(361, 'PUERTO CUMAREBO', 106),
(362, 'LA CIENAGA', 106),
(363, 'LA SOLEDAD', 106),
(364, 'PUEBLO CUMAREBO', 106),
(365, 'ZAZARIDA', 106),
(366, 'CM. DABAJURO', 107),
(367, 'CHICHIRIVICHE', 108),
(368, 'BOCA DE TOCUYO', 108),
(369, 'TOCUYO DE LA COSTA', 108),
(370, 'LOS TAQUES', 109),
(371, 'JUDIBANA', 109),
(372, 'PIRITU', 110),
(373, 'SAN JOSE DE LA COSTA', 110),
(374, 'STA.CRUZ DE BUCARAL', 111),
(375, 'EL CHARAL', 111),
(376, 'LAS VEGAS DEL TUY', 111),
(377, 'CM. MIRIMIRE', 112),
(378, 'JACURA', 113),
(379, 'AGUA LINDA', 113),
(380, 'ARAURIMA', 113),
(381, 'CM. YARACAL', 114),
(382, 'CM. PALMA SOLA', 115),
(383, 'SUCRE', 116),
(384, 'PECAYA', 116),
(385, 'URUMACO', 117),
(386, 'BRUZUAL', 117),
(387, 'CM. TOCOPERO', 118),
(388, 'VALLE DE LA PASCUA', 119),
(389, 'ESPINO', 119),
(390, 'EL SOMBRERO', 120),
(391, 'SOSA', 120),
(392, 'CALABOZO', 121),
(393, 'EL CALVARIO', 121),
(394, 'EL RASTRO', 121),
(395, 'GUARDATINAJAS', 121),
(396, 'ALTAGRACIA DE ORITUCO', 122),
(397, 'LEZAMA', 122),
(398, 'LIBERTAD DE ORITUCO', 122),
(399, 'SAN FCO DE MACAIRA', 122),
(400, 'SAN RAFAEL DE ORITUCO', 122),
(401, 'SOUBLETTE', 122),
(402, 'PASO REAL DE MACAIRA', 122),
(403, 'TUCUPIDO', 123),
(404, 'SAN RAFAEL DE LAYA', 123),
(405, 'SAN JUAN DE LOS MORROS', 124),
(406, 'PARAPARA', 124),
(407, 'CANTAGALLO', 124),
(408, 'ZARAZA', 125),
(409, 'SAN JOSE DE UNARE', 125),
(410, 'CAMAGUAN', 126),
(411, 'PUERTO MIRANDA', 126),
(412, 'UVERITO', 126),
(413, 'SAN JOSE DE GUARIBE', 127),
(414, 'LAS MERCEDES', 128),
(415, 'STA RITA DE MANAPIRE', 128),
(416, 'CABRUTA', 128),
(417, 'EL SOCORRO', 129),
(418, 'ORTIZ', 130),
(419, 'SAN FCO. DE TIZNADOS', 130),
(420, 'SAN JOSE DE TIZNADOS', 130),
(421, 'S LORENZO DE TIZNADOS', 130),
(422, 'SANTA MARIA DE IPIRE', 131),
(423, 'ALTAMIRA', 131),
(424, 'CHAGUARAMAS', 132),
(425, 'GUAYABAL', 133),
(426, 'CAZORLA', 133),
(427, 'FREITEZ', 134),
(428, 'JOSE MARIA BLANCO', 134),
(429, 'CATEDRAL', 135),
(430, 'LA CONCEPCION', 135),
(431, 'SANTA ROSA', 135),
(432, 'UNION', 135),
(433, 'EL CUJI', 135),
(434, 'TAMACA', 135),
(435, 'JUAN DE VILLEGAS', 135),
(436, 'AGUEDO F. ALVARADO', 135),
(437, 'BUENA VISTA', 135),
(438, 'JUAREZ', 135),
(439, 'JUAN B RODRIGUEZ', 136),
(440, 'DIEGO DE LOZADA', 136),
(441, 'SAN MIGUEL', 136),
(442, 'CUARA', 136),
(443, 'PARAISO DE SAN JOSE', 136),
(444, 'TINTORERO', 136),
(445, 'JOSE BERNARDO DORANTE', 136),
(446, 'CRNEL. MARIANO PERAZA', 136),
(447, 'BOLIVAR', 137),
(448, 'ANZOATEGUI', 137),
(449, 'GUARICO', 137),
(450, 'HUMOCARO ALTO', 137),
(451, 'HUMOCARO BAJO', 137),
(452, 'MORAN', 137),
(453, 'HILARIO LUNA Y LUNA', 137),
(454, 'LA CANDELARIA', 137),
(455, 'CABUDARE', 138),
(456, 'JOSE G. BASTIDAS', 138),
(457, 'AGUA VIVA', 138),
(458, 'TRINIDAD SAMUEL', 139),
(459, 'ANTONIO DIAZ', 139),
(460, 'CAMACARO', 139),
(461, 'CASTAÑEDA', 139),
(462, 'CHIQUINQUIRA', 139),
(463, 'ESPINOZA LOS MONTEROS', 139),
(464, 'LARA', 139),
(465, 'MANUEL MORILLO', 139),
(466, 'MONTES DE OCA', 139),
(467, 'TORRES', 139),
(468, 'EL BLANCO', 139),
(469, 'MONTA A VERDE', 139),
(470, 'HERIBERTO ARROYO', 139),
(471, 'LAS MERCEDES', 139),
(472, 'CECILIO ZUBILLAGA', 139),
(473, 'REYES VARGAS', 139),
(474, 'ALTAGRACIA', 139),
(475, 'SIQUISIQUE', 140),
(476, 'SAN MIGUEL', 140),
(477, 'XAGUAS', 140),
(478, 'MOROTURO', 140),
(479, 'PIO TAMAYO', 141),
(480, 'YACAMBU', 141),
(481, 'QBDA. HONDA DE GUACHE', 141),
(482, 'SARARE', 142),
(483, 'GUSTAVO VEGAS LEON', 142),
(484, 'BURIA', 142),
(485, 'GABRIEL PICON G.', 143),
(486, 'HECTOR AMABLE MORA', 143),
(487, 'JOSE NUCETE SARDI', 143),
(488, 'PULIDO MENDEZ', 143),
(489, 'PTE. ROMULO GALLEGOS', 143),
(490, 'PRESIDENTE BETANCOURT', 143),
(491, 'PRESIDENTE PAEZ', 143),
(492, 'CM. LA AZULITA', 144),
(493, 'CM. CANAGUA', 145),
(494, 'CAPURI', 145),
(495, 'CHACANTA', 145),
(496, 'EL MOLINO', 145),
(497, 'GUAIMARAL', 145),
(498, 'MUCUTUY', 145),
(499, 'MUCUCHACHI', 145),
(500, 'ACEQUIAS', 146),
(501, 'JAJI', 146),
(502, 'LA MESA', 146),
(503, 'SAN JOSE', 146),
(504, 'MONTALBAN', 146),
(505, 'MATRIZ', 146),
(506, 'FERNANDEZ PEÑA', 146),
(507, 'CM. GUARAQUE', 147),
(508, 'MESA DE QUINTERO', 147),
(509, 'RIO NEGRO', 147),
(510, 'CM. ARAPUEY', 148),
(511, 'PALMIRA', 148),
(512, 'CM. TORONDOY', 149),
(513, 'SAN CRISTOBAL DE T', 149),
(514, 'ARIAS', 150),
(515, 'SAGRARIO', 150),
(516, 'MILLA', 150),
(517, 'EL LLANO', 150),
(518, 'JUAN RODRIGUEZ SUAREZ', 150),
(519, 'JACINTO PLAZA', 150),
(520, 'DOMINGO PEÑA', 150),
(521, 'GONZALO PICON FEBRES', 150),
(522, 'OSUNA RODRIGUEZ', 150),
(523, 'LASSO DE LA VEGA', 150),
(524, 'CARACCIOLO PARRA P', 150),
(525, 'MARIANO PICON SALAS', 150),
(526, 'ANTONIO SPINETTI DINI', 150),
(527, 'EL MORRO', 150),
(528, 'LOS NEVADOS', 150),
(529, 'CM. TABAY', 151),
(530, 'CM. TIMOTES', 152),
(531, 'ANDRES ELOY BLANCO', 152),
(532, 'PIÑANGO', 152),
(533, 'LA VENTA', 152),
(534, 'CM. STA CRUZ DE MORA', 153),
(535, 'MESA BOLIVAR', 153),
(536, 'MESA DE LAS PALMAS', 153),
(537, 'CM. STA ELENA DE ARENALES', 154),
(538, 'ELOY PAREDES', 154),
(539, 'PQ R DE ALCAZAR', 154),
(540, 'CM. TUCANI', 155),
(541, 'FLORENCIO RAMIREZ', 155),
(542, 'CM. SANTO DOMINGO', 156),
(543, 'LAS PIEDRAS', 156),
(544, 'CM. PUEBLO LLANO', 157),
(545, 'CM. MUCUCHIES', 158),
(546, 'MUCURUBA', 158),
(547, 'SAN RAFAEL', 158),
(548, 'CACUTE', 158),
(549, 'LA TOMA', 158),
(550, 'CM. BAILADORES', 159),
(551, 'GERONIMO MALDONADO', 159),
(552, 'CM. LAGUNILLAS', 160),
(553, 'CHIGUARA', 160),
(554, 'ESTANQUES', 160),
(555, 'SAN JUAN', 160),
(556, 'PUEBLO NUEVO DEL SUR', 160),
(557, 'LA TRAMPA', 160),
(558, 'EL LLANO', 161),
(559, 'TOVAR', 161),
(560, 'EL AMPARO', 161),
(561, 'SAN FRANCISCO', 161),
(562, 'CM. NUEVA BOLIVIA', 162),
(563, 'INDEPENDENCIA', 162),
(564, 'MARIA C PALACIOS', 162),
(565, 'SANTA APOLONIA', 162),
(566, 'CM. STA MARIA DE CAPARO', 163),
(567, 'CM. ARICAGUA', 164),
(568, 'SAN ANTONIO', 164),
(569, 'CM. ZEA', 165),
(570, 'CAÑO EL TIGRE', 165),
(571, 'CAUCAGUA', 166),
(572, 'ARAGUITA', 166),
(573, 'AREVALO GONZALEZ', 166),
(574, 'CAPAYA', 166),
(575, 'PANAQUIRE', 166),
(576, 'RIBAS', 166),
(577, 'EL CAFE', 166),
(578, 'MARIZAPA', 166),
(579, 'HIGUEROTE', 167),
(580, 'CURIEPE', 167),
(581, 'TACARIGUA', 167),
(582, 'LOS TEQUES', 168),
(583, 'CECILIO ACOSTA', 168),
(584, 'PARACOTOS', 168),
(585, 'SAN PEDRO', 168),
(586, 'TACATA', 168),
(587, 'EL JARILLO', 168),
(588, 'ALTAGRACIA DE LA M', 168),
(589, 'STA TERESA DEL TUY', 169),
(590, 'EL CARTANAL', 169),
(591, 'OCUMARE DEL TUY', 170),
(592, 'LA DEMOCRACIA', 170),
(593, 'SANTA BARBARA', 170),
(594, 'RIO CHICO', 171),
(595, 'EL GUAPO', 171),
(596, 'TACARIGUA DE LA LAGUNA', 171),
(597, 'PAPARO', 171),
(598, 'SN FERNANDO DEL GUAPO', 171),
(599, 'SANTA LUCIA', 172),
(600, 'GUARENAS', 173),
(601, 'PETARE', 174),
(602, 'LEONCIO MARTINEZ', 174),
(603, 'CAUCAGUITA', 174),
(604, 'FILAS DE MARICHES', 174),
(605, 'LA DOLORITA', 174),
(606, 'CUA', 175),
(607, 'NUEVA CUA', 175),
(608, 'GUATIRE', 176),
(609, 'BOLIVAR', 176),
(610, 'CHARALLAVE', 177),
(611, 'LAS BRISAS', 177),
(612, 'SAN ANTONIO LOS ALTOS', 178),
(613, 'SAN JOSE DE BARLOVENTO', 179),
(614, 'CUMBO', 179),
(615, 'SAN FCO DE YARE', 180),
(616, 'S ANTONIO DE YARE', 180),
(617, 'BARUTA', 181),
(618, 'EL CAFETAL', 181),
(619, 'LAS MINAS DE BARUTA', 181),
(620, 'CARRIZAL', 182),
(621, 'CHACAO', 183),
(622, 'EL HATILLO', 184),
(623, 'MAMPORAL', 185),
(624, 'CUPIRA', 186),
(625, 'MACHURUCUTO', 186),
(626, 'CM. SAN ANTONIO', 187),
(627, 'SAN FRANCISCO', 187),
(628, 'CM. CARIPITO', 188),
(629, 'CM. CARIPE', 189),
(630, 'TERESEN', 189),
(631, 'EL GUACHARO', 189),
(632, 'SAN AGUSTIN', 189),
(633, 'LA GUANOTA', 189),
(634, 'SABANA DE PIEDRA', 189),
(635, 'CM. CAICARA', 190),
(636, 'AREO', 190),
(637, 'SAN FELIX', 190),
(638, 'VIENTO FRESCO', 190),
(639, 'CM. PUNTA DE MATA', 191),
(640, 'EL TEJERO', 191),
(641, 'CM. TEMBLADOR', 192),
(642, 'TABASCA', 192),
(643, 'LAS ALHUACAS', 192),
(644, 'CHAGUARAMAS', 192),
(645, 'EL FURRIAL', 193),
(646, 'JUSEPIN', 193),
(647, 'EL COROZO', 193),
(648, 'SAN VICENTE', 193),
(649, 'LA PICA', 193),
(650, 'ALTO DE LOS GODOS', 193),
(651, 'BOQUERON', 193),
(652, 'LAS COCUIZAS', 193),
(653, 'SANTA CRUZ', 193),
(654, 'SAN SIMON', 193),
(655, 'CM. ARAGUA', 194),
(656, 'CHAGUARAMAL', 194),
(657, 'GUANAGUANA', 194),
(658, 'APARICIO', 194),
(659, 'TAGUAYA', 194),
(660, 'EL PINTO', 194),
(661, 'LA TOSCANA', 194),
(662, 'CM. QUIRIQUIRE', 195),
(663, 'CACHIPO', 195),
(664, 'CM. BARRANCAS', 196),
(665, 'LOS BARRANCOS DE FAJARDO', 196),
(666, 'CM. AGUASAY', 197),
(667, 'CM. SANTA BARBARA', 198),
(668, 'CM. URACOA', 199),
(669, 'CM. LA ASUNCION', 200),
(670, 'CM. SAN JUAN BAUTISTA', 201),
(671, 'ZABALA', 201),
(672, 'CM. SANTA ANA', 202),
(673, 'GUEVARA', 202),
(674, 'MATASIETE', 202),
(675, 'BOLIVAR', 202),
(676, 'SUCRE', 202),
(677, 'CM. PAMPATAR', 203),
(678, 'AGUIRRE', 203),
(679, 'CM. JUAN GRIEGO', 204),
(680, 'ADRIAN', 204),
(681, 'CM. PORLAMAR', 205),
(682, 'CM. BOCA DEL RIO', 206),
(683, 'SAN FRANCISCO', 206),
(684, 'CM. SAN PEDRO DE COCHE', 207),
(685, 'VICENTE FUENTES', 207),
(686, 'CM. PUNTA DE PIEDRAS', 208),
(687, 'LOS BARALES', 208),
(688, 'CM.LA PLAZA DE PARAGUACHI', 209),
(689, 'CM. VALLE ESP SANTO', 210),
(690, 'FRANCISCO FAJARDO', 210),
(691, 'CM. ARAURE', 211),
(692, 'RIO ACARIGUA', 211),
(693, 'CM. PIRITU', 212),
(694, 'UVERAL', 212),
(695, 'CM. GUANARE', 213),
(696, 'CORDOBA', 213),
(697, 'SAN JUAN GUANAGUANARE', 213),
(698, 'VIRGEN DE LA COROMOTO', 213),
(699, 'SAN JOSE DE LA MONTAÑA', 213),
(700, 'CM. GUANARITO', 214),
(701, 'TRINIDAD DE LA CAPILLA', 214),
(702, 'DIVINA PASTORA', 214),
(703, 'CM. OSPINO', 215),
(704, 'APARICION', 215),
(705, 'LA ESTACION', 215),
(706, 'CM. ACARIGUA', 216),
(707, 'PAYARA', 216),
(708, 'PIMPINELA', 216),
(709, 'RAMON PERAZA', 216),
(710, 'CM. BISCUCUY', 217),
(711, 'CONCEPCION', 217),
(712, 'SAN RAFAEL PALO ALZADO', 217),
(713, 'UVENCIO A VELASQUEZ', 217),
(714, 'SAN JOSE DE SAGUAZ', 217),
(715, 'VILLA ROSA', 217),
(716, 'CM. VILLA BRUZUAL', 218),
(717, 'CANELONES', 218),
(718, 'SANTA CRUZ', 218),
(719, 'SAN ISIDRO LABRADOR', 218),
(720, 'CM. CHABASQUEN', 219),
(721, 'PEÑA BLANCA', 219),
(722, 'CM. AGUA BLANCA', 220),
(723, 'CM. PAPELON', 221),
(724, 'CAÑO DELGADITO', 221),
(725, 'CM. BOCONOITO', 222),
(726, 'ANTOLIN TOVAR AQUINO', 222),
(727, 'CM. SAN RAFAEL DE ONOTO', 223),
(728, 'SANTA FE', 223),
(729, 'THERMO MORLES', 223),
(730, 'CM. EL PLAYON', 224),
(731, 'FLORIDA', 224),
(732, 'RIO CARIBE', 225),
(733, 'SAN JUAN GALDONAS', 225),
(734, 'PUERTO SANTO', 225),
(735, 'EL MORRO DE PTO SANTO', 225),
(736, 'ANTONIO JOSE DE SUCRE', 225),
(737, 'EL PILAR', 226),
(738, 'EL RINCON', 226),
(739, 'GUARAUNOS', 226),
(740, 'TUNAPUICITO', 226),
(741, 'UNION', 226),
(742, 'GRAL FCO. A VASQUEZ', 226),
(743, 'SANTA CATALINA', 227),
(744, 'SANTA ROSA', 227),
(745, 'SANTA TERESA', 227),
(746, 'BOLIVAR', 227),
(747, 'MACARAPANA', 227),
(748, 'YAGUARAPARO', 228),
(749, 'LIBERTAD', 228),
(750, 'PAUJIL', 228),
(751, 'IRAPA', 229),
(752, 'CAMPO CLARO', 229),
(753, 'SORO', 229),
(754, 'SAN ANTONIO DE IRAPA', 229),
(755, 'MARABAL', 229),
(756, 'CM. SAN ANT DEL GOLFO', 230),
(757, 'CUMANACOA', 231),
(758, 'ARENAS', 231),
(759, 'ARICAGUA', 231),
(760, 'COCOLLAR', 231),
(761, 'SAN FERNANDO', 231),
(762, 'SAN LORENZO', 231),
(763, 'CARIACO', 232),
(764, 'CATUARO', 232),
(765, 'RENDON', 232),
(766, 'SANTA CRUZ', 232),
(767, 'SANTA MARIA', 232),
(768, 'ALTAGRACIA', 233),
(769, 'AYACUCHO', 233),
(770, 'SANTA INES', 233),
(771, 'VALENTIN VALIENTE', 233),
(772, 'SAN JUAN', 233),
(773, 'GRAN MARISCAL', 233),
(774, 'RAUL LEONI', 233),
(775, 'GUIRIA', 234),
(776, 'CRISTOBAL COLON', 234),
(777, 'PUNTA DE PIEDRA', 234),
(778, 'BIDEAU', 234),
(779, 'MARIÑO', 235),
(780, 'ROMULO GALLEGOS', 235),
(781, 'TUNAPUY', 236),
(782, 'CAMPO ELIAS', 236),
(783, 'SAN JOSE DE AREOCUAR', 237),
(784, 'TAVERA ACOSTA', 237),
(785, 'CM. MARIGUITAR', 238),
(786, 'ARAYA', 239),
(787, 'MANICUARE', 239),
(788, 'CHACOPATA', 239),
(789, 'CM. COLON', 240),
(790, 'RIVAS BERTI', 240),
(791, 'SAN PEDRO DEL RIO', 240),
(792, 'CM. SAN ANT DEL TACHIRA', 241),
(793, 'PALOTAL', 241),
(794, 'JUAN VICENTE GOMEZ', 241),
(795, 'ISAIAS MEDINA ANGARIT', 241),
(796, 'CM. CAPACHO NUEVO', 242),
(797, 'JUAN GERMAN ROSCIO', 242),
(798, 'ROMAN CARDENAS', 242),
(799, 'CM. TARIBA', 243),
(800, 'LA FLORIDA', 243),
(801, 'AMENODORO RANGEL LAMU', 243),
(802, 'CM. LA GRITA', 244),
(803, 'EMILIO C. GUERRERO', 244),
(804, 'MONS. MIGUEL A SALAS', 244),
(805, 'CM. RUBIO', 245),
(806, 'BRAMON', 245),
(807, 'LA PETROLEA', 245),
(808, 'QUINIMARI', 245),
(809, 'CM. LOBATERA', 246),
(810, 'CONSTITUCION', 246),
(811, 'LA CONCORDIA', 247),
(812, 'PEDRO MARIA MORANTES', 247),
(813, 'SN JUAN BAUTISTA', 247),
(814, 'SAN SEBASTIAN', 247),
(815, 'DR. FCO. ROMERO LOBO', 247),
(816, 'CM. PREGONERO', 248),
(817, 'CARDENAS', 248),
(818, 'POTOSI', 248),
(819, 'JUAN PABLO PEÑALOZA', 248),
(820, 'CM. STA. ANA  DEL TACHIRA', 249),
(821, 'CM. LA FRIA', 250),
(822, 'BOCA DE GRITA', 250),
(823, 'JOSE ANTONIO PAEZ', 250),
(824, 'CM. PALMIRA', 251),
(825, 'CM. MICHELENA', 252),
(826, 'CM. ABEJALES', 253),
(827, 'SAN JOAQUIN DE NAVAY', 253),
(828, 'DORADAS', 253),
(829, 'EMETERIO OCHOA', 253),
(830, 'CM. COLONCITO', 254),
(831, 'LA PALMITA', 254),
(832, 'CM. UREÑA', 255),
(833, 'NUEVA ARCADIA', 255),
(834, 'CM. QUENIQUEA', 256),
(835, 'SAN PABLO', 256),
(836, 'ELEAZAR LOPEZ CONTRERA', 256),
(837, 'CM. CORDERO', 257),
(838, 'CM.SAN RAFAEL DEL PINAL', 258),
(839, 'SANTO DOMINGO', 258),
(840, 'ALBERTO ADRIANI', 258),
(841, 'CM. CAPACHO VIEJO', 259),
(842, 'CIPRIANO CASTRO', 259),
(843, 'MANUEL FELIPE RUGELES', 259),
(844, 'CM. LA TENDIDA', 260),
(845, 'BOCONO', 260),
(846, 'HERNANDEZ', 260),
(847, 'CM. SEBORUCO', 261),
(848, 'CM. LAS MESAS', 262),
(849, 'CM. SAN JOSE DE BOLIVAR', 263),
(850, 'CM. EL COBRE', 264),
(851, 'CM. DELICIAS', 265),
(852, 'CM. SAN SIMON', 266),
(853, 'CM. SAN JOSECITO', 267),
(854, 'CM. UMUQUENA', 268),
(855, 'BETIJOQUE', 269),
(856, 'JOSE G HERNANDEZ', 269),
(857, 'LA PUEBLITA', 269),
(858, 'EL CEDRO', 269),
(859, 'BOCONO', 270),
(860, 'EL CARMEN', 270),
(861, 'MOSQUEY', 270),
(862, 'AYACUCHO', 270),
(863, 'BURBUSAY', 270),
(864, 'GENERAL RIVAS', 270),
(865, 'MONSEÑOR JAUREGUI', 270),
(866, 'RAFAEL RANGEL', 270),
(867, 'SAN JOSE', 270),
(868, 'SAN MIGUEL', 270),
(869, 'GUARAMACAL', 270),
(870, 'LA VEGA DE GUARAMACAL', 270),
(871, 'CARACHE', 271),
(872, 'LA CONCEPCION', 271),
(873, 'CUICAS', 271),
(874, 'PANAMERICANA', 271),
(875, 'SANTA CRUZ', 271),
(876, 'ESCUQUE', 272),
(877, 'SABANA LIBRE', 272),
(878, 'LA UNION', 272),
(879, 'SANTA RITA', 272),
(880, 'CRISTOBAL MENDOZA', 273),
(881, 'CHIQUINQUIRA', 273),
(882, 'MATRIZ', 273),
(883, 'MONSEÑOR CARRILLO', 273),
(884, 'CRUZ CARRILLO', 273),
(885, 'ANDRES LINARES', 273),
(886, 'TRES ESQUINAS', 273),
(887, 'LA QUEBRADA', 274),
(888, 'JAJO', 274),
(889, 'LA MESA', 274),
(890, 'SANTIAGO', 274),
(891, 'CABIMBU', 274),
(892, 'TUÑAME', 274),
(893, 'MERCEDES DIAZ', 275),
(894, 'JUAN IGNACIO MONTILLA', 275),
(895, 'LA BEATRIZ', 275),
(896, 'MENDOZA', 275),
(897, 'LA PUERTA', 275),
(898, 'SAN LUIS', 275),
(899, 'CHEJENDE', 276),
(900, 'CARRILLO', 276),
(901, 'CEGARRA', 276),
(902, 'BOLIVIA', 276),
(903, 'MANUEL SALVADOR ULLOA', 276),
(904, 'SAN JOSE', 276),
(905, 'ARNOLDO GABALDON', 276),
(906, 'EL DIVIDIVE', 277),
(907, 'AGUA CALIENTE', 277),
(908, 'EL CENIZO', 277),
(909, 'AGUA SANTA', 277),
(910, 'VALERITA', 277),
(911, 'MONTE CARMELO', 278),
(912, 'BUENA VISTA', 278),
(913, 'STA MARIA DEL HORCON', 278),
(914, 'MOTATAN', 279),
(915, 'EL BAÑO', 279),
(916, 'JALISCO', 279),
(917, 'PAMPAN', 280),
(918, 'SANTA ANA', 280),
(919, 'LA PAZ', 280),
(920, 'FLOR DE PATRIA', 280),
(921, 'CARVAJAL', 281),
(922, 'ANTONIO N BRICEÑO', 281),
(923, 'CAMPO ALEGRE', 281),
(924, 'JOSE LEONARDO SUAREZ', 281),
(925, 'SABANA DE MENDOZA', 282),
(926, 'JUNIN', 282),
(927, 'VALMORE RODRIGUEZ', 282),
(928, 'EL PARAISO', 282),
(929, 'SANTA ISABEL', 283),
(930, 'ARAGUANEY', 283),
(931, 'EL JAGUITO', 283),
(932, 'LA ESPERANZA', 283),
(933, 'SABANA GRANDE', 284),
(934, 'CHEREGUE', 284),
(935, 'GRANADOS', 284),
(936, 'EL SOCORRO', 285),
(937, 'LOS CAPRICHOS', 285),
(938, 'ANTONIO JOSE DE SUCRE', 285),
(939, 'CAMPO ELIAS', 286),
(940, 'ARNOLDO GABALDON', 286),
(941, 'SANTA APOLONIA', 287),
(942, 'LA CEIBA', 287),
(943, 'EL PROGRESO', 287),
(944, 'TRES DE FEBRERO', 287),
(945, 'PAMPANITO', 288),
(946, 'PAMPANITO II', 288),
(947, 'LA CONCEPCION', 288),
(948, 'CM. AROA', 289),
(949, 'CM. CHIVACOA', 290),
(950, 'CAMPO ELIAS', 290),
(951, 'CM. NIRGUA', 291),
(952, 'SALOM', 291),
(953, 'TEMERLA', 291),
(954, 'CM. SAN FELIPE', 292),
(955, 'ALBARICO', 292),
(956, 'SAN JAVIER', 292),
(957, 'CM. GUAMA', 293),
(958, 'CM. URACHICHE', 294),
(959, 'CM. YARITAGUA', 295),
(960, 'SAN ANDRES', 295),
(961, 'CM. SABANA DE PARRA', 296),
(962, 'CM. BORAURE', 297),
(963, 'CM. COCOROTE', 298),
(964, 'CM. INDEPENDENCIA', 299),
(965, 'CM. SAN PABLO', 300),
(966, 'CM. YUMARE', 301),
(967, 'CM. FARRIAR', 302),
(968, 'EL GUAYABO', 302),
(969, 'GENERAL URDANETA', 303),
(970, 'LIBERTADOR', 303),
(971, 'MANUEL GUANIPA MATOS', 303),
(972, 'MARCELINO BRICEÑO', 303),
(973, 'SAN TIMOTEO', 303),
(974, 'PUEBLO NUEVO', 303),
(975, 'PEDRO LUCAS URRIBARRI', 304),
(976, 'SANTA RITA', 304),
(977, 'JOSE CENOVIO URRIBARR', 304),
(978, 'EL MENE', 304),
(979, 'SANTA CRUZ DEL ZULIA', 305),
(980, 'URRIBARRI', 305),
(981, 'MORALITO', 305),
(982, 'SAN CARLOS DEL ZULIA', 305),
(983, 'SANTA BARBARA', 305),
(984, 'LUIS DE VICENTE', 306),
(985, 'RICAURTE', 306),
(986, 'MONS.MARCOS SERGIO G', 306),
(987, 'SAN RAFAEL', 306),
(988, 'LAS PARCELAS', 306),
(989, 'TAMARE', 306),
(990, 'LA SIERRITA', 306),
(991, 'BOLIVAR', 307),
(992, 'COQUIVACOA', 307),
(993, 'CRISTO DE ARANZA', 307),
(994, 'CHIQUINQUIRA', 307),
(995, 'SANTA LUCIA', 307),
(996, 'OLEGARIO VILLALOBOS', 307),
(997, 'JUANA DE AVILA', 307),
(998, 'CARACCIOLO PARRA PEREZ', 307),
(999, 'IDELFONZO VASQUEZ', 307),
(1000, 'CACIQUE MARA', 307),
(1001, 'CECILIO ACOSTA', 307),
(1002, 'RAUL LEONI', 307),
(1003, 'FRANCISCO EUGENIO B', 307),
(1004, 'MANUEL DAGNINO', 307),
(1005, 'LUIS HURTADO HIGUERA', 307),
(1006, 'VENANCIO PULGAR', 307),
(1007, 'ANTONIO BORJAS ROMERO', 307),
(1008, 'SAN ISIDRO', 307),
(1009, 'FARIA', 308),
(1010, 'SAN ANTONIO', 308),
(1011, 'ANA MARIA CAMPOS', 308),
(1012, 'SAN JOSE', 308),
(1013, 'ALTAGRACIA', 308),
(1014, 'GOAJIRA', 309),
(1015, 'ELIAS SANCHEZ RUBIO', 309),
(1016, 'SINAMAICA', 309),
(1017, 'ALTA GUAJIRA', 309),
(1018, 'SAN JOSE DE PERIJA', 310),
(1019, 'BARTOLOME DE LAS CASAS', 310),
(1020, 'LIBERTAD', 310),
(1021, 'RIO NEGRO', 310),
(1022, 'GIBRALTAR', 311),
(1023, 'HERAS', 311),
(1024, 'M.ARTURO CELESTINO A', 311),
(1025, 'ROMULO GALLEGOS', 311),
(1026, 'BOBURES', 311),
(1027, 'EL BATEY', 311),
(1028, 'ANDRES BELLO (KM 48)', 312),
(1029, 'POTRERITOS', 312),
(1030, 'EL CARMELO', 312),
(1031, 'CHIQUINQUIRA', 312),
(1032, 'CONCEPCION', 312),
(1033, 'ELEAZAR LOPEZ C', 313),
(1034, 'ALONSO DE OJEDA', 313),
(1035, 'VENEZUELA', 313),
(1036, 'CAMPO LARA', 313),
(1037, 'LIBERTAD', 313),
(1038, 'UDON PEREZ', 314),
(1039, 'ENCONTRADOS', 314),
(1040, 'DONALDO GARCIA', 315),
(1041, 'SIXTO ZAMBRANO', 315),
(1042, 'EL ROSARIO', 315),
(1043, 'AMBROSIO', 316),
(1044, 'GERMAN RIOS LINARES', 316),
(1045, 'JORGE HERNANDEZ', 316),
(1046, 'LA ROSA', 316),
(1047, 'PUNTA GORDA', 316),
(1048, 'CARMEN HERRERA', 316),
(1049, 'SAN BENITO', 316),
(1050, 'ROMULO BETANCOURT', 316),
(1051, 'ARISTIDES CALVANI', 316),
(1052, 'RAUL CUENCA', 317),
(1053, 'LA VICTORIA', 317),
(1054, 'RAFAEL URDANETA', 317),
(1055, 'JOSE RAMON YEPEZ', 318),
(1056, 'LA CONCEPCION', 318),
(1057, 'SAN JOSE', 318),
(1058, 'MARIANO PARRA LEON', 318),
(1059, 'MONAGAS', 319),
(1060, 'ISLA DE TOAS', 319),
(1061, 'MARCIAL HERNANDEZ', 320),
(1062, 'FRANCISCO OCHOA', 320),
(1063, 'SAN FRANCISCO', 320),
(1064, 'EL BAJO', 320),
(1065, 'DOMITILA FLORES', 320),
(1066, 'LOS CORTIJOS', 320),
(1067, 'BARI', 321),
(1068, 'JESUS M SEMPRUN', 321),
(1069, 'SIMON RODRIGUEZ', 322),
(1070, 'CARLOS QUEVEDO', 322),
(1071, 'FRANCISCO J PULGAR', 322),
(1072, 'RAFAEL MARIA BARALT', 323),
(1073, 'MANUEL MANRIQUE', 323),
(1074, 'RAFAEL URDANETA', 323),
(1075, 'FERNANDO GIRON TOVAR', 324),
(1076, 'LUIS ALBERTO GOMEZ', 324),
(1077, 'PARHUEÑA', 324),
(1078, 'PLATANILLAL', 324),
(1079, 'CM. SAN FERNANDO DE ATABA', 325),
(1080, 'UCATA', 325),
(1081, 'YAPACANA', 325),
(1082, 'CANAME', 325),
(1083, 'CM. MAROA', 326),
(1084, 'VICTORINO', 326),
(1085, 'COMUNIDAD', 326),
(1086, 'CM. SAN CARLOS DE RIO NEG', 327),
(1087, 'SOLANO', 327),
(1088, 'COCUY', 327),
(1089, 'CM. ISLA DE RATON', 328),
(1090, 'SAMARIAPO', 328),
(1091, 'SIPAPO', 328),
(1092, 'MUNDUAPO', 328),
(1093, 'GUAYAPO', 328),
(1094, 'CM. SAN JUAN DE MANAPIARE', 329),
(1095, 'ALTO VENTUARI', 329),
(1096, 'MEDIO VENTUARI', 329),
(1097, 'BAJO VENTUARI', 329),
(1098, 'CM. LA ESMERALDA', 330),
(1099, 'HUACHAMACARE', 330),
(1100, 'MARAWAKA', 330),
(1101, 'MAVACA', 330),
(1102, 'SIERRA PARIMA', 330),
(1103, 'SAN JOSE', 331),
(1104, 'VIRGEN DEL VALLE', 331),
(1105, 'SAN RAFAEL', 331),
(1106, 'JOSE VIDAL MARCANO', 331),
(1107, 'LEONARDO RUIZ PINEDA', 331),
(1108, 'MONS. ARGIMIRO GARCIA', 331),
(1109, 'MCL.ANTONIO J DE SUCRE', 331),
(1110, 'JUAN MILLAN', 331),
(1111, 'PEDERNALES', 332),
(1112, 'LUIS B PRIETO FIGUERO', 332),
(1113, 'CURIAPO', 333),
(1114, 'SANTOS DE ABELGAS', 333),
(1115, 'MANUEL RENAUD', 333),
(1116, 'PADRE BARRAL', 333),
(1117, 'ANICETO LUGO', 333),
(1118, 'ALMIRANTE LUIS BRION', 333),
(1119, 'IMATACA', 334),
(1120, 'ROMULO GALLEGOS', 334),
(1121, 'JUAN BAUTISTA ARISMEN', 334),
(1122, 'MANUEL PIAR', 334),
(1123, '5 DE JULIO', 334),
(1124, 'CARABALLEDA', 335),
(1125, 'CARAYACA', 335),
(1126, 'CARUAO', 335),
(1127, 'CATIA LA MAR', 335),
(1128, 'LA GUAIRA', 335),
(1129, 'MACUTO', 335),
(1130, 'MAIQUETIA', 335),
(1131, 'NAIGUATA', 335),
(1132, 'EL JUNKO', 335),
(1133, 'PQ RAUL LEONI', 335),
(1134, 'PQ CARLOS SOUBLETTE', 335);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `person`
--

CREATE TABLE `person` (
  `idPerson` int(11) NOT NULL COMMENT 'identificador unico de la persona',
  `ci` varchar(11) NOT NULL COMMENT 'cedula propia de la persona',
  `name` varchar(20) NOT NULL COMMENT '1er nombre propio de la persona',
  `lastName` varchar(20) NOT NULL COMMENT '1er apellido de la persona',
  `birthDate` date NOT NULL COMMENT 'fecha de nacimiento de la persona',
  `phone` varchar(20) NOT NULL COMMENT 'telefono de la persona',
  `idParroquia` int(11) NOT NULL COMMENT 'clave foranea que relaciona la persona con una parroquia',
  `address` varchar(200) NOT NULL COMMENT 'sector o calle de vivienda de la persona'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `person`
--

INSERT INTO `person` (`idPerson`, `ci`, `name`, `lastName`, `birthDate`, `phone`, `idParroquia`, `address`) VALUES
(1, '1234567', 'Administrador', 'Gonzales', '2000-01-17', 'POR ASIGNAR', 825, 'Calle 7, sector charrallave'),
(2, '12345678', 'Root', 'López', '2003-08-25', 'POR ASIGNAR', 831, 'Calle universitaria, sector 23 de enero'),
(3, '12345679', 'Erain', 'Peña', '1999-10-07', 'POR ASIGNAR', 731, 'Laguaira'),
(4, '12345675', 'Publicista', 'Salazar', '1997-06-17', 'POR ASIGNAR', 756, 'Cumana'),
(5, '1457896', 'Jose', 'Altunsa', '1998-06-11', 'POR ASIGNAR', 727, 'Calle Carabobo, el centro'),
(6, '1236895', 'Ayudante', 'Luna', '1988-05-31', 'POR ASIGNAR', 764, 'San jose, plaza trocha, casa 4'),
(7, '28997664', 'Edgar', 'Agulera', '1997-07-09', 'POR ASIGNAR', 760, 'Charalleve'),
(8, '12378945', 'Sabrina', 'Atilano', '2002-06-13', 'POR ASIGNAR', 628, 'Canchunchu nuevo'),
(9, '28593422', 'Maria', 'Perez', '2000-02-22', 'POR ASIGNAR', 686, 'En la esquina'),
(10, '28593422', 'Jose', 'Jesus', '2000-02-22', 'POR ASIGNAR', 825, 'En la esquina'),
(11, '28593422', 'Edgar', 'Aguilera', '2001-10-29', 'POR ASIGNAR', 752, 'Los  morenos '),
(12, '25593422', 'Erain', 'Salazar', '1989-02-10', '04122245678', 737, 'El pilar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pubspecials`
--

CREATE TABLE `pubspecials` (
  `idPubSpecial` int(11) NOT NULL COMMENT 'identificador unico de la publicacion especial',
  `title` varchar(100) NOT NULL COMMENT 'titulo unico de la publicacion especial',
  `description` varchar(300) NOT NULL COMMENT 'descripcion particular de la publicacion especial',
  `status` varchar(1) NOT NULL COMMENT 'indicador para saber si la publicacion especial esta habilitada o inhabilitada en el sistema',
  `idImage` int(11) NOT NULL COMMENT 'clave foranea que relaciona la publicacion especial con una imagen'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `pubspecials`
--

INSERT INTO `pubspecials` (`idPubSpecial`, `title`, `description`, `status`, `idImage`) VALUES
(1, 'Viaje con amigos', 'Esta es una experiencia que no te puedes perder, tendremos dinámicas de confianza y socialización', '1', 15),
(2, 'Nuevo producto Bitácora', 'Tenemos camisas coon nuestro logo, comunicate o viaja con nosotros para poder ganar una', '1', 16),
(3, '¿No te has atrevido a viajar aun?', 'Es tu oportunidad, los primeros 10cupos estarán a la mitad de precio', '1', 17),
(4, 'Viajes escolares', 'Alguna vez has planificado un viaje? suele ser muy dificl la organizacion, pero cuenta con nosotros y solo tendras qeu preocuparte por disfrutar de la experiencia', '1', 18),
(5, 'Nos alegra formar parte de tu felicidad', 'Tendremos recompensas para nuestros clientes mas fieles en esta temporada', '1', 19),
(6, 'Campaña, ¡Ahora tu propón!', 'Esta se trata de recoger nuevas ideas para ampliar nuestra comunidad Bitácoras', '1', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservation`
--

CREATE TABLE `reservation` (
  `idReservation` int(11) NOT NULL COMMENT 'identificador unico de una reservacion',
  `idUser` int(11) NOT NULL COMMENT 'clave foranea para relacionar una reservacion con un usuario',
  `idTravelOffer` int(11) NOT NULL COMMENT 'clave foranea para relacionar la reservacion con una oferta de viaje',
  `numberSlots` int(11) NOT NULL COMMENT 'cantidad de cupos que se reservarion',
  `reservationDate` date NOT NULL COMMENT 'Fecha en la que se realizó el registro de la reservacion',
  `amount` int(11) NOT NULL COMMENT 'monto a pagar para la reservacion',
  `confirmation` varchar(1) NOT NULL COMMENT 'indicador para saber si la reservacion esta sin procesar, rechazada, aceptada, cancelada o culminada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `reservation`
--

INSERT INTO `reservation` (`idReservation`, `idUser`, `idTravelOffer`, `numberSlots`, `reservationDate`, `amount`, `confirmation`) VALUES
(1, 3, 2, 2, '2025-01-20', 1200, 'E'),
(2, 3, 5, 5, '2025-01-20', 3000, 'E'),
(3, 3, 5, 3, '2025-01-20', 1200, 'E'),
(4, 3, 3, 2, '2025-01-20', 1400, 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `route`
--

CREATE TABLE `route` (
  `idRoute` int(11) NOT NULL COMMENT 'identificador unico de la ruta de viaje',
  `idParroquia` int(11) NOT NULL COMMENT 'clave foranea que vincula la ruta con una parroquia',
  `place` varchar(80) NOT NULL COMMENT 'lugar de la ruta de viaje',
  `location` varchar(80) NOT NULL COMMENT 'sector o calle en que se encuentra este lugar de la ruta de viaje',
  `description` text NOT NULL COMMENT 'descripcion particular de la ruta de viaje',
  `status` varchar(1) NOT NULL COMMENT 'indicador para saber si la ruta de viaje esta habilitada o inhabilitada en el sistema',
  `idImage` int(11) NOT NULL COMMENT 'clave foranea que relaciona la ruta de viaje con una imagen'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `route`
--

INSERT INTO `route` (`idRoute`, `idParroquia`, `place`, `location`, `description`, `status`, `idImage`) VALUES
(1, 743, 'Poza El Gato', 'Reserva posa el gato', 'Es una piscina natural de aguas cristalinas, situada en el curso de un río. Rodeada de vegetación exuberante, es un lugar perfecto para refrescarse y disfrutar de la naturaleza en un entorno tranquilo y relajante.', '1', 34),
(2, 732, 'Playa Medina', 'Zona montañosa de rio caribe', 'Esta playa es famosa por su arena blanca y suave, y sus aguas cristalinas. Rodeada de cocoteros y vegetación tropical, Playa Medina es ideal para nadar, hacer snorkel o simplemente relajarse bajo el sol.', '1', 31),
(3, 732, 'Playa Puy Puy', 'Zona de playa', 'Conocida por su tranquilidad, Playa Pui Pui ofrece una escapada perfecta del bullicio de la ciudad. Su arena dorada y aguas transparentes la hacen ideal para un día de descanso y tranquilidad', '1', 32),
(4, 748, 'Parque Nacional Mochima', 'Área en reserva parque mochima', 'Este parque nacional abarca una amplia zona costera con numerosas islas y playas. Es un destino popular para el buceo y el snorkel debido a su rica vida marina y sus aguas claras. También se pueden hacer paseos en bote para explorar las islas.', '0', 4),
(5, 771, 'Playa Manare', 'Manare', 'Otra de las joyas del Parque Nacional Mochima, Playa Manare se caracteriza por sus aguas turquesas y su entorno natural virgen. Es un lugar perfecto para los amantes de la naturaleza y aquellos que buscan un refugio tranquilo.', '1', 33),
(6, 786, 'Playa Blanca', 'Sector araya', 'Esta playa es un paraíso para los amantes del mar y la arena. Sus aguas cristalinas y su arena blanca la convierten en un lugar ideal para nadar y relajarse. Además, es un excelente punto para practicar deportes acuáticos.', '1', 6),
(7, 61, 'Parque Nacional Mochima', 'Los pozuelos', 'La sección del Parque Nacional Mochima en el estado de Anzoátegui ofrece más playas e islas maravillosas. Es un destino ideal para el ecoturismo y las actividades al aire libre, como el senderismo y la observación de aves.', '1', 7),
(8, 737, 'Cascada Los 7 Pisos', 'Pilar', 'Una impresionante serie de cascadas situadas en un entorno natural exuberante. Es un lugar popular para hacer senderismo y disfrutar del paisaje natural mientras se refresca en las piscinas naturales formadas por las cascadas.', '1', 8),
(9, 64, 'Isla de Plata', 'Calle 5, ensenada principal', 'Una pequeña y pintoresca isla conocida por su biodiversidad marina. Es un excelente lugar para bucear y explorar la vida submarina, incluyendo peces de colores y arrecifes de coral.', '1', 9),
(10, 629, 'Puertas de Miraflores', 'Miraflores', 'Una formación rocosa impresionante que es un destino popular para los amantes de la naturaleza y la fotografía. Es un lugar ideal para explorar y disfrutar de las vistas panorámicas del entorno natural.', '1', 10),
(11, 146, 'La Colonia Tovar', 'Sector alto', 'Un pequeño y encantador pueblo de montaña fundado por colonos alemanes en el siglo XIX. Con su arquitectura de estilo bávaro, sus deliciosos productos locales y su ambiente acogedor, La Colonia Tovar es un destino encantador para una escapada de fin', '1', 11),
(12, 367, 'Chichiriviche', 'Chichiriviche', 'Este destino costero es conocido por sus hermosas playas, sus manglares y su rica biodiversidad. Es un lugar perfecto para el ecoturismo, el avistamiento de aves y los deportes acuáticos.', '1', 12),
(13, 763, 'Kokolan', 'Cocoland', 'Tiene una inmensa piscina con un cangrejo gigantesco en el centro, diseño que configura una majestuosa visión paisajística.', '1', 13),
(14, 736, 'Villa azucena', 'San jose, subida despues de la iglesia el muco', 'Es una montaña desde donde podras ver a todo el el mano carupano en sus 7 colinas, pasar una velada nocturna a la luz de las estrellas acampando, y por supuesto atención, de los dueños y conexión con la naturaleza.', '1', 14),
(15, 686, 'La esquina', 'La cuadra', 'Al lado', '0', 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tourist`
--

CREATE TABLE `tourist` (
  `idTourist` int(11) NOT NULL COMMENT 'identificador unico para un viajero',
  `idPerson` int(11) NOT NULL COMMENT 'clave foranea que relaciona el viajero con persona',
  `idReservation` int(11) NOT NULL COMMENT 'clave foranea que identifica al viajero con la reservacion',
  `status` varchar(1) NOT NULL COMMENT 'indicador para saber si el turista sigue incluido o no en la reservacion'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `tourist`
--

INSERT INTO `tourist` (`idTourist`, `idPerson`, `idReservation`, `status`) VALUES
(1, 3, 1, '1'),
(2, 3, 2, '1'),
(3, 9, 2, '1'),
(4, 3, 3, '1'),
(5, 10, 3, '1'),
(6, 3, 4, '1'),
(7, 11, 4, 'D');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `traveloffer`
--

CREATE TABLE `traveloffer` (
  `id` int(11) NOT NULL COMMENT 'identificador unico para las ofertas de viaje',
  `idTrip` int(11) NOT NULL COMMENT 'clave foranea que relaciona los viajes con las ofertas ',
  `idPackages` int(11) NOT NULL COMMENT 'clave foranea que vincula un paquete el paquete con la oferta del viaje',
  `amount` int(11) NOT NULL COMMENT 'monto total a pagar de la oferta de viaje',
  `status` varchar(11) NOT NULL COMMENT 'indicador para saber si la oferta sigue habilitada en el sistema o esta inhabilitadas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `traveloffer`
--

INSERT INTO `traveloffer` (`id`, `idTrip`, `idPackages`, `amount`, `status`) VALUES
(1, 1, 3, 1700, 'C'),
(2, 2, 1, 600, '1'),
(3, 2, 5, 700, '1'),
(4, 3, 3, 1600, 'C'),
(5, 4, 5, 600, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trip`
--

CREATE TABLE `trip` (
  `idTrip` int(11) NOT NULL COMMENT 'identificador unico del viaje',
  `idRoute` int(11) NOT NULL COMMENT 'clave foranea que vincula el viaje con la ruta',
  `title` varchar(50) NOT NULL COMMENT 'titulo o eslogan del viaje',
  `departureLocation` varchar(100) NOT NULL COMMENT 'lugar de salida del viaje',
  `departureDate` date NOT NULL COMMENT 'fecha de salida del viaje',
  `departureTime` time NOT NULL COMMENT 'hora de salida del viaje',
  `returnDate` date NOT NULL COMMENT 'fecha de regreso del viaje',
  `returnTime` time NOT NULL COMMENT 'hora de regreso del viaje',
  `numberSlots` int(11) NOT NULL COMMENT 'cantidad maxima de viajeros a ',
  `vacant` int(11) NOT NULL COMMENT 'cantidad disponible de cupos para el viaje',
  `price` int(11) NOT NULL COMMENT 'precio del viaje'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `trip`
--

INSERT INTO `trip` (`idTrip`, `idRoute`, `title`, `departureLocation`, `departureDate`, `departureTime`, `returnDate`, `returnTime`, `numberSlots`, `vacant`, `price`) VALUES
(1, 12, 'Primer viaje', 'Centro de carupano, plaza colon', '2025-01-01', '08:00:00', '2025-01-22', '09:00:00', 35, 35, 500),
(2, 13, 'Vamos a kokoland', 'Centro de carupano, plaza colon', '2025-01-25', '10:00:00', '2025-01-25', '11:59:00', 20, 18, 500),
(3, 14, 'Vamos a villa azucena', 'Centro de carupano, plaza colon', '2025-01-01', '09:00:00', '2025-01-22', '09:00:00', 22, 22, 400),
(4, 8, 'Vamos a el chorreron', 'Centro de carupano, plaza colon', '2025-01-30', '09:03:00', '2025-01-30', '21:03:00', 20, 20, 400);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `underage`
--

CREATE TABLE `underage` (
  `idMinor` int(11) NOT NULL COMMENT 'identificador unico del menor de edad',
  `age` int(11) NOT NULL COMMENT 'edad ',
  `sex` varchar(6) NOT NULL COMMENT 'genero del menor de edad',
  `responsible` int(11) NOT NULL COMMENT 'clave foranea que relaciona al menor con una persona que es su responsable',
  `idReservation` int(11) NOT NULL COMMENT 'clave foranea que relaciona el menor de edad con una reservacion de viaje',
  `status` varchar(1) NOT NULL COMMENT 'indicador para saber si el niño esta incluido en la reservacion de viaje o no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `underage`
--

INSERT INTO `underage` (`idMinor`, `age`, `sex`, `responsible`, `idReservation`, `status`) VALUES
(1, 6, 'm', 3, 2, '1'),
(2, 9, 'm', 3, 2, '1'),
(3, 8, 'f', 3, 2, '1'),
(4, 3, 'm', 3, 3, 'D'),
(5, 3, 'm', 3, 3, '1'),
(6, 5, 'm', 3, 1, '1'),
(7, 9, 'm', 3, 4, 'D'),
(8, 9, 'm', 3, 4, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL COMMENT 'identificador unico del usuario',
  `idPerson` int(11) NOT NULL COMMENT 'clave foranea que vincula la persona con el usuario',
  `email` varchar(100) NOT NULL COMMENT 'correo electronico del usuario',
  `password` varchar(62) NOT NULL COMMENT 'contraseña encriptada del usuario',
  `privilege` varchar(11) NOT NULL COMMENT 'nivel de usuario',
  `status` varchar(1) NOT NULL COMMENT 'indicador para saber si el usuario tiene la sesion activa o esta baneado\r\n',
  `verified` varchar(1) NOT NULL COMMENT 'indicador para conocer si el usuario verifico su cuanta con su correo electronico'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`idUser`, `idPerson`, `email`, `password`, `privilege`, `status`, `verified`) VALUES
(1, 1, 'admin@gmail.com', '$2y$11$Wl2xekhQi2VGGdNt4WdrAuuwLDcxAPQM5qm1BYQw12/StUR.fS2WC', 'admin', '1', '1'),
(2, 2, 'root@gmail.com', '$2y$11$c/7RqiDsME.JORQsLxJzIeWj8xYW8WQWBGWPZbYKggnNrx7XDPfw6', 'admin', '1', '1'),
(3, 3, 'turista@gmail.com', '$2y$11$wne.irwLUfnN8OBZT.I20eIlTKua6PlQVsiwd49QsYxETX5C0IHre', 'turista', '1', '1'),
(4, 4, 'publicista@gmail.com', '$2y$11$2T3Ss6wihMdNwlZ1Avqn3ODliyhyeU1EHX/J9RQTuXhnRtmrxkc6.', 'turista', '1', '1'),
(5, 5, 'empleado@gmail.com', '$2y$11$V9GVU6dCbF3.mZSPBWQRiuJTac24rC6BE2YWwVqFdUrRlirI4s7PO', 'publicista', '1', '1'),
(6, 6, 'ayudante@gmail.com', '$2y$11$9yOsgazAcJ7wKMwVD2XwOOQlJHWkFz/ytd0EOb3BWN2a9jjlwDaeC', 'publicista', '1', '1'),
(7, 7, 'edgar@gmail.com', '$2y$11$YclsNpducoet1uxn8gVpcuxik7bpgMhofOYXbCOc5XTUOBJVsr0dK', 'turista', '1', '1'),
(8, 8, 'sabrina@gmail.com', '$2y$11$OW1ZYD8OicP6b68g1lnX1egDEmXGkqDJR.3dtnnNeO0MY/shMnvnW', 'turista', '1', '1'),
(9, 12, 'evmoya.89@gmail.com', '$2y$11$VwtqOdP1QVZFb9Pg6xIQqO.Eiv9jv6YlSwORM50SfOzPyuxrw2MGi', 'turista', '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `weblog`
--

CREATE TABLE `weblog` (
  `idWebLog` int(11) NOT NULL COMMENT 'identificador unico para la bitacora de viaje',
  `idTravelOffer` int(11) NOT NULL COMMENT 'clave foranea que vincula el viaje con la bitacora a traves de su oferta',
  `description` varchar(250) NOT NULL COMMENT 'descripcion unica de la bitacora del viaje',
  `numberTravel` int(11) NOT NULL COMMENT 'numero de turista que fueron al viaje',
  `status` varchar(1) NOT NULL COMMENT 'indicador para saber si la bitacora esta activa o inactiva en el sistema'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `weblog`
--

INSERT INTO `weblog` (`idWebLog`, `idTravelOffer`, `description`, `numberTravel`, `status`) VALUES
(1, 1, 'Viajemaos 20 personas, fue muy divertido, cantamos canciones de camino, comimos en un restauran .\r\nnos lanzamos fotos,\r\ntodos tuvieron una experiencia agradable', 20, '1'),
(2, 4, 'Que divertido pasar el dia en la montaña, coomiendo fruta, contando cuento, en un rio y viendo las estrellas, asi lo pasamos el grupo  el di 01-01-2025 las 30 personas que salimos al viajes', 30, '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `authenticationcode`
--
ALTER TABLE `authenticationcode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autentificationcodeUser` (`idUser`);

--
-- Indices de la tabla `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`idComment`),
  ADD KEY `webLogComment` (`idWebLog`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_e`);

--
-- Indices de la tabla `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_preg_frecuente`);

--
-- Indices de la tabla `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`idHistory`),
  ADD KEY `historyUser` (`idUser`);

--
-- Indices de la tabla `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`idImage`);

--
-- Indices de la tabla `imageweblog`
--
ALTER TABLE `imageweblog`
  ADD KEY `weblogImageWebLog` (`idWebLog`),
  ADD KEY `webLogImage` (`idImage`);

--
-- Indices de la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`id_m`),
  ADD KEY `estado_id` (`estado_id`);

--
-- Indices de la tabla `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`idPackages`);

--
-- Indices de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  ADD PRIMARY KEY (`id_p`),
  ADD KEY `municipio_id` (`municipio_id`);

--
-- Indices de la tabla `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`idPerson`),
  ADD KEY `personDirecction` (`idParroquia`);

--
-- Indices de la tabla `pubspecials`
--
ALTER TABLE `pubspecials`
  ADD PRIMARY KEY (`idPubSpecial`),
  ADD KEY `imagenPubSpecial` (`idImage`);

--
-- Indices de la tabla `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`idReservation`),
  ADD KEY `userReservaction` (`idUser`),
  ADD KEY `reservationtravelOffer` (`idTravelOffer`);

--
-- Indices de la tabla `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`idRoute`),
  ADD KEY `idParroquia` (`idParroquia`),
  ADD KEY `imageRout` (`idImage`);

--
-- Indices de la tabla `tourist`
--
ALTER TABLE `tourist`
  ADD PRIMARY KEY (`idTourist`),
  ADD KEY `reservationAccom` (`idReservation`),
  ADD KEY `reservationPerson` (`idPerson`);

--
-- Indices de la tabla `traveloffer`
--
ALTER TABLE `traveloffer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idTrip` (`idTrip`),
  ADD KEY `idPackages` (`idPackages`);

--
-- Indices de la tabla `trip`
--
ALTER TABLE `trip`
  ADD PRIMARY KEY (`idTrip`),
  ADD KEY `idRoute` (`idRoute`);

--
-- Indices de la tabla `underage`
--
ALTER TABLE `underage`
  ADD PRIMARY KEY (`idMinor`),
  ADD KEY `underReservation` (`idReservation`),
  ADD KEY `responsible` (`responsible`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `personUser` (`idPerson`);

--
-- Indices de la tabla `weblog`
--
ALTER TABLE `weblog`
  ADD PRIMARY KEY (`idWebLog`),
  ADD KEY `webLogTravel` (`idTravelOffer`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `authenticationcode`
--
ALTER TABLE `authenticationcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'clave primaria de las autentificaciones', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
  MODIFY `idComment` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico del resgistro del comentario', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `faq`
--
ALTER TABLE `faq`
  MODIFY `id_preg_frecuente` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico de una pregunta frecuente', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `history`
--
ALTER TABLE `history`
  MODIFY `idHistory` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico del registro del historial', AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `image`
--
ALTER TABLE `image`
  MODIFY `idImage` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico de la imagen', AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `packages`
--
ALTER TABLE `packages`
  MODIFY `idPackages` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico de un paquete de viaje', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `person`
--
ALTER TABLE `person`
  MODIFY `idPerson` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico de la persona', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `pubspecials`
--
ALTER TABLE `pubspecials`
  MODIFY `idPubSpecial` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico de la publicacion especial', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `reservation`
--
ALTER TABLE `reservation`
  MODIFY `idReservation` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico de una reservacion', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `route`
--
ALTER TABLE `route`
  MODIFY `idRoute` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico de la ruta de viaje', AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `tourist`
--
ALTER TABLE `tourist`
  MODIFY `idTourist` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico para un viajero', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `traveloffer`
--
ALTER TABLE `traveloffer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico para las ofertas de viaje', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `trip`
--
ALTER TABLE `trip`
  MODIFY `idTrip` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico del viaje', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `underage`
--
ALTER TABLE `underage`
  MODIFY `idMinor` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico del menor de edad', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico del usuario', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `weblog`
--
ALTER TABLE `weblog`
  MODIFY `idWebLog` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico para la bitacora de viaje', AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `authenticationcode`
--
ALTER TABLE `authenticationcode`
  ADD CONSTRAINT `autentificationcodeUser` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `webLogComment` FOREIGN KEY (`idWebLog`) REFERENCES `weblog` (`idWebLog`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `historyUser` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imageweblog`
--
ALTER TABLE `imageweblog`
  ADD CONSTRAINT `webLogImage` FOREIGN KEY (`idImage`) REFERENCES `image` (`idImage`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `weblogImageWebLog` FOREIGN KEY (`idWebLog`) REFERENCES `weblog` (`idWebLog`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `conccE` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id_e`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `parroquia`
--
ALTER TABLE `parroquia`
  ADD CONSTRAINT `conccM` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id_m`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `personDirecction` FOREIGN KEY (`idParroquia`) REFERENCES `parroquia` (`id_p`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pubspecials`
--
ALTER TABLE `pubspecials`
  ADD CONSTRAINT `imagenPubSpecial` FOREIGN KEY (`idImage`) REFERENCES `image` (`idImage`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservationtravelOffer` FOREIGN KEY (`idTravelOffer`) REFERENCES `traveloffer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userReservaction` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `route`
--
ALTER TABLE `route`
  ADD CONSTRAINT `imageRout` FOREIGN KEY (`idImage`) REFERENCES `image` (`idImage`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `routeParroquia` FOREIGN KEY (`idParroquia`) REFERENCES `parroquia` (`id_p`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tourist`
--
ALTER TABLE `tourist`
  ADD CONSTRAINT `reservationAccom` FOREIGN KEY (`idReservation`) REFERENCES `reservation` (`idReservation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservationPerson` FOREIGN KEY (`idPerson`) REFERENCES `person` (`idPerson`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `traveloffer`
--
ALTER TABLE `traveloffer`
  ADD CONSTRAINT `travelOfferPackages` FOREIGN KEY (`idPackages`) REFERENCES `packages` (`idPackages`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `travelofferTrip` FOREIGN KEY (`idTrip`) REFERENCES `trip` (`idTrip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `trip`
--
ALTER TABLE `trip`
  ADD CONSTRAINT `tripRoute` FOREIGN KEY (`idRoute`) REFERENCES `route` (`idRoute`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `underage`
--
ALTER TABLE `underage`
  ADD CONSTRAINT `underReservation` FOREIGN KEY (`idReservation`) REFERENCES `reservation` (`idReservation`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `underage_ibfk_1` FOREIGN KEY (`responsible`) REFERENCES `person` (`idPerson`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `personUser` FOREIGN KEY (`idPerson`) REFERENCES `person` (`idPerson`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `weblog`
--
ALTER TABLE `weblog`
  ADD CONSTRAINT `webLogTravel` FOREIGN KEY (`idTravelOffer`) REFERENCES `traveloffer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
