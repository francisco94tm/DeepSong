-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-12-2015 a las 15:24:46
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';
--
-- Base de datos: `cremadeelote'
	CREATE SCHEMA IF NOT EXISTS `cremadeelote` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
	USE `cremadeelote` ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `album_id` int(11) NOT NULL,
  `album_name` varchar(60) DEFAULT NULL,
  `album_description` varchar(2000) DEFAULT NULL,
  `album_downloads` int(11) DEFAULT NULL,
  `album_year` int(11) DEFAULT NULL,
  `album_cover` varchar(50) DEFAULT NULL,
  `album_video` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `album_genre`
--

CREATE TABLE IF NOT EXISTS `album_genre` (
  `album_album_id` int(11) NOT NULL,
  `genre_genre_id` int(11) NOT NULL,
  PRIMARY KEY (`album_album_id`,`genre_genre_id`),
  KEY `fk_album_has_genre_genre1_idx` (`genre_genre_id`),
  KEY `fk_album_has_genre_album1_idx` (`album_album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artist`
--

CREATE TABLE IF NOT EXISTS `artist` (
  `artist_id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_name` varchar(100) DEFAULT NULL,
  `artist_img` varchar(50) DEFAULT NULL,
  `artist_description` varchar(200) DEFAULT NULL,
  `artist_pass` varchar(45) DEFAULT NULL,
  `artist_country` varchar(45) DEFAULT NULL,
  `artist_email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`artist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `artist`
--

INSERT INTO `artist` (`artist_id`, `artist_name`, `artist_img`, `artist_description`, `artist_pass`, `artist_country`, `artist_email`) VALUES
(1, 'Motorama', 'Motorama.jpg', 'wearemotorama.com', 'kpCLkI2ekp4=', 'RUS', 'motorama@ds.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artist_album`
--

CREATE TABLE IF NOT EXISTS `artist_album` (
  `artist_artist_id` int(11) NOT NULL,
  `album_album_id` int(11) NOT NULL,
  PRIMARY KEY (`artist_artist_id`,`album_album_id`),
  KEY `fk_artist_has_album_album1_idx` (`album_album_id`),
  KEY `fk_artist_has_album_artist1_idx` (`artist_artist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cd`
--

CREATE TABLE IF NOT EXISTS `cd` (
  `cd_part` int(11) NOT NULL AUTO_INCREMENT,
  `cd_price` float DEFAULT NULL,
  `album_album_id` int(11) NOT NULL,
  PRIMARY KEY (`cd_part`,`album_album_id`),
  KEY `fk_cd_album1_idx` (`album_album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genre`
--

CREATE TABLE IF NOT EXISTS `genre` (
  `genre_id` int(11) NOT NULL AUTO_INCREMENT,
  `genre_name` int(11) NOT NULL,
  `genre_description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`genre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `song`
--

CREATE TABLE IF NOT EXISTS `song` (
  `song_id` int(11) NOT NULL AUTO_INCREMENT,
  `song_name` varchar(100) NOT NULL,
  `song_track` int(11) NOT NULL,
  `song_price` float NOT NULL,
  `song_colaborator` varchar(100) DEFAULT NULL,
  `song_url` varchar(100) DEFAULT NULL,
  `song_downloads` int(11) DEFAULT NULL,
  `cd_cd_part` int(11) NOT NULL,
  `cd_album_album_id` int(11) NOT NULL,
  `song_length` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`song_id`,`cd_cd_part`,`cd_album_album_id`),
  KEY `fk_song_cd1_idx` (`cd_cd_part`,`cd_album_album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `album_genre`
--
ALTER TABLE `album_genre`
  ADD CONSTRAINT `fk_album_has_genre_album1` FOREIGN KEY (`album_album_id`) REFERENCES `album` (`album_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_album_has_genre_genre1` FOREIGN KEY (`genre_genre_id`) REFERENCES `genre` (`genre_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `artist_album`
--
ALTER TABLE `artist_album`
  ADD CONSTRAINT `fk_artist_has_album_album1` FOREIGN KEY (`album_album_id`) REFERENCES `album` (`album_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_artist_has_album_artist1` FOREIGN KEY (`artist_artist_id`) REFERENCES `artist` (`artist_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cd`
--
ALTER TABLE `cd`
  ADD CONSTRAINT `fk_cd_album1` FOREIGN KEY (`album_album_id`) REFERENCES `album` (`album_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `fk_song_cd1` FOREIGN KEY (`cd_cd_part`, `cd_album_album_id`) REFERENCES `cd` (`cd_part`, `album_album_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
