-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 22 mars 2019 à 06:53
-- Version du serveur :  10.1.36-MariaDB
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `covoiturage`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE TABLE `adresse` (
  `id` int(11) NOT NULL,
  `numeroRue` int(11) DEFAULT NULL,
  `nomRue` varchar(50) DEFAULT NULL,
  `codePostal` int(11) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`id`, `numeroRue`, `nomRue`, `codePostal`, `ville`) VALUES
(1, 18, 'Avenue de l\'hopital', 84140, 'Monteux'),
(2, 18, 'rue de l', 84170, 'Monteux'),
(26, 18, 'rue de l hôpital2', 84170, 'Monteux');

-- --------------------------------------------------------

--
-- Structure de la table `besoin`
--

CREATE TABLE `besoin` (
  `id` int(11) NOT NULL,
  `convoitureur` tinyint(1) DEFAULT NULL,
  `passager` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `besoin`
--

INSERT INTO `besoin` (`id`, `convoitureur`, `passager`) VALUES
(1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `calendrier_filiere`
--

CREATE TABLE `calendrier_filiere` (
  `id` int(11) NOT NULL,
  `filiere` int(11) DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `numeroSemaine` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `calendrier_filiere`
--

INSERT INTO `calendrier_filiere` (`id`, `filiere`, `dateDebut`, `dateFin`, `numeroSemaine`) VALUES
(1, 1, '2019-02-03', '2019-02-08', 1);

-- --------------------------------------------------------

--
-- Structure de la table `filiere`
--

CREATE TABLE `filiere` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `filiere`
--

INSERT INTO `filiere` (`id`, `nom`, `type`) VALUES
(1, 'BTS Systeme Informatique Solution B', 'BTS SIO SLAM');

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

CREATE TABLE `lieu` (
  `id` int(11) NOT NULL,
  `lieu` varchar(350) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`id`, `lieu`) VALUES
(1, 'Avignon'),
(2, 'Paris'),
(3, 'testCity'),
(4, 'Bagdad');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `trajet` int(11) DEFAULT NULL,
  `idUtilisateur` int(11) DEFAULT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id`, `trajet`, `idUtilisateur`, `status`) VALUES
(1, 1, 1, 'ACTIF'),
(2, 2, 1, 'ACTIF'),
(4, 1, 2, 'ACTIF'),
(5, 4, 2, 'ACTIF'),
(6, 2, 2, 'ACTIF');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `nom`) VALUES
(1, 'Etudiant');

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE `trajet` (
  `id` int(11) NOT NULL,
  `idConducteur` int(11) NOT NULL,
  `dateParcours` date DEFAULT NULL,
  `heureDepart` time DEFAULT NULL,
  `heureArrivee` time NOT NULL,
  `lieuDepart` int(11) DEFAULT NULL,
  `lieuArrivee` int(11) DEFAULT NULL,
  `placeDisponible` int(11) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `trajet`
--

INSERT INTO `trajet` (`id`, `idConducteur`, `dateParcours`, `heureDepart`, `heureArrivee`, `lieuDepart`, `lieuArrivee`, `placeDisponible`, `status`) VALUES
(1, 1, '2019-02-12', '07:00:00', '08:00:00', 1, 3, 4, 'ACTIF'),
(2, 2, '2019-02-07', '17:00:00', '18:00:00', 2, 1, 3, 'ACTIF'),
(3, 2, '2019-03-08', '09:00:00', '15:30:00', 2, 3, 4, 'ACTIF'),
(4, 1, '2019-03-08', '09:00:00', '15:30:00', 1, 2, 4, 'ACTIF');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `motDePasse` varchar(50) DEFAULT NULL,
  `adresse` int(11) DEFAULT NULL,
  `voiture` int(11) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `filiere` int(11) DEFAULT NULL,
  `lieu_Depart` int(11) NOT NULL,
  `lieu_Arrivee` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `email`, `motDePasse`, `adresse`, `voiture`, `role`, `filiere`, `lieu_Depart`, `lieu_Arrivee`, `status`) VALUES
(1, 'admin', 'admin', 'adm', 'fff7eb243dbd210499ea317274aa4f6203d4dbce', 2, 1, '1', 1, 0, 0, 0),
(2, 'Neutron', 'Jimmy', 'test', 'test', 2, 3, '1', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `id` int(11) NOT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `modele` varchar(50) DEFAULT NULL,
  `place` int(11) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`id`, `marque`, `modele`, `place`, `couleur`) VALUES
(1, 'Clio', '2', 5, 'Grise'),
(2, 'BMW', 'M5', 2, 'Rouge'),
(3, 'Ford', 'Challenger', 3, 'Noir');

-- --------------------------------------------------------

--
-- Structure de la table `voyager_arrivee`
--

CREATE TABLE `voyager_arrivee` (
  `lieuArrivee` int(11) DEFAULT NULL,
  `trajetArrivee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `voyager_depart`
--

CREATE TABLE `voyager_depart` (
  `lieuDepart` int(11) DEFAULT NULL,
  `trajetDepart` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `besoin`
--
ALTER TABLE `besoin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `calendrier_filiere`
--
ALTER TABLE `calendrier_filiere`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `filiere`
--
ALTER TABLE `filiere`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adresse`
--
ALTER TABLE `adresse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `besoin`
--
ALTER TABLE `besoin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `calendrier_filiere`
--
ALTER TABLE `calendrier_filiere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `filiere`
--
ALTER TABLE `filiere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `lieu`
--
ALTER TABLE `lieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
