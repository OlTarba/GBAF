-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 15 mai 2020 à 11:29
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gbaf`
--

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE `account` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `question` varchar(250) NOT NULL,
  `reponse` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `account`
--

INSERT INTO `account` (`id_user`, `nom`, `prenom`, `username`, `password`, `question`, `reponse`) VALUES
(18, 'Berthelin', 'Thibault', 'OlTarba', '45053abcc15186832b392d444437bb449f666e1f', 'BMW ?', '860beddad989e0c2f48a4550eb690ba64b3f8b10'),
(19, 'Carpentier', 'Angélique', 'Larpentier', '9566cb34c0540b338c2b9361e735cda659374be2', 'Comment s\'appelle la grosse chatte ?', '7a076344e1f09fd026fa20666c33a2be615ead53');

-- --------------------------------------------------------

--
-- Structure de la table `acteur`
--

CREATE TABLE `acteur` (
  `id_acteur` int(11) NOT NULL,
  `acteur` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `logo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `acteur`
--

INSERT INTO `acteur` (`id_acteur`, `acteur`, `description`, `logo`) VALUES
(1, 'Formation & Co', 'Formation&co est une association française présente sur tout le territoire. <br>\r\nNous proposons à des personnes issues de tout milieu de devenir entrepreneur grâce à un crédit et un accompagnement professionnel et personnalisé. <br>\r\n<br>\r\nNotre proposition : <br>\r\n<br>\r\nun financement jusqu’à 30 000€ <br>\r\nun suivi personnalisé et gratuit <br>\r\nune lutte acharnée contre les freins sociétaux et les stéréotypes. <br>\r\n<br>\r\nLe financement est possible, peu importe le métier : coiffeur, banquier, éleveur de chèvres… .<br> \r\nNous collaborons avec des personnes talentueuses et motivées. \r\nVous n’avez pas de diplômes ? Ce n’est pas un problème pour nous ! <br>\r\n<br>\r\nNos financements s’adressent à tous.', 'formation_co.png'),
(2, 'Protect People', 'Protect people finance la solidarité nationale. <br>\r\nNous appliquons le principe édifié par la Sécurité sociale française en 1945 : permettre à chacun de bénéficier d’une protection sociale. <br>\r\n<br>\r\nChez Protect people, chacun cotise selon ses moyens et reçoit selon ses besoins. <br>\r\nProtect people est ouvert à tous, sans considération d’âge ou d’état de santé.\r\nNous garantissons un accès aux soins et une retraite.\r\n<br>\r\n<br>\r\nChaque année, nous collectons et répartissons 300 milliards d’euros. <br>\r\n<br>\r\nNotre mission est double :\r\n<br>\r\n<br>\r\nsociale : nous garantissons la fiabilité des données sociales <br>\r\néconomique : nous apportons une contribution aux activités économiques.', 'protectpeople.png'),
(3, 'DSA France', 'Dsa France accélère la croissance du territoire et s’engage avec les collectivités territoriales. <br>\r\nNous accompagnons les entreprises dans les étapes clés de leur évolution. <br>\r\n<br>\r\nNotre philosophie : s’adapter à chaque entreprise. <br>\r\nNous les accompagnons pour voir plus grand et plus loin et proposons des solutions de financement adaptées à chaque étape de la vie des entreprises\r\n', 'Dsa_france.png'),
(4, 'Chambre des Entrepreneurs (CDE)', 'La CDE (Chambre Des Entrepreneurs) accompagne les entreprises dans leurs démarches de formation.<br> \r\nSon président est élu pour 3 ans par ses pairs, chefs d’entreprises et présidents des CDE.', 'CDE.png');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id_post` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_acteur` int(11) NOT NULL,
  `date_add` datetime NOT NULL DEFAULT current_timestamp(),
  `post` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id_post`, `id_user`, `id_acteur`, `date_add`, `post`) VALUES
(27, 18, 1, '2020-05-15 11:18:43', 'Hey ! Super ce que vous faites !'),
(28, 18, 2, '2020-05-15 11:19:28', 'Tu peux me payer une BMW Serie 8 Stp ? 850i ou une M8 ce serais cool'),
(29, 19, 1, '2020-05-15 11:20:26', 'Cool ! Vous pouvez financez toute sorte de formation ?'),
(30, 19, 2, '2020-05-15 11:20:54', 'Il y a moyens de m\'acheter une nouveau petit chatons ? Ou une villa'),
(31, 19, 4, '2020-05-15 11:23:16', 'Dites ! Vous vous occupez vraiment des auto entreprenneurs, genre Freelance Developpeur Web ?');

-- --------------------------------------------------------

--
-- Structure de la table `vote`
--

CREATE TABLE `vote` (
  `id_user` int(11) NOT NULL,
  `id_acteur` int(11) NOT NULL,
  `vote` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `vote`
--

INSERT INTO `vote` (`id_user`, `id_acteur`, `vote`) VALUES
(18, 1, 1),
(18, 2, 1),
(19, 4, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `acteur`
--
ALTER TABLE `acteur`
  ADD PRIMARY KEY (`id_acteur`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`),
  ADD KEY `post - account` (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `account`
--
ALTER TABLE `account`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `acteur`
--
ALTER TABLE `acteur`
  MODIFY `id_acteur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post - account` FOREIGN KEY (`id_user`) REFERENCES `account` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
