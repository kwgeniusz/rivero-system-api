-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-04-2019 a las 15:18:29
-- Versión del servidor: 10.1.31-MariaDB
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

CREATE TABLE `bank` (
  `bankId` int(6) NOT NULL,
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
  `balance12` decimal(13,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bank`
--

INSERT INTO `bank` (`bankId`, `countryId`, `bankName`, `bankAccount`, `initialBalance`, `balance01`, `balance02`, `balance03`, `balance04`, `balance05`, `balance06`, `balance07`, `balance08`, `balance09`, `balance10`, `balance11`, `balance12`) VALUES
(2, 1, 'BANESCO', '01050234021234566732', '10000.00', '0.00', '17500.00', '32943.00', '1000.00', '0.00', '0.00', '0.00', '5500.00', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client`
--

CREATE TABLE `client` (
  `clientId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `clientName` varchar(255) NOT NULL,
  `clientDescription` varchar(255) DEFAULT NULL,
  `clientAddress` varchar(255) DEFAULT NULL,
  `clientPhone` varchar(255) DEFAULT NULL,
  `clientEmail` varchar(255) DEFAULT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `client`
--

INSERT INTO `client` (`clientId`, `userId`, `clientName`, `clientDescription`, `clientAddress`, `clientPhone`, `clientEmail`, `dateCreated`, `lastUserId`) VALUES
(1, 3, 'Dennis Lawler', 'PROFESOR EN MINNESOTA STATE UNIVERSITY', 'ROCHESTER, MN', '+1 44 2343200', 'djl@gmail.com', '2018-06-09 00:00:00', 1),
(2, 5, 'Latin market', 'Grocery Retailer', '231 Texas Ave., Dallas, TX', '+1 32 7896032', 'groceryretailer@gmail.com', '2018-03-05 04:57:15', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuration`
--

CREATE TABLE `configuration` (
  `configurationId` int(6) NOT NULL,
  `countryId` int(6) NOT NULL,
  `officeId` int(6) NOT NULL,
  `projectNumber` int(6) NOT NULL,
  `serviceNumber` int(6) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `configuration`
--

INSERT INTO `configuration` (`configurationId`, `countryId`, `officeId`, `projectNumber`, `serviceNumber`, `dateCreated`, `lastUserId`) VALUES
(1, 1, 1, 79, 11, '2018-06-09 00:00:00', 1),
(2, 2, 2, 4, 3, '2018-06-09 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contract`
--

CREATE TABLE `contract` (
  `contractId` int(11) NOT NULL,
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
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contract`
--

INSERT INTO `contract` (`contractId`, `contractType`, `contractNumber`, `countryId`, `officeId`, `contractDate`, `clientId`, `siteAddress`, `projectTypeId`, `serviceTypeId`, `registryNumber`, `startDate`, `scheduledFinishDate`, `actualFinishDate`, `deliveryDate`, `initialComment`, `intermediateComment`, `finalComment`, `contractCost`, `currencyName`, `contractStatus`, `dateCreated`, `lastUserId`) VALUES
(1, 'P', '18PC-000001', 1, 1, '2018-01-01', 2, '3800 JORDAN VALLEY RD DALLAS TX 75253', 1, 1, '1', '2018-01-01', '2018-02-01', '2018-02-01', '2018-02-01', NULL, NULL, NULL, '2500.00', 'USD', 2, '2018-09-01 00:00:00', 1),
(2, 'P', '18PC-000002', 1, 1, '2018-01-03', 1, '9401 BARTON CREEK DR ROWLETT TX', 1, 1, '1', '2019-01-03', '2018-01-24', '2018-01-24', '2018-01-24', NULL, NULL, NULL, '0.00', 'USD', 3, '2018-09-01 00:00:00', 1),
(3, 'P', '18PC-000003', 1, 1, '2018-01-04', 1, '', 1, 1, '1', '2018-01-04', '2018-03-04', '2018-03-04', '2018-03-04', NULL, NULL, NULL, '0.00', 'USD', 3, '2018-09-01 00:00:00', 1),
(4, 'P', '18PC-000004', 1, 1, '2018-04-01', 1, '3062 Primrose Ln Farmers Branch, TX 75234', 1, 1, '1', '2018-04-01', '2018-04-30', '2018-04-30', '2018-04-30', NULL, NULL, NULL, '0.00', 'USD', 3, '2018-09-01 00:00:00', 1),
(5, 'P', '18PC-000005', 1, 1, '2018-01-05', 1, '2808 ANZIO DR DALLAS TX 75224', 1, 1, '1', '2017-12-05', '2018-01-25', '2018-01-25', '2018-01-25', NULL, NULL, NULL, '3500.00', 'USD', 1, '2018-09-01 00:00:00', 1),
(6, 'P', '18PC-000006', 1, 1, '2018-01-10', 1, '', 1, 1, '1', '2018-01-10', '2018-02-10', '2018-02-10', '2018-02-10', NULL, NULL, NULL, '100.00', 'USD', 2, '2018-09-01 00:00:00', 1),
(7, 'P', '18PC-000007', 1, 1, '2018-01-10', 1, '7916 West Hodges Rd Dallas Tx 75217', 1, 1, '1', '2018-01-10', '2018-02-10', '2018-02-10', '2018-02-10', NULL, NULL, NULL, '0.00', 'USD', 1, '2018-09-01 00:00:00', 1),
(8, 'P', '18PC-000008', 1, 1, '2018-01-11', 1, '615 Coombs Creek Dr, Dallas Tx 75211', 1, 1, '1', '2018-01-11', '2018-02-11', '2018-02-11', '2018-02-11', NULL, NULL, NULL, '0.00', 'USD', 1, '2018-09-01 00:00:00', 1),
(9, 'P', '18PC-000009', 1, 1, '2018-01-12', 1, '2217 Greenville Ave Dallas Tx 75206', 1, 1, '1', '0000-00-00', '2019-02-15', '2019-02-15', '2019-02-15', NULL, NULL, NULL, '0.00', 'USD', 1, '2018-09-01 00:00:00', 1),
(10, 'P', '18PC-000010', 1, 1, '2018-01-16', 1, '700 WINSTON DR DESOTO TX 75115', 1, 1, '1', '2018-01-16', '2018-03-16', '2018-03-16', '2018-03-16', NULL, NULL, NULL, '0.00', 'USD', 1, '2018-09-01 00:00:00', 1),
(11, 'P', '19PC-0000011', 1, 1, '2018-01-17', 1, '8740 QUINN ST DALLAS TX 75217', 1, 1, '1', '2018-01-17', '2018-01-30', '2018-01-30', '2018-01-31', NULL, NULL, NULL, '0.01', 'USD', 2, '2019-01-30 18:50:16', 2),
(12, 'P', '19PC-0000012', 1, 1, '2019-01-16', 1, 'LOT 2581 LAKE RIDGE PERIWINKLE COURT GRAND PRAIRE DALLAS COUNTY TX', 1, 1, '1', '2019-01-17', '2018-02-01', '2018-02-01', '2018-02-02', NULL, NULL, NULL, '0.01', 'USD', 2, '2019-01-30 18:53:47', 2),
(13, 'P', '19PC-0000013', 1, 1, '2018-01-22', 1, '2451 FRANKLIN DR MESQUITE TX 75150', 1, 1, '1', '2018-01-22', '2018-02-22', '2018-02-22', '2018-02-23', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-01-30 18:57:28', 2),
(14, 'P', '19PC-0000014', 1, 1, '2018-01-22', 1, '4629 COLLEGE PARK DR, DALLAS TX 75229', 1, 1, '1', '2018-01-22', '2018-02-22', '2018-02-22', '2018-02-25', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-01-30 20:01:03', 2),
(15, 'P', '19PC-0000015', 1, 1, '2018-01-22', 1, '4910 LYNNACRE DR DALLAS TX  75211', 1, 1, '1', '2018-01-22', '2018-02-22', '2018-02-22', '2018-02-24', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-01-30 20:03:02', 2),
(16, 'P', '19PC-0000016', 1, 1, '2018-01-24', 1, '1602 WILBUR ST DALLAS TX 75224', 1, 1, '-1', '2018-01-24', '2018-02-24', '2018-02-24', '2018-02-25', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-01-30 20:04:48', 2),
(17, 'P', '19PC-0000017', 1, 1, '2018-01-25', 1, '4505 KENSINGTON CT GRAND PRAIRIE TX 75052', 1, 1, '1', '2018-01-25', '2018-02-25', '2018-02-25', '2018-02-27', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-01-30 20:06:23', 2),
(18, 'P', '19PC-0000018', 1, 1, '2018-01-26', 1, '625 BIG HORN RD OAK POINT TX', 1, 1, '1', '2018-01-26', '2018-02-26', '2018-02-26', '2018-02-28', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-01-30 20:09:01', 2),
(19, 'P', '19PC-0000019', 1, 1, '2018-01-26', 1, '10939 LIMESTONE DR BALCH SPRINGS TX 75180', 1, 1, '-1', '2018-02-28', '2018-02-28', '2018-02-28', '2018-02-28', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-01-30 20:10:25', 2),
(20, 'P', '19PC-0000020', 1, 1, '2018-01-27', 1, '1021 S OAK CLIFF BLVD, DALLAS TX 75217', 1, 1, '1', '2018-01-27', '2018-02-28', '2018-02-28', '2018-02-28', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-01-30 20:14:29', 2),
(21, 'P', '19PC-0000021', 1, 1, '2018-01-29', 1, '3215 FAIRVIEW AVE, DALLAS TX 75223', 1, 1, '1', '2018-01-29', '2018-03-01', '2018-03-01', '2018-03-02', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-01-30 20:17:31', 2),
(22, 'P', '19PC-0000022', 1, 1, '2018-01-31', 1, '301 Northpoint Dr. Coppell Tx 75019', 1, 1, '1', '2018-02-01', '2018-02-27', '2018-02-27', '2018-02-28', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-01-30 20:18:58', 2),
(23, 'P', '19PC-0000023', 1, 1, '2018-01-31', 1, '3102 LAWNVIEW AVE DALLAS TX 75227', 1, 1, '-1', '2018-02-02', '2018-03-02', '2018-03-02', '2018-03-02', NULL, NULL, NULL, '100.00', 'USD', 1, '2019-01-30 20:21:49', 2),
(24, 'P', '19PC-0000024', 1, 1, '2018-02-05', 1, '503 S Stemmons Fwy Lewisville Tx 75067', 1, 1, '1', '2018-02-05', '2018-03-05', '2018-03-05', '2018-03-05', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:23:44', 2),
(25, 'P', '19PC-0000025', 1, 1, '2018-02-06', 1, '5107 E GRAND AVE DALLAS TX 75223', 1, 1, '1', '2018-02-06', '2018-03-06', '2018-03-06', '2018-03-07', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:26:23', 2),
(26, 'P', '19PC-0000026', 1, 1, '2018-02-08', 1, '7355 SWEETGATE LN DENTON TX 76208', 1, 1, '1', '2018-02-08', '2018-03-08', '2018-03-08', '2018-04-08', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:28:00', 2),
(27, 'P', '19PC-0000027', 1, 1, '2018-02-13', 1, '102 WINGREN LN ARLINGTON TX 76014', 1, 1, '1', '2018-02-13', '2018-03-13', '2018-03-13', '2018-03-13', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:30:03', 2),
(28, 'P', '19PC-0000028', 1, 1, '2018-02-13', 1, '4902 REIGER AVE DALLAS TX 75214', 1, 1, '1', '2018-02-13', '2018-03-13', '2018-03-13', '2018-03-13', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:31:26', 2),
(29, 'P', '19PC-0000029', 1, 1, '2018-02-15', 1, '1801 RANDOM RD CARROLTON TX 75006', 1, 1, '1', '2018-02-15', '2018-03-15', '2018-03-15', '2018-03-15', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:33:12', 2),
(30, 'P', '19PC-0000030', 1, 1, '2018-02-20', 1, '11 WOODWAY DR DALLAS TX 75217', 1, 1, '1', '2018-02-20', '2018-03-20', '2018-02-20', '2018-02-20', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:34:24', 2),
(31, 'P', '19PC-0000031', 1, 1, '2018-02-22', 1, '725 Fairview Ave Seagoville TX 75159', 1, 1, '1', '2018-02-22', '2018-03-22', '2018-03-22', '2018-03-22', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:35:40', 2),
(32, 'P', '19PC-0000032', 1, 1, '2018-02-23', 1, '11532 HARRY HINES BLVD SUITE 304 DALLAS TX 75229', 1, 1, '1', '0218-02-23', '2019-03-23', '2018-03-23', '2018-03-23', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:37:13', 2),
(33, 'P', '19PC-0000033', 1, 1, '2018-02-23', 1, '3475 ROYAL LN DALLAS TX 75229', 1, 1, '1', '2018-02-23', '2018-03-23', '2018-03-23', '2018-03-23', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:40:26', 2),
(34, 'P', '19PC-0000034', 1, 1, '2018-02-27', 1, '4166 EASTER AVENUE DALLAS TX 75216', 1, 1, '1', '2018-02-27', '2018-03-27', '2018-03-27', '2018-03-27', NULL, NULL, NULL, '0.00', 'USD', 1, '2019-02-01 00:47:19', 2),
(35, 'P', '19PC-0000035', 1, 1, '2018-02-27', 1, '1415 E WACO AVENUE DALLAS TX 75216', 1, 1, '1', '2018-02-27', '2018-03-27', '2018-03-27', '2018-03-27', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:48:28', 2),
(36, 'P', '19PC-0000036', 1, 1, '2018-02-27', 1, '2226 MOFFATT AVENUE DALLAS TX 75216', 1, 1, '1', '2018-02-27', '2018-03-27', '2018-03-27', '2018-03-27', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:50:00', 2),
(37, 'P', '19PC-0000037', 1, 1, '2018-02-27', 1, '2230 MOFFATT AVE DALLAS TX 75216', 1, 1, '1', '2018-02-27', '2018-03-27', '2018-03-27', '2018-03-27', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:51:41', 2),
(38, 'P', '19PC-0000038', 1, 1, '2018-03-02', 1, '5610 VAN WINKLE BLVD DALLAS TX', 1, 1, '1', '2018-03-02', '2018-04-02', '2018-04-02', '2018-04-02', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:53:00', 2),
(39, 'P', '19PC-0000039', 1, 1, '2018-03-05', 1, '6829 PARKWOOD DR. NORTH RICHLAND HILL TX 75182', 1, 1, '1', '2018-03-05', '2018-03-05', '2018-04-05', '2018-04-05', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:54:12', 2),
(40, 'P', '19PC-0000040', 1, 1, '2018-03-09', 1, '7879 SPRING VALLEY SUITE 112 DALLAS TX 75254', 1, 1, '1', '2018-03-09', '2018-04-09', '2018-04-09', '2018-04-09', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 00:55:24', 2),
(41, 'P', '19PC-0000041', 1, 1, '2018-03-09', 1, '3124 Koscher Dr, Cedar Hill, Texas 75104', 1, 1, '1', '2018-03-09', '2018-04-09', '2018-04-09', '2018-04-09', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 20:49:44', 2),
(42, 'P', '19PC-0000042', 1, 1, '2018-03-12', 1, '514 Stafford Dr, Seagoville, Texas 75159', 1, 1, '1', '2018-03-12', '2018-04-12', '2018-04-12', '2012-04-12', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 20:51:24', 2),
(43, 'P', '19PC-0000043', 1, 1, '2018-03-12', 1, '7305 Albert Williams Drive, Dallas, TX 75241', 1, 1, '1', '2018-03-12', '2016-04-12', '2018-04-12', '2018-04-12', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 20:53:18', 2),
(44, 'P', '19PC-0000044', 1, 1, '2018-03-19', 1, '2603 GLADSTONE DR DALLAS TX 75211', 1, 1, '1', '2018-03-19', '2018-04-19', '2014-04-19', '2018-04-19', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 20:56:17', 2),
(45, 'P', '19PC-0000045', 1, 1, '2018-03-19', 1, '3914 LIVELY LN DALLAS TX 75220', 1, 1, '1', '2018-03-19', '2018-04-19', '2018-04-19', '2018-04-10', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 20:57:41', 2),
(46, 'P', '19PC-0000046', 1, 1, '2018-03-27', 1, '6412 TEAGUE DR DALLAS TX 75241', 1, 1, '1', '2018-03-27', '2018-04-27', '2018-04-27', '2018-04-27', NULL, NULL, NULL, '0.01', 'USD', 1, '2019-02-01 20:59:01', 2),
(47, 'P', '19PC-0000047', 1, 1, '2018-03-27', 1, '6412 TEAGUE DR DALLAS TX 75241', 1, 1, '1', '2018-03-27', '2018-04-27', '2018-04-27', '2018-04-27', NULL, NULL, NULL, '5000.01', 'USD', 1, '2019-02-01 20:59:02', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contract_staff`
--

CREATE TABLE `contract_staff` (
  `contractStaffId` int(11) NOT NULL,
  `contractId` int(11) NOT NULL,
  `staffId` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contract_staff`
--

INSERT INTO `contract_staff` (`contractStaffId`, `contractId`, `staffId`, `dateCreated`, `lastUserId`) VALUES
(6, 8, 1, '2019-02-22 17:50:23', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `country`
--

CREATE TABLE `country` (
  `countryId` int(6) NOT NULL,
  `countryName` varchar(128) NOT NULL,
  `currencyName` varchar(64) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE `office` (
  `officeId` int(6) NOT NULL,
  `countryId` int(6) NOT NULL,
  `officeName` varchar(255) NOT NULL,
  `officeAddress` varchar(255) NOT NULL,
  `officePhone` varchar(255) NOT NULL,
  `officeEmail` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_contract`
--

CREATE TABLE `payment_contract` (
  `paymentContractId` int(11) NOT NULL,
  `contractId` int(11) NOT NULL,
  `amount` decimal(13,2) NOT NULL DEFAULT '0.00',
  `paymentDate` date NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `payment_contract`
--

INSERT INTO `payment_contract` (`paymentContractId`, `contractId`, `amount`, `paymentDate`, `dateCreated`, `lastUserId`) VALUES
(11, 47, '1000.00', '2019-03-11', '2019-03-11 19:56:44', 2),
(12, 47, '2000.00', '2019-03-11', '2019-03-11 20:07:04', 2),
(13, 1, '2000.00', '2019-03-11', '2019-03-11 23:19:49', 2),
(14, 1, '500.00', '2019-03-11', '2019-03-11 23:28:43', 2),
(17, 5, '2000.00', '2019-03-11', '2019-03-12 00:18:32', 2),
(19, 5, '1000.00', '2019-03-14', '2019-03-14 20:45:48', 2),
(20, 5, '500.00', '2019-03-25', '2019-03-25 06:39:06', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment_precontract`
--

CREATE TABLE `payment_precontract` (
  `paymentPrecontractId` int(11) NOT NULL,
  `precontractId` int(11) NOT NULL,
  `amount` decimal(13,2) NOT NULL,
  `paymentDate` date NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `position`
--

CREATE TABLE `position` (
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

CREATE TABLE `pre_contract` (
  `precontractId` int(11) NOT NULL,
  `contractType` varchar(1) NOT NULL,
  `countryId` int(6) NOT NULL,
  `officeId` int(6) NOT NULL,
  `clientId` int(11) NOT NULL,
  `siteAddress` varchar(255) NOT NULL,
  `projectTypeId` int(11) NOT NULL,
  `serviceTypeId` int(11) NOT NULL,
  `comment` text,
  `precontractCost` decimal(13,2) NOT NULL DEFAULT '0.00',
  `currencyName` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pre_contract`
--

INSERT INTO `pre_contract` (`precontractId`, `contractType`, `countryId`, `officeId`, `clientId`, `siteAddress`, `projectTypeId`, `serviceTypeId`, `comment`, `precontractCost`, `currencyName`) VALUES
(1, 'P', 2, 2, 1, 'ROCHESTER, MN', 1, 1, NULL, '0.00', 'BS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_type`
--

CREATE TABLE `project_type` (
  `projectTypeId` int(11) NOT NULL,
  `projectTypeName` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(31, 'REPAIR', '2018-09-01 00:00:00', 1),
(32, 'OF/GALPON', '2019-01-28 00:00:00', 1),
(33, 'PRUEBA', '2018-09-01 00:00:00', 1),
(34, 'DEVELOPMENT', '2018-09-01 00:00:00', 1),
(35, 'INTERIOR REMO', '2018-09-01 00:00:00', 1),
(36, 'CORRECCIONES', '2018-09-01 00:00:00', 1),
(37, 'ADDITION LIVING', '2018-09-01 00:00:00', 1),
(38, 'TV', '2018-09-01 00:00:00', 1),
(39, 'TV/PRUEBA', '2019-01-22 00:00:00', 1),
(40, 'WALL', '2018-09-01 00:00:00', 1),
(41, 'RETENI WALL', '2018-09-01 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receivable`
--

CREATE TABLE `receivable` (
  `receivableId` int(11) NOT NULL,
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
  `pending` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `receivable`
--

INSERT INTO `receivable` (`receivableId`, `countryId`, `clientId`, `contractId`, `paymentContractId`, `sourceReference`, `amountDue`, `amountPaid`, `amountPercentaje`, `collectMethod`, `sourceBank`, `sourceBankAccount`, `checkNumber`, `targetBankId`, `targetBankAccount`, `datePaid`, `pending`) VALUES
(1, 1, 1, 47, 11, '19PC-0000047', '1200.00', '0.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y'),
(2, 1, 1, 47, 12, '19PC-0000047', '1000.00', '0.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y'),
(3, 1, 2, 1, 13, '18PC-000001', '2000.00', '0.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y'),
(4, 1, 2, 1, 14, '18PC-000001', '500.00', '0.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y'),
(7, 1, 1, 5, 17, '18PC-000005', '2000.00', '0.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y'),
(9, 1, 1, 5, 19, '18PC-000005', '500.00', '0.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y'),
(10, 1, 1, 5, 20, '18PC-000005', '1000.00', '0.00', '0.00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Y');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `service_type`
--

CREATE TABLE `service_type` (
  `serviceTypeId` int(11) NOT NULL,
  `serviceTypeName` varchar(255) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `staff` (
  `staffId` int(11) NOT NULL,
  `staffCategoryId` int(6) NOT NULL,
  `countryId` int(6) NOT NULL,
  `officeId` int(6) NOT NULL,
  `userId` int(11) NOT NULL,
  `fullName` varchar(64) NOT NULL,
  `positionId` int(9) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `staff`
--

INSERT INTO `staff` (`staffId`, `staffCategoryId`, `countryId`, `officeId`, `userId`, `fullName`, `positionId`, `dateCreated`, `lastUserId`) VALUES
(1, 3, 2, 2, 4, 'David Aparicio', 1, '2019-02-22 00:00:00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staff_category`
--

CREATE TABLE `staff_category` (
  `staffCategory` int(6) NOT NULL,
  `staffCategoryName` varchar(64) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `transaction` (
  `transactionId` int(11) NOT NULL,
  `transactionTypeId` int(6) NOT NULL,
  `transactionDate` date NOT NULL,
  `description` varchar(128) NOT NULL,
  `amount` decimal(13,2) NOT NULL,
  `sign` varchar(1) DEFAULT NULL,
  `bankId` int(6) NOT NULL,
  `reference` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transaction_type`
--

CREATE TABLE `transaction_type` (
  `transactionTypeId` int(6) NOT NULL,
  `transactionTypeName` varchar(64) NOT NULL,
  `sign` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `user` (
  `userId` int(11) NOT NULL,
  `userTypeName` varchar(64) NOT NULL,
  `userLevel` int(2) NOT NULL,
  `countryId` int(6) NOT NULL,
  `officeId` int(6) NOT NULL,
  `userName` varchar(64) NOT NULL,
  `userPassword` varchar(64) NOT NULL,
  `userEmail` varchar(30) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `dateCreated` datetime NOT NULL,
  `lastUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`userId`, `userTypeName`, `userLevel`, `countryId`, `officeId`, `userName`, `userPassword`, `userEmail`, `remember_token`, `dateCreated`, `lastUserId`) VALUES
(1, 'ADMINISTRADOR', 2, 1, 1, 'gabrielcarrillo2018', 'ec037f0bdfc5339525bbd807a26a07a0', 'gabrielcarrillo2018@gmail.com', '', '2018-06-09 00:00:00', 1),
(2, 'DIRECTOR', 1, 1, 1, 'joserivero', '$2a$12$biGGoisiXcQb5xjLS3yDxOMP5y0ErpFMJkv4Q4xaVU.YABdjbBQSi', 'directorgeneral@gmail.com', '9UQIcWTrpW3UOTnet46ChlZmsGTyqkSDEQzIwww0B2L83boyXXjEaIJRcP3P', '2018-06-09 00:00:00', 1),
(3, 'CLIENTE', 5, 1, 1, 'cliente1', '$2y$12$RvUF8dFWdHx54s5uUlZI4OKaADNPlBO2Ebu8aZ8QPRtKkCCa5qyKS', 'cliente1@gmail.com', 'cfStkkRasQBCQpTVIdyUFI4ntSY18Fl68RS1eFjGZej5dGszzPOSOL62v2Zn', '2018-06-09 00:00:00', 1),
(4, 'EMPLEADO', 4, 1, 1, 'davidaparicio', '$2a$12$LjpaOM5IBmS/Ws3Qz3wgu.P98M5ETqtlRnlmxW6VhxhhGPlxdoS4C', 'proyectista1@gmail.com', '32nnllPyoXExK07A2T3P8loLQX5FWdFwl6w101jcSm7rgBO3gADpI3Nv2y4w', '2018-06-09 00:00:00', 1),
(5, 'CLIENTE', 5, 1, 1, 'cliente2', '6dcd0e14f89d67e397b9f52bb63f5570', 'cliente2@gmail.com', '', '2018-06-09 00:00:00', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`bankId`);

--
-- Indices de la tabla `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientId`);

--
-- Indices de la tabla `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`configurationId`);

--
-- Indices de la tabla `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`contractId`),
  ADD KEY `projectTypeId` (`projectTypeId`),
  ADD KEY `serviceTypeId` (`serviceTypeId`);

--
-- Indices de la tabla `contract_staff`
--
ALTER TABLE `contract_staff`
  ADD PRIMARY KEY (`contractStaffId`);

--
-- Indices de la tabla `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`countryId`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`officeId`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `payment_contract`
--
ALTER TABLE `payment_contract`
  ADD PRIMARY KEY (`paymentContractId`),
  ADD KEY `contractId` (`contractId`);

--
-- Indices de la tabla `payment_precontract`
--
ALTER TABLE `payment_precontract`
  ADD PRIMARY KEY (`paymentPrecontractId`),
  ADD KEY `precontractId` (`precontractId`);

--
-- Indices de la tabla `pre_contract`
--
ALTER TABLE `pre_contract`
  ADD PRIMARY KEY (`precontractId`);

--
-- Indices de la tabla `project_type`
--
ALTER TABLE `project_type`
  ADD PRIMARY KEY (`projectTypeId`);

--
-- Indices de la tabla `receivable`
--
ALTER TABLE `receivable`
  ADD PRIMARY KEY (`receivableId`);

--
-- Indices de la tabla `service_type`
--
ALTER TABLE `service_type`
  ADD PRIMARY KEY (`serviceTypeId`);

--
-- Indices de la tabla `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffId`);

--
-- Indices de la tabla `staff_category`
--
ALTER TABLE `staff_category`
  ADD PRIMARY KEY (`staffCategory`);

--
-- Indices de la tabla `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transactionId`),
  ADD KEY `transactionTypeId` (`transactionTypeId`),
  ADD KEY `bankId` (`bankId`);

--
-- Indices de la tabla `transaction_type`
--
ALTER TABLE `transaction_type`
  ADD PRIMARY KEY (`transactionTypeId`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bank`
--
ALTER TABLE `bank`
  MODIFY `bankId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `client`
--
ALTER TABLE `client`
  MODIFY `clientId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `configuration`
--
ALTER TABLE `configuration`
  MODIFY `configurationId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `contract`
--
ALTER TABLE `contract`
  MODIFY `contractId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `contract_staff`
--
ALTER TABLE `contract_staff`
  MODIFY `contractStaffId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `country`
--
ALTER TABLE `country`
  MODIFY `countryId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `office`
--
ALTER TABLE `office`
  MODIFY `officeId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `payment_contract`
--
ALTER TABLE `payment_contract`
  MODIFY `paymentContractId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `payment_precontract`
--
ALTER TABLE `payment_precontract`
  MODIFY `paymentPrecontractId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pre_contract`
--
ALTER TABLE `pre_contract`
  MODIFY `precontractId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `project_type`
--
ALTER TABLE `project_type`
  MODIFY `projectTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `receivable`
--
ALTER TABLE `receivable`
  MODIFY `receivableId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `service_type`
--
ALTER TABLE `service_type`
  MODIFY `serviceTypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `staff`
--
ALTER TABLE `staff`
  MODIFY `staffId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `staff_category`
--
ALTER TABLE `staff_category`
  MODIFY `staffCategory` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transactionId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `transaction_type`
--
ALTER TABLE `transaction_type`
  MODIFY `transactionTypeId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `payment_contract`
--
ALTER TABLE `payment_contract`
  ADD CONSTRAINT `payment_contract_ibfk_1` FOREIGN KEY (`contractId`) REFERENCES `contract` (`contractId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `payment_precontract`
--
ALTER TABLE `payment_precontract`
  ADD CONSTRAINT `payment_precontract_ibfk_1` FOREIGN KEY (`precontractId`) REFERENCES `pre_contract` (`precontractId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
