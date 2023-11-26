-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 26 nov. 2023 à 01:11
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `location`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `id_membre` int(11) NOT NULL,
  `id_vehicule` int(11) NOT NULL,
  `date_heure_depart` datetime DEFAULT NULL,
  `date_heure_fin` datetime DEFAULT NULL,
  `prix_total` int(11) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `id_vehicule`, `date_heure_depart`, `date_heure_fin`, `prix_total`, `date_enregistrement`) VALUES
(6, 6, 2, '2023-11-26 00:57:00', '2023-12-08 04:12:00', 1680, '2023-11-26 00:57:15');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20231115100251', '2023-11-15 11:02:59', 116),
('DoctrineMigrations\\Version20231115100831', '2023-11-15 11:08:38', 102),
('DoctrineMigrations\\Version20231115101044', '2023-11-15 11:11:19', 94),
('DoctrineMigrations\\Version20231116091123', '2023-11-16 10:11:33', 36),
('DoctrineMigrations\\Version20231116110241', '2023-11-16 12:02:50', 90);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `civilite` tinyint(1) DEFAULT NULL,
  `statut` varchar(11) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `username`, `password`, `nom`, `prenom`, `email`, `civilite`, `statut`, `date_enregistrement`) VALUES
(5, 'baba', '$2y$13$OC5QBoVOotVbIrZoU2x9k.Gi91uw6L2900Sp.b6P2inmXkQsBd/nu', 'Ringler', 'Baptiste', 'ringler@gmail.com', 0, 'ROLE_USER', '2023-11-17 10:29:42'),
(6, 'dada', '$2y$13$5ZqSfKqX67F582kMMWdu/e09suxc2kNR9pwcX3YjMMKbUsiahpy/.', 'test', 'Damien', 'damienraunier@gmail.com', 1, 'ROLE_ADMIN', '2023-11-17 11:43:53'),
(7, 'test', '$2y$13$6QJ2YCF3M3cpV5c.kKy0.u8uGOo6/FSfsNkwZe3opOL2YBcCX7f/G', 'test', 'test', 'test@gmail.com', 0, 'ROLE_USER', '2023-11-17 12:09:10'),
(9, 'test3', '$2y$13$5CaBrNO6uFS6ae1Y3F.sDu.GaaFEM6G2ys3Ei.nBYH/texXxnBslW', 'test', 'test', 'test3@test.fr', 0, 'ROLE_ADMIN', '2023-11-23 23:11:24'),
(10, 'test22', '$2y$13$lyVmZTxgHr3LNQhapw5VPuEf4qKfeYy2VQCazHIzXUwoDBd2IUkTG', 'sdqsd', 'sdqs', 'test@test.fr', 1, 'ROLE_USER', '2023-11-25 23:28:57');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE `vehicule` (
  `id_vehicule` int(11) NOT NULL,
  `titre` varchar(200) DEFAULT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `modele` varchar(50) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `prix_journalier` int(11) DEFAULT NULL,
  `date_enregistrement` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`id_vehicule`, `titre`, `marque`, `modele`, `description`, `photo`, `prix_journalier`, `date_enregistrement`) VALUES
(1, 'Nissan Skyline', 'Nissan', 'Skyline R29', 'Location d\'un véhicule de collection', 'https://i.pinimg.com/originals/05/17/27/051727186536811a872f01549c75e0a6.jpg', 265, '2023-11-15 07:21:00'),
(2, 'Nissan S13', 'Nissan', 'S13', 'Location d\'une voiture de collection des années 90', 'https://www.downshift.fr/wp-content/uploads/2020/03/Nissan-200SX-S13-0.jpg', 210, '2023-11-15 12:22:00'),
(3, 'Nissan Sunny', 'Nissan', 'Sunny', 'Location du véhicule Nissan Sunny', 'https://images.caradisiac.com/logos-ref/modele/modele--nissan-sunny-coupe/S0-modele--nissan-sunny-coupe.jpg', 150, '2023-11-15 17:38:00'),
(5, 'Toyota Hilux', 'Toyota', 'Hilux', 'Location d\'un 4x4', 'https://cdn-s-www.lalsace.fr/images/23B89BC9-EE35-4CDC-A50D-4A7D23DF7E7D/NW_raw/top-gear-va-tout-faire-pour-tuer-ce-hilux-en-vain-photo-toyota-1684933128.jpg', 100, '2023-11-23 11:38:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`id_vehicule`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `vehicule`
--
ALTER TABLE `vehicule`
  MODIFY `id_vehicule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
