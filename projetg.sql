-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 20 déc. 2024 à 16:51
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projetg`
--

-- --------------------------------------------------------

--
-- Structure de la table `achievement`
--

CREATE TABLE `achievement` (
  `achievement_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `achievement_date` date DEFAULT NULL,
  `achievement_image` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT 'bi-award'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `achievement`
--

INSERT INTO `achievement` (`achievement_id`, `player_id`, `title`, `description`, `achievement_date`, `achievement_image`, `icon`) VALUES
(1, 1, 'MVP 2020', 'Won the MVP award for outstanding performance.', '2020-12-25', 'image (20).jpg', 'bi-award'),
(2, 1, 'Best Player 2024', 'Awarded for outstanding performance in 2024.', '2024-12-19', 'best_player.jpg', 'bi-star'),
(3, 1, 'Top Scorer', 'Highest goals scorer of the season.', '2024-12-19', 'top_scorer.jpg', 'bi-trophy'),
(4, 1, 'MVP Award', 'Most valuable player of the tournament.', '2024-12-19', 'mvp.jpg', 'bi-award'),
(5, 1, 'Champion', 'Won the championship league.', '2024-12-19', 'champion.jpg', 'bi-flag');

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `nom`, `email`, `password`, `created_at`, `image`) VALUES
(1, 'Azzedine Rih', 'azzedinerih36@gmail.com', '$2y$10$Sk2OKEawcQaMCdPfU07AUui1jzo6ECpRSBx2v55oyy9OWVHT8FPxC', '2024-11-17 12:02:33', 'images/icon/avatar-04.jpg'),
(2, 'oussama', 'oussama@gmail.com', '$2y$10$mMW1zVmZ7p.PQMqklM5AcuO6kf3c4UZ7K3cSWwtvqB4muEJCosAla', '2024-11-17 12:11:35', NULL),
(3, 'ismaail rih', 'ismail@gmail.com', '$2y$10$G5lafobZ03jXHC4JQBmPEucDzyXOdBQRrm13dFpOZRwKh168xrgMK', '2024-11-17 12:58:55', NULL),
(4, 'mehdi', 'mehdifatimi@gmail.com', '$2y$10$BeLSzemE0vFVn1leXnH/LOtZ7seIcTyUnNkIxDy3HSIp5e9vAi7bK', '2024-11-17 15:45:05', NULL),
(5, 'Oussama', 'sadosami297@gmail.com', '$2y$10$nYf5/SBbflsDDFbEXi4jteAsS4lHFKreN0SFie05Pa7DwLcGCVr3m', '2024-11-17 16:04:51', NULL),
(6, 'oussama outo', 'oussamaot@gmail.com', '$2y$10$ffZXCe91mJmvhWLIjXQXleB3LHNj.fd2CcdnHGXUIvX7zE7pZPEli', '2024-11-19 00:55:29', NULL),
(7, 'aymen', 'aymen1@gmail.com', '$2y$10$W7MuTxZdNZiYt6bEO/ByrOB0h9pVOW.Tpg0LnUo6k9IZi1nLoSi7u', '2024-11-19 03:25:19', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `carrieres`
--

CREATE TABLE `carrieres` (
  `id_carreire` int(11) NOT NULL,
  `id_entraineur` int(11) NOT NULL,
  `club` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `carrieres`
--

INSERT INTO `carrieres` (`id_carreire`, `id_entraineur`, `club`, `description`) VALUES
(1, 1, 'Olympique Lyonnais', '2017'),
(2, 1, 'Paris Saint-Germain', '2014'),
(3, 2, 'FC Barcelone', '2020');

-- --------------------------------------------------------

--
-- Structure de la table `contacts_player`
--

CREATE TABLE `contacts_player` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id` int(11) NOT NULL,
  `heure` varchar(100) DEFAULT NULL,
  `courLundi` varchar(100) DEFAULT NULL,
  `courMardi` varchar(100) DEFAULT NULL,
  `courMercredi` varchar(100) DEFAULT NULL,
  `courJeudi` varchar(100) DEFAULT NULL,
  `courVendredi` varchar(100) DEFAULT NULL,
  `courSamedi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id`, `heure`, `courLundi`, `courMardi`, `courMercredi`, `courJeudi`, `courVendredi`, `courSamedi`) VALUES
(8, '8h-9h', 'sport', '', '', '', '', ''),
(10, '8h-9h', 'sportt2', '', '', '', '', ''),
(11, '8h-9h', 'sport43', '', '', '', '', ''),
(12, '8h-9h', 'sport12', '', '', '', '', ''),
(13, '9', '', 'hdshj', '', '', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `diplomes`
--

CREATE TABLE `diplomes` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `annee` int(11) DEFAULT NULL,
  `entraineur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `diplomes`
--

INSERT INTO `diplomes` (`id`, `titre`, `annee`, `entraineur_id`) VALUES
(1, 'UEFA', 2019, 1),
(2, 'master', 2017, 1),
(3, 'license de football', 2020, 2),
(4, 'license en', 2013, 1);

-- --------------------------------------------------------

--
-- Structure de la table `emails`
--

CREATE TABLE `emails` (
  `email_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sender_name` varchar(100) DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `email_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `entraineur`
--

CREATE TABLE `entraineur` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `nationalite` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `poste` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `entraineur`
--

INSERT INTO `entraineur` (`id`, `nom`, `age`, `nationalite`, `email`, `password`, `photo`, `poste`) VALUES
(1, 'Abdallah Idrissi', 36, 'Marocain', 'Abdallah Idrissi@example.com', 'entraineur123', 'image (1).jpg', 'tacktick coach'),
(2, 'Noureddine Boubou', 28, 'Marocain', 'Julienmorel@gmail.com', 'entraineur123', 'image (2).jpg', 'skill Coach'),
(3, 'Nabil Baha', 47, 'Marocain', 'ahmed.karim@gmail.com', 'entraineur123', 'image (3).jpg', 'préparateur physique');

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`id`, `titre`, `description`, `status`, `created_at`) VALUES
(1, 'Formation Intense', 'Entraînement intensif pour attaquants', 'active', '2024-11-08 21:19:12'),
(2, 'Formation Défensive', 'Formation spécialisée en défense', 'inactive', '2024-11-08 21:19:12');

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

CREATE TABLE `joueurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `position` varchar(50) NOT NULL,
  `status` enum('active','blessee','repos') DEFAULT 'active',
  `physical_condition` int(11) DEFAULT 100,
  `performance` int(11) DEFAULT 100,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_entraineur` int(11) DEFAULT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  `hometown` varchar(255) NOT NULL,
  `dream` varchar(255) NOT NULL,
  `achievements` text DEFAULT NULL,
  `medical_status` text DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `joueurs`
--

INSERT INTO `joueurs` (`id`, `nom`, `age`, `position`, `status`, `physical_condition`, `performance`, `created_at`, `updated_at`, `id_entraineur`, `height`, `weight`, `hometown`, `dream`, `achievements`, `medical_status`, `email`, `password`, `image_path`) VALUES
(1, 'ayman dahhak', 25, 'Forward', 'active', 100, 100, '2024-12-20 13:42:30', '2024-12-20 13:42:30', NULL, 180, 70, 'marrakech', 'représenter le nation marocain team', 'MVP 2020', 'Healthy', '', '', 'image (5).jpg'),
(2, 'ayman dahhak', 25, 'Forward', 'active', 100, 100, '2024-12-20 13:42:30', '2024-12-20 13:42:30', NULL, 180, 70, 'marrakech', 'représenter le nation marocain team', 'MVP 2020', 'Healthy', '', '', 'image (23).jpg'),
(10, 'oussama ait mohmmed', 18, 'milieu', 'active', 100, 100, '2024-12-16 19:10:18', '2024-12-19 18:23:05', NULL, 0, 0, '', '', NULL, NULL, 'azzedinerih20@gmail', '0000', NULL),
(11, 'Azzedine Rih', 11, 'milieu', 'active', 100, 100, '2024-12-16 19:10:18', '2024-12-16 19:10:18', NULL, 0, 0, '', '', NULL, NULL, '', '', NULL),
(14, 'marwan', 14, 'attaquant', 'active', 100, 100, '2024-12-16 19:10:18', '2024-12-16 19:10:18', NULL, 0, 0, '', '', NULL, NULL, '', '', NULL),
(15, 'aymen abbad', 19, 'attaquant', 'active', 100, 100, '2024-12-19 20:53:50', '2024-12-19 20:53:50', NULL, 178, 80, '0', 'none', '', '', 'azzedinerih2001@gmail.com', '$2y$10$3kN19DLbdmzq.VFh1d4WjeW1ev3MRtyq4tjDFWKZhFDBZYkOd/DIG', 'uploads/linus.jpeg'),
(16, 'KARIM BENZEMA', 37, 'attaquant', 'active', 97, 100, '2024-12-19 21:08:08', '2024-12-19 21:21:31', NULL, 186, 96, '0', 'being R9', 'champions league 5\r\nbaloon d\'or', 'good ', 'karimBenzema9@gmail.com', '$2y$10$8lc03dtbFfQisQbP8bX/c.E9R3nnFPvLztFZhm3hHzonqdesiURUu', 'uploads/download.jpeg'),
(17, 'Achraf Hakimi', 36, 'defenseur', 'active', 100, 100, '2024-12-19 21:38:08', '2024-12-19 21:38:08', NULL, 186, 96, '0', 'wining Copa africa', 'champions leagues 1\r\nBalon D\'Or 0\r\n', '', 'AchrafHakimi2@gmail.com', '$2y$10$WiBef1b8EJSt1fUQrxobouWWsgSY7k2KuDMdftY2xfcdvISw43f3K', 'uploads/hakimi-HD.png');

-- --------------------------------------------------------

--
-- Structure de la table `matches`
--

CREATE TABLE `matches` (
  `id` int(11) NOT NULL,
  `match_date` date DEFAULT NULL,
  `opponent` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `match_type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `matches`
--

INSERT INTO `matches` (`id`, `match_date`, `opponent`, `location`, `match_type`, `created_at`) VALUES
(1, '2025-11-12', NULL, NULL, NULL, '2024-11-23 17:52:01'),
(2, '2024-12-17', NULL, NULL, NULL, '2024-11-23 17:52:01');

-- --------------------------------------------------------

--
-- Structure de la table `medical_status`
--

CREATE TABLE `medical_status` (
  `medical_status_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `conditionP` varchar(255) NOT NULL,
  `injury_history` text DEFAULT NULL,
  `fitness_level` varchar(50) DEFAULT NULL,
  `last_checkup_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `cleared_to_play` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `medical_status`
--

INSERT INTO `medical_status` (`medical_status_id`, `player_id`, `conditionP`, `injury_history`, `fitness_level`, `last_checkup_date`, `notes`, `cleared_to_play`) VALUES
(4, 1, 'Healthy', 'Minor knee sprain in 2023', 'Excellent', '2024-12-15', 'Player is cleared for the upcoming season.', 1);

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `metier` varchar(15) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `members`
--

INSERT INTO `members` (`id`, `nom`, `email`, `metier`, `image`) VALUES
(1, 'Jane Smith', 'jane.smith@example.com', 'Entraineur', 'images/icon/avatar-04.jpg'),
(2, 'Azzedine Rih', 'azzedinerih2001@gmail.com', 'Admin', 'images/icon/avatar-01.jpg'),
(3, 'marwan', 'marwan@gmail.com', 'entraineur', 'images/icon/avatar-02.jpg'),
(4, 'azough ', 'soufian@gmail.com', 'entraineur', 'images/icon/avatar-06.jpg'),
(5, 'RIH SMAAIL', 'rihsmaail@gmail.com', 'entraineur', 'images/icon/avatar-05.jpg'),
(6, 'khalid', 'khalid@gmail.com', 'entraineur', 'uploads/2024/12/20/6764bb2b8f518-team-1.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sender_name` varchar(100) DEFAULT NULL,
  `message_content` text DEFAULT NULL,
  `message_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notification_content` text DEFAULT NULL,
  `notification_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`, `created_at`) VALUES
(1, 'jane.smith@example.com', 'random_token_123', '2024-11-20 00:00:00', '2024-11-18 22:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `preinscriptions`
--

CREATE TABLE `preinscriptions` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `position_preferree` varchar(50) NOT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `preinscriptions`
--

INSERT INTO `preinscriptions` (`id`, `nom`, `prenom`, `date_naissance`, `adresse`, `telephone`, `email`, `position_preferree`, `experience`, `date_inscription`) VALUES
(22, 'outouchente', 'oussama', '0000-00-00', 'OURIKA TAHANNAOUT EL HAOUEZ', '0649511024', 'OUSSAMAOUTOUCHENTE@GMAIL.COM', 'gardian', 'non', '2024-11-24 13:46:55'),
(23, 'ettahiri', 'abdessamad', '0000-00-00', 'douar zmran lostora 120', '0612349832', 'Thabdo11@gmail.com', 'milieu', 'non', '2024-12-02 09:31:02'),
(24, 'EL Fatimy', 'El Mehdi', '0000-00-00', 'sidi yousef', '0762818313', 'mehdifatimi84@gmail.com', 'milieu', 'non', '2024-12-02 09:35:33'),
(25, 'outouchente', 'oussama', '0000-00-00', 'OURIKA TAHANNAOUT EL HAOUEZ', '0649511024', 'OUSSAMAOUTOUCHENTE@GMAIL.COM', 'gardian', 'non', '2024-12-02 09:42:45'),
(26, 'khalid', 'elbena', '0000-00-00', 'douar zmran lostora 120', '0600500047', 'khalidelbenna@gmail.com', 'gardian', 'non', '2024-12-04 19:39:37'),
(27, 'khalid', 'elbena', '0000-00-00', 'douar zmran lostora 120', '0600500047', 'khalidelbenna@gmail.com', 'gardian', 'non', '2024-12-05 15:37:32'),
(28, 'khalid', 'elbena', '0000-00-00', 'douar zmran lostora 120', '0600500047', 'khalidelbenna@gmail.com', 'gardian', 'non', '2024-12-05 15:38:00'),
(29, 'khalid', 'elbena', '0000-00-00', 'douar zmran lostora 120', '0600500047', 'khalidelbenna@gmail.com', 'gardian', 'non', '2024-12-05 15:41:13'),
(30, 'Rai Classique', 'MEHDI', '0000-00-00', '1198 Mhamid', '0875543333', 'midodesignltd@gmail.com', 'Striker', 'NON', '2024-12-10 18:41:48'),
(31, 'Rai Classique', 'MEHDI', '0000-00-00', '1198 Mhamid', '0875543333', 'midodesignltd@gmail.com', 'Defender', 'NON', '2024-12-10 18:43:38'),
(32, 'mouna', 'aglaou', '0000-00-00', 'douar iziki', '0649511024', 'mounaaglaou@gmail.com', 'Defender', 'Non', '2024-12-13 12:59:48'),
(33, 'Azzedine', 'Rih', '0000-00-00', 'taznakhte-ouarzazat', '0603075442', 'azzedinerih2001@gmail.com', 'Goalkeeper', '', '2024-12-20 01:43:05'),
(34, 'Azzedine', 'Rih', '0000-00-00', 'taznakhte-ouarzazat', '0603075442', 'azzedinerih2001@gmail.com', 'Midfielder', '', '2024-12-20 02:01:31');

-- --------------------------------------------------------

--
-- Structure de la table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `activity_type` enum('Training','Match','Recovery','Educational') NOT NULL,
  `player_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `schedule`
--

INSERT INTO `schedule` (`id`, `title`, `description`, `date`, `time`, `location`, `activity_type`, `player_id`) VALUES
(1, 'Morning Training Session', 'Ball control drills and passing techniques', '2024-12-21', '08:00:00', 'Training Ground A', 'Training', 1),
(2, 'Friendly Match', 'Friendly match with local club', '2024-12-22', '15:00:00', 'Stadium B', 'Match', 1),
(3, 'Fitness and Recovery', 'Fitness workout and physiotherapy', '2024-12-23', '10:00:00', 'Fitness Center', '', 1),
(4, 'Tactical Session', 'Tactical play and set pieces', '2024-12-24', '11:00:00', 'Training Ground A', 'Training', 1);

-- --------------------------------------------------------

--
-- Structure de la table `specialisations`
--

CREATE TABLE `specialisations` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `progression` int(11) NOT NULL,
  `entraineur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `specialisations`
--

INSERT INTO `specialisations` (`id`, `nom`, `progression`, `entraineur_id`) VALUES
(1, 'Tactic de jeu', 70, 1),
(2, 'Tactic de jeu', 60, 2);

-- --------------------------------------------------------

--
-- Structure de la table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `time_slot` varchar(50) NOT NULL,
  `day` varchar(20) NOT NULL,
  `subject` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `timetable`
--

INSERT INTO `timetable` (`id`, `group_id`, `time_slot`, `day`, `subject`) VALUES
(11, 2, '08:00-09:00', 'Monday', 'sport'),
(12, 1, '08:00-09:00', 'Tuesday', 'sport'),
(13, 1, '08:00-09:00', 'Monday', 'sport');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'images/icon/avatar-01.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `user_settings`
--

CREATE TABLE `user_settings` (
  `setting_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `setting_name` varchar(100) DEFAULT NULL,
  `setting_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achievement`
--
ALTER TABLE `achievement`
  ADD PRIMARY KEY (`achievement_id`),
  ADD KEY `player_id` (`player_id`);

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `carrieres`
--
ALTER TABLE `carrieres`
  ADD PRIMARY KEY (`id_carreire`),
  ADD KEY `id_entraineur` (`id_entraineur`);

--
-- Index pour la table `contacts_player`
--
ALTER TABLE `contacts_player`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `diplomes`
--
ALTER TABLE `diplomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entraineur_id` (`entraineur_id`);

--
-- Index pour la table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`email_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `entraineur`
--
ALTER TABLE `entraineur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `joueurs`
--
ALTER TABLE `joueurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `preinscriptions`
--
ALTER TABLE `preinscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_group_id` (`group_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Index pour la table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `emails`
--
ALTER TABLE `emails`
  MODIFY `email_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entraineur`
--
ALTER TABLE `entraineur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `formations`
--
ALTER TABLE `formations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `joueurs`
--
ALTER TABLE `joueurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `preinscriptions`
--
ALTER TABLE `preinscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `emails`
--
ALTER TABLE `emails`
  ADD CONSTRAINT `emails_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
