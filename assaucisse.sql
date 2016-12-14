-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 14 Décembre 2016 à 14:46
-- Version du serveur :  10.1.16-MariaDB
-- Version de PHP :  5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `assaucisse`
--

-- --------------------------------------------------------

--
-- Structure de la table `assoc`
--

CREATE TABLE `assoc` (
  `id` int(10) NOT NULL,
  `id_mairie` int(10) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `code_postal` int(5) NOT NULL,
  `ville` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fix` int(10) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `background` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `assoc`
--

INSERT INTO `assoc` (`id`, `id_mairie`, `id_user`, `nom`, `slug`, `adresse`, `code_postal`, `ville`, `fix`, `description`, `created_at`, `token`, `status`, `avatar`, `background`) VALUES
(1, 1, 1, 'les rois du volant', 'les-rois-du-volant', '1 place glandu', 39800, 'tintinouu', NULL, NULL, '2016-12-06 00:00:00', 'onverra', 'Actif', NULL, NULL),
(2, 2, 2, 'Les second', 'les-second', 'onsenbas les reins', 27800, 'testville', NULL, NULL, '2016-12-07 00:00:00', 'onsenfou', 'En attente', NULL, NULL),
(4, 1, 1, 'les rois du volant2', 'les-rois-du-volant2', '1 place glandu', 39800, 'tintinouu', NULL, NULL, '2016-12-06 00:00:00', 'onverra', 'En attente', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `emeteur_pseudo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `destinataire` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `objet` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contenu` text COLLATE utf8_unicode_ci NOT NULL,
  `date_envoi` datetime NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `organisme` varchar(155) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `contact`
--

INSERT INTO `contact` (`id`, `emeteur_pseudo`, `mail`, `destinataire`, `objet`, `contenu`, `date_envoi`, `status`, `organisme`) VALUES
(1, 'simon', 'savalle.simon@gmail.com', 'All', 'inscript_mairie', 'essai mail super admin', '2016-12-12 23:36:26', 'non-lu', 'site'),
(3, 'simon', 'savalle.simon@gmail.com', 'mairie-de-bourneville', 'inscript_assoc', 'bonjour jaimerai creer une assoc', '2016-12-12 23:42:07', 'non-lu', 'mairie'),
(4, 'simon', 'savalle.simon@gmail.com', 'mairie-de-bourneville', 'probleme_mairie', 'test envoi', '2016-12-13 11:12:35', 'non-lu', 'mairie'),
(10, 'simon', 'savalle.simon@gmail.com', 'les-rois-du-volan', 'inscript_menbre', 'jaimerai etre menbre', '2016-12-12 23:42:40', 'non-lu', 'assoc'),
(11, 'simon', 'savalle.simon@gmail.com', 'les-rois-du-volant', 'inscript_menbre', 'je souhaite etre menbre', '2016-12-13 11:23:04', 'non-lu', 'assoc'),
(12, 'simon', 'savalle.simon@gmail.com', 'mairie-de-bourneville', 'inscript_assoc', 'bonjour je souhaite creer mon assoc assaucisse', '2016-12-13 16:42:38', 'non-lu', 'mairie');

-- --------------------------------------------------------

--
-- Structure de la table `mairie`
--

CREATE TABLE `mairie` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `code_postal` int(5) NOT NULL,
  `departement` int(3) NOT NULL,
  `ville` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fix` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `horaire` text COLLATE utf8_unicode_ci,
  `mail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `status` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `background` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `mairie`
--

INSERT INTO `mairie` (`id`, `id_user`, `nom`, `slug`, `token`, `adresse`, `code_postal`, `departement`, `ville`, `fix`, `horaire`, `mail`, `created_at`, `status`, `avatar`, `background`) VALUES
(1, 1, 'Mairie de Bourneville', 'mairie-de-bourneville', 'onverra', '1 place de la mairie', 27500, 27, 'Bourneville', '0232570001', 'a:7:{s:5:"Lundi";s:12:"9h-12 13h-17";s:5:"Mardi";s:6:"Fermer";s:8:"Mercredi";s:12:"9h-12 13h-17";s:5:"Jeudi";s:6:"Fermer";s:8:"Vendredi";s:12:"9h-12 13h-17";s:6:"Samedi";s:5:"9h-12";s:8:"Dimanche";s:6:"Fermer";} ', 'mairie@bourneville.fr', '2016-12-05 00:00:00', 'Actif', NULL, NULL),
(2, 5, 'Mairie d''epaigne', 'mairie-d-epaigne', 'onverra', 'chemin de la mairie', 27820, 27, 'epaigne', '0202020202', 'a:7:{s:5:"Lundi";s:12:"9h-12 13h-17";s:5:"Mardi";s:6:"Fermer";s:8:"Mercredi";s:12:"9h-12 13h-17";s:5:"Jeudi";s:6:"Fermer";s:8:"Vendredi";s:12:"9h-12 13h-17";s:6:"Samedi";s:5:"9h-12";s:8:"Dimanche";s:6:"Fermer";} ', 'mairie@epaigne.fr', '2016-12-01 00:00:00', 'Actif', NULL, NULL),
(3, 4, 'Mairie de Rouen', 'mairie-de-rouen', 'onverraca', 'chemin de leglise', 76000, 76, 'roeun', '0232023202', 'a:7:{s:5:"Lundi";s:12:"9h-12 13h-17";s:5:"Mardi";s:6:"Fermer";s:8:"Mercredi";s:12:"9h-12 13h-17";s:5:"Jeudi";s:6:"Fermer";s:8:"Vendredi";s:12:"9h-12 13h-17";s:6:"Samedi";s:5:"9h-12";s:8:"Dimanche";s:6:"Fermer";} ', 'mairie@rouen.fr', '2016-12-01 00:00:00', 'Actif', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `emeteur` int(11) NOT NULL,
  `destinataire` int(11) NOT NULL,
  `objet` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contenu` text COLLATE utf8_unicode_ci NOT NULL,
  `date_envoi` datetime NOT NULL,
  `date_lecture` datetime DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `emeteur`, `destinataire`, `objet`, `contenu`, `date_envoi`, `date_lecture`, `status`) VALUES
(1, 2, 1, 'test envoi', 'un lessage pour essayer', '2016-12-07 00:00:00', NULL, 'envoye'),
(2, 2, 1, 'test envoi 2', 'un lessage pour essayer 2', '2016-12-08 00:00:00', NULL, 'envoye'),
(3, 2, 1, 'test envoi 23', 'un lessage pour essayer 23', '2016-12-01 00:00:00', NULL, 'envoye');

-- --------------------------------------------------------

--
-- Structure de la table `pictures`
--

CREATE TABLE `pictures` (
  `id` int(11) NOT NULL,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `origine_nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nouveau_nom` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mime` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `emplacement` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_ajout` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `id_assoc` int(11) DEFAULT NULL,
  `id_mairie` int(11) DEFAULT NULL,
  `id_site` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `role` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `roles`
--

INSERT INTO `roles` (`id`, `id_assoc`, `id_mairie`, `id_site`, `id_user`, `role`) VALUES
(1, NULL, 1, NULL, 1, 'Admin'),
(3, 1, NULL, NULL, 1, 'Admin'),
(4, NULL, NULL, 1, 1, 'SuperAdmin'),
(5, 2, NULL, NULL, 2, 'Admin'),
(6, NULL, 3, NULL, 3, 'Admin'),
(7, 4, NULL, NULL, 4, 'Admin'),
(8, NULL, 2, NULL, 4, 'Admin');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `code_postal` int(5) NOT NULL,
  `ville` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `fix` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `lost_connect` datetime DEFAULT NULL,
  `avatar` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `mail`, `password`, `token`, `nom`, `prenom`, `adresse`, `code_postal`, `ville`, `fix`, `mobile`, `created_at`, `status`, `lost_connect`, `avatar`) VALUES
(1, 'simon', 'savalle.simon@gmail.com', '$2y$10$.cr80NLYoPFTXKSQThnuYuPnJXipOHrnkbwuQtJus572TqJ4dmpga', 'A1SuWfYYeItYRLeC2LT7NPAR2HITQPzJyT4hUyMeoynh2U5xcd', 'savalle', 'simon', '5 chemin moulant', 27500, 'Saint-mards-de-blacarville', NULL, '0662776320', '2016-12-12 22:08:16', 'Actived', NULL, NULL),
(2, 'Laurent', 'laurent@gmail.com', '$2y$10$X/mPic7jzV8VL8qawIQuReunw3z2A0eEgSLsr4AqjiEMD2nGonUmW', '44xQQ0KCf-wBGNVP2uKlCm_uEDBeReqkRcUNBCa-5L61hJSutX', 'Dubec', 'Laurent', 'bla bla bla rue bla', 76530, 'Moulineaux', NULL, NULL, '2016-12-13 12:36:02', 'Actived', NULL, NULL),
(3, 'Benoit', 'benoit@gmail.com', '$2y$10$UXnzDSEiTgiXjOgYxtFPpOUeP8wx0iRnrYkM5u8E423xWi1W7wCx.', 'G18RPPaLQn0w8JmLN1v1T48a3tN0TyyloMd1-DznLhQl0ydDxm', 'Blondel', 'Benoit', 'rue de la rep', 27500, 'Pont-audemer', NULL, NULL, '2016-12-13 12:39:08', 'Actived', NULL, NULL),
(4, 'Jessy', 'jessy@gmail.com', '$2y$10$kFl5fLNakMjo.e9Ob0eDlOuVVQ6Djl7bL2Y33HmDXIV0J2bfri05S', '5-KMcs0HS-r8LcuWRuuKq3wB3RAW9HR2-rUhugvoc2ahnnxsU2', 'Leroy', 'Jessy', 'aller de lorgasme', 27310, 'Bourg-achard', NULL, NULL, '2016-12-13 12:42:08', 'Actived', NULL, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `assoc`
--
ALTER TABLE `assoc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mairie`
--
ALTER TABLE `mairie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `assoc`
--
ALTER TABLE `assoc`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `mairie`
--
ALTER TABLE `mairie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
