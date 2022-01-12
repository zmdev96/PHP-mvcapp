-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 12, 2022 at 04:01 PM
-- Server version: 8.0.27-0ubuntu0.20.04.1
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvcapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

CREATE TABLE `app_users` (
  `UserId` int UNSIGNED NOT NULL,
  `Username` varchar(24) NOT NULL,
  `Firstname` varchar(60) NOT NULL,
  `Lastname` varchar(60) NOT NULL,
  `Password` char(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Email` varchar(60) NOT NULL,
  `SubscriptionDate` date NOT NULL,
  `LastUpdate` datetime NOT NULL,
  `LastLogin` datetime NOT NULL,
  `GroupId` tinyint UNSIGNED NOT NULL,
  `Status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_users`
--

INSERT INTO `app_users` (`UserId`, `Username`, `Firstname`, `Lastname`, `Password`, `Email`, `SubscriptionDate`, `LastUpdate`, `LastLogin`, `GroupId`, `Status`) VALUES
(1, 'admin', 'Admin', 'Test', '$2a$07$yeNCSNwRpYopOhv0TrrReOfePkToEwmNKagsCYcwX3XoXYyElzR7y', 'admin@test.com', '2021-11-12', '2021-11-12 10:16:43', '2021-11-12 10:16:43', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_users_group`
--

CREATE TABLE `app_users_group` (
  `GroupId` tinyint UNSIGNED NOT NULL,
  `GroupName` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_users_group`
--

INSERT INTO `app_users_group` (`GroupId`, `GroupName`) VALUES
(1, 'Adminstration');

-- --------------------------------------------------------

--
-- Table structure for table `app_users_groups_privileges`
--

CREATE TABLE `app_users_groups_privileges` (
  `Id` tinyint UNSIGNED NOT NULL,
  `GroupId` tinyint UNSIGNED NOT NULL,
  `PrivilegeId` tinyint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_users_groups_privileges`
--

INSERT INTO `app_users_groups_privileges` (`Id`, `GroupId`, `PrivilegeId`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `app_users_privileges`
--

CREATE TABLE `app_users_privileges` (
  `PrivilegeId` tinyint UNSIGNED NOT NULL,
  `Privilege` varchar(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `app_users_privileges`
--

INSERT INTO `app_users_privileges` (`PrivilegeId`, `Privilege`) VALUES
(1, 'Create new user'),
(2, 'Create new user');

-- --------------------------------------------------------

--
-- Table structure for table `app_users_profiles`
--

CREATE TABLE `app_users_profiles` (
  `UserId` int UNSIGNED NOT NULL,
  `FirstName` varchar(24) NOT NULL,
  `LastName` varchar(24) NOT NULL,
  `Country` varchar(24) NOT NULL,
  `City` varchar(24) NOT NULL,
  `Address` varchar(60) NOT NULL,
  `PostalCode` tinyint NOT NULL,
  `DateOfBirth` date NOT NULL,
  `About` varchar(255) NOT NULL,
  `Image` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_users`
--
ALTER TABLE `app_users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `UserGroup` (`GroupId`);

--
-- Indexes for table `app_users_group`
--
ALTER TABLE `app_users_group`
  ADD PRIMARY KEY (`GroupId`);

--
-- Indexes for table `app_users_groups_privileges`
--
ALTER TABLE `app_users_groups_privileges`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `AppUserGroup` (`GroupId`),
  ADD KEY `AppPrivilegeGroup` (`PrivilegeId`);

--
-- Indexes for table `app_users_privileges`
--
ALTER TABLE `app_users_privileges`
  ADD PRIMARY KEY (`PrivilegeId`);

--
-- Indexes for table `app_users_profiles`
--
ALTER TABLE `app_users_profiles`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_users`
--
ALTER TABLE `app_users`
  MODIFY `UserId` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_users_group`
--
ALTER TABLE `app_users_group`
  MODIFY `GroupId` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_users_groups_privileges`
--
ALTER TABLE `app_users_groups_privileges`
  MODIFY `Id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `app_users_privileges`
--
ALTER TABLE `app_users_privileges`
  MODIFY `PrivilegeId` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `app_users_profiles`
--
ALTER TABLE `app_users_profiles`
  MODIFY `UserId` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `app_users`
--
ALTER TABLE `app_users`
  ADD CONSTRAINT `UserGroup` FOREIGN KEY (`GroupId`) REFERENCES `app_users_group` (`GroupId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `app_users_groups_privileges`
--
ALTER TABLE `app_users_groups_privileges`
  ADD CONSTRAINT `AppPrivilegeGroup` FOREIGN KEY (`PrivilegeId`) REFERENCES `app_users_privileges` (`PrivilegeId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AppUserGroup` FOREIGN KEY (`GroupId`) REFERENCES `app_users_group` (`GroupId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `app_users_profiles`
--
ALTER TABLE `app_users_profiles`
  ADD CONSTRAINT `UserProfile` FOREIGN KEY (`UserId`) REFERENCES `app_users` (`UserId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
