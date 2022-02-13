-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 06 jan. 2022 à 09:59
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cr_reunion`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualite`
--

DROP TABLE IF EXISTS `actualite`;
CREATE TABLE IF NOT EXISTS `actualite` (
  `ID_ACTU` int(2) NOT NULL AUTO_INCREMENT,
  `ID_CAT` int(2) NOT NULL,
  `TITRE` char(32) NOT NULL,
  `ACCROCHE` char(32) NOT NULL,
  `TEXTE` char(32) NOT NULL,
  `VALIDER` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_ACTU`),
  KEY `I_FK_ACTUALITE_CATEGORIE` (`ID_CAT`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `actu_audio`
--

DROP TABLE IF EXISTS `actu_audio`;
CREATE TABLE IF NOT EXISTS `actu_audio` (
  `ID_AUDIO` char(32) NOT NULL,
  `ID_ACTU` int(2) NOT NULL,
  PRIMARY KEY (`ID_AUDIO`,`ID_ACTU`),
  KEY `I_FK_ACTU_AUDIO_AUDIO` (`ID_AUDIO`),
  KEY `I_FK_ACTU_AUDIO_ACTUALITE` (`ID_ACTU`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `actu_piecejointe`
--

DROP TABLE IF EXISTS `actu_piecejointe`;
CREATE TABLE IF NOT EXISTS `actu_piecejointe` (
  `ID_PIECEJOINTE` int(2) NOT NULL,
  `ID_ACTU` int(2) NOT NULL,
  PRIMARY KEY (`ID_PIECEJOINTE`,`ID_ACTU`),
  KEY `I_FK_ACTU_PIECEJOINTE_PIECESJOINTES` (`ID_PIECEJOINTE`),
  KEY `I_FK_ACTU_PIECEJOINTE_ACTUALITE` (`ID_ACTU`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `actu_video`
--

DROP TABLE IF EXISTS `actu_video`;
CREATE TABLE IF NOT EXISTS `actu_video` (
  `ID_VIDEO` int(2) NOT NULL,
  `ID_ACTU` int(2) NOT NULL,
  PRIMARY KEY (`ID_VIDEO`,`ID_ACTU`),
  KEY `I_FK_ACTU_VIDEO_VIDEO` (`ID_VIDEO`),
  KEY `I_FK_ACTU_VIDEO_ACTUALITE` (`ID_ACTU`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `adminusers`
--

DROP TABLE IF EXISTS `adminusers`;
CREATE TABLE IF NOT EXISTS `adminusers` (
  `id_admin` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `prenom` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tel` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `passwords` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `recup` blob,
  `photo` varchar(500) DEFAULT NULL,
  `couleur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adminusers`
--

INSERT INTO `adminusers` (`id_admin`, `nom`, `prenom`, `tel`, `email`, `passwords`, `recup`, `photo`, `couleur`) VALUES
(1, 'bove', 'kylian', '0123654789', 'kylian@gm.fr', '$2y$10$oVTIUUg9s/kC4J6p1BkGIOYlT6ccWpdxFCssFOo8GDXvHhtYkIpIC', NULL, NULL, NULL),
(2, 'bove', 'kylian', '0123654789', 'kylian20@gm.fr', '$2y$10$/2GnO0/JsDQTJno1K3zmGOdsl0uMQNSDOkx.mDKxVZLINxwC5bvfi', NULL, NULL, NULL),
(5, 'bove', 'kylian', '0123654789', 'kylian27@gm.fr', '$2y$10$bx54vVA4DigxnX.UPCokZuczZzxN69CvY5MsRZmjkDg/1J3vHgpc2', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `audio`
--

DROP TABLE IF EXISTS `audio`;
CREATE TABLE IF NOT EXISTS `audio` (
  `ID_AUDIO` int(2) NOT NULL AUTO_INCREMENT,
  `TITRE` char(32) NOT NULL,
  `FICHIER` char(32) NOT NULL,
  PRIMARY KEY (`ID_AUDIO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `ID_CAT` int(2) NOT NULL AUTO_INCREMENT,
  `TITRE` char(32) NOT NULL,
  PRIMARY KEY (`ID_CAT`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `compte_rendu`
--

DROP TABLE IF EXISTS `compte_rendu`;
CREATE TABLE IF NOT EXISTS `compte_rendu` (
  `ID_CR` int(2) NOT NULL AUTO_INCREMENT,
  `ID_CAT` int(2) NOT NULL,
  `TITRE` char(32) NOT NULL,
  `ACCROCHE` char(32) NOT NULL,
  `TEXTE` char(32) NOT NULL,
  `VALIDER` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_CR`),
  KEY `I_FK_COMPTE_RENDU_CATEGORIE` (`ID_CAT`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id_contact` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `message` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_contact`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `contributeur`
--

DROP TABLE IF EXISTS `contributeur`;
CREATE TABLE IF NOT EXISTS `contributeur` (
  `id_contri` int(32) NOT NULL,
  `nom` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `prenom` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tel` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `passwords` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `recup` blob,
  `photo` varchar(500) DEFAULT NULL,
  `couleur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_contri`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `contribution`
--

DROP TABLE IF EXISTS `contribution`;
CREATE TABLE IF NOT EXISTS `contribution` (
  `ID_CONTRIBUTEUR` int(2) NOT NULL,
  `ID_USERS` int(2) NOT NULL,
  PRIMARY KEY (`ID_CONTRIBUTEUR`),
  UNIQUE KEY `I_FK_CONTRIBUTEURS_USERS` (`ID_USERS`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cr_audio`
--

DROP TABLE IF EXISTS `cr_audio`;
CREATE TABLE IF NOT EXISTS `cr_audio` (
  `ID_CR` int(2) NOT NULL,
  `ID_AUDIO` char(32) NOT NULL,
  PRIMARY KEY (`ID_CR`,`ID_AUDIO`),
  KEY `I_FK_CR_AUDIO_COMPTE_RENDU` (`ID_CR`),
  KEY `I_FK_CR_AUDIO_AUDIO` (`ID_AUDIO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cr_piecejointe`
--

DROP TABLE IF EXISTS `cr_piecejointe`;
CREATE TABLE IF NOT EXISTS `cr_piecejointe` (
  `ID_CR` int(2) NOT NULL,
  `ID_PIECEJOINTE` int(2) NOT NULL,
  PRIMARY KEY (`ID_CR`,`ID_PIECEJOINTE`),
  KEY `I_FK_CR_PIECEJOINTE_COMPTE_RENDU` (`ID_CR`),
  KEY `I_FK_CR_PIECEJOINTE_PIECESJOINTES` (`ID_PIECEJOINTE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `cr_video`
--

DROP TABLE IF EXISTS `cr_video`;
CREATE TABLE IF NOT EXISTS `cr_video` (
  `ID_CR` int(2) NOT NULL,
  `ID_VIDEO` int(2) NOT NULL,
  PRIMARY KEY (`ID_CR`,`ID_VIDEO`),
  KEY `I_FK_CR_VIDEO_COMPTE_RENDU` (`ID_CR`),
  KEY `I_FK_CR_VIDEO_VIDEO` (`ID_VIDEO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `infosutiles`
--

DROP TABLE IF EXISTS `infosutiles`;
CREATE TABLE IF NOT EXISTS `infosutiles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `logo` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `adresse` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `cp` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `ville` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `pays` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `tel` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `fax` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `facebook` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `twitter` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `youtube` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `pinterest` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `instagram` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `rss` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `accroche` varchar(1000) COLLATE latin1_general_ci DEFAULT NULL,
  `googlemap` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  `seoDescription` mediumtext COLLATE latin1_general_ci,
  `seoKeywords` mediumtext COLLATE latin1_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `infosutiles`
--

INSERT INTO `infosutiles` (`id`, `nom`, `logo`, `adresse`, `cp`, `ville`, `pays`, `tel`, `fax`, `email`, `facebook`, `twitter`, `youtube`, `pinterest`, `instagram`, `rss`, `accroche`, `googlemap`, `seoDescription`, `seoKeywords`) VALUES
(1, 'O18Market', '08595db77cd5c11db9d3ced8edd23e3c.png', '6 Rue MAURICE ROY', '18000', 'BOURGES', NULL, '0622073045', NULL, 'info@oslab-france.com', '', '', '', '', '', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s...', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2716.9335206557726!2d2.4123485155170523!3d47.08076727915335!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47fa965d58b7a4e3%3A0x1cff701c19937a9f!2s6%20Rue%20Maurice%20Roy%2C%2018000%20Bourges!5e0!3m2!1sfr!2sfr!4v1615726228714!5m2!1sfr!2sfr', 'Ici Méta description', 'keyword1, keyword2');

-- --------------------------------------------------------

--
-- Structure de la table `moderateur`
--

DROP TABLE IF EXISTS `moderateur`;
CREATE TABLE IF NOT EXISTS `moderateur` (
  `id_mod` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `prenom` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tel` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `passwords` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `recup` blob,
  `photo` varchar(500) DEFAULT NULL,
  `couleur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mod`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `moderateur`
--

INSERT INTO `moderateur` (`id_mod`, `nom`, `prenom`, `tel`, `email`, `passwords`, `recup`, `photo`, `couleur`) VALUES
(1, 'Bove', 'Kylian', '0123654789', 'kylianbove2@gm.fr', '$2y$10$/XliDkRpeWKMCWMWipSKJegyjMe5L3bW2O8o6/.jk2CxgKNa/.kjS', NULL, NULL, NULL),
(2, 'Bove', 'Kylian', '0123654789', 'kylianbove3@gm.fr', '$2y$10$o.l3D7sz9VDPSxarSL9eveGMW0CWNLZkEtvtlrUjV06D.Uan9bUgG', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `page_rgpd`
--

DROP TABLE IF EXISTS `page_rgpd`;
CREATE TABLE IF NOT EXISTS `page_rgpd` (
  `ID_RGPD` int(2) NOT NULL AUTO_INCREMENT,
  `TITRE` char(32) NOT NULL,
  `ACCROCHE` char(32) NOT NULL,
  `TEXTE` char(32) NOT NULL,
  PRIMARY KEY (`ID_RGPD`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `piecesjointes`
--

DROP TABLE IF EXISTS `piecesjointes`;
CREATE TABLE IF NOT EXISTS `piecesjointes` (
  `ID_PIECEJOINTE` int(2) NOT NULL AUTO_INCREMENT,
  `TITRE` char(32) NOT NULL,
  `FICHIER` char(32) NOT NULL,
  PRIMARY KEY (`ID_PIECEJOINTE`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `planning`
--

DROP TABLE IF EXISTS `planning`;
CREATE TABLE IF NOT EXISTS `planning` (
  `ID_PLANNING` int(2) NOT NULL,
  `DATE` datetime NOT NULL,
  `TITRE` char(32) NOT NULL,
  `DESCRIPTION` char(32) NOT NULL,
  `COULEUR` char(32) NOT NULL,
  PRIMARY KEY (`ID_PLANNING`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `redacteur`
--

DROP TABLE IF EXISTS `redacteur`;
CREATE TABLE IF NOT EXISTS `redacteur` (
  `id_redacteur` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `prenom` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tel` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `passwords` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `recup` blob,
  `photo` varchar(500) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_redacteur`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nom` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `prenom` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tel` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `passwords` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `recup` blob,
  `adresse` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `cp` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `ville` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `pays` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `typeUser` int(10) NOT NULL DEFAULT '1',
  `photo` varchar(500) DEFAULT NULL,
  `code` int(32) DEFAULT NULL,
  `datedebut` datetime DEFAULT NULL,
  `datefin` datetime DEFAULT NULL,
  `couleur` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `tel`, `email`, `passwords`, `recup`, `adresse`, `cp`, `ville`, `pays`, `typeUser`, `photo`, `code`, `datedebut`, `datefin`, `couleur`) VALUES
(49, 'Kylian', 'BOVE', '0601712205', 'kylianbove26@sfr.fr', '$2y$10$uEA8t5ibcmfIEUX0mlnU8eadfH1djkA2bGb0Yqq2lAHOFlKiApizO', NULL, '11 allÃ©e du vieux poirier', '28500', 'st gemme moronval', 'france', 1, NULL, 847646, NULL, NULL, NULL),
(48, 'Kylian', 'BOVE', '0601712205', 'kylianbove25@sfr.fr', '$2y$10$s94oWil0YLrqjVjjklNjc.4j27g3UPRsDc/KhTlBtpgjg//mJsVsS', NULL, '11 allÃ©e du vieux poirier', '28500', 'st gemme moronval', 'france', 1, NULL, 132542, NULL, NULL, NULL),
(47, 'Kylian', 'BOVE', '0601712205', 'kylianbove15@sfr.f9', '$2y$10$rrKRCppwGVrvoP//8uCFJ.Al9T64cE0xKkjY/cUIS5vw.aVdD5kIG', NULL, '11 allÃ©e du vieux poirier', '28500', 'st gemme moronval', 'france', 1, NULL, NULL, NULL, NULL, NULL),
(46, 'Kylian', 'BOVE', '0601712205', 'kylianbove15@sfr.fr', '$2y$10$YueewZnhDgyXEeyEYuMCA.5mTinJm899Q6MJCUjWtRwY1b8voUL8e', NULL, '11 allÃ©e du vieux poirier', '28500', 'st gemme moronval', 'france', 1, NULL, 0, NULL, NULL, NULL),
(44, 'Kylian', 'BOVE', '0601712205', 'kylianbove45@sfr.fr', '$2y$10$ZCAdqBslTwJoOqFI6lTy2O8xc6/7z7LfqLnkAYD9rEsSN9qsdVmmO', NULL, '11 allÃ©e du vieux poirier', '28500', 'st gemme moronval', 'france', 1, NULL, 210770, NULL, NULL, NULL),
(45, 'Kylian', 'BOVE', '0601712205', 'kylianbove12@sfr.fr', '$2y$10$h3EtO8A7kn3DmK1obfaRX.6L369/n1akPrahCRjSLsjkLSrJB5BEy', NULL, '11 allÃ©e du vieux poirier', '28500', 'st gemme moronval', 'france', 1, NULL, 123, NULL, NULL, NULL),
(42, 'Kylian', 'BOVE', '0601712205', 'kylianbove8@sfr.fr', '$2y$10$E.5wicr.G9emToPs.Vnr4OsnVbiF59.FhYgd1GWPL2S3ZXn2U.tNO', NULL, '11 allÃ©e du vieux poirier', '28500', 'st gemme moronval', 'france', 1, NULL, 392163, NULL, NULL, NULL),
(41, 'Kylian', 'BOVE', '0601712205', 'kylianbove2@sfr.fr', '$2y$10$1s/WbNztdTDigMlGGlfU9e8a4cXt3hgDngrtQLTw.7CMixVGqAWUi', NULL, '11 allÃ©e du vieux poirier', '28500', 'st gemme moronval', 'france', 1, NULL, 717305, NULL, NULL, NULL),
(43, 'Kylian', 'BOVE', '0601712205', 'kylianbove@sfr.fr', '$2y$10$8ZufQ93z6eVWTNL7Fzc3Ye34Rgat84hTL/eqYXtlTqEDQN0ThDqtK', NULL, '11 allÃ©e du vieux poirier', '28500', 'st gemme moronval', 'france', 1, NULL, 166862, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `ID_VIDEO` int(2) NOT NULL AUTO_INCREMENT,
  `TITRE` char(32) NOT NULL,
  `FICHIER` char(32) NOT NULL,
  PRIMARY KEY (`ID_VIDEO`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
