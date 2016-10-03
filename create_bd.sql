-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-08-2016 a las 13:45:34
-- Versión del servidor: 10.0.17-MariaDB
-- Versión de PHP: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `appdiet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acces_groups`
--

CREATE TABLE `acces_groups` (
  `id` int(11) NOT NULL,
  `groups_id` int(11) NOT NULL,
  `con_ac_id` int(11) NOT NULL,
  `acceso` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acces_users`
--

CREATE TABLE `acces_users` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `con_ac_id` int(11) NOT NULL,
  `acceso` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` int(11) NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `texto1` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `carpeta` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `texto2` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `principal` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `con_ac`
--

CREATE TABLE `con_ac` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `alias` varchar(150) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(150) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'administrador'),
(2, 'gestor'),
(3, 'SuperUsuario'),
(4, 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `id` int(11) NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `texto` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `href` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `articulo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(11) NOT NULL,
  `orden` int(11) NOT NULL DEFAULT '0',
  `tipo` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rt_password`
--

CREATE TABLE `rt_password` (
  `id` int(11) NOT NULL,
  `user_id` varchar(23) NOT NULL,
  `codigo` varchar(264) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tiempo` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `apellidos` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `groups_id` tinyint(4) NOT NULL DEFAULT '2',
  `fecha_nacimiento` datetime DEFAULT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime DEFAULT NULL,
  `verificacion_envio` int(11) NOT NULL,
  `verificado` int(11) NOT NULL,
  `codigo_verificacion` varchar(264) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `apellidos`, `email`, `password`, `groups_id`, `fecha_nacimiento`, `fecha_alta`, `fecha_mod`, `verificacion_envio`, `verificado`, `codigo_verificacion`) VALUES
(1, 'administrador', '', '', '21b72c0b7adc5c7b4a50ffcb90d92dd6', 1, '0000-00-00 00:00:00', '2011-09-27 11:42:02', NULL, 1, 1, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acces_groups`
--
ALTER TABLE `acces_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `acces_users`
--
ALTER TABLE `acces_users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `con_ac`
--
ALTER TABLE `con_ac`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `rt_password`
--
ALTER TABLE `rt_password`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
