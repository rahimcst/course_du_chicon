-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+deb12u1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 23 mai 2025 à 18:55
-- Version du serveur : 10.11.11-MariaDB-0+deb12u1
-- Version de PHP : 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `course_chicon`
--

-- --------------------------------------------------------

--
-- Structure de la table `courses`
--

CREATE TABLE `courses` (
  `idCourses` int(11) NOT NULL,
  `intitule` varchar(50) NOT NULL,
  `distance` int(11) NOT NULL,
  `date` date NOT NULL,
  `statut` enum('InscriptionOpen','InscriptionClosed','Ready','Chrono','Finished') NOT NULL,
  `dateLimite` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `courses`
--

INSERT INTO `courses` (`idCourses`, `intitule`, `distance`, `date`, `statut`, `dateLimite`) VALUES
(76, 'Mini-Chicons (6-8 ans)', 500, '2025-03-25', 'Finished', '2025-03-25'),
(77, 'Petits-Chicons (9-10 ans)', 1000, '2025-03-25', 'Finished', '2025-03-25'),
(79, 'Grands-Chicons (11-12 ans)', 1500, '2025-03-25', 'Finished', '2025-03-25'),
(92, 'Mini-Chicons (6-8 ans)', 500, '2025-04-30', 'Ready', '2025-04-29');

-- --------------------------------------------------------

--
-- Structure de la table `inscriptions`
--

CREATE TABLE `inscriptions` (
  `idInscriptions` int(11) NOT NULL,
  `idParticipant` int(11) DEFAULT NULL,
  `chrono` time DEFAULT NULL,
  `statut_inscription` enum('Approuvée','Rejetée','En attente') DEFAULT NULL,
  `tagRFID` varchar(50) DEFAULT NULL,
  `numeroDossard` int(11) DEFAULT NULL,
  `idCourse` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `inscriptions`
--

INSERT INTO `inscriptions` (`idInscriptions`, `idParticipant`, `chrono`, `statut_inscription`, `tagRFID`, `numeroDossard`, `idCourse`) VALUES
(330, 138, '00:42:13', 'Approuvée', '', 1, 77),
(332, 140, '01:07:45', 'Rejetée', '', 1, 76),
(333, 141, '00:59:12', 'Approuvée', '', NULL, 79),
(334, 142, '01:23:10', 'Approuvée', '', NULL, 79),
(335, 143, '00:48:37', 'Approuvée', '', NULL, 79),
(336, 144, '01:12:59', 'Approuvée', '', 2, 77),
(337, 145, '00:33:25', 'Rejetée', '', 2, 76),
(338, 146, '01:05:31', 'Approuvée', '', 3, 77),
(339, 147, '00:54:18', 'Approuvée', '', NULL, 79),
(340, 148, '01:31:42', 'Approuvée', '', 3, 76),
(341, 149, '00:39:10', 'Approuvée', '', 4, 77),
(342, 150, '01:15:55', 'Approuvée', '', 4, 76),
(343, 151, '00:57:34', 'Approuvée', '', 5, 77),
(344, 152, '00:46:03', 'Approuvée', '', NULL, 79),
(345, 153, '01:29:17', 'Approuvée', '', 5, 76),
(346, 154, '00:51:22', 'Approuvée', '', 6, 77),
(347, 155, '01:18:44', 'Approuvée', '', 6, 76),
(348, 156, '00:36:59', 'Approuvée', '', 7, 77),
(349, 157, '01:09:28', 'Approuvée', '', NULL, 79),
(350, 158, '00:43:56', 'Approuvée', '', 8, 77),
(351, 159, '01:33:21', 'Approuvée', '', 7, 76),
(352, 160, '00:29:15', 'Approuvée', '', 8, 76),
(353, 161, '01:11:39', 'Approuvée', '', 9, 77),
(354, 162, '00:55:04', 'Approuvée', '', NULL, 79),
(355, 163, '01:22:27', 'Approuvée', '', 10, 77),
(356, 164, '00:47:51', 'Approuvée', 'C1E0 D503 9C1A 02CE 0070 5562 0A4E FB3A', 9, 76),
(357, 165, '01:16:03', 'Approuvée', '', 10, 76),
(358, 166, '00:41:19', 'Approuvée', '', 11, 77),
(359, 167, '01:10:12', 'Approuvée', '', NULL, 79),
(360, 168, '00:53:48', 'Approuvée', '', 11, 76),
(361, 169, '01:27:36', 'Approuvée', '', 12, 77),
(362, 170, '00:38:25', 'Approuvée', '', 12, 76),
(363, 171, '01:14:08', 'Approuvée', '', 13, 77),
(364, 172, '00:49:33', 'Approuvée', '', NULL, 79),
(365, 173, '01:31:57', 'Approuvée', 'E200 3411 B802 0116 1816 4473', 14, 77),
(366, 174, '00:44:42', 'Approuvée', '', 15, 77),
(367, 175, '01:19:29', 'Approuvée', '', 13, 76),
(368, 176, '00:35:17', 'Approuvée', '', 16, 77),
(369, 177, '01:06:24', 'Approuvée', '', NULL, 79),
(370, 178, '00:52:10', 'Approuvée', '', 17, 77),
(371, 179, '01:25:51', 'Approuvée', '', 14, 76),
(372, 180, '00:37:42', 'Approuvée', '', 15, 76),
(373, 181, '01:13:17', 'Approuvée', '', 18, 77),
(374, 182, '00:50:28', 'Approuvée', '', NULL, 79),
(375, 183, NULL, 'Approuvée', 'E200 3411 B802 0116 1815 6358', NULL, 79),
(376, 184, '01:30:09', 'Approuvée', '', 19, 77),
(377, 185, '00:45:39', 'Approuvée', '', 16, 76),
(378, 186, '01:17:54', 'Approuvée', '', 20, 77),
(379, 187, '00:34:08', 'Approuvée', '', NULL, 79),
(380, 188, '01:08:33', 'Approuvée', '', 17, 76),
(381, 189, '00:56:21', 'Approuvée', '', 18, 76),
(382, 190, '01:21:14', 'Approuvée', '', 19, 76),
(383, 191, '00:40:57', 'Approuvée', '', 20, 76),
(384, 192, '00:00:05', 'Approuvée', 'E200 3411 B802 0115 3831 0079', 21, 76),
(431, 239, '01:05:02', 'Approuvée', '', 21, 77);

-- --------------------------------------------------------

--
-- Structure de la table `participants`
--

CREATE TABLE `participants` (
  `idParticipants` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `licence` varchar(50) DEFAULT NULL,
  `autorisation` tinyint(1) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `compte_actif` tinyint(1) DEFAULT 0,
  `token_confirmation` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `participants`
--

INSERT INTO `participants` (`idParticipants`, `nom`, `prenom`, `date_naissance`, `adresse`, `licence`, `autorisation`, `password`, `mail`, `compte_actif`, `token_confirmation`) VALUES
(138, 'BOUGHEZAL', 'Abderrahim', '1999-12-28', '8 AVENUE DE LA ROSERAIE', NULL, 1, '$2y$10$00BB2UlbJUBYtExPtqZ.AeK/KBCWKO3ZqlVvSjmm5BqvdRxf4vFCu', 'rahimboughezal@gmail.com', 1, 'fa89245aa3840c111e0f7cb18c7fd82c'),
(140, 'FOURNIER', 'Mélanie', '2013-04-12', '7 rue Simon, 45182 Merville', '\'LIC6550\'', 1, '$2y$10$c6b4b04c9e019b90b9bc5d066a72028f2b4f42c4e0e', 'melanie.fournier@example.com', 1, 'c5e987e1e64854e440b5d9d2565b01e5'),
(141, 'ROUSSEL', 'Nathan', '2016-07-05', '18 place Marchand, 18875 Marly', 'LIC2993893', 0, '$2y$10$1536d1edb4b4bc3aee8d9ae429f3b084902e5fc3732', 'nathan.roussel@example.org', 1, '264f5a193e84c332a7f9b2084be56993'),
(142, 'Bernard', 'Lucas', '2013-03-15', '15 chemin des Fleurs', 'LIC34567', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lucas.bernard3@email.com', 1, 'c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8'),
(143, 'Thomas', 'Chloé', '2015-11-02', '8 rue du Stade', 'LIC45678', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'chloe.thomas4@email.com', 1, 'd4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9'),
(144, 'Petit', 'Jules', '2012-09-30', '30 rue des Écoles', 'LIC56789', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'jules.petit5@email.com', 1, 'e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0'),
(145, 'Robert', 'Louise', '2014-01-17', '17 impasse des Violettes', '\'LIC26510\'', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'louise.robert6@email.com', 1, 'f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1'),
(146, 'Richard', 'Tom', '2013-07-21', '21 place des Arts', 'LIC78901', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'tom.richard7@email.com', 1, 'g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2'),
(147, 'Durand', 'Lina', '2015-05-14', '14 rue des Champs', 'LIC89012', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lina.durand8@email.com', 1, 'h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3'),
(148, 'Lefebvre', 'Noah', '2012-12-05', '5 rue de la Gare', 'LIC90123', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'noah.lefebvre9@email.com', 1, 'i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4'),
(149, 'Moreau', 'Eva', '2013-02-28', '28 avenue des Rosiers', 'LIC01234', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'eva.moreau10@email.com', 1, 'j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5'),
(150, 'Simon', 'Adam', '2015-06-18', '18 rue des Jardins', 'LIC12346', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'adam.simon11@email.com', 1, 'k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6'),
(151, 'Laurent', 'Zoé', '2014-04-09', '9 rue des Peupliers', 'LIC23457', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'zoe.laurent12@email.com', 1, 'l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6a7'),
(152, 'Garcia', 'Nathan', '2013-10-27', '27 rue du Moulin', 'LIC34568', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'nathan.garcia13@email.com', 1, 'm3n4o5p6q7r8s9t0u1v2w3x4y5z6a7b8'),
(153, 'Roux', 'Léa', '2012-11-11', '11 rue de la République', 'LIC45679', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lea.roux14@email.com', 1, 'n4o5p6q7r8s9t0u1v2w3x4y5z6a7b8c9'),
(154, 'Fontaine', 'Gabriel', '2014-03-03', '3 rue de la Liberté', 'LIC56780', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'gabriel.fontaine15@email.com', 1, 'o5p6q7r8s9t0u1v2w3x4y5z6a7b8c9d0'),
(155, 'Carpentier', 'Mia', '2015-09-22', '22 rue du Pont', 'LIC67891', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'mia.carpentier16@email.com', 1, 'p6q7r8s9t0u1v2w3x4y5z6a7b8c9d0e1'),
(156, 'Lemoine', 'Louis', '2013-05-30', '30 rue du Marché', 'LIC78902', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'louis.lemoine17@email.com', 1, 'q7r8s9t0u1v2w3x4y5z6a7b8c9d0e1f2'),
(157, 'Faure', 'Léna', '2014-07-08', '8 rue de la Poste', 'LIC89013', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lena.faure18@email.com', 1, 'r8s9t0u1v2w3x4y5z6a7b8c9d0e1f2g3'),
(158, 'Guerin', 'Ethan', '2012-10-06', '6 rue des Prés', 'LIC90124', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'ethan.guerin19@email.com', 1, 's9t0u1v2w3x4y5z6a7b8c9d0e1f2g3h4'),
(159, 'Blanc', 'Manon', '2015-12-13', '13 rue de la Forêt', 'LIC01235', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'manon.blanc20@email.com', 1, 't0u1v2w3x4y5z6a7b8c9d0e1f2g3h4i5'),
(160, 'Masson', 'Alice', '2014-06-19', '19 rue des Saules', 'LIC12347', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'alice.masson21@email.com', 1, 'u1v2w3x4y5z6a7b8c9d0e1f2g3h4i5j6'),
(161, 'Chevalier', 'Enzo', '2013-08-25', '25 rue de la Fontaine', 'LIC23458', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'enzo.chevalier22@email.com', 1, 'v2w3x4y5z6a7b8c9d0e1f2g3h4i5j6k7'),
(162, 'Clement', 'Sarah', '2012-02-16', '16 rue du Soleil', 'LIC34569', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'sarah.clement23@email.com', 1, 'w3x4y5z6a7b8c9d0e1f2g3h4i5j6k7l8'),
(163, 'Mercier', 'Tom', '2015-10-04', '4 rue des Tilleuls', 'LIC45670', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'tom.mercier24@email.com', 1, 'x4y5z6a7b8c9d0e1f2g3h4i5j6k7l8m9'),
(164, 'Dupont', 'Lila', '2014-09-17', '17 rue du Lac', 'LIC56781', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lila.dupont25@email.com', 1, 'y5z6a7b8c9d0e1f2g3h4i5j6k7l8m9n0'),
(165, 'Lambert', 'Nathan', '2013-01-12', '12 rue des Peupliers', 'LIC67892', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'nathan.lambert26@email.com', 1, 'z6a7b8c9d0e1f2g3h4i5j6k7l8m9n0o1'),
(166, 'Bonnet', 'Léna', '2012-05-08', '8 rue des Chênes', 'LIC78903', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lena.bonnet27@email.com', 1, 'a7b8c9d0e1f2g3h4i5j6k7l8m9n0o1p2'),
(167, 'Francois', 'Noé', '2015-03-27', '27 rue des Champs', 'LIC89014', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'noe.francois28@email.com', 1, 'b8c9d0e1f2g3h4i5j6k7l8m9n0o1p2q3'),
(168, 'Garnier', 'Clara', '2014-12-01', '1 rue de la Liberté', 'LIC90125', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'clara.garnier29@email.com', 1, 'c9d0e1f2g3h4i5j6k7l8m9n0o1p2q3r4'),
(169, 'Robin', 'Axel', '2013-06-14', '14 rue du Parc', 'LIC01236', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'axel.robin30@email.com', 1, 'd0e1f2g3h4i5j6k7l8m9n0o1p2q3r4s5'),
(170, 'Morin', 'Léna', '2012-08-09', '9 rue du Moulin', 'LIC12348', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lena.morin31@email.com', 1, 'e1f2g3h4i5j6k7l8m9n0o1p2q3r4s5t6'),
(171, 'Gerard', 'Milo', '2015-07-06', '6 rue du Stade', 'LIC23459', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'milo.gerard32@email.com', 1, 'f2g3h4i5j6k7l8m9n0o1p2q3r4s5t6u7'),
(172, 'Andre', 'Lina', '2013-04-11', '11 rue des Écoles', 'LIC34570', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lina.andre33@email.com', 1, 'g3h4i5j6k7l8m9n0o1p2q3r4s5t6u7v8'),
(173, 'Collet', 'Nina', '2014-10-15', '15 rue de la République', 'LIC45671', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'nina.collet34@email.com', 1, 'h4i5j6k7l8m9n0o1p2q3r4s5t6u7v8w9'),
(174, 'Leroy', 'Eliott', '2015-01-19', '19 rue des Lilas', 'LIC56782', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'eliott.leroy35@email.com', 1, 'i5j6k7l8m9n0o1p2q3r4s5t6u7v8w9x0'),
(175, 'Perrin', 'Léon', '2014-05-25', '25 avenue du Parc', 'LIC67893', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'leon.perrin36@email.com', 1, 'j6k7l8m9n0o1p2q3r4s5t6u7v8w9x0y1'),
(176, 'Muller', 'Léna', '2013-09-03', '3 rue des Rosiers', 'LIC78904', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lena.muller37@email.com', 1, 'k7l8m9n0o1p2q3r4s5t6u7v8w9x0y1z2'),
(177, 'Renard', 'Sacha', '2012-03-28', '28 rue du Stade', 'LIC89015', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'sacha.renard38@email.com', 1, 'l8m9n0o1p2q3r4s5t6u7v8w9x0y1z2a3'),
(178, 'Marchand', 'Lina', '2015-08-10', '10 rue du Pont', 'LIC90126', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lina.marchand39@email.com', 1, 'm9n0o1p2q3r4s5t6u7v8w9x0y1z2a3b4'),
(179, 'Benoit', 'Liam', '2014-02-07', '7 rue des Fleurs', 'LIC01237', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'liam.benoit40@email.com', 1, 'n0o1p2q3r4s5t6u7v8w9x0y1z2a3b4c5'),
(180, 'Legrand', 'Léa', '2013-11-29', '29 rue des Jardins', 'LIC12349', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lea.legrand41@email.com', 1, 'o1p2q3r4s5t6u7v8w9x0y1z2a3b4c5d6'),
(181, 'Gauthier', 'Lola', '2012-07-18', '18 rue de la Gare', 'LIC23460', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lola.gauthier42@email.com', 1, 'p2q3r4s5t6u7v8w9x0y1z2a3b4c5d6e7'),
(182, 'Barbier', 'Noah', '2015-03-05', '5 rue du Marché', 'LIC34571', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'noah.barbier43@email.com', 1, 'q3r4s5t6u7v8w9x0y1z2a3b4c5d6e7f8'),
(183, 'Girard', 'Mila', '2014-11-21', '21 rue du Soleil', 'LIC45672', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'mila.girard44@email.com', 1, 'r4s5t6u7v8w9x0y1z2a3b4c5d6e7f8g9'),
(184, 'Arnaud', 'Noé', '2013-12-25', '25 rue des Champs', 'LIC56783', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'noe.arnaud45@email.com', 1, 's5t6u7v8w9x0y1z2a3b4c5d6e7f8g9h0'),
(185, 'Poiret', 'Lina', '2012-06-02', '2 rue des Tilleuls', '\'trhrzt\'', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lina.poiret46@email.com', 1, 't6u7v8w9x0y1z2a3b4c5d6e7f8g9h0i1'),
(186, 'Besson', 'Liam', '2014-08-28', '28 rue de la Liberté', 'LIC78905', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'liam.besson47@email.com', 1, 'u7v8w9x0y1z2a3b4c5d6e7f8g9h0i1j2'),
(187, 'Renaud', 'Léa', '2015-02-11', '11 rue du Parc', 'LIC89016', 1, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'lea.renaud48@email.com', 1, 'v8w9x0y1z2a3b4c5d6e7f8g9h0i1j2k3'),
(188, 'Lopez', 'Milo', '2013-04-27', '27 rue des Rosiers', 'LIC90127', 0, '$2y$10$CwTycUXWue0Thq9StjUM0uJ8c1A4bQp7r6vHk6G7r2G5y8QJ6vQ7y', 'milo.lopez49@email.com', 1, 'w9x0y1z2a3b4c5d6e7f8g9h0i1j2k3l4'),
(189, 'FISCHER', 'Céline', '2014-02-17', '56 rue Marechal Leclerc, 84732 Wasquehal', 'LIC5623845', 1, '$2y$10$e564ce2d35de4d095e61330b290c147fd58c80d8b4a', 'celine.fischer@example.net', 1, 'e8137fba510b63c30992bb53f4f4c671'),
(190, 'DURAND', 'Hugo', '2012-12-27', '36 rue de Paris, 50746 Villeneuve-d\'Ascq', 'LIC2184436', 0, '$2y$10$1ab4a9a3df0f4ec67e6c79', 'hugo.durand@example.com', 1, 'c0d0b88a0fca04cfc20c5f02b0cf6c9e'),
(191, 'RICHARD', 'Gabin', '2012-05-01', '47 boulevard Voltaire, 44721 Lille', 'LIC7559402', 0, '$2y$10$057b7ec30efb0e6cc7e362', 'gabin.richard@example.com', 1, '34e2402e9f50296f346b91b6c0b419a5'),
(192, 'DUBOIS', 'Arthur', '2012-03-15', '14 rue Victor Hugo, 79963 Tourcoing', 'LIC4937560', 0, '$2y$10$2b3dd9e1ae878aa17444da', 'arthur.dubois@example.com', 1, 'f5c9aa10e9cf181bb8c94980e12231f6'),
(239, 'MARTIN', 'Lucas', '2011-07-09', '20 rue Pasteur, 14060 Lille', 'LIC8771519', 1, '$2y$10$f2e519b8f3b3a50aef7c1b', 'lucas.martin@example.com', 1, '8ff8e42086ae21a99472815432835b38');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`idCourses`);

--
-- Index pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`idInscriptions`),
  ADD KEY `idParticipant` (`idParticipant`),
  ADD KEY `idCourse` (`idCourse`);

--
-- Index pour la table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`idParticipants`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `courses`
--
ALTER TABLE `courses`
  MODIFY `idCourses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  MODIFY `idInscriptions` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=433;

--
-- AUTO_INCREMENT pour la table `participants`
--
ALTER TABLE `participants`
  MODIFY `idParticipants` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD CONSTRAINT `inscriptions_ibfk_1` FOREIGN KEY (`idParticipant`) REFERENCES `participants` (`idParticipants`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inscriptions_ibfk_2` FOREIGN KEY (`idCourse`) REFERENCES `courses` (`idCourses`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
