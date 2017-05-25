-- Adminer 4.2.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `biomine`;
CREATE DATABASE `biomine` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `biomine`;


DROP TABLE IF EXISTS `DbCache`;
CREATE TABLE `DbCache` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `Type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Key` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Value1` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Value2` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Type` (`Type`),
  KEY `Key` (`Key`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `ErrorLog`;
CREATE TABLE `ErrorLog` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `RequestId` bigint(20) NOT NULL,
  `Time` datetime NOT NULL,
  `ErrorType` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `StackTrace` varchar(8192) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CredentialHash` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL,
  `UserType` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USER',
  `Email` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IsEmailVerified` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `User` (`id`, `UserName`, `CredentialHash`, `UserType`, `Email`, `IsEmailVerified`) VALUES
(10000,	'biomine',	'$2a$10$y2WBt18nYovbxTOgpwmjdunSOe7/ecrKBMZX0FXXwPAJRdbwevn8e',	'ADMIN',	NULL,	0);

-- 2016-10-02 13:21:00
