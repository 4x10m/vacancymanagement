-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 22 Mars 2015 à 23:17
-- Version du serveur: 5.5.41
-- Version de PHP: 5.4.39-0+deb7u1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `projetstage`
--

-- --------------------------------------------------------

--
-- Structure de la table `candidature`
--

CREATE TABLE IF NOT EXISTS `candidature` (
  `student` int(11) NOT NULL,
  `stage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `enterpriseregistration`
--

CREATE TABLE IF NOT EXISTS `enterpriseregistration` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `mail` text NOT NULL,
  `website` text NOT NULL,
  `validationcode` text NOT NULL,
  `validationlevel` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `gcmuser`
--

CREATE TABLE IF NOT EXISTS `gcmuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `registrationid` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `stage`
--

CREATE TABLE IF NOT EXISTS `stage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `enterprise` int(11) NOT NULL,
  `online` tinyint(1) NOT NULL DEFAULT '0',
  `placenumber` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_5` (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`),
  KEY `id_3` (`id`),
  KEY `id_4` (`id`),
  KEY `id_6` (`id`),
  KEY `enterprise` (`enterprise`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `stage`
--

INSERT INTO `stage` (`id`, `title`, `description`, `enterprise`, `online`, `placenumber`) VALUES
(4, 'plop', 'plop', 12, 1, 1),
(5, 'plop1', 'plop1', 12, 1, 0),
(6, 'yyyyoooooo', '<p>un ssssstttttaaaagggggeeee</p>', 12, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `studentsession`
--

CREATE TABLE IF NOT EXISTS `studentsession` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `contact` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `validationcode` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `type` enum('STUDENT','ENTERPRISE','ADMINISTRATOR') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
