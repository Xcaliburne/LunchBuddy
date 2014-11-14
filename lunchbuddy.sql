-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 14 Novembre 2014 à 14:44
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
CREATE DATABASE `LunchBuddy`;
USE `LunchBuddy`;

-- --------------------------------------------------------

--
-- Structure de la table `avoir`
--

CREATE TABLE IF NOT EXISTS `avoir` (
  `dateRdv` datetime NOT NULL,
  `commentaire` longtext COLLATE latin1_general_ci NOT NULL,
  `accepte` tinyint(1) NOT NULL,
  `idGroupe` int(11) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  PRIMARY KEY (`idGroupe`,`idUtilisateur`),
  KEY `FK_avoir_idUtilisateur` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

CREATE TABLE IF NOT EXISTS `groupes` (
  `idGroupe` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `idStatut` int(11) NOT NULL,
  PRIMARY KEY (`idGroupe`),
  KEY `FK_GROUPES_idStatut` (`idStatut`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `jours`
--

CREATE TABLE IF NOT EXISTS `jours` (
  `idJour` int(11) NOT NULL AUTO_INCREMENT,
  `nomJour` varchar(25) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`idJour`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `statuts`
--

CREATE TABLE IF NOT EXISTS `statuts` (
  `idStatut` int(11) NOT NULL AUTO_INCREMENT,
  `nomStatut` varchar(25) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`idStatut`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `mdp` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `NPA` varchar(4) COLLATE latin1_general_ci NOT NULL,
  `nomRue` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `numeroRue` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `rayon` decimal(65,0) NOT NULL,
  `debutPause` time NOT NULL,
  `finPause` time NOT NULL,
  PRIMARY KEY (`idUtilisateur`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `avoir`
--
ALTER TABLE `avoir`
  ADD CONSTRAINT `FK_avoir_idUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`),
  ADD CONSTRAINT `FK_avoir_idGroupe` FOREIGN KEY (`idGroupe`) REFERENCES `groupes` (`idGroupe`);

--
-- Contraintes pour la table `disponible`
--
ALTER TABLE `disponible`
  ADD CONSTRAINT `FK_disponible_idJour` FOREIGN KEY (`idJour`) REFERENCES `jours` (`idJour`),
  ADD CONSTRAINT `FK_disponible_idUtilisateur` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);

--
-- Contraintes pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD CONSTRAINT `FK_GROUPES_idStatut` FOREIGN KEY (`idStatut`) REFERENCES `statuts` (`idStatut`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
