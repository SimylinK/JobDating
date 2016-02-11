-- phpMyAdmin SQL Dump
-- version 4.3.11.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 11 Février 2016 à 09:14
-- Version du serveur :  5.5.41-0+wheezy1
-- Version de PHP :  5.4.36-0+deb7u3

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
-- Structure de la table `creneau`
--

CREATE TABLE IF NOT EXISTS `creneau` (
  `numeroCreneau` int(11) NOT NULL,
  `heureDepart` time NOT NULL,
  `heureFin` time NOT NULL,
  `idFormation` int(11) NOT NULL,
  `idEtudiant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `creneau`
--

INSERT INTO `creneau` (`numeroCreneau`, `heureDepart`, `heureFin`, `idFormation`, `idEtudiant`) VALUES
(0, '00:00:00', '00:00:00', 736, 35),
(0, '00:00:00', '00:00:00', 738, 36),
(0, '00:00:00', '00:00:00', 739, 22),
(0, '00:00:00', '00:00:00', 740, 17),
(1, '00:00:00', '00:00:00', 736, 37),
(1, '00:00:00', '00:00:00', 738, 26),
(1, '00:00:00', '00:00:00', 740, 24),
(2, '00:00:00', '00:00:00', 736, 17),
(2, '00:00:00', '00:00:00', 740, 30),
(3, '00:00:00', '00:00:00', 736, 24),
(3, '00:00:00', '00:00:00', 740, 32),
(4, '00:00:00', '00:00:00', 740, 37),
(5, '00:00:00', '00:00:00', 736, 32),
(5, '00:00:00', '00:00:00', 740, 35),
(6, '00:00:00', '00:00:00', 734, 33),
(6, '00:00:00', '00:00:00', 735, 34),
(6, '00:00:00', '00:00:00', 737, 23),
(7, '00:00:00', '00:00:00', 734, 38),
(7, '00:00:00', '00:00:00', 737, 29),
(8, '00:00:00', '00:00:00', 737, 31),
(9, '00:00:00', '00:00:00', 734, 29),
(9, '00:00:00', '00:00:00', 737, 33),
(10, '00:00:00', '00:00:00', 737, 34);

-- --------------------------------------------------------

--
-- Structure de la table `demandesmdp`
--

CREATE TABLE IF NOT EXISTS `demandesmdp` (
  `idDemande` int(11) NOT NULL,
  `demandeur` varchar(255) NOT NULL,
  `newMdp` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE IF NOT EXISTS `entreprise` (
  `IDEnt` int(11) NOT NULL,
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
  `adresseEnt` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `entreprise`
--

INSERT INTO `entreprise` (`IDEnt`, `nomEnt`, `mdpEnt`, `typeCreneau`, `formationsRecherchees`, `nbPlaces`, `nbStands`, `nbRepas`, `mailEnt`, `nomContact`, `prenomContact`, `numTelEnt`, `codePostal`, `villeEnt`, `adresseEnt`) VALUES
(57, 'TRALORNA', '$1$iU4.Dz..$UEhBUQmy87DY/BKE2N83q/', 'apres_midi', 'DUT SGM', 2, 3, 2, 'tralorna.pluto@mail.com', 'Pluto', 'Benjamin', '0648651144', 44000, 'Nantes', '3 rue des girouettes'),
(58, 'GIGAPANNEL', '$1$i60.D52.$LLjQ9ljy7DT02zVOd51VW0', 'journee', 'DUT INFO,DUT SGM', 1, 1, 1, 'gigapannel.trollingo@mail.com', 'Trollingo', 'Marcel', '0685479612', 44000, 'Nantes', '8 rue des lézards'),
(60, 'SUPRAMATHS', '$1$ks0.de5.$bnlfJ.GL.lefyerCNqDuY1', 'journee', 'DCG', 2, 1, 1, 'supramaths.boudin@mail.com', 'Michel', 'Boudin', '0645784521', 44000, 'Nantes', '8 rue Manchot'),
(61, 'INFORMATHIX', '$1$Wz0.nx4.$Lr81Af3DHBh8nGoH5F5Ux/', 'matin', 'DUT INFO', 1, 3, 1, 'informathix.barbarian@mail.com', 'Barbarian', 'Conan', '0645129814', 44000, 'Nantes', '2 rue Maréchal Joffre'),
(63, 'CAPGEMINI3', '$6$VOcP4LqP4asC$YqFs1SzHHF3NFmdbhtn/RPjOolKqYq2eXgdq3EpmD6mDVl0dsTvh8o54DMx.4/0H.tP81sKKNa9eHmQTLqRRj/', 'apres_midi', 'DUT INFO,DUT GMP', 1, 2, 1, 'nassim.hadjrabia@wanadoo.fr', 'Rabia', 'nassim', '0650021455', 44000, 'Nantes', '3 rue  du pacique'),
(66, 'SUPERWEB', '$1$4S4.5V/.$hbnvocwXerqHEdQ7IIum7/', 'apres_midi', 'LP IDEB,LP I2P,LP SIL,LP FICA,DCG', 4, 8, 1, 'superweb.bourgeon@mail.com', 'Bourgeon', 'François', '0642589421', 44000, 'Nantes', '3 rue du colibri');

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE IF NOT EXISTS `etudiant` (
  `IDEtu` int(11) NOT NULL,
  `nomEtu` varchar(255) NOT NULL,
  `prenomEtu` varchar(255) NOT NULL,
  `mailEtu` varchar(255) NOT NULL,
  `mdpEtu` varchar(255) NOT NULL,
  `numtelEtu` varchar(10) NOT NULL,
  `formationEtu` text NOT NULL,
  `listechoixEtu` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1 COMMENT='Table qui contient tous les étudiants';

--
-- Contenu de la table `etudiant`
--

INSERT INTO `etudiant` (`IDEtu`, `nomEtu`, `prenomEtu`, `mailEtu`, `mdpEtu`, `numtelEtu`, `formationEtu`, `listechoixEtu`) VALUES
(17, 'Aimarre', 'Jean', 'j.aimarre@mail.com', '$1$XX3.U91.$vsZAx02TDIzricxPe8Ixj/', '0610203040', 'DUT INFO', '61,56,58'),
(22, 'Borsdorf', 'Jane', 'j.borsdorf@mail.com', '$1$hwsYAvJN$lLVquB7or.uIYkJ7Ir9Hr/', '0648775421', 'DCG', '57,60,56'),
(23, 'Bouleau', 'Yvan', 'y.bouleau@mail.com', '$1$Qb5.Zf/.$5cbw4XCn9wqdxdvhXBE3X1', '0685475123', 'DUT SGM', '58,56'),
(24, 'Bourdon', 'Gérard', 'g.bourdon@mail.com', '$1$MW/.lX5.$I5uZb2s4.18gTjSCdq9Ue0', '0685154237', 'DUT INFO', '61,56,58'),
(25, 'Bourreaux', 'Alexandre', 'a.bourreaux@mail.com', '$1$ME5.lt4.$uEK7JBkWJ7XSPvYYCqZLU1', '0684521545', 'DCG', '57'),
(26, 'Bouvier', 'Bernois', 'b.bouvier@mail.com', '$1$yB0.T11.$eyKXTMKgIZohEYroduLoW0', '0654559873', 'DCG', '57,60,56'),
(28, 'Chou', 'Ema', 'e.chou@mail.com', '$1$8a5.vj5.$HLJY4PH/bVPWlr/YIQ9L3.', '0612003284', 'DCG', '57,56'),
(29, 'Gorge', 'Eléana', 'e.gorge@mail.com', '$1$ET..7D4.$TX/ORbfxHmh9xX.dlSBXg0', '0653975145', 'DUT SGM', '58,57,56'),
(30, 'Gustin', 'Michel', 'm.gustin@mail.com', '$1$gq2.pd0.$8ViGCijBg4fYn/oaEKvzF1', '0265346511', 'DUT INFO', '61,56'),
(31, 'Jambon', 'Charles', 'c.jambon@mail.com', '$1$ua4.f/4.$vMqiL5nPuc6qKEvNYkH301', '0623010014', 'DUT SGM', '58,56'),
(32, 'Mouchon', 'Valentine', 'v.mouchon@mail.com', '$1$Kn/.Lh0.$SwC4BMKDLeAfKCg5I4tCW.', '065428664', 'DUT INFO', '61,56,58'),
(33, 'Moulin', 'Clémentine', 'c.moulin@mail.com', '$1$0W2.Hi0.$gyE0PMwMLBsLjwEGur4/l.', '0644533742', 'DUT SGM', '57,58'),
(34, 'Plantin', 'Georges', 'g.plantin@mail.com', '$1$Cf4.jr4.$QlOlItNyZmVUj1iDkv6q4/', '0612368545', 'DUT SGM', '57,56,58'),
(35, 'Titane', 'Paul', 'p.titane@mail.com', '$1$q95.rP/.$oG0xZS8UDaaI07W4jpl4Y1', '0634864258', 'DUT INFO', '58,56,61'),
(36, 'Trombe', 'James', 'j.trombe@mail.com', '$1$KF0.Ln3.$GHaFwQNJsTMCYUN127LDs0', '0631206565', 'DCG', '60,56'),
(37, 'Valjean', 'Jean', 'j.val@mail.com', '$1$8c4.v74.$iiSkXwJ8q4MoAxhq3Tpmw1', '0620309020', 'DUT INFO', '61,58,56'),
(38, 'Beaucham', 'Brigitte', 'b.beaucham@mail.com', '$1$6T3.V/..$zeu3PlM2vVTTV07DptwlM/', '0642588898', 'DUT SGM', '56,57');

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE IF NOT EXISTS `formation` (
  `IDformation` int(11) NOT NULL,
  `typeFormation` varchar(255) NOT NULL,
  `entPropose` int(11) NOT NULL,
  `creneauDebut` int(11) NOT NULL,
  `creneauFin` int(11) NOT NULL,
  `descriptionFormation` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=794 DEFAULT CHARSET=latin1 COMMENT='Table qui associe une formation avec une entreprise qui la propose';

--
-- Contenu de la table `formation`
--

INSERT INTO `formation` (`IDformation`, `typeFormation`, `entPropose`, `creneauDebut`, `creneauFin`, `descriptionFormation`) VALUES
(734, 'DUT SGM', 57, 7, 14, ''),
(735, 'DUT SGM', 57, 7, 14, ''),
(736, 'DUT INFO', 58, 1, 6, ''),
(737, 'DUT SGM', 58, 7, 14, ''),
(738, 'DCG', 60, 1, 14, ''),
(739, 'DCG', 60, 1, 14, ''),
(740, 'DUT INFO', 61, 1, 6, ''),
(741, 'DUT INFO', 63, 7, 6, ''),
(742, 'DUT GMP', 63, 7, 14, ''),
(786, 'LP IDEB', 66, 7, 14, ''),
(787, 'LP I2P', 66, 7, 14, ''),
(788, 'LP SIL', 66, 7, 14, ''),
(789, 'LP FICA', 66, 7, 14, ''),
(790, 'DCG', 66, 7, 14, ''),
(791, 'LP IDEB', 66, 7, 14, ''),
(792, 'LP I2P', 66, 7, 14, ''),
(793, 'LP SIL', 66, 7, 14, '');

-- --------------------------------------------------------

--
-- Structure de la table `identificationadmin`
--

CREATE TABLE IF NOT EXISTS `identificationadmin` (
  `emailadmin` varchar(255) NOT NULL,
  `mdpadmin` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `identificationadmin`
--

INSERT INTO `identificationadmin` (`emailadmin`, `mdpadmin`) VALUES
('admin', '$1$yQwRJFsR$G0J/A9E5jgTOy4eg5XS5p.'),
('admin2', '$1$7cm0k7cE$3L6ko8LwCLXWn82C3h8aU.'),
('JobMeetAdmin', '$1$.D6CxsUJ$lOVZ6mPZ3SIO5cwaAovJF1');

-- --------------------------------------------------------

--
-- Structure de la table `listeFormations`
--

CREATE TABLE IF NOT EXISTS `listeFormations` (
  `departement` varchar(255) NOT NULL,
  `initiales` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `lien` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `listeFormations`
--

INSERT INTO `listeFormations` (`departement`, `initiales`, `description`, `lien`) VALUES
('GEA', 'DCG', 'Diplôme Comptabilité et Gestion', 'http://www.iutnantes.univ-nantes.fr/1767/0/fiche___formation/&RH=1183119182323'),
('GEII', 'DUT GEII', 'DUT 2ème année GEII : Génie Électrique et Informatique Industrielle', 'http://www.iutnantes.univ-nantes.fr/901/0/fiche___formation/&RH=1364294977339'),
('GMP', 'DUT GMP', 'DUT 2ème année Génie Mécanique et Productique', 'http://www.iutnantes.univ-nantes.fr/319/0/fiche___formation/&RH=1364294977339'),
('INFO', 'DUT INFO', 'DUT 2ème année Informatique', 'http://www.iutnantes.univ-nantes.fr/321/0/fiche___formation/&RH=1364294977339'),
('QLIO', 'DUT QLIO-1', 'DUT QLIO en 1 an', 'http://www.iutnantes.univ-nantes.fr/1762/0/fiche___formation/&RH=1364294977339&RF=1364294977339'),
('QLIO', 'DUT QLIO-2', 'DUT QLIO en 2 ans', 'http://www.iutnantes.univ-nantes.fr/1762/0/fiche___formation/&RH=1364294977339&RF=1364294977339'),
('SGM', 'DUT SGM', 'DUT 2ème année Science et Génie des Matériaux', 'http://www.iutnantes.univ-nantes.fr/754/0/fiche___formation/&RH=1364294977339'),
('SGM', 'LP D2M', 'LP Design, Matériaux et Modélisation', 'http://www.iutnantes.univ-nantes.fr/1201519012298/0/fiche___formation/&RH=1183119182323'),
('GMP', 'LP EAS', 'LP Electrohydraulique mobile et automatismes associés', 'http://www.iutnantes.univ-nantes.fr/SI00301/0/fiche___formation/&RH=1364301271082'),
('GTE', 'LP FICA', 'LP Froid Industriel et Conditionnement d''Air', 'http://www.iutnantes.univ-nantes.fr/1405083887231/0/fiche___formation/&RH=1364301271082&RF=1364301271082'),
('GMP', 'LP I2P', 'LP Innovations Produits Process', 'http://www.iutnantes.univ-nantes.fr/21201764597485/0/fiche___formation/&RH=1364301271082'),
('GEII', 'LP IDEB', 'LP Intelligence et Distribution Electrique du Bâtiment', 'http://www.iutnantes.univ-nantes.fr/1405080647109/0/fiche___formation/&RH=1364301271082'),
('SGM', 'LP IMOC', 'LP Industrialisation et Mise en Oeuvre des matériaux composites', 'http://www.iutnantes.univ-nantes.fr/30321595/0/fiche___formation/&RH=1364301271082'),
('QLIO', 'LP LOGIQUAL', 'LP Logistique et qualité', 'http://www.iutnantes.univ-nantes.fr/1199959931798/0/fiche___formation/&RH=1364301271082&RF=1364301271082'),
('GEII', 'LP SEICOM', 'LP Systèmes Electroniques et Informatiques Communicants', 'http://www.iutnantes.univ-nantes.fr/LPSEICOM/0/fiche___formation/&RH=1364301271082'),
('INFO', 'LP SIL', 'LP Systèmes informatiques et logiciels', 'http://www.iutnantes.univ-nantes.fr/SI00165/0/fiche___formation/&RH=1364301271082');

-- --------------------------------------------------------

--
-- Structure de la table `nouveauxcomptes`
--

CREATE TABLE IF NOT EXISTS `nouveauxcomptes` (
  `idNewCompte` int(11) NOT NULL,
  `typeCompte` varchar(255) NOT NULL,
  `id_compte` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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
('10:00:00', '14:00:00', 6, 8, 20, '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `temp_entreprise`
--

CREATE TABLE IF NOT EXISTS `temp_entreprise` (
  `IDEnt` int(11) NOT NULL,
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
  `adresseEnt` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `temp_etudiant`
--

CREATE TABLE IF NOT EXISTS `temp_etudiant` (
  `IDEtu` int(11) NOT NULL,
  `nomEtu` varchar(255) NOT NULL,
  `prenomEtu` varchar(255) NOT NULL,
  `mailEtu` varchar(255) NOT NULL,
  `mdpEtu` varchar(255) NOT NULL,
  `numtelEtu` varchar(10) NOT NULL,
  `formationEtu` varchar(255) NOT NULL,
  `listechoixEtu` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 COMMENT='Table qui contient tous les étudiants';

--
-- Contenu de la table `temp_etudiant`
--

INSERT INTO `temp_etudiant` (`IDEtu`, `nomEtu`, `prenomEtu`, `mailEtu`, `mdpEtu`, `numtelEtu`, `formationEtu`, `listechoixEtu`) VALUES
(13, 'Choquet', 'Lucas', 'lucas.choquet@etu.univ-nantes.fr', '$6$c34nKdv2nT.X$ozhAd9o.Gsw5Ulwy6sM.FOrWZUFi.qWugrABbwPXxhwF6icuM65xLusLseZKkKSUw3svhuWV0mrmeAOkSaMaW1', '0645392030', 'DUT INFO', '63,58,61'),
(14, 'Buisson', 'Florient', 'f.buisson@mail.com', '$1$g25.pT2.$HLz5AB5UJyDwZMMz8n0QM.', '0642157411', 'DCG', '57,60');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `creneau`
--
ALTER TABLE `creneau`
  ADD PRIMARY KEY (`numeroCreneau`,`idFormation`), ADD KEY `idFormation` (`idFormation`), ADD KEY `idEtudiant` (`idEtudiant`);

--
-- Index pour la table `demandesmdp`
--
ALTER TABLE `demandesmdp`
  ADD KEY `idDemande` (`idDemande`);

--
-- Index pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`IDEnt`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`IDEtu`);

--
-- Index pour la table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`IDformation`), ADD KEY `entPropose` (`entPropose`);

--
-- Index pour la table `listeFormations`
--
ALTER TABLE `listeFormations`
  ADD PRIMARY KEY (`initiales`);

--
-- Index pour la table `nouveauxcomptes`
--
ALTER TABLE `nouveauxcomptes`
  ADD PRIMARY KEY (`idNewCompte`);

--
-- Index pour la table `temp_entreprise`
--
ALTER TABLE `temp_entreprise`
  ADD PRIMARY KEY (`IDEnt`);

--
-- Index pour la table `temp_etudiant`
--
ALTER TABLE `temp_etudiant`
  ADD PRIMARY KEY (`IDEtu`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `demandesmdp`
--
ALTER TABLE `demandesmdp`
  MODIFY `idDemande` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `entreprise`
--
ALTER TABLE `entreprise`
  MODIFY `IDEnt` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT pour la table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `IDEtu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT pour la table `formation`
--
ALTER TABLE `formation`
  MODIFY `IDformation` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=794;
--
-- AUTO_INCREMENT pour la table `nouveauxcomptes`
--
ALTER TABLE `nouveauxcomptes`
  MODIFY `idNewCompte` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `temp_entreprise`
--
ALTER TABLE `temp_entreprise`
  MODIFY `IDEnt` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT pour la table `temp_etudiant`
--
ALTER TABLE `temp_etudiant`
  MODIFY `IDEtu` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `creneau`
--
ALTER TABLE `creneau`
ADD CONSTRAINT `FKEtudiant` FOREIGN KEY (`idEtudiant`) REFERENCES `etudiant` (`IDEtu`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `FKFormation` FOREIGN KEY (`idFormation`) REFERENCES `formation` (`IDformation`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `formation`
ADD CONSTRAINT `FKEnt` FOREIGN KEY (`entPropose`) REFERENCES `entreprise` (`IDEnt`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
