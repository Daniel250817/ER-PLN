-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ER_PLN
-- ------------------------------------------------------
-- Server version	8.4.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Atributos`
--

DROP TABLE IF EXISTS `Atributos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Atributos` (
  `IdAtributos` int NOT NULL AUTO_INCREMENT,
  `Atributos` varchar(100) DEFAULT NULL,
  `IdEntidades` int DEFAULT NULL,
  PRIMARY KEY (`IdAtributos`),
  KEY `fk_entidades_atributos` (`IdEntidades`),
  CONSTRAINT `fk_entidades_atributos` FOREIGN KEY (`IdEntidades`) REFERENCES `Entidades` (`IdEntidades`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Atributos`
--

LOCK TABLES `Atributos` WRITE;
/*!40000 ALTER TABLE `Atributos` DISABLE KEYS */;
INSERT INTO `Atributos` VALUES (1,'Alumno',1);
/*!40000 ALTER TABLE `Atributos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Diagramas`
--

DROP TABLE IF EXISTS `Diagramas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Diagramas` (
  `IdDiagrama` int NOT NULL AUTO_INCREMENT,
  `NombreDiagrama` varchar(100) DEFAULT NULL,
  `FechaCreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `IdUsuario` int DEFAULT NULL,
  `IdEntidades` int DEFAULT NULL,
  PRIMARY KEY (`IdDiagrama`),
  KEY `FK_Entidades_Diagramas` (`IdUsuario`),
  CONSTRAINT `Diagramas_ibfk_1` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuarios` (`IdUsuario`),
  CONSTRAINT `FK_Entidades_Diagramas` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuarios` (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Diagramas`
--

LOCK TABLES `Diagramas` WRITE;
/*!40000 ALTER TABLE `Diagramas` DISABLE KEYS */;
INSERT INTO `Diagramas` VALUES (1,'Prueba 1','2024-08-20 01:00:42',1,1);
/*!40000 ALTER TABLE `Diagramas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Entidades`
--

DROP TABLE IF EXISTS `Entidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Entidades` (
  `IdEntidades` int NOT NULL AUTO_INCREMENT,
  `Entidades` varchar(100) DEFAULT NULL,
  `IdUsuario` int DEFAULT NULL,
  PRIMARY KEY (`IdEntidades`),
  KEY `FK_Entidades_Usuarios` (`IdUsuario`),
  CONSTRAINT `FK_Entidades_Usuarios` FOREIGN KEY (`IdUsuario`) REFERENCES `Usuarios` (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Entidades`
--

LOCK TABLES `Entidades` WRITE;
/*!40000 ALTER TABLE `Entidades` DISABLE KEYS */;
INSERT INTO `Entidades` VALUES (1,'Entidad 1',1),(3,'Entidad 2',3),(4,'Entidad 3',2),(5,'Entidad 4',NULL),(6,'Entidad 5',NULL),(7,'Wilson',1),(8,'Wilson',1);
/*!40000 ALTER TABLE `Entidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuarios`
--

DROP TABLE IF EXISTS `Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Usuarios` (
  `IdUsuario` int NOT NULL AUTO_INCREMENT,
  `NombreUsuario` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Contra` varchar(255) NOT NULL,
  `FechaRegistro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`IdUsuario`),
  UNIQUE KEY `NombreUsuario` (`NombreUsuario`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuarios`
--

LOCK TABLES `Usuarios` WRITE;
/*!40000 ALTER TABLE `Usuarios` DISABLE KEYS */;
INSERT INTO `Usuarios` VALUES (1,'Julio','juliomix089@gmail.com','$2y$10$tinDibI2MkzBP9QSKzyR3O5i8eefl4SdmlkgevdQW4SPgSsATVvGW','2024-08-14 09:19:26'),(2,'Wilson','Wilson@gmail.com','$2y$10$gr2xb8pQt11j4ghTOtU3oOTOfduoOM0/DRhiovKnUeJtCQYt5rf/e','2024-08-14 09:42:28'),(3,'Alejandro','Alejandro@gmail.com','$2y$10$Rvn7L8sHfef3IGdZPTSXBu.s9AgeKE/9/NoPndkWfluV6WH7VyIi.','2024-08-14 10:25:15'),(4,'Arbaiza','Arbaiza@gmail.com','$2y$10$nVoxB86aT.sTZX3.Gfd28ujGy3hnTRX9ThyWp5Zlod4MRNPF0k4Fy','2024-08-14 23:23:30'),(12,'Julioss','juliomix9@gmail.com','$2y$10$gxudK/AHxFTU.dOArMUobeX7mBgx4Wkt.ncezfdRFuFRyXCKCPs2a','2024-08-15 00:02:26'),(15,'Julios','juliomix09@gmail.com','$2y$10$LxzlNepmmNFlrg1lAFaX7.NkzbzwzJ8S96isDgm/V5/CnZ8fuaw/a','2024-08-15 00:11:34'),(16,'Wilalex','wilalex@gmail.com','$2y$10$BR2w3q3KxOOuSjynE1g.QuttFWeYZ4o9fPlX4JOrIYgNcG8GScOiS','2024-08-15 03:33:03');
/*!40000 ALTER TABLE `Usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-19 23:47:28
