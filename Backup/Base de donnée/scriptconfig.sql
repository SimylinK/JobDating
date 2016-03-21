-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 12 Février 2016 à 11:38
-- Version du serveur: 5.5.47-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `info2-2015-jobdating`
--

-- --------------------------------------------------------

--
-- Structure de la table `scriptconfig`
--

CREATE TABLE IF NOT EXISTS `scriptconfig` (
  `heureDebutMatin` time NOT NULL,
  `heureDebutAprem` time NOT NULL,
  `nbCreneauxMatin` int(11) NOT NULL,
  `nbCreneauxAprem` int(11) NOT NULL,
  `dureeCreneau` int(11) NOT NULL,
  `dateDebutInscriptionEtu` date NOT NULL,
  `dateDebutInscriptionEnt` date NOT NULL,
  `dateFinInscription` date NOT NULL,
  `dateDebutVuePlanning` date NOT NULL,
  `dateFinVuePlanning` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `scriptconfig`
--

INSERT INTO `scriptconfig` (`heureDebutMatin`, `heureDebutAprem`, `nbCreneauxMatin`, `nbCreneauxAprem`, `dureeCreneau`, `dateDebutInscriptionEtu`, `dateDebutInscriptionEnt`, `dateFinInscription`, `dateDebutVuePlanning`, `dateFinVuePlanning`) VALUES
('10:00:00', '14:00:00', 6, 8, 20, '2016-03-04', '2016-02-12', '2016-03-19', '2016-03-30', '0000-00-00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
