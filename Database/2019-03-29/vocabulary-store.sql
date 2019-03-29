-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 29, 2019 at 03:34 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vocabulary-store`
--

-- --------------------------------------------------------

--
-- Table structure for table `architectures_supported`
--

DROP TABLE IF EXISTS `architectures_supported`;
CREATE TABLE IF NOT EXISTS `architectures_supported` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `architecture_name` varchar(32) NOT NULL,
  `description` varchar(256) NOT NULL,
  `modules` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `architectures_supported`
--

INSERT INTO `architectures_supported` (`id`, `architecture_name`, `description`, `modules`) VALUES
(1, 'LTE', 'This is an LTE network', '[{\'name\':\'UE\',\'description\':\'User Equipment\'},{\'name\':\'gNB\',\'description\':\'5G Node B\'},{\'name\':\'AMF\',\'description\':\'Access and Mobility management Function\'},{\'name\':\'NSSF\',\'description\':\'Network Slice Selection Function\'},{\'name\':\'SMF\',\'description\':\'Session Management Fucntion\'},{\'name\':\'UDM\',\'description\':\'Unified Data Management\'},{\'name\':\'UDR\',\'description\':\'Unified Data Repository\'},{\'name\':\'NRF\',\'description\':\'Network Repository Function\'},{\'name\':\'UPF\',\'description\':\'User Plane Function\'},{\'name\':\'vSPGWC\',\'description\':\'virtual Software Protocol Gateway User-Plane\'}]'),
(2, '5G', 'This is a 5G network', '[{\'name\':\'UE\',\'description\':\'User Equipment\'},{\'name\':\'gNB\',\'description\':\'5G Node B\'},{\'name\':\'AMF\',\'description\':\'Access and Mobility management Function\'},{\'name\':\'NSSF\',\'description\':\'Network Slice Selection Function\'},{\'name\':\'SMF\',\'description\':\'Session Management Fucntion\'},{\'name\':\'UDM\',\'description\':\'Unified Data Management\'},{\'name\':\'UDR\',\'description\':\'Unified Data Repository\'},{\'name\':\'NRF\',\'description\':\'Network Repository Function\'},{\'name\':\'UPF\',\'description\':\'User Plane Function\'},{\'name\':\'vSPGWC\',\'description\':\'virtual Software Protocol Gateway User-Plane\'}]'),
(3, 'LTE Advanced', 'This is an LTE Advanced network', '[{\'name\':\'UE\',\'description\':\'User Equipment\'},{\'name\':\'gNB\',\'description\':\'5G Node B\'},{\'name\':\'AMF\',\'description\':\'Access and Mobility management Function\'},{\'name\':\'NSSF\',\'description\':\'Network Slice Selection Function\'},{\'name\':\'SMF\',\'description\':\'Session Management Fucntion\'},{\'name\':\'UDM\',\'description\':\'Unified Data Management\'},{\'name\':\'UDR\',\'description\':\'Unified Data Repository\'},{\'name\':\'NRF\',\'description\':\'Network Repository Function\'},{\'name\':\'UPF\',\'description\':\'User Plane Function\'},{\'name\':\'vSPGWC\',\'description\':\'virtual Software Protocol Gateway User-Plane\'}]');

-- --------------------------------------------------------

--
-- Table structure for table `modules_architecture`
--

DROP TABLE IF EXISTS `modules_architecture`;
CREATE TABLE IF NOT EXISTS `modules_architecture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `arch_id` int(11) NOT NULL,
  `node_name` varchar(32) NOT NULL,
  `sequence_number` int(11) NOT NULL,
  `is_end_node` tinyint(1) NOT NULL DEFAULT '1',
  `relational_nodes` varchar(512) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_arch_id_to_id` (`arch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules_architecture`
--

INSERT INTO `modules_architecture` (`id`, `arch_id`, `node_name`, `sequence_number`, `is_end_node`, `relational_nodes`) VALUES
(2, 1, 'eNB', 2, 1, '1,3,7'),
(3, 1, 'vMME', 3, 1, '2,4,5,6,7'),
(4, 1, 'NSSF', 4, 1, '3'),
(5, 1, 'vHSS', 5, 1, '3'),
(6, 1, 'vSPGWC', 6, 1, '3,7'),
(7, 1, 'vSPGWU', 7, 1, '2,3,6');

-- --------------------------------------------------------

--
-- Table structure for table `modules_relations`
--

DROP TABLE IF EXISTS `modules_relations`;
CREATE TABLE IF NOT EXISTS `modules_relations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_id` int(11) NOT NULL,
  `node_name` varchar(32) NOT NULL,
  `relation_id` int(11) NOT NULL,
  `link_specs` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_mod_id_to_id` (`mod_id`),
  KEY `FK_relation_id_to_id` (`relation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules_relations`
--

INSERT INTO `modules_relations` (`id`, `mod_id`, `node_name`, `relation_id`, `link_specs`) VALUES
(3, 2, 'eNB', 3, 1),
(4, 2, 'eNB', 7, 1),
(5, 3, 'vMME', 2, 1),
(6, 3, 'vMME', 4, 1),
(7, 3, 'vMME', 5, 1),
(8, 3, 'vMME', 6, 1),
(10, 4, 'NSSF', 3, 1),
(11, 5, 'vHSS', 3, 1),
(12, 6, 'vSPGWC', 3, 1),
(13, 6, 'vSPGWC', 7, 1),
(14, 7, 'vSPGWU', 2, 1),
(16, 7, 'vSPGWU', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules_versions`
--

DROP TABLE IF EXISTS `modules_versions`;
CREATE TABLE IF NOT EXISTS `modules_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_id` int(11) NOT NULL,
  `mod_version` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ` (`mod_id`,`mod_version`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules_versions`
--

INSERT INTO `modules_versions` (`id`, `mod_id`, `mod_version`) VALUES
(1, 2, 1),
(9, 2, 2),
(5, 3, 1),
(2, 4, 1),
(4, 5, 1),
(6, 6, 1),
(7, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `snssais_supported`
--

DROP TABLE IF EXISTS `snssais_supported`;
CREATE TABLE IF NOT EXISTS `snssais_supported` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `snssai` enum('1','2','3','4','5','6','7','8') NOT NULL,
  `uprate` int(11) NOT NULL,
  `downrate` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UN_snssai_name` (`name`),
  UNIQUE KEY `UN_snssai` (`snssai`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `snssais_supported`
--

INSERT INTO `snssais_supported` (`id`, `name`, `snssai`, `uprate`, `downrate`) VALUES
(1, 'slice_no_1', '1', 10, 20),
(2, 'slice_no_2', '2', 15, 30),
(3, 'slice_no_3', '3', 20, 40),
(4, 'slice_no_4', '4', 25, 50);

-- --------------------------------------------------------

--
-- Table structure for table `xontracts`
--

DROP TABLE IF EXISTS `xontracts`;
CREATE TABLE IF NOT EXISTS `xontracts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `arch_id` int(11) NOT NULL,
  `s_nssai` tinyint(4) NOT NULL DEFAULT '1',
  `uprate` int(11) NOT NULL,
  `downrate` int(11) NOT NULL,
  `unit` enum('MB','KB') NOT NULL DEFAULT 'MB',
  `is_synced` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UN_name` (`name`),
  KEY `FK_arch_id_to_id_2` (`arch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `xontracts`
--

INSERT INTO `xontracts` (`id`, `name`, `arch_id`, `s_nssai`, `uprate`, `downrate`, `unit`, `is_synced`) VALUES
(68, 'ASIF-1', 1, 1, 10, 20, 'MB', '0'),
(69, 'ASIF-2', 1, 4, 25, 50, 'MB', '0'),
(70, 'JAVI-1', 1, 3, 20, 40, 'MB', '0'),
(71, 'TALHA-SI-1', 1, 4, 25, 50, 'MB', '0');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `modules_architecture`
--
ALTER TABLE `modules_architecture`
  ADD CONSTRAINT `FK_arch_id_to_id` FOREIGN KEY (`arch_id`) REFERENCES `architectures_supported` (`id`);

--
-- Constraints for table `modules_relations`
--
ALTER TABLE `modules_relations`
  ADD CONSTRAINT `FK_mod_id_to_id` FOREIGN KEY (`mod_id`) REFERENCES `modules_architecture` (`id`),
  ADD CONSTRAINT `FK_relation_id_to_id` FOREIGN KEY (`relation_id`) REFERENCES `modules_architecture` (`id`);

--
-- Constraints for table `modules_versions`
--
ALTER TABLE `modules_versions`
  ADD CONSTRAINT `FK_mod_id_to_id_2` FOREIGN KEY (`mod_id`) REFERENCES `modules_architecture` (`id`);

--
-- Constraints for table `xontracts`
--
ALTER TABLE `xontracts`
  ADD CONSTRAINT `FK_arch_id_to_id_2` FOREIGN KEY (`arch_id`) REFERENCES `architectures_supported` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
