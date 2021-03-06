-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 09 Janvier 2015 à 12:42
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `lunchbuddy`
--

-- --------------------------------------------------------

--
-- Structure de la table `composer`
--

CREATE TABLE IF NOT EXISTS `composer` (
  `idUtilisateur` int(11) NOT NULL,
  `idGroupe` int(11) NOT NULL,
  `idStatut` int(11) NOT NULL,
  PRIMARY KEY (`idUtilisateur`,`idGroupe`,`idStatut`),
  KEY `idGroupe` (`idGroupe`),
  KEY `idStatut` (`idStatut`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `composer`
--

INSERT INTO `composer` (`idUtilisateur`, `idGroupe`, `idStatut`) VALUES
(1, 27, 1),
(2, 27, 1),
(8, 28, 1),
(9, 28, 1),
(1, 29, 1),
(8, 29, 3),
(1, 30, 2),
(8, 30, 3),
(1, 31, 1),
(9, 31, 3),
(1, 32, 1),
(8, 32, 3),
(1, 33, 1),
(2, 33, 3),
(1, 34, 1),
(9, 34, 3),
(1, 35, 1),
(9, 35, 3),
(1, 36, 3),
(2, 36, 3),
(1, 37, 1),
(9, 37, 3),
(1, 38, 1),
(8, 38, 3),
(1, 39, 1),
(2, 39, 3),
(1, 40, 1),
(9, 40, 3),
(1, 41, 1),
(8, 41, 3);

-- --------------------------------------------------------

--
-- Structure de la table `disponible`
--

CREATE TABLE IF NOT EXISTS `disponible` (
  `idUtilisateur` int(11) NOT NULL,
  `idJour` int(11) NOT NULL,
  PRIMARY KEY (`idUtilisateur`,`idJour`),
  KEY `FK_disponible_idJour` (`idJour`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Contenu de la table `disponible`
--

INSERT INTO `disponible` (`idUtilisateur`, `idJour`) VALUES
(1, 1),
(2, 1),
(1, 2),
(8, 2),
(2, 3),
(8, 3),
(1, 4),
(9, 4),
(1, 5),
(2, 5),
(8, 5),
(9, 5);

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

CREATE TABLE IF NOT EXISTS `groupes` (
  `idGroupe` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`idGroupe`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=42 ;

--
-- Contenu de la table `groupes`
--

INSERT INTO `groupes` (`idGroupe`, `nom`) VALUES
(27, 'gregory@gmail.com'),
(28, 'robin@gmail.com'),
(29, 'lu.gindre@gmail.com'),
(30, 'lu.gindre@gmail.com'),
(31, 'lu.gindre@gmail.com'),
(32, 'lu.gindre@gmail.com'),
(33, 'lu.gindre@gmail.com'),
(34, 'lu.gindre@gmail.com'),
(35, 'lu.gindre@gmail.com'),
(36, 'lu.gindre@gmail.com'),
(37, 'lu.gindre@gmail.com'),
(38, 'lu.gindre@gmail.com'),
(39, 'lu.gindre@gmail.com'),
(40, 'lu.gindre@gmail.com'),
(41, 'lu.gindre@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `jours`
--

CREATE TABLE IF NOT EXISTS `jours` (
  `idJour` int(11) NOT NULL AUTO_INCREMENT,
  `nomJour` varchar(25) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`idJour`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=6 ;

--
-- Contenu de la table `jours`
--

INSERT INTO `jours` (`idJour`, `nomJour`) VALUES
(1, 'Lundi'),
(2, 'Mardi'),
(3, 'Mercredi'),
(4, 'Jeudi'),
(5, 'Vendredi');

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

CREATE TABLE IF NOT EXISTS `rendezvous` (
  `idRdv` int(11) NOT NULL AUTO_INCREMENT,
  `dateRdv` date NOT NULL,
  `commentaire` longtext COLLATE latin1_general_ci NOT NULL,
  `idGroupe` int(11) NOT NULL,
  PRIMARY KEY (`idRdv`),
  KEY `idGroupe` (`idGroupe`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=26 ;

--
-- Contenu de la table `rendezvous`
--

INSERT INTO `rendezvous` (`idRdv`, `dateRdv`, `commentaire`, `idGroupe`) VALUES
(25, '2015-01-09', 'Sandwicherie onex 12:15', 28);

-- --------------------------------------------------------

--
-- Structure de la table `statuts`
--

CREATE TABLE IF NOT EXISTS `statuts` (
  `idStatut` int(11) NOT NULL AUTO_INCREMENT,
  `nomStatut` varchar(25) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`idStatut`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `statuts`
--

INSERT INTO `statuts` (`idStatut`, `nomStatut`) VALUES
(1, 'Accepté'),
(2, 'Refusé'),
(3, 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `prenom` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `NPA` varchar(4) COLLATE latin1_general_ci NOT NULL,
  `nomRue` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `numeroRue` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `rayon` int(4) NOT NULL,
  `lat` decimal(65,30) DEFAULT NULL,
  `lng` decimal(65,30) DEFAULT NULL,
  `debutPause` time NOT NULL,
  `finPause` time NOT NULL,
  PRIMARY KEY (`idUtilisateur`),
  UNIQUE KEY `pseudo` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateur`, `nom`, `prenom`, `email`, `password`, `NPA`, `nomRue`, `numeroRue`, `rayon`, `lat`, `lng`, `debutPause`, `finPause`) VALUES
(1, 'Gindre', 'Ludovic', 'lu.gindre@gmail.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '1213', 'Chemin Gerard-de-ternier', '6', 18, '46.195033400000000000000000000000', '6.109267100000011000000000000000', '12:00:00', '13:00:00'),
(2, 'Mendez', 'Gregory', 'gregory@gmail.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '1219', 'Avenue du lignon', '11', 12, '46.201140700000000000000000000000', '6.093081900000016000000000000000', '12:00:00', '13:00:00'),
(8, 'Pisanello', 'Antonio', 'antonio@gmail.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '1213', 'Bois de la chapelle', '5', 15, '46.191636000000000000000000000000', '6.109068000000000000000000000000', '12:00:00', '13:00:00'),
(9, 'Plojoux', 'Robin', 'robin@gmail.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '1213', 'Chemin des esserts', '5', 8, '46.190285000000000000000000000000', '6.114245000000000000000000000000', '12:00:00', '13:00:00');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `composer`
--
ALTER TABLE `composer`
  ADD CONSTRAINT `composer_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`),
  ADD CONSTRAINT `composer_ibfk_2` FOREIGN KEY (`idGroupe`) REFERENCES `groupes` (`idGroupe`),
  ADD CONSTRAINT `composer_ibfk_3` FOREIGN KEY (`idStatut`) REFERENCES `statuts` (`idStatut`);

--
-- Contraintes pour la table `disponible`
--
ALTER TABLE `disponible`
  ADD CONSTRAINT `FK_disponible_idJour` FOREIGN KEY (`idJour`) REFERENCES `jours` (`idJour`),
  ADD CONSTRAINT `FK_disponible_idUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Contraintes pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD CONSTRAINT `rendezvous_ibfk_1` FOREIGN KEY (`idGroupe`) REFERENCES `groupes` (`idGroupe`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
