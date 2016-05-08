-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Dim 08 Mai 2016 à 23:26
-- Version du serveur :  5.7.12-0ubuntu1
-- Version de PHP :  7.0.4-7ubuntu2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `tweet`
--
CREATE DATABASE IF NOT EXISTS `tweet` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tweet`;

-- --------------------------------------------------------

--
-- Structure de la table `tweets`
--

CREATE TABLE `tweets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` varchar(120) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `tweets`
--

INSERT INTO `tweets` (`id`, `user_id`, `content`, `active`, `created_at`, `updated_at`) VALUES
(1, 2, 'rap', 0, '2016-05-08 20:54:32', NULL),
(2, 2, 'rap', 0, '2016-05-08 20:54:44', NULL),
(3, 2, 'rap', 0, '2016-05-08 20:58:19', NULL),
(4, 2, 'I ate a burger today, not fat enough', 1, '2016-05-08 21:19:04', '2016-05-08 21:39:47'),
(5, 2, 'hello', 0, '2016-05-08 21:40:21', NULL),
(6, 3, 'my burger', 1, '2016-05-08 22:06:43', NULL),
(7, 3, 'nope nope nope nope nope nope nope nope ', 1, '2016-05-08 22:06:54', '2016-05-08 22:49:03'),
(8, 3, 'tululÃ©tÃ©', 1, '2016-05-08 22:18:11', '2016-05-08 22:48:45'),
(9, 3, 'Last tweet', 1, '2016-05-08 22:18:14', '2016-05-08 22:48:34');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(60) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `token`, `created_at`, `updated_at`, `img`, `active`) VALUES
(2, 'raph', '$2y$10$g14wsragaMLSj34Se272qel7P74mSwRCWRkMGuD77Xap6NRuOt.ei', '21a2dccb8003acba2b6f679e597b87b2f1518b17', '2016-05-08 19:59:00', NULL, NULL, 1),
(3, 'test', '$2y$10$UIP/w5J4Ew5RE01dQGT5y.KtpbBhysghtgTA0x4FkKl2QkrWjdBNC', '9f1b374ac4f3479b92bc4536d0bf3aeb9ec54e4d', '2016-05-08 22:06:35', '2016-05-08 23:24:23', 'http://365psd.com/images/premium/thumbs/101/burger-292517.jpg', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `tweets`
--
ALTER TABLE `tweets`
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
-- AUTO_INCREMENT pour la table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
