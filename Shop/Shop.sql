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

-- Dumping data for table shop.categorie: ~2 rows (approximately)
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` (`ID_CATEGORIE`, `C_NOM`) VALUES
	(1, 'Fruits'),
	(2, 'LÃ©gumes');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;

-- Dumping data for table shop.client: ~1 rows (approximately)
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
INSERT INTO `client` (`ID_CLIENT`, `NOM`, `PRENOM`, `EMAIL`, `PASSWORD`, `ROLE`) VALUES
	(1, 'Doe', 'John', 'john@doe.com', '$2y$10$A.rIthsQRE4U.cgnrHbYteM/NTayl9H7FUxm4q6zLQmlVHgCdVPo6', 'admin'),
	(2, 'Jane', 'Doe', 'jane@doe.com', '$2y$10$g68k1ShGh6Gy70GhwGBNsOiKVwJhl48SRhtA94CBR6shbxt4c8UOG', 'user');
/*!40000 ALTER TABLE `client` ENABLE KEYS */;

-- Dumping data for table shop.commande: ~2 rows (approximately)
/*!40000 ALTER TABLE `commande` DISABLE KEYS */;
INSERT INTO `commande` (`ID_COMMANDE`, `ID_CLIENT`, `CC_NUM`, `CC_EXP`, `CC_CVV`, `PRIX_TOTALE`) VALUES
	(8, 1, '4242424242424242', '12/24', '123', 40),
	(9, 1, '4242424242424242', '12/24', '123', 40);
/*!40000 ALTER TABLE `commande` ENABLE KEYS */;

-- Dumping data for table shop.commande_pf: ~0 rows (approximately)
/*!40000 ALTER TABLE `commande_pf` DISABLE KEYS */;
/*!40000 ALTER TABLE `commande_pf` ENABLE KEYS */;

-- Dumping data for table shop.commande_produit: ~2 rows (approximately)
/*!40000 ALTER TABLE `commande_produit` DISABLE KEYS */;
INSERT INTO `commande_produit` (`ID_PRODUIT`, `ID_COMMANDE`, `PRIX_PRODUIT`, `QUANTITE_PRODUIT`) VALUES
	(2, 8, 4, 10),
	(2, 9, 4, 10);
/*!40000 ALTER TABLE `commande_produit` ENABLE KEYS */;

-- Dumping data for table shop.panierfix: ~0 rows (approximately)
/*!40000 ALTER TABLE `panierfix` DISABLE KEYS */;
/*!40000 ALTER TABLE `panierfix` ENABLE KEYS */;

-- Dumping data for table shop.produit: ~4 rows (approximately)
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
INSERT INTO `produit` (`ID_PRODUIT`, `ID_CATEGORIE`, `PRIX`, `IMAGE`, `P_NOM`, `QUANTITE`) VALUES
	(2, 2, 4.00, _binary 0x70726F647563742D352E6A7067, 'Tomate', 40),
	(5, 1, 15.00, _binary 0x70726F647563742D31302E6A7067, 'Pomme', 5),
	(6, 2, 7.00, _binary 0x70726F647563742D392E6A7067, 'Onion', 10);
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;

-- Dumping data for table shop.produit_pf: ~0 rows (approximately)
/*!40000 ALTER TABLE `produit_pf` DISABLE KEYS */;
/*!40000 ALTER TABLE `produit_pf` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
