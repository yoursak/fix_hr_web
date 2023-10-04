-- Adminer 4.7.8 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `login_admin`;
CREATE TABLE `login_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `country_code` varchar(5) DEFAULT NULL,
  `phone` varchar(225) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `is_verified` tinyint(1) DEFAULT NULL,
  `api_token` longtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `login_admin` (`id`, `business_id`, `name`, `email`, `country_code`, `phone`, `otp`, `otp_created_at`, `is_verified`, `api_token`, `created_at`, `updated_at`) VALUES
(1,	'e3d64177e51bdff82b499e116796fe74',	'Aman Sahu',	'amansahu.er@gmail.com',	'+91',	'831915176',	'870600',	'2023-10-04 06:09:30',	1,	'4|vha3HWR0D4IKuLm6qTzZ5XJPZV5l6h8qwvAO6E1135446570',	'0000-00-00 00:00:00',	'2023-10-04 11:39:30'),
(10,	'e3d64177e51bdff82b499e116796fe74',	'Umesh Sahu',	'cpictogram@gmail.com',	'+91',	'6266043320',	NULL,	NULL,	0,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(11,	'e3d64177e51bdff82b499e116796fe74',	'Nisha Sahu',	'nishasahu018@gmail.com',	'+91',	'9993433474',	'101480',	'2023-09-27 04:45:23',	1,	NULL,	'0000-00-00 00:00:00',	'2023-09-27 10:15:23'),
(12,	'e3d64177e51bdff82b499e116796fe74',	'Dilip Sahu',	'dilipsahu26@gmail.com',	'+91',	'1234567890',	'919899',	'2023-10-03 19:08:26',	1,	NULL,	'0000-00-00 00:00:00',	'2023-10-04 00:38:26'),
(13,	'bd545732e12addf17c34a231d24a3814',	'Dilip Sahu',	'dilipsahu26@gmail.com',	'+91',	'9993659548',	NULL,	NULL,	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00');

-- 2023-10-04 06:11:33
