-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 26 mars 2025 à 11:42
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `adminischool`
--

-- --------------------------------------------------------

--
-- Structure de la table `absences`
--

CREATE TABLE `absences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `absence_date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `acteur`
--

CREATE TABLE `acteur` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `secondName` varchar(255) DEFAULT NULL,
  `accountType` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `childName` varchar(255) DEFAULT NULL,
  `SchoolName` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `acteurs`
--

CREATE TABLE `acteurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `secondName` varchar(255) NOT NULL,
  `accountType` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(4, '6 ème', '2025-03-19 18:15:56', '2025-03-19 18:15:56'),
(5, '5 ème', '2025-03-19 18:15:56', '2025-03-19 18:15:56'),
(6, '4 ème ', '2025-03-19 18:15:56', '2025-03-19 18:15:56'),
(7, '3 ème', '2025-03-19 18:15:56', '2025-03-19 18:15:56'),
(8, '2 nd', '2025-03-19 18:15:56', '2025-03-19 18:15:56'),
(9, '1 ère', '2025-03-19 18:15:56', '2025-03-19 18:15:56'),
(10, 'Tle', '2025-03-19 18:15:56', '2025-03-19 18:15:56');

-- --------------------------------------------------------

--
-- Structure de la table `convocations`
--

CREATE TABLE `convocations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `convocation_date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tuteur_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `documents`
--

INSERT INTO `documents` (`id`, `tuteur_id`, `file_path`, `created_at`, `updated_at`) VALUES
(3, 2, 'documents/YG1VnB1bAG4LUCunFnkZrIvDUoK2rimNSEQ0peta.pdf', '2025-03-19 14:21:37', '2025-03-19 14:21:37'),
(4, 2, 'documents/zfnUtIMB67VepnFlff6mHuRNjm3NqsWxcpIOFt1Q.pdf', '2025-03-19 14:24:07', '2025-03-19 14:24:07'),
(5, 2, 'documents/8FR0ZAvmkT4xO0kHvtZoaobp5uAzGph6UlKhIoch.pdf', '2025-03-25 09:13:51', '2025-03-25 09:13:51');

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `class` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `event_time`, `class`, `created_at`, `updated_at`) VALUES
(1, 'Reunon', 'azertyuio', '2025-03-20', '17:18:00', 'classe 1', '2025-03-19 15:18:08', '2025-03-19 15:18:08');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_name` varchar(255) NOT NULL,
  `grade` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `grades`
--

INSERT INTO `grades` (`id`, `student_name`, `grade`, `created_at`, `updated_at`) VALUES
(1, 'bren nya', 15, '2025-03-25 08:16:42', '2025-03-25 08:16:42'),
(2, 'Jean Martin', 15, '2025-03-25 08:16:42', '2025-03-25 08:16:42'),
(3, 'Sophie Bernard', 15, '2025-03-25 08:16:42', '2025-03-25 08:16:42'),
(4, 'Luc Moreau', 15, '2025-03-25 08:16:42', '2025-03-25 08:16:42');

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `tuteur_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_14_150652_create_acteurs_table', 1),
(5, '2025_01_15_094240_create_schools_table', 1),
(6, '2025_01_17_095226_create_acteur_table', 1),
(7, '2025_01_19_180539_create_students_table', 1),
(8, '2025_01_20_112329_create_events_table', 1),
(9, '2025_01_22_114909_create_tuteurs_table', 1),
(10, '2025_01_23_080340_create_messages_table', 1),
(11, '2025_01_23_113632_create_paiements_table', 1),
(12, '2025_01_24_120525_create_absences_table', 1),
(13, '2025_01_24_120551_create_convocations_table', 1),
(14, '2025_01_30_112657_create_classes_table', 2),
(15, '2025_01_30_113256_add_tuteur_id_to_students_table', 2),
(16, '2025_01_31_085316_create_students_table', 3),
(17, '2025_01_31_085846_create_students_table', 4),
(18, '2025_01_31_085958_create_students_table', 5),
(19, '2025_02_02_003308_create_documents_table', 6),
(20, '2025_02_03_092901_update_tuteurs_table', 7),
(21, '2025_02_03_094721_update_paiements_table', 8),
(22, '2025_02_03_095122_remove_tuteur_id_from_paiements_table', 9),
(23, '2025_02_03_142120_remove_school_id_from_messages_table', 10),
(24, '2025_03_19_150038_add_remember_token_to_tuteurs_table', 11),
(25, '2025_03_19_150415_add_remember_token_to_schools_table', 12),
(26, '2025_03_19_202507_create_plannings_table', 13),
(27, '2025_03_19_203458_create_plannings_table', 14),
(28, '2025_03_21_132543_create_student_tutor_table', 15),
(29, '2025_03_23_161949_create_teacher_table', 16),
(30, '2025_03_24_104328_create_grades_table', 17),
(31, '2025_03_25_075936_create_teacher_table', 18);

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `typepaiement` varchar(255) NOT NULL,
  `montant` decimal(8,2) NOT NULL,
  `num_facture` varchar(255) NOT NULL,
  `etat` varchar(255) NOT NULL DEFAULT 'en attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiements`
--

INSERT INTO `paiements` (`id`, `nom`, `prenom`, `typepaiement`, `montant`, `num_facture`, `etat`, `created_at`, `updated_at`) VALUES
(3, 'elvis', 'nya', 'pension', 300030.00, 'VQNVFIEBL?CPEO', 'payé', '2025-02-03 08:53:20', '2025-03-19 14:38:44'),
(4, 'Darel', 'nya', 'other', 150000.00, 'VQNVFIEBL?CPEO', 'annulé', '2025-03-22 18:04:07', '2025-03-22 18:09:45'),
(5, 'Nya', 'Darel', 'other', 150000.00, '1234567890', 'annulé', '2025-03-22 18:14:39', '2025-03-24 07:53:50');

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `plannings`
--

CREATE TABLE `plannings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `teacher` varchar(255) NOT NULL,
  `room` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `plannings`
--

INSERT INTO `plannings` (`id`, `class`, `date`, `start_time`, `end_time`, `code`, `teacher`, `room`, `created_at`, `updated_at`) VALUES
(1, '1ère', '2025-03-19', '11:30', '12:30', 'C661', 'M. Petit', 'Salle 105', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(2, '1ère', '2025-03-19', '15:30', '16:30', 'C641', 'M. Martin', 'Salle 101', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(3, '1ère', '2025-03-19', '11:30', '12:30', 'C307', 'M. Martin', 'Salle 201', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(4, '5ème', '2025-03-19', '16:00', '17:00', 'C490', 'Mme Morel', 'Salle 201', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(5, '4ème', '2025-03-19', '11:30', '12:30', 'C747', 'Mme Lefevre', 'Salle 201', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(6, '6ème', '2025-03-19', '16:00', '17:00', 'C541', 'M. Dupont', 'Salle 202', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(7, '3ème', '2025-03-19', '12:00', '13:00', 'C634', 'Mme Durand', 'Salle 103', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(8, '6ème', '2025-03-19', '8:00', '9:00', 'C325', 'Mme Morel', 'Salle 201', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(9, '1ère', '2025-03-19', '15:30', '16:30', 'C554', 'M. Martin', 'Salle 101', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(10, '4ème', '2025-03-19', '14:00', '15:00', 'C972', 'Mme Lefevre', 'Salle 202', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(11, '6ème', '2025-03-19', '8:00', '9:00', 'C887', 'Mme Morel', 'Salle 104', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(12, '2nde', '2025-03-19', '12:00', '13:00', 'C790', 'Mme Morel', 'Salle 202', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(13, '5ème', '2025-03-19', '13:00', '14:00', 'C641', 'M. Martin', 'Salle 202', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(14, '6ème', '2025-03-19', '9:30', '10:30', 'C129', 'Mme Lefevre', 'Salle 105', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(15, '6ème', '2025-03-19', '9:00', '10:00', 'C203', 'Mme Durand', 'Salle 201', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(16, '1ère', '2025-03-19', '12:00', '13:00', 'C944', 'Mme Durand', 'Salle 103', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(17, '3ème', '2025-03-19', '16:30', '17:30', 'C430', 'M. Martin', 'Salle 202', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(18, '6ème', '2025-03-19', '15:00', '16:00', 'C570', 'Mme Morel', 'Salle 201', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(19, '4ème', '2025-03-19', '16:30', '17:30', 'C787', 'Mme Morel', 'Salle 202', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(20, '2nde', '2025-03-19', '13:30', '14:30', 'C412', 'M. Martin', 'Salle 201', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(21, '6ème', '2025-03-19', '14:30', '15:30', 'C215', 'Mme Lefevre', 'Salle 202', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(22, '6ème', '2025-03-19', '8:00', '9:00', 'C685', 'M. Martin', 'Salle 104', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(23, '3ème', '2025-03-19', '11:00', '12:00', 'C282', 'Mme Lefevre', 'Salle 102', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(24, '2nde', '2025-03-19', '10:00', '11:00', 'C213', 'M. Lambert', 'Salle 104', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(25, '4ème', '2025-03-19', '10:00', '11:00', 'C560', 'M. Petit', 'Salle 104', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(26, 'Terminale', '2025-03-19', '10:00', '11:00', 'C702', 'Mme Lefevre', 'Salle 102', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(27, 'Terminale', '2025-03-19', '17:30', '18:30', 'C897', 'M. Dupont', 'Salle 104', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(28, '4ème', '2025-03-19', '15:30', '16:30', 'C253', 'M. Martin', 'Salle 105', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(29, '2nde', '2025-03-19', '13:30', '14:30', 'C214', 'M. Petit', 'Salle 202', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(30, 'Terminale', '2025-03-19', '17:30', '18:30', 'C410', 'M. Lambert', 'Salle 105', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(31, '6ème', '2025-03-19', '8:00', '9:00', 'C432', 'Mme Durand', 'Salle 102', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(32, 'Terminale', '2025-03-19', '10:00', '11:00', 'C645', 'M. Lambert', 'Salle 103', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(33, 'Terminale', '2025-03-19', '13:30', '14:30', 'C332', 'M. Dupont', 'Salle 101', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(34, '1ère', '2025-03-19', '16:00', '17:00', 'C880', 'M. Dupont', 'Salle 101', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(35, '2nde', '2025-03-19', '14:00', '15:00', 'C168', 'M. Martin', 'Salle 102', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(36, '1ère', '2025-03-19', '13:30', '14:30', 'C533', 'Mme Durand', 'Salle 101', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(37, '3ème', '2025-03-19', '8:00', '9:00', 'C212', 'M. Lambert', 'Salle 201', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(38, '6ème', '2025-03-19', '12:00', '13:00', 'C395', 'Mme Durand', 'Salle 104', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(39, '3ème', '2025-03-19', '10:00', '11:00', 'C234', 'Mme Morel', 'Salle 103', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(40, '6ème', '2025-03-19', '12:30', '13:30', 'C921', 'Mme Morel', 'Salle 104', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(41, '1ère', '2025-03-19', '9:30', '10:30', 'C887', 'Mme Lefevre', 'Salle 103', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(42, '4ème', '2025-03-19', '12:30', '13:30', 'C523', 'Mme Lefevre', 'Salle 201', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(43, '3ème', '2025-03-19', '13:30', '14:30', 'C474', 'Mme Durand', 'Salle 201', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(44, '5ème', '2025-03-19', '11:30', '12:30', 'C921', 'M. Martin', 'Salle 201', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(45, '1ère', '2025-03-19', '16:00', '17:00', 'C282', 'M. Petit', 'Salle 105', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(46, '6ème', '2025-03-19', '16:30', '17:30', 'C119', 'M. Dupont', 'Salle 101', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(47, '6ème', '2025-03-19', '12:30', '13:30', 'C166', 'M. Martin', 'Salle 101', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(48, '6ème', '2025-03-19', '8:00', '9:00', 'C947', 'M. Martin', 'Salle 105', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(49, '5ème', '2025-03-19', '12:30', '13:30', 'C765', 'M. Martin', 'Salle 103', '2025-03-19 19:50:13', '2025-03-19 19:50:13'),
(50, '3ème', '2025-03-19', '14:00', '15:00', 'C374', 'Mme Morel', 'Salle 201', '2025-03-19 19:50:13', '2025-03-19 19:50:13');

-- --------------------------------------------------------

--
-- Structure de la table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `schools`
--

INSERT INTO `schools` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `type`, `remember_token`) VALUES
(1, 'UY2', 'uy2@gmail.com', '$2y$12$eoH94Y2PS6mSTBzjo7p2jeAMUIsyDG1e1RjPwBB1Wqi5Qt6BVmIfS', '2025-01-30 12:12:35', '2025-01-30 12:12:35', 'school', NULL),
(2, 'UY1', 'uy1@gmail.com', '$2y$12$Vz6F/UiUL9s6sv2lW.bnK.rVDUcnS8M.WLMeJXxATke8EakRYH5KS', '2025-02-03 12:18:55', '2025-02-03 12:18:55', 'school', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('113cgFgZW7ocaNX3NPMnnCLdMA6CgACZ9MAKV7vJ', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 Edg/134.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZVM4M3NwMkgxQlBHU1g0Q1g3cEpmRWFHdWVMeUJFTGZiYjIyMlRHQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ub3RpZmljYXRpb25zY2hvb2wiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUzOiJsb2dpbl90dXRldXJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1742932455),
('htdwYXNnpkVGfa1RY4oiaS9GJzAnJM8LqwJB8S5b', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 Edg/134.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ0tFOUJubjdENXJTYUVYM0NMb21BYW9SMzg1ck9SRllmcFRyeVZUYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdHVkZW50c2Nob29sIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1742976877),
('pfqavEDriVYTOikrT5dR8D0up3juhJf5cmQiYGbX', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 Edg/134.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYlpScUhHMVJiUDNUN0hIekxOVDBrWHg3RGUxN1ZQVTlhUHFjbFNHMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ub3RpZmljYXRpb25zY2hvb2wiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUzOiJsb2dpbl90dXRldXJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1742908607);

-- --------------------------------------------------------

--
-- Structure de la table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `enrollment_date` date DEFAULT NULL,
  `absences` int(11) NOT NULL DEFAULT 0,
  `convocations` int(11) NOT NULL DEFAULT 0,
  `warnings` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `students`
--

INSERT INTO `students` (`id`, `name`, `class`, `enrollment_date`, `absences`, `convocations`, `warnings`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', '6 ème', '2022-09-01', 3, 1, 1, '2025-01-31 08:01:26', '2025-01-31 08:01:26'),
(2, 'Jane Smith', '5 ème', '2021-09-01', 5, 2, 0, '2025-01-31 08:01:27', '2025-01-31 08:01:27'),
(3, 'Alice Brown', '1 ère', '2022-01-15', 2, 0, 2, '2025-01-31 08:01:27', '2025-01-31 08:01:27'),
(4, 'Bob Johnson', '6 ème', '2020-09-01', 4, 3, 0, '2025-01-31 08:01:27', '2025-01-31 08:01:27'),
(5, 'Charlie Davis', '2 nd', '2021-03-05', 0, 1, 10, '2025-01-31 08:01:27', '2025-01-31 08:01:27'),
(6, 'yvan djanko', 'TLE', '2021-04-15', 2, 4, 0, '2025-01-31 08:22:29', '2025-03-25 18:26:55'),
(7, 'bren nya', '3 ème', NULL, 0, 0, 0, '2025-02-03 12:41:51', '2025-02-03 12:41:51');

-- --------------------------------------------------------

--
-- Structure de la table `student_tutor`
--

CREATE TABLE `student_tutor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `tuteur_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `teacher`
--

CREATE TABLE `teacher` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'teacher',
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `teacher`
--

INSERT INTO `teacher` (`id`, `first_name`, `last_name`, `phone`, `email`, `subject`, `type`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Darel', 'Nya', '+237686236882', 'sanangdarel16@gmail.com', 'math', 'teacher', '$2y$12$sYTEUOcTuznLmcA1kd6zI.G8o/x86gIHrt7AAIiw5M0WkDSE3JU8a', '2025-03-25 07:54:15', '2025-03-25 07:54:15');

-- --------------------------------------------------------

--
-- Structure de la table `tuteurs`
--

CREATE TABLE `tuteurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `child_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tuteurs`
--

INSERT INTO `tuteurs` (`id`, `nom`, `prenom`, `type`, `email`, `child_name`, `password`, `created_at`, `updated_at`, `phone_number`, `remember_token`) VALUES
(2, 'Nya', 'Darel', 'parent', 'sanangdarel17@gmail.com', 'bren nya', '$2y$12$4bayUd4fzkoV1MmujQLdvuFH4JCu27RD0.x5y/BUAiv4X8FCDXmtW', '2025-02-03 12:39:17', '2025-02-03 12:41:51', '+237686236882', 'H7Wz2mAfyf2zxCf58LGGGhpyBWa3RYKI5edZ587ulhOvB7nCC7C57Cu7KpPk'),
(3, 'nya', 'bren', 'parent', 'bren@gmail.com', NULL, '$2y$12$wuBrS9e74N3KhgE2G9SOVeYEA6Q.NSJ/p5eCiJ8SFN1SG6wpE1eWy', '2025-02-03 12:41:09', '2025-02-03 12:41:09', '633456789', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `acteur`
--
ALTER TABLE `acteur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `acteur_username_unique` (`username`);

--
-- Index pour la table `acteurs`
--
ALTER TABLE `acteurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `acteurs_username_unique` (`username`);

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `convocations`
--
ALTER TABLE `convocations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_tuteur_id_foreign` (`tuteur_id`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_tuteur_id_foreign` (`tuteur_id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `plannings`
--
ALTER TABLE `plannings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schools_username_unique` (`email`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `student_tutor`
--
ALTER TABLE `student_tutor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_tutor_student_id_foreign` (`student_id`),
  ADD KEY `student_tutor_tuteur_id_foreign` (`tuteur_id`);

--
-- Index pour la table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_email_unique` (`email`);

--
-- Index pour la table `tuteurs`
--
ALTER TABLE `tuteurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tuteurs_email_unique` (`email`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `absences`
--
ALTER TABLE `absences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `acteur`
--
ALTER TABLE `acteur`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `acteurs`
--
ALTER TABLE `acteurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `convocations`
--
ALTER TABLE `convocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `plannings`
--
ALTER TABLE `plannings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `student_tutor`
--
ALTER TABLE `student_tutor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tuteurs`
--
ALTER TABLE `tuteurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_tuteur_id_foreign` FOREIGN KEY (`tuteur_id`) REFERENCES `tuteurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_tuteur_id_foreign` FOREIGN KEY (`tuteur_id`) REFERENCES `tuteurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `student_tutor`
--
ALTER TABLE `student_tutor`
  ADD CONSTRAINT `student_tutor_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_tutor_tuteur_id_foreign` FOREIGN KEY (`tuteur_id`) REFERENCES `tuteurs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
