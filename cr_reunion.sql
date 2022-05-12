-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 12 mai 2022 à 13:22
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
  `id_actu` int(2) NOT NULL AUTO_INCREMENT,
  `id_cat` int(2) DEFAULT NULL,
  `titre` varchar(1000) NOT NULL,
  `accroche` longtext NOT NULL,
  `texte` longtext NOT NULL,
  `valider` tinyint(1) DEFAULT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  `date_publication` datetime DEFAULT NULL,
  `date_modification` datetime DEFAULT NULL,
  `affichage` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_actu`),
  KEY `FK_C_ID` (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `actualite`
--

INSERT INTO `actualite` (`id_actu`, `id_cat`, `titre`, `accroche`, `texte`, `valider`, `publier`, `date_publication`, `date_modification`, `affichage`) VALUES
(15, 3, 'Test Complet', '<p><span style=\"color: rgb(17, 17, 17);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis</span></p>', '<p><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span></p>', 1, 1, '2022-01-12 14:13:24', '2022-03-17 17:33:47', 0),
(17, 3, 'test2', '<p>test</p>', '<p>Ghjgnh</p>', 1, 1, '2022-01-14 13:56:38', '2022-01-20 16:59:18', 0),
(18, 3, 'test25', '<p>azerty</p>', '<p><span source=\"\" sans=\"\" pro\",=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\" style=\"padding: 0px; margin: 0px; outline: none; font-size: 14px; font-family: &quot;Source Sans Pro&quot;, sans-serif; color: rgb(17, 17, 17);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span source=\"\" sans=\"\" pro\",=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\" style=\"padding: 0px; margin: 0px; outline: none; font-size: 14px; font-family: &quot;Source Sans Pro&quot;, sans-serif; color: rgb(17, 17, 17);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span source=\"\" sans=\"\" pro\",=\"\" sans-serif;=\"\" font-size:=\"\" 14px;\"=\"\" style=\"padding: 0px; margin: 0px; outline: none; font-size: 14px; font-family: &quot;Source Sans Pro&quot;, sans-serif; color: rgb(17, 17, 17);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span></p>', 1, 1, '2022-01-14 13:56:55', '2022-01-24 10:39:00', 0),
(19, 2, 'testcontri2', '<p>erdhfn</p>', '<p>vedc</p>', 1, 1, '2022-01-17 14:39:58', '2022-01-24 13:30:30', 0),
(20, 2, 'test', '<p>EGD</p>', '<p>egvd</p>', 1, 1, '2022-01-20 15:16:37', '2022-01-25 14:36:12', 1),
(21, 2, 'testactu', '<p><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span></p>', '<p><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span></p>', 1, 1, '2022-01-24 13:33:43', '2022-01-25 14:36:05', 1),
(22, 3, 'test', '<p><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span></p>', '<p><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span></p>', 1, 1, '2022-01-24 13:34:03', NULL, 0),
(23, 2, 'connectÃ©', '<p><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit,</span></p>', '<p><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span></p>', 1, 1, '2022-01-24 13:34:25', '2022-01-25 16:08:39', 1),
(24, 3, 'non connectÃ©', '<p><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliquav</span><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span></p>', '<p><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span></p>', 1, 1, '2022-01-24 14:38:35', '2022-01-25 16:17:06', 0),
(25, 3, 'executif', '<p><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span></p>', '<p><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span></p>', 1, 1, '2022-01-24 14:39:20', '2022-01-25 16:16:47', 4),
(26, 3, 'testuser3', '<p>test</p>', '<p><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span></p>', 1, 1, '2022-01-24 14:40:00', '2022-01-25 16:06:19', 3);

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
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adminusers`
--

INSERT INTO `adminusers` (`id_admin`, `nom`, `prenom`, `tel`, `email`, `passwords`, `recup`, `photo`, `couleur`, `token`) VALUES
(23, 'bove', 'kylian', '0123654789', 'login@gm.fr', '$2y$10$w16AFDO0wHvKFVsmdSLoGujf2zlwrEP2ryeLddt1WJw/xflor7a.G', NULL, 'DSCN3326.JPG', NULL, NULL),
(26, 'bove', 'kylian', '0123654789', 'kylian@gm.fr', '$2y$10$/dLEaxXxRFI6VtJjstbfNeumBsN6nktuBWPI/KVW0Op14CLLjYXr6', NULL, 'DSCN3326.JPG', '#007DFF', '733978006277c73ae4cc64.42980375');

-- --------------------------------------------------------

--
-- Structure de la table `audio`
--

DROP TABLE IF EXISTS `audio`;
CREATE TABLE IF NOT EXISTS `audio` (
  `id_audio` int(2) NOT NULL AUTO_INCREMENT,
  `id_actu` int(2) DEFAULT NULL,
  `titre` char(32) NOT NULL,
  `fichier` varchar(1000) NOT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_audio`),
  KEY `I_FK_AUDIO_ACTUALITE` (`id_actu`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `audio`
--

INSERT INTO `audio` (`id_audio`, `id_actu`, `titre`, `fichier`, `publier`) VALUES
(4, 15, 'test audio', '15-L\'Angleterre fait une pub anti-Afghans - Tanguy Pastureau maltraite l\'info.mp3', 1),
(3, 15, 'test', '5-Soprano - Le Coach feat. Vincenzo (Clip officiel).mp3', 1),
(6, 24, 'test', '24-5-Soprano - Le Coach feat. Vincenzo (Clip officiel).mp3', 1);

-- --------------------------------------------------------

--
-- Structure de la table `bloc_contri`
--

DROP TABLE IF EXISTS `bloc_contri`;
CREATE TABLE IF NOT EXISTS `bloc_contri` (
  `id_bloc` int(10) NOT NULL AUTO_INCREMENT,
  `titre` varchar(500) NOT NULL,
  `accroche` longtext NOT NULL,
  PRIMARY KEY (`id_bloc`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `bloc_contri`
--

INSERT INTO `bloc_contri` (`id_bloc`, `titre`, `accroche`) VALUES
(1, 'Bloc Contributeur', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</p>');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_cat` int(2) NOT NULL AUTO_INCREMENT,
  `titre` char(32) NOT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_cat`, `titre`, `publier`) VALUES
(3, 'categorie2', 1),
(2, 'categorie1', 1);

-- --------------------------------------------------------

--
-- Structure de la table `compte_rendu`
--

DROP TABLE IF EXISTS `compte_rendu`;
CREATE TABLE IF NOT EXISTS `compte_rendu` (
  `id_cr` int(2) NOT NULL AUTO_INCREMENT,
  `id_cat` int(2) NOT NULL,
  `titre` varchar(1000) NOT NULL,
  `accroche` longtext NOT NULL,
  `texte` longtext NOT NULL,
  `valider` tinyint(1) DEFAULT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  `date_publication` datetime DEFAULT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id_cr`),
  KEY `I_FK_COMPTE_RENDU_CATEGORIE` (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `compte_rendu`
--

INSERT INTO `compte_rendu` (`id_cr`, `id_cat`, `titre`, `accroche`, `texte`, `valider`, `publier`, `date_publication`, `date_modification`) VALUES
(2, 1, 'test2', '<p><span style=\"color: rgb(17, 17, 17); font-family: \"Source Sans Pro\", sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span></p>', '<p><span style=\"color: rgb(17, 17, 17);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17);\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span></p>', 1, 1, '2022-01-12 16:37:57', '2022-01-24 12:02:28'),
(4, 2, 'test21', '<p>bts</p>', '<p>bfwbf</p>', 1, 1, '2022-01-12 16:40:51', '2022-01-24 15:46:40'),
(5, 2, 'test', '<p><u>gvb,y</u></p>', '<p>hfbngn</p>', 1, 1, '2022-01-12 16:41:31', '2022-01-24 15:46:46'),
(7, 2, 'testcat', '<div class=\"droiteContent\" style=\"padding: 0px 0.75rem; margin: 0px 0px 1rem; outline: none;\" source=\"\" sans=\"\" pro\",=\"\" sans-serif;\"=\"\"><div class=\"accroche\" style=\"padding: 0px 0px 0.75rem; margin: 0px; outline: none;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</div></div>', '<p>htf</p>', 1, 1, '2022-01-14 15:26:05', '2022-01-24 15:46:51'),
(8, 2, 'testcontri2', '<p>esg</p>', '<p>brf</p>', 1, 1, '2022-01-17 14:45:20', '2022-01-24 15:47:05'),
(9, 2, 'test_cr', '<p><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span></p>', '<p><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span></p>', 1, 1, '2022-01-24 15:47:30', NULL),
(10, 2, 'test', '<p><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida.</span></p>', '<p><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span></p>', 1, 1, '2022-01-24 15:47:52', NULL),
(11, 2, 'compte rendu', '<p><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span></p>', '<p><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span></p>', 1, 1, '2022-01-24 15:48:11', NULL),
(12, 1, 'test reunion', '<p><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span></p>', '<p><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span><span style=\"color: rgb(17, 17, 17); font-family: &quot;Source Sans Pro&quot;, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.</span></p>', 1, 1, '2022-01-24 15:48:30', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id_contact` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `message` longtext CHARACTER SET latin1 COLLATE latin1_general_ci,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `tel` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id_contact`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id_contact`, `email`, `message`, `nom`, `prenom`, `tel`) VALUES
(1, 'test@gm.fr', 'test d\'envoie de mail', '', '', NULL),
(2, 'kylian@gm.fr', 'test', '', '', NULL),
(5, 'contact@gm.fr', 'test', 'bove', 'kylian', '0123654789'),
(4, 'contact@gm.fr', 'test', 'bove', 'kylian', ''),
(6, 'kylian@gm.fr', 'dr', 'bove', 'kylian', '0123654789'),
(7, 'kylian@gm.fr', 'azerty', 'bove', 'kylian', '0123654789'),
(8, 'kylian@gm.fr', 'azery', 'bove', 'kylian', '0123654789'),
(9, 'kylianbove@sfr.fr', 'tttttttt', 'Bove', 'Kylian', '0601712205'),
(10, 'kylianbove@sfr.fr', '\'', 'Bove', 'Kylian', '0601712205'),
(11, 'kikibove@gmail.com', 'test de mail', 'Bove', 'Kylian', '0601712205'),
(12, 'kikibove@gmail.com', 'test ', 'Bove', 'Kylian', '0601712205'),
(13, 'test@gm.fr', 'test', 'tets', 'test2', '0123654789');

-- --------------------------------------------------------

--
-- Structure de la table `contributeur`
--

DROP TABLE IF EXISTS `contributeur`;
CREATE TABLE IF NOT EXISTS `contributeur` (
  `id_contri` int(32) NOT NULL AUTO_INCREMENT,
  `nom` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `prenom` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `tel` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `passwords` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `recup` blob,
  `photo` varchar(500) DEFAULT NULL,
  `couleur` varchar(255) DEFAULT NULL,
  `actif` tinyint(1) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_contri`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contributeur`
--

INSERT INTO `contributeur` (`id_contri`, `nom`, `prenom`, `tel`, `email`, `passwords`, `recup`, `photo`, `couleur`, `actif`, `token`) VALUES
(2, 'tets', 'test2', '0123654789', 'test@gm.fr', '$2y$10$JnEnevx4fhDnH9rCZlWds.sSRd3IfgSmxyhvgB0YCUm8SFqXCBgTe', NULL, NULL, NULL, 1, NULL),
(5, 'bove', 'kylian', '0123654789', 'kylian3@gm.fr', '$2y$10$uojj.HF.P/sT1JZQ6GKOZOWbNCpFT1.zt8f1diILwNBd12Vmlue1C', NULL, NULL, NULL, 0, NULL),
(13, 'bove', 'kylian', '0123654789', 'contri@gm.fr', '$2y$10$8SQqDfX.6zO.4bvzZUN0geWnBDSjGIaFH.OHC1OZObW2kuBn3JHgW', NULL, 'DSCN3325.JPG', '#600000', 1, NULL),
(7, 'bove', 'kylian', '0123654789', 'kylian36@gm.fr', '$2y$10$IjYOA5pG5JhnTJQMWWy05eeGJb0cTHQbI0IHCCMswqtbz.1yUmbPq', NULL, NULL, '#CCA1A1', 0, NULL),
(9, 'bove', 'kylian', '0123654789', 'kyliantestphoto@gm.fr', '$2y$10$sN61cAXKDVp49kgWVvtxeOmIxL9qzVkih.jlzStun/jjlPc7Oauk.', NULL, 'DSCN3326.JPG', '#FF0068', 0, NULL),
(10, 'bove', 'kylian', '0123654789', 'kyliantestcouleur@gm.fr', '$2y$10$1QYBTfTm0oaimfbFM46vn.jwSIcvY2TwM1ssLgc7ew0XIKM1IbsHm', NULL, NULL, '#00FF0D', 0, NULL),
(11, 'bove', 'kylian', '0123654789', 'kyliancontri@gm.fr', '$2y$10$tuzHCsPt9y6Y8rndWvrkmeD8yglqEMMMQ9EQwmnuvZGaTcOzKq82W', NULL, NULL, '#FF0000', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contribution`
--

DROP TABLE IF EXISTS `contribution`;
CREATE TABLE IF NOT EXISTS `contribution` (
  `id_contribution` int(2) NOT NULL AUTO_INCREMENT,
  `id_users` int(2) NOT NULL,
  `titre` char(255) NOT NULL,
  `details` longtext NOT NULL,
  `valider` tinyint(1) DEFAULT NULL,
  `valider_par` varchar(255) DEFAULT NULL,
  `date_validation` datetime DEFAULT NULL,
  PRIMARY KEY (`id_contribution`),
  KEY `I_FK_CONTRIBUTION_USERS` (`id_users`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `contribution`
--

INSERT INTO `contribution` (`id_contribution`, `id_users`, `titre`, `details`, `valider`, `valider_par`, `date_validation`) VALUES
(1, 49, 'testcontri', '<p>test</p>', 1, '', '2022-01-14 14:04:08'),
(3, 49, 'test2', '<p>test</p>', 1, 'bove kylian', '2022-05-12 14:47:33'),
(4, 49, 'test', '<p>test date</p>', 1, '', '2022-01-13 16:13:07'),
(5, 49, 'testdate', '<p>test</p>', 1, '', '2022-01-13 13:50:17'),
(6, 60, 'test', 'azerty', 1, 'bove kylian', '2022-05-12 14:47:37'),
(7, 81, 'demande de participation', 'je souhaite participer Ã  la rÃ©union du 30/01/2021', 1, 'bove kylian', '2022-03-17 14:37:37'),
(8, 81, 'demande de participation', 'je souhaite participer Ã  la rÃ©union du 30/01/2021', 1, 'bove kylian', '2022-03-17 14:37:33'),
(12, 102, 'test', '10', 1, 'bove kylian', '2022-03-17 15:11:39');

-- --------------------------------------------------------

--
-- Structure de la table `cr_audio`
--

DROP TABLE IF EXISTS `cr_audio`;
CREATE TABLE IF NOT EXISTS `cr_audio` (
  `id_audio` int(2) NOT NULL AUTO_INCREMENT,
  `id_cr` int(2) DEFAULT NULL,
  `titre` char(32) NOT NULL,
  `fichier` varchar(1000) NOT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_audio`),
  KEY `I_FK_AUDIO_COMPTE_RENDU` (`id_cr`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cr_audio`
--

INSERT INTO `cr_audio` (`id_audio`, `id_cr`, `titre`, `fichier`, `publier`) VALUES
(4, 2, 'test', '2-L\'Angleterre fait une pub anti-Afghans - Tanguy Pastureau maltraite l\'info.mp3', 1),
(2, 2, 'test', '2-Soprano - Le Coach feat. Vincenzo (Clip officiel).mp3', 1),
(5, 12, 'test', '12-5-Soprano - Le Coach feat. Vincenzo (Clip officiel).mp3', 1);

-- --------------------------------------------------------

--
-- Structure de la table `cr_categorie`
--

DROP TABLE IF EXISTS `cr_categorie`;
CREATE TABLE IF NOT EXISTS `cr_categorie` (
  `id_cat` int(2) NOT NULL AUTO_INCREMENT,
  `titre` char(32) NOT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cr_categorie`
--

INSERT INTO `cr_categorie` (`id_cat`, `titre`, `publier`) VALUES
(1, 'testcat2', 1),
(2, 'test', 1);

-- --------------------------------------------------------

--
-- Structure de la table `cr_image`
--

DROP TABLE IF EXISTS `cr_image`;
CREATE TABLE IF NOT EXISTS `cr_image` (
  `id_img` int(2) NOT NULL AUTO_INCREMENT,
  `id_cr` int(2) DEFAULT NULL,
  `titre` char(32) NOT NULL,
  `fichier` varchar(1000) NOT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_img`),
  KEY `I_FK_IMAGE_COMPTE_RENDU` (`id_cr`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cr_image`
--

INSERT INTO `cr_image` (`id_img`, `id_cr`, `titre`, `fichier`, `publier`) VALUES
(1, 2, 'test2', '2-DSCN3536.JPG', 1),
(2, 2, 'testimg', '2-DSCN3550.JPG', 1),
(3, 11, 'test', '11-DSCN3337.JPG', 1),
(4, 11, 'test', '11-DSCN3342.JPG', 1),
(5, 12, 'test', '12-DSCN3336.JPG', 1);

-- --------------------------------------------------------

--
-- Structure de la table `cr_piecesjointes`
--

DROP TABLE IF EXISTS `cr_piecesjointes`;
CREATE TABLE IF NOT EXISTS `cr_piecesjointes` (
  `id_piecejointe` int(2) NOT NULL AUTO_INCREMENT,
  `id_cr` int(2) DEFAULT NULL,
  `titre` char(32) NOT NULL,
  `fichier` varchar(1000) NOT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_piecejointe`),
  KEY `I_FK_PIECESJOINTES_COMPTE_RENDU` (`id_cr`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cr_piecesjointes`
--

INSERT INTO `cr_piecesjointes` (`id_piecejointe`, `id_cr`, `titre`, `fichier`, `publier`) VALUES
(1, 2, 'test2', '2-Classeur1.xlsx', 1),
(3, 2, 'test', '2-test.doc', 1),
(4, 2, 'test2', '2-test.pdf', 1),
(5, 12, 'test', '12-test.doc', 1);

-- --------------------------------------------------------

--
-- Structure de la table `cr_video`
--

DROP TABLE IF EXISTS `cr_video`;
CREATE TABLE IF NOT EXISTS `cr_video` (
  `id_video` int(2) NOT NULL AUTO_INCREMENT,
  `id_cr` int(2) DEFAULT NULL,
  `titre` char(32) NOT NULL,
  `fichier` varchar(500) NOT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_video`),
  KEY `I_FK_VIDEO_COMPTE_RENDU` (`id_cr`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `cr_video`
--

INSERT INTO `cr_video` (`id_video`, `id_cr`, `titre`, `fichier`, `publier`) VALUES
(1, 2, 'testvideo2', '2-tirage_x264.mp4', 1),
(2, 2, 'testvideo', '2-tirage_x264.mp4', 1),
(4, 7, 'test', '7-tirage_x264.mp4', 0),
(5, 12, 'test', '12-tik5_x264.mp4', 1);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id_img` int(2) NOT NULL AUTO_INCREMENT,
  `id_actu` int(2) DEFAULT NULL,
  `titre` char(32) NOT NULL,
  `fichier` varchar(1000) NOT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_img`),
  KEY `I_FK_IMAGE_ACTUALITE` (`id_actu`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id_img`, `id_actu`, `titre`, `fichier`, `publier`) VALUES
(4, 17, 'test2', '13-DSCN3539.JPG', 1),
(5, 15, 'image2', '5-DSCN3536.JPG', 1),
(3, 15, 'test', '15-DSCN3319.JPG', 1),
(6, 15, 'test2', '15-DSCN3326.JPG', 1),
(7, 24, 'test', '24-DSCN3543.JPG', 1),
(8, 24, 'test2', '24-DSCN3542.JPG', 1);

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
  `info_bienvenue` varchar(500) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci ROW_FORMAT=DYNAMIC;

--
-- Déchargement des données de la table `infosutiles`
--

INSERT INTO `infosutiles` (`id`, `nom`, `logo`, `adresse`, `cp`, `ville`, `pays`, `tel`, `fax`, `email`, `facebook`, `twitter`, `youtube`, `pinterest`, `instagram`, `rss`, `accroche`, `googlemap`, `seoDescription`, `seoKeywords`, `info_bienvenue`) VALUES
(1, 'MES', 'mes.png', '6 Rue MAURICE ROY', '18000', 'BOURGES', NULL, '0622073045', NULL, 'info@oslab-france.com', '', '', '', '', '', '', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s...', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d84184.47051848588!2d1.2878424539475288!3d48.74819132842936!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e1551ee0688e79%3A0x40dc8d7053981f0!2s28100%20Dreux!5e0!3m2!1sfr!2sfr!4v1643208123814!5m2!1sfr!2sfr', 'Ici la description', 'keyword1, keyword2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis.');

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
  `actif` tinyint(1) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mod`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `moderateur`
--

INSERT INTO `moderateur` (`id_mod`, `nom`, `prenom`, `tel`, `email`, `passwords`, `recup`, `photo`, `couleur`, `actif`, `token`) VALUES
(8, 'bove', 'kylian', '0123654789', 'kylianmod@gm.fr', '$2y$10$2srm0MEpPoAxWOhwEtflO.SRutX13v6Omkd37NXiAZA97Oh27VD4S', NULL, NULL, '#374068', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `page_rgpd`
--

DROP TABLE IF EXISTS `page_rgpd`;
CREATE TABLE IF NOT EXISTS `page_rgpd` (
  `id_rgpd` int(2) NOT NULL AUTO_INCREMENT,
  `titre` char(32) NOT NULL,
  `accroche` char(32) NOT NULL,
  `texte` char(32) NOT NULL,
  PRIMARY KEY (`id_rgpd`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `alpha3` varchar(3) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nom` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alpha3` (`alpha3`)
) ENGINE=MyISAM AUTO_INCREMENT=242 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id`, `alpha3`, `nom`) VALUES
(1, 'AFG', 'Afghanistan'),
(2, 'ALB', 'Albanie'),
(3, 'ATA', 'Antarctique'),
(4, 'DZA', 'AlgÃ©rie'),
(5, 'ASM', 'Samoa AmÃ©ricaines'),
(6, 'AND', 'Andorre'),
(7, 'AGO', 'Angola'),
(8, 'ATG', 'Antigua-et-Barbuda'),
(9, 'AZE', 'AzerbaÃ¯djan'),
(10, 'ARG', 'Argentine'),
(11, 'AUS', 'Australie'),
(12, 'AUT', 'Autriche'),
(13, 'BHS', 'Bahamas'),
(14, 'BHR', 'BahreÃ¯n'),
(15, 'BGD', 'Bangladesh'),
(16, 'ARM', 'ArmÃ©nie'),
(17, 'BRB', 'Barbade'),
(18, 'BEL', 'Belgique'),
(19, 'BMU', 'Bermudes'),
(20, 'BTN', 'Bhoutan'),
(21, 'BOL', 'Bolivie'),
(22, 'BIH', 'Bosnie-HerzÃ©govine'),
(23, 'BWA', 'Botswana'),
(24, 'BVT', 'ÃŽle Bouvet'),
(25, 'BRA', 'BrÃ©sil'),
(26, 'BLZ', 'Belize'),
(27, 'IOT', 'Territoire Britannique de l\'OcÃ©an Indien'),
(28, 'SLB', 'ÃŽles Salomon'),
(29, 'VGB', 'ÃŽles Vierges Britanniques'),
(30, 'BRN', 'BrunÃ©i Darussalam'),
(31, 'BGR', 'Bulgarie'),
(32, 'MMR', 'Myanmar'),
(33, 'BDI', 'Burundi'),
(34, 'BLR', 'BÃ©larus'),
(35, 'KHM', 'Cambodge'),
(36, 'CMR', 'Cameroun'),
(37, 'CAN', 'Canada'),
(38, 'CPV', 'Cap-vert'),
(39, 'CYM', 'ÃŽles CaÃ¯manes'),
(40, 'CAF', 'RÃ©publique Centrafricaine'),
(41, 'LKA', 'Sri Lanka'),
(42, 'TCD', 'Tchad'),
(43, 'CHL', 'Chili'),
(44, 'CHN', 'Chine'),
(45, 'TWN', 'TaÃ¯wan'),
(46, 'CXR', 'ÃŽle Christmas'),
(47, 'CCK', 'ÃŽles Cocos (Keeling)'),
(48, 'COL', 'Colombie'),
(49, 'COM', 'Comores'),
(50, 'MYT', 'Mayotte'),
(51, 'COG', 'RÃ©publique du Congo'),
(52, 'COD', 'RÃ©publique DÃ©mocratique du Congo'),
(53, 'COK', 'ÃŽles Cook'),
(54, 'CRI', 'Costa Rica'),
(55, 'HRV', 'Croatie'),
(56, 'CUB', 'Cuba'),
(57, 'CYP', 'Chypre'),
(58, 'CZE', 'RÃ©publique TchÃ¨que'),
(59, 'BEN', 'BÃ©nin'),
(60, 'DNK', 'Danemark'),
(61, 'DMA', 'Dominique'),
(62, 'DOM', 'RÃ©publique Dominicaine'),
(63, 'ECU', 'Ã‰quateur'),
(64, 'SLV', 'El Salvador'),
(65, 'GNQ', 'GuinÃ©e Ã‰quatoriale'),
(66, 'ETH', 'Ã‰thiopie'),
(67, 'ERI', 'Ã‰rythrÃ©e'),
(68, 'EST', 'Estonie'),
(69, 'FRO', 'ÃŽles FÃ©roÃ©'),
(70, 'FLK', 'ÃŽles (malvinas) Falkland'),
(71, 'SGS', 'GÃ©orgie du Sud et les ÃŽles Sandwich du Sud'),
(72, 'FJI', 'Fidji'),
(73, 'FIN', 'Finlande'),
(74, 'ALA', 'ÃŽles Ã…land'),
(75, 'FRA', 'France'),
(76, 'GUF', 'Guyane FranÃ§aise'),
(77, 'PYF', 'PolynÃ©sie FranÃ§aise'),
(78, 'ATF', 'Terres Australes FranÃ§aises'),
(79, 'DJI', 'Djibouti'),
(80, 'GAB', 'Gabon'),
(81, 'GEO', 'GÃ©orgie'),
(82, 'GMB', 'Gambie'),
(83, 'PSE', 'Territoire Palestinien OccupÃ©'),
(84, 'DEU', 'Allemagne'),
(85, 'GHA', 'Ghana'),
(86, 'GIB', 'Gibraltar'),
(87, 'KIR', 'Kiribati'),
(88, 'GRC', 'GrÃ¨ce'),
(89, 'GRL', 'Groenland'),
(90, 'GRD', 'Grenade'),
(91, 'GLP', 'Guadeloupe'),
(92, 'GUM', 'Guam'),
(93, 'GTM', 'Guatemala'),
(94, 'GIN', 'GuinÃ©e'),
(95, 'GUY', 'Guyana'),
(96, 'HTI', 'HaÃ¯ti'),
(97, 'HMD', 'ÃŽles Heard et Mcdonald'),
(98, 'VAT', 'Saint-SiÃ¨ge (Ã©tat de la CitÃ© du Vatican)'),
(99, 'HND', 'Honduras'),
(100, 'HKG', 'Hong-Kong'),
(101, 'HUN', 'Hongrie'),
(102, 'ISL', 'Islande'),
(103, 'IND', 'Inde'),
(104, 'IDN', 'IndonÃ©sie'),
(105, 'IRN', 'RÃ©publique Islamique d\'Iran'),
(106, 'IRQ', 'Iraq'),
(107, 'IRL', 'Irlande'),
(108, 'ISR', 'IsraÃ«l'),
(109, 'ITA', 'Italie'),
(110, 'CIV', 'CÃ´te d\'Ivoire'),
(111, 'JAM', 'JamaÃ¯que'),
(112, 'JPN', 'Japon'),
(113, 'KAZ', 'Kazakhstan'),
(114, 'JOR', 'Jordanie'),
(115, 'KEN', 'Kenya'),
(116, 'PRK', 'RÃ©publique Populaire DÃ©mocratique de CorÃ©e'),
(117, 'KOR', 'RÃ©publique de CorÃ©e'),
(118, 'KWT', 'KoweÃ¯t'),
(119, 'KGZ', 'Kirghizistan'),
(120, 'LAO', 'RÃ©publique DÃ©mocratique Populaire Lao'),
(121, 'LBN', 'Liban'),
(122, 'LSO', 'Lesotho'),
(123, 'LVA', 'Lettonie'),
(124, 'LBR', 'LibÃ©ria'),
(125, 'LBY', 'Jamahiriya Arabe Libyenne'),
(126, 'LIE', 'Liechtenstein'),
(127, 'LTU', 'Lituanie'),
(128, 'LUX', 'Luxembourg'),
(129, 'MAC', 'Macao'),
(130, 'MDG', 'Madagascar'),
(131, 'MWI', 'Malawi'),
(132, 'MYS', 'Malaisie'),
(133, 'MDV', 'Maldives'),
(134, 'MLI', 'Mali'),
(135, 'MLT', 'Malte'),
(136, 'MTQ', 'Martinique'),
(137, 'MRT', 'Mauritanie'),
(138, 'MUS', 'Maurice'),
(139, 'MEX', 'Mexique'),
(140, 'MCO', 'Monaco'),
(141, 'MNG', 'Mongolie'),
(142, 'MDA', 'RÃ©publique de Moldova'),
(143, 'MSR', 'Montserrat'),
(144, 'MAR', 'Maroc'),
(145, 'MOZ', 'Mozambique'),
(146, 'OMN', 'Oman'),
(147, 'NAM', 'Namibie'),
(148, 'NRU', 'Nauru'),
(149, 'NPL', 'NÃ©pal'),
(150, 'NLD', 'Pays-Bas'),
(151, 'ANT', 'Antilles NÃ©erlandaises'),
(152, 'ABW', 'Aruba'),
(153, 'NCL', 'Nouvelle-CalÃ©donie'),
(154, 'VUT', 'Vanuatu'),
(155, 'NZL', 'Nouvelle-ZÃ©lande'),
(156, 'NIC', 'Nicaragua'),
(157, 'NER', 'Niger'),
(158, 'NGA', 'NigÃ©ria'),
(159, 'NIU', 'NiuÃ©'),
(160, 'NFK', 'ÃŽle Norfolk'),
(161, 'NOR', 'NorvÃ¨ge'),
(162, 'MNP', 'ÃŽles Mariannes du Nord'),
(163, 'UMI', 'ÃŽles Mineures Ã‰loignÃ©es des Ã‰tats-Unis'),
(164, 'FSM', 'Ã‰tats FÃ©dÃ©rÃ©s de MicronÃ©sie'),
(165, 'MHL', 'ÃŽles Marshall'),
(166, 'PLW', 'Palaos'),
(167, 'PAK', 'Pakistan'),
(168, 'PAN', 'Panama'),
(169, 'PNG', 'Papouasie-Nouvelle-GuinÃ©e'),
(170, 'PRY', 'Paraguay'),
(171, 'PER', 'PÃ©rou'),
(172, 'PHL', 'Philippines'),
(173, 'PCN', 'Pitcairn'),
(174, 'POL', 'Pologne'),
(175, 'PRT', 'Portugal'),
(176, 'GNB', 'GuinÃ©e-Bissau'),
(177, 'TLS', 'Timor-Leste'),
(178, 'PRI', 'Porto Rico'),
(179, 'QAT', 'Qatar'),
(180, 'REU', 'RÃ©union'),
(181, 'ROU', 'Roumanie'),
(182, 'RUS', 'FÃ©dÃ©ration de Russie'),
(183, 'RWA', 'Rwanda'),
(184, 'SHN', 'Sainte-HÃ©lÃ¨ne'),
(185, 'KNA', 'Saint-Kitts-et-Nevis'),
(186, 'AIA', 'Anguilla'),
(187, 'LCA', 'Sainte-Lucie'),
(188, 'SPM', 'Saint-Pierre-et-Miquelon'),
(189, 'VCT', 'Saint-Vincent-et-les Grenadines'),
(190, 'SMR', 'Saint-Marin'),
(191, 'STP', 'Sao TomÃ©-et-Principe'),
(192, 'SAU', 'Arabie Saoudite'),
(193, 'SEN', 'SÃ©nÃ©gal'),
(194, 'SYC', 'Seychelles'),
(195, 'SLE', 'Sierra Leone'),
(196, 'SGP', 'Singapour'),
(197, 'SVK', 'Slovaquie'),
(198, 'VNM', 'Viet Nam'),
(199, 'SVN', 'SlovÃ©nie'),
(200, 'SOM', 'Somalie'),
(201, 'ZAF', 'Afrique du Sud'),
(202, 'ZWE', 'Zimbabwe'),
(203, 'ESP', 'Espagne'),
(204, 'ESH', 'Sahara Occidental'),
(205, 'SDN', 'Soudan'),
(206, 'SUR', 'Suriname'),
(207, 'SJM', 'Svalbard etÃŽle Jan Mayen'),
(208, 'SWZ', 'Swaziland'),
(209, 'SWE', 'SuÃ¨de'),
(210, 'CHE', 'Suisse'),
(211, 'SYR', 'RÃ©publique Arabe Syrienne'),
(212, 'TJK', 'Tadjikistan'),
(213, 'THA', 'ThaÃ¯lande'),
(214, 'TGO', 'Togo'),
(215, 'TKL', 'Tokelau'),
(216, 'TON', 'Tonga'),
(217, 'TTO', 'TrinitÃ©-et-Tobago'),
(218, 'ARE', 'Ã‰mirats Arabes Unis'),
(219, 'TUN', 'Tunisie'),
(220, 'TUR', 'Turquie'),
(221, 'TKM', 'TurkmÃ©nistan'),
(222, 'TCA', 'ÃŽles Turks et CaÃ¯ques'),
(223, 'TUV', 'Tuvalu'),
(224, 'UGA', 'Ouganda'),
(225, 'UKR', 'Ukraine'),
(226, 'MKD', 'L\'ex-RÃ©publique Yougoslave de MacÃ©doine'),
(227, 'EGY', 'Ã‰gypte'),
(228, 'GBR', 'Royaume-Uni'),
(229, 'IMN', 'ÃŽle de Man'),
(230, 'TZA', 'RÃ©publique-Unie de Tanzanie'),
(231, 'USA', 'Ã‰tats-Unis'),
(232, 'VIR', 'ÃŽles Vierges des Ã‰tats-Unis'),
(233, 'BFA', 'Burkina Faso'),
(234, 'URY', 'Uruguay'),
(235, 'UZB', 'OuzbÃ©kistan'),
(236, 'VEN', 'Venezuela'),
(237, 'WLF', 'Wallis et Futuna'),
(238, 'WSM', 'Samoa'),
(239, 'YEM', 'YÃ©men'),
(240, 'SCG', 'Serbie-et-MontÃ©nÃ©gro'),
(241, 'ZMB', 'Zambie');

-- --------------------------------------------------------

--
-- Structure de la table `piecesjointes`
--

DROP TABLE IF EXISTS `piecesjointes`;
CREATE TABLE IF NOT EXISTS `piecesjointes` (
  `id_piecejointe` int(2) NOT NULL AUTO_INCREMENT,
  `id_actu` int(2) DEFAULT NULL,
  `titre` char(32) NOT NULL,
  `fichier` varchar(1000) NOT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_piecejointe`),
  KEY `I_FK_PIECESJOINTES_ACTUALITE` (`id_actu`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `piecesjointes`
--

INSERT INTO `piecesjointes` (`id_piecejointe`, `id_actu`, `titre`, `fichier`, `publier`) VALUES
(3, 13, 'test3', '13-test.xls', 1),
(11, 15, 'test', '15-Classeur1.xlsx', 1),
(12, 17, 'test', '13-test.doc', 1),
(20, 15, 'test', '15-test.doc', 1),
(18, 15, 'testactu', '15-test.pdf', 1),
(24, 24, 'fichier pdf', '24-test.pdf', 1);

-- --------------------------------------------------------

--
-- Structure de la table `planning`
--

DROP TABLE IF EXISTS `planning`;
CREATE TABLE IF NOT EXISTS `planning` (
  `id_planning` int(2) NOT NULL AUTO_INCREMENT,
  `titre` char(32) NOT NULL,
  `description` longtext NOT NULL,
  `couleur` varchar(255) DEFAULT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  `annuler` tinyint(1) DEFAULT NULL,
  `affichage` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_planning`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `planning`
--

INSERT INTO `planning` (`id_planning`, `titre`, `description`, `couleur`, `date_debut`, `date_fin`, `publier`, `annuler`, `affichage`) VALUES
(1, 'testdate2', '<p>test2</p>', '#FFFFFF', '2021-01-22 00:00:00', '2021-02-18 10:10:00', 0, 0, '0'),
(4, 'test', '<p>rvgsd</p>', '#3901FF', '2022-02-09 12:30:00', '2022-02-24 02:00:00', 1, 0, '0'),
(5, 'test', '<p>qsdfghj,k</p>', '#FF0000', '2022-01-10 00:00:00', '2022-02-15 00:00:00', 1, 0, '0'),
(7, 'test', '<p>dfg</p>', '#FFF688', '2022-01-01 14:00:00', '2022-01-10 16:00:00', 1, 0, '2'),
(8, 'test', '<p>sdfghj</p>', '#FFA000', '2022-01-15 13:00:00', '2022-02-09 14:00:00', 1, 0, '1'),
(9, 'test', '<p>dhf,</p>', '#00FF4D', '2022-02-17 15:00:00', '2022-02-28 16:00:00', 1, 0, '4'),
(10, 'test', '<p>test</p>', '#FFA000', '2022-01-21 15:37:00', '2022-01-07 14:00:00', 1, 0, '3'),
(11, 'test', '<p>gfb&nbsp;</p>', '#FFA000', '2022-01-20 16:26:00', '2022-01-21 16:26:00', 0, NULL, '0'),
(15, 'examen', '<p>bts</p>', '#FFA000', '2022-05-15 14:51:00', '2022-05-17 14:51:00', 1, 1, '1');

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
-- Structure de la table `rgpd`
--

DROP TABLE IF EXISTS `rgpd`;
CREATE TABLE IF NOT EXISTS `rgpd` (
  `id` int(10) NOT NULL,
  `titre` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `texte` longtext CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rgpd`
--

INSERT INTO `rgpd` (`id`, `titre`, `texte`) VALUES
(1, 'Mentions LÃ©gales - RGPD', '<div>\r\n<h3><b>POLITIQUE DE CONFIDENTIALITÃ‰</b></h3></div><div><div><div data-exp=\"simple2\"><div><div><p> <br>www.monespacesalarie-cse.com <br>CSE APF Eure <br> <br>Type de site&nbsp;: Portail d\'Ã©change</p>\r\n</div>\r\n<div>\r\n<p><h4>Le but de cette politique de confidentialitÃ© </h4> <br>Le but de cette politique de confidentialitÃ© est d\'informer les utilisateurs de notre site des donnÃ©es personnelles que nous recueillerons ainsi que les informations suivantes, le cas Ã©chÃ©ant :</p>\r\n<ol start=\"1\">\r\n<li value=\"1\">Les donnÃ©es personnelles que nous recueillerons </li>\r\n<li value=\"2\">Lâ€™utilisation des donnÃ©es recueillies </li>\r\n<li value=\"3\">Qui a accÃ¨s aux donnÃ©es recueillies </li>\r\n<li value=\"4\">Les droits des utilisateurs du site </li>\r\n<li value=\"5\">La politique de cookies du site </li>\r\n</ol>\r\n<p>Cette politique de confidentialitÃ© fonctionne parallÃ¨lement aux conditions gÃ©nÃ©rales dâ€™utilisation de notre site.</p>\r\n</div>\r\n<div>\r\n<h4><b>Lois applicables</b></h4>\r\n<p>ConformÃ©ment au RÃ¨glement gÃ©nÃ©ral sur la protection des donnÃ©es (RGPD), cette politique de confidentialitÃ© est conforme aux rÃ¨glements suivants. <br> <br></p><h5><b>Les donnÃ©es Ã  caractÃ¨re personnel doivent Ãªtre :</b></h5><p></p>\r\n<ol start=\"1\">\r\n<li value=\"1\">traitÃ©es de maniÃ¨re licite, loyale et transparente au regard de la personne concernÃ©e (licÃ©itÃ©, loyautÃ©, transparence) ; </li>\r\n<li value=\"2\">collectÃ©es pour des finalitÃ©s dÃ©terminÃ©es, explicites et lÃ©gitimes, et ne pas Ãªtre traitÃ©es ultÃ©rieurement d\'une maniÃ¨re incompatible avec ces finalitÃ©s; le traitement ultÃ©rieur Ã  des fins archivistiques dans l\'intÃ©rÃªt public, Ã  des fins de recherche scientifique ou historique ou Ã  des fins statistiques n\'est pas considÃ©rÃ©, conformÃ©ment Ã  l\'article 89, paragraphe 1, comme incompatible avec les finalitÃ©s initiales (limitation des finalitÃ©s) ; </li>\r\n<li value=\"3\">adÃ©quates, pertinentes et limitÃ©es Ã  ce qui est nÃ©cessaire au regard des finalitÃ©s pour lesquelles elles sont traitÃ©es (minimisation des donnÃ©es) ; </li>\r\n<li value=\"4\">exactes et, si nÃ©cessaire, tenues Ã  jour; toutes les mesures raisonnables doivent Ãªtre prises pour que les donnÃ©es Ã  caractÃ¨re personnel qui sont inexactes, eu Ã©gard aux finalitÃ©s pour lesquelles elles sont traitÃ©es, soient effacÃ©es ou rectifiÃ©es sans tarder (exactitude) ; </li>\r\n<li value=\"5\">conservÃ©es sous une forme permettant l\'identification des personnes concernÃ©es pendant une durÃ©e n\'excÃ©dant pas celle nÃ©cessaire au regard des finalitÃ©s pour lesquelles elles sont traitÃ©es; les donnÃ©es Ã  caractÃ¨re personnel peuvent Ãªtre conservÃ©es pour des durÃ©es plus longues dans la mesure oÃ¹ elles seront traitÃ©es exclusivement Ã  des fins archivistiques dans l\'intÃ©rÃªt public, Ã  des fins de recherche scientifique ou historique ou Ã  des fins statistiques conformÃ©ment Ã  l\'article 89, paragraphe 1, pour autant que soient mises en Å“uvre les mesures techniques et organisationnelles appropriÃ©es requises par le rÃ¨glement afin de garantir les droits et libertÃ©s de la personne concernÃ©e (limitation de la conservation) ; </li>\r\n<li value=\"6\">traitÃ©es de faÃ§on Ã  garantir une sÃ©curitÃ© appropriÃ©e des donnÃ©es Ã  caractÃ¨re personnel, y compris la protection contre le traitement non autorisÃ© ou illicite et contre la perte, la destruction ou les dÃ©gÃ¢ts d\'origine accidentelle, Ã  l\'aide de mesures techniques ou organisationnelles appropriÃ©es (intÃ©gritÃ© et confidentialitÃ©). <br> </li>\r\n</ol>\r\n<h5><b>Le traitement n\'est licite que si, et dans la mesure oÃ¹, au moins une des conditions suivantes est remplie :</b></h5>\r\n<ol start=\"1\">\r\n<li value=\"1\">la personne concernÃ©e a consenti au traitement de ses donnÃ©es Ã  caractÃ¨re personnel pour une ou plusieurs finalitÃ©s spÃ©cifiques ; </li>\r\n<li value=\"2\">le traitement est nÃ©cessaire Ã  l\'exÃ©cution d\'un contrat auquel la personne concernÃ©e est partie ou Ã  l\'exÃ©cution de mesures prÃ©contractuelles prises Ã  la demande de celle-ci ; </li>\r\n<li value=\"3\">le traitement est nÃ©cessaire au respect d\'une obligation lÃ©gale Ã  laquelle le responsable du traitement est soumis ; </li>\r\n<li value=\"4\">le traitement est nÃ©cessaire Ã  la sauvegarde des intÃ©rÃªts vitaux de la personne concernÃ©e ou d\'une autre personne physique ; </li>\r\n<li value=\"5\">le traitement est nÃ©cessaire Ã  l\'exÃ©cution d\'une mission d\'intÃ©rÃªt public ou relevant de l\'exercice de l\'autoritÃ© publique dont est investi le responsable du traitement ; </li>\r\n<li value=\"6\">le traitement est nÃ©cessaire aux fins des intÃ©rÃªts lÃ©gitimes poursuivis par le responsable du traitement ou par un tiers, Ã  moins que ne prÃ©valent les intÃ©rÃªts ou les libertÃ©s et droits fondamentaux de la personne concernÃ©e qui exigent une protection des donnÃ©es Ã  caractÃ¨re personnel, notamment lorsque la personne concernÃ©e est un enfant. </li>\r\n</ol>\r\n<p>Pour les rÃ©sidents de lâ€™Ã‰tat de Californie, cette politique de confidentialitÃ© vise Ã  se conformer Ã  la California Consumer Privacy Act (CCPA). Sâ€™il y a des incohÃ©rences entre ce document et la CCPA, la lÃ©gislation de lâ€™Ã‰tat sâ€™appliquera. Si nous constatons des incohÃ©rences, nous modifierons notre politique pour nous conformer Ã  la loi pertinente.</p>\r\n</div>\r\n<div>\r\n<p></p><h4><b>Consentement </b></h4> <br><h5>Les utilisateurs conviennent quâ€™en utilisant notre site, ils consentent Ã  :</h5><p></p>\r\n<ol start=\"1\">\r\n<li value=\"1\">les conditions Ã©noncÃ©es dans la prÃ©sente politique de confidentialitÃ© et </li>\r\n<li value=\"2\">la collecte, lâ€™utilisation et la conservation des donnÃ©es Ã©numÃ©rÃ©es dans la prÃ©sente politique. </li>\r\n</ol>\r\n</div>\r\n<div>\r\n<p>DonnÃ©es personnelles que nous collectons</p>\r\n<div>\r\n<div>\r\n<p>DonnÃ©es collectÃ©es automatiquement</p>\r\n<p>Nous ne collectons aucune donnÃ©e automatiquement sur notre site.</p>\r\n</div>\r\n<div>\r\n<p>DonnÃ©es recueillies de faÃ§on non automatique</p>\r\n<h5>Nous pouvons Ã©galement collecter les donnÃ©es suivantes lorsque vous effectuez certaines fonctions sur notre site&nbsp;:</h5>\r\n<ol start=\"1\">\r\n<li value=\"1\">PrÃ©nom et nom </li>\r\n<li value=\"2\">Email </li>\r\n<li value=\"3\">NumÃ©ro de tÃ©lÃ©phone </li>\r\n<li value=\"4\">Domicile </li>\r\n</ol>\r\n<h5>Ces donnÃ©es peuvent Ãªtre recueillies au moyen des mÃ©thodes suivantes&nbsp;:</h5>\r\n<p>Enregistrement d\'un compte utilisateur</p>\r\n<p>Formulaire de contact</p>\r\n</div>\r\n<p>Veuillez noter que nous ne collectons que les donnÃ©es qui nous aident Ã  atteindre lâ€™objectif Ã©noncÃ© dans cette politique de confidentialitÃ©. Nous ne recueillerons pas de donnÃ©es supplÃ©mentaires sans vous en informer au prÃ©alable.</p>\r\n</div>\r\n</div>\r\n<div>\r\n<p></p><h4>Comment nous utilisons les donnÃ©es personnelles </h4> <br>Les donnÃ©es personnelles recueillies sur notre site seront utilisÃ©es uniquement aux fins prÃ©cisÃ©es dans la prÃ©sente politique ou indiquÃ©es sur les pages pertinentes de notre site. Nous nâ€™utiliserons pas vos donnÃ©es au-delÃ  de ce que nous divulguerons.<p></p>\r\n<div>\r\n<h5>Les donnÃ©es que nous recueillons lorsque lâ€™utilisateur exÃ©cute certaines fonctions peuvent Ãªtre utilisÃ©es aux fins suivantes&nbsp;:</h5>\r\n<ol start=\"1\">\r\n<li value=\"1\">Identification des utilisateurs par les administrateurs du site </li>\r\n</ol>\r\n</div>\r\n</div>\r\n<div>\r\n<p>Avec qui nous partageons les donnÃ©es personnelles</p>\r\n<div>\r\n<p></p><h4><b>EmployÃ©s </b></h4>Nous pouvons divulguer Ã  tout membre de notre organisation les donnÃ©es utilisateur dont il a raisonnablement besoin pour rÃ©aliser les objectifs Ã©noncÃ©s dans la prÃ©sente politique.<p></p>\r\n</div>\r\n<div>\r\n<p></p><h4>Tierces parties </h4>Nous pouvons partager les donnÃ©es utilisateur avec les tiers suivants&nbsp;:<p></p>\r\n<ol start=\"1\">\r\n<li value=\"1\">__________ </li>\r\n</ol>\r\n<p>Nous pouvons partager les donnÃ©es utilisateur avec des tiers aux fins suivantes&nbsp;:</p>\r\n<ol start=\"1\">\r\n<li value=\"1\">__________ </li>\r\n</ol>\r\n<p>Les tiers ne seront pas en mesure dâ€™accÃ©der aux donnÃ©es des utilisateurs au-delÃ  de ce qui est raisonnablement nÃ©cessaire pour atteindre lâ€™objectif donnÃ©.</p>\r\n</div>\r\n<div>\r\n<p></p><h4>Autres divulgations </h4>Nous nous engageons Ã  ne pas vendre ou partager vos donnÃ©es avec des tiers, sauf dans les cas suivants&nbsp;:<p></p>\r\n<ol start=\"1\">\r\n<li value=\"1\">si la loi l\'exige </li>\r\n<li value=\"2\">si elle est requise pour toute procÃ©dure judiciaire </li>\r\n<li value=\"3\">pour prouver ou protÃ©ger nos droits lÃ©gaux </li>\r\n<li value=\"4\">Ã  des acheteurs ou des acheteurs potentiels de cette sociÃ©tÃ© dans le cas oÃ¹ nous cherchons Ã  la vendre la sociÃ©tÃ© </li>\r\n</ol>\r\n<p>Si vous suivez des hyperliens de notre site vers un autre site, veuillez noter que nous ne sommes pas responsables et nâ€™avons pas de contrÃ´le sur leurs politiques et pratiques de confidentialitÃ©.</p>\r\n</div>\r\n</div>\r\n<div>\r\n<p></p><h4>Combien de temps nous stockons les donnÃ©es personnelles </h4> <br>Nous ne conservons pas les donnÃ©es des utilisateurs au-delÃ  de ce qui est nÃ©cessaire pour atteindre les fins pour lesquelles elles sont recueillies.<p></p>\r\n</div>\r\n<div>\r\n<p></p><h4>Comment nous protÃ©geons vos donnÃ©es personnelles </h4> <br>Les donnÃ©es utilisateurs (adresse, tÃ©lÃ©phone, email...) ne sont accessibles qu\'aux administrateurs du site et par l\'utilisateur du site. <br>Toutes ces informations sont confidentielles, et l\'administrateur ne peut que les consulter. Aucun export, n\'est possible. <br>De plus le site est protÃ©gÃ© par certificat SSL, et les donnÃ©es transmises via un canal sÃ©curisÃ© <br> <br>Alors que nous prenons toutes les prÃ©cautions raisonnables pour nous assurer que nos donnÃ©es dâ€™utilisateur sont sÃ©curisÃ©es et que les utilisateurs sont protÃ©gÃ©s, il reste toujours du risque de prÃ©judice. Lâ€™Internet en sa totalitÃ© peut Ãªtre, parfois, peu sÃ»r et donc nous sommes incapables de garantir la sÃ©curitÃ© des donnÃ©es des utilisateurs au-delÃ  de ce qui est raisonnablement pratique.<p></p>\r\n</div>\r\n<div>\r\n<h4>Mineurs</h4>\r\n<p>Le RGPD prÃ©cise que les personnes de moins de 15 ans sont considÃ©rÃ©es comme des mineurs aux fins de la collecte de donnÃ©es. Les mineurs doivent avoir le consentement dâ€™un reprÃ©sentant lÃ©gal pour que leurs donnÃ©es soient recueillies, traitÃ©es et utilisÃ©es.</p>\r\n</div>\r\n<div>\r\n<h4>Vos droits en tant quâ€™utilisateur</h4>\r\n<div>\r\n<p>En vertu du RGPD, les utilisateurs ont les droits suivants en tant que personnes concernÃ©es :</p>\r\n<ol start=\"1\">\r\n<li value=\"1\">droit dâ€™accÃ¨s </li>\r\n<li value=\"2\">droit de rectification </li>\r\n<li value=\"3\">droit Ã  lâ€™effacement </li>\r\n<li value=\"4\">droit de restreindre le traitement </li>\r\n<li value=\"5\">droit Ã  la portabilitÃ© des donnÃ©es </li>\r\n<li value=\"6\">droit d\'objection </li>\r\n</ol>\r\n<p>Vous trouverez de plus amples informations sur ces droits au chapitre 3 (art 12-23) du RGPD.</p>\r\n</div>\r\n</div>\r\n<div>\r\n<p></p><h4>Comment modifier, supprimer ou contester les donnÃ©es recueillies </h4> <br>Si vous souhaitez que vos renseignements soient supprimÃ©s ou modifiÃ©s dâ€™une faÃ§on ou dâ€™une autre, veuillez communiquer avec notre agent de protection de la vie privÃ©e ici :<p></p>\r\n<p>Lucas SCHNEKENBURGER <br>9Bis Rue du Puits CarrÃ©, 27000, Evreux <br>altameos2012@gmail.com <br>06 75 58 61 93</p>\r\n</div>\r\n<div>\r\n<h4>Dispositions supplÃ©mentaires</h4>\r\n<p>___________________________________________________________ <br>___________________________________________________________ <br>___________________________________________________________ <br>___________________________________________________________</p>\r\n</div>\r\n<div>\r\n<h4>Modifications</h4>\r\n<p>Cette politique de confidentialitÃ© peut Ãªtre modifiÃ©e Ã  lâ€™occasion afin de maintenir la conformitÃ© avec la loi et de tenir compte de tout changement Ã  notre processus de collecte de donnÃ©es. Nous recommandons Ã  nos utilisateurs de vÃ©rifier notre politique de temps Ã  autre pour sâ€™assurer quâ€™ils soient informÃ©s de toute mise Ã  jour. Au besoin, nous pouvons informer les utilisateurs par courriel des changements apportÃ©s Ã  cette politique.</p>\r\n</div>\r\n<div>\r\n<h4>Contact</h4>\r\n<p>Si vous avez des questions Ã  nous poser, nâ€™hÃ©sitez pas Ã  communiquer avec nous en utilisant ce qui suit&nbsp;: <br>06 75 58 61 93 <br>altameos2012@gmail.com <br>9Bis Rue du Puits CarrÃ©, 27000, Evreux</p>\r\n</div>\r\n<p><br><b> Date dâ€™entrÃ©e en vigueur&nbsp;: le 16 fÃ©vrier 2022</b></p></div>\r\n</div>\r\n</div>\r\n</div>\r\n');

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
  `actif` tinyint(1) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `tel`, `email`, `passwords`, `recup`, `adresse`, `cp`, `ville`, `pays`, `typeUser`, `photo`, `code`, `datedebut`, `datefin`, `couleur`, `actif`, `token`) VALUES
(49, 'Kylian', 'BOVE', '9874563210', 'kylianbove26@sfr.fr', '$2y$10$uhwEzekzXMQqRwm4Yjpp7edGpCNULo9qGiEOgkBdsIG2JJkFcA9G6', NULL, '11 allÃ©e du vieux poirier', '28500', 'st gemme moronval', 'france', 1, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(81, 'bove', 'kylian', '0123654789', 'inscription@gm.fr', '$2y$10$cjKOrdv1gkJh8gizW8UnLO93UhwQd/94n3GDNvGan1scRCbhHefKS', NULL, 'test', '28100', 'dreux', 'Argentine', 3, NULL, NULL, NULL, NULL, '#FF0000', 1, NULL),
(55, 'bove', 'kylian', '0123654789', 'kylian7@gm.fr', '$2y$10$ibcBylomJfxEXmdkiiKVXuzUY61zd56/bwC5UD.i9ndw/BQ46oE6K', NULL, 'test', '28100', 'dreux', 'Luxembourg', 3, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(54, 'bove', 'kylian', '0123654789', 'kylian4@gm.fr', '$2y$10$BHqv2cL2WLvwd.GU4F13MOHuRiRa14HucFP8n77ki7gtE8JHPPSrm', NULL, 'test', '28100', 'dreux', 'france', 1, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(53, 'tets', 'test2', '0123654789', 'test2@gm.fr', '$2y$10$OlyYrQCgWCKXoZvoDSjZnukOdpPsfxZrGzc1ia3Gf4sAWIPDnjPcy', NULL, 'test', '28100', 'dreux', 'france', 1, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(60, 'bove', 'kylian', '0123654789', 'kylianuser@gm.fr', '$2y$10$IVmFhJhTrJJqmtyuwugen.pQrjURowhxBXcuj3N/GrxOLBa9ESdmS', NULL, 'test', '28100', 'dreux', 'France', 2, NULL, NULL, NULL, NULL, '#000000', 0, NULL),
(80, 'bove', 'kylian', '0123654789', 'couleur@gm.fr', '$2y$10$/FnJkYx7DVdqRUa5Ff0zTemi.r.euMdmMKysMnFWz0YbfDLLawgk.', NULL, 'test', '28100', 'dreux', 'Afghanistan', 1, NULL, NULL, NULL, NULL, '#7E8AFF', 0, NULL),
(82, 'bove', 'kylian', '0123654789', 'kylian2@gm.fr', '$2y$10$S.cWstxDxTsgaXP50kNv4.y4jkcUfZdvedJUNMRmsirsfZnzTbhmW', NULL, 'test', '28100', 'dreux', 'Afghanistan', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 'tets', 'test2', '0123654789', 'testphoto@gm.fr', '$2y$10$P5Ftab1CiObDfmwMktrhQug5MBaDq06JOHL2Gm5Gppjnv6hWu8dcu', NULL, 'test', '28100', 'dreux', 'Afghanistan', 1, NULL, NULL, NULL, NULL, '#FF0000', 1, NULL),
(78, 'bove2', 'kylian', '0123654789', 'phto@gm.fr', '$2y$10$E1Epa.rK9FIMZVS7KQveAuIz/uNsF6N2tt4BPvK2NN4GCoif/6viO', NULL, 'test', '28100', 'dreux', 'Afghanistan', 1, 'DSCN3534.JPG', NULL, NULL, NULL, NULL, 1, NULL),
(75, 'test', 'kylian', '0123654789', 'kylianpays@gm.fr', '$2y$10$ZAjOVR66OK74Ac4GWTGvO.9kJUV6v8.9A.O1yS3ZP0vTIMdKELwOG', NULL, 'test', '28100', 'dreux', 'Autriche', 1, NULL, NULL, NULL, NULL, NULL, 1, NULL),
(89, 'bove', 'kylian', '0123654789', 'test123456@gm.fr', '$2y$10$YbPvkbklXfaAkfFGpsY03uJGU4VnF3Q9UqUfjgOU.DOoDvOpDqTU6', NULL, 'test', '28100', 'dreux', 'Afghanistan', 2, NULL, NULL, NULL, NULL, '#FF005F', 0, NULL),
(88, 'bove', 'test', '0123654789', 'testcode@gm.fr', '$2y$10$RQ7vwv4qmm5lCPo3bEsTwuktpwcUCSsOS2RwsdGEx0RnywPWmNWWu', NULL, 'test', '28100', 'dreux', 'Afghanistan', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(90, 'bove', 'kylian', '0123654789', 'kylian258@gm.fr', '$2y$10$EF7sYh277zlrHVUmiinvbe.B7PIu3P8uh4LCUrRvq38.Y7eiyPFUS', NULL, 'test', '28100', 'dreux', 'Afghanistan', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(91, 'bove', 'kylian', '0123654789', 'kylian987456@gm.fr', '$2y$10$QCNAPGsOBpr/CNOZR6mFF.pIbjp8SZ48qtCDosPdn9.gfy6DzLThq', NULL, 'test', '28100', 'dreux', 'Afghanistan', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 'bove', 'kylian', '0123654789', '987456@gm.fr', '$2y$10$3V/ckHpF4GDZfWRU2UkM/OKYuVo/CoWURp4Enl8Bvj6s94.EoSjPq', NULL, 'test', '28100', 'dreux', 'Afghanistan', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 'bove', 'kylian', '0123654789', '5236@gm.fr', '$2y$10$9TmuQrVwfplTsRAPnUR.2uRUhP6amk1WiRx/hCFv/R.Jptb4ROF3e', NULL, 'test', '28100', 'dreux', 'Afghanistan', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 'tets', 'test2', '0123654789', 'test3@gm.fr', '$2y$10$i3lZ6Uade3d7AGg2jpaU/uyL2cDCtTVYI650V5iorvRUOlIndHFF6', NULL, 'test', '28100', 'dreux', 'France', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 'bove', 'kylian', '0123654789', 'kylian123@gm.fr', '$2y$10$Z2nxTqRhtRpRh4GFIpfOMeAfY5r2cxl6DgxhJ.GE7bVA8ZCm7AAEW', NULL, 'test', '28100', 'dreux', 'France', 3, NULL, NULL, NULL, NULL, '#000000', 1, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id_video` int(2) NOT NULL AUTO_INCREMENT,
  `id_actu` int(2) DEFAULT NULL,
  `titre` char(32) NOT NULL,
  `fichier` varchar(500) NOT NULL,
  `publier` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_video`),
  KEY `I_FK_VIDEO_ACTUALITE` (`id_actu`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id_video`, `id_actu`, `titre`, `fichier`, `publier`) VALUES
(16, 15, 'test', '15-tirage_x264.mp4', 1),
(24, 24, 'test', '24-tik5_x264.mp4', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
