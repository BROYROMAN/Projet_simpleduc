-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Dim 15 Mars 2020 à 18:37
-- Version du serveur :  10.1.26-MariaDB-0+deb9u1
-- Version de PHP :  7.0.30-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `bdgestionprojets`
--

-- --------------------------------------------------------

--
-- Structure de la table `contrat`
--

CREATE TABLE `contrat` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `datesignature` date NOT NULL,
  `delaiproduction` date NOT NULL,
  `coutglobal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `contrat`
--

INSERT INTO `contrat` (`id`, `nom`, `datesignature`, `delaiproduction`, `coutglobal`) VALUES
(1, 'Guy Mollet', '2018-10-09', '2018-10-10', 850),
(2, 'Gambetta', '2018-10-22', '2018-10-28', 500),
(3, '6 ans', '1998-03-26', '2018-03-26', 600);

-- --------------------------------------------------------

--
-- Structure de la table `developpeur`
--

CREATE TABLE `developpeur` (
  `codedev` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `date_naiss` date NOT NULL,
  `tel` varchar(10) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `remuneration` int(11) NOT NULL,
  `couthoraire` int(11) NOT NULL,
  `idEquipe` int(11) DEFAULT NULL,
  `idOutils` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `developpeur`
--

INSERT INTO `developpeur` (`codedev`, `nom`, `prenom`, `date_naiss`, `tel`, `adresse`, `remuneration`, `couthoraire`, `idEquipe`, `idOutils`) VALUES
(18, 'MARIE ANGE', 'POUCHAIN', '1998-03-25', '0612594660', '16 residence jean poperen', 500, 10, 32, 1),
(19, 'BROY', 'ROMAN', '1998-03-25', '0612594660', '16 residence jean poperen', 500, 10, 34, 1),
(20, 'Iflah', 'Younesse', '1997-11-30', '0609811931', 'xfxxbfss', 500, 50, 33, 2),
(21, 'Julien', 'Berton', '1998-07-19', '0609811931', 'xgfsdfs', 450, 50, 33, 3),
(22, 'Rocha ', 'Maxime', '1998-11-28', '0609811931', 'jsdrgqgvq', 700, 4, 33, 2),
(23, 'Ydee', 'Corentin', '1998-12-30', '0609811931', 'qzgqzbherg', 900, 50, 33, 2);

-- --------------------------------------------------------

--
-- Structure de la table `equipe`
--

CREATE TABLE `equipe` (
  `libelle` varchar(150) NOT NULL,
  `idResponsable` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `equipe`
--

INSERT INTO `equipe` (`libelle`, `idResponsable`, `id`) VALUES
('equipe 3', 18, 32),
('PAS D\'EQUIPE', NULL, 33),
('equipe 2', 19, 34);

-- --------------------------------------------------------

--
-- Structure de la table `outils`
--

CREATE TABLE `outils` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `outils`
--

INSERT INTO `outils` (`id`, `libelle`, `version`) VALUES
(1, 'php', '5.0'),
(2, 'Symfony', '3.0'),
(3, 'Php', '7.0'),
(4, 'Symfony', '4.1');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `codeResponsable` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `nbdev` int(11) NOT NULL,
  `budget` int(11) NOT NULL,
  `cahierdescharges` varchar(255) NOT NULL,
  `idContrat` int(11) NOT NULL,
  `idUtil` int(11) NOT NULL,
  `idEquip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `projet`
--

INSERT INTO `projet` (`codeResponsable`, `nom`, `nbdev`, `budget`, `cahierdescharges`, `idContrat`, `idUtil`, `idEquip`) VALUES
(4, 'PROJET1', 5, 200, 'test', 1, 3, 32);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`id`, `libelle`) VALUES
(1, 'Admin'),
(2, 'Client');

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

CREATE TABLE `tache` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `heureprevue` int(11) NOT NULL,
  `idProjet` int(11) NOT NULL,
  `cout` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `tache`
--

INSERT INTO `tache` (`id`, `libelle`, `heureprevue`, `idProjet`, `cout`) VALUES
(2, 'MCD', 10, 4, 500);

-- --------------------------------------------------------

--
-- Structure de la table `traiter`
--

CREATE TABLE `traiter` (
  `id` int(11) NOT NULL,
  `idTache` int(11) NOT NULL,
  `idDev` int(11) NOT NULL,
  `nbheure` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `idRole` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `email`, `mdp`, `nom`, `prenom`, `idRole`, `photo`) VALUES
(1, 'roman.broy@hotmail.com', '$2y$10$C6cx3z/yFqFoQxgqSwlDB.62NVy2SKWO1qiS1K6DZTOOhTMXNIxFa', 'BROY', 'Roman', 1, ''),
(2, 'test@test.fr', '$2y$10$t/6rNUtj6emB8JCGyHIv/OIjN9tnRut/J9rGruQEoBTryFGC05SJO', 'test', 'test', 2, ''),
(3, '1', '', '1', '1', 2, ''),
(4, 'iflah.younesse@gmail.com', '$2y$10$ohLATWG3HxH3Ae3S7GGz/OKGKzKC5CvrxiRM6I77mUTAw2Gov0uQy', 'Iflah', 'Younesse', 1, '');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `contrat`
--
ALTER TABLE `contrat`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `developpeur`
--
ALTER TABLE `developpeur`
  ADD PRIMARY KEY (`codedev`),
  ADD KEY `idEquipe` (`idEquipe`),
  ADD KEY `idOutils` (`idOutils`);

--
-- Index pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipe_ibfk_1` (`idResponsable`);

--
-- Index pour la table `outils`
--
ALTER TABLE `outils`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`codeResponsable`),
  ADD KEY `idUtil` (`idUtil`),
  ADD KEY `idEquip` (`idEquip`),
  ADD KEY `idContrat` (`idContrat`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tache`
--
ALTER TABLE `tache`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idProjet` (`idProjet`);

--
-- Index pour la table `traiter`
--
ALTER TABLE `traiter`
  ADD PRIMARY KEY (`id`,`idTache`,`idDev`),
  ADD KEY `idTache` (`idTache`),
  ADD KEY `idDev` (`idDev`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idRole` (`idRole`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `contrat`
--
ALTER TABLE `contrat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `developpeur`
--
ALTER TABLE `developpeur`
  MODIFY `codedev` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT pour la table `equipe`
--
ALTER TABLE `equipe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT pour la table `outils`
--
ALTER TABLE `outils`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `codeResponsable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `tache`
--
ALTER TABLE `tache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `traiter`
--
ALTER TABLE `traiter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `developpeur`
--
ALTER TABLE `developpeur`
  ADD CONSTRAINT `developpeur_ibfk_1` FOREIGN KEY (`idEquipe`) REFERENCES `equipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `developpeur_ibfk_2` FOREIGN KEY (`idOutils`) REFERENCES `outils` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `equipe`
--
ALTER TABLE `equipe`
  ADD CONSTRAINT `equipe_ibfk_1` FOREIGN KEY (`idResponsable`) REFERENCES `developpeur` (`codedev`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `projet_ibfk_1` FOREIGN KEY (`idUtil`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projet_ibfk_2` FOREIGN KEY (`idEquip`) REFERENCES `equipe` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `projet_ibfk_3` FOREIGN KEY (`idContrat`) REFERENCES `contrat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tache`
--
ALTER TABLE `tache`
  ADD CONSTRAINT `tache_ibfk_1` FOREIGN KEY (`idProjet`) REFERENCES `projet` (`codeResponsable`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `traiter`
--
ALTER TABLE `traiter`
  ADD CONSTRAINT `traiter_ibfk_1` FOREIGN KEY (`idTache`) REFERENCES `tache` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `traiter_ibfk_2` FOREIGN KEY (`idDev`) REFERENCES `developpeur` (`codedev`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
