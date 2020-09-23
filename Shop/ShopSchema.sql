-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for shop
CREATE DATABASE IF NOT EXISTS `shop` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `shop`;

-- Dumping structure for table shop.categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `ID_CATEGORIE` int(11) NOT NULL AUTO_INCREMENT,
  `C_NOM` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_CATEGORIE`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table shop.client
CREATE TABLE IF NOT EXISTS `client` (
  `ID_CLIENT` int(11) NOT NULL AUTO_INCREMENT,
  `NOM` varchar(255) NOT NULL,
  `PRENOM` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `ROLE` varchar(255) NOT NULL,
  PRIMARY KEY (`ID_CLIENT`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table shop.commande
CREATE TABLE IF NOT EXISTS `commande` (
  `ID_COMMANDE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CLIENT` int(11) NOT NULL,
  `CC_NUM` varchar(16) NOT NULL,
  `CC_EXP` varchar(5) NOT NULL,
  `CC_CVV` varchar(3) NOT NULL,
  `PRIX_TOTALE` float NOT NULL,
  PRIMARY KEY (`ID_COMMANDE`),
  KEY `FK_COMMANDER` (`ID_CLIENT`),
  CONSTRAINT `FK_COMMANDER` FOREIGN KEY (`ID_CLIENT`) REFERENCES `client` (`ID_CLIENT`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table shop.commande_pf
CREATE TABLE IF NOT EXISTS `commande_pf` (
  `ID_PANIER` int(11) NOT NULL,
  `ID_COMMANDE` int(11) NOT NULL,
  PRIMARY KEY (`ID_PANIER`,`ID_COMMANDE`),
  KEY `FK_CONTENIR` (`ID_COMMANDE`),
  CONSTRAINT `FK_CONTENIR` FOREIGN KEY (`ID_COMMANDE`) REFERENCES `commande` (`ID_COMMANDE`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_CONTENIR2` FOREIGN KEY (`ID_PANIER`) REFERENCES `panierfix` (`ID_PANIER`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table shop.commande_produit
CREATE TABLE IF NOT EXISTS `commande_produit` (
  `ID_PRODUIT` int(11) NOT NULL,
  `ID_COMMANDE` int(11) NOT NULL,
  `PRIX_PRODUIT` float NOT NULL,
  `QUANTITE_PRODUIT` float NOT NULL,
  PRIMARY KEY (`ID_PRODUIT`,`ID_COMMANDE`),
  KEY `FK_COMMANDE_PRODUIT` (`ID_COMMANDE`),
  CONSTRAINT `FK_COMMANDE_PRODUIT` FOREIGN KEY (`ID_COMMANDE`) REFERENCES `commande` (`ID_COMMANDE`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_COMMANDE_PRODUIT2` FOREIGN KEY (`ID_PRODUIT`) REFERENCES `produit` (`ID_PRODUIT`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table shop.panierfix
CREATE TABLE IF NOT EXISTS `panierfix` (
  `ID_PANIER` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`ID_PANIER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table shop.produit
CREATE TABLE IF NOT EXISTS `produit` (
  `ID_PRODUIT` int(11) NOT NULL AUTO_INCREMENT,
  `ID_CATEGORIE` int(11) NOT NULL,
  `PRIX` float(8,2) NOT NULL,
  `IMAGE` longblob NOT NULL,
  `P_NOM` longtext NOT NULL,
  `QUANTITE` float NOT NULL,
  PRIMARY KEY (`ID_PRODUIT`),
  KEY `FK_CONTIENT` (`ID_CATEGORIE`),
  CONSTRAINT `FK_CONTIENT` FOREIGN KEY (`ID_CATEGORIE`) REFERENCES `categorie` (`ID_CATEGORIE`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

-- Dumping structure for table shop.produit_pf
CREATE TABLE IF NOT EXISTS `produit_pf` (
  `ID_PRODUIT` int(11) NOT NULL,
  `ID_PANIER` int(11) NOT NULL,
  PRIMARY KEY (`ID_PRODUIT`,`ID_PANIER`),
  KEY `FK_PRODUIT_PF` (`ID_PANIER`),
  CONSTRAINT `FK_PRODUIT_PF` FOREIGN KEY (`ID_PANIER`) REFERENCES `panierfix` (`ID_PANIER`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_PRODUIT_PF2` FOREIGN KEY (`ID_PRODUIT`) REFERENCES `produit` (`ID_PRODUIT`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
