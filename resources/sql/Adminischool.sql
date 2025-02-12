-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 fév. 2025 à 10:04
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
(1, '6 ème', NULL, NULL),
(2, '5 ème', NULL, NULL),
(3, '4 ème', NULL, NULL);

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
(1, 1, 'documents/on0l5aEvEfNrMb3rdJ1T1Ij7vi9YqkotuJKiJ8Oo.pdf', '2025-02-01 23:45:00', '2025-02-01 23:45:00'),
(2, 1, 'documents/KCNWi5lcbWG7iZnVoE0RXDASrz0wVg4s3tRyPxG7.pdf', '2025-02-01 23:45:11', '2025-02-01 23:45:11');

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
(23, '2025_02_03_142120_remove_school_id_from_messages_table', 10);

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
(3, 'elvis', 'nya', 'pension', 300030.00, 'VQNVFIEBL?CPEO', 'payé', '2025-02-03 08:53:20', '2025-02-04 10:05:22');

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
-- Structure de la table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `schools`
--

INSERT INTO `schools` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`, `type`) VALUES
(1, 'UY2', 'uy2@gmail.com', '$2y$12$eoH94Y2PS6mSTBzjo7p2jeAMUIsyDG1e1RjPwBB1Wqi5Qt6BVmIfS', '2025-01-30 12:12:35', '2025-01-30 12:12:35', 'school'),
(2, 'UY1', 'uy1@gmail.com', '$2y$12$Vz6F/UiUL9s6sv2lW.bnK.rVDUcnS8M.WLMeJXxATke8EakRYH5KS', '2025-02-03 12:18:55', '2025-02-03 12:18:55', 'school');

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
('jBXDzZtV3KF9hnYxkr9Rj8LMtCe1XOlD3T0hLfjq', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 Edg/132.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMEl6aXlXRTV2WU10Q0k3dWlLZ1ZxckY0ZmlyZFZSc3AzYld6a1c4NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9maWxlZG9jdW1lbnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUzOiJsb2dpbl90dXRldXJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1738686373),
('KBNJmQaQDdEkjeuCOo3mKB0sDDEELJNCDATXa786', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 Edg/132.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicW9lSjVkUkFtN1R1RE1zaHh4U05oTFhyczJkaFJVVzZ5SUcwOFN1aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9maWxlZG9jdW1lbnQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUzOiJsb2dpbl90dXRldXJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1738873002),
('TLhfkQdJjB4Oh5qxCSYPzr4NeeqHMDNumPphZjfx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 Edg/132.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNTdrajI1ZEZwRUUzbnFmNXNuU2tMdEd4T3BKY2p5bXJ2V1U2WnJvbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1738751425),
('VEmGu4FyDyc5yroa6cjM9xH1mf6foPueBmiUBlAb', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36 Edg/132.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoic1p1cHJDTjZTWXJmQm9EMU1zWGtPbzlqS2lHcDQ0UXFlWWlOYkUzMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zaG93cGFpZW1lbnQvMyI7fXM6NTM6ImxvZ2luX3R1dGV1cl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1738667266);

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
(3, 'Alice Brown', 'TLE', '2022-01-15', 2, 0, 2, '2025-01-31 08:01:27', '2025-01-31 08:01:27'),
(4, 'Bob Johnson', '6 ème', '2020-09-01', 4, 3, 0, '2025-01-31 08:01:27', '2025-01-31 08:01:27'),
(5, 'Charlie Davis', '2 nd', '2021-03-05', 0, 1, 10, '2025-01-31 08:01:27', '2025-01-31 08:01:27'),
(6, 'yvan djanko', 'terminale', NULL, 2, 4, 0, '2025-01-31 08:22:29', '2025-02-03 11:48:23'),
(7, 'bren nya', '3ème', NULL, 0, 0, 0, '2025-02-03 12:41:51', '2025-02-03 12:41:51');

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
  `phone_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tuteurs`
--

INSERT INTO `tuteurs` (`id`, `nom`, `prenom`, `type`, `email`, `child_name`, `password`, `created_at`, `updated_at`, `phone_number`) VALUES
(1, 'elvis', 'nya', 'parent', 'nya@gmail.com', 'yvan djanko', '$2y$12$5jmBP2Hq27rdTTX/IZO/9ukEWBeLHf8w2iggoyiQZFKHPM7xNcaQu', '2025-01-30 10:39:02', '2025-01-31 08:22:29', '+237694517366'),
(2, 'Nya', 'Darel', 'parent', 'sanangdarel17@gmail.com', 'bren nya', '$2y$12$4bayUd4fzkoV1MmujQLdvuFH4JCu27RD0.x5y/BUAiv4X8FCDXmtW', '2025-02-03 12:39:17', '2025-02-03 12:41:51', '693865560'),
(3, 'nya', 'bren', 'parent', 'bren@gmail.com', NULL, '$2y$12$wuBrS9e74N3KhgE2G9SOVeYEA6Q.NSJ/p5eCiJ8SFN1SG6wpE1eWy', '2025-02-03 12:41:09', '2025-02-03 12:41:09', '633456789');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `convocations`
--
ALTER TABLE `convocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
