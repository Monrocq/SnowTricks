-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 24 sep. 2019 à 11:50
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `group`
--

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `group`
--

INSERT INTO `group` (`id`, `title`) VALUES
(1, 'Grabs'),
(2, 'Rotations'),
(3, 'Flips'),
(4, 'Rotations désaxées'),
(5, 'Slides'),
(6, 'One foot tricks');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) NOT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `une` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FB281BE2E` (`trick_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `trick_id`, `url`, `une`) VALUES
(2, 3, 'img/tricks/mute1.jpg', 0),
(3, 3, 'img/tricks/mute2.jpg', 1),
(4, 4, 'img/tricks/sad1.jpg', 1),
(5, 4, 'img/tricks/sad2.jpg', 0),
(6, 5, 'img/tricks/indy.jpg', 1),
(7, 6, 'img/tricks/stalefish1.jpg', 1),
(8, 6, 'img/tricks/stalefish2.jpg', 0),
(9, 7, 'img/tricks/tailgrab1.jpg', 1),
(10, 7, 'img/tricks/tailgrab2.jpg', 0),
(11, 8, 'img/tricks/nosegrab1.jpg', 1),
(12, 8, 'img/tricks/nosegrab2.jpg', 0),
(13, 9, 'img/tricks/japanair1.jpg', 1),
(14, 9, 'img/tricks/japanair2.jpeg', 0),
(15, 10, 'img/tricks/seatbelt1.jpg', 1),
(16, 10, 'img/tricks/seatbelt2.jpg', 0),
(17, 11, 'img/tricks/truckdriver1.jpg', 1),
(18, 11, 'img/tricks/truckdriver2.jpg', 0),
(19, 12, 'img/tricks/rotations.jpg', 1),
(20, 13, 'img/tricks/frontflip.jpg', 1),
(21, 14, 'img/tricks/backflip.jpg', 1),
(22, 15, 'img/tricks/cork.jpg', 1),
(23, 16, 'img/tricks/rodeo.jpg', 1),
(24, 17, 'img/tricks/misty.jpg', 1),
(25, 18, 'img/tricks/noseslide.jpg', 1),
(26, 19, 'img/tricks/tailslide.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190923103549', '2019-09-23 10:36:40'),
('20190923114645', '2019-09-23 11:47:14'),
('20190923165725', '2019-09-23 16:57:46');

-- --------------------------------------------------------

--
-- Structure de la table `trick`
--

DROP TABLE IF EXISTS `trick`;
CREATE TABLE IF NOT EXISTS `trick` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D8F0A91E12469DE2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick`
--

INSERT INTO `trick` (`id`, `title`, `description`, `created_at`, `updated_at`, `category_id`) VALUES
(3, 'Mute', 'saisie de la carre frontside de la planche entre les deux pieds avec la main avant', '2019-09-24 00:00:00', NULL, 1),
(4, 'Sad/Melancholie/Style-Week', 'saisie de la carre backside de la planche, entre les deux pieds, avec la main avant ', '2019-09-24 00:00:00', NULL, 1),
(5, 'Indy', 'Saisie de la carre frontside de la planche, entre les deux pieds, avec la main arrière', '2019-09-24 00:00:00', NULL, 1),
(6, 'Stalefish', 'Saisie de la carre backside de la planche entre les deux pieds avec la main arrière ', '2019-09-24 00:00:00', NULL, 1),
(7, 'Tail Grab', 'Saisie de la partie arrière de la planche, avec la main arrière', '2019-09-24 00:00:00', NULL, 1),
(8, 'Nose Grab', 'Saisie de la partie avant de la planche, avec la main avant', '2019-09-24 00:00:00', NULL, 1),
(9, 'Japan Air', 'Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.', '2019-09-24 00:00:00', NULL, 1),
(10, 'Seat Belt', 'Saisie du carre frontside à l\'arrière avec la main avant.', '2019-09-24 00:00:00', NULL, 1),
(11, 'Truck Driver', 'Saisie du carre avant et carre arrière avec chaque main (comme tenir un volant de voiture)', '2019-09-24 00:00:00', NULL, 1),
(12, 'Rotations', '- un 180 désigne un demi-tour, soit 180 degrés d\'angle ;\r\n- 360, trois six pour un tour complet ;\r\n- 540, cinq quatre pour un tour et demi ;\r\n- 720, sept deux pour deux tours complets ;\r\n- 900 pour deux tours et demi ;\r\n- 1080 ou big foot pour trois tours ;\r\netc.', '2019-09-24 00:00:00', NULL, 2),
(13, 'Front Flip', 'Rotation en avant', '2019-09-24 00:00:00', NULL, 3),
(14, 'Back Flip', 'Rotations en arrière', '2019-09-24 00:00:00', NULL, 3),
(15, 'Corkscrew/Cork', 'Une rotation désaxée est une rotation initialement horizontale mais lancée avec un mouvement des épaules particulier qui désaxe la rotation.', '2019-09-24 00:00:00', NULL, 4),
(16, 'Rodeo', 'Certaines de ces rotations, bien qu\'initialement horizontales, font passer la tête en bas.', '2019-09-24 00:00:00', NULL, 4),
(17, 'Misty', 'Bien que certaines de ces rotations soient plus faciles à faire sur un certain nombre de tours (ou de demi-tours) que d\'autres, il est en théorie possible de d\'attérir n\'importe quelle rotation désaxée avec n\'importe quel nombre de tours, en jouant sur la quantité de désaxage afin de se retrouver à la position verticale au moment voulu.', '2019-09-24 00:00:00', NULL, 4),
(18, 'Nose Slide', 'L\'avant de la planche sur la barre', '2019-09-24 00:00:00', NULL, 5),
(19, 'Tail Slide', 'L\'arrière de la planche sur la barre', '2019-09-24 00:00:00', NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trick_id` int(11) DEFAULT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CC7DA2CB281BE2E` (`trick_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045FB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);

--
-- Contraintes pour la table `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `group` (`id`);

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
