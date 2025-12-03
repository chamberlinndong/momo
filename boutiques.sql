-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 26 nov. 2025 à 16:08
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutiques`
--

-- --------------------------------------------------------

--
-- Structure de la table `publication`
--

CREATE TABLE `publication` (
  `id_publication` int(10) UNSIGNED NOT NULL,
  `photo` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `id_technicien` int(10) UNSIGNED NOT NULL,
  `date_publication` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `publication`
--

INSERT INTO `publication` (`id_publication`, `photo`, `description`, `id_technicien`, `date_publication`) VALUES
(1, 'image/images.jpeg', 'Maison plein pied en bois d\'ébène ', 2, '2025-11-26 13:03:48');

-- --------------------------------------------------------

--
-- Structure de la table `technicien`
--

CREATE TABLE `technicien` (
  `id_technicien` int(10) UNSIGNED NOT NULL,
  `photo_profil` varchar(255) NOT NULL,
  `identite` varchar(100) NOT NULL,
  `metier` varchar(100) NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `ville` varchar(100) NOT NULL,
  `localisation` varchar(255) NOT NULL,
  `categorie` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `technicien`
--

INSERT INTO `technicien` (`id_technicien`, `photo_profil`, `identite`, `metier`, `qualification`, `email`, `ville`, `localisation`, `categorie`, `mdp`, `date_creation`) VALUES
(1, 'profil/DSC_0104.jpg', 'chamberlin construction', 'architecte', 'Conception &amp; réalisation de projet immobiliers (plan;makette;devis;livraison)', 'esaitondaobame08@gmail.com', 'libreville', 'Rio', 'BTP', '19964453', '2025-11-26 12:52:14'),
(2, 'profil/istockphoto-154046398-612x612.jpg', 'OM construction', 'architecte', 'Conception &amp; réalisation de projet immobiliers (plan;makette;devis;livraison)', 'chamberlin@gmail.com', 'Oyem', 'vallée-sud', 'BTP', '19964453', '2025-11-26 13:00:57');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `nom` varchar(100) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `mdp` varchar(255) NOT NULL,
  `date_creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `telephone`, `email`, `photo`, `mdp`, `date_creation`) VALUES
(1, 'TONDA OBAME', '074453539', 'esaitondaobame08@gmail.com', 'image/images.jpeg', '19964453', '2025-11-26 12:42:01');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `publication`
--
ALTER TABLE `publication`
  ADD PRIMARY KEY (`id_publication`),
  ADD KEY `id_technicien` (`id_technicien`);

--
-- Index pour la table `technicien`
--
ALTER TABLE `technicien`
  ADD PRIMARY KEY (`id_technicien`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `publication`
--
ALTER TABLE `publication`
  MODIFY `id_publication` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `technicien`
--
ALTER TABLE `technicien`
  MODIFY `id_technicien` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `publication`
--
ALTER TABLE `publication`
  ADD CONSTRAINT `publication_ibfk_1` FOREIGN KEY (`id_technicien`) REFERENCES `technicien` (`id_technicien`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
