-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 12 Décembre 2014 à 15:20
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
(2, 2),
(1, 3),
(2, 3),
(1, 4),
(2, 4),
(1, 5),
(2, 5);

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
  `dateRdv` datetime NOT NULL,
  `commentaire` longtext COLLATE latin1_general_ci NOT NULL,
  `accepte` tinyint(1) NOT NULL,
  `idGroupe` int(11) NOT NULL,
  `idUtilisateur` int(4) NOT NULL,
  PRIMARY KEY (`idGroupe`,`idUtilisateur`),
  KEY `idUtilisateur` (`idUtilisateur`),
  KEY `idUtilisateur_2` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
(1, 'accepté'),
(2, 'refusé'),
(3, 'en cours');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`idUtilisateur`, `nom`, `prenom`, `email`, `password`, `NPA`, `nomRue`, `numeroRue`, `rayon`, `lat`, `lng`, `debutPause`, `finPause`) VALUES
(1, 'test', 'test', 'test@gmail.com', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', '1213', 'Chemin Gerard-de-ternier', '4', 6, '46.195033400000000000000000000000', '6.109267100000011000000000000000', '12:00:00', '13:00:00'),
(2, 'Mendez', 'Gregory', 'gregory@gmail.com', 'f6889fc97e14b42dec11a8c183ea791c5465b658', '1219', 'Avenue du lignon', '12', 12, '46.201140700000000000000000000000', '6.093081900000016000000000000000', '12:00:00', '13:00:00'),
(3, '', '', 'test2@test.com', 'f6889fc97e14b42dec11a8c183ea791c5465b658', '', '', '', 0, NULL, NULL, '00:00:00', '00:00:00');

--
-- Contraintes pour les tables exportées
--

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

--
-- Contraintes pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
  ADD CONSTRAINT `FK_avoir_idGroupe` FOREIGN KEY (`idGroupe`) REFERENCES `groupes` (`idGroupe`),
  ADD CONSTRAINT `rendezvous_ibfk_1` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateurs` (`idUtilisateur`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
