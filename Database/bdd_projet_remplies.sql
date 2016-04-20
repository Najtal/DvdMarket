-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Dim 06 Mai 2012 à 11:24
-- Version du serveur: 5.5.20
-- Version de PHP: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `projet`
--
CREATE DATABASE `projet` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `projet`;

-- --------------------------------------------------------

--
-- Structure de la table `encheres`
--

CREATE TABLE IF NOT EXISTS `encheres` (
  `id_encheres` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `montant` double NOT NULL,
  `date_enchere` datetime NOT NULL,
  PRIMARY KEY (`id_encheres`),
  KEY `id_utilisateur` (`id_utilisateur`,`id_produit`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

--
-- Contenu de la table `encheres`
--

INSERT INTO `encheres` (`id_encheres`, `id_utilisateur`, `id_produit`, `montant`, `date_enchere`) VALUES
(15, 7, 5, 10, '2012-04-02 19:10:29'),
(16, 7, 5, 10, '2012-04-02 19:12:27'),
(17, 7, 5, 10, '2012-04-02 19:12:30'),
(18, 7, 5, 10, '2012-04-02 19:13:17'),
(19, 7, 5, 10, '2012-04-02 19:25:29'),
(20, 7, 5, 10, '2012-04-02 19:27:12'),
(21, 7, 5, 10, '2012-04-02 19:27:25'),
(22, 7, 5, 20, '2012-04-02 19:42:50'),
(26, 8, 4, 12, '2012-04-03 08:25:43'),
(27, 9, 4, 15, '2012-04-03 08:31:12'),
(28, 8, 4, 17, '2012-04-03 08:31:35'),
(29, 9, 5, 22, '2012-04-03 08:45:32'),
(30, 9, 1, 7, '2012-04-03 08:46:30'),
(31, 8, 5, 25, '2012-04-03 08:56:45'),
(32, 8, 1, 9, '2012-04-03 09:16:44'),
(33, 9, 1, 10, '2012-04-03 09:17:12'),
(34, 9, 3, 6, '2012-04-03 09:20:36'),
(35, 9, 4, 18, '2012-04-03 09:22:35'),
(36, 8, 3, 8, '2012-04-03 10:12:43'),
(37, 9, 3, 9, '2012-04-03 10:13:08'),
(38, 10, 3, 10, '2012-04-03 10:33:56'),
(39, 8, 4, 19, '2012-04-03 14:17:06'),
(40, 9, 2, 12, '2012-04-03 14:18:25'),
(41, 8, 2, 12.01, '2012-04-03 16:37:38'),
(42, 9, 2, 13, '2012-04-03 16:38:26'),
(43, 9, 4, 23, '2012-04-03 18:23:51'),
(44, 8, 2, 15, '2012-04-04 16:48:07'),
(45, 9, 2, 16, '2012-04-04 16:49:54'),
(46, 8, 2, 17, '2012-04-04 16:53:08'),
(58, 9, 1, 10.7, '2012-04-04 18:03:36'),
(59, 9, 5, 26, '2012-04-05 15:49:11'),
(60, 65, 6, 20, '2012-04-24 16:46:54'),
(61, 65, 24, 3, '2012-04-24 16:47:12'),
(62, 66, 7, 8.5, '2012-04-24 17:24:27'),
(63, 8, 1, 11, '2012-04-25 05:40:25'),
(64, 9, 1, 12, '2012-04-25 05:41:21'),
(65, 64, 22, 2.1, '2012-04-25 07:19:01'),
(66, 9, 24, 5, '2012-04-25 12:33:00'),
(67, 67, 2, 18, '2012-04-25 12:43:32'),
(68, 67, 19, 29420, '2012-04-25 12:48:53'),
(69, 8, 26, 4, '2012-04-26 04:14:56'),
(70, 9, 6, 20.5, '2012-04-26 06:53:44'),
(71, 10, 16, 5, '2012-04-26 10:28:39'),
(72, 8, 19, 30000, '2012-04-26 10:44:00'),
(73, 7, 22, 6, '2012-04-26 10:45:52'),
(74, 9, 2, 19, '2012-04-26 12:03:46'),
(76, 7, 35, 6, '2012-04-27 05:47:59'),
(77, 8, 35, 6.2, '2012-04-27 06:41:48'),
(78, 10, 5, 26.5, '2012-04-28 09:41:44'),
(79, 10, 2, 20, '2012-04-28 09:46:32'),
(81, 7, 31, 6, '2012-05-04 13:09:38'),
(82, 9, 23, 7, '2012-05-04 13:20:52');

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `id_genre` int(5) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET ascii NOT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `genres`
--

INSERT INTO `genres` (`id_genre`, `nom`) VALUES
(0, 'Autre'),
(1, 'Action'),
(2, 'Humour'),
(3, 'Comedie'),
(4, 'Policier'),
(5, 'Drame'),
(6, 'Animation'),
(7, 'Aventure'),
(8, 'Biographie'),
(9, 'Catastrophe'),
(10, 'Conte'),
(11, 'Crime'),
(12, 'Western'),
(13, 'Espionnage'),
(14, 'Fantastique'),
(15, 'Guerre'),
(16, 'Histoire'),
(17, 'Musical'),
(18, 'Policier'),
(19, 'Romance'),
(20, 'Science-fiction'),
(21, 'Sport'),
(22, 'Thriller'),
(23, 'Dessin animee');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id_message` int(30) NOT NULL AUTO_INCREMENT,
  `id_receveur` int(15) NOT NULL,
  `id_envoyeur` int(15) NOT NULL,
  `objet` varchar(50) CHARACTER SET armscii8 NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `lu` tinyint(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_message`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Contenu de la table `messages`
--

INSERT INTO `messages` (`id_message`, `id_receveur`, `id_envoyeur`, `objet`, `message`, `lu`, `date`) VALUES
(1, 7, 8, 'test mng', 'Salut, voici le message de mon test', 1, '2012-03-21 06:31:37'),
(2, 7, 8, 'test msg2', 'Ceci est un super message de test', 1, '2012-03-30 16:26:33'),
(3, 8, 7, 'test envoy?', 'le message est envoy? par 7 et recu par 8', 1, '2012-04-01 17:31:31'),
(4, 8, 7, 'test envoie', 'sdcssc', 1, '2012-04-01 13:42:09'),
(5, 8, 7, 'test envoie mess final', 'ceci est un super message de bruuuuut ! ', 1, '2012-04-02 16:00:40'),
(8, 7, 8, 'test envoy?', 'envoie test avec accents ? ? ?  ?', 1, '2012-04-03 10:19:53'),
(9, 7, 10, 'Bonjour Test1', 'Bonjour !\r\n\r\nJe suis intéressé par votre produit !', 1, '2012-04-03 10:33:10'),
(10, 10, 7, 'Bonjour Test1', 'Moi aussi je suis intéressé !\r\n\r\nQuand pourrions nous nous rencontrer afin que je vous donne votre dvd ?', 1, '2012-04-03 10:37:41'),
(11, 66, 8, 'test', 'Tu as recu mon message ?', 1, '2012-04-24 17:48:12'),
(12, 8, 66, 'test', 'oui mais je ne peux pas en rédiger moi même.', 1, '2012-04-24 17:53:44'),
(13, 66, 8, 'test', 'Oui, je sais j''essaye de voir d''où viens le problème ;)', 1, '2012-04-24 17:57:20'),
(14, 64, 8, 'test', 'blablaba', 1, '2012-04-25 04:32:17'),
(15, 65, 8, 'bienvenue', 'Bienvenu sur le site d''enchÃ¨re de Dvd !\r\n\r\nIl s''agit bien de fakes, les enchÃ¨res ne sont pas rÃ©elles...', 0, '2012-04-25 04:54:40'),
(16, 8, 7, 'hihi', 'Regarde ce truc de fou\r\n', 1, '2012-04-25 05:37:47'),
(17, 10, 8, 'Listes des membres', 'VoilÃ  bug rÃ©parÃ© ! C''est juste que dans la requete sql on avait pseudo = ''$recherche'' au lieu de pseudo like ''%recherche%'' ;) ', 1, '2012-04-25 11:07:22'),
(18, 9, 7, 'test', 'test message', 1, '2012-04-26 02:20:51'),
(19, 8, 64, 'test image non lu', 'blabalbal', 1, '2012-04-26 03:31:50'),
(20, 7, 9, 'test', 'salut! ', 1, '2012-04-26 06:52:14'),
(21, 64, 64, 'Bienvenue sur DvdMarket !', 'Felicitations, vous venez de vous inscrire avec succes sur le site DvdMarket.', 1, '2012-04-26 09:20:54'),
(22, 7, 8, 'Test message en gras si nv message', 'hÃ©hÃ©hÃ©, ca marche ?! :)', 1, '2012-04-26 10:40:54'),
(23, 9, 7, 'test', 'Salut a toi aussi loulou ! :)', 1, '2012-04-26 10:45:19'),
(24, 8, 10, 'Listes des membres', 'Beau gosse ! :)', 0, '2012-04-26 11:57:50');

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE IF NOT EXISTS `produits` (
  `id_produit` int(11) NOT NULL AUTO_INCREMENT,
  `id_vendeur` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `genre` int(11) NOT NULL,
  `realisateurs` text NOT NULL,
  `acteurs` text NOT NULL,
  `duree` time NOT NULL,
  `description` blob NOT NULL,
  `support` text NOT NULL,
  `langue` varchar(255) NOT NULL,
  `prix_initial` double NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `cover` varchar(50) DEFAULT '0',
  `note` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_produit`),
  KEY `id_vendeur` (`id_vendeur`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Contenu de la table `produits`
--

INSERT INTO `produits` (`id_produit`, `id_vendeur`, `titre`, `genre`, `realisateurs`, `acteurs`, `duree`, `description`, `support`, `langue`, `prix_initial`, `date_debut`, `date_fin`, `cover`, `note`) VALUES
(2, 7, 'La memoire dans la peau', 1, 'vfvd', 'bbb', '00:00:56', 0x62666762, 'dvd', 'francais', 10, '2012-03-28 00:00:00', '2012-06-20 00:00:00', '2.jpg', 3),
(3, 7, 'Les Schtroumpfs', 1, 'dessin annimé', 'bonne question...', '00:00:00', 0x7164736667686a6b, 'dvd', 'francais', 5, '2012-04-02 00:00:00', '2012-05-20 04:00:00', '0.jpg', 0),
(4, 7, 'La mort dans la peau', 0, 'dsfg', 'dswfgh', '01:00:00', 0x63646a6b, 'dvd', 'francais', 2, '2012-04-01 13:21:39', '2012-06-15 19:00:00', '4.jpg', 4),
(5, 7, 'Le seigneur des anneaux - le retour du roi', 3, 'csdc', '', '00:00:00', '', '', 'anglais', 0, '2012-04-03 09:26:23', '2012-05-10 00:00:00', '5.jpg', 0),
(6, 7, 'Titanic', 4, 'James Cameron', 'wgxdfhcjvkblm', '02:25:00', 0x7a65666773726864746e756a6f6b6d6c66736467662066676466207766662c6a2067647768627867, 'dvd', 'francais', 0, '2012-04-05 17:57:14', '2012-04-25 09:09:00', '0.jpg', 0),
(15, 9, 'Shutter island', 4, 'Martin Scorsese', 'Leonardo Dicaprio', '02:23:00', 0x53757065722066696c6d2071756520706f75706f756e657474652061696d65207265676172646572, 'dvd', 'francais', 8, '2012-04-06 10:21:15', '2012-05-25 09:09:00', '15.jpg', 0),
(16, 9, 'Kill Bill', 1, 'Quentin Tarentino', 'Uma Thurman', '02:10:00', 0x736468666a676b6c6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a6a64646464646464646464646464646464646464646464646464646464646464646464646464646464646464646464646464646464646464646464646464646464646464646464642064206420642c20626320646373, 'dvd', 'francais', 4, '2012-04-06 11:38:41', '2012-05-28 09:09:00', '16.jpg', 0),
(19, 9, 'The Terminator', 1, 'James Cameron', 'Arnold Schwarzenegger  Michael Biehn  Linda Hamilton', '01:56:00', 0x5465726d696e61746f722065737420756e2066696c6d20646520736369656e63652066696374696f6e, 'dvd', 'anglais', 2, '2012-04-06 11:48:04', '2012-05-24 09:09:00', '0.jpg', 0),
(22, 8, 'Cloverfield', 1, 'Roger Ebert', 'John, Slayer', '01:52:00', 0x6667666e20206a686c6b6a686c6b6a6c20343520676a68676b6a66, 'dvd', 'francais', 2, '2012-04-19 12:53:43', '2012-05-30 09:09:00', '20.jpg', 0),
(23, 8, 'Ip man', 1, 'fghj,', 'gfj,h', '01:20:00', 0x74657374206465206c61206465736372697074696f6e20e920e02e2c202d29, 'Blue-Ray', 'francais', 5, '2012-04-19 12:59:58', '2012-05-29 09:09:00', '23.jpg', 0),
(24, 8, 'Le roi lion', 5, 'Disney', 'vfgbdfh', '01:20:00', 0x6667666e20206a686c6b6a686c6b6a6c20343520676a68676b6a66, 'VHS', 'francais', 1, '2012-04-19 13:58:53', '2012-05-01 09:09:00', '24.jpg', 4),
(25, 67, 'Chicago', 17, 'Rob Marshall', 'Thibaut Randaxhe', '00:00:00', 0x4d757264657265737365732056656c6d61204b656c6c79, 'Dvd', 'anglais', 4, '2012-04-25 13:01:00', '2012-05-15 09:09:00', '25.jpg', 0),
(26, 64, 'Prince of persia : les sables du temps', 1, 'Mike Newell', 'Jake Gyllenhaal, Gemma Arterton, Ben Kingsley', '02:01:00', 0x556e207072696e636520726562656c6c652065737420636f6e747261696e74206420756e69722073657320666f72636573206176656320756e65206d797374c3a9726965757365207072696e636573736520706f757220616666726f6e74657220656e73656d626c65206c657320666f72636573206475206d616c2065742070726f74c3a967657220756e6520646167756520616e74697175652063617061626c65206465206c6962c3a9726572206c6573205361626c65732064752074656d70732c20756e20646f6e20646520646965752e, 'Dvd', 'francais', 3, '2012-04-25 14:37:55', '2012-05-25 09:09:00', '26.jpg', 0),
(31, 9, 'Les petits mouchoirs', 5, 'Guillaume Canet', 'Marion Cottillard', '02:34:00', 0x626c69626c61626c61, 'Dvd', 'francais', 1, '2012-04-26 07:01:50', '2012-05-04 13:13:19', '0.jpg', 0),
(32, 64, 'Les dents de la mer', 2, 'Steven Spielberg ', 'Roy Scheider, Robert Shaw, Richard Dreyfuss', '02:01:00', 0x41207175656c71756573206a6f7572732064752064c3a9627574206465206c6120736169736f6e206573746976616c652c206c6573206861626974616e7473206465206c61207065746974652073746174696f6e2062616c6ec3a961697265206427416d69747920736f6e74206d697320656e20c3a96d6f6920706172206c612064c3a9636f75766572746520737572206c65206c6974746f72616c20647520636f727073206174726f63656d656e74206d7574696cc3a9206427756e65206a65756e6520766163616e6369c3a872652e20506f7572204d617274696e2042726f64792c206c652063686566206465206c6120706f6c6963652c20696c206e65206661697420617563756e20646f75746520717565206c61206a65756e652066696c6c65206120c3a974c3a92076696374696d65206427756e2072657175696e2e20496c2064c3a96369646520616c6f7273206427696e74657264697265206c27616363c3a8732064657320706c61676573206d6169732073652068657572746520c3a0206c27686f7374696c6974c3a9206475206d6169726520756e697175656d656e7420696e74c3a972657373c3a920706172206c276166666c75782064657320746f757269737465732e2050656e64616e742063652074656d70732c206c652072657175696e20636f6e74696e756520c3a02073656d6572206c612074657272657572206c65206c6f6e67206465732063c3b474657320657420c3a02064c3a9766f726572206c657320626169676e657572732e2e2e20, 'Dvd', 'francais', 2, '2012-04-26 10:13:03', '2012-05-11 14:13:03', '32.jpg', 0),
(33, 10, 'Peter Pan', 23, 'Disney', 'vide', '01:10:00', 0x50657465722070616e2c206c65206772616e6420, 'Dvd', 'francais', 3, '2012-04-26 10:24:17', '2012-05-01 11:24:17', '33.jpg', 0),
(35, 10, 'Zombie Land', 2, 'Brad', 'Woody Harrelson, Jesse Eisenberg, Emma stone, Abigail Breslin', '01:45:00', 0x5375697465206120756e65206d75746174696f6e206475207669727573206465206c6120766163686520666f6c6c652c206c65732068756d61696e7320736f6e74207472616e73666f726d657320656e207a6f6d626965732e20436f6c6f6d62757320284a6573736520456973656e62657267292065742054616c6c616861737365652028576f6f64792048617272656c736f6e292c206465757820737572766976616e74732071756520746f7574206f70706f73652c2073696c6c6f6e6e656e74206c657320726f7574657320657420616666726f6e74656e74206c6573207a6f6d62696573207175692067726f75696c6c656e74206175782071756174726520636f696e7320647520706179732e20417520636f757273206465206c6575722070657269706c652c20696c7320666f6e74206c6120636f6e6e61697373616e63652064652064657578206a65756e65732066656d6d65732c20576963686974612028456d6d612053746f6e6529206574204c6974746c6520526f636b20284162696761696c20427265736c696e292c20717569206f6e74206465636964652064652072656a6f696e64726520756e207061726320642761747472616374696f6e7320737572206c6120636f7465206f75657374206465732065746174732d556e69732e, 'Dvd', 'francais', 5, '2012-04-26 11:36:06', '2012-05-14 15:36:06', '34.jpg', 0),
(36, 10, 'Tintin et le secret de la licorne', 7, 'Steven Spielsberg', 'Edgard Wright, Joe Cornish', '01:35:00', 0x54696e74696e2c20756e206a65756e65207265706f72746572206163636f6d7061676ec3a920646520736f6e20636869656e20626c616e63204d696c6f752c20616368c3a8746520756e65206d61717565747465206465204c61204c69636f726e6520c3a020626f6e206d61726368c3a92064616e7320756e652062726f63616e746520656e2042656c67697175652e20496c2065737420696d6dc3a964696174656d656e74206163636f7374c3a920706172204261726e6162c3a9206574204976616e204976616e6f76697463682053616b686172696e65207175692074656e74656e74206465207261636865746572206c65206d6f64c3a86c652072c3a9647569742c206d6169732073616e732073756363c3a8732e2e2e2e, 'Blue-Ray', 'francais', 5, '2012-04-28 12:13:25', '2012-05-06 16:13:25', '36.jpg', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_inscription` text NOT NULL,
  `etat` int(1) NOT NULL,
  `activation` int(7) NOT NULL,
  `photo` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `pseudo`, `mdp`, `email`, `date_inscription`, `etat`, `activation`, `photo`) VALUES
(7, 'test1 Nom', 'test1 Prenom', 'test1', 'b444ac06613fc8d63795be9ad0beaf55011936ac', 'jvdurieu@live.be', '27:03:2012', 1, 8133170, 1),
(8, 'test2 prÃ©nom', 'test2 nom', 'test2', '109f4b3c50d7b0df729d299bc6f8e9ef9066971f', 'dady_012@hotmail.com', '27:03:2012', 2, 9328313, 4),
(9, 'Renault', 'Claire', 'clairounette', 'ef3ecccf258fa062c5c6521a4887d40541963af7', 'cl.renault@gmail.com', '1:04:2012', 1, 3570526, 2),
(10, 'Durieu', 'Jean-Vital', 'jvdudux', 'b95371d17679886e866abba4ad4f11b44df18f2e', 'jvdurieu@gmail.com', '3:04:2012', 1, 7570373, 1),
(65, 'van migem', 'simon', 'simon', '4452efbf167d4aa55e6be843315d5f06aa609193', 'simon.vanmigem@gmail.com', '24:04:2012', 1, 4297052, 1),
(12, 'Streel', 'Xavier', 'MaitreNorris', '572982bbc4f29ee92ae2d65a9edc2453d2c9170c', 'contact@xavierstreel.com', '24:04:2012', 1, 8915250, 1),
(64, 'Mad', 'Gaet', 'madgaet', '86de497f08331f0ac5ce442eca473a3ae05dc30c', 'madgaet@gmail.com', '24:04:2012', 1, 6724197, 1),
(66, 'Ghilain', 'Arnaud', 'magoa', '1a340065606634b575ed162e9c434c27fe24a7c3', 'gladiatorag@hotmail.com', '24:04:2012', 1, 9494406, 1),
(67, 'Randaxhe', 'Thibaut', 'RandaTh', '2b1c8883b2230f9d6a43980e13f1e323634ec5b6', 'randath@gmail.com', '25:04:2012', 1, 4239432, 1),
(69, 'Rappe', 'Alexandre', 'Alex-sex', '9453fba5767f503250e950c3916f6d4bb1e1c5cc', 'alexix-02@live.be', '26:04:2012', 0, 2135299, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
