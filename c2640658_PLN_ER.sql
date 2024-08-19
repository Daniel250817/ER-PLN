-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 14, 2024 at 02:30 AM
-- Server version: 8.0.35
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c2640658_PLN_ER`
--

-- --------------------------------------------------------

--
-- Table structure for table `Atributos`
--

CREATE TABLE `Atributos` (
  `IdAtributos` int NOT NULL,
  `Atributos` varchar(100) DEFAULT NULL,
  `IdEntidades` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `Entidades`
--

CREATE TABLE `Entidades` (
  `IdEntidades` int NOT NULL,
  `Entidadades` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `Entidades`
--

INSERT INTO `Entidades` (`IdEntidades`, `Entidadades`) VALUES
(1, 'Entidad 1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Atributos`
--
ALTER TABLE `Atributos`
  ADD PRIMARY KEY (`IdAtributos`),
  ADD KEY `fk_entidades_atributos` (`IdEntidades`);

--
-- Indexes for table `Entidades`
--
ALTER TABLE `Entidades`
  ADD PRIMARY KEY (`IdEntidades`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Atributos`
--
ALTER TABLE `Atributos`
  MODIFY `IdAtributos` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Entidades`
--
ALTER TABLE `Entidades`
  MODIFY `IdEntidades` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Atributos`
--
ALTER TABLE `Atributos`
  ADD CONSTRAINT `fk_entidades_atributos` FOREIGN KEY (`IdEntidades`) REFERENCES `Entidades` (`IdEntidades`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
