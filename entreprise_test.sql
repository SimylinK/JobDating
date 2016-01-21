-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 20 Janvier 2016 à 15:54
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `info2-2015-jobdating`
--

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE IF NOT EXISTS `entreprise` (
  `IDEnt` int(11) NOT NULL AUTO_INCREMENT,
  `nomEnt` varchar(255) NOT NULL,
  `mdpEnt` varchar(255) NOT NULL,
  `typeCreneau` varchar(255) NOT NULL,
  `formationsRecherchees` varchar(255) NOT NULL,
  `nbPlaces` int(11) NOT NULL,
  `nbStands` int(11) NOT NULL,
  `nbRepas` int(11) NOT NULL,
  `mailEnt` varchar(255) NOT NULL,
  `nomContact` varchar(255) NOT NULL,
  `prenomContact` varchar(255) NOT NULL,
  `numTelEnt` varchar(10) NOT NULL,
  `codePostal` int(11) NOT NULL,
  `villeEnt` varchar(255) NOT NULL,
  `adresseEnt` varchar(255) NOT NULL,
  PRIMARY KEY (`IDEnt`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `entreprise`
--

INSERT INTO `entreprise` (`IDEnt`, `nomEnt`, `mdpEnt`, `typeCreneau`, `formationsRecherchees`, `nbPlaces`, `nbStands`, `nbRepas`, `mailEnt`, `nomContact`, `prenomContact`, `numTelEnt`, `codePostal`, `villeEnt`, `adresseEnt`) VALUES
(10, 'SUPERWEB', '$1$4S4.5V/.$hbnvocwXerqHEdQ7IIum7/', 'journee', 'DUT INFO,DUT SGM,DCG', 4, 1, 1, 'superweb.bourgeon@mail.com', 'Bourgeon', 'François', '0642589421', 44000, 'Nantes', '3 rue du colibri'),
(11, 'INFORMATHIX', '$1$Wz0.nx4.$Lr81Af3DHBh8nGoH5F5Ux/', 'matin', 'DUT INFO', 1, 0, 1, 'informathix.barbarian@mail.com', 'Barbarian', 'Conan', '0645129814', 44000, 'Nantes', '2 rue Maréchal Joffre'),
(12, 'SUPRAMATHS', '$1$ks0.de5.$bnlfJ.GL.lefyerCNqDuY1', 'journee', 'DCG', 2, 1, 1, 'supramaths.boudin@mail.com', 'Michel', 'Boudin', '0645784521', 44000, 'Nantes', '8 rue Manchot'),
(13, 'GIGAPANNEL', '$1$i60.D52.$LLjQ9ljy7DT02zVOd51VW0', 'journee', 'DUT INFO,DUT SGM', 1, 1, 1, 'gigapannel.trollingo@mail.com', 'Trollingo', 'Marcel', '0685479612', 44000, 'Nantes', '8 rue des lézards'),
(14, 'TRALORNA', '$1$iU4.Dz..$UEhBUQmy87DY/BKE2N83q/', 'apres_midi', 'DUT SGM,DCG', 2, 0, 2, 'tralorna.pluto@mail.com', 'Pluto', 'Benjamin', '0648651144', 44000, 'Nantes', '3 rue des girouettes');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
