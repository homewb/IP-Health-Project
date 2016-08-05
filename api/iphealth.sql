-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2015-04-28 03:58:20
-- 服务器版本: 5.5.43-0ubuntu0.14.04.1
-- PHP 版本: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `iphealth`
--

-- --------------------------------------------------------

--
-- 表的结构 `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `empId` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `jobTittle` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`empId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `employees`
--

INSERT INTO `employees` (`empId`, `firstName`, `lastName`, `birthday`, `address`, `phone`, `mobile`, `department`, `jobTittle`) VALUES
(1, 'Jonathan', 'Ive', '1980-09-09', 'Russell Street', '2147483647', '1336223232', 'Department of Design', 'Senior Vice President'),
(2, 'Tim', 'Cook', '1960-09-09', '172_La_Trobe_Street_,Melbourne,Victoria,3000', '2147483647', '1234567890', 'CEO of Apple Inc', 'Board'),
(3, 'Jonathan', 'Ive', '1966-03-02', '156_Exhibition_Street_,Melbourne,Victoria,3000', '1403329982', '1336223232', 'Department of Art', 'Producer'),
(4, 'Amitabh', 'Bachchan', '1942-10-11', '170_Flinders_Street_,Melbourne,Victoria,3000', '1445322009', '1338723111', 'Department of Design', 'Senior Vice President'),
(5, 'Min-hen', 'Law', '2015-02-13', '33/google', '12321312', '38938', 'Department of Design', 'Producer'),
(6, 'Kang', 'Ho', '1770-04-14', '43/9 string street ', '0', '0', 'Department of System admin', 'System Engeineer'),
(7, 'Matter1', 'Kai', '2015-04-20', '29/433 Sprint street', '433777094', '433777040', 'Department of Design', 'Senior Vice President'),
(8, 'Matter2', 'Kai', '2015-04-20', '29/433 Sprint street', '433777094', '433777040', 'Department of Design', 'Senior Vice President'),
(9, 'Matter3', 'Kai', '2015-04-20', '29/433 Sprint street', '433777094', '433777040', 'Department of Design', 'Senior Vice President'),
(10, 'Matter4', 'Kai', '2015-04-20', '29/433 Sprint street', '433777094', '433777040', 'Department of Design', 'Senior Vice President'),
(11, 'Matter5', 'Kai', '2015-04-20', '29/433 Sprint street', '433777094', '433777040', 'Department of Design', 'Senior Vice President'),
(12, 'Matter6', 'Kai', '2015-04-20', '29/433 Sprint street', '433777094', '433777040', 'Department of Design', 'Senior Vice President');

--
-- 触发器 `employees`
--
DROP TRIGGER IF EXISTS `countEmployeeId`;
DELIMITER //
CREATE TRIGGER `countEmployeeId` BEFORE INSERT ON `employees`
 FOR EACH ROW SET @autonumber = ( SELECT AUTO_INCREMENT FROM information_schema.tables
WHERE table_name =  'employees' )
//
DELIMITER ;
DROP TRIGGER IF EXISTS `newLoginempId`;
DELIMITER //
CREATE TRIGGER `newLoginempId` AFTER INSERT ON `employees`
 FOR EACH ROW insert into login (empId) values ((SELECT @autonumber) )
//
DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `groupEmployee`
--

CREATE TABLE IF NOT EXISTS `groupEmployee` (
  `groupId` int(11) NOT NULL,
  `empId` int(11) NOT NULL,
  PRIMARY KEY (`groupId`,`empId`),
  KEY `empId` (`empId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `groupId` int(11) NOT NULL,
  `groupTittle` varchar(255) NOT NULL,
  PRIMARY KEY (`groupId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `loginId` int(255) NOT NULL AUTO_INCREMENT,
  `emailAddress` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `authLevel` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `empId` int(11) NOT NULL,
  PRIMARY KEY (`loginId`,`empId`),
  KEY `empId` (`empId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `login`
--

INSERT INTO `login` (`loginId`, `emailAddress`, `password`, `authLevel`, `photo`, `empId`) VALUES
(1, 'gzcisco720@gmail.com', 'e30c2debe560ee31f9c8d356ef080610', 'A', 'img/ive_hero20110204.png', 1),
(2, 'admin@iphealth.com', '21232f297a57a5a743894a0e4a801fc3', 'A', 'img/cook_hero.png', 2),
(3, 'hrmanager@iphealth.com', 'cc501ce6cd4e21d3fa81134e6e2eed81', 'H', 'img/ive_hero20110204.png', 3),
(4, 'staff@iphealth.com', 'c4ca4238a0b923820dcc509a6f75849b', 'S', 'img/13amitabh-bachchan1.jpg', 4),
(5, 'aa@aa.com', 'c4ca4238a0b923820dcc509a6f75849b', 'A', 'img/ive_hero20110204.png', 5),
(6, 'ee@ee.com', 'c4ca4238a0b923820dcc509a6f75849b', 'E', 'img/13amitabh-bachchan1.jpg', 6),
(7, 'admin1@mobile.com', '1', 'A', 'img/13amitabh-bachchan1.jpg', 7),
(8, 'admin2@mobile.com', '1', 'A', 'img/13amitabh-bachchan1.jpg', 8),
(9, 'admin3@mobile.com', '1', 'A', 'img/13amitabh-bachchan1.jpg', 9),
(10, 'admin4@mobile.com', '1', 'A', 'img/13amitabh-bachchan1.jpg', 10),
(11, 'admin5@mobile.com', '1', 'A', 'img/13amitabh-bachchan1.jpg', 11),
(12, 'admin6@mobile.com', '1', 'A', 'img/13amitabh-bachchan1.jpg', 12);

-- --------------------------------------------------------

--
-- 表的结构 `loginLog`
--

CREATE TABLE IF NOT EXISTS `loginLog` (
  `logId` int(11) NOT NULL AUTO_INCREMENT,
  `empId` int(11) NOT NULL,
  `loginTime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`logId`,`empId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `loginLog`
--

INSERT INTO `loginLog` (`logId`, `empId`, `loginTime`) VALUES
(1, 1, '2015-04-20 18:18:09');

-- --------------------------------------------------------

--
-- 表的结构 `performanceData`
--

CREATE TABLE IF NOT EXISTS `performanceData` (
  `performanceDataId` int(11) NOT NULL AUTO_INCREMENT,
  `empId` int(11) NOT NULL,
  `performanceInfoId` int(11) NOT NULL,
  `performanceRecordTime` datetime DEFAULT NULL,
  `performanceDataStatu` varchar(255) DEFAULT NULL,
  `performanceData` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`performanceDataId`,`empId`,`performanceInfoId`),
  KEY `empId` (`empId`),
  KEY `performanceInfoId` (`performanceInfoId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- 转存表中的数据 `performanceData`
--

INSERT INTO `performanceData` (`performanceDataId`, `empId`, `performanceInfoId`, `performanceRecordTime`, `performanceDataStatu`, `performanceData`) VALUES
(1, 1, 1, '2015-04-22 00:00:00', 'accepted', 10),
(2, 2, 1, '2015-04-22 00:00:00', 'accepted', 20),
(3, 3, 1, '2015-04-22 00:00:00', 'accepted', 10),
(4, 4, 1, '2015-04-22 00:00:00', 'accepted', 10),
(5, 5, 1, '2015-04-22 00:00:00', 'accepted', 10),
(6, 6, 1, '2015-04-22 00:00:00', 'accepted', 10),
(7, 7, 1, '2015-04-22 00:00:00', 'accepted', 10),
(8, 8, 1, '2015-04-22 00:00:00', 'accepted', 10),
(9, 7, 2, '2015-04-22 00:00:00', 'accepted', 40),
(11, 6, 2, '2015-04-22 00:00:00', 'accepted', 10),
(12, 5, 2, '2015-04-22 00:00:00', 'accepted', 20),
(13, 4, 2, '2015-04-22 00:00:00', 'accepted', 10),
(14, 3, 2, '2015-04-22 00:00:00', 'accepted', 20),
(15, 2, 2, '2015-04-22 00:00:00', 'accepted', 30),
(16, 1, 2, '2015-04-22 00:00:00', 'accepted', 40),
(17, 8, 2, '2015-04-22 00:00:00', 'accepted', 10),
(18, 9, 2, '2015-04-22 00:00:00', 'accepted', 20),
(19, 10, 2, '2015-04-22 00:00:00', 'accepted', 40),
(20, 11, 2, '2015-04-22 00:00:00', 'accepted', 10),
(21, 12, 2, '2015-04-22 00:00:00', 'accepted', 10),
(22, 1, 3, '2015-04-22 00:00:00', 'accepted', 10),
(23, 2, 3, '2015-04-22 00:00:00', 'accepted', 20),
(24, 3, 3, '2015-04-22 00:00:00', 'accepted', 10),
(25, 4, 3, '2015-04-22 00:00:00', 'accepted', 20),
(26, 5, 3, '2015-04-22 00:00:00', 'accepted', 30),
(27, 6, 3, '2015-04-22 00:00:00', 'accepted', 40),
(28, 7, 3, '2015-04-22 00:00:00', 'accepted', 10),
(29, 8, 3, '2015-04-22 00:00:00', 'accepted', 20),
(30, 9, 3, '2015-04-22 00:00:00', 'accepted', 40),
(31, 10, 3, '2015-04-22 00:00:00', 'accepted', 10),
(32, 11, 3, '2015-04-22 00:00:00', 'accepted', 10),
(33, 12, 3, '2015-04-22 00:00:00', 'accepted', 10),
(34, 9, 1, '2015-04-22 00:00:00', 'accepted', 40),
(35, 10, 1, '2015-04-22 00:00:00', 'accepted', 10),
(36, 11, 1, '2015-04-22 00:00:00', 'accepted', 10),
(37, 12, 1, '2015-04-22 00:00:00', 'accepted', 10),
(38, 1, 4, '2015-04-22 00:00:00', 'accepted', 10),
(39, 2, 4, '2015-04-22 00:00:00', 'accepted', 20),
(40, 3, 4, '2015-04-22 00:00:00', 'accepted', 50),
(41, 4, 4, '2015-04-22 00:00:00', 'accepted', 10),
(42, 5, 4, '2015-04-22 00:00:00', 'accepted', 20),
(43, 6, 4, '2015-04-22 00:00:00', 'accepted', 40),
(44, 7, 4, '2015-04-22 00:00:00', 'accepted', 10),
(45, 8, 4, '2015-04-22 00:00:00', 'accepted', 20),
(46, 9, 4, '2015-04-22 00:00:00', 'accepted', 40),
(47, 10, 4, '2015-04-22 00:00:00', 'accepted', 10),
(48, 11, 4, '2015-04-22 00:00:00', 'accepted', 10),
(49, 12, 4, '2015-04-22 00:00:00', 'accepted', 10),
(50, 1, 5, '2015-04-22 00:00:00', 'accepted', 10),
(51, 2, 5, '2015-04-22 00:00:00', 'accepted', 20),
(52, 3, 5, '2015-04-22 00:00:00', 'accepted', 10),
(53, 4, 5, '2015-04-22 00:00:00', 'accepted', 20),
(54, 5, 5, '2015-04-22 00:00:00', 'accepted', 30),
(55, 6, 5, '2015-04-22 00:00:00', 'accepted', 40),
(56, 7, 5, '2015-04-22 00:00:00', 'accepted', 10),
(57, 8, 5, '2015-04-22 00:00:00', 'accepted', 20),
(58, 9, 5, '2015-04-22 00:00:00', 'accepted', 40),
(59, 10, 5, '2015-04-22 00:00:00', 'accepted', 10),
(60, 11, 5, '2015-04-22 00:00:00', 'accepted', 10),
(61, 12, 5, '2015-04-22 00:00:00', 'accepted', 10);

-- --------------------------------------------------------

--
-- 表的结构 `performanceInfo`
--

CREATE TABLE IF NOT EXISTS `performanceInfo` (
  `performanceInfoId` int(11) NOT NULL AUTO_INCREMENT,
  `performanceTypeName` varchar(255) DEFAULT NULL,
  `performanceRate` int(11) DEFAULT NULL,
  `performanceGoal` varchar(255) DEFAULT NULL,
  `performanceBaseLine` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`performanceInfoId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `performanceInfo`
--

INSERT INTO `performanceInfo` (`performanceInfoId`, `performanceTypeName`, `performanceRate`, `performanceGoal`, `performanceBaseLine`) VALUES
(1, 'passedStudents', NULL, NULL, NULL),
(2, 'totalStudents', NULL, NULL, NULL),
(3, 'publishedPaper', NULL, NULL, NULL),
(4, 'sitedPaper', NULL, NULL, NULL),
(5, 'phdStudents', NULL, NULL, NULL),
(6, 'totalResearchHour', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `roleEmployee`
--

CREATE TABLE IF NOT EXISTS `roleEmployee` (
  `roleId` int(11) NOT NULL,
  `empId` int(11) NOT NULL,
  PRIMARY KEY (`roleId`,`empId`),
  KEY `empId` (`empId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `roleId` int(11) NOT NULL,
  `roleTittle` varchar(255) NOT NULL,
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `timeTrackerData`
--

CREATE TABLE IF NOT EXISTS `timeTrackerData` (
  `timeTrackerDataId` int(11) NOT NULL AUTO_INCREMENT,
  `empId` int(11) NOT NULL,
  `timeTrackerInfoId` int(11) NOT NULL,
  `timeTrackerRecordTime` datetime DEFAULT NULL,
  `timeTrackerStatu` varchar(255) DEFAULT NULL,
  `timeTrackerData` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`timeTrackerDataId`,`empId`,`timeTrackerInfoId`),
  KEY `empId` (`empId`),
  KEY `timeTrackerInfoId` (`timeTrackerInfoId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `timeTrackerData`
--

INSERT INTO `timeTrackerData` (`timeTrackerDataId`, `empId`, `timeTrackerInfoId`, `timeTrackerRecordTime`, `timeTrackerStatu`, `timeTrackerData`) VALUES
(1, 1, 1, '2015-04-22 00:00:00', 'accepted', 30),
(2, 2, 1, '2015-04-22 00:00:00', 'accepted', 40),
(3, 3, 1, '2015-04-22 00:00:00', 'accepted', 40),
(4, 4, 1, '2015-04-22 00:00:00', 'accepted', 40),
(5, 5, 1, '2015-04-22 00:00:00', 'accepted', 40),
(6, 6, 1, '2015-04-22 00:00:00', 'accepted', 40),
(7, 7, 1, '2015-04-22 00:00:00', 'accepted', 40),
(8, 8, 1, '2015-04-22 00:00:00', 'accepted', 40),
(9, 7, 2, '2015-04-22 00:00:00', 'accepted', 40),
(11, 6, 2, '2015-04-22 00:00:00', 'accepted', 10),
(12, 5, 2, '2015-04-22 00:00:00', 'accepted', 20),
(13, 4, 2, '2015-04-22 00:00:00', 'accepted', 10),
(14, 3, 2, '2015-04-22 00:00:00', 'accepted', 20),
(15, 2, 2, '2015-04-22 00:00:00', 'accepted', 30),
(16, 1, 2, '2015-04-22 00:00:00', 'accepted', 40),
(17, 8, 2, '2015-04-22 00:00:00', 'accepted', 10),
(18, 9, 2, '2015-04-22 00:00:00', 'accepted', 20),
(19, 10, 2, '2015-04-22 00:00:00', 'accepted', 40),
(20, 11, 2, '2015-04-22 00:00:00', 'accepted', 10),
(21, 12, 2, '2015-04-22 00:00:00', 'accepted', 10),
(22, 1, 3, '2015-04-22 00:00:00', 'accepted', 10),
(23, 2, 3, '2015-04-22 00:00:00', 'accepted', 20),
(24, 3, 3, '2015-04-22 00:00:00', 'accepted', 10),
(25, 4, 3, '2015-04-22 00:00:00', 'accepted', 20),
(26, 5, 3, '2015-04-22 00:00:00', 'accepted', 30),
(27, 6, 3, '2015-04-22 00:00:00', 'accepted', 40),
(28, 7, 3, '2015-04-22 00:00:00', 'accepted', 10),
(29, 8, 3, '2015-04-22 00:00:00', 'accepted', 20),
(30, 9, 3, '2015-04-22 00:00:00', 'accepted', 40),
(31, 10, 3, '2015-04-22 00:00:00', 'accepted', 10),
(32, 11, 3, '2015-04-22 00:00:00', 'accepted', 10),
(33, 12, 3, '2015-04-22 00:00:00', 'accepted', 10);

-- --------------------------------------------------------

--
-- 表的结构 `timeTrackerInfo`
--

CREATE TABLE IF NOT EXISTS `timeTrackerInfo` (
  `timeTrackerInfoId` int(11) NOT NULL AUTO_INCREMENT,
  `timeTrackerTypeName` varchar(255) DEFAULT NULL,
  `timeTrackerRate` int(11) DEFAULT NULL,
  PRIMARY KEY (`timeTrackerInfoId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `timeTrackerInfo`
--

INSERT INTO `timeTrackerInfo` (`timeTrackerInfoId`, `timeTrackerTypeName`, `timeTrackerRate`) VALUES
(1, 'totalWorkingHour', NULL),
(2, 'totalTeachingHour', NULL),
(3, 'totalResearchHour', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `userInfo`
--

CREATE TABLE IF NOT EXISTS `userInfo` (
  `infoId` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) DEFAULT '',
  `lastname` varchar(50) DEFAULT '',
  `birthday` date DEFAULT NULL,
  `address` varchar(150) DEFAULT '',
  `phone1` varchar(15) DEFAULT '0',
  `phone2` varchar(15) DEFAULT '0',
  `userId` int(11) NOT NULL,
  `position` varchar(45) DEFAULT NULL,
  `department` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`infoId`,`userId`),
  UNIQUE KEY `infoId` (`infoId`),
  KEY `userId` (`userId`),
  KEY `userId_2` (`userId`),
  KEY `phone2` (`phone2`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `userInfo`
--

INSERT INTO `userInfo` (`infoId`, `firstname`, `lastname`, `birthday`, `address`, `phone1`, `phone2`, `userId`, `position`, `department`) VALUES
(1, 'Jonathan', 'Ive', '1980-09-09', 'Russell Street', 2147483647, 1336223232, 1, 'Senior Vice President', 'Department of Design'),
(2, 'Tim', 'Cook', '1960-09-09', '172_La_Trobe_Street_,Melbourne,Victoria,3000', 2147483647, 1234567890, 2, 'CEO of Apple Inc', 'Board'),
(3, 'Jonathan', 'Ive', '1966-03-02', '156_Exhibition_Street_,Melbourne,Victoria,3000', 1403329982, 1336223232, 3, 'Senior Vice President', 'Department of Design'),
(4, 'Amitabh', 'Bachchan', '1942-10-11', '170_Flinders_Street_,Melbourne,Victoria,3000', 1445322009, 1338723111, 4, 'Producer', 'Department of Art'),
(5, 'Min-hen', 'Law', '2015-02-13', '33/google', 12321312, 38938, 5, 'Producer', 'sdfasdf'),
(6, 'Kang', 'Ho', '1770-04-14', '43/9 string street ', 0, 0, 6, 'System Engeineer ', 'fdsa'),
(7, 'Matter', 'Kai', '2015-04-20', '29/433 Sprint street', 433777094, 433777040, 7, 'System Engeineer ', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL DEFAULT '',
  `permission` varchar(10) NOT NULL DEFAULT 'E',
  `photo` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `permission`, `photo`) VALUES
(1, 'gzcisco720@gmail.com', 'e30c2debe560ee31f9c8d356ef080610', 'A', 'img/ive_hero20110204.png'),
(2, 'admin@iphealth.com', '21232f297a57a5a743894a0e4a801fc3', 'A', 'img/cook_hero.png'),
(3, 'hrmanager@iphealth.com', 'cc501ce6cd4e21d3fa81134e6e2eed81', 'H', 'img/ive_hero20110204.png'),
(4, 'staff@iphealth.com', 'c4ca4238a0b923820dcc509a6f75849b', 'S', 'img/13amitabh-bachchan1.jpg'),
(5, 'aa@aa.com', 'c4ca4238a0b923820dcc509a6f75849b', 'A', 'img/ive_hero20110204.png'),
(6, 'ee@ee.com', 'c4ca4238a0b923820dcc509a6f75849b', 'E', 'img/13amitabh-bachchan1.jpg'),
(7, 'admin@mobile.com', '1', 'A', 'img/13amitabh-bachchan1.jpg');

--
-- 限制导出的表
--

--
-- 限制表 `groupEmployee`
--
ALTER TABLE `groupEmployee`
  ADD CONSTRAINT `employee_has_group` FOREIGN KEY (`empId`) REFERENCES `employees` (`empId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_has_employee` FOREIGN KEY (`groupId`) REFERENCES `groups` (`groupId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `employee_has_loginId_fk1` FOREIGN KEY (`empId`) REFERENCES `employees` (`empId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `performanceData`
--
ALTER TABLE `performanceData`
  ADD CONSTRAINT `performanceDataInfoLink` FOREIGN KEY (`performanceInfoId`) REFERENCES `performanceInfo` (`performanceInfoId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `performanceEmployeeLink` FOREIGN KEY (`empId`) REFERENCES `employees` (`empId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `roleEmployee`
--
ALTER TABLE `roleEmployee`
  ADD CONSTRAINT `employee_has_ role` FOREIGN KEY (`empId`) REFERENCES `employees` (`empId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_has_employee` FOREIGN KEY (`roleId`) REFERENCES `roles` (`roleId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `timeTrackerData`
--
ALTER TABLE `timeTrackerData`
  ADD CONSTRAINT `timeTracker_has_employeeId` FOREIGN KEY (`empId`) REFERENCES `employees` (`empId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `timeTracker_has_infoId` FOREIGN KEY (`timeTrackerInfoId`) REFERENCES `timeTrackerInfo` (`timeTrackerInfoId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `userInfo`
--
ALTER TABLE `userInfo`
  ADD CONSTRAINT `userinfo_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
