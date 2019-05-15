-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 09-05-2019 a las 18:43:58
-- Versión del servidor: 5.7.21
-- Versión de PHP: 7.0.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `riverogcdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bank`
--

DROP TABLE IF EXISTS `bank`;
CREATE TABLE IF NOT EXISTS `bank` (
  `bankId` int(6) NOT NULL AUTO_INCREMENT,
  `countryId` int(6) NOT NULL,
  `bankName` varchar(65) NOT NULL,
  `bankAccount` varchar(24) NOT NULL,
  `initialBalance` decimal(13,2) NOT NULL DEFAULT '0.00',
  `balance01` decimal(13,2) NOT NULL DEFAULT '0.00',
  `balance02` decimal(13,2) NOT NULL DEFAULT '0.00',
  `balance03` decimal(13,2) NOT NULL DEFAULT '0.00',
  `balance04` decimal(13,2) NOT NULL DEFAULT '0.00',
  `balance05` decimal(13,2) NOT NULL DEFAULT '0.00',
  `balance06` decimal(13,2) NOT NULL DEFAULT '0.00',
  `balance07` decimal(13,2) NOT NULL DEFAULT '0.00',
  `balance08` decimal(13,2) NOT NULL DEFAULT '0.00',
  `balance09` decimal(13,2) NOT NULL DEFAULT '0.00',
  `balance10` decimal(13,2) NOT NULL DEFAULT '0.00',
  `balance11` decimal(13,2) NOT NULL DEFAULT '0.00',
  `balance12` decimal(13,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`bankId`),
  KEY `bank_ibfk_1` (`countryId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bank`
--

INSERT INTO `bank` (`bankId`, `countryId`, `bankName`, `bankAccount`, `initialBalance`, `balance01`, `balance02`, `balance03`, `balance04`, `balance05`, `balance06`, `balance07`, `balance08`, `balance09`, `balance10`, `balance11`, `balance12`) VALUES
(2, 1, 'BANESCO', '01050234021234566732', '11000.00', '0.00', '17500.00', '32943.00', '1000.00', '5000.00', '0.00', '0.00', '5500.00', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `clientId` int(11) NOT NULL AUTO_INCREMENT,
  `countryId` int(6) NOT NULL,
  `userId` int(11) DEFAULT NULL,
  `clientCode` varchar(8) DEFAULT NULL,
  `clientName` varchar(255) NOT NULL,
  `clientAddress` varchar(255) DEFAULT NULL,
  `clientPhone` varchar(255) DEFAULT NULL,
  `clientEmail` varchar(255) DEFAULT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL,
  PRIMARY KEY (`clientId`),
  KEY `client_ibfk_1` (`countryId`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `client`
--

INSERT INTO `client` (`clientId`, `countryId`, `userId`, `clientCode`, `clientName`, `clientAddress`, `clientPhone`, `clientEmail`, `dateCreated`, `lastUserId`) VALUES
(1, 1, NULL, 'CU-1001', 'JUAN ROJAS', NULL, '214 625 2244', NULL, '2019-04-24 00:00:00', 1),
(2, 1, NULL, 'CU-1002', 'LETICIA CARRILLO\r\n', '3549 MANANA DR DALLAS TX 75220\r\n', '214 586 9285\r\n', NULL, '2019-04-24 00:00:00', 1),
(3, 1, NULL, 'CU-1003', 'NEFI CORNELIO\r\n', NULL, '469 328 8549\r\n', 'corneliohomes@gmail.com\r\n', '2019-04-24 00:00:00', 1),
(4, 1, NULL, 'CU-1004', 'JOSE RAMIREZ\r\n', '526 ELLA AVE DALLAS TX 75217\r\n', '682 251 5633\r\n', NULL, '2019-04-24 00:00:00', 1),
(5, 1, NULL, 'CU-1005', 'ERIKA\r\n', NULL, '214 257 3537\r\n', NULL, '2019-04-24 00:00:00', 1),
(6, 1, NULL, 'CU-1006', 'SHEIMI GRUBBS', NULL, '972 955 5033\r\n', 's.grubbs@grubbsconstructioncleaningllc.com', '2019-04-24 00:00:00', 1),
(7, 1, NULL, 'CU-1007', 'DANI HERNANDEZ\r\n', NULL, '214 543 5553\r\n', 'Dannyneo55@yahoo.com\r\n', '2019-04-24 00:00:00', 1),
(8, 1, NULL, 'CU-1008', 'FIDEL', NULL, '469 682 97 63\r\n', NULL, '2019-04-24 00:00:00', 1),
(9, 1, NULL, 'CU-1009', 'AJW CUSTOM H\r\n', NULL, NULL, NULL, '2019-04-24 00:00:00', 1),
(10, 1, NULL, 'CU-1010', 'HOMEBUND CONSTRUCTION SERVICES LLC\r\n', NULL, '214 566 7939\r\n', NULL, '2019-04-24 00:00:00', 1),
(11, 1, NULL, 'CU-1011', 'ALEJANDRA ANZIO DR \r\n', NULL, '214 912 8574\r\n', NULL, '2019-04-24 00:00:00', 1),
(12, 1, NULL, 'CU-1012', 'JOSE LUIS', NULL, '214 436 1817\r\n', NULL, '2019-04-24 00:00:00', 1),
(13, 1, NULL, 'CU-1013', 'FERNANDO', NULL, '972 815 3425\r\n', 'amayawelding12@yahoo.com\r\n', '2019-04-24 00:00:00', 1),
(14, 1, NULL, 'CU-1014', 'RICHARD	DARDEN\r\n', NULL, '469 360 5766\r\n', 'fr2rinvestor@gmail.com\r\n', '2019-04-24 00:00:00', 1),
(15, 1, NULL, 'CU-1015', 'MARK GARZA\r\n', NULL, '817 320 9347\r\n', 'markgarzaconstruction@gmail.com\r\n', '2019-04-24 00:00:00', 1),
(16, 1, NULL, 'CU-1016', 'ABEL', NULL, '469 650 5593\r\n', NULL, '2019-04-24 00:00:00', 1),
(17, 1, NULL, 'CU-1017', 'LUIS CABRERA\r\n', NULL, '469 288 2703\r\n', NULL, '2019-04-24 00:00:00', 1),
(18, 1, NULL, 'CU-1018', 'BROWN', NULL, '214 212 4395', NULL, '2019-04-24 00:00:00', 1),
(19, 1, NULL, 'CU-1019', 'ALEX', NULL, '817 797 2660\r\n', NULL, '2019-04-24 00:00:00', 1),
(20, 1, NULL, 'CU-1020', 'STEVE', NULL, '469 867 2629\r\n', NULL, '2019-04-24 00:00:00', 1),
(21, 1, NULL, 'CU-1021', 'MICHAEL MEMAR\r\n', NULL, '469 888 9016 \r\n', 'memarinteriors@gmail.com\r\n', '2019-04-24 00:00:00', 1),
(22, 1, NULL, 'CU-1022', 'HECTOR HERRERA\r\n', NULL, '214 515 8966', NULL, '2019-04-24 00:00:00', 1),
(23, 1, NULL, 'CU-1023', 'ALEJANDRO ARAUJO\r\n', NULL, '214 994 4378\r\n', 'alexaraujoroofing@yahoo.com\r\n', '2019-04-24 00:00:00', 1),
(24, 1, NULL, 'CU-1024', 'JUAN RAMOS\r\n', NULL, '323 717 3719\r\n', 'juan2340@gmail.com\r\n', '2019-04-24 00:00:00', 1),
(25, 1, NULL, 'CU-1025', 'TOMAS RAMIREZ\r\n', '1508 FLEETWOOD ST DALLAS TX 75223', '214 923 2699\r\n', NULL, '2019-04-24 00:00:00', 1),
(26, 1, NULL, 'CU-1026', 'PITER MCMILLAN', '111 COLLETT SUBLETT RD.KENNEDALE TX 76060', '817 513 2720', 'peter.e.mcmillan@gmail.com', '2019-04-24 00:00:00', 1),
(27, 1, NULL, 'CU-1027', 'VICTOR RODRIGUEZ', NULL, '214 598 9013\r\n', 'rodriguezconstruction1234@gmail.com', '2019-04-24 00:00:00', 1),
(28, 1, NULL, 'CU-1028', 'HUMBERTO CORREA', NULL, '214 316 7747', NULL, '2019-04-24 00:00:00', 1),
(29, 1, NULL, 'CU-1029', 'JAVIER CARRILLO', NULL, '214 724 4328', 'j_carrillo59@yahoo.com', '2019-04-24 00:00:00', 1),
(30, 1, NULL, 'CU-1030', 'GUILLERMO TREVINO', '1225 Capital Dr. #100 Carrollton, TX 75006', '214 637 8530\r\n', 'GTrevino@rpfoodsinc.com\r\n', '2018-06-09 00:00:00', 1),
(31, 1, NULL, 'CU-1031', 'ALEX Y AARON GALBAN\r\n', 'GABA GROUP LLC.', '214 642 3138', 'aaed@gabagroupllc.com', '2018-06-09 00:00:00', 1),
(32, 1, NULL, 'CU-1032', 'SALVADOR OLMEDA', NULL, '214 395 4457', NULL, '2018-06-09 00:00:00', 1),
(33, 1, NULL, 'CU-1033', 'DANIELLE ZARATE', NULL, '469 647 2588\r\n', 'daniellezarate5@gmail.com\r\n', '2018-06-09 00:00:00', 1),
(34, 1, NULL, 'CU-1034', 'EDUARDO', '10124 Goodyear Dr, Dallas, TX 75229\r\n', '214 243 9250\r\n', NULL, '2018-06-09 00:00:00', 1),
(35, 1, NULL, 'CU-1035', 'EILEEN WONGVALLE', NULL, '214 789 1881\r\n', '6142 JOYCE WAY DALLAS TX 75225\r\n', '2018-06-09 00:00:00', 1),
(36, 1, NULL, 'CU-1036', 'JOSE JARAMILLO', '1056 E FULTON ST VAN ALSTYNE TX 75495\r\n', '972 330 7241\r\n', NULL, '2018-06-09 00:00:00', 1),
(37, 1, NULL, 'CU-1037', 'ESTRUCTURA IGLESIA', NULL, '214 815 4596\r\n', NULL, '2018-06-09 00:00:00', 1),
(38, 1, NULL, 'CU-1038', 'LUIS LUCERO', NULL, '214 414 8388\r\n', NULL, '2018-06-09 00:00:00', 1),
(39, 1, NULL, 'CU-1039', 'JUAN ROJAS', NULL, '469 987 9689\r\n', NULL, '2018-06-09 00:00:00', 1),
(40, 1, NULL, 'CU-1040', 'ALBINO PERDOMO', '3235 RAMONA AVE, DALLAS TX 75216 \r\n', '469 733 0228\r\n', 'perdomoalbino@gmail.com\r\n', '2018-06-09 00:00:00', 1),
(41, 1, NULL, 'CU-1041', 'JAVIER LEAL', '2630 Northaven rd Suite 101 Dallas Tx 75229', '214 519 4132', 'office@regional-homes.com', '2018-06-09 00:00:00', 1),
(42, 1, NULL, 'CU-1042', 'MANUEL', '3520 TYLER DR\r\n', '469 569 8273\r\n', NULL, '2018-06-09 00:00:00', 1),
(43, 1, NULL, 'CU-1043', 'JOSE', '10939 LIMONESTON DR BALCH SPRINGS TX \r\n', '469 271 4884\r\n', 'tulumremodeling@yahoo.com\r\n', '2018-06-09 00:00:00', 1),
(44, 1, NULL, 'CU-1044', 'HAZAEL MILLAN', '2008 CALYPSO ST, DALLAS TX 75212\r\n', '214 853 0416\r\n', NULL, '2018-06-09 00:00:00', 1),
(45, 1, NULL, 'CU-1045', 'WENDELL	ORMISTON\r\n', NULL, '214 727 0645\r\n', 'weormiston@yahoo.com\r\n', '2018-06-09 00:00:00', 1),
(46, 1, NULL, 'CU-1046', 'MICHAEL ARANI', '2095 N COLINS BLV RICHARSON TX\r\n', '214-697-5887 \r\n', 'decdallas@aol.com\r\n', '2019-04-24 00:00:00', 1),
(47, 1, NULL, 'CU-1047', 'ADAM REYES\r\n', NULL, '469 781 0952\r\n', 'arcdesingdfw@gmail.com\r\n', '2018-06-09 00:00:00', 1),
(48, 1, NULL, 'CU-1048', 'PETER COORLAS', NULL, '972 458 6854\r\n', 'petercoorlas@yahoo.com\r\n', '2018-06-09 00:00:00', 1),
(49, 1, NULL, 'CU-1049', 'CRISANTO CORONADO', NULL, '214 563 7900\r\n', NULL, '2019-04-24 00:00:00', 1),
(50, 1, NULL, 'CU-1050', 'OMELDA SALVADOR', NULL, '214 395 4457 \r\n', NULL, '2019-04-24 00:00:00', 1),
(51, 1, NULL, 'CU-1051', 'GLEN HERMES', NULL, '817 205 8505\r\n', 'ghpgnt@aol.com\r\n', '2019-04-24 00:00:00', 1),
(52, 1, NULL, 'CU-1052', 'GLORIA', NULL, '682 465 9137\r\n', 'info@goldenhotpots.com\r\n', '2019-04-24 00:00:00', 1),
(53, 1, NULL, 'CU-1053', 'LILIAN CUSTOM HOME Luanne Rivera \r\n', '509 Ferris Ave, Waxahachie, TX 75165\r\n', '972 937 8990 \r\n', 'https://www.lilliancustomhomes.com/\r\n', '2019-04-24 00:00:00', 1),
(54, 1, NULL, 'CU-1054', 'WILLI ARIAS', NULL, '214 597 3453\r\n', 'arias892.wa@gmail.com\r\n', '2019-04-24 00:00:00', 1),
(55, 1, NULL, 'CU-1055', 'CASTILLO MIRNA', NULL, '469 563 0223\r\n', NULL, '2019-04-24 00:00:00', 1),
(56, 1, NULL, 'CU-1056', 'JAIMA SERVPRO', '1515 WESTCHESTER DR ENNIS TX 75119\r\n', '972 672 4553\r\n', 'jamesyanez007@icloud.com\r\n', '2019-04-24 00:00:00', 1),
(57, 1, NULL, 'CU-1057', 'GUADALUPE SOTO', '2424 MONTALBAN AVE\r\n', '214 957 2211\r\n', NULL, '2019-04-24 00:00:00', 1),
(58, 1, NULL, 'CU-1058', 'WILLY', '2614 S EWING AVE DALLAS TX\r\n', '214 508 2204\r\n', NULL, '2018-06-09 00:00:00', 1),
(59, 1, NULL, 'CU-1059', 'CARLOS RUIZ', NULL, '214 918 0263\r\n', 'carlosjr@jcrmail.com\r\n', '2019-04-24 00:00:00', 1),
(60, 1, NULL, 'CU-1060', 'ISRAEL GEE', NULL, '214 695 8433', 'israelgee91@gmail.com\r\n', '2019-04-24 00:00:00', 1),
(61, 1, NULL, 'CU-1061', 'GUILLERMO', NULL, '469 371 5998\r\n', NULL, '2019-04-24 00:00:00', 1),
(62, 1, NULL, 'CU-1062', 'SANDRA QUINTANA', NULL, '214 957 6935', 'qsandra27.sq@gmail.com', '2018-06-09 00:00:00', 1),
(63, 2, 1, 'CU-0001', 'Maria perez', 'la trinidad', '04243328092', 'alejocastro2@gmail.com', '2019-05-02 04:47:21', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuration`
--

DROP TABLE IF EXISTS `configuration`;
CREATE TABLE IF NOT EXISTS `configuration` (
  `configurationId` int(6) NOT NULL AUTO_INCREMENT,
  `countryId` int(6) NOT NULL,
  `officeId` int(6) NOT NULL,
  `projectNumber` int(6) NOT NULL,
  `serviceNumber` int(6) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL,
  PRIMARY KEY (`configurationId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `configuration`
--

INSERT INTO `configuration` (`configurationId`, `countryId`, `officeId`, `projectNumber`, `serviceNumber`, `dateCreated`, `lastUserId`) VALUES
(1, 1, 1, 42, 0, '2018-06-09 00:00:00', 1),
(2, 2, 2, 0, 0, '2018-06-09 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contract`
--

DROP TABLE IF EXISTS `contract`;
CREATE TABLE IF NOT EXISTS `contract` (
  `contractId` int(11) NOT NULL AUTO_INCREMENT,
  `contractType` varchar(1) NOT NULL,
  `contractNumber` varchar(13) NOT NULL,
  `countryId` int(6) NOT NULL,
  `officeId` int(6) NOT NULL,
  `contractDate` date NOT NULL,
  `clientId` int(11) NOT NULL,
  `siteAddress` varchar(255) NOT NULL,
  `projectTypeId` int(11) NOT NULL,
  `serviceTypeId` int(11) NOT NULL,
  `registryNumber` varchar(32) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `scheduledFinishDate` date DEFAULT NULL,
  `actualFinishDate` date DEFAULT NULL,
  `deliveryDate` date DEFAULT NULL,
  `initialComment` text,
  `intermediateComment` text,
  `finalComment` text,
  `contractCost` decimal(13,2) NOT NULL DEFAULT '0.00',
  `currencyName` varchar(64) NOT NULL,
  `contractStatus` int(2) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL,
  PRIMARY KEY (`contractId`),
  KEY `projectTypeId` (`projectTypeId`),
  KEY `serviceTypeId` (`serviceTypeId`),
  KEY `countryId` (`countryId`),
  KEY `officeId` (`officeId`),
  KEY `clientId` (`clientId`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contract`
--

INSERT INTO `contract` (`contractId`, `contractType`, `contractNumber`, `countryId`, `officeId`, `contractDate`, `clientId`, `siteAddress`, `projectTypeId`, `serviceTypeId`, `registryNumber`, `startDate`, `scheduledFinishDate`, `actualFinishDate`, `deliveryDate`, `initialComment`, `intermediateComment`, `finalComment`, `contractCost`, `currencyName`, `contractStatus`, `dateCreated`, `lastUserId`) VALUES
(1, 'P', '19PC-0000001', 1, 1, '2019-01-04', 3, '2036 Echo Lake Dr Dallas, TX 75253', 1, 2, '1', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:05:08', 2),
(2, 'P', '19PC-0000002', 1, 1, '2019-01-04', 4, '526 ELLA AVE DALLAS TX 75217', 1, 1, '2', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:07:45', 2),
(3, 'P', '19PC-0000003', 1, 1, '2019-01-04', 23, '4319 ELECTRA ST DALLAS TX 75215', 2, 2, '3', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:08:54', 2),
(4, 'P', '19PC-0000004', 1, 1, '2019-01-07', 27, '9400 Waterman Dr, Aubrey, TX 76227', 2, 2, '4', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:09:48', 2),
(5, 'P', '19PC-0000005', 1, 1, '2019-01-08', 30, '3922 Lively Ln Dallas, TX 75220', 1, 2, '5', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:11:51', 2),
(6, 'P', '19PC-0000006', 1, 1, '2019-01-08', 31, '3906 Broadway Ave Haltom City, TX 76117', 42, 1, '6', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:15:26', 2),
(7, 'P', '19PC-0000007', 1, 1, '2019-01-17', 33, '428 W Davis St. Dallas, TX 75208', 14, 1, '7', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:16:47', 2),
(8, 'P', '19PC-0000008', 1, 1, '2019-01-18', 39, '6443 LEANA AVE DALLAS TX 75241', 1, 2, '8', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:20:05', 2),
(9, 'P', '19PC-0000009', 1, 1, '2019-01-18', 34, '10124 Goodyear Dr, Dallas, TX 75229', 2, 2, '9', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:22:04', 2),
(10, 'P', '19PC-0000010', 1, 1, '2019-01-19', 35, '6142 JOYCE WAY DALLAS TX 75225', 2, 2, '10', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:22:50', 2),
(11, 'P', '19PC-0000011', 1, 1, '2019-01-19', 36, '1056 E FULTON ST VAN ALSTYNE TX 75495', 1, 2, '11', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:23:35', 2),
(12, 'P', '19PC-0000012', 1, 1, '2019-01-21', 38, '625 W Danieldale Rd Dallas, TX 75232', 1, 2, '12', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:25:10', 2),
(13, 'P', '19PC-0000013', 1, 1, '2019-01-21', 38, '12619 Rialto Dr Dallas, TX 75243', 1, 2, '13', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:26:09', 2),
(14, 'P', '19PC-0000014', 1, 1, '2019-01-21', 43, '10939 LIMONESTON DR BALCH SPRINGS TX', 1, 2, '14', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:27:10', 2),
(15, 'P', '19PC-0000015', 1, 1, '2019-01-22', 40, '3235 RAMONA AVE, DALLAS TX 75216', 2, 2, '15', '2019-04-27', '2019-04-27', '2019-05-04', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:28:01', 2),
(16, 'P', '19PC-0000016', 1, 1, '2019-01-23', 44, '2008 CALYPSO ST, DALLAS TX 75212', 1, 2, '16', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:28:51', 2),
(17, 'P', '19PC-0000017', 1, 1, '2019-01-24', 38, '2861 SPRUCE VALLEY LN DALLAS TX 75233', 1, 2, '17', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:29:35', 2),
(18, 'P', '19PC-0000018', 1, 1, '2019-01-24', 42, '3520 TYLER ST.DALLAS 75224', 43, 2, '18', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:31:14', 2),
(19, 'P', '19PC-0000019', 1, 1, '2019-02-04', 27, '6407 BOB O LINK DR DALLAS TX 75214', 1, 2, '19', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:32:10', 2),
(20, 'P', '19PC-0000020', 1, 1, '2019-02-04', 46, '120 W Grand St, Whitewright, TX 75491', 12, 1, '20', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:33:46', 2),
(21, 'P', '19PC-0000021', 1, 1, '2019-02-04', 30, '9847 Ontario Ln, Dallas, TX 75220', 44, 2, '21', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:35:29', 2),
(22, 'P', '19PC-0000022', 1, 1, '2019-02-05', 48, '1921 N PRAIRIE AVE DALLAS TX 75204', 12, 2, '22', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:36:17', 2),
(23, 'P', '19PC-0000023', 1, 1, '2019-02-07', 47, '9576 IRONWOOD DR FRISCO TX 75033', 12, 2, '23', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:37:15', 2),
(24, 'P', '19PC-0000024', 1, 1, '2019-02-06', 51, '1150 Strader Rd Northlake, TX 76247', 12, 2, '24', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:38:03', 2),
(25, 'P', '19PC-0000025', 1, 1, '2019-02-08', 49, '9924 GULF PALMS DR DALLAS TX 75227', 12, 2, '25', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:40:18', 2),
(26, 'P', '19PC-0000026', 1, 1, '2019-02-08', 50, '3502 MIDDLEFIELD RD DALLAS TX 75253', 1, 2, '26', '2019-04-27', '2019-05-24', '2019-05-02', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:41:23', 2),
(27, 'P', '19PC-0000027', 1, 1, '2019-02-13', 52, '1625 W Arkansas Ln, Arlington, TX 76013', 12, 1, '27', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:42:08', 2),
(28, 'P', '19PC-0000028', 1, 1, '2019-02-13', 55, '7932 CARBONDALE ST DALLAS TX 75216', 13, 1, '28', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:43:29', 2),
(29, 'P', '19PC-0000029', 1, 1, '2019-02-14', 53, '509 Ferris Ave, Waxahachie, TX 75165', 45, 2, '29', '2019-04-26', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:46:19', 2),
(30, 'P', '19PC-0000030', 1, 1, '2019-02-14', 54, '2430 LOCUST AVE DALLAS TX 75216', 8, 2, '30', '2019-05-04', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:47:21', 2),
(31, 'P', '19PC-0000031', 1, 1, '2019-02-18', 3, '208 Kimbell St Mesquite, TX 75149', 1, 2, '31', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:48:06', 2),
(32, 'P', '19PC-0000032', 1, 1, '2019-02-21', 57, '2424 Montalban Ave, Dallas, TX 75228', 2, 2, '32', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:48:49', 2),
(33, 'P', '19PC-0000033', 1, 1, '2019-02-22', 59, '721 N Central Expy, Plano, TX 75075', 35, 1, '33', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:50:05', 2),
(34, 'P', '19PC-0000034', 1, 1, '2019-02-27', 53, '509 Ferris Ave, Waxahachie, TX 75165', 45, 2, '34', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:51:07', 2),
(35, 'P', '19PC-0000035', 1, 1, '2019-02-27', 53, '509 Ferris Ave, Waxahachie, TX 75165', 45, 2, '35', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:52:02', 2),
(36, 'P', '19PC-0000036', 1, 1, '2019-02-27', 53, '509 Ferris Ave, Waxahachie, TX 75165', 45, 2, '36', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:52:43', 2),
(37, 'P', '19PC-0000037', 1, 1, '2019-02-28', 58, '2614 S EWING AVE DALLAS TX', 13, 2, '37', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:53:43', 2),
(38, 'P', '19PC-0000038', 1, 1, '2019-02-28', 56, '1601 WESTCHESTER DR ENNIS TX 75120', 1, 2, '38', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:54:51', 2),
(39, 'P', '19PC-0000039', 1, 1, '2019-03-06', 31, '3906 Broadway Ave Haltom City, TX 76117', 46, 1, '39', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:56:45', 2),
(40, 'P', '19PC-0000040', 1, 1, '2019-03-12', 60, '2720 E ILLINOIS AVE DALLAS TX 75216', 47, 2, '40', '2019-04-26', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:58:03', 2),
(41, 'P', '19PC-0000041', 1, 1, '2019-03-13', 61, '10272 VINEMONT ST DALLAS TX 75218', 12, 2, '41', '2019-04-26', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:58:53', 2),
(42, 'P', '19PC-0000042', 1, 1, '2019-03-14', 62, '8021 COUNTY ROAD 2448, TOOL TX 75143', 1, 2, '42', '2019-04-27', '2019-04-27', '2019-04-27', '2019-04-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-04-27 22:59:28', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contract_staff`
--

DROP TABLE IF EXISTS `contract_staff`;
CREATE TABLE IF NOT EXISTS `contract_staff` (
  `contractStaffId` int(11) NOT NULL AUTO_INCREMENT,
  `contractId` int(11) NOT NULL,
  `staffId` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL,
  PRIMARY KEY (`contractStaffId`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contract_staff`
--

INSERT INTO `contract_staff` (`contractStaffId`, `contractId`, `staffId`, `dateCreated`, `lastUserId`) VALUES
(6, 8, 1, '2019-02-22 17:50:23', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `countryId` int(6) NOT NULL AUTO_INCREMENT,
  `countryName` varchar(128) NOT NULL,
  `currencyName` varchar(64) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL,
  PRIMARY KEY (`countryId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `country`
--

INSERT INTO `country` (`countryId`, `countryName`, `currencyName`, `dateCreated`, `lastUserId`) VALUES
(1, 'USA', 'USD', '2018-06-09 00:00:00', 1),
(2, 'VENEZUELA', 'BS', '2018-06-09 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `office`
--

DROP TABLE IF EXISTS `office`;
CREATE TABLE IF NOT EXISTS `office` (
  `officeId` int(6) NOT NULL AUTO_INCREMENT,
  `countryId` int(6) NOT NULL,
  `officeName` varchar(255) NOT NULL,
  `officeAddress` varchar(255) NOT NULL,
  `officePhone` varchar(255) NOT NULL,
  `officeEmail` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL,
  PRIMARY KEY (`officeId`),
  KEY `countryId` (`countryId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `office`
--

INSERT INTO `office` (`officeId`, `countryId`, `officeName`, `officeAddress`, `officePhone`, `officeEmail`, `dateCreated`, `lastUserId`) VALUES
(1, 1, 'DALLAS', 'DALLAS', '', '', '2018-06-09 00:00:00', 1),
(2, 2, 'SAN FERNANDO', '', '', '', '2018-06-09 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_contract`
--

DROP TABLE IF EXISTS `payment_contract`;
CREATE TABLE IF NOT EXISTS `payment_contract` (
  `paymentContractId` int(11) NOT NULL AUTO_INCREMENT,
  `contractId` int(11) NOT NULL,
  `amount` decimal(13,2) NOT NULL DEFAULT '0.00',
  `paymentDate` date NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL,
  PRIMARY KEY (`paymentContractId`),
  KEY `contractId` (`contractId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_precontract`
--

DROP TABLE IF EXISTS `payment_precontract`;
CREATE TABLE IF NOT EXISTS `payment_precontract` (
  `paymentPrecontractId` int(11) NOT NULL AUTO_INCREMENT,
  `precontractId` int(11) NOT NULL,
  `amount` decimal(13,2) NOT NULL,
  `paymentDate` date NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(1) NOT NULL,
  PRIMARY KEY (`paymentPrecontractId`),
  KEY `precontractId` (`precontractId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `position`
--

DROP TABLE IF EXISTS `position`;
CREATE TABLE IF NOT EXISTS `position` (
  `positionId` int(9) NOT NULL,
  `positionName` varchar(128) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `position`
--

INSERT INTO `position` (`positionId`, `positionName`, `dateCreated`, `lastUserId`) VALUES
(1, 'NULL', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pre_contract`
--

DROP TABLE IF EXISTS `pre_contract`;
CREATE TABLE IF NOT EXISTS `pre_contract` (
  `precontractId` int(11) NOT NULL AUTO_INCREMENT,
  `contractType` varchar(1) NOT NULL,
  `countryId` int(6) NOT NULL,
  `officeId` int(6) NOT NULL,
  `clientId` int(11) NOT NULL,
  `siteAddress` varchar(255) NOT NULL,
  `projectTypeId` int(11) NOT NULL,
  `serviceTypeId` int(11) NOT NULL,
  `comment` text,
  `precontractCost` decimal(13,2) NOT NULL DEFAULT '0.00',
  `currencyName` varchar(64) NOT NULL,
  PRIMARY KEY (`precontractId`),
  KEY `countryId` (`countryId`),
  KEY `officeId` (`officeId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pre_contract`
--

INSERT INTO `pre_contract` (`precontractId`, `contractType`, `countryId`, `officeId`, `clientId`, `siteAddress`, `projectTypeId`, `serviceTypeId`, `comment`, `precontractCost`, `currencyName`) VALUES
(1, 'P', 2, 2, 1, 'ROCHESTER, MN', 1, 1, NULL, '0.00', 'BS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_type`
--

DROP TABLE IF EXISTS `project_type`;
CREATE TABLE IF NOT EXISTS `project_type` (
  `projectTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `projectTypeName` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL,
  PRIMARY KEY (`projectTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `project_type`
--

INSERT INTO `project_type` (`projectTypeId`, `projectTypeName`, `dateCreated`, `lastUserId`) VALUES
(1, 'NEW', '2018-09-01 00:00:00', 1),
(2, 'ADDITION', '2018-09-01 00:00:00', 1),
(3, 'CO', '2018-09-01 00:00:00', 1),
(4, 'IR', '2018-09-01 00:00:00', 1),
(5, 'SHARE WALL', '2018-09-01 00:00:00', 1),
(6, 'GREEN ENERGY', '2018-09-01 00:00:00', 1),
(7, 'ADE', '2018-09-01 00:00:00', 1),
(8, 'ELEVATION', '2018-09-01 00:00:00', 1),
(9, 'EXISTING', '2018-09-01 00:00:00', 1),
(10, 'FLOOR PLAN', '2018-09-01 00:00:00', 1),
(11, 'PERBOLA', '2018-09-01 00:00:00', 1),
(12, 'REMODEL', '2018-09-01 00:00:00', 1),
(13, 'FENCE', '2018-09-01 00:00:00', 1),
(14, 'RAR', '2018-09-01 00:00:00', 1),
(15, 'INT REM', '2018-09-01 00:00:00', 1),
(16, 'DP', '2018-09-01 00:00:00', 1),
(17, 'PP', '2019-01-22 00:00:00', 1),
(18, 'FRAMING', '2018-09-01 00:00:00', 1),
(19, 'ADDITION', '2018-09-01 00:00:00', 1),
(20, 'ADDENDUM', '2019-01-23 00:00:00', 1),
(21, 'REPAIR', '2018-09-01 00:00:00', 1),
(22, '3D', '2018-09-01 00:00:00', 1),
(23, 'ELECTRICAL', '2018-09-01 00:00:00', 1),
(24, 'SP PA', '2019-01-23 07:32:59', 1),
(25, 'COPY', '2018-09-01 00:00:00', 1),
(26, 'SITE PLAN', '2019-01-27 00:00:00', 1),
(27, 'STRUCTURE', '2018-09-01 00:00:00', 1),
(28, 'GREEN INSPEC', '2018-09-01 00:00:00', 1),
(29, 'SURVEY', '2018-09-01 00:00:00', 1),
(30, 'STRUCTURAL', '2018-09-01 00:00:00', 1),
(32, 'OF/GALPON', '2019-01-28 00:00:00', 1),
(33, 'PRUEBA', '2018-09-01 00:00:00', 1),
(34, 'DEVELOPMENT', '2018-09-01 00:00:00', 1),
(35, 'INTERIOR REMO', '2018-09-01 00:00:00', 1),
(36, 'CORRECCIONES', '2018-09-01 00:00:00', 1),
(37, 'ADDITION LIVING', '2018-09-01 00:00:00', 1),
(38, 'TV', '2018-09-01 00:00:00', 1),
(39, 'TV/PRUEBA', '2019-01-22 00:00:00', 1),
(40, 'WALL', '2018-09-01 00:00:00', 1),
(41, 'RETENI WALL', '2018-09-01 00:00:00', 1),
(42, 'ELECT PLUMBING', '2019-04-27 22:14:37', 2),
(43, 'CHANGE', '2019-04-27 22:30:33', 2),
(44, 'CARPORT', '2019-04-27 22:34:47', 2),
(45, 'RVIEW/COMPLETE', '2019-04-27 22:45:17', 2),
(46, 'CIVIL ENG', '2019-04-27 22:56:02', 2),
(47, 'FFE SWD', '2019-04-27 22:57:29', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receivable`
--

DROP TABLE IF EXISTS `receivable`;
CREATE TABLE IF NOT EXISTS `receivable` (
  `receivableId` int(11) NOT NULL AUTO_INCREMENT,
  `countryId` int(6) NOT NULL,
  `clientId` int(11) NOT NULL,
  `contractId` int(11) NOT NULL,
  `paymentContractId` int(11) NOT NULL,
  `sourceReference` varchar(24) NOT NULL,
  `amountDue` decimal(13,2) NOT NULL,
  `amountPaid` decimal(13,2) DEFAULT '0.00',
  `amountPercentaje` decimal(13,2) DEFAULT '0.00',
  `collectMethod` varchar(64) DEFAULT NULL,
  `sourceBank` varchar(64) DEFAULT NULL,
  `sourceBankAccount` varchar(24) DEFAULT NULL,
  `checkNumber` int(11) DEFAULT NULL,
  `targetBankId` int(6) DEFAULT NULL,
  `targetBankAccount` varchar(24) DEFAULT NULL,
  `datePaid` date DEFAULT NULL,
  `pending` varchar(1) NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`receivableId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `receivable`
--

INSERT INTO `receivable` (`receivableId`, `countryId`, `clientId`, `contractId`, `paymentContractId`, `sourceReference`, `amountDue`, `amountPaid`, `amountPercentaje`, `collectMethod`, `sourceBank`, `sourceBankAccount`, `checkNumber`, `targetBankId`, `targetBankAccount`, `datePaid`, `pending`) VALUES
(1, 1, 1, 47, 11, '19PC-0000047', '200.00', '200.00', '0.00', '1', NULL, NULL, NULL, 2, '01050234021234566732', '2019-05-08', 'N'),
(2, 1, 1, 47, 12, '19PC-0000047', '2000.00', '2000.00', '0.00', '1', NULL, NULL, NULL, 2, '01050234021234566732', '2019-05-08', 'N'),
(3, 1, 2, 1, 13, '18PC-000001', '1000.00', '1000.00', '0.00', '1', NULL, NULL, NULL, 2, '01050234021234566732', '2019-05-08', 'N'),
(4, 1, 2, 1, 14, '18PC-000001', '1500.00', '0.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y'),
(7, 1, 1, 5, 17, '18PC-000005', '500.00', '500.00', '0.00', '1', NULL, NULL, NULL, 2, '01050234021234566732', '2019-05-08', 'N'),
(9, 1, 1, 5, 19, '18PC-000005', '1600.00', '1600.00', '0.00', '1', NULL, NULL, NULL, 2, '01050234021234566732', '2019-05-08', 'N'),
(10, 1, 1, 5, 20, '18PC-000005', '1400.00', '1400.00', '0.00', '1', NULL, NULL, NULL, 2, '01050234021234566732', '2019-05-15', 'N');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `service_type`
--

DROP TABLE IF EXISTS `service_type`;
CREATE TABLE IF NOT EXISTS `service_type` (
  `serviceTypeId` int(11) NOT NULL AUTO_INCREMENT,
  `serviceTypeName` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL,
  PRIMARY KEY (`serviceTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `service_type`
--

INSERT INTO `service_type` (`serviceTypeId`, `serviceTypeName`, `dateCreated`, `lastUserId`) VALUES
(1, 'COM', '2018-09-01 00:00:00', 1),
(2, 'RES', '2018-09-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff`
--

DROP TABLE IF EXISTS `staff`;
CREATE TABLE IF NOT EXISTS `staff` (
  `staffId` int(11) NOT NULL AUTO_INCREMENT,
  `staffCategoryId` int(6) NOT NULL,
  `countryId` int(6) NOT NULL,
  `officeId` int(6) NOT NULL,
  `userId` int(11) NOT NULL,
  `fullName` varchar(64) NOT NULL,
  `positionId` int(9) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL,
  PRIMARY KEY (`staffId`),
  KEY `staffCategoryId` (`staffCategoryId`,`countryId`,`officeId`),
  KEY `countryId` (`countryId`),
  KEY `officeId` (`officeId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `staff`
--

INSERT INTO `staff` (`staffId`, `staffCategoryId`, `countryId`, `officeId`, `userId`, `fullName`, `positionId`, `dateCreated`, `lastUserId`) VALUES
(1, 3, 2, 2, 4, 'David Aparicio', 1, '2019-02-22 00:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff_category`
--

DROP TABLE IF EXISTS `staff_category`;
CREATE TABLE IF NOT EXISTS `staff_category` (
  `staffCategory` int(6) NOT NULL AUTO_INCREMENT,
  `staffCategoryName` varchar(64) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL,
  PRIMARY KEY (`staffCategory`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `staff_category`
--

INSERT INTO `staff_category` (`staffCategory`, `staffCategoryName`, `dateCreated`, `lastUserId`) VALUES
(1, 'DIRECTOR', '2018-06-09 00:00:00', 1),
(2, 'GERENTE', '2018-06-09 00:00:00', 1),
(3, 'EMPLEADO', '2018-06-09 00:00:00', 1),
(4, 'OBRERO', '2018-06-09 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
  `transactionId` int(11) NOT NULL AUTO_INCREMENT,
  `transactionTypeId` int(6) NOT NULL,
  `transactionDate` date NOT NULL,
  `description` varchar(128) NOT NULL,
  `amount` decimal(13,2) NOT NULL,
  `sign` varchar(1) DEFAULT NULL,
  `bankId` int(6) NOT NULL,
  `reference` varchar(64) NOT NULL,
  PRIMARY KEY (`transactionId`),
  KEY `transactionTypeId` (`transactionTypeId`),
  KEY `bankId` (`bankId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `transaction`
--

INSERT INTO `transaction` (`transactionId`, `transactionTypeId`, `transactionDate`, `description`, `amount`, `sign`, `bankId`, `reference`) VALUES
(13, 1, '2019-05-08', 'CUOTA', '2000.00', '+', 2, '19PC-0000047'),
(14, 1, '2019-05-08', 'CUOTA', '1000.00', '+', 2, '18PC-000001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaction_type`
--

DROP TABLE IF EXISTS `transaction_type`;
CREATE TABLE IF NOT EXISTS `transaction_type` (
  `transactionTypeId` int(6) NOT NULL AUTO_INCREMENT,
  `transactionTypeName` varchar(64) NOT NULL,
  `sign` varchar(1) NOT NULL,
  PRIMARY KEY (`transactionTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `transaction_type`
--

INSERT INTO `transaction_type` (`transactionTypeId`, `transactionTypeName`, `sign`) VALUES
(1, 'COBRO', '+'),
(2, 'PAGO', '-');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userTypeName` varchar(64) NOT NULL,
  `userLevel` int(2) NOT NULL,
  `countryId` int(6) NOT NULL,
  `officeId` int(6) NOT NULL,
  `userName` varchar(64) NOT NULL,
  `userPassword` varchar(64) NOT NULL,
  `userEmail` varchar(30) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userEmail` (`userEmail`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`userId`, `userTypeName`, `userLevel`, `countryId`, `officeId`, `userName`, `userPassword`, `userEmail`, `remember_token`, `dateCreated`, `lastUserId`) VALUES
(1, 'ADMINISTRADOR', 2, 1, 1, 'gabrielcarrillo2018', 'ec037f0bdfc5339525bbd807a26a07a0', 'gabrielcarrillo2018@gmail.com', '', '2018-06-09 00:00:00', 1),
(2, 'DIRECTOR', 1, 1, 1, 'joserivero', '$2a$12$biGGoisiXcQb5xjLS3yDxOMP5y0ErpFMJkv4Q4xaVU.YABdjbBQSi', 'directorgeneral@gmail.com', 'wCnqQqU5f36juqXLynvbnLUZDKbGsDB6Uw7Hehfp0hK0sI2pofknCQBP6z8Q', '2018-06-09 00:00:00', 1),
(3, 'CLIENTE', 5, 1, 1, 'cliente1', '$2y$12$RvUF8dFWdHx54s5uUlZI4OKaADNPlBO2Ebu8aZ8QPRtKkCCa5qyKS', 'cliente1@gmail.com', 'cfStkkRasQBCQpTVIdyUFI4ntSY18Fl68RS1eFjGZej5dGszzPOSOL62v2Zn', '2018-06-09 00:00:00', 1),
(4, 'EMPLEADO', 4, 1, 1, 'davidaparicio', '$2a$12$LjpaOM5IBmS/Ws3Qz3wgu.P98M5ETqtlRnlmxW6VhxhhGPlxdoS4C', 'proyectista1@gmail.com', '32nnllPyoXExK07A2T3P8loLQX5FWdFwl6w101jcSm7rgBO3gADpI3Nv2y4w', '2018-06-09 00:00:00', 1),
(5, 'CLIENTE', 5, 1, 1, 'cliente2', '6dcd0e14f89d67e397b9f52bb63f5570', 'cliente2@gmail.com', '', '2018-06-09 00:00:00', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bank`
--
ALTER TABLE `bank`
  ADD CONSTRAINT `bank_ibfk_1` FOREIGN KEY (`countryId`) REFERENCES `country` (`countryId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`countryId`) REFERENCES `country` (`countryId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `contract`
--
ALTER TABLE `contract`
  ADD CONSTRAINT `contract_ibfk_1` FOREIGN KEY (`projectTypeId`) REFERENCES `project_type` (`projectTypeId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `contract_ibfk_2` FOREIGN KEY (`serviceTypeId`) REFERENCES `service_type` (`serviceTypeId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `contract_ibfk_3` FOREIGN KEY (`countryId`) REFERENCES `country` (`countryId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `contract_ibfk_4` FOREIGN KEY (`officeId`) REFERENCES `office` (`officeId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `contract_ibfk_5` FOREIGN KEY (`clientId`) REFERENCES `client` (`clientId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `office`
--
ALTER TABLE `office`
  ADD CONSTRAINT `office_ibfk_1` FOREIGN KEY (`countryId`) REFERENCES `country` (`countryId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `payment_contract`
--
ALTER TABLE `payment_contract`
  ADD CONSTRAINT `payment_contract_ibfk_1` FOREIGN KEY (`contractId`) REFERENCES `contract` (`contractId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `payment_precontract`
--
ALTER TABLE `payment_precontract`
  ADD CONSTRAINT `payment_precontract_ibfk_1` FOREIGN KEY (`precontractId`) REFERENCES `pre_contract` (`precontractId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `pre_contract`
--
ALTER TABLE `pre_contract`
  ADD CONSTRAINT `pre_contract_ibfk_1` FOREIGN KEY (`countryId`) REFERENCES `country` (`countryId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_contract_ibfk_2` FOREIGN KEY (`officeId`) REFERENCES `office` (`officeId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`staffCategoryId`) REFERENCES `staff_category` (`staffCategory`) ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_ibfk_2` FOREIGN KEY (`countryId`) REFERENCES `country` (`countryId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `staff_ibfk_3` FOREIGN KEY (`officeId`) REFERENCES `office` (`officeId`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`transactionTypeId`) REFERENCES `transaction_type` (`transactionTypeId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`bankId`) REFERENCES `bank` (`bankId`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
