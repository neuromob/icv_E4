-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 12 Février 2019 à 12:58
-- Version du serveur :  10.1.37-MariaDB-0+deb9u1
-- Version de PHP :  7.0.30-0+deb9u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Structure de la table `Adresse`
--

CREATE TABLE `Adresse` (
  `id` int(11) NOT NULL,
  `numeroRue` int(11) DEFAULT NULL,
  `nomRue` varchar(50) DEFAULT NULL,
  `codePostal` int(11) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Adresse`
--

INSERT INTO `Adresse` (`id`, `numeroRue`, `nomRue`, `codePostal`, `ville`) VALUES
(1, 18, 'rue de l hôpital', 84170, 'Monteux'),
(2, 18, 'Avenue de la Paix', 13000, 'Marseille');

-- --------------------------------------------------------

--
-- Structure de la table `Besoin`
--

CREATE TABLE `Besoin` (
  `id` int(11) NOT NULL,
  `convoitureur` tinyint(1) DEFAULT NULL,
  `passager` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Besoin`
--

INSERT INTO `Besoin` (`id`, `convoitureur`, `passager`) VALUES
(1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Calendrier_filiere`
--

CREATE TABLE `Calendrier_filiere` (
  `id` int(11) NOT NULL,
  `filiere` int(11) DEFAULT NULL,
  `dateDebut` date DEFAULT NULL,
  `dateFin` date DEFAULT NULL,
  `numeroSemaine` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Calendrier_filiere`
--

INSERT INTO `Calendrier_filiere` (`id`, `filiere`, `dateDebut`, `dateFin`, `numeroSemaine`) VALUES
(1, 1, '2019-02-03', '2019-02-08', 1);

-- --------------------------------------------------------

--
-- Structure de la table `Filiere`
--

CREATE TABLE `Filiere` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Filiere`
--

INSERT INTO `Filiere` (`id`, `nom`, `type`) VALUES
(1, 'BTS Systeme Informatique Solution B', 'BTS SIO SLAM');

-- --------------------------------------------------------

--
-- Structure de la table `Lieu`
--

CREATE TABLE `Lieu` (
  `id` int(11) NOT NULL,
  `numeroRue` int(11) DEFAULT NULL,
  `nomRue` varchar(50) DEFAULT NULL,
  `codePostal` int(11) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Lieu`
--

INSERT INTO `Lieu` (`id`, `numeroRue`, `nomRue`, `codePostal`, `ville`) VALUES
(1, 19, 'allée des sapins', 84000, 'Avignon'),
(2, 44, 'Rue des peupliers', 93000, 'Paris');

-- --------------------------------------------------------

--
-- Structure de la table `Reservation`
--

CREATE TABLE `Reservation` (
  `id` int(11) NOT NULL,
  `trajet` int(11) DEFAULT NULL,
  `placeDisponible` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Reservation`
--

INSERT INTO `Reservation` (`id`, `trajet`, `placeDisponible`) VALUES
(1, 1, 4),
(2, 2, 4);

-- --------------------------------------------------------

--
-- Structure de la table `Role`
--

CREATE TABLE `Role` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Role`
--

INSERT INTO `Role` (`id`, `nom`) VALUES
(1, 'Etudiant');

-- --------------------------------------------------------

--
-- Structure de la table `Trajet`
--

CREATE TABLE `Trajet` (
  `id` int(11) NOT NULL,
  `dateParcours` date DEFAULT NULL,
  `heureDepart` time DEFAULT NULL,
  `heureArrivee` time NOT NULL,
  `lieuDepart` int(11) DEFAULT NULL,
  `lieuArrivee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Trajet`
--

INSERT INTO `Trajet` (`id`, `dateParcours`, `heureDepart`, `heureArrivee`, `lieuDepart`, `lieuArrivee`) VALUES
(1, '2019-02-12', '07:00:00', '08:00:00', 1, 2),
(2, '2019-02-07', '17:00:00', '18:00:00', 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `motDePasse` varchar(50) DEFAULT NULL,
  `adresse` int(11) DEFAULT NULL,
  `besoin` int(11) DEFAULT NULL,
  `voiture` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `filiere` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `nom`, `prenom`, `email`, `motDePasse`, `adresse`, `besoin`, `voiture`, `role`, `filiere`) VALUES
(1, '', '', '', NULL, 1, 1, 1, 1, 1),
(2, 'userAndroid', 'Alex', 'testAndroid@test.fr', '1234', 2, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Voiture`
--

CREATE TABLE `Voiture` (
  `id` int(11) NOT NULL,
  `marque` varchar(50) DEFAULT NULL,
  `modele` varchar(50) DEFAULT NULL,
  `place` int(11) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Voiture`
--

INSERT INTO `Voiture` (`id`, `marque`, `modele`, `place`, `couleur`) VALUES
(1, 'Renault', 'Zoe', 5, 'blanche');

-- --------------------------------------------------------

--
-- Structure de la table `Voyager_Arrivee`
--

CREATE TABLE `Voyager_Arrivee` (
  `lieuArrivee` int(11) DEFAULT NULL,
  `trajetArrivee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Voyager_Depart`
--

CREATE TABLE `Voyager_Depart` (
  `lieuDepart` int(11) DEFAULT NULL,
  `trajetDepart` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Adresse`
--
ALTER TABLE `Adresse`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Besoin`
--
ALTER TABLE `Besoin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Calendrier_filiere`
--
ALTER TABLE `Calendrier_filiere`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Filiere`
--
ALTER TABLE `Filiere`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Lieu`
--
ALTER TABLE `Lieu`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Role`
--
ALTER TABLE `Role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Trajet`
--
ALTER TABLE `Trajet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Voiture`
--
ALTER TABLE `Voiture`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Adresse`
--
ALTER TABLE `Adresse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Besoin`
--
ALTER TABLE `Besoin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `Calendrier_filiere`
--
ALTER TABLE `Calendrier_filiere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `Filiere`
--
ALTER TABLE `Filiere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `Lieu`
--
ALTER TABLE `Lieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Role`
--
ALTER TABLE `Role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `Trajet`
--
ALTER TABLE `Trajet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Voiture`
--
ALTER TABLE `Voiture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
