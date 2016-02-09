-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 20 Janvier 2016 à 15:51
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
-- Structure de la table `etudiant`
--

CREATE TABLE IF NOT EXISTS `etudiant` (
  `IDEtu` int(11) NOT NULL AUTO_INCREMENT,
  `nomEtu` varchar(255) NOT NULL,
  `prenomEtu` varchar(255) NOT NULL,
  `mailEtu` varchar(255) NOT NULL,
  `mdpEtu` varchar(255) NOT NULL,
  `numtelEtu` varchar(10) NOT NULL,
  `formationEtu` text NOT NULL,
  `listechoixEtu` varchar(255) NOT NULL,
  PRIMARY KEY (`IDEtu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Table qui contient tous les étudiants' AUTO_INCREMENT=38 ;

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`IDEtu`, `nomEtu`, `prenomEtu`, `mailEtu`, `mdpEtu`, `numtelEtu`, `formationEtu`, `listechoixEtu`) VALUES
(17, 'Aimarre', 'Jean', 'j.aimarre@mail.com', '$1$XX3.U91.$vsZAx02TDIzricxPe8Ixj/', '0610203040', 'DUT INFO', ''),
(21, 'Beaucham', 'Brigitte', 'b.beaucham@mail.com', '$1$6T3.V/..$zeu3PlM2vVTTV07DptwlM/', '0642588898', 'DUT SGM', ''),
(22, 'Borsdorf', 'Jane', 'j.borsdorf@mail.com', '$1$2b1.h0..$rVP4yVHkhNthYx4PhNW2Y0', '0648775421', 'DCG', ''),
(23, 'Bouleau', 'Yvan', 'y.bouleau@mail.com', '$1$Qb5.Zf/.$5cbw4XCn9wqdxdvhXBE3X1', '0685475123', 'DUT SGM', ''),
(24, 'Bourdon', 'Gérard', 'g.bourdon@mail.com', '$1$MW/.lX5.$I5uZb2s4.18gTjSCdq9Ue0', '0685154237', 'DUT INFO', ''),
(25, 'Bourreaux', 'Alexandre', 'a.bourreaux@mail.com', '$1$ME5.lt4.$uEK7JBkWJ7XSPvYYCqZLU1', '0684521545', 'DCG', ''),
(26, 'Bouvier', 'Bernois', 'b.bouvier@mail.com', '$1$yB0.T11.$eyKXTMKgIZohEYroduLoW0', '0654559873', 'DCG', ''),
(27, 'Buisson', 'Florient', 'f.buisson@mail.com', '$1$g25.pT2.$HLz5AB5UJyDwZMMz8n0QM.', '0642157411', 'DCG', ''),
(28, 'Chou', 'Ema', 'e.chou@mail.com', '$1$8a5.vj5.$HLJY4PH/bVPWlr/YIQ9L3.', '0612003284', 'DCG', ''),
(29, 'Gorge', 'Eléana', 'e.gorge@mail.com', '$1$ET..7D4.$TX/ORbfxHmh9xX.dlSBXg0', '0653975145', 'DUT SGM', ''),
(30, 'Gustin', 'Michel', 'm.gustin@mail.com', '$1$gq2.pd0.$8ViGCijBg4fYn/oaEKvzF1', '0265346511', 'DUT INFO', ''),
(31, 'Jambon', 'Charles', 'c.jambon@mail.com', '$1$ua4.f/4.$vMqiL5nPuc6qKEvNYkH301', '0623010014', 'DUT SGM', ''),
(32, 'Mouchon', 'Valentine', 'v.mouchon@mail.com', '$1$Kn/.Lh0.$SwC4BMKDLeAfKCg5I4tCW.', '065428664', 'DUT INFO', ''),
(33, 'Moulin', 'Clémentine', 'c.moulin@mail.com', '$1$0W2.Hi0.$gyE0PMwMLBsLjwEGur4/l.', '0644533742', 'DUT SGM', ''),
(34, 'Plantin', 'Georges', 'g.plantin@mail.com', '$1$Cf4.jr4.$QlOlItNyZmVUj1iDkv6q4/', '0612368545', 'DUT SGM', ''),
(35, 'Titane', 'Paul', 'p.titane@mail.com', '$1$q95.rP/.$oG0xZS8UDaaI07W4jpl4Y1', '0634864258', 'DUT INFO', ''),
(36, 'Trombe', 'James', 'j.trombe@mail.com', '$1$KF0.Ln3.$GHaFwQNJsTMCYUN127LDs0', '0631206565', 'DCG', ''),
(37, 'Valjean', 'Jean', 'j.val@mail.com', '$1$8c4.v74.$iiSkXwJ8q4MoAxhq3Tpmw1', '0620309020', 'DUT INFO', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
