-- Adminer 4.7.8 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `account_setting`;
CREATE TABLE `account_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `subscriptions` varchar(100) DEFAULT NULL,
  `kyb_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `business_id` (`business_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `admin_notices`;
CREATE TABLE `admin_notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `file` longtext DEFAULT NULL,
  `business_id` longtext DEFAULT NULL,
  `branch_id` longtext DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin_notices` (`id`, `title`, `date`, `file`, `business_id`, `branch_id`, `description`, `updated_at`, `created_at`) VALUES
(14,	'Dussehra Notice',	'2023-10-24',	'04-10-2023_09912cab8e1376abc2d96f5f56bf987d.pdf',	'bd545732e12addf17c34a231d24a3814',	'',	'Exciting Bonus Announcement',	'2023-10-04 12:31:19',	'0000-00-00 00:00:00'),
(17,	'Diwali Leave 2',	'2023-11-15',	'10-10-2023_83ee562894e4d8e230c26637f17eab0c.xlsx',	'e3d64177e51bdff82b499e116796fe74',	'',	'Diwali Leave Notice',	'2023-10-10 04:53:14',	'0000-00-00 00:00:00'),
(18,	'Diwali Leave 3',	'2023-11-15',	'10-10-2023_d9eabd0b15b6a7d66d87104b8661129c.pdf',	'e3d64177e51bdff82b499e116796fe74',	'',	NULL,	'2023-10-10 04:53:37',	'0000-00-00 00:00:00'),
(19,	'Next Leave Notice',	'2023-10-17',	'10-10-2023_2ff7184653fd77b0e906fc7068e8607e.pdf',	'e3d64177e51bdff82b499e116796fe74',	'',	'Next Leave Notice',	'2023-10-10 04:54:24',	'0000-00-00 00:00:00'),
(20,	'Previous',	'2023-10-08',	'10-10-2023_52760533d30e5876f6a1752190ae7283.pdf',	'e3d64177e51bdff82b499e116796fe74',	'',	'Previous Notice',	'2023-10-10 04:59:59',	'0000-00-00 00:00:00'),
(21,	'fsdgsdfgd',	'2023-11-03',	'02-11-2023_cae4ec5aecddb5d1b038f1f612d221c9.pdf',	'e3d64177e51bdff82b499e116796fe74',	'',	'hndfgbhdfcb',	'2023-11-02 10:11:56',	'0000-00-00 00:00:00');

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `approval_management_cycle`;
CREATE TABLE `approval_management_cycle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `branch_id` longtext DEFAULT NULL,
  `department_id` longtext DEFAULT NULL,
  `desgination_id` longtext DEFAULT NULL,
  `cycle_type` tinyint(1) DEFAULT NULL,
  `role_id` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`role_id`)),
  `checked_status` tinyint(1) NOT NULL DEFAULT 1,
  `initial_status` tinyint(1) NOT NULL DEFAULT 0,
  `current_status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `attendance_list`;
CREATE TABLE `attendance_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `working_from_method` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  `method_auto` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  `method_manual` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  `marked_in_mode` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  `marked_out_mode` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  `active_qr_mode` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  `active_selfie_mode` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  `active_face_mode` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  `active_location_tab_mode` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  `attendance_status` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  `attendance_shift` varchar(255) DEFAULT NULL,
  `punch_date` date DEFAULT NULL,
  `emp_id` varchar(255) DEFAULT NULL,
  `business_id` varchar(255) DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `emp_today_current_status` varchar(255) DEFAULT NULL,
  `punch_in_selfie` longtext DEFAULT NULL,
  `punch_in_time` time DEFAULT '00:00:00',
  `punch_in_location_tag` varchar(255) DEFAULT NULL,
  `punch_in_address` varchar(255) DEFAULT NULL,
  `punch_in_latitude` varchar(255) DEFAULT NULL,
  `punch_in_longitude` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `punch_out_selfie` longtext DEFAULT NULL,
  `punch_out_time` time DEFAULT '00:00:00',
  `punch_out_address` varchar(255) DEFAULT NULL,
  `punch_out_latitude` varchar(255) DEFAULT NULL,
  `punch_out_longitude` varchar(255) DEFAULT NULL,
  `punch_out_location_tag` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `total_working_hour` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `attendance_list` (`id`, `working_from_method`, `method_auto`, `method_manual`, `marked_in_mode`, `marked_out_mode`, `active_qr_mode`, `active_selfie_mode`, `active_face_mode`, `active_location_tab_mode`, `attendance_status`, `attendance_shift`, `punch_date`, `emp_id`, `business_id`, `branch_id`, `emp_today_current_status`, `punch_in_selfie`, `punch_in_time`, `punch_in_location_tag`, `punch_in_address`, `punch_in_latitude`, `punch_in_longitude`, `punch_out_selfie`, `punch_out_time`, `punch_out_address`, `punch_out_latitude`, `punch_out_longitude`, `punch_out_location_tag`, `total_working_hour`, `created_at`, `updated_at`) VALUES
(34,	1,	0,	0,	0,	0,	0,	1,	0,	0,	1,	NULL,	'2023-09-30',	'IT010',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'12-10-2023_6aaa2c1c7dd6e84d92361626b346a6d0.jpg',	'09:00:00',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896106',	'81.6236888',	'28-09-2023_f9d2f832006a6f5afe263dfb32a5d3d3.jpg',	'18:00:00',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	NULL,	NULL,	NULL,	'09:10:00',	'2023-10-31 07:59:11',	'2023-10-12 17:18:40'),
(35,	1,	0,	0,	0,	0,	0,	1,	0,	0,	1,	NULL,	'2023-10-09',	'IT010',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'16-10-2023_4402de8dc6f1943c696f38ecd7506b28.jpg',	'09:48:08',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896371',	'81.6236837',	NULL,	'17:48:08',	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-16 16:48:09'),
(37,	1,	0,	0,	0,	0,	0,	1,	0,	0,	1,	NULL,	'2023-10-05',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'17-10-2023_6a3f31964e04f41b064ceb356547d1e4.jpg',	'10:00:20',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896224',	'81.6236877',	NULL,	'04:00:20',	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-17 12:00:21'),
(38,	1,	0,	0,	0,	0,	0,	1,	0,	0,	1,	NULL,	'2023-10-17',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'17-10-2023_a1a3a44cfbd6650d2e6d6e98d595ac95.jpg',	'12:00:38',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896319',	'81.6236855',	NULL,	'01:00:38',	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-17 12:00:39'),
(39,	1,	0,	0,	0,	0,	0,	1,	0,	0,	0,	NULL,	'2023-10-13',	'IT010',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'12-10-2023_6aaa2c1c7dd6e84d92361626b346a6d0.jpg',	'11:00:00',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896106',	'81.6236888',	NULL,	'18:20:00',	NULL,	NULL,	NULL,	NULL,	'04:10:00',	'2023-10-31 07:59:11',	'2023-10-12 17:18:40'),
(40,	1,	0,	0,	0,	0,	0,	1,	0,	0,	0,	NULL,	'2023-10-11',	'IT010',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'12-10-2023_6aaa2c1c7dd6e84d92361626b346a6d0.jpg',	'08:40:00',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896106',	'81.6236888',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'09:10:00',	'2023-10-31 07:59:11',	'2023-10-12 17:18:40'),
(41,	1,	0,	0,	0,	0,	0,	1,	0,	0,	1,	'68',	'2023-10-16',	'IT010',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'12-10-2023_6aaa2c1c7dd6e84d92361626b346a6d0.jpg',	'09:20:00',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896106',	'81.6236888',	NULL,	'18:50:00',	NULL,	NULL,	NULL,	NULL,	'09:30:00',	'2023-10-31 07:59:11',	'2023-10-12 17:18:40'),
(42,	1,	0,	0,	0,	0,	0,	1,	0,	0,	1,	'68',	'2023-10-18',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'18-10-2023_517ffc3646ccb8bf87ea9efccad8a867.jpg',	'11:59:59',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896349',	'81.6236796',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-18 17:33:36'),
(43,	1,	0,	0,	0,	0,	0,	1,	0,	0,	1,	'68',	'2023-10-18',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'18-10-2023_9fa4bb87e6ff79f106466b3af75336bb.png',	'17:41:03',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896774',	'81.6236399',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-18 17:43:06'),
(44,	1,	0,	0,	0,	0,	0,	1,	0,	0,	1,	'68',	'2023-10-18',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'18-10-2023_9fa4bb87e6ff79f106466b3af75336bb.png',	'17:41:03',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896774',	'81.6236399',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-18 17:57:35'),
(45,	1,	0,	0,	0,	0,	0,	1,	0,	0,	1,	'68',	'2023-10-18',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'18-10-2023_54545722f5bccb0f50ec1278c425cafa.jpg',	'18:00:17',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896773',	'81.623636',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-18 18:00:19'),
(47,	1,	0,	0,	0,	0,	0,	1,	0,	0,	1,	'68',	'2023-10-10',	'IT010',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'12-10-2023_6aaa2c1c7dd6e84d92361626b346a6d0.jpg',	'13:40:02',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896106',	'81.6236888',	NULL,	'18:00:00',	NULL,	NULL,	NULL,	NULL,	'04:10:00',	'2023-10-31 07:59:11',	'2023-10-12 17:18:40'),
(48,	1,	0,	0,	0,	0,	0,	1,	0,	0,	1,	'68',	'2023-10-17',	'IT010',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'12-10-2023_6aaa2c1c7dd6e84d92361626b346a6d0.jpg',	'10:00:00',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896106',	'81.6236888',	NULL,	'18:10:00',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	NULL,	NULL,	NULL,	'09:10:00',	'2023-10-31 07:59:11',	'2023-10-12 17:18:40'),
(67,	1,	0,	1,	0,	0,	1,	0,	0,	0,	0,	'68',	'2023-10-19',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	NULL,	'23:54:49',	NULL,	'7J7F+92F, , Raipur Division, 492001',	'21.2634089',	'81.6229431',	NULL,	'23:57:57',	'7J7F+92F, , Raipur Division, 492001',	'21.2634089',	'81.6229431',	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-19 23:54:49'),
(70,	1,	0,	1,	0,	0,	1,	0,	0,	0,	1,	'68',	'2023-10-20',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	NULL,	'00:11:00',	NULL,	'7J7F+92F, , Raipur Division, 492001',	'21.2634073',	'81.6229435',	NULL,	'10:17:00',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896901',	'81.6236308',	NULL,	'10:06:00',	'2023-10-31 07:59:11',	'2023-10-20 00:11:11'),
(155,	1,	0,	1,	3,	1,	0,	1,	0,	0,	0,	'68',	'2023-10-23',	'IT010',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'23-10-2023_80f8baee4acbef6a871d422c04ebd8d7.png',	'10:01:11',	NULL,	'Jay',	'21.111245',	'81.152525',	NULL,	'10:55:11',	'adsd sd',	'21.1255',	'82.1222',	NULL,	'00:54:00',	'2023-10-31 07:59:11',	'2023-10-23 23:06:30'),
(156,	1,	0,	1,	3,	1,	0,	1,	0,	0,	1,	'68',	'2023-10-23',	'IT0012',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'23-10-2023_bd12b180fdf7cb7047f4fddcf4af2e70.png',	'10:01:11',	NULL,	'Jay',	'21.111245',	'81.152525',	NULL,	'10:55:11',	'adsd sd',	'21.1255',	'82.1222',	NULL,	'00:54:00',	'2023-10-31 07:59:11',	'2023-10-23 23:21:37'),
(157,	1,	0,	1,	1,	3,	1,	0,	0,	0,	1,	'68',	'2023-10-23',	'IT008',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	NULL,	'10:01:11',	NULL,	'Jay',	'21.111245',	'81.152525',	'23-10-2023_403379d73aa9ae97d8a9cae6a3241bd7.png',	'10:55:11',	'adsd sd',	'21.1255',	'82.1222',	NULL,	'00:54:00',	'2023-10-31 07:59:11',	'2023-10-23 23:28:16'),
(173,	1,	0,	1,	3,	3,	0,	1,	0,	0,	0,	'68',	'2023-10-25',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'25-10-2023_8bd1eab5484d21b52d6db254b6054508.jpg',	'15:17:27',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896911',	'81.6236483',	'25-10-2023_2967aa13e56ebbf5820dbffa22facd91.jpg',	'18:52:34',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896879',	'81.6236558',	NULL,	'03:35:07',	'2023-10-31 07:59:11',	'2023-10-25 15:17:29'),
(175,	1,	0,	1,	3,	3,	0,	1,	0,	0,	1,	'84',	'2023-10-25',	'IT119',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'25-10-2023_c6b67069f3b3338e6d72758015cd5d69.jpg',	'09:41:00',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896881',	'81.6236544',	'25-10-2023_3ec081e32ffbaa60b2198e8ef3e9c57e.jpg',	'17:30:00',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896898',	'81.6236505',	NULL,	'07:49:00',	'2023-10-31 07:59:11',	'2023-10-25 16:40:54'),
(179,	1,	0,	1,	3,	3,	0,	1,	0,	0,	0,	'68',	'2023-10-25',	'IT0012',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'25-10-2023_2f2dcba346ce20f4a6d1ea738398a6dc.jpg',	'23:56:21',	NULL,	'7J7F+92F, , Raipur Division, 492001',	'21.2633997',	'81.6229689',	'25-10-2023_e4c105f9c1a134d1380d1e0aee47b0e7.jpg',	'23:56:47',	'7J7F+92F, , Raipur Division, 492001',	'21.2634006',	'81.6229679',	NULL,	'00:00:26',	'2023-10-31 07:59:11',	'2023-10-25 23:56:22'),
(182,	1,	0,	1,	3,	3,	0,	1,	0,	0,	0,	'68',	'2023-10-26',	'IT010',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'26-10-2023_f8fd064c62294bc7e996a269e1bf6f70.jpg',	'00:46:11',	NULL,	'7J7F+92F, , Raipur Division, 492001',	'21.2633969',	'81.6229659',	'26-10-2023_e827f21d87b54ea1fa6a804556af1c4c.jpg',	'00:46:29',	'7J7F+92F, , Raipur Division, 492001',	'21.2634002',	'81.6229679',	NULL,	'00:00:18',	'2023-10-31 07:59:11',	'2023-10-26 00:46:12'),
(184,	1,	0,	1,	1,	3,	1,	0,	0,	0,	0,	'68',	'2023-10-26',	'IT0012',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	NULL,	'10:01:11',	NULL,	'Jay',	'21.111245',	'81.152525',	'26-10-2023_fbe8a25d49794be4f4a59d60fbbd4ca7.jpg',	'10:19:48',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.289688',	'81.6236521',	NULL,	'00:18:37',	'2023-10-31 07:59:11',	'2023-10-26 10:19:05'),
(185,	1,	0,	1,	3,	3,	0,	1,	0,	0,	1,	'84',	'2023-10-26',	'IT119',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'25-10-2023_c6b67069f3b3338e6d72758015cd5d69.jpg',	'16:00:00',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896881',	'81.6236544',	'25-10-2023_3ec081e32ffbaa60b2198e8ef3e9c57e.jpg',	'24:30:00',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896898',	'81.6236505',	NULL,	'24:00:00',	'2023-10-31 07:59:11',	'2023-10-25 16:40:54'),
(186,	1,	0,	1,	3,	3,	0,	1,	0,	0,	0,	'68',	'2023-10-26',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'26-10-2023_5c99ac090ae8fba317b6c2b3f8450b43.jpg',	'13:08:04',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896395',	'81.6237046',	'26-10-2023_aa52b092f8c68f06d1d770e5cae05f13.jpg',	'13:09:35',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896309',	'81.6236917',	NULL,	'00:01:31',	'2023-10-31 07:59:11',	'2023-10-26 13:08:04'),
(187,	1,	0,	1,	3,	3,	0,	1,	0,	0,	0,	'68',	'2023-10-28',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'27-10-2023_9f2927d77556ef4d27d1f12fd8a7f458.jpg',	'09:25:22',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.289687',	'81.6236554',	'27-10-2023_b67a3d95bdf8bfc922d4379392d01e90.jpg',	'17:35:18',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896878',	'81.6236557',	NULL,	'00:00:56',	'2023-10-31 07:59:11',	'2023-10-27 13:13:24'),
(188,	1,	0,	1,	1,	1,	1,	0,	0,	0,	0,	'68',	'2023-10-28',	'IT122',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	NULL,	'07:50:00',	NULL,	'Jay',	'21.111245',	'81.152525',	NULL,	'15:10:00',	'adsd hogaya hy abhe',	'21.1255',	'82.1222',	NULL,	'07:20:00',	'2023-10-31 07:59:11',	'2023-10-27 18:04:28'),
(189,	1,	0,	1,	1,	1,	1,	0,	0,	0,	0,	'68',	'2023-10-28',	'IT010',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	NULL,	'15:51:00',	NULL,	'Jay',	'21.111245',	'81.152525',	NULL,	'00:00:00',	'adsd hogaya hy abhe',	'21.1255',	'82.1222',	NULL,	'08:09:00',	'2023-10-31 07:59:11',	'2023-10-27 18:27:38'),
(190,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-10-28',	'IT0012',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'28-10-2023_dcce182ada50f51a638ec487b982498b.jpg',	'11:51:00',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896861',	'81.623655',	NULL,	'00:00:00',	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-28 11:51:05'),
(191,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-10-30',	'IT0012',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'30-10-2023_e98f79f33bd762bfe2408fd10a2d1eb3.jpg',	'11:30:33',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896294',	'81.6236877',	NULL,	'00:00:00',	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-30 10:22:33'),
(192,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-10-30',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'30-10-2023_7ed29e9c6b7655b81c9259f7a162b247.jpg',	'11:39:39',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896847',	'81.6236568',	NULL,	'00:00:00',	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-30 11:39:44'),
(194,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-10-30',	'IT121',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'2',	'30-10-2023_af651dc9191276af55f8dfc111d070c5.jpg',	'09:27:15',	NULL,	'7JQC+5VG, Bhanpuri, Raipur Division, 492003',	'21.2879296',	'81.6218321',	'30-10-2023_af651dc9191276af55f8dfc111d070c5.jpg',	'18:27:15',	'7JQC+5VG, Bhanpuri, Raipur Division, 492003',	'21.2879296',	'81.6218321',	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-30 15:28:09'),
(196,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-10-29',	'IT125',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'2',	'30-10-2023_af651dc9191276af55f8dfc111d070c5.jpg',	'10:27:15',	NULL,	'7JQC+5VG, Bhanpuri, Raipur Division, 492003',	'21.2879296',	'81.6218321',	NULL,	'18:27:15',	'7JQC+5VG, Bhanpuri, Raipur Division, 492003',	'21.2879296',	'81.6218321',	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-30 15:28:09'),
(197,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-10-27',	'IT125',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'2',	'30-10-2023_af651dc9191276af55f8dfc111d070c5.jpg',	'10:27:15',	NULL,	'7JQC+5VG, Bhanpuri, Raipur Division, 492003',	'21.2879296',	'81.6218321',	NULL,	'16:27:15',	'7JQC+5VG, Bhanpuri, Raipur Division, 492003',	'21.2879296',	'81.6218321',	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-30 15:28:09'),
(198,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-10-26',	'IT125',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'2',	'30-10-2023_af651dc9191276af55f8dfc111d070c5.jpg',	'11:00:15',	NULL,	'7JQC+5VG, Bhanpuri, Raipur Division, 492003',	'21.2879296',	'81.6218321',	NULL,	'23:27:15',	'7JQC+5VG, Bhanpuri, Raipur Division, 492003',	'21.2879296',	'81.6218321',	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-30 15:28:09'),
(200,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-10-31',	'IT121',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'2',	'31-10-2023_f6339f845f1caa49bb050e39258b1d6c.jpg',	'10:12:24',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896079',	'81.6236763',	NULL,	'17:40:00',	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-31 10:12:37'),
(202,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-10-31',	'IT0012',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'31-10-2023_09f5bd5757d7818f6c8a7ef4713e86a1.jpg',	'10:50:39',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896881',	'81.6236566',	NULL,	'00:00:00',	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-31 10:50:51'),
(203,	1,	0,	1,	3,	3,	0,	1,	0,	0,	0,	'68',	'2023-10-31',	'IT020',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'2',	'31-10-2023_2804150443df3cd7ac455a717e81eb58.jpg',	'10:51:36',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2897011',	'81.6236526',	'31-10-2023_759a39bea6baa588a8da2dbdbe638a69.jpg',	'10:51:37',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2897011',	'81.6236526',	NULL,	'00:00:01',	'2023-10-31 07:59:11',	'2023-10-31 10:53:26'),
(204,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-10-31',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'31-10-2023_7b0dbbe46630bdea4795541f2f1b698b.jpg',	'10:54:10',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896375',	'81.6236876',	NULL,	'00:00:00',	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-10-31 07:59:11',	'2023-10-31 10:55:17'),
(205,	1,	0,	1,	3,	3,	0,	1,	0,	0,	0,	'139',	'2023-10-31',	'IT124',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'2',	'31-10-2023_85d1e1c96b95e14acf37708e4463589d.jpg',	'10:57:20',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896472',	'81.6236858',	'31-10-2023_a0245cb5e1e8cb0148f3bb2c19b8b019.jpg',	'10:57:22',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896472',	'81.6236858',	NULL,	'00:00:02',	'2023-10-31 07:59:11',	'2023-10-31 10:57:58'),
(207,	1,	0,	1,	3,	3,	0,	1,	0,	0,	0,	'68',	'2023-11-01',	'IT121',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'2',	'01-11-2023_6cb0fe58e8329da4f87ae5b2089e7f2b.jpg',	'10:27:17',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896327',	'81.6236906',	'01-11-2023_00cdb700530bf18919a1729540c62b8a.jpg',	'10:27:19',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896327',	'81.6236906',	NULL,	'00:00:02',	'2023-11-01 04:57:39',	'2023-11-01 10:27:35'),
(208,	1,	0,	1,	3,	3,	0,	1,	0,	0,	0,	'68',	'2023-11-01',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'01-11-2023_cd601652a573d3ec5781881a38bce26d.jpg',	'10:31:16',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896334',	'81.6236909',	'01-11-2023_6309fb0d43e321520d6b78e667ea232a.jpg',	'16:50:46',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896864',	'81.6236575',	NULL,	'06:19:30',	'2023-11-01 11:20:50',	'2023-11-01 10:31:20'),
(209,	1,	0,	0,	0,	0,	0,	1,	0,	0,	1,	NULL,	'2023-09-30',	'IT008',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'12-10-2023_6aaa2c1c7dd6e84d92361626b346a6d0.jpg',	'09:00:00',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896106',	'81.6236888',	'28-09-2023_f9d2f832006a6f5afe263dfb32a5d3d3.jpg',	'18:00:00',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	NULL,	NULL,	NULL,	'09:10:00',	'2023-10-31 07:59:11',	'2023-10-12 17:18:40'),
(210,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-11-01',	'IT0012',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'1',	'01-11-2023_b948c97d08ab9b6ed5929c282c6e2610.jpg',	'15:04:56',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896871',	'81.6236554',	NULL,	'00:00:00',	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-11-01 15:05:05',	'2023-11-01 15:05:05'),
(211,	1,	0,	1,	3,	3,	0,	1,	0,	0,	0,	'68',	'2023-11-01',	'IT125',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'01-11-2023_2a2322bc83225a2a85ff6dbe5c811c44.jpg',	'09:58:43',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.289685',	'81.6236582',	'01-11-2023_2e591d471e6ca88225fb977a6b785310.jpg',	'17:30:45',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.289685',	'81.6236582',	NULL,	'00:00:02',	'2023-11-01 10:40:09',	'2023-11-01 16:09:03'),
(212,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-11-02',	'IT0012',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'02-11-2023_0957b850d1ed325449dd6a68ccd0595b.jpg',	'10:20:56',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896347',	'81.6236821',	NULL,	'18:00:00',	NULL,	NULL,	NULL,	NULL,	NULL,	'2023-11-03 04:43:28',	'2023-11-02 10:21:01'),
(215,	1,	0,	1,	3,	0,	0,	1,	0,	0,	0,	'68',	'2023-11-02',	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'2',	'02-11-2023_0957b850d1ed325449dd6a68ccd0595b.jpg',	'10:20:56',	NULL,	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2896347',	'81.6236821',	NULL,	'18:00:00',	'7JQF+WC9, Birgoan, Raipur Division, 492003',	'21.2879296',	'81.6218321',	NULL,	'09:49:40',	'2023-11-03 04:43:00',	'2023-11-02 10:21:01');

DROP TABLE IF EXISTS `branch_list`;
CREATE TABLE `branch_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `branch_id` varchar(300) DEFAULT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) unsigned zerofill DEFAULT 0,
  `address` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `branch_list` (`id`, `business_id`, `branch_id`, `branch_name`, `is_active`, `address`, `updated_at`, `created_at`) VALUES
(1,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'Kesar Earth Solutions',	0,	NULL,	'2023-08-26 10:19:54',	'2023-09-27 05:41:40'),
(2,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308229',	'Kesar Earth Solution Pvt. Ltd.',	0,	NULL,	'2023-08-26 10:19:45',	'2023-08-26 10:19:45'),
(3,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'FixingDots Gudhgaon',	0,	NULL,	'2023-08-26 10:20:10',	'2023-08-26 10:20:10'),
(4,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'FixingDots',	1,	NULL,	'2023-09-04 11:35:42',	'2023-09-04 11:35:42'),
(7,	'bd545732e12addf17c34a231d24a3814',	'797342eb22742bdf4524f3322a8852f1',	'Creative Minds',	0,	NULL,	'2023-10-02 06:56:18',	'2023-10-02 06:56:18'),
(8,	'e3d64177e51bdff82b499e116796fe74',	'234de5fb3a0dc68c19b33446d054d6c2',	'FixingDots Gudhgaons',	0,	NULL,	'2023-10-11 12:05:42',	'2023-10-22 17:07:10'),
(9,	'b4a8dd835f749b155efa9862b130808b',	'0b30ae1bd5ea396ecccc00fbb2a20da6',	'Fixing Dots',	0,	NULL,	'2023-10-13 07:33:20',	'2023-10-13 07:33:20');

DROP TABLE IF EXISTS `business_details_list`;
CREATE TABLE `business_details_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `business_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_logo` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_categories` int(11) DEFAULT NULL,
  `client_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_type` int(11) DEFAULT NULL,
  `mobile_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pin_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gstnumber` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `business_categories` (`business_categories`),
  KEY `business_type` (`business_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `business_details_list` (`id`, `business_id`, `business_logo`, `business_categories`, `client_name`, `business_email`, `business_name`, `business_type`, `mobile_no`, `city`, `state`, `country`, `business_address`, `pin_code`, `gstnumber`, `created_at`, `updated_at`) VALUES
(1,	'e3d64177e51bdff82b499e116796fe74',	'25-09-2023_b9f46108508bcf0c617f0b1398c948f5.png',	4,	'Mr. Aman Sahu',	'amansahu.er@gmail.com',	'IT Google Invitation Comp',	4,	'8319151766',	'12',	'11',	'India',	'Shrinagar ,Pahadipara,Gudhiyari  Raipur C.G 492001\r\nTulshi nagar ,Pahadipara,Gudhiyari  Raipur C.G 492001',	'492011',	'SODSMEW123X',	'2023-11-02 12:44:27',	'2023-09-25 18:13:19'),
(2,	'bd545732e12addf17c34a231d24a3814',	'02-10-2023_12930beafc3b22a230438ffb901fefd3.png',	4,	'Dilip Sahu',	'dilipsahu26@gmail.com',	'Creative Minds',	1,	'9993659548',	'Raipur',	'Chhattisgarh',	'1',	'Pachpedi Naka, Old Dhamtari Road, Near Colors Mall',	'492001',	'1234567890098',	'2023-10-02 06:51:11',	'2023-10-02 06:51:11');

DROP TABLE IF EXISTS `camera_permission`;
CREATE TABLE `camera_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode_check` varchar(200) DEFAULT NULL,
  `business_check` tinyint(1) unsigned zerofill DEFAULT 0,
  `branch_check` tinyint(1) DEFAULT 0,
  `business_id` varchar(300) DEFAULT 'null',
  `mobile_ip` varchar(300) DEFAULT NULL,
  `imei_number` varchar(300) DEFAULT NULL,
  `check_camera` tinyint(1) unsigned zerofill DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `camera_permission` (`id`, `mode_check`, `business_check`, `branch_check`, `business_id`, `mobile_ip`, `imei_number`, `check_camera`, `created_at`, `updated_at`) VALUES
(13,	'1',	1,	0,	'e3d64177e51bdff82b499e116796fe74',	'224.234.23.232',	'558654849411982',	1,	'2023-10-09 17:25:25',	'2023-10-23 04:46:32');

DROP TABLE IF EXISTS `department_list`;
CREATE TABLE `department_list` (
  `depart_id` int(11) NOT NULL AUTO_INCREMENT,
  `b_id` longtext DEFAULT NULL,
  `branch_id` longtext DEFAULT NULL,
  `depart_name` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`depart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `department_list` (`depart_id`, `b_id`, `branch_id`, `depart_name`, `status`, `updated_at`, `created_at`) VALUES
(1,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'Finance & sales Department',	0,	'2023-11-02 16:16:54',	'2023-11-02 10:46:54'),
(2,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'Housekeepings',	0,	'2023-09-15 01:02:34',	'2023-09-14 19:32:34'),
(3,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'Accounting',	0,	'2023-09-14 10:33:06',	'2023-09-14 10:33:06'),
(4,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'Human Resource Department',	0,	'2023-09-15 01:02:53',	'2023-09-14 19:32:53'),
(5,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'Human Resource',	0,	'2023-09-14 10:33:06',	'2023-09-14 10:33:06'),
(6,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'Sales Department',	0,	'2023-09-14 10:33:06',	'2023-09-14 10:33:06'),
(7,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'Finance Department',	0,	'2023-09-14 10:33:06',	'2023-09-14 10:33:06'),
(8,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'Marketing Department',	0,	'2023-09-14 10:33:06',	'2023-09-14 10:33:06'),
(9,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'Marketing Department',	0,	'2023-09-22 06:42:01',	'2023-09-22 01:12:01'),
(10,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'IT informations',	0,	'2023-10-05 11:08:07',	'2023-10-05 05:38:07'),
(11,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'Software Developer',	0,	'2023-09-25 19:12:29',	'2023-09-25 19:12:29'),
(12,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'IT Root',	0,	'2023-09-26 00:42:58',	'2023-09-26 00:42:58'),
(14,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'House Kepping',	0,	'2023-10-10 15:00:12',	'2023-10-10 09:30:12'),
(15,	'bd545732e12addf17c34a231d24a3814',	'797342eb22742bdf4524f3322a8852f1',	'Information Technology',	0,	'2023-10-05 11:49:01',	'2023-10-05 06:19:01'),
(16,	'bd545732e12addf17c34a231d24a3814',	'797342eb22742bdf4524f3322a8852f1',	'Sales and Marketing',	0,	'2023-10-02 12:28:34',	'2023-10-02 12:28:34'),
(18,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'Software Developer Google',	0,	'2023-10-10 14:58:50',	'2023-10-10 14:58:50'),
(21,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'Information Technology',	0,	'2023-10-13 13:05:17',	'2023-10-13 13:05:17'),
(22,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'Human Resource',	0,	'2023-10-13 13:05:32',	'2023-10-13 13:05:32');

DROP TABLE IF EXISTS `designation_list`;
CREATE TABLE `designation_list` (
  `desig_id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `branch_id` longtext DEFAULT NULL,
  `department_id` longtext DEFAULT NULL,
  `desig_name` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`desig_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `designation_list` (`desig_id`, `business_id`, `branch_id`, `department_id`, `desig_name`, `updated_at`, `created_at`) VALUES
(2,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308229',	'2',	'Director',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(3,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308229',	'6',	'Chairman',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(4,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'6',	'Chief Executive Officer (CEO)',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(5,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'2',	'Chief Financial Officer (CFO)',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(6,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'2',	'Secretary',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(7,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'2',	'Chief Operating Officer (COO)',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(8,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'4',	'Chief Technology Officer (CTO)',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(9,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'5',	'Vice President',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(10,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'6',	'Manager',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(12,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308229',	'3',	'Vice President',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(13,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308229',	'3',	'Chief Technology Officer (CTO)',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(14,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'4',	'Secretary',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(15,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308229',	'4',	'Managing Director',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(16,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308229',	'3',	'Chairman',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(17,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308229',	'5',	'Director',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(18,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'6',	'Chairman',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(19,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'6',	'Managing Directors',	'2023-10-05 11:47:03',	'2023-10-05 06:17:03'),
(20,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'7',	'Secretary',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(21,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'7',	'Vice President',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(22,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'7',	'Manager',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(23,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'7',	'Chief Operating Officer (COO)',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(24,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'7',	'Chief Operating Officer (COO)',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(25,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'7',	'Manager',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(26,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'7',	'Assistant Manager',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(27,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'7\r\n',	'Finance Manager',	'2023-09-25 19:02:59',	'2023-09-25 19:02:59'),
(28,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'11',	'IT Full Stack',	'2023-09-26 00:36:19',	'2023-09-26 00:36:19'),
(31,	'bd545732e12addf17c34a231d24a3814',	'797342eb22742bdf4524f3322a8852f1',	'15',	'Software Engineer',	'2023-10-02 12:29:10',	'2023-10-02 12:29:10'),
(32,	'bd545732e12addf17c34a231d24a3814',	'797342eb22742bdf4524f3322a8852f1',	'15',	'Project Head',	'2023-10-05 11:51:31',	'2023-10-05 06:21:31'),
(34,	'bd545732e12addf17c34a231d24a3814',	'797342eb22742bdf4524f3322a8852f1',	NULL,	'Business Development Manager',	'2023-10-02 12:30:19',	'2023-10-02 12:30:19'),
(35,	'bd545732e12addf17c34a231d24a3814',	'797342eb22742bdf4524f3322a8852f1',	NULL,	'Web Developer',	'2023-10-02 12:31:43',	'2023-10-02 12:31:43'),
(36,	'bd545732e12addf17c34a231d24a3814',	'797342eb22742bdf4524f3322a8852f1',	'15',	'Software Manual Tester',	'2023-10-02 12:32:40',	'2023-10-02 12:32:40'),
(37,	'bd545732e12addf17c34a231d24a3814',	'797342eb22742bdf4524f3322a8852f1',	'16',	'Business Manager',	'2023-10-05 11:54:12',	'2023-10-05 06:24:12'),
(38,	'bd545732e12addf17c34a231d24a3814',	'797342eb22742bdf4524f3322a8852f1',	'15',	'Marketing Executive',	'2023-10-05 11:53:44',	'2023-10-05 06:23:44'),
(39,	'e3d64177e51bdff82b499e116796fe74',	NULL,	NULL,	'Finance Managerd',	'2023-10-23 14:54:01',	'2023-10-23 09:24:01'),
(40,	'e3d64177e51bdff82b499e116796fe74',	NULL,	NULL,	'Finance Manager',	'2023-10-10 15:15:56',	'2023-10-10 15:15:56');

DROP TABLE IF EXISTS `employee_personal_details`;
CREATE TABLE `employee_personal_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `business_id` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch_id` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `master_endgame_id` bigint(11) DEFAULT NULL,
  `emp_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_mname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_lname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `designation_id` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) unsigned zerofill DEFAULT 0,
  `role_id` bigint(20) unsigned NOT NULL DEFAULT 0,
  `employee_type` int(11) DEFAULT NULL,
  `employee_contractual_type` int(11) DEFAULT 0,
  `emp_mobile_number` decimal(10,0) DEFAULT NULL,
  `emp_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_date_of_birth` date DEFAULT NULL,
  `emp_date_of_joining` date DEFAULT NULL,
  `emp_gender` tinyint(1) NOT NULL DEFAULT 0,
  `emp_marital_status` tinyint(1) NOT NULL DEFAULT 0,
  `emp_caste` tinyint(1) NOT NULL DEFAULT 0,
  `emp_blood_group` tinyint(1) NOT NULL DEFAULT 0,
  `emp_select_id` tinyint(1) NOT NULL DEFAULT 0,
  `emp_select_id_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `emp_nationality` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `emp_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_pin_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_shift_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_reporting_manager` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_imei_no` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emp_attendance_method` tinyint(1) DEFAULT NULL,
  `emp_status` tinyint(1) NOT NULL DEFAULT 0,
  `profile_photo` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `emp_id` (`emp_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `employee_personal_details` (`id`, `business_id`, `branch_id`, `emp_id`, `master_endgame_id`, `emp_name`, `emp_mname`, `emp_lname`, `department_id`, `designation_id`, `is_admin`, `role_id`, `employee_type`, `employee_contractual_type`, `emp_mobile_number`, `emp_email`, `emp_date_of_birth`, `emp_date_of_joining`, `emp_gender`, `emp_marital_status`, `emp_caste`, `emp_blood_group`, `emp_select_id`, `emp_select_id_number`, `emp_nationality`, `emp_address`, `emp_country`, `emp_state`, `emp_city`, `emp_pin_code`, `emp_shift_type`, `emp_reporting_manager`, `emp_imei_no`, `emp_attendance_method`, `emp_status`, `profile_photo`, `created_at`, `updated_at`) VALUES
(5,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'IT008',	250,	'Dilip',	NULL,	'Sahu',	11,	28,	0,	1,	1,	0,	1234567890,	'dilipsahu26@gmail.com',	'1993-10-26',	'1998-09-01',	1,	0,	0,	0,	0,	'0',	'0',	'asdfafsdadffgssd',	'1',	'6',	'61',	'493333',	'30',	NULL,	NULL,	1,	0,	'29-09-2023_6ceab5266017decc66c8f0225becb1ff.png',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(7,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'IT009',	250,	'Nisha',	'power',	'Sahu',	11,	28,	0,	3,	1,	0,	9993433474,	'nishasahu018@gmail.com',	'1998-02-10',	'2023-09-13',	2,	0,	0,	0,	0,	'0',	'0',	'Near of Railway Station',	'1',	'6',	'65',	'495677',	'27',	NULL,	NULL,	1,	0,	'25-10-2023_1214b7e05479d3093893648a31982c54.jpg',	'2023-11-03 05:04:59',	'2023-11-03 10:34:59'),
(8,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'IT010',	250,	'Soniya',	NULL,	'root',	11,	28,	0,	0,	1,	0,	9658473211,	'soniyasahu583@gmail.com',	'2000-10-04',	'2023-09-01',	2,	0,	0,	0,	0,	'0',	'0',	'Pahadipara,Gudhiyari  Raipur C.G 492011',	'1',	'6',	'101',	'489333',	'29',	NULL,	NULL,	2,	0,	'19-10-2023_3901ff8daa8436afde7e5155d4fbda3f.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(15,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'IT0012',	250,	'Jayant',	'fast',	'Nishad',	6,	28,	0,	0,	1,	0,	8462074453,	'jayantnishad34@gmail.com',	'2005-05-10',	'2023-01-05',	1,	0,	0,	0,	0,	'0',	'0',	'Shrinagar ,Pahadipara,Gudhiyari  Raipur C.G 492001',	'1',	'6',	'101',	'492011',	'27',	NULL,	NULL,	1,	0,	'09-10-2023_c9b5bba0ecfc5fbb8bce291a6eb6483c.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(18,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'IT111',	250,	'Satyam',	NULL,	'Singh',	5,	9,	0,	0,	1,	0,	8585858585,	'satyamsing55@gmail.com',	'2023-09-12',	'2023-09-07',	1,	0,	0,	0,	0,	'0',	'0',	'Amanaka raipur',	'1',	'6',	'101',	'493221',	'27',	NULL,	NULL,	2,	0,	'28-09-2023_cbe24864da407522f4b2ebf4b739f17b.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(22,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'IT020',	250,	'Kumar',	NULL,	'Sahu',	5,	17,	0,	0,	1,	0,	8596969696,	'ramesh@gmail.com',	'2000-10-03',	'2023-10-25',	1,	0,	0,	0,	0,	'0',	'0',	'fasdfasdf',	'1',	'6',	'101',	'858596',	'27',	NULL,	NULL,	3,	0,	'01-10-2023_ecf69975bffe119b50a066e13dc28cfe.png',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(29,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'IT034',	250,	'MD',	NULL,	'Shajid',	7,	26,	0,	0,	1,	0,	8585858585,	'satyamsingh@gmail.com',	'2005-12-02',	'2023-10-12',	1,	0,	0,	0,	0,	'0',	'0',	'Birgaon Raipur C.G.',	'1',	'6',	'101',	'564658',	'27',	NULL,	NULL,	1,	0,	'02-10-2023_088503d5ed091f76f405cd23a82be75b.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(30,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'IT024',	250,	'Radhika',	NULL,	'Singh',	5,	17,	0,	0,	1,	0,	8585858585,	'radhikasingh@gmail.com',	'1993-06-16',	'2023-10-11',	1,	0,	0,	0,	0,	'0',	'0',	'Birgaon Raipur C.G.',	'1',	'6',	'101',	NULL,	'27',	NULL,	NULL,	2,	0,	'19-10-2023_a5282dd7ce48d2e138f04095df08bfc4.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(32,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'IT040',	250,	'Vinay',	NULL,	'Verma',	2,	6,	0,	0,	1,	0,	8558585588,	'vinayverma@gmail.com',	'1993-11-17',	'2023-10-01',	1,	0,	0,	0,	0,	'0',	'0',	'Chainpur',	'1',	'6',	'101',	'564658',	'27',	NULL,	NULL,	1,	0,	'04-10-2023_c2d823fa7029fc07cf625bc7a5b5cb22.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(33,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'IT025',	250,	'Vandana',	NULL,	'Prajapati',	1,	28,	0,	0,	1,	0,	8585858585,	'vandnaprajapati@gmail.com',	'1991-06-04',	'2023-10-03',	2,	0,	0,	0,	0,	'0',	'0',	'Birgaon Raipur C.G.',	'1',	'0',	'0',	NULL,	'27',	NULL,	NULL,	1,	0,	'19-10-2023_fb47a4e39c924a0e23916aa2cac3127e.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(34,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'IT043',	250,	'Ishita',	NULL,	'Thakur',	4,	8,	0,	0,	1,	0,	8585858585,	'ishitathakur@gmail.com',	'1996-06-04',	'2023-10-02',	3,	0,	0,	0,	0,	'0',	'0',	'gfasdGfhdag',	'1',	'6',	'101',	'564658',	'27',	NULL,	NULL,	1,	0,	'04-10-2023_c2d823fa7029fc07cf625bc7a5b5cb22.jpg	',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(35,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'IT112',	250,	'Aditi',	NULL,	'Mishra',	5,	17,	0,	0,	1,	0,	7708925678,	'aditimishra@gmail.com',	'2000-11-08',	'2023-10-02',	2,	0,	0,	0,	0,	'0',	'0',	'Gondware, Ring Road 2',	'1',	'6',	'101',	'858596',	'27',	NULL,	NULL,	1,	0,	'19-10-2023_cfcda46fa805bc4fed7fd315f28f563b.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(37,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'IT114',	250,	'Arjun',	NULL,	'Rawat',	6,	10,	0,	0,	1,	0,	8985852852,	'aditimishra@gmail.com',	'2023-10-24',	'2023-10-18',	1,	0,	0,	0,	0,	'0',	'0',	'Rawabhata Raipur, Chhattisgarh 493221',	'1',	'14',	'1',	'858596',	'27',	NULL,	NULL,	2,	0,	'06-10-2023_4b72e1ad2382450c42fc1840d302433f.png',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(38,	'bd545732e12addf17c34a231d24a3814',	'797342eb22742bdf4524f3322a8852f1',	'Cr115',	NULL,	'Ramesh',	NULL,	'Yadav',	15,	32,	0,	0,	1,	0,	8855888588,	'ramesh@gmail.com',	'2000-10-17',	'2023-10-02',	1,	0,	0,	0,	0,	'0',	'0',	'Goa',	'1',	'10',	'4',	'526325',	'27',	NULL,	NULL,	1,	0,	'06-10-2023_c7741c9986aefd95c9b8ecee1be74ff3.png',	'2023-10-19 06:50:47',	'2023-10-06 11:33:42'),
(39,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'IT115',	250,	'rahulraj',	'sda',	'Nishad',	7,	22,	0,	0,	1,	0,	354624564,	'jayantnishad34@gmail.com',	'2023-10-02',	'2023-10-09',	2,	0,	0,	0,	0,	'0',	'0',	'Shrinagar ,Pahadipara,Gudhiyari  Raipur C.G 492001',	'1',	'6',	'14',	'492011',	'27',	NULL,	NULL,	1,	0,	'08-10-2023_516d18fe541d42e58dd5761e0c1f1086.png',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(40,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308252',	'IT116',	250,	'mohit',	NULL,	'sahu',	5,	9,	0,	0,	1,	0,	483589348,	'mohit007@gmail.com',	'2023-09-27',	'2023-10-23',	1,	0,	0,	0,	0,	'0',	'0',	'Raipur',	'1',	'6',	'44',	'492011',	'27',	NULL,	NULL,	1,	0,	'08-10-2023_c83c281cf1fc02e3500574e47731c897.png',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(41,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'IT117',	250,	'Bhaskar',	'asdf',	'Dewangan',	2,	39,	0,	0,	1,	0,	8585885885,	'bhaskardewangan@gmail.co',	'1998-07-07',	'2023-10-05',	1,	0,	0,	0,	0,	'0',	'0',	'Mon',	'1',	'24',	'5',	'564658',	'27',	NULL,	NULL,	1,	0,	'18-10-2023_95fc577a986545f3a996d9ae017d36a4.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(42,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'IT118',	250,	'Rahul',	NULL,	'Verma',	9,	25,	0,	0,	1,	0,	8558585544,	'contractualemp@gmail.com',	'2000-06-13',	'2022-05-01',	1,	0,	0,	0,	0,	'0',	'0',	'C/O Ram Ganesh CG Nagar Tikraara Near Mahesh, Vijayvada',	'1',	'15',	'13',	'490505',	'27',	NULL,	NULL,	1,	0,	'23-10-2023_d4bfc20c7818c75867918aa46e8cfbd4.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(43,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'IT119',	250,	'Rupali',	NULL,	'Verma',	1,	40,	0,	0,	1,	1,	9875868485,	'rupali430@gmail.com',	'1999-10-12',	'2023-10-06',	2,	0,	0,	0,	0,	'0',	'0',	'Muzaaffarpur',	'1',	'4',	'74',	'858758',	'29',	NULL,	NULL,	1,	0,	'23-10-2023_aebe11b464f9d66d0e63ad8b889a2428.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(44,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'IT120',	250,	'Megha',	NULL,	'Kapoor',	1,	40,	0,	0,	2,	1,	8764584564,	'meghakapoor886@gmail.com',	'1998-11-11',	'2023-10-02',	2,	0,	0,	0,	0,	'0',	'0',	'Bastar',	'1',	'6',	'13',	'845415',	'27',	NULL,	NULL,	1,	0,	'23-10-2023_f25210e85fea6706e85cc627ec27b155.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(45,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'IT121',	250,	'Nitin',	NULL,	'Singh',	1,	39,	0,	0,	1,	3,	8888888888,	'satyamsingh@gmail.com',	'2000-06-07',	'2023-10-03',	1,	0,	0,	0,	0,	'0',	'0',	'Birgaon Raipur C.G.',	'1',	'10',	'4',	'564658',	'27',	NULL,	NULL,	1,	0,	'23-10-2023_229016001a0731f2a64d2d85fb210a42.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(46,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'IT122',	250,	'Lucky',	NULL,	'Prasad',	10,	28,	0,	0,	2,	2,	8888888877,	'luckyprasad84@gmail.com',	'2000-11-15',	'2023-02-21',	1,	0,	0,	0,	0,	'0',	'0',	'Dholka',	'1',	'11',	'43',	'898458',	'29',	NULL,	NULL,	1,	0,	'23-10-2023_ac4c98e10582952ecf33c6b9e60a184e.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(47,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'IT123',	250,	'Mrs. Jiya',	NULL,	'Sonwane',	6,	26,	0,	0,	1,	2,	9823757720,	'jiyarajput@gmail.com',	'2000-10-23',	'2023-07-01',	2,	0,	0,	0,	0,	'0',	'0',	'Kabir Nagar, Near SBPL',	'1',	'6',	'101',	'492001',	'27',	NULL,	NULL,	1,	0,	'23-10-2023_5195b06a40fdd84974c20586b42e39e6.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(48,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'IT124',	250,	'Karan',	'Prasad',	'Verma',	9,	25,	0,	0,	1,	3,	9823757755,	'karanverma@gmail.com',	'1999-11-10',	'2023-10-04',	1,	0,	0,	0,	0,	'0',	'0',	'Sahu Para, Main Road Bemetara',	'1',	'6',	'15',	'491237',	'29',	NULL,	NULL,	2,	0,	'23-10-2023_1ed86a3123cf74d559d7e389f8f9c58c.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(49,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308253',	'IT125',	250,	'Aman',	'Kumar',	'Sahu',	10,	28,	0,	0,	1,	0,	9111326605,	'amansahu2333924@gmail.com',	'2000-07-07',	'2023-06-13',	1,	0,	0,	0,	0,	'0',	'0',	'Vill-Ganiyari, Post-Sambalpur, Block-Nawagarh,C.G., 491340',	'1',	'6',	'15',	'491340',	'27',	NULL,	NULL,	1,	0,	'30-10-2023_19555fb9659a39160b458d5206d3273c.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(50,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308228',	'IT126',	250,	'Satyam',	NULL,	'Singh',	2,	39,	0,	0,	1,	0,	8585858585,	'satyamsingh@gmail.com',	'2023-11-02',	'2023-11-15',	1,	0,	1,	1,	1,	'704375743989',	'1',	NULL,	'1',	'3',	'0',	NULL,	'30',	NULL,	NULL,	1,	0,	'01-11-2023_19e117f19274353287492d5c051b6814.png',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(51,	'e3d64177e51bdff82b499e116796fe74',	'd845e2bc8a80f01f71ea5699a91308229',	'IT127',	250,	'Nitya',	NULL,	'Nishad',	1,	40,	0,	0,	1,	0,	6546546546,	'nityavaishnav@gmail.com',	'1999-02-02',	'2023-11-01',	2,	1,	3,	1,	1,	'707070707070',	'1',	'Antagarh',	NULL,	'6',	'1',	'564658',	'30',	'Mr. R. K.',	NULL,	1,	0,	'01-11-2023_1601d7185e3c905218de930e84685f1c.jpg',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14');

DROP TABLE IF EXISTS `export_employee_templates`;
CREATE TABLE `export_employee_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` bigint(20) DEFAULT NULL,
  `emp_fname` varchar(200) DEFAULT NULL,
  `emp_mname` varchar(200) DEFAULT NULL,
  `emp_lname` varchar(200) DEFAULT NULL,
  `emp_dob` date DEFAULT NULL,
  `emp_join` date DEFAULT NULL,
  `emp_gender` varchar(255) DEFAULT NULL,
  `emp_mobile` varchar(200) DEFAULT NULL,
  `emp_gmail` varchar(200) DEFAULT NULL,
  `emp_blood_group` varchar(20) DEFAULT NULL,
  `emp_iemi` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `export_employee_templates` (`id`, `emp_id`, `emp_fname`, `emp_mname`, `emp_lname`, `emp_dob`, `emp_join`, `emp_gender`, `emp_mobile`, `emp_gmail`, `emp_blood_group`, `emp_iemi`, `created_at`, `updated_at`) VALUES
(1,	323,	'John',	'D',	'Miller',	'2023-10-12',	'2023-10-12',	'Male/Female',	'8984388949',	'@gmail.com',	'O,B+,',	'5655645343434344',	NULL,	NULL);

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
(1,	'e3d64177e51bdff82b499e116796fe74',	'Aman Sahu',	'amansahu.er@gmail.com',	'+91',	'831915176',	'497215',	'2023-11-03 05:06:14',	1,	'98|pIcrLZ1VNq36CPoCHUuwlVwoOmHmAQVhGdYjVflFf4f39a06',	'0000-00-00 00:00:00',	'2023-11-03 10:36:14'),
(10,	'e3d64177e51bdff82b499e116796fe74',	'Umesh Sahu',	'cpictogram@gmail.com',	'+91',	'6266043320',	'803277',	'2023-10-17 04:39:29',	0,	NULL,	'0000-00-00 00:00:00',	'2023-10-17 10:09:29'),
(13,	'bd545732e12addf17c34a231d24a3814',	'Dilip Sahu',	'dilipsahu26@gmail.com',	'+91',	'9993659548',	'132036',	'2023-10-16 12:29:42',	1,	'7|tYFPvRzNzAsj15X0tbT9roRXAytTLhCOj3zQA6tVa73e0ce9',	'0000-00-00 00:00:00',	'2023-10-16 17:59:42'),
(15,	'e3d64177e51bdff82b499e116796fe74',	'Dilip',	'dilipsahu26@gmail.com',	'+91',	'1234567890',	NULL,	'2023-10-16 12:30:05',	1,	NULL,	'0000-00-00 00:00:00',	'2023-10-16 12:30:05'),
(16,	'e3d64177e51bdff82b499e116796fe74',	'Nisha',	'nishasahu018@gmail.com',	'+91',	'9993433474',	'727965',	'2023-11-03 05:05:43',	1,	NULL,	'0000-00-00 00:00:00',	'2023-11-03 05:05:43');

DROP TABLE IF EXISTS `login_employee`;
CREATE TABLE `login_employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(100) DEFAULT NULL,
  `business_id` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `country_code` varchar(5) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `otp_created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `emp_id` (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `login_employee` (`id`, `emp_id`, `business_id`, `email`, `country_code`, `phone`, `otp`, `otp_created_at`, `created_at`, `updated_at`) VALUES
(1,	'IT0012',	'e3d64177e51bdff82b499e116796fe74',	'jayantnishad34@gmail.com',	'+91',	'8462074453',	NULL,	'2023-10-09 09:55:59',	'0000-00-00 00:00:00',	'2023-10-09 09:55:59'),
(2,	'IT020',	'e3d64177e51bdff82b499e116796fe74',	'sahuuuu@gmail.com',	'+91',	'8985852852',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(3,	'IT022',	'e3d64177e51bdff82b499e116796fe74',	'satyamsingh@gmail.com',	'+91',	'8585858585',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(4,	'IT001',	'e3d64177e51bdff82b499e116796fe74',	'satyamsingh@gmail.com',	'+91',	'8585858585',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(5,	'IT025',	'e3d64177e51bdff82b499e116796fe74',	'satyamsingh@gmail.com',	'+91',	'8585858585',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(7,	'IT009',	'e3d64177e51bdff82b499e116796fe74',	'nishasahu018@gmail.com',	'+91',	'9993433474',	NULL,	'2023-10-09 12:53:05',	'0000-00-00 00:00:00',	'2023-10-09 12:53:05'),
(8,	'IT030',	'e3d64177e51bdff82b499e116796fe74',	'satyamsingh@gmail.com',	'+91',	'8585858585',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(11,	'IT111',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'8585858585',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(12,	'IT028',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'8585858585',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(14,	'IT031',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'96969696',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(17,	'IT027',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'8596969696',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(19,	'IT029',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'8589658965',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(21,	'IT033',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'8585858585',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(22,	'IT034',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'8585858585',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(23,	'IT024',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'8585858585',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(24,	'IT040',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'8558585588',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(26,	'IT043',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'8585858585',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(27,	'IT112',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'7708925678',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(28,	'IT113',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'8985852852',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(29,	'IT114',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'8985852852',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(30,	'Cr115',	'bd545732e12addf17c34a231d24a3814',	NULL,	'+91',	'8855888588',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(31,	'IT115',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'3546245658',	NULL,	'2023-10-09 11:01:13',	'0000-00-00 00:00:00',	'2023-10-09 11:01:13'),
(32,	'IT116',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'483589348',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(33,	'IT117',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'8585885885',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(34,	'IT010',	'e3d64177e51bdff82b499e116796fe74',	NULL,	'+91',	'9658473211',	NULL,	'2023-10-18 12:54:24',	'0000-00-00 00:00:00',	'2023-10-18 12:54:24'),
(35,	'IT121',	'e3d64177e51bdff82b499e116796fe74',	'satyamsingh@gmail.com',	'+91',	'8888888888',	NULL,	'2023-10-30 09:52:47',	'0000-00-00 00:00:00',	'2023-10-30 09:52:47'),
(36,	'IT122',	'e3d64177e51bdff82b499e116796fe74',	'luckyprasad84@gmail.com',	'+91',	'8888888877',	NULL,	'2023-10-30 09:56:55',	'0000-00-00 00:00:00',	'2023-10-30 09:56:55'),
(37,	'IT123',	'e3d64177e51bdff82b499e116796fe74',	'jiyarajput@gmail.com',	'+91',	'9823757720',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(39,	'IT124',	'e3d64177e51bdff82b499e116796fe74',	'karanverma@gmail.com',	'+91',	'9823757755',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(40,	'IT125',	'e3d64177e51bdff82b499e116796fe74',	'amansahu2333924@gmail.com',	'+91',	'9111326605',	NULL,	'2023-10-09 11:01:13',	'0000-00-00 00:00:00',	'2023-10-30 09:29:39'),
(41,	'IT126',	'e3d64177e51bdff82b499e116796fe74',	'satyamsingh@gmail.com',	'+91',	'8585858585',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(42,	'IT127',	'e3d64177e51bdff82b499e116796fe74',	'nityavaishnav@gmail.com',	'+91',	'6546546546',	NULL,	NULL,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_id` bigint(20) unsigned DEFAULT NULL,
  `permission_id` bigint(20) unsigned DEFAULT NULL,
  `model_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_id` bigint(20) unsigned DEFAULT NULL,
  `model_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `permission_name` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `business_id` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch_id` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `model_has_permissions` (`id`, `role_id`, `permission_id`, `model_id`, `module_id`, `model_type`, `permission_name`, `business_id`, `branch_id`) VALUES
(1,	NULL,	NULL,	'IT001',	1,	'0',	'Dashboard.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(2,	NULL,	NULL,	'IT001',	1,	'0',	'Dashboard.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(3,	NULL,	NULL,	'IT001',	1,	'0',	'Dashboard.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(4,	NULL,	NULL,	'IT001',	1,	'0',	'Dashboard.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(5,	NULL,	NULL,	'IT001',	2,	'0',	'Employee.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(6,	NULL,	NULL,	'IT001',	2,	'0',	'Employee.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(7,	NULL,	NULL,	'IT001',	2,	'0',	'Employee.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(8,	NULL,	NULL,	'IT001',	2,	'0',	'Employee.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(9,	NULL,	NULL,	'IT001',	3,	'0',	'Attendance.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(10,	NULL,	NULL,	'IT001',	3,	'0',	'Attendance.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(11,	NULL,	NULL,	'IT001',	3,	'0',	'Attendance.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(12,	NULL,	NULL,	'IT001',	3,	'0',	'Attendance.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(13,	NULL,	NULL,	'IT001',	4,	'0',	'Leave.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(14,	NULL,	NULL,	'IT001',	4,	'0',	'Leave.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(15,	NULL,	NULL,	'IT001',	4,	'0',	'Leave.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(16,	NULL,	NULL,	'IT001',	4,	'0',	'Leave.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(17,	NULL,	NULL,	'IT001',	5,	'0',	'Miss Punch.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(18,	NULL,	NULL,	'IT001',	5,	'0',	'Miss Punch.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(19,	NULL,	NULL,	'IT001',	5,	'0',	'Miss Punch.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(20,	NULL,	NULL,	'IT001',	5,	'0',	'Miss Punch.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(21,	NULL,	NULL,	'IT001',	6,	'0',	'Gate Pass.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(22,	NULL,	NULL,	'IT001',	6,	'0',	'Gate Pass.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(23,	NULL,	NULL,	'IT001',	6,	'0',	'Gate Pass.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(24,	NULL,	NULL,	'IT001',	6,	'0',	'Gate Pass.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(25,	NULL,	NULL,	'IT001',	7,	'0',	'Roles & Permissions.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(26,	NULL,	NULL,	'IT001',	7,	'0',	'Roles & Permissions.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(27,	NULL,	NULL,	'IT001',	7,	'0',	'Roles & Permissions.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(28,	NULL,	NULL,	'IT001',	7,	'0',	'Roles & Permissions.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(29,	NULL,	NULL,	'IT001',	8,	'0',	'Admin List.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(30,	NULL,	NULL,	'IT001',	8,	'0',	'Admin List.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(31,	NULL,	NULL,	'IT001',	8,	'0',	'Admin List.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(32,	NULL,	NULL,	'IT001',	8,	'0',	'Admin List.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(33,	NULL,	NULL,	'IT001',	9,	'0',	'Attendance Setting.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(34,	NULL,	NULL,	'IT001',	9,	'0',	'Attendance Setting.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(35,	NULL,	NULL,	'IT001',	9,	'0',	'Attendance Setting.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(36,	NULL,	NULL,	'IT001',	9,	'0',	'Attendance Setting.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(37,	NULL,	NULL,	'IT001',	10,	'0',	'Attendance Attedance-Mode.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(38,	NULL,	NULL,	'IT001',	10,	'0',	'Attendance Attedance-Mode.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(39,	NULL,	NULL,	'IT001',	10,	'0',	'Attendance Attedance-Mode.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(40,	NULL,	NULL,	'IT001',	10,	'0',	'Attendance Attedance-Mode.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(41,	NULL,	NULL,	'IT001',	11,	'0',	'Attendance Access-List.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(42,	NULL,	NULL,	'IT001',	11,	'0',	'Attendance Access-List.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(43,	NULL,	NULL,	'IT001',	11,	'0',	'Attendance Access-List.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(44,	NULL,	NULL,	'IT001',	11,	'0',	'Attendance Access-List.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(45,	NULL,	NULL,	'IT001',	12,	'0',	'Attendance Shift.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(46,	NULL,	NULL,	'IT001',	12,	'0',	'Attendance Shift.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(47,	NULL,	NULL,	'IT001',	12,	'0',	'Attendance Shift.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(48,	NULL,	NULL,	'IT001',	12,	'0',	'Attendance Shift.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(49,	NULL,	NULL,	'IT001',	13,	'0',	'Attendance Automation-Rules.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(50,	NULL,	NULL,	'IT001',	13,	'0',	'Attendance Automation-Rules.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(51,	NULL,	NULL,	'IT001',	13,	'0',	'Attendance Automation-Rules.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(52,	NULL,	NULL,	'IT001',	13,	'0',	'Attendance Automation-Rules.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(53,	NULL,	NULL,	'IT001',	14,	'0',	'Attendance TrackIn-OutTime.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(54,	NULL,	NULL,	'IT001',	14,	'0',	'Attendance TrackIn-OutTime.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(55,	NULL,	NULL,	'IT001',	14,	'0',	'Attendance TrackIn-OutTime.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(56,	NULL,	NULL,	'IT001',	14,	'0',	'Attendance TrackIn-OutTime.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(57,	NULL,	NULL,	'IT001',	15,	'0',	'Attendance Holiday.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(58,	NULL,	NULL,	'IT001',	15,	'0',	'Attendance Holiday.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(59,	NULL,	NULL,	'IT001',	15,	'0',	'Attendance Holiday.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(60,	NULL,	NULL,	'IT001',	15,	'0',	'Attendance Holiday.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(61,	NULL,	NULL,	'IT001',	16,	'0',	'Business Setting.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(62,	NULL,	NULL,	'IT001',	16,	'0',	'Business Setting.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(63,	NULL,	NULL,	'IT001',	16,	'0',	'Business Setting.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(64,	NULL,	NULL,	'IT001',	16,	'0',	'Business Setting.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(65,	NULL,	NULL,	'IT001',	17,	'0',	'Branch Setting.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(66,	NULL,	NULL,	'IT001',	17,	'0',	'Branch Setting.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(67,	NULL,	NULL,	'IT001',	17,	'0',	'Branch Setting.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(68,	NULL,	NULL,	'IT001',	17,	'0',	'Branch Setting.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(69,	NULL,	NULL,	'IT001',	18,	'0',	'Department Setting.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(70,	NULL,	NULL,	'IT001',	18,	'0',	'Department Setting.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(71,	NULL,	NULL,	'IT001',	18,	'0',	'Department Setting.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(72,	NULL,	NULL,	'IT001',	18,	'0',	'Department Setting.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(73,	NULL,	NULL,	'IT001',	19,	'0',	'Designation Setting.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(74,	NULL,	NULL,	'IT001',	19,	'0',	'Designation Setting.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(75,	NULL,	NULL,	'IT001',	19,	'0',	'Designation Setting.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(76,	NULL,	NULL,	'IT001',	19,	'0',	'Designation Setting.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(77,	NULL,	NULL,	'IT001',	20,	'0',	'Holiday Setting.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(78,	NULL,	NULL,	'IT001',	20,	'0',	'Holiday Setting.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(79,	NULL,	NULL,	'IT001',	20,	'0',	'Holiday Setting.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(80,	NULL,	NULL,	'IT001',	20,	'0',	'Holiday Setting.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(81,	NULL,	NULL,	'IT001',	21,	'0',	'Leave Setting.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(82,	NULL,	NULL,	'IT001',	21,	'0',	'Leave Setting.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(83,	NULL,	NULL,	'IT001',	21,	'0',	'Leave Setting.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(84,	NULL,	NULL,	'IT001',	21,	'0',	'Leave Setting.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(85,	NULL,	NULL,	'IT001',	22,	'0',	'WeeklyHoliday Setting.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(86,	NULL,	NULL,	'IT001',	22,	'0',	'WeeklyHoliday Setting.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(87,	NULL,	NULL,	'IT001',	22,	'0',	'WeeklyHoliday Setting.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(88,	NULL,	NULL,	'IT001',	22,	'0',	'WeeklyHoliday Setting.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(89,	NULL,	NULL,	'IT001',	23,	'0',	'Manage Employee Data Setting.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(90,	NULL,	NULL,	'IT001',	23,	'0',	'Manage Employee Data Setting.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(91,	NULL,	NULL,	'IT001',	23,	'0',	'Manage Employee Data Setting.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(92,	NULL,	NULL,	'IT001',	23,	'0',	'Manage Employee Data Setting.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(93,	NULL,	NULL,	'IT001',	24,	'0',	'Invite Employee.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(94,	NULL,	NULL,	'IT001',	24,	'0',	'Invite Employee.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(95,	NULL,	NULL,	'IT001',	24,	'0',	'Invite Employee.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(96,	NULL,	NULL,	'IT001',	24,	'0',	'Invite Employee.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(97,	NULL,	NULL,	'IT001',	25,	'0',	'Account Setting.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(98,	NULL,	NULL,	'IT001',	25,	'0',	'Account Setting.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(99,	NULL,	NULL,	'IT001',	25,	'0',	'Account Setting.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(100,	NULL,	NULL,	'IT001',	25,	'0',	'Account Setting.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(101,	NULL,	NULL,	'IT001',	26,	'0',	'Localization Setting.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(102,	NULL,	NULL,	'IT001',	26,	'0',	'Localization Setting.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(103,	NULL,	NULL,	'IT001',	26,	'0',	'Localization Setting.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(104,	NULL,	NULL,	'IT001',	26,	'0',	'Localization Setting.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(105,	NULL,	NULL,	'IT001',	27,	'0',	'Notification Setting.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(106,	NULL,	NULL,	'IT001',	27,	'0',	'Notification Setting.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(107,	NULL,	NULL,	'IT001',	27,	'0',	'Notification Setting.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(108,	NULL,	NULL,	'IT001',	27,	'0',	'Notification Setting.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(109,	NULL,	NULL,	'IT001',	28,	'0',	'Report.View',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(110,	NULL,	NULL,	'IT001',	28,	'0',	'Report.Create',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(111,	NULL,	NULL,	'IT001',	28,	'0',	'Report.Update',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(112,	NULL,	NULL,	'IT001',	28,	'0',	'Report.Delete',	'e3d64177e51bdff82b499e116796fe74',	NULL),
(113,	NULL,	NULL,	'Cr001',	1,	'0',	'Dashboard.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(114,	NULL,	NULL,	'Cr001',	1,	'0',	'Dashboard.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(115,	NULL,	NULL,	'Cr001',	1,	'0',	'Dashboard.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(116,	NULL,	NULL,	'Cr001',	1,	'0',	'Dashboard.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(117,	NULL,	NULL,	'Cr001',	2,	'0',	'Employee.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(118,	NULL,	NULL,	'Cr001',	2,	'0',	'Employee.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(119,	NULL,	NULL,	'Cr001',	2,	'0',	'Employee.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(120,	NULL,	NULL,	'Cr001',	2,	'0',	'Employee.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(121,	NULL,	NULL,	'Cr001',	3,	'0',	'Attendance.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(122,	NULL,	NULL,	'Cr001',	3,	'0',	'Attendance.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(123,	NULL,	NULL,	'Cr001',	3,	'0',	'Attendance.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(124,	NULL,	NULL,	'Cr001',	3,	'0',	'Attendance.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(125,	NULL,	NULL,	'Cr001',	4,	'0',	'Leave.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(126,	NULL,	NULL,	'Cr001',	4,	'0',	'Leave.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(127,	NULL,	NULL,	'Cr001',	4,	'0',	'Leave.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(128,	NULL,	NULL,	'Cr001',	4,	'0',	'Leave.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(129,	NULL,	NULL,	'Cr001',	5,	'0',	'Miss Punch.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(130,	NULL,	NULL,	'Cr001',	5,	'0',	'Miss Punch.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(131,	NULL,	NULL,	'Cr001',	5,	'0',	'Miss Punch.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(132,	NULL,	NULL,	'Cr001',	5,	'0',	'Miss Punch.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(133,	NULL,	NULL,	'Cr001',	6,	'0',	'Gate Pass.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(134,	NULL,	NULL,	'Cr001',	6,	'0',	'Gate Pass.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(135,	NULL,	NULL,	'Cr001',	6,	'0',	'Gate Pass.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(136,	NULL,	NULL,	'Cr001',	6,	'0',	'Gate Pass.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(137,	NULL,	NULL,	'Cr001',	7,	'0',	'Roles & Permissions.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(138,	NULL,	NULL,	'Cr001',	7,	'0',	'Roles & Permissions.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(139,	NULL,	NULL,	'Cr001',	7,	'0',	'Roles & Permissions.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(140,	NULL,	NULL,	'Cr001',	7,	'0',	'Roles & Permissions.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(141,	NULL,	NULL,	'Cr001',	8,	'0',	'Admin List.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(142,	NULL,	NULL,	'Cr001',	8,	'0',	'Admin List.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(143,	NULL,	NULL,	'Cr001',	8,	'0',	'Admin List.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(144,	NULL,	NULL,	'Cr001',	8,	'0',	'Admin List.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(145,	NULL,	NULL,	'Cr001',	9,	'0',	'Attendance Setting.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(146,	NULL,	NULL,	'Cr001',	9,	'0',	'Attendance Setting.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(147,	NULL,	NULL,	'Cr001',	9,	'0',	'Attendance Setting.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(148,	NULL,	NULL,	'Cr001',	9,	'0',	'Attendance Setting.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(149,	NULL,	NULL,	'Cr001',	10,	'0',	'Attendance Attedance-Mode.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(150,	NULL,	NULL,	'Cr001',	10,	'0',	'Attendance Attedance-Mode.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(151,	NULL,	NULL,	'Cr001',	10,	'0',	'Attendance Attedance-Mode.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(152,	NULL,	NULL,	'Cr001',	10,	'0',	'Attendance Attedance-Mode.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(153,	NULL,	NULL,	'Cr001',	11,	'0',	'Attendance Access-List.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(154,	NULL,	NULL,	'Cr001',	11,	'0',	'Attendance Access-List.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(155,	NULL,	NULL,	'Cr001',	11,	'0',	'Attendance Access-List.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(156,	NULL,	NULL,	'Cr001',	11,	'0',	'Attendance Access-List.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(157,	NULL,	NULL,	'Cr001',	12,	'0',	'Attendance Shift.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(158,	NULL,	NULL,	'Cr001',	12,	'0',	'Attendance Shift.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(159,	NULL,	NULL,	'Cr001',	12,	'0',	'Attendance Shift.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(160,	NULL,	NULL,	'Cr001',	12,	'0',	'Attendance Shift.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(161,	NULL,	NULL,	'Cr001',	13,	'0',	'Attendance Automation-Rules.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(162,	NULL,	NULL,	'Cr001',	13,	'0',	'Attendance Automation-Rules.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(163,	NULL,	NULL,	'Cr001',	13,	'0',	'Attendance Automation-Rules.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(164,	NULL,	NULL,	'Cr001',	13,	'0',	'Attendance Automation-Rules.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(165,	NULL,	NULL,	'Cr001',	14,	'0',	'Attendance TrackIn-OutTime.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(166,	NULL,	NULL,	'Cr001',	14,	'0',	'Attendance TrackIn-OutTime.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(167,	NULL,	NULL,	'Cr001',	14,	'0',	'Attendance TrackIn-OutTime.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(168,	NULL,	NULL,	'Cr001',	14,	'0',	'Attendance TrackIn-OutTime.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(169,	NULL,	NULL,	'Cr001',	15,	'0',	'Attendance Holiday.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(170,	NULL,	NULL,	'Cr001',	15,	'0',	'Attendance Holiday.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(171,	NULL,	NULL,	'Cr001',	15,	'0',	'Attendance Holiday.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(172,	NULL,	NULL,	'Cr001',	15,	'0',	'Attendance Holiday.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(173,	NULL,	NULL,	'Cr001',	16,	'0',	'Business Setting.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(174,	NULL,	NULL,	'Cr001',	16,	'0',	'Business Setting.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(175,	NULL,	NULL,	'Cr001',	16,	'0',	'Business Setting.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(176,	NULL,	NULL,	'Cr001',	16,	'0',	'Business Setting.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(177,	NULL,	NULL,	'Cr001',	17,	'0',	'Branch Setting.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(178,	NULL,	NULL,	'Cr001',	17,	'0',	'Branch Setting.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(179,	NULL,	NULL,	'Cr001',	17,	'0',	'Branch Setting.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(180,	NULL,	NULL,	'Cr001',	17,	'0',	'Branch Setting.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(181,	NULL,	NULL,	'Cr001',	18,	'0',	'Department Setting.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(182,	NULL,	NULL,	'Cr001',	18,	'0',	'Department Setting.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(183,	NULL,	NULL,	'Cr001',	18,	'0',	'Department Setting.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(184,	NULL,	NULL,	'Cr001',	18,	'0',	'Department Setting.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(185,	NULL,	NULL,	'Cr001',	19,	'0',	'Designation Setting.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(186,	NULL,	NULL,	'Cr001',	19,	'0',	'Designation Setting.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(187,	NULL,	NULL,	'Cr001',	19,	'0',	'Designation Setting.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(188,	NULL,	NULL,	'Cr001',	19,	'0',	'Designation Setting.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(189,	NULL,	NULL,	'Cr001',	20,	'0',	'Holiday Setting.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(190,	NULL,	NULL,	'Cr001',	20,	'0',	'Holiday Setting.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(191,	NULL,	NULL,	'Cr001',	20,	'0',	'Holiday Setting.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(192,	NULL,	NULL,	'Cr001',	20,	'0',	'Holiday Setting.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(193,	NULL,	NULL,	'Cr001',	21,	'0',	'Leave Setting.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(194,	NULL,	NULL,	'Cr001',	21,	'0',	'Leave Setting.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(195,	NULL,	NULL,	'Cr001',	21,	'0',	'Leave Setting.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(196,	NULL,	NULL,	'Cr001',	21,	'0',	'Leave Setting.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(197,	NULL,	NULL,	'Cr001',	22,	'0',	'WeeklyHoliday Setting.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(198,	NULL,	NULL,	'Cr001',	22,	'0',	'WeeklyHoliday Setting.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(199,	NULL,	NULL,	'Cr001',	22,	'0',	'WeeklyHoliday Setting.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(200,	NULL,	NULL,	'Cr001',	22,	'0',	'WeeklyHoliday Setting.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(201,	NULL,	NULL,	'Cr001',	23,	'0',	'Manage Employee Data Setting.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(202,	NULL,	NULL,	'Cr001',	23,	'0',	'Manage Employee Data Setting.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(203,	NULL,	NULL,	'Cr001',	23,	'0',	'Manage Employee Data Setting.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(204,	NULL,	NULL,	'Cr001',	23,	'0',	'Manage Employee Data Setting.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(205,	NULL,	NULL,	'Cr001',	24,	'0',	'Invite Employee.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(206,	NULL,	NULL,	'Cr001',	24,	'0',	'Invite Employee.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(207,	NULL,	NULL,	'Cr001',	24,	'0',	'Invite Employee.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(208,	NULL,	NULL,	'Cr001',	24,	'0',	'Invite Employee.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(209,	NULL,	NULL,	'Cr001',	25,	'0',	'Account Setting.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(210,	NULL,	NULL,	'Cr001',	25,	'0',	'Account Setting.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(211,	NULL,	NULL,	'Cr001',	25,	'0',	'Account Setting.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(212,	NULL,	NULL,	'Cr001',	25,	'0',	'Account Setting.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(213,	NULL,	NULL,	'Cr001',	26,	'0',	'Localization Setting.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(214,	NULL,	NULL,	'Cr001',	26,	'0',	'Localization Setting.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(215,	NULL,	NULL,	'Cr001',	26,	'0',	'Localization Setting.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(216,	NULL,	NULL,	'Cr001',	26,	'0',	'Localization Setting.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(217,	NULL,	NULL,	'Cr001',	27,	'0',	'Notification Setting.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(218,	NULL,	NULL,	'Cr001',	27,	'0',	'Notification Setting.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(219,	NULL,	NULL,	'Cr001',	27,	'0',	'Notification Setting.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(220,	NULL,	NULL,	'Cr001',	27,	'0',	'Notification Setting.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(221,	NULL,	NULL,	'Cr001',	28,	'0',	'Report.View',	'bd545732e12addf17c34a231d24a3814',	NULL),
(222,	NULL,	NULL,	'Cr001',	28,	'0',	'Report.Create',	'bd545732e12addf17c34a231d24a3814',	NULL),
(223,	NULL,	NULL,	'Cr001',	28,	'0',	'Report.Update',	'bd545732e12addf17c34a231d24a3814',	NULL),
(224,	NULL,	NULL,	'Cr001',	28,	'0',	'Report.Delete',	'bd545732e12addf17c34a231d24a3814',	NULL),
(225,	NULL,	NULL,	'Fi001',	1,	'0',	'Dashboard.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(226,	NULL,	NULL,	'Fi001',	1,	'0',	'Dashboard.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(227,	NULL,	NULL,	'Fi001',	1,	'0',	'Dashboard.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(228,	NULL,	NULL,	'Fi001',	1,	'0',	'Dashboard.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(229,	NULL,	NULL,	'Fi001',	2,	'0',	'Employee.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(230,	NULL,	NULL,	'Fi001',	2,	'0',	'Employee.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(231,	NULL,	NULL,	'Fi001',	2,	'0',	'Employee.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(232,	NULL,	NULL,	'Fi001',	2,	'0',	'Employee.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(233,	NULL,	NULL,	'Fi001',	3,	'0',	'Attendance.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(234,	NULL,	NULL,	'Fi001',	3,	'0',	'Attendance.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(235,	NULL,	NULL,	'Fi001',	3,	'0',	'Attendance.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(236,	NULL,	NULL,	'Fi001',	3,	'0',	'Attendance.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(237,	NULL,	NULL,	'Fi001',	4,	'0',	'Leave.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(238,	NULL,	NULL,	'Fi001',	4,	'0',	'Leave.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(239,	NULL,	NULL,	'Fi001',	4,	'0',	'Leave.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(240,	NULL,	NULL,	'Fi001',	4,	'0',	'Leave.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(241,	NULL,	NULL,	'Fi001',	5,	'0',	'Miss Punch.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(242,	NULL,	NULL,	'Fi001',	5,	'0',	'Miss Punch.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(243,	NULL,	NULL,	'Fi001',	5,	'0',	'Miss Punch.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(244,	NULL,	NULL,	'Fi001',	5,	'0',	'Miss Punch.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(245,	NULL,	NULL,	'Fi001',	6,	'0',	'Gate Pass.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(246,	NULL,	NULL,	'Fi001',	6,	'0',	'Gate Pass.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(247,	NULL,	NULL,	'Fi001',	6,	'0',	'Gate Pass.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(248,	NULL,	NULL,	'Fi001',	6,	'0',	'Gate Pass.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(249,	NULL,	NULL,	'Fi001',	7,	'0',	'Roles & Permissions.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(250,	NULL,	NULL,	'Fi001',	7,	'0',	'Roles & Permissions.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(251,	NULL,	NULL,	'Fi001',	7,	'0',	'Roles & Permissions.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(252,	NULL,	NULL,	'Fi001',	7,	'0',	'Roles & Permissions.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(253,	NULL,	NULL,	'Fi001',	8,	'0',	'Admin List.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(254,	NULL,	NULL,	'Fi001',	8,	'0',	'Admin List.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(255,	NULL,	NULL,	'Fi001',	8,	'0',	'Admin List.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(256,	NULL,	NULL,	'Fi001',	8,	'0',	'Admin List.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(257,	NULL,	NULL,	'Fi001',	9,	'0',	'Attendance Setting.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(258,	NULL,	NULL,	'Fi001',	9,	'0',	'Attendance Setting.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(259,	NULL,	NULL,	'Fi001',	9,	'0',	'Attendance Setting.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(260,	NULL,	NULL,	'Fi001',	9,	'0',	'Attendance Setting.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(261,	NULL,	NULL,	'Fi001',	10,	'0',	'Attendance Attedance-Mode.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(262,	NULL,	NULL,	'Fi001',	10,	'0',	'Attendance Attedance-Mode.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(263,	NULL,	NULL,	'Fi001',	10,	'0',	'Attendance Attedance-Mode.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(264,	NULL,	NULL,	'Fi001',	10,	'0',	'Attendance Attedance-Mode.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(265,	NULL,	NULL,	'Fi001',	11,	'0',	'Attendance Access-List.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(266,	NULL,	NULL,	'Fi001',	11,	'0',	'Attendance Access-List.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(267,	NULL,	NULL,	'Fi001',	11,	'0',	'Attendance Access-List.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(268,	NULL,	NULL,	'Fi001',	11,	'0',	'Attendance Access-List.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(269,	NULL,	NULL,	'Fi001',	12,	'0',	'Attendance Shift.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(270,	NULL,	NULL,	'Fi001',	12,	'0',	'Attendance Shift.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(271,	NULL,	NULL,	'Fi001',	12,	'0',	'Attendance Shift.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(272,	NULL,	NULL,	'Fi001',	12,	'0',	'Attendance Shift.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(273,	NULL,	NULL,	'Fi001',	13,	'0',	'Attendance Automation-Rules.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(274,	NULL,	NULL,	'Fi001',	13,	'0',	'Attendance Automation-Rules.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(275,	NULL,	NULL,	'Fi001',	13,	'0',	'Attendance Automation-Rules.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(276,	NULL,	NULL,	'Fi001',	13,	'0',	'Attendance Automation-Rules.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(277,	NULL,	NULL,	'Fi001',	14,	'0',	'Attendance TrackIn-OutTime.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(278,	NULL,	NULL,	'Fi001',	14,	'0',	'Attendance TrackIn-OutTime.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(279,	NULL,	NULL,	'Fi001',	14,	'0',	'Attendance TrackIn-OutTime.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(280,	NULL,	NULL,	'Fi001',	14,	'0',	'Attendance TrackIn-OutTime.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(281,	NULL,	NULL,	'Fi001',	15,	'0',	'Attendance Holiday.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(282,	NULL,	NULL,	'Fi001',	15,	'0',	'Attendance Holiday.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(283,	NULL,	NULL,	'Fi001',	15,	'0',	'Attendance Holiday.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(284,	NULL,	NULL,	'Fi001',	15,	'0',	'Attendance Holiday.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(285,	NULL,	NULL,	'Fi001',	16,	'0',	'Business Setting.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(286,	NULL,	NULL,	'Fi001',	16,	'0',	'Business Setting.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(287,	NULL,	NULL,	'Fi001',	16,	'0',	'Business Setting.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(288,	NULL,	NULL,	'Fi001',	16,	'0',	'Business Setting.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(289,	NULL,	NULL,	'Fi001',	17,	'0',	'Branch Setting.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(290,	NULL,	NULL,	'Fi001',	17,	'0',	'Branch Setting.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(291,	NULL,	NULL,	'Fi001',	17,	'0',	'Branch Setting.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(292,	NULL,	NULL,	'Fi001',	17,	'0',	'Branch Setting.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(293,	NULL,	NULL,	'Fi001',	18,	'0',	'Department Setting.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(294,	NULL,	NULL,	'Fi001',	18,	'0',	'Department Setting.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(295,	NULL,	NULL,	'Fi001',	18,	'0',	'Department Setting.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(296,	NULL,	NULL,	'Fi001',	18,	'0',	'Department Setting.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(297,	NULL,	NULL,	'Fi001',	19,	'0',	'Designation Setting.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(298,	NULL,	NULL,	'Fi001',	19,	'0',	'Designation Setting.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(299,	NULL,	NULL,	'Fi001',	19,	'0',	'Designation Setting.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(300,	NULL,	NULL,	'Fi001',	19,	'0',	'Designation Setting.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(301,	NULL,	NULL,	'Fi001',	20,	'0',	'Holiday Setting.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(302,	NULL,	NULL,	'Fi001',	20,	'0',	'Holiday Setting.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(303,	NULL,	NULL,	'Fi001',	20,	'0',	'Holiday Setting.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(304,	NULL,	NULL,	'Fi001',	20,	'0',	'Holiday Setting.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(305,	NULL,	NULL,	'Fi001',	21,	'0',	'Leave Setting.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(306,	NULL,	NULL,	'Fi001',	21,	'0',	'Leave Setting.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(307,	NULL,	NULL,	'Fi001',	21,	'0',	'Leave Setting.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(308,	NULL,	NULL,	'Fi001',	21,	'0',	'Leave Setting.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(309,	NULL,	NULL,	'Fi001',	22,	'0',	'WeeklyHoliday Setting.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(310,	NULL,	NULL,	'Fi001',	22,	'0',	'WeeklyHoliday Setting.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(311,	NULL,	NULL,	'Fi001',	22,	'0',	'WeeklyHoliday Setting.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(312,	NULL,	NULL,	'Fi001',	22,	'0',	'WeeklyHoliday Setting.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(313,	NULL,	NULL,	'Fi001',	23,	'0',	'Manage Employee Data Setting.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(314,	NULL,	NULL,	'Fi001',	23,	'0',	'Manage Employee Data Setting.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(315,	NULL,	NULL,	'Fi001',	23,	'0',	'Manage Employee Data Setting.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(316,	NULL,	NULL,	'Fi001',	23,	'0',	'Manage Employee Data Setting.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(317,	NULL,	NULL,	'Fi001',	24,	'0',	'Invite Employee.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(318,	NULL,	NULL,	'Fi001',	24,	'0',	'Invite Employee.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(319,	NULL,	NULL,	'Fi001',	24,	'0',	'Invite Employee.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(320,	NULL,	NULL,	'Fi001',	24,	'0',	'Invite Employee.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(321,	NULL,	NULL,	'Fi001',	25,	'0',	'Account Setting.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(322,	NULL,	NULL,	'Fi001',	25,	'0',	'Account Setting.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(323,	NULL,	NULL,	'Fi001',	25,	'0',	'Account Setting.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(324,	NULL,	NULL,	'Fi001',	25,	'0',	'Account Setting.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(325,	NULL,	NULL,	'Fi001',	26,	'0',	'Localization Setting.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(326,	NULL,	NULL,	'Fi001',	26,	'0',	'Localization Setting.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(327,	NULL,	NULL,	'Fi001',	26,	'0',	'Localization Setting.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(328,	NULL,	NULL,	'Fi001',	26,	'0',	'Localization Setting.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(329,	NULL,	NULL,	'Fi001',	27,	'0',	'Notification Setting.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(330,	NULL,	NULL,	'Fi001',	27,	'0',	'Notification Setting.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(331,	NULL,	NULL,	'Fi001',	27,	'0',	'Notification Setting.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(332,	NULL,	NULL,	'Fi001',	27,	'0',	'Notification Setting.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(333,	NULL,	NULL,	'Fi001',	28,	'0',	'Report.View',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(334,	NULL,	NULL,	'Fi001',	28,	'0',	'Report.Create',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(335,	NULL,	NULL,	'Fi001',	28,	'0',	'Report.Update',	'b4a8dd835f749b155efa9862b130808b',	NULL),
(336,	NULL,	NULL,	'Fi001',	28,	'0',	'Report.Delete',	'b4a8dd835f749b155efa9862b130808b',	NULL);

DROP TABLE IF EXISTS `pending_admins`;
CREATE TABLE `pending_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `branch_id` longtext DEFAULT NULL,
  `emp_id` varchar(255) DEFAULT NULL,
  `emp_name` varchar(255) DEFAULT NULL,
  `emp_email` varchar(255) DEFAULT NULL,
  `emp_phone` varchar(255) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guard_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `business_id` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch_id` longtext CHARACTER SET latin1 DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `branch_id` (`branch_id`(3072)),
  KEY `module_id` (`module_id`),
  CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `static_sidebar_menu` (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `permissions` (`id`, `guard_name`, `name`, `description`, `module_id`, `business_id`, `branch_id`, `created_at`, `updated_at`) VALUES
(1,	NULL,	'View',	'IT Google Invitation Comp',	1,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(2,	NULL,	'Create',	'IT Google Invitation Comp',	1,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(3,	NULL,	'Update',	'IT Google Invitation Comp',	1,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(4,	NULL,	'Delete',	'IT Google Invitation Comp',	1,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(5,	NULL,	'View',	'IT Google Invitation Comp',	2,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(6,	NULL,	'Create',	'IT Google Invitation Comp',	2,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(7,	NULL,	'Update',	'IT Google Invitation Comp',	2,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(8,	NULL,	'Delete',	'IT Google Invitation Comp',	2,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(9,	NULL,	'View',	'IT Google Invitation Comp',	3,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(10,	NULL,	'Create',	'IT Google Invitation Comp',	3,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(11,	NULL,	'Update',	'IT Google Invitation Comp',	3,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(12,	NULL,	'Delete',	'IT Google Invitation Comp',	3,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(13,	NULL,	'View',	'IT Google Invitation Comp',	4,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(14,	NULL,	'Create',	'IT Google Invitation Comp',	4,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(15,	NULL,	'Update',	'IT Google Invitation Comp',	4,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(16,	NULL,	'Delete',	'IT Google Invitation Comp',	4,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(17,	NULL,	'View',	'IT Google Invitation Comp',	5,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(18,	NULL,	'Create',	'IT Google Invitation Comp',	5,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(19,	NULL,	'Update',	'IT Google Invitation Comp',	5,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(20,	NULL,	'Delete',	'IT Google Invitation Comp',	5,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(21,	NULL,	'View',	'IT Google Invitation Comp',	6,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(22,	NULL,	'Create',	'IT Google Invitation Comp',	6,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(23,	NULL,	'Update',	'IT Google Invitation Comp',	6,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(24,	NULL,	'Delete',	'IT Google Invitation Comp',	6,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(25,	NULL,	'View',	'IT Google Invitation Comp',	7,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(26,	NULL,	'Create',	'IT Google Invitation Comp',	7,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(27,	NULL,	'Update',	'IT Google Invitation Comp',	7,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(28,	NULL,	'Delete',	'IT Google Invitation Comp',	7,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(29,	NULL,	'View',	'IT Google Invitation Comp',	8,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(30,	NULL,	'Create',	'IT Google Invitation Comp',	8,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(31,	NULL,	'Update',	'IT Google Invitation Comp',	8,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(32,	NULL,	'Delete',	'IT Google Invitation Comp',	8,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(33,	NULL,	'View',	'IT Google Invitation Comp',	9,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(34,	NULL,	'Create',	'IT Google Invitation Comp',	9,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(35,	NULL,	'Update',	'IT Google Invitation Comp',	9,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(36,	NULL,	'Delete',	'IT Google Invitation Comp',	9,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(37,	NULL,	'View',	'IT Google Invitation Comp',	10,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(38,	NULL,	'Create',	'IT Google Invitation Comp',	10,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(39,	NULL,	'Update',	'IT Google Invitation Comp',	10,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(40,	NULL,	'Delete',	'IT Google Invitation Comp',	10,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(41,	NULL,	'View',	'IT Google Invitation Comp',	11,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(42,	NULL,	'Create',	'IT Google Invitation Comp',	11,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(43,	NULL,	'Update',	'IT Google Invitation Comp',	11,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(44,	NULL,	'Delete',	'IT Google Invitation Comp',	11,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(45,	NULL,	'View',	'IT Google Invitation Comp',	12,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(46,	NULL,	'Create',	'IT Google Invitation Comp',	12,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(47,	NULL,	'Update',	'IT Google Invitation Comp',	12,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(48,	NULL,	'Delete',	'IT Google Invitation Comp',	12,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(49,	NULL,	'View',	'IT Google Invitation Comp',	13,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(50,	NULL,	'Create',	'IT Google Invitation Comp',	13,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(51,	NULL,	'Update',	'IT Google Invitation Comp',	13,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(52,	NULL,	'Delete',	'IT Google Invitation Comp',	13,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(53,	NULL,	'View',	'IT Google Invitation Comp',	14,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(54,	NULL,	'Create',	'IT Google Invitation Comp',	14,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(55,	NULL,	'Update',	'IT Google Invitation Comp',	14,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(56,	NULL,	'Delete',	'IT Google Invitation Comp',	14,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(57,	NULL,	'View',	'IT Google Invitation Comp',	15,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(58,	NULL,	'Create',	'IT Google Invitation Comp',	15,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(59,	NULL,	'Update',	'IT Google Invitation Comp',	15,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(60,	NULL,	'Delete',	'IT Google Invitation Comp',	15,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(61,	NULL,	'View',	'IT Google Invitation Comp',	16,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(62,	NULL,	'Create',	'IT Google Invitation Comp',	16,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(63,	NULL,	'Update',	'IT Google Invitation Comp',	16,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(64,	NULL,	'Delete',	'IT Google Invitation Comp',	16,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(65,	NULL,	'View',	'IT Google Invitation Comp',	17,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(66,	NULL,	'Create',	'IT Google Invitation Comp',	17,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(67,	NULL,	'Update',	'IT Google Invitation Comp',	17,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(68,	NULL,	'Delete',	'IT Google Invitation Comp',	17,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(69,	NULL,	'View',	'IT Google Invitation Comp',	18,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(70,	NULL,	'Create',	'IT Google Invitation Comp',	18,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(71,	NULL,	'Update',	'IT Google Invitation Comp',	18,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(72,	NULL,	'Delete',	'IT Google Invitation Comp',	18,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(73,	NULL,	'View',	'IT Google Invitation Comp',	19,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(74,	NULL,	'Create',	'IT Google Invitation Comp',	19,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(75,	NULL,	'Update',	'IT Google Invitation Comp',	19,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(76,	NULL,	'Delete',	'IT Google Invitation Comp',	19,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(77,	NULL,	'View',	'IT Google Invitation Comp',	20,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(78,	NULL,	'Create',	'IT Google Invitation Comp',	20,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(79,	NULL,	'Update',	'IT Google Invitation Comp',	20,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(80,	NULL,	'Delete',	'IT Google Invitation Comp',	20,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(81,	NULL,	'View',	'IT Google Invitation Comp',	21,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(82,	NULL,	'Create',	'IT Google Invitation Comp',	21,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(83,	NULL,	'Update',	'IT Google Invitation Comp',	21,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(84,	NULL,	'Delete',	'IT Google Invitation Comp',	21,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(85,	NULL,	'View',	'IT Google Invitation Comp',	22,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(86,	NULL,	'Create',	'IT Google Invitation Comp',	22,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(87,	NULL,	'Update',	'IT Google Invitation Comp',	22,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(88,	NULL,	'Delete',	'IT Google Invitation Comp',	22,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(89,	NULL,	'View',	'IT Google Invitation Comp',	23,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(90,	NULL,	'Create',	'IT Google Invitation Comp',	23,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(91,	NULL,	'Update',	'IT Google Invitation Comp',	23,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(92,	NULL,	'Delete',	'IT Google Invitation Comp',	23,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(93,	NULL,	'View',	'IT Google Invitation Comp',	24,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(94,	NULL,	'Create',	'IT Google Invitation Comp',	24,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(95,	NULL,	'Update',	'IT Google Invitation Comp',	24,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(96,	NULL,	'Delete',	'IT Google Invitation Comp',	24,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(97,	NULL,	'View',	'IT Google Invitation Comp',	25,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(98,	NULL,	'Create',	'IT Google Invitation Comp',	25,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(99,	NULL,	'Update',	'IT Google Invitation Comp',	25,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(100,	NULL,	'Delete',	'IT Google Invitation Comp',	25,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(101,	NULL,	'View',	'IT Google Invitation Comp',	26,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(102,	NULL,	'Create',	'IT Google Invitation Comp',	26,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(103,	NULL,	'Update',	'IT Google Invitation Comp',	26,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(104,	NULL,	'Delete',	'IT Google Invitation Comp',	26,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(105,	NULL,	'View',	'IT Google Invitation Comp',	27,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(106,	NULL,	'Create',	'IT Google Invitation Comp',	27,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(107,	NULL,	'Update',	'IT Google Invitation Comp',	27,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(108,	NULL,	'Delete',	'IT Google Invitation Comp',	27,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(109,	NULL,	'View',	'IT Google Invitation Comp',	28,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(110,	NULL,	'Create',	'IT Google Invitation Comp',	28,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(111,	NULL,	'Update',	'IT Google Invitation Comp',	28,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(112,	NULL,	'Delete',	'IT Google Invitation Comp',	28,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'2023-09-25 18:13:19',	'2023-09-25 18:13:19'),
(113,	NULL,	'View',	'Creative Minds',	1,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(114,	NULL,	'Create',	'Creative Minds',	1,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(115,	NULL,	'Update',	'Creative Minds',	1,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(116,	NULL,	'Delete',	'Creative Minds',	1,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(117,	NULL,	'View',	'Creative Minds',	2,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(118,	NULL,	'Create',	'Creative Minds',	2,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(119,	NULL,	'Update',	'Creative Minds',	2,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(120,	NULL,	'Delete',	'Creative Minds',	2,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(121,	NULL,	'View',	'Creative Minds',	3,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(122,	NULL,	'Create',	'Creative Minds',	3,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(123,	NULL,	'Update',	'Creative Minds',	3,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(124,	NULL,	'Delete',	'Creative Minds',	3,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(125,	NULL,	'View',	'Creative Minds',	4,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(126,	NULL,	'Create',	'Creative Minds',	4,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(127,	NULL,	'Update',	'Creative Minds',	4,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(128,	NULL,	'Delete',	'Creative Minds',	4,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(129,	NULL,	'View',	'Creative Minds',	5,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(130,	NULL,	'Create',	'Creative Minds',	5,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(131,	NULL,	'Update',	'Creative Minds',	5,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(132,	NULL,	'Delete',	'Creative Minds',	5,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(133,	NULL,	'View',	'Creative Minds',	6,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(134,	NULL,	'Create',	'Creative Minds',	6,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(135,	NULL,	'Update',	'Creative Minds',	6,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(136,	NULL,	'Delete',	'Creative Minds',	6,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(137,	NULL,	'View',	'Creative Minds',	7,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(138,	NULL,	'Create',	'Creative Minds',	7,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(139,	NULL,	'Update',	'Creative Minds',	7,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(140,	NULL,	'Delete',	'Creative Minds',	7,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(141,	NULL,	'View',	'Creative Minds',	8,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(142,	NULL,	'Create',	'Creative Minds',	8,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(143,	NULL,	'Update',	'Creative Minds',	8,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(144,	NULL,	'Delete',	'Creative Minds',	8,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(145,	NULL,	'View',	'Creative Minds',	9,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(146,	NULL,	'Create',	'Creative Minds',	9,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(147,	NULL,	'Update',	'Creative Minds',	9,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(148,	NULL,	'Delete',	'Creative Minds',	9,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(149,	NULL,	'View',	'Creative Minds',	10,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(150,	NULL,	'Create',	'Creative Minds',	10,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(151,	NULL,	'Update',	'Creative Minds',	10,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(152,	NULL,	'Delete',	'Creative Minds',	10,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(153,	NULL,	'View',	'Creative Minds',	11,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(154,	NULL,	'Create',	'Creative Minds',	11,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(155,	NULL,	'Update',	'Creative Minds',	11,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(156,	NULL,	'Delete',	'Creative Minds',	11,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(157,	NULL,	'View',	'Creative Minds',	12,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(158,	NULL,	'Create',	'Creative Minds',	12,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(159,	NULL,	'Update',	'Creative Minds',	12,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(160,	NULL,	'Delete',	'Creative Minds',	12,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(161,	NULL,	'View',	'Creative Minds',	13,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(162,	NULL,	'Create',	'Creative Minds',	13,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(163,	NULL,	'Update',	'Creative Minds',	13,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(164,	NULL,	'Delete',	'Creative Minds',	13,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(165,	NULL,	'View',	'Creative Minds',	14,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(166,	NULL,	'Create',	'Creative Minds',	14,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(167,	NULL,	'Update',	'Creative Minds',	14,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(168,	NULL,	'Delete',	'Creative Minds',	14,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(169,	NULL,	'View',	'Creative Minds',	15,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(170,	NULL,	'Create',	'Creative Minds',	15,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(171,	NULL,	'Update',	'Creative Minds',	15,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(172,	NULL,	'Delete',	'Creative Minds',	15,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(173,	NULL,	'View',	'Creative Minds',	16,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(174,	NULL,	'Create',	'Creative Minds',	16,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(175,	NULL,	'Update',	'Creative Minds',	16,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(176,	NULL,	'Delete',	'Creative Minds',	16,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(177,	NULL,	'View',	'Creative Minds',	17,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(178,	NULL,	'Create',	'Creative Minds',	17,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(179,	NULL,	'Update',	'Creative Minds',	17,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(180,	NULL,	'Delete',	'Creative Minds',	17,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(181,	NULL,	'View',	'Creative Minds',	18,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(182,	NULL,	'Create',	'Creative Minds',	18,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(183,	NULL,	'Update',	'Creative Minds',	18,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(184,	NULL,	'Delete',	'Creative Minds',	18,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(185,	NULL,	'View',	'Creative Minds',	19,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(186,	NULL,	'Create',	'Creative Minds',	19,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(187,	NULL,	'Update',	'Creative Minds',	19,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(188,	NULL,	'Delete',	'Creative Minds',	19,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(189,	NULL,	'View',	'Creative Minds',	20,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(190,	NULL,	'Create',	'Creative Minds',	20,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(191,	NULL,	'Update',	'Creative Minds',	20,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(192,	NULL,	'Delete',	'Creative Minds',	20,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(193,	NULL,	'View',	'Creative Minds',	21,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(194,	NULL,	'Create',	'Creative Minds',	21,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(195,	NULL,	'Update',	'Creative Minds',	21,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(196,	NULL,	'Delete',	'Creative Minds',	21,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(197,	NULL,	'View',	'Creative Minds',	22,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(198,	NULL,	'Create',	'Creative Minds',	22,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(199,	NULL,	'Update',	'Creative Minds',	22,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(200,	NULL,	'Delete',	'Creative Minds',	22,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(201,	NULL,	'View',	'Creative Minds',	23,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(202,	NULL,	'Create',	'Creative Minds',	23,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(203,	NULL,	'Update',	'Creative Minds',	23,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(204,	NULL,	'Delete',	'Creative Minds',	23,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(205,	NULL,	'View',	'Creative Minds',	24,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(206,	NULL,	'Create',	'Creative Minds',	24,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(207,	NULL,	'Update',	'Creative Minds',	24,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(208,	NULL,	'Delete',	'Creative Minds',	24,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(209,	NULL,	'View',	'Creative Minds',	25,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(210,	NULL,	'Create',	'Creative Minds',	25,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(211,	NULL,	'Update',	'Creative Minds',	25,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(212,	NULL,	'Delete',	'Creative Minds',	25,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(213,	NULL,	'View',	'Creative Minds',	26,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(214,	NULL,	'Create',	'Creative Minds',	26,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(215,	NULL,	'Update',	'Creative Minds',	26,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(216,	NULL,	'Delete',	'Creative Minds',	26,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(217,	NULL,	'View',	'Creative Minds',	27,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(218,	NULL,	'Create',	'Creative Minds',	27,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(219,	NULL,	'Update',	'Creative Minds',	27,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(220,	NULL,	'Delete',	'Creative Minds',	27,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(221,	NULL,	'View',	'Creative Minds',	28,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(222,	NULL,	'Create',	'Creative Minds',	28,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(223,	NULL,	'Update',	'Creative Minds',	28,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(224,	NULL,	'Delete',	'Creative Minds',	28,	'bd545732e12addf17c34a231d24a3814',	NULL,	'2023-10-02 06:51:11',	'2023-10-02 06:51:11'),
(225,	NULL,	'View',	'Fixing Dots',	1,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(226,	NULL,	'Create',	'Fixing Dots',	1,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(227,	NULL,	'Update',	'Fixing Dots',	1,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(228,	NULL,	'Delete',	'Fixing Dots',	1,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(229,	NULL,	'View',	'Fixing Dots',	2,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(230,	NULL,	'Create',	'Fixing Dots',	2,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(231,	NULL,	'Update',	'Fixing Dots',	2,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(232,	NULL,	'Delete',	'Fixing Dots',	2,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(233,	NULL,	'View',	'Fixing Dots',	3,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(234,	NULL,	'Create',	'Fixing Dots',	3,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(235,	NULL,	'Update',	'Fixing Dots',	3,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(236,	NULL,	'Delete',	'Fixing Dots',	3,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(237,	NULL,	'View',	'Fixing Dots',	4,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(238,	NULL,	'Create',	'Fixing Dots',	4,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(239,	NULL,	'Update',	'Fixing Dots',	4,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(240,	NULL,	'Delete',	'Fixing Dots',	4,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(241,	NULL,	'View',	'Fixing Dots',	5,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(242,	NULL,	'Create',	'Fixing Dots',	5,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(243,	NULL,	'Update',	'Fixing Dots',	5,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(244,	NULL,	'Delete',	'Fixing Dots',	5,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(245,	NULL,	'View',	'Fixing Dots',	6,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(246,	NULL,	'Create',	'Fixing Dots',	6,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(247,	NULL,	'Update',	'Fixing Dots',	6,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(248,	NULL,	'Delete',	'Fixing Dots',	6,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(249,	NULL,	'View',	'Fixing Dots',	7,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(250,	NULL,	'Create',	'Fixing Dots',	7,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(251,	NULL,	'Update',	'Fixing Dots',	7,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(252,	NULL,	'Delete',	'Fixing Dots',	7,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(253,	NULL,	'View',	'Fixing Dots',	8,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(254,	NULL,	'Create',	'Fixing Dots',	8,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(255,	NULL,	'Update',	'Fixing Dots',	8,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(256,	NULL,	'Delete',	'Fixing Dots',	8,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(257,	NULL,	'View',	'Fixing Dots',	9,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(258,	NULL,	'Create',	'Fixing Dots',	9,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(259,	NULL,	'Update',	'Fixing Dots',	9,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(260,	NULL,	'Delete',	'Fixing Dots',	9,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(261,	NULL,	'View',	'Fixing Dots',	10,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(262,	NULL,	'Create',	'Fixing Dots',	10,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(263,	NULL,	'Update',	'Fixing Dots',	10,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(264,	NULL,	'Delete',	'Fixing Dots',	10,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(265,	NULL,	'View',	'Fixing Dots',	11,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(266,	NULL,	'Create',	'Fixing Dots',	11,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(267,	NULL,	'Update',	'Fixing Dots',	11,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(268,	NULL,	'Delete',	'Fixing Dots',	11,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(269,	NULL,	'View',	'Fixing Dots',	12,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(270,	NULL,	'Create',	'Fixing Dots',	12,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(271,	NULL,	'Update',	'Fixing Dots',	12,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(272,	NULL,	'Delete',	'Fixing Dots',	12,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(273,	NULL,	'View',	'Fixing Dots',	13,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(274,	NULL,	'Create',	'Fixing Dots',	13,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(275,	NULL,	'Update',	'Fixing Dots',	13,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(276,	NULL,	'Delete',	'Fixing Dots',	13,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(277,	NULL,	'View',	'Fixing Dots',	14,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(278,	NULL,	'Create',	'Fixing Dots',	14,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(279,	NULL,	'Update',	'Fixing Dots',	14,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(280,	NULL,	'Delete',	'Fixing Dots',	14,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(281,	NULL,	'View',	'Fixing Dots',	15,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(282,	NULL,	'Create',	'Fixing Dots',	15,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(283,	NULL,	'Update',	'Fixing Dots',	15,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(284,	NULL,	'Delete',	'Fixing Dots',	15,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(285,	NULL,	'View',	'Fixing Dots',	16,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(286,	NULL,	'Create',	'Fixing Dots',	16,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(287,	NULL,	'Update',	'Fixing Dots',	16,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(288,	NULL,	'Delete',	'Fixing Dots',	16,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(289,	NULL,	'View',	'Fixing Dots',	17,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(290,	NULL,	'Create',	'Fixing Dots',	17,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(291,	NULL,	'Update',	'Fixing Dots',	17,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(292,	NULL,	'Delete',	'Fixing Dots',	17,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(293,	NULL,	'View',	'Fixing Dots',	18,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(294,	NULL,	'Create',	'Fixing Dots',	18,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(295,	NULL,	'Update',	'Fixing Dots',	18,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(296,	NULL,	'Delete',	'Fixing Dots',	18,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(297,	NULL,	'View',	'Fixing Dots',	19,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(298,	NULL,	'Create',	'Fixing Dots',	19,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(299,	NULL,	'Update',	'Fixing Dots',	19,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(300,	NULL,	'Delete',	'Fixing Dots',	19,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(301,	NULL,	'View',	'Fixing Dots',	20,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(302,	NULL,	'Create',	'Fixing Dots',	20,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(303,	NULL,	'Update',	'Fixing Dots',	20,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(304,	NULL,	'Delete',	'Fixing Dots',	20,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(305,	NULL,	'View',	'Fixing Dots',	21,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(306,	NULL,	'Create',	'Fixing Dots',	21,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(307,	NULL,	'Update',	'Fixing Dots',	21,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(308,	NULL,	'Delete',	'Fixing Dots',	21,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(309,	NULL,	'View',	'Fixing Dots',	22,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(310,	NULL,	'Create',	'Fixing Dots',	22,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(311,	NULL,	'Update',	'Fixing Dots',	22,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(312,	NULL,	'Delete',	'Fixing Dots',	22,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(313,	NULL,	'View',	'Fixing Dots',	23,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(314,	NULL,	'Create',	'Fixing Dots',	23,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(315,	NULL,	'Update',	'Fixing Dots',	23,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(316,	NULL,	'Delete',	'Fixing Dots',	23,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(317,	NULL,	'View',	'Fixing Dots',	24,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(318,	NULL,	'Create',	'Fixing Dots',	24,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(319,	NULL,	'Update',	'Fixing Dots',	24,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(320,	NULL,	'Delete',	'Fixing Dots',	24,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(321,	NULL,	'View',	'Fixing Dots',	25,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(322,	NULL,	'Create',	'Fixing Dots',	25,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(323,	NULL,	'Update',	'Fixing Dots',	25,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(324,	NULL,	'Delete',	'Fixing Dots',	25,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(325,	NULL,	'View',	'Fixing Dots',	26,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(326,	NULL,	'Create',	'Fixing Dots',	26,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(327,	NULL,	'Update',	'Fixing Dots',	26,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(328,	NULL,	'Delete',	'Fixing Dots',	26,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(329,	NULL,	'View',	'Fixing Dots',	27,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(330,	NULL,	'Create',	'Fixing Dots',	27,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(331,	NULL,	'Update',	'Fixing Dots',	27,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(332,	NULL,	'Delete',	'Fixing Dots',	27,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(333,	NULL,	'View',	'Fixing Dots',	28,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(334,	NULL,	'Create',	'Fixing Dots',	28,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(335,	NULL,	'Update',	'Fixing Dots',	28,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46'),
(336,	NULL,	'Delete',	'Fixing Dots',	28,	'b4a8dd835f749b155efa9862b130808b',	NULL,	'2023-10-13 07:29:46',	'2023-10-13 07:29:46');

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  UNIQUE KEY `id` (`id`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'cbbe350bfd1a8adc1a33923123f6a261f789dce1c8312f72fe5512005696b515',	'[\"*\"]',	NULL,	NULL,	'2023-10-01 22:45:49',	'2023-10-01 22:45:49'),
(2,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'15f250cf19b2ab9a8484d0f5dacbeccde0e35877ccdf4b5cc124bfa380d6e1d0',	'[\"*\"]',	NULL,	NULL,	'2023-10-01 22:55:47',	'2023-10-01 22:55:47'),
(3,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'8ffe034539c1363189311d6f681335a4bc4c9ca1db4c8ac894840dc38ed0d542',	'[\"*\"]',	NULL,	NULL,	'2023-10-01 22:58:35',	'2023-10-01 22:58:35'),
(4,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'1b8abd7a9639f9cf354b15ce60490f6281e5363c559b9c75add56ecf261320fb',	'[\"*\"]',	NULL,	NULL,	'2023-10-01 22:59:47',	'2023-10-01 22:59:47'),
(5,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'e46d1763b26ae3a20c3260d7349d171ae9a59ce20fb3f59ad7c8f30fba90b5a4',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 18:33:09',	'2023-10-08 18:33:09'),
(6,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'c7624ed582e323fdee2632524bda0d5df47776fa4150d906f1128d88bf276db8',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 22:03:20',	'2023-10-08 22:03:20'),
(7,	'App\\Models\\admin\\LoginAdmin',	12,	'API TOKEN',	'a4d6e69cd8d5f9e38235f837b551204f2dabce34ffb7944405fc6e4392924e6b',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 22:14:41',	'2023-10-08 22:14:41'),
(8,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'65d8fb58e3931c748a95f40df637cf9990985597aabf6bfa8bee58bef4bb1c41',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 22:29:11',	'2023-10-08 22:29:11'),
(9,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'4151614b9aba5ed72a8cd734a19b1597df69486501ec4addc03db3d17015391f',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 22:40:56',	'2023-10-08 22:40:56'),
(10,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'322eedd6bda7407dc5ba50b2d6b13964b13d73e9214a90511eaabc74c14ee8bd',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 22:44:57',	'2023-10-08 22:44:57'),
(11,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'e246195e961163a0534f3c482d5584f9545cc9450d640598a52d8a322f0dff0d',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 22:47:28',	'2023-10-08 22:47:28'),
(12,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'b689c05c081310f1a666d27665fa55366ab85e7844e8d062fedb1e1450c6c28b',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 22:57:55',	'2023-10-08 22:57:55'),
(13,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'8dab76d585aa159b704ff07f524f9d8dd9316d629b62249e2cb21b3406d43b19',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 22:59:55',	'2023-10-08 22:59:55'),
(14,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'299a6e6595e42e6530bf2491849d3e7d487d725c991df695b7007e9718c0c91d',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 23:02:52',	'2023-10-08 23:02:52'),
(15,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'dfc35d5a7497e1cb3a58ce4b0dc385ac869fbb7ea729de2f6f93654b193de374',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 23:04:55',	'2023-10-08 23:04:55'),
(16,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'dd395ffd24cce14a786621c316a4d1571acbdd587e6415f7d1a4c43542edfff9',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 23:09:06',	'2023-10-08 23:09:06'),
(17,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'ff8e102339b38dafa614c133177101b2ea813f7f56ea046f2863ae68599b32a6',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 23:11:48',	'2023-10-08 23:11:48'),
(18,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'b525d89bc5135c7dcb3bf5e69909b3370bed51aa3f0835fa5c1874036acae17a',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 23:12:35',	'2023-10-08 23:12:35'),
(19,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'04a8740f7c8f95f2b5177d02c8a39f607a05a4658cafce18929a3f6123ec8f42',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 23:18:54',	'2023-10-08 23:18:54'),
(20,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'4e0c928ecd4347e063864d523bc1c123a8ad2f2358b1aec4bc39c13f59b7aa85',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 23:25:38',	'2023-10-08 23:25:38'),
(21,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'0cc0399ec1cfea52be36c95c9ca5f1939b7e372f154f50d01a19a46b2f84602c',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 23:37:18',	'2023-10-08 23:37:18'),
(22,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'3b9c8ce6083a7f374688c449271452a16a8e8c3f321bb5d08e076910e96839b7',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 23:38:07',	'2023-10-08 23:38:07'),
(23,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'53bc7ac9032d477ddf1f6798658a431d725fc1157d1fdca3a951625fcf98dd02',	'[\"*\"]',	NULL,	NULL,	'2023-10-08 23:41:26',	'2023-10-08 23:41:26'),
(24,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'e809877cdcaa9d16173ac1021202c14cf1034daff3231903de313728000b3566',	'[\"*\"]',	NULL,	NULL,	'2023-10-09 10:23:53',	'2023-10-09 10:23:53'),
(25,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'e71121e2360a156104c37ca0654d433965dee5369dd2ab5911878537ee0a8119',	'[\"*\"]',	NULL,	NULL,	'2023-10-09 10:45:03',	'2023-10-09 10:45:03'),
(26,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'f4c0c626a0cc0bddff861cb4003338e933856a05a69c41f78c66fe512e9c8db0',	'[\"*\"]',	NULL,	NULL,	'2023-10-09 10:46:10',	'2023-10-09 10:46:10'),
(27,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'8a843e826c1180284da7be9182193d95a52264b58917fad5ffd00a66902e6587',	'[\"*\"]',	NULL,	NULL,	'2023-10-09 10:47:22',	'2023-10-09 10:47:22'),
(28,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'ef9c07cd9f7bcb4cea447729d8afebc3e0807ff1a8b9e7bde746581085f74180',	'[\"*\"]',	NULL,	NULL,	'2023-10-09 11:25:45',	'2023-10-09 11:25:45'),
(29,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'85bf2f9a83648e63bce472aa14a3f5b952dcf9e25c60e33c004341ac6b357b67',	'[\"*\"]',	NULL,	NULL,	'2023-10-09 11:28:34',	'2023-10-09 11:28:34'),
(30,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'3c6d0b6ab445f453821a76e61f83ae266d720401f888058b13c5b675ab12d674',	'[\"*\"]',	NULL,	NULL,	'2023-10-09 20:38:22',	'2023-10-09 20:38:22'),
(31,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'5ff349538008e51494281961131e4d2b080df27a203fbd56bc75891c8eecd42b',	'[\"*\"]',	NULL,	NULL,	'2023-10-09 22:41:29',	'2023-10-09 22:41:29'),
(32,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'8a30885d92d1891d4b732684c3cbadd82d0cb9cb345c3b5a1c65ca0b8a6946e7',	'[\"*\"]',	NULL,	NULL,	'2023-10-10 10:28:35',	'2023-10-10 10:28:35'),
(33,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'3fb00c7b3b651d6229fb3b8a3c778f3c6b7b4b8d16d5388b61ba1a2efa460186',	'[\"*\"]',	NULL,	NULL,	'2023-10-10 10:29:19',	'2023-10-10 10:29:19'),
(34,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'c3d2fe20084e611ca558bbc28a2756bc4a3fb1c70e7b83bff2728fcfe5b338da',	'[\"*\"]',	NULL,	NULL,	'2023-10-10 17:48:21',	'2023-10-10 17:48:21'),
(35,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'c8b03eb6207161ff9da2819273826526146f9513caad51f9658d699608868494',	'[\"*\"]',	NULL,	NULL,	'2023-10-10 21:38:37',	'2023-10-10 21:38:37'),
(36,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'2567295aeb6eb8240e784dc70325723631fbd1a501f439c6ae5da6b460f6a947',	'[\"*\"]',	NULL,	NULL,	'2023-10-10 23:47:23',	'2023-10-10 23:47:23'),
(37,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'beaa54cf6cc913c6014fada6857ecf15a464143840bbff4d70ef92f6f48f69e4',	'[\"*\"]',	NULL,	NULL,	'2023-10-11 00:06:44',	'2023-10-11 00:06:44'),
(38,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'89bd0896f66c3742cdfce48ee7f677bd06cf6979e543fb4628f053b6c5e8037b',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 12:17:40',	'2023-10-13 12:17:40'),
(39,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'4cc70303f9a9432c4c8360b89af557997ac60acbcfdfe2a7c3d46aeb3df323c5',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 12:37:23',	'2023-10-13 12:37:23'),
(40,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'95046c2cbeca9bfc5b554ad5fac6cda8953bb5cb700450e3b575bdfa3080ff3b',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 16:51:11',	'2023-10-13 16:51:11'),
(41,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'3506fc04ffca91cfb5428d3636c0d9ac7ae851fa3d5910339f08fd1d65118517',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 16:53:34',	'2023-10-13 16:53:34'),
(42,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'e23d1dba87126c79ed0cfd43e5917e8df1fcb9319cd9c426f7d590ea0efafd8c',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 16:54:56',	'2023-10-13 16:54:56'),
(43,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'69a414957b4c6db71e74dc1918402a2293330cddab625e4e24714bdebf73ffa0',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 16:57:59',	'2023-10-13 16:57:59'),
(44,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'4caf4508a54475da953d1a26c453ca3aec104006c3f90e8c3fe6065dd6ff2991',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 16:59:59',	'2023-10-13 16:59:59'),
(45,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'96066776a3216bb07f4cc0a4661dacbb35d466ddb98c9d6548c403d401fee27e',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 17:05:32',	'2023-10-13 17:05:32'),
(46,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'6d91b1467c3646d10d4652039312cb93c30d1d6ed9e822c74f77ceb373bee389',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 17:09:14',	'2023-10-13 17:09:14'),
(47,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'b32438f6a765853fd59422d36d8d622560326d1dd4f5c3d7d90ef72cbb1967ea',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 17:10:52',	'2023-10-13 17:10:52'),
(48,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'a468c53f5dbb89fbeb19be3993872019b50ad86b1e0480d43b344a0b584a10b9',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 17:11:28',	'2023-10-13 17:11:28'),
(49,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'39b7c51c03c5032470ff7dd2111e7aa05a05e4478dc8f7c2a8fba713feb818fb',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 20:24:34',	'2023-10-13 20:24:34'),
(50,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'de2f76dc6e0137a9d8e1c2d43bb930516c18c0c4e6ffcbe78404ed6eb616767c',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 20:36:14',	'2023-10-13 20:36:14'),
(51,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'3e240f9dc4760546234fb5c2f7c62f7a8c91287efeb66ec6bf9e4d0c316ba58b',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 20:37:31',	'2023-10-13 20:37:31'),
(52,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'3e773b37485b3dfbbe8ba2546f9e54b7497dca01f90a833fe32397d4f5599042',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 20:42:53',	'2023-10-13 20:42:53'),
(53,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'eba0072685e582cdc0523a4362a855d0c5697f3a0161707ecb71aa84ef7b70ee',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 20:45:03',	'2023-10-13 20:45:03'),
(54,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'b0cfe41caa52465e94d7e61847e4f9b82b70f6a7479a9d2829bce727d7b72c76',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 20:47:41',	'2023-10-13 20:47:41'),
(55,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'5a351268dbfccd769319e165cb139b79fd6d02ee311c08df1c32ac0f00ce1197',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 20:50:50',	'2023-10-13 20:50:50'),
(56,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'7c1fe8be7b3a817809df08e938bcd3bf1db7a507d9ce0e34ad927b496aeb5ebd',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 20:53:10',	'2023-10-13 20:53:10'),
(57,	'App\\Models\\admin\\LoginAdmin',	14,	'API TOKEN',	'd66c621e202b476b192e32ee8b5949bd8562c3328e8a8c83403bdf4d91dd805f',	'[\"*\"]',	NULL,	NULL,	'2023-10-13 20:55:42',	'2023-10-13 20:55:42'),
(58,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'f84936fea8dc4adc9c8cada0429f7bded7cf0bb24638652707b5c82ac0407361',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 00:05:22',	'2023-10-17 00:05:22'),
(59,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'167f5eaaae69b020c9730d212a162977f6e95a3d9011630a26f4fcf9a769d7f0',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 00:16:00',	'2023-10-17 00:16:00'),
(60,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'bf45e57a69b31585ad4727aa034aa1897fc22b2be63e3329de498b1d0825e344',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 10:25:53',	'2023-10-17 10:25:53'),
(61,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'75edbe02cbccdd64958d73325410fa1ca99492b45d56bc4c2e9117590a795c49',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 11:20:42',	'2023-10-17 11:20:42'),
(62,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'083a93e62ea7ca81c33a9e10b1d74e083afa0aa7dd1c009d0c06a82c4783044e',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 11:26:53',	'2023-10-17 11:26:53'),
(63,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'083f9510b21f485b3cb975a5c4bb7fce2b8cb04072beec3d4b59b41ee341c3b4',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 15:31:36',	'2023-10-17 15:31:36'),
(64,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'0a9b6175571a50be5ec4f1e335624443cc11e028af40ee1b5b0055418a4a36ba',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 15:33:12',	'2023-10-17 15:33:12'),
(65,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'047b5ee11a26d4ea684305cd48a89329d0b7e51370df170a66d20a2a859354d0',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 16:34:27',	'2023-10-17 16:34:27'),
(66,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'1a71698eb8248d6a355f9ad6ab83fb0c1ce3aa2416aeeb479f5182cb81833db5',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 16:35:49',	'2023-10-17 16:35:49'),
(67,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'9c3656b33f8981fbd92e817fe8f2e3b68618060e77c38d8cd066e823d5c8cd8d',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 17:07:28',	'2023-10-17 17:07:28'),
(68,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'5e0ffa3220d8881e6190f11af845e9b7c94e7fb14772c8f8d08be9ab8db1aa94',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 17:51:46',	'2023-10-17 17:51:46'),
(69,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'9f82ea5bdc4658b2899e684b35a5cae918d9b7dfd28fea621cab6c333ad56761',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 17:52:54',	'2023-10-17 17:52:54'),
(70,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'266b96924189acc83a199c5db7df9d2d6990370004a72530d34d586fefe5957f',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 19:34:38',	'2023-10-17 19:34:38'),
(71,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'230952ba8e954da112ed996b1bd315b02afc74fe3d8026083b0d1863a181b3f3',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 19:37:08',	'2023-10-17 19:37:08'),
(72,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'b67aa4651a480d16db096023f5c0169693396151a515a719b6c5fedc5dacac1f',	'[\"*\"]',	NULL,	NULL,	'2023-10-17 20:04:09',	'2023-10-17 20:04:09'),
(73,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'36f0500c7c11b9a6a3e445bb02d9c786da5054357baf36b73ba0d80124442fd2',	'[\"*\"]',	NULL,	NULL,	'2023-10-18 10:46:44',	'2023-10-18 10:46:44'),
(74,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'ec2f8270d7d24fbcdcb1ca6555b1d9fa887346d4ccbc561c6bf8b435081969c1',	'[\"*\"]',	NULL,	NULL,	'2023-10-18 14:16:15',	'2023-10-18 14:16:15'),
(75,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'044278587ab3ab3e188c134a33cea2bba26223f3f976ecb936c238b5585f4713',	'[\"*\"]',	NULL,	NULL,	'2023-10-18 22:31:18',	'2023-10-18 22:31:18'),
(76,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'b8c66f9007bf50ae452aecf349855a674eebbe00e8e65404bcad42679d0827c0',	'[\"*\"]',	NULL,	NULL,	'2023-10-19 10:12:04',	'2023-10-19 10:12:04'),
(77,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'd77e05e31b37c16c6e53e911a164004f1e8b8d4b280bde8731bf713cbfa1bb73',	'[\"*\"]',	NULL,	NULL,	'2023-10-19 22:27:54',	'2023-10-19 22:27:54'),
(78,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'7fae080c2dea3abc5448e9a9a54077107910203b8865263c7ffda15368d1be60',	'[\"*\"]',	NULL,	NULL,	'2023-10-20 10:10:27',	'2023-10-20 10:10:27'),
(79,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'9a1902f14da443a06ec67e9eed43723bb3d322eb2f635280694f1383faddaa93',	'[\"*\"]',	NULL,	NULL,	'2023-10-20 13:07:12',	'2023-10-20 13:07:12'),
(80,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'08b96402f906aa5ae5f6a4b39cda13af8e90cfdfca9f718c55f253bb349252a5',	'[\"*\"]',	NULL,	NULL,	'2023-10-23 10:17:26',	'2023-10-23 10:17:26'),
(81,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'7e67dde52c924140d4b0aff5c5f5c50ceafa70176164b50f2bba56cd92d4180f',	'[\"*\"]',	NULL,	NULL,	'2023-10-25 11:59:56',	'2023-10-25 11:59:56'),
(82,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'2c1121bd2594ae2049798998b263ea563a82aeb3950969d0a4579d3a04bb09f9',	'[\"*\"]',	NULL,	NULL,	'2023-10-26 22:08:48',	'2023-10-26 22:08:48'),
(83,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'4c2a1af6ed0f9fb9fd0e06412e135b8fd5de49e0ef5e70e60dc20355b010ae51',	'[\"*\"]',	NULL,	NULL,	'2023-10-27 10:16:02',	'2023-10-27 10:16:02'),
(84,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'f9e6ba34dbb2ee003f7aa5d27eca9e1872e47363a136a74f66185dc1cd89e67f',	'[\"*\"]',	NULL,	NULL,	'2023-10-27 18:42:15',	'2023-10-27 18:42:15'),
(85,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'9b3ddd66428d9fd8a13cde2158cff40bb8a65e83df1ea0dd88e14dc3609c284e',	'[\"*\"]',	NULL,	NULL,	'2023-10-29 19:17:37',	'2023-10-29 19:17:37'),
(86,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'6fc772abfb893eea2715e2aab1e1198d647c840da7121c8c320b861cc38a0786',	'[\"*\"]',	NULL,	NULL,	'2023-10-29 22:56:31',	'2023-10-29 22:56:31'),
(87,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'1e87fbf7793fd6c374ee9d901197844cb00f5427ce0b2e112443ed20f988be45',	'[\"*\"]',	NULL,	NULL,	'2023-10-29 23:48:35',	'2023-10-29 23:48:35'),
(88,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'ac2cce14369b42bd8036be01d82e2bf2632faa1e0a87a031c274eb76450dd810',	'[\"*\"]',	NULL,	NULL,	'2023-10-30 10:17:08',	'2023-10-30 10:17:08'),
(89,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'cbe422549658119419d3ffe6eb9ea3a2cef35bd2b2cc759a6ac99d15cc570f27',	'[\"*\"]',	NULL,	NULL,	'2023-10-30 15:27:43',	'2023-10-30 15:27:43'),
(90,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'68751ed24e83b06fe873e22dc5715aa7862c783a3da306eb36430574ee3e5062',	'[\"*\"]',	NULL,	NULL,	'2023-10-30 15:37:18',	'2023-10-30 15:37:18'),
(91,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'c800f202d8f2f3f1e3c9cfc871622dd852ba73a045361731144d93eb78d51407',	'[\"*\"]',	NULL,	NULL,	'2023-10-30 15:55:54',	'2023-10-30 15:55:54'),
(92,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'8fe67c33c8b13560e5bfff956cd59136207a8e272d6f040297eaad006d3621cb',	'[\"*\"]',	NULL,	NULL,	'2023-10-30 17:19:58',	'2023-10-30 17:19:58'),
(93,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'c4618a7642bc221a7f13a68756278dccf2966fa368f828bd11254ec2533fa882',	'[\"*\"]',	NULL,	NULL,	'2023-10-30 23:32:23',	'2023-10-30 23:32:23'),
(94,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'c497aa376f0442a2a77582196faf99d2b677fed828d83f8c2cdfe927dfb0c863',	'[\"*\"]',	NULL,	NULL,	'2023-10-31 10:24:10',	'2023-10-31 10:24:10'),
(95,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'47fa856116f724e6d9b16b48227689e9047765c83cefbda5523c7a95cf1354fe',	'[\"*\"]',	NULL,	NULL,	'2023-10-31 15:15:08',	'2023-10-31 15:15:08'),
(96,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'e071634c84128729363631f83203f97acf9c756d8f7523f1b9c86ad23bc90428',	'[\"*\"]',	NULL,	NULL,	'2023-10-31 19:36:34',	'2023-10-31 19:36:34'),
(97,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'1ea6a7c408da67159fa73a113335d189dbe91c9897d911c67d9f6da5efdad457',	'[\"*\"]',	NULL,	NULL,	'2023-11-01 10:36:58',	'2023-11-01 10:36:58'),
(98,	'App\\Models\\admin\\LoginAdmin',	1,	'API TOKEN',	'ea64dbdba5460a73a87cde044876d0c6177947c1714976d0364cae4cae194f3c',	'[\"*\"]',	NULL,	NULL,	'2023-11-01 19:49:30',	'2023-11-01 19:49:30');

DROP TABLE IF EXISTS `policy_attendance_mode`;
CREATE TABLE `policy_attendance_mode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `attendance_active_methods` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`attendance_active_methods`)),
  `office_auto` tinyint(1) unsigned zerofill DEFAULT 0,
  `office_manual` tinyint(1) unsigned zerofill DEFAULT 0,
  `office_qr` tinyint(1) unsigned zerofill DEFAULT 0,
  `office_face_id` tinyint(1) unsigned zerofill DEFAULT 0,
  `office_selfie` tinyint(1) unsigned zerofill DEFAULT 0,
  `outdoor_auto` tinyint(1) unsigned zerofill DEFAULT 0,
  `outdoor_manual` tinyint(1) unsigned zerofill DEFAULT 0,
  `outdoor_selfie` tinyint(1) unsigned zerofill DEFAULT 0,
  `wfh_auto` tinyint(1) unsigned zerofill DEFAULT 0,
  `wfh_manual` tinyint(1) unsigned zerofill DEFAULT 0,
  `wfh_selfie` tinyint(1) unsigned zerofill DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_attendance_mode` (`id`, `business_id`, `attendance_active_methods`, `office_auto`, `office_manual`, `office_qr`, `office_face_id`, `office_selfie`, `outdoor_auto`, `outdoor_manual`, `outdoor_selfie`, `wfh_auto`, `wfh_manual`, `wfh_selfie`, `updated_at`, `created_at`) VALUES
(1,	'e3d64177e51bdff82b499e116796fe74',	'[1,2]',	0,	1,	1,	1,	1,	1,	0,	1,	0,	0,	0,	'2023-10-23 14:18:26',	'0000-00-00 00:00:00'),
(2,	'bd545732e12addf17c34a231d24a3814',	'[1,3]',	0,	NULL,	1,	1,	NULL,	0,	NULL,	NULL,	0,	NULL,	1,	'2023-10-04 17:59:38',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `policy_attendance_shift_settings`;
CREATE TABLE `policy_attendance_shift_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `branch_id` longtext DEFAULT NULL,
  `department_id` longtext DEFAULT NULL,
  `shift_type` tinyint(1) unsigned zerofill NOT NULL DEFAULT 0,
  `shift_type_name` varchar(255) DEFAULT NULL,
  `shift_weekly_repeat` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_attendance_shift_settings` (`id`, `business_id`, `branch_id`, `department_id`, `shift_type`, `shift_type_name`, `shift_weekly_repeat`, `created_at`, `updated_at`) VALUES
(26,	'bd545732e12addf17c34a231d24a3814',	'',	NULL,	1,	'General Shift',	0,	'2023-10-02 09:46:57',	'2023-10-03 05:25:27'),
(27,	'e3d64177e51bdff82b499e116796fe74',	'',	NULL,	1,	'Policy for First 6 Month',	0,	'2023-10-04 06:18:59',	'2023-10-25 07:50:33'),
(29,	'e3d64177e51bdff82b499e116796fe74',	NULL,	NULL,	2,	'24*7',	5,	'2023-10-11 05:45:51',	'2023-10-28 05:53:36'),
(30,	'e3d64177e51bdff82b499e116796fe74',	'',	NULL,	1,	'Policy for Last 6 Month',	0,	'2023-10-11 12:24:13',	'2023-10-25 07:50:09'),
(32,	'e3d64177e51bdff82b499e116796fe74',	NULL,	NULL,	2,	'Reapetive Shift',	6,	'2023-10-27 11:36:58',	'2023-10-28 05:41:55'),
(37,	'e3d64177e51bdff82b499e116796fe74',	NULL,	NULL,	3,	'FD Open',	0,	'2023-10-28 12:54:50',	'2023-10-28 12:54:50');

DROP TABLE IF EXISTS `policy_attendance_shift_type_items`;
CREATE TABLE `policy_attendance_shift_type_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attendance_shift_id` int(11) DEFAULT NULL,
  `business_id` longtext DEFAULT NULL,
  `branch_id` longtext DEFAULT NULL,
  `depart_id` longtext DEFAULT NULL,
  `shift_name` varchar(255) DEFAULT NULL,
  `shift_start` time DEFAULT NULL,
  `shift_hr` int(11) DEFAULT NULL,
  `shift_end` time DEFAULT NULL,
  `shift_min` int(11) DEFAULT NULL,
  `work_hr` int(11) DEFAULT NULL,
  `work_min` int(11) DEFAULT NULL,
  `break_min` int(11) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_attendance_shift_type_items` (`id`, `attendance_shift_id`, `business_id`, `branch_id`, `depart_id`, `shift_name`, `shift_start`, `shift_hr`, `shift_end`, `shift_min`, `work_hr`, `work_min`, `break_min`, `is_active`, `is_paid`, `created_at`, `updated_at`) VALUES
(67,	26,	'bd545732e12addf17c34a231d24a3814',	'',	NULL,	'General Shift',	'09:30:00',	NULL,	'18:30:00',	NULL,	9,	0,	45,	1,	1,	'2023-10-25 04:51:48',	'2023-10-03 10:55:27'),
(68,	27,	'e3d64177e51bdff82b499e116796fe74',	'',	NULL,	'Policy for First 6 Month',	'09:30:00',	NULL,	'17:30:00',	NULL,	7,	30,	30,	1,	0,	'2023-10-25 07:50:33',	'2023-10-25 13:20:33'),
(80,	30,	'e3d64177e51bdff82b499e116796fe74',	'',	NULL,	'Policy for Last 6 Month',	'10:30:00',	NULL,	'18:30:00',	NULL,	7,	30,	30,	1,	0,	'2023-10-25 07:50:09',	'2023-10-25 13:20:09'),
(131,	32,	'e3d64177e51bdff82b499e116796fe74',	'',	NULL,	'Shift A',	'04:00:00',	NULL,	'12:00:00',	NULL,	8,	0,	20,	1,	1,	'2023-10-28 05:54:46',	'2023-10-28 05:41:55'),
(132,	32,	'e3d64177e51bdff82b499e116796fe74',	'',	NULL,	'Shift B',	'12:00:00',	NULL,	'20:00:00',	NULL,	8,	0,	20,	0,	1,	'2023-10-28 05:54:46',	'2023-10-28 05:41:55'),
(139,	29,	'e3d64177e51bdff82b499e116796fe74',	'',	NULL,	'SET A',	'08:00:00',	NULL,	'16:00:00',	NULL,	8,	0,	30,	1,	1,	'2023-10-28 05:58:46',	'2023-10-28 05:53:36'),
(140,	29,	'e3d64177e51bdff82b499e116796fe74',	'',	NULL,	'SET B',	'16:00:00',	NULL,	'00:00:00',	NULL,	7,	30,	30,	0,	0,	'2023-10-28 05:53:36',	'2023-10-28 05:53:36'),
(141,	37,	'e3d64177e51bdff82b499e116796fe74',	'',	NULL,	'FD Open',	NULL,	9,	NULL,	12,	NULL,	NULL,	30,	1,	1,	'2023-10-28 12:54:50',	'2023-10-28 18:24:50');

DROP TABLE IF EXISTS `policy_attendance_track_in_out`;
CREATE TABLE `policy_attendance_track_in_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `branch_id` longtext DEFAULT NULL,
  `department_id` longtext DEFAULT NULL,
  `track_in_out` tinyint(1) NOT NULL DEFAULT 0,
  `no_attendace_without_punch` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_attendance_track_in_out` (`id`, `business_id`, `branch_id`, `department_id`, `track_in_out`, `no_attendace_without_punch`, `updated_at`, `created_at`) VALUES
(11,	'e3d64177e51bdff82b499e116796fe74',	NULL,	NULL,	1,	0,	'2023-09-28 13:12:43',	'2023-10-05 15:08:21'),
(13,	'bd545732e12addf17c34a231d24a3814',	NULL,	NULL,	0,	1,	'2023-10-03 05:17:24',	'2023-10-03 05:17:24');

DROP TABLE IF EXISTS `policy_atten_rule_break`;
CREATE TABLE `policy_atten_rule_break` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `switch_is` tinyint(1) unsigned zerofill DEFAULT NULL,
  `is_break_hr_deduct` tinyint(1) unsigned zerofill DEFAULT NULL,
  `break_extra_hr` int(2) unsigned zerofill DEFAULT NULL,
  `break_extra_min` int(2) unsigned zerofill DEFAULT NULL,
  `occurance_is` tinyint(1) unsigned zerofill DEFAULT NULL,
  `occurance_hr` int(2) unsigned zerofill DEFAULT NULL,
  `occurance_min` int(2) unsigned zerofill DEFAULT NULL,
  `occurance_count` int(2) unsigned zerofill DEFAULT NULL,
  `absent_is` tinyint(1) unsigned zerofill DEFAULT NULL,
  `business_id` longtext DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_atten_rule_break` (`id`, `switch_is`, `is_break_hr_deduct`, `break_extra_hr`, `break_extra_min`, `occurance_is`, `occurance_hr`, `occurance_min`, `occurance_count`, `absent_is`, `business_id`, `updated_at`, `created_at`) VALUES
(3,	1,	NULL,	00,	15,	1,	00,	00,	03,	1,	'bd545732e12addf17c34a231d24a3814',	'2023-10-03 05:17:01',	'2023-10-03 05:17:01'),
(4,	0,	NULL,	00,	20,	2,	02,	00,	NULL,	1,	'e3d64177e51bdff82b499e116796fe74',	'2023-10-18 05:20:04',	'2023-10-23 06:54:27');

DROP TABLE IF EXISTS `policy_atten_rule_early_exit`;
CREATE TABLE `policy_atten_rule_early_exit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `switch_is` tinyint(1) NOT NULL,
  `grace_time_hr` int(2) DEFAULT NULL,
  `grace_time_min` int(2) DEFAULT NULL,
  `occurance_is` int(1) DEFAULT NULL,
  `occurance_count` int(2) DEFAULT NULL,
  `occurance_hr` int(2) DEFAULT NULL,
  `occurance_min` int(2) DEFAULT NULL,
  `absent_is` int(1) DEFAULT NULL,
  `mark_half_day_hr` int(2) DEFAULT NULL,
  `mark_half_day_min` int(2) DEFAULT NULL,
  `business_id` longtext DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_atten_rule_early_exit` (`id`, `switch_is`, `grace_time_hr`, `grace_time_min`, `occurance_is`, `occurance_count`, `occurance_hr`, `occurance_min`, `absent_is`, `mark_half_day_hr`, `mark_half_day_min`, `business_id`, `updated_at`, `created_at`) VALUES
(3,	1,	0,	30,	1,	3,	0,	1,	1,	2,	30,	'bd545732e12addf17c34a231d24a3814',	'2023-10-03 05:17:01',	'0000-00-00 00:00:00'),
(4,	1,	0,	10,	2,	NULL,	2,	0,	1,	2,	30,	'e3d64177e51bdff82b499e116796fe74',	'2023-10-23 08:18:37',	'2023-10-23 08:18:37');

DROP TABLE IF EXISTS `policy_atten_rule_gatepass`;
CREATE TABLE `policy_atten_rule_gatepass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `switch_is` int(1) DEFAULT NULL,
  `occurance_is` int(1) DEFAULT NULL,
  `occurance_count` int(2) DEFAULT NULL,
  `occurance_hr` int(2) DEFAULT NULL,
  `occurance_min` int(2) DEFAULT NULL,
  `absent_is` int(1) DEFAULT NULL,
  `business_id` longtext NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_atten_rule_gatepass` (`id`, `switch_is`, `occurance_is`, `occurance_count`, `occurance_hr`, `occurance_min`, `absent_is`, `business_id`, `updated_at`, `created_at`) VALUES
(3,	1,	1,	5,	0,	0,	1,	'bd545732e12addf17c34a231d24a3814',	'2023-10-03 05:17:01',	'0000-00-00 00:00:00'),
(4,	0,	2,	NULL,	0,	30,	1,	'e3d64177e51bdff82b499e116796fe74',	'2023-10-23 06:54:31',	'2023-10-23 06:54:31');

DROP TABLE IF EXISTS `policy_atten_rule_late_entry`;
CREATE TABLE `policy_atten_rule_late_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `switch_is` tinyint(1) DEFAULT NULL,
  `grace_time_hr` int(2) DEFAULT NULL,
  `grace_time_min` int(2) DEFAULT NULL,
  `occurance_is` int(1) DEFAULT NULL,
  `occurance_count` int(2) DEFAULT NULL,
  `occurance_hr` int(2) DEFAULT NULL,
  `occurance_min` int(2) DEFAULT NULL,
  `absent_is` int(1) DEFAULT NULL,
  `mark_half_day_hr` int(2) DEFAULT NULL,
  `mark_half_day_min` int(2) DEFAULT NULL,
  `business_id` longtext DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_atten_rule_late_entry` (`id`, `switch_is`, `grace_time_hr`, `grace_time_min`, `occurance_is`, `occurance_count`, `occurance_hr`, `occurance_min`, `absent_is`, `mark_half_day_hr`, `mark_half_day_min`, `business_id`, `updated_at`, `created_at`) VALUES
(3,	1,	0,	30,	1,	5,	0,	0,	1,	2,	30,	'bd545732e12addf17c34a231d24a3814',	'2023-10-03 05:17:01',	'0000-00-00 00:00:00'),
(4,	1,	0,	15,	2,	NULL,	2,	0,	1,	2,	30,	'e3d64177e51bdff82b499e116796fe74',	'2023-10-30 12:00:00',	'2023-10-30 12:00:00');

DROP TABLE IF EXISTS `policy_atten_rule_misspunch`;
CREATE TABLE `policy_atten_rule_misspunch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `switch_is` tinyint(1) NOT NULL,
  `occurance_is` int(1) DEFAULT NULL,
  `occurance_count` int(2) DEFAULT NULL,
  `occurance_hr` int(2) DEFAULT NULL,
  `occurance_min` int(2) DEFAULT NULL,
  `absent_is` int(1) DEFAULT NULL,
  `business_id` longtext NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_atten_rule_misspunch` (`id`, `switch_is`, `occurance_is`, `occurance_count`, `occurance_hr`, `occurance_min`, `absent_is`, `business_id`, `updated_at`, `created_at`) VALUES
(3,	1,	1,	3,	0,	0,	2,	'bd545732e12addf17c34a231d24a3814',	'2023-10-03 05:17:01',	'0000-00-00 00:00:00'),
(4,	1,	2,	NULL,	2,	50,	1,	'e3d64177e51bdff82b499e116796fe74',	'2023-10-28 09:39:16',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `policy_atten_rule_overtime`;
CREATE TABLE `policy_atten_rule_overtime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `switch_is` tinyint(1) NOT NULL,
  `early_ot_hr` int(2) NOT NULL,
  `early_ot_min` int(2) NOT NULL,
  `late_ot_hr` int(2) NOT NULL,
  `late_ot_min` int(2) NOT NULL,
  `min_ot_hr` int(2) NOT NULL,
  `min_ot_min` int(2) NOT NULL,
  `max_ot_hr` int(2) NOT NULL,
  `max_ot_min` int(2) NOT NULL,
  `business_id` longtext NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_atten_rule_overtime` (`id`, `switch_is`, `early_ot_hr`, `early_ot_min`, `late_ot_hr`, `late_ot_min`, `min_ot_hr`, `min_ot_min`, `max_ot_hr`, `max_ot_min`, `business_id`, `updated_at`, `created_at`) VALUES
(3,	1,	0,	15,	1,	30,	10,	0,	30,	0,	'bd545732e12addf17c34a231d24a3814',	'2023-10-03 05:17:01',	'0000-00-00 00:00:00'),
(4,	1,	0,	30,	0,	30,	1,	0,	40,	0,	'e3d64177e51bdff82b499e116796fe74',	'2023-10-23 07:07:54',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `policy_holiday_details`;
CREATE TABLE `policy_holiday_details` (
  `holiday_id` int(11) NOT NULL AUTO_INCREMENT,
  `template_id` int(11) DEFAULT NULL,
  `business_id` longtext DEFAULT NULL,
  `holiday_name` varchar(255) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `holiday_date` date DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`holiday_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_holiday_details` (`holiday_id`, `template_id`, `business_id`, `holiday_name`, `day`, `holiday_date`, `updated_at`, `created_at`) VALUES
(5,	3,	'e3d64177e51bdff82b499e116796fe74',	'Maha Shiv Ratri',	'Thursday',	'2023-09-07',	'2023-09-26 18:50:33',	'2023-09-26 18:50:33'),
(10,	3,	'e3d64177e51bdff82b499e116796fe74',	'sdf',	'Thursday',	'2023-08-31',	NULL,	NULL),
(11,	6,	'e3d64177e51bdff82b499e116796fe74',	'asdf',	'Wednesday',	'2023-09-13',	'2023-09-28 16:50:57',	'2023-09-28 16:50:57'),
(12,	6,	'e3d64177e51bdff82b499e116796fe74',	'asdf',	'Monday',	'2023-09-04',	'2023-09-28 16:50:57',	'2023-09-28 16:50:57'),
(13,	6,	'e3d64177e51bdff82b499e116796fe74',	'Dubai',	'Wednesday',	'2023-08-30',	'2023-09-28 16:50:57',	'2023-09-28 16:50:57'),
(15,	8,	'bd545732e12addf17c34a231d24a3814',	'New Year',	'Sunday',	'2023-01-01',	'2023-10-02 12:43:26',	'2023-10-02 12:43:26'),
(16,	8,	'bd545732e12addf17c34a231d24a3814',	'Republic Day',	'Thursday',	'2023-01-26',	'2023-10-02 12:43:26',	'2023-10-02 12:43:26'),
(17,	8,	'bd545732e12addf17c34a231d24a3814',	'Holi',	'Tuesday',	'2023-03-07',	'2023-10-02 12:43:26',	'2023-10-02 12:43:26'),
(18,	8,	'bd545732e12addf17c34a231d24a3814',	'Independence Day',	'Tuesday',	'2023-08-15',	'2023-10-02 12:43:26',	'2023-10-02 12:43:26'),
(19,	9,	'e3d64177e51bdff82b499e116796fe74',	'Day 1',	'Monday',	'2023-10-02',	'2023-10-04 12:21:44',	'2023-10-04 12:21:44'),
(25,	9,	'e3d64177e51bdff82b499e116796fe74',	'ASDF',	'Thursday',	'2023-10-05',	NULL,	NULL),
(35,	10,	'e3d64177e51bdff82b499e116796fe74',	'Dashehara',	'Tuesday',	'2023-10-24',	'2023-10-10 10:12:51',	'2023-10-10 10:12:51');

DROP TABLE IF EXISTS `policy_holiday_template`;
CREATE TABLE `policy_holiday_template` (
  `temp_id` int(255) NOT NULL AUTO_INCREMENT,
  `temp_name` varchar(255) DEFAULT NULL,
  `temp_from` date DEFAULT NULL,
  `temp_to` date DEFAULT NULL,
  `business_id` longtext DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`temp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_holiday_template` (`temp_id`, `temp_name`, `temp_from`, `temp_to`, `business_id`, `updated_at`, `created_at`) VALUES
(3,	'Maha Shiv Ratri',	'2023-09-07',	'2023-09-08',	'e3d64177e51bdff82b499e116796fe74',	'2023-09-26 18:50:33',	'2023-09-26 18:50:33'),
(6,	'getting rooted',	'2023-09-15',	'2023-09-10',	'e3d64177e51bdff82b499e116796fe74',	'2023-09-28 16:50:57',	'2023-09-28 16:50:57'),
(8,	'Creative Minds Holiday Policy',	'2023-01-01',	'2023-12-31',	'bd545732e12addf17c34a231d24a3814',	'2023-10-02 12:43:26',	'2023-10-02 12:43:26'),
(9,	'All Fest',	'2023-10-01',	'2023-10-30',	'e3d64177e51bdff82b499e116796fe74',	'2023-10-04 12:21:44',	'2023-10-04 12:21:44'),
(10,	'Navratri',	'2023-10-15',	'2023-10-24',	'e3d64177e51bdff82b499e116796fe74',	'2023-10-10 10:12:51',	'2023-10-10 10:12:51');

DROP TABLE IF EXISTS `policy_master_endgame_method`;
CREATE TABLE `policy_master_endgame_method` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `method_switch` tinyint(1) DEFAULT NULL,
  `method_name` varchar(255) DEFAULT NULL,
  `policy_preference` tinyint(4) DEFAULT NULL,
  `level_type` tinyint(1) unsigned zerofill DEFAULT 0,
  `leave_policy_ids_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`leave_policy_ids_list`)),
  `holiday_policy_ids_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`holiday_policy_ids_list`)),
  `weekly_policy_ids_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`weekly_policy_ids_list`)),
  `shift_settings_ids_list` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`shift_settings_ids_list`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_master_endgame_method` (`id`, `business_id`, `method_switch`, `method_name`, `policy_preference`, `level_type`, `leave_policy_ids_list`, `holiday_policy_ids_list`, `weekly_policy_ids_list`, `shift_settings_ids_list`, `created_at`, `updated_at`) VALUES
(38,	'bd545732e12addf17c34a231d24a3814',	1,	'Creative Minds Approved Rule',	1,	1,	'[\"18\"]',	'[\"8\"]',	'[\"10\"]',	'[\"26\"]',	'2023-10-03 19:09:36',	'0000-00-00 00:00:00'),
(247,	'e3d64177e51bdff82b499e116796fe74',	0,	'INDIA',	1,	1,	'[\"10\"]',	'[\"9\"]',	'[\"4\"]',	'[\"30\"]',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14'),
(250,	'e3d64177e51bdff82b499e116796fe74',	1,	'Indus',	1,	1,	'[\"10\"]',	'[\"6\",\"10\"]',	'[\"11\"]',	'[\"27\",\"29\",\"30\",\"37\"]',	'2023-11-02 12:07:14',	'2023-11-02 17:37:14');

DROP TABLE IF EXISTS `policy_setting_leave_category`;
CREATE TABLE `policy_setting_leave_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_policy_id` int(11) DEFAULT NULL,
  `business_id` longtext DEFAULT NULL,
  `branch_id` longtext DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `days` int(11) DEFAULT NULL,
  `unused_leave_rule` varchar(200) DEFAULT NULL,
  `carry_forward_limit` int(11) DEFAULT NULL,
  `applicable_to` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_setting_leave_category` (`id`, `leave_policy_id`, `business_id`, `branch_id`, `category_name`, `days`, `unused_leave_rule`, `carry_forward_limit`, `applicable_to`, `created_at`, `updated_at`) VALUES
(131,	18,	'bd545732e12addf17c34a231d24a3814',	'',	'CL',	1,	'Carry Forward',	10,	'All',	'2023-10-02 12:55:28',	'2023-10-02 12:55:28'),
(132,	18,	'bd545732e12addf17c34a231d24a3814',	'',	'SL',	1,	'Carry Forward',	10,	'All',	'2023-10-02 12:55:28',	'2023-10-02 12:55:28'),
(145,	10,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'CL',	1,	'Carry Forward',	5,	'All',	'2023-10-31 07:17:44',	'2023-10-31 07:17:44'),
(146,	10,	'e3d64177e51bdff82b499e116796fe74',	NULL,	'SL',	1,	'Carry Forward',	5,	'All',	'2023-10-31 07:17:44',	'2023-10-31 07:17:44');

DROP TABLE IF EXISTS `policy_setting_leave_policy`;
CREATE TABLE `policy_setting_leave_policy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `branch_id` longtext DEFAULT NULL,
  `policy_name` varchar(255) DEFAULT NULL,
  `leave_policy_cycle_monthly` tinyint(1) unsigned zerofill DEFAULT 0,
  `leave_policy_cycle_yearly` tinyint(1) unsigned zerofill DEFAULT 0,
  `leave_period_from` date DEFAULT NULL,
  `leave_period_to` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_setting_leave_policy` (`id`, `business_id`, `branch_id`, `policy_name`, `leave_policy_cycle_monthly`, `leave_policy_cycle_yearly`, `leave_period_from`, `leave_period_to`, `created_at`, `updated_at`) VALUES
(10,	'e3d64177e51bdff82b499e116796fe74',	'',	'Fixing Dots Leave Policy',	1,	0,	'2023-09-07',	'2023-09-12',	'2023-10-25 07:54:35',	'2023-09-28 00:19:49'),
(18,	'bd545732e12addf17c34a231d24a3814',	'',	'Creative Minds Leave Policy',	1,	0,	'2023-01-01',	'2023-12-31',	'2023-10-02 12:55:28',	'2023-10-02 12:55:28');

DROP TABLE IF EXISTS `policy_setting_role_assign_permission`;
CREATE TABLE `policy_setting_role_assign_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `emp_id` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) unsigned DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `designation_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_setting_role_assign_permission` (`id`, `business_id`, `emp_id`, `role_id`, `branch_id`, `department_id`, `designation_id`, `created_at`, `updated_at`) VALUES
(13,	'e3d64177e51bdff82b499e116796fe74',	'IT008',	1,	'd845e2bc8a80f01f71ea5699a91308253',	'11',	'28',	'2023-10-16 12:10:01',	'2023-10-16 12:10:01'),
(14,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	3,	'd845e2bc8a80f01f71ea5699a91308253',	'11',	'28',	'2023-11-03 05:04:59',	'2023-11-03 05:04:59');

DROP TABLE IF EXISTS `policy_setting_role_create`;
CREATE TABLE `policy_setting_role_create` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `branch_id` varchar(255) DEFAULT NULL,
  `roles_name` varchar(225) DEFAULT NULL,
  `description` varchar(225) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `role_name` (`roles_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_setting_role_create` (`id`, `business_id`, `branch_id`, `roles_name`, `description`, `created_at`, `updated_at`) VALUES
(1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Admin',	'set access',	'2023-09-25 18:49:47',	'2023-09-25 18:49:47'),
(2,	'e3d64177e51bdff82b499e116796fe74',	'',	'HR Access',	'set access',	'2023-09-26 18:57:16',	'2023-09-26 18:57:16'),
(3,	'e3d64177e51bdff82b499e116796fe74',	'',	'MD',	'set access',	'2023-10-01 08:03:08',	'2023-10-01 08:03:08'),
(5,	'e3d64177e51bdff82b499e116796fe74',	'',	'Super Admin',	'view creditionals',	'2023-10-05 04:59:35',	'2023-10-05 04:59:35'),
(6,	'e3d64177e51bdff82b499e116796fe74',	'',	'HR',	'Full access View creditionals',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55');

DROP TABLE IF EXISTS `policy_setting_role_items`;
CREATE TABLE `policy_setting_role_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_create_id` bigint(20) DEFAULT NULL,
  `business_id` longtext DEFAULT NULL,
  `branch_id` longtext DEFAULT NULL,
  `model_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_setting_role_items` (`id`, `role_create_id`, `business_id`, `branch_id`, `model_name`, `created_at`, `updated_at`) VALUES
(73,	2,	'e3d64177e51bdff82b499e116796fe74',	'',	'Dashboard.View',	'2023-09-26 18:57:16',	'2023-09-26 18:57:16'),
(74,	2,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance.View',	'2023-09-26 18:57:16',	'2023-09-26 18:57:16'),
(75,	2,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance Setting.View',	'2023-09-26 18:57:16',	'2023-09-26 18:57:16'),
(76,	2,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance Attedance-Mode.View',	'2023-09-26 18:57:16',	'2023-09-26 18:57:16'),
(77,	2,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance Access-List.View',	'2023-09-26 18:57:16',	'2023-09-26 18:57:16'),
(78,	2,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance Shift.View',	'2023-09-26 18:57:16',	'2023-09-26 18:57:16'),
(79,	2,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance Automation-Rules.View',	'2023-09-26 18:57:16',	'2023-09-26 18:57:16'),
(80,	2,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance TrackIn-OutTime.View',	'2023-09-26 18:57:16',	'2023-09-26 18:57:16'),
(81,	2,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance Holiday.View',	'2023-09-26 18:57:16',	'2023-09-26 18:57:16'),
(103,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Dashboard.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(104,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(105,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Leave.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(106,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Miss Punch.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(107,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Gate Pass.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(108,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance Setting.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(109,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance Attedance-Mode.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(110,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance Access-List.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(111,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance Shift.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(112,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance Automation-Rules.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(113,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance TrackIn-OutTime.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(114,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance Holiday.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(115,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Business Setting.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(116,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Branch Setting.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(117,	1,	'e3d64177e51bdff82b499e116796fe74',	'',	'Department Setting.View',	'2023-09-28 06:45:18',	'2023-09-28 06:45:18'),
(118,	3,	'e3d64177e51bdff82b499e116796fe74',	'',	'Dashboard.View',	'2023-10-01 08:03:08',	'2023-10-01 08:03:08'),
(119,	3,	'e3d64177e51bdff82b499e116796fe74',	'',	'Employee.View',	'2023-10-01 08:03:08',	'2023-10-01 08:03:08'),
(120,	3,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance.View',	'2023-10-01 08:03:08',	'2023-10-01 08:03:08'),
(121,	3,	'e3d64177e51bdff82b499e116796fe74',	'',	'Roles & Permissions.View',	'2023-10-01 08:03:08',	'2023-10-01 08:03:08'),
(122,	3,	'e3d64177e51bdff82b499e116796fe74',	'',	'Roles & Permissions.Update',	'2023-10-01 08:03:08',	'2023-10-01 08:03:08'),
(123,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Dashboard.View',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(124,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Dashboard.Create',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(125,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Dashboard.Update',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(126,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Dashboard.Delete',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(127,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Employee.View',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(128,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Employee.Create',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(129,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Employee.Update',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(130,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Employee.Delete',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(131,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Attendance.View',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(132,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Attendance.Create',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(133,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Attendance.Update',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(134,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Attendance.Delete',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(135,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Leave.View',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(136,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Leave.Create',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(137,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Leave.Update',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(138,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Leave.Delete',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(139,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Miss Punch.View',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(140,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Miss Punch.Create',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(141,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Miss Punch.Update',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(142,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Miss Punch.Delete',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(143,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Gate Pass.View',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(144,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Gate Pass.Create',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(145,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Gate Pass.Update',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(146,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Gate Pass.Delete',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(147,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Roles & Permissions.View',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(148,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Roles & Permissions.Create',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(149,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Roles & Permissions.Update',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(150,	4,	'bd545732e12addf17c34a231d24a3814',	'',	'Roles & Permissions.Delete',	'2023-10-04 11:55:30',	'2023-10-04 11:55:30'),
(151,	5,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance.View',	'2023-10-05 04:59:35',	'2023-10-05 04:59:35'),
(152,	5,	'e3d64177e51bdff82b499e116796fe74',	'',	'Leave.View',	'2023-10-05 04:59:35',	'2023-10-05 04:59:35'),
(153,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Dashboard.View',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(154,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Dashboard.Create',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(155,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Dashboard.Update',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(156,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Dashboard.Delete',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(157,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Employee.View',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(158,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Employee.Create',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(159,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Employee.Update',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(160,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Employee.Delete',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(161,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance.View',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(162,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance.Create',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(163,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance.Update',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(164,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Attendance.Delete',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(165,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Leave.View',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(166,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Leave.Create',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(167,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Leave.Update',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(168,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Leave.Delete',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(169,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Miss Punch.View',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(170,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Miss Punch.Create',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(171,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Miss Punch.Update',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(172,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Miss Punch.Delete',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(173,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Gate Pass.View',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(174,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Gate Pass.Create',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(175,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Gate Pass.Update',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(176,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Gate Pass.Delete',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(177,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Roles & Permissions.View',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(178,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Roles & Permissions.Create',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(179,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Roles & Permissions.Update',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55'),
(180,	6,	'e3d64177e51bdff82b499e116796fe74',	'',	'Roles & Permissions.Delete',	'2023-10-16 12:37:55',	'2023-10-16 12:37:55');

DROP TABLE IF EXISTS `policy_weekly_holiday_list`;
CREATE TABLE `policy_weekly_holiday_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `days` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `policy_weekly_holiday_list` (`id`, `business_id`, `name`, `days`, `created_at`, `updated_at`) VALUES
(4,	'e3d64177e51bdff82b499e116796fe74',	'weeklyoff A',	'[\"Saturday\"]',	'2023-10-31 09:39:17',	'2023-09-28 14:05:37'),
(10,	'bd545732e12addf17c34a231d24a3814',	'Creative Minds Week Off',	'[\"Sunday\"]',	'2023-10-02 07:30:29',	'2023-10-02 12:56:21'),
(11,	'e3d64177e51bdff82b499e116796fe74',	'weeklyoff B',	'[\"Saturday\",\"Sunday\"]',	'2023-11-01 12:44:26',	'2023-10-04 22:53:01');

DROP TABLE IF EXISTS `request_gatepass_list`;
CREATE TABLE `request_gatepass_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `emp_id` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `going_through` varchar(255) DEFAULT NULL,
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `request_gatepass_list` (`id`, `business_id`, `emp_id`, `date`, `going_through`, `in_time`, `out_time`, `source`, `destination`, `reason`, `status`, `remark`, `created_at`, `updated_at`) VALUES
(9,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'2023-09-30',	'Auto',	'13:23:00',	'13:23:00',	NULL,	NULL,	'Qetj',	'2',	'hii',	'2023-09-30 13:23:42',	'2023-09-30 13:23:42'),
(10,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'2023-09-30',	'Scooty',	'13:26:00',	'13:26:00',	NULL,	NULL,	'4hh',	'2',	'sddsfaf',	'2023-09-30 13:26:25',	'2023-09-30 13:26:25'),
(11,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'2023-09-30',	'Car',	'17:05:00',	'16:10:00',	NULL,	NULL,	'Collect parcel',	'1',	NULL,	'2023-09-30 15:38:12',	'2023-09-30 15:38:12'),
(13,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'2023-10-10',	'JCB',	'12:50:00',	'16:35:00',	NULL,	NULL,	'Movie time',	'2',	'Not a valid reason',	'2023-10-10 10:45:06',	'2023-10-10 10:45:06'),
(15,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'0',	NULL,	'2023-10-12 18:01:19',	'2023-10-12 18:01:19'),
(16,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'2023-10-10',	'Auto',	'17:03:01',	'16:03:00',	NULL,	NULL,	'Ggggggg',	'0',	NULL,	'2023-10-12 18:03:24',	'2023-10-12 18:03:24'),
(17,	'e3d64177e51bdff82b499e116796fe74',	'IT010',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'0',	NULL,	'2023-10-27 18:02:33',	'2023-10-27 18:02:33'),
(18,	'e3d64177e51bdff82b499e116796fe74',	'IT010',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'0',	NULL,	'2023-10-27 18:04:03',	'2023-10-27 18:04:03'),
(19,	'e3d64177e51bdff82b499e116796fe74',	'IT010',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'0',	NULL,	'2023-10-27 18:04:09',	'2023-10-27 18:04:09'),
(20,	'e3d64177e51bdff82b499e116796fe74',	'IT010',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'0',	NULL,	'2023-10-27 18:04:25',	'2023-10-27 18:04:25'),
(21,	'e3d64177e51bdff82b499e116796fe74',	'IT010',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'0',	NULL,	'2023-10-27 18:05:03',	'2023-10-27 18:05:03'),
(22,	'e3d64177e51bdff82b499e116796fe74',	'IT010',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'0',	NULL,	'2023-10-27 18:05:41',	'2023-10-27 18:05:41'),
(23,	'e3d64177e51bdff82b499e116796fe74',	'IT010',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'0',	NULL,	'2023-10-27 18:06:40',	'2023-10-27 18:06:40'),
(24,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'2023-10-10',	'Car',	'12:50:00',	'12:50:00',	NULL,	NULL,	'cjjjj',	'0',	NULL,	'2023-11-01 11:39:02',	'2023-11-01 11:39:02'),
(25,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'2023-10-10',	'Car',	'12:50:00',	'12:50:00',	NULL,	NULL,	'cjjjj',	'0',	NULL,	'2023-11-01 11:41:50',	'2023-11-01 11:41:50'),
(26,	'e3d64177e51bdff82b499e116796fe74',	'IT121',	'2023-11-20',	NULL,	NULL,	NULL,	NULL,	NULL,	NULL,	'0',	NULL,	'2023-11-01 12:13:43',	'2023-11-01 12:13:43'),
(27,	'e3d64177e51bdff82b499e116796fe74',	'IT121',	'2023-11-20',	'Auto',	'04:20:00',	'10:30:00',	'Raipur',	'Bilashpur',	'Fov Visiting',	'0',	NULL,	'2023-11-01 12:21:07',	'2023-11-01 12:21:07'),
(28,	'e3d64177e51bdff82b499e116796fe74',	'IT121',	'2023-11-20',	'Auto',	'04:20:00',	'10:30:00',	'Raipur',	'Bilashpur',	'Fov Visiting',	'0',	NULL,	'2023-11-01 12:21:22',	'2023-11-01 12:21:22'),
(29,	'e3d64177e51bdff82b499e116796fe74',	'IT121',	'2023-11-20',	'Auto',	'04:20:00',	'10:30:00',	'Raipur',	'Bilashpur',	'Fov Visiting',	'0',	NULL,	'2023-11-01 12:21:33',	'2023-11-01 12:21:33'),
(30,	'e3d64177e51bdff82b499e116796fe74',	'IT121',	'2023-11-20',	'Auto',	'04:20:00',	'10:30:00',	'Raipur',	'Bilashpur',	'Fov Visiting',	'0',	NULL,	'2023-11-01 12:21:39',	'2023-11-01 12:21:39'),
(31,	'e3d64177e51bdff82b499e116796fe74',	'IT121',	'2023-11-20',	'Auto',	'04:20:00',	'10:30:00',	'Raipur',	'Bilashpur',	'Fov Visiting',	'0',	NULL,	'2023-11-01 12:26:27',	'2023-11-01 12:26:27'),
(32,	'e3d64177e51bdff82b499e116796fe74',	'IT121',	'2023-11-20',	'Auto',	'04:20:00',	'10:30:00',	'Raipur',	'Bilashpur',	'Fov Visiting',	'0',	NULL,	'2023-11-01 12:28:10',	'2023-11-01 12:28:10'),
(33,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'2023-10-10',	'Car',	'12:50:00',	'12:50:00',	NULL,	NULL,	'cjjjj',	'0',	NULL,	'2023-11-01 12:30:20',	'2023-11-01 12:30:20'),
(34,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'2023-10-10',	'Car',	'12:50:00',	'12:50:00',	NULL,	NULL,	'cjjjj',	'0',	NULL,	'2023-11-01 12:30:43',	'2023-11-01 12:30:43'),
(35,	'e3d64177e51bdff82b499e116796fe74',	'IT121',	'2023-11-20',	'Auto',	'04:20:00',	'14:00:00',	'Raipur',	'Bilashpur',	'Fov Visiting',	'0',	NULL,	'2023-11-01 12:37:03',	'2023-11-01 12:37:03'),
(36,	'e3d64177e51bdff82b499e116796fe74',	'IT121',	'2023-11-20',	'Auto',	'04:20:00',	'14:00:00',	'Raipur',	'Bilashpur',	'For Visiting',	'0',	NULL,	'2023-11-01 12:37:19',	'2023-11-01 12:37:19'),
(37,	'e3d64177e51bdff82b499e116796fe74',	'IT121',	'2023-11-20',	'Auto',	'04:20:00',	'14:00:00',	'Raipur',	'Bilashpur',	'For Visiting',	'0',	NULL,	'2023-11-01 12:39:07',	'2023-11-01 12:39:07'),
(40,	'e3d64177e51bdff82b499e116796fe74',	'IT0012',	'2023-11-01',	'Scotty',	'15:08:00',	'15:07:00',	'ttt',	'hhh',	'Ggggg',	'2',	'asdf',	'2023-11-01 15:08:31',	'2023-11-02 15:19:47'),
(41,	'e3d64177e51bdff82b499e116796fe74',	'IT0012',	'2023-11-08',	'Car',	'17:46:00',	'16:46:00',	'uu',	'jj',	'Hhh',	'1',	NULL,	'2023-11-01 15:47:13',	'2023-11-02 15:18:23'),
(42,	'e3d64177e51bdff82b499e116796fe74',	'IT0012',	'2023-11-01',	'Car',	'17:46:00',	'16:46:00',	'uu',	'jj',	'Hhh',	'1',	NULL,	'2023-11-01 16:01:02',	'2023-11-01 16:01:02'),
(43,	'e3d64177e51bdff82b499e116796fe74',	'IT0012',	'2023-11-02',	'Truck',	'18:13:00',	'17:13:00',	'ii',	'yyyy',	'Uuuuuu',	'2',	'adf',	'2023-11-01 16:14:09',	'2023-11-01 16:14:09');

DROP TABLE IF EXISTS `request_leave_list`;
CREATE TABLE `request_leave_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` varchar(255) DEFAULT NULL,
  `emp_id` varchar(255) DEFAULT NULL,
  `emp_mobile_no` varchar(255) DEFAULT NULL,
  `leave_type` tinyint(1) DEFAULT NULL,
  `leave_category` int(11) NOT NULL DEFAULT 0,
  `shift_type` tinyint(1) NOT NULL DEFAULT 0,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `days` double DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `request_leave_list` (`id`, `business_id`, `emp_id`, `emp_mobile_no`, `leave_type`, `leave_category`, `shift_type`, `from_date`, `to_date`, `days`, `reason`, `remark`, `status`, `created_at`, `updated_at`) VALUES
(1,	'e3d64177e51bdff82b499e116796fe74',	'IT010',	'9658473211',	1,	145,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'2023-11-01 16:38:17',	'2023-11-03 01:05:54'),
(2,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	1,	146,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'2023-11-01 17:01:54',	'2023-11-03 01:05:54'),
(3,	'e3d64177e51bdff82b499e116796fe74',	'IT010',	'9658473211',	2,	145,	2,	'2023-10-10',	NULL,	NULL,	NULL,	NULL,	0,	'2023-11-01 17:16:15',	'2023-11-03 01:05:54'),
(4,	'e3d64177e51bdff82b499e116796fe74',	'IT010',	'9658473211',	1,	145,	1,	'2023-10-10',	NULL,	NULL,	NULL,	NULL,	0,	'2023-11-01 17:16:21',	'2023-11-03 01:05:54'),
(5,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	1,	145,	1,	NULL,	NULL,	NULL,	NULL,	NULL,	0,	'2023-11-01 17:18:17',	'2023-11-03 01:05:54'),
(6,	'e3d64177e51bdff82b499e116796fe74',	'IT010',	'9658473211',	1,	146,	2,	'2023-10-10',	'2023-11-10',	1,	'1',	NULL,	0,	'2023-11-01 17:29:08',	'2023-11-03 01:05:54'),
(7,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	2,	146,	1,	'2023-10-10',	NULL,	0.5,	NULL,	NULL,	0,	'2023-11-01 17:32:22',	'2023-11-03 05:29:13');

DROP TABLE IF EXISTS `request_mispunch_list`;
CREATE TABLE `request_mispunch_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext DEFAULT NULL,
  `emp_id` varchar(255) DEFAULT NULL,
  `emp_mobile_no` varchar(10) DEFAULT NULL,
  `emp_miss_date` varchar(50) DEFAULT NULL,
  `emp_miss_time_type` int(11) DEFAULT NULL,
  `emp_miss_in_time` time DEFAULT NULL,
  `emp_miss_out_time` time DEFAULT NULL,
  `emp_working_hour` time DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `request_mispunch_list` (`id`, `business_id`, `emp_id`, `emp_mobile_no`, `emp_miss_date`, `emp_miss_time_type`, `emp_miss_in_time`, `emp_miss_out_time`, `emp_working_hour`, `message`, `remark`, `status`, `created_at`, `updated_at`) VALUES
(38,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	'2023-09-16',	1,	'10:08:00',	'17:09:00',	'00:00:08',	'Chjn',	'asdfasdf',	2,	'2023-09-29 12:09:31',	'2023-09-29 12:09:31'),
(39,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	'2023-09-29',	1,	'12:33:00',	'00:36:00',	'10:00:00',	'Dm',	NULL,	1,	'2023-09-29 12:31:37',	'2023-09-29 12:31:37'),
(41,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	'2023-09-29',	1,	'13:51:00',	'13:51:00',	'00:00:00',	'Rjj',	NULL,	1,	'2023-09-29 13:52:12',	'2023-09-29 13:52:12'),
(43,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	'2023-09-30',	1,	'10:28:00',	'04:28:00',	'18:00:00',	NULL,	'asdf',	2,	'2023-09-30 00:28:56',	'2023-09-30 00:28:56'),
(48,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	'2023-09-08',	1,	'10:07:00',	'18:13:00',	'08:05:00',	'Miss the both punch',	NULL,	1,	'2023-09-30 15:39:20',	'2023-09-30 15:39:20'),
(49,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	'2023-09-06',	1,	'10:15:00',	'19:20:00',	'09:05:00',	'Miss punching both interval',	NULL,	1,	'2023-09-30 15:43:47',	'2023-09-30 15:43:47'),
(50,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	'2023-09-10',	1,	'08:40:00',	'21:14:00',	'12:34:00',	'Thjn',	NULL,	1,	'2023-09-30 17:15:06',	'2023-09-30 17:15:06'),
(51,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	'2023-09-14',	1,	'09:16:00',	'16:16:00',	'07:00:00',	'Mmmmmmmmmm',	'Reson Is not Valid',	2,	'2023-10-01 23:16:47',	'2023-10-09 12:40:15'),
(52,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	'2023-10-05',	1,	'09:50:00',	'19:10:00',	'09:20:00',	'Thalapati',	'asdfdsaf',	2,	'2023-10-10 10:43:42',	'2023-10-10 10:43:42'),
(53,	'e3d64177e51bdff82b499e116796fe74',	'IT010',	'9993433474',	'2023-10-11',	1,	'11:10:00',	'18:15:00',	'07:05:00',	'Ooooo',	NULL,	1,	'2023-10-12 17:52:54',	'2023-10-12 17:52:54'),
(54,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	'24-10-2023',	1,	'11:08:00',	'16:08:00',	'05:00:00',	'Hhhh',	'asdf',	2,	'2023-10-23 15:08:46',	'2023-11-03 08:42:01'),
(55,	'e3d64177e51bdff82b499e116796fe74',	'IT009',	'9993433474',	'2023-10-25',	1,	'11:19:00',	'17:19:00',	'06:00:00',	'Jjjjjjjjj',	NULL,	1,	'2023-10-23 16:19:49',	'2023-11-03 08:41:46'),
(56,	'e3d64177e51bdff82b499e116796fe74',	'IT0012',	'8462074453',	'2023-11-09',	1,	'15:13:00',	'15:13:00',	'00:00:00',	'Ttt',	NULL,	0,	'2023-11-01 15:14:05',	'2023-11-01 15:14:05');

DROP TABLE IF EXISTS `static_attendance_endgame_level`;
CREATE TABLE `static_attendance_endgame_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policypreference_level_id` bigint(11) DEFAULT NULL,
  `level_name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_attendance_endgame_level` (`id`, `policypreference_level_id`, `level_name`) VALUES
(1,	1,	'Business Level');

DROP TABLE IF EXISTS `static_attendance_endgame_policypreference`;
CREATE TABLE `static_attendance_endgame_policypreference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_name` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_attendance_endgame_policypreference` (`id`, `policy_name`, `created_at`, `updated_at`) VALUES
(1,	'Business',	'2023-10-03 05:16:43',	'2023-10-03 05:16:43'),
(2,	'Employee',	'2023-10-03 05:17:55',	'2023-10-03 05:17:55');

DROP TABLE IF EXISTS `static_attendance_methods`;
CREATE TABLE `static_attendance_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method_name` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_attendance_methods` (`id`, `method_name`) VALUES
(1,	'Office'),
(2,	'Out Door'),
(3,	'Remote');

DROP TABLE IF EXISTS `static_attendance_mode`;
CREATE TABLE `static_attendance_mode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='use attendancelist static data';

INSERT INTO `static_attendance_mode` (`id`, `mode_name`) VALUES
(1,	'QR Code'),
(2,	'Face ID'),
(3,	'Selfie');

DROP TABLE IF EXISTS `static_attendance_shift_type`;
CREATE TABLE `static_attendance_shift_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(225) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_attendance_shift_type` (`id`, `name`) VALUES
(1,	'Fixed Shift'),
(2,	'Rotational Shift'),
(3,	'Open Shift');

DROP TABLE IF EXISTS `static_business_categories_list`;
CREATE TABLE `static_business_categories_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_business_categories_list` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1,	'Hospital',	0,	'2023-08-18 12:00:52',	'2023-08-18 11:59:26'),
(2,	'Hotel',	0,	'2023-08-18 12:00:44',	'2023-08-18 11:59:35'),
(3,	'Super Market',	0,	'2023-08-18 12:00:34',	'2023-08-18 11:59:43'),
(4,	'Software Development',	0,	'2023-08-18 12:01:34',	'2023-08-18 12:01:34'),
(5,	'IT/Telecom',	0,	'2023-08-18 12:02:35',	'2023-08-18 12:02:35'),
(6,	'Jewellery',	0,	'2023-08-18 12:02:53',	'2023-08-18 12:02:53'),
(7,	'Logistics',	0,	'2023-08-18 12:03:05',	'2023-08-18 12:03:05'),
(8,	'Saloon/Boutique',	0,	'2023-08-18 12:04:38',	'2023-08-18 12:03:43'),
(9,	'Educational/Coaching Institute',	0,	'2023-08-18 12:05:47',	'2023-08-18 12:05:47'),
(10,	'Manufacturing',	0,	'2023-08-18 12:06:25',	'2023-08-18 12:06:25'),
(11,	'Others',	0,	'2023-08-18 12:08:06',	'2023-08-18 12:08:06');

DROP TABLE IF EXISTS `static_business_type_list`;
CREATE TABLE `static_business_type_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_business_type_list` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1,	'Sole Proprietorship',	'2023-09-04 06:41:20',	'2023-08-19 17:48:07'),
(2,	'Partnership',	'2023-09-04 06:41:28',	'2023-08-19 17:48:07'),
(3,	'Corporation',	'2023-09-04 06:41:36',	'2023-08-19 17:48:07'),
(4,	'Cooperative',	'2023-09-04 06:41:58',	'2023-08-19 17:48:07'),
(5,	'Limited Liability Company (LLC)',	'2023-09-04 06:42:10',	'2023-08-19 17:48:07');

DROP TABLE IF EXISTS `static_employee_join_blood_group`;
CREATE TABLE `static_employee_join_blood_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blood_group` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_employee_join_blood_group` (`id`, `blood_group`) VALUES
(1,	'A+'),
(2,	'O+'),
(3,	'B+'),
(4,	'AB+'),
(5,	'A-'),
(6,	'O-'),
(7,	'B-'),
(8,	'AB-');

DROP TABLE IF EXISTS `static_employee_join_category_caste`;
CREATE TABLE `static_employee_join_category_caste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caste_category` varchar(50) DEFAULT NULL,
  `caste_full_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_employee_join_category_caste` (`id`, `caste_category`, `caste_full_name`) VALUES
(1,	'SC',	'Scheduled Caste'),
(2,	'ST',	'Scheduled Tribe'),
(3,	'OBC',	'Other Backward Class'),
(4,	'General',	'General Category'),
(5,	'Other',	'');

DROP TABLE IF EXISTS `static_employee_join_contractual_type`;
CREATE TABLE `static_employee_join_contractual_type` (
  `id` int(11) NOT NULL,
  `contractual_type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_employee_join_contractual_type` (`id`, `contractual_type`) VALUES
(1,	'Monthly'),
(2,	'Weekly'),
(3,	'Daily'),
(4,	'Hourly');

DROP TABLE IF EXISTS `static_employee_join_emp_type`;
CREATE TABLE `static_employee_join_emp_type` (
  `type_id` int(255) NOT NULL AUTO_INCREMENT,
  `emp_type` varchar(255) NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_employee_join_emp_type` (`type_id`, `emp_type`) VALUES
(1,	'Regular'),
(2,	'Contractual');

DROP TABLE IF EXISTS `static_employee_join_gender_type`;
CREATE TABLE `static_employee_join_gender_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gender_type` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_employee_join_gender_type` (`id`, `gender_type`) VALUES
(1,	'Male'),
(2,	'Female'),
(3,	'Other');

DROP TABLE IF EXISTS `static_employee_join_govt_doc_type`;
CREATE TABLE `static_employee_join_govt_doc_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `govt_type` varchar(50) DEFAULT NULL,
  `document_no_length` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`document_no_length`)),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_employee_join_govt_doc_type` (`id`, `govt_type`, `document_no_length`) VALUES
(1,	'Aadhaar card',	'[\"12\"]'),
(2,	'PAN Card',	'[\"10\"]'),
(3,	'Driving license',	'[\"16\"]'),
(4,	'Passport',	'[\"8\",\"9\"]'),
(5,	'Voter ID',	'[\"6\",\"4\"]'),
(6,	'Other',	'[\"0\"]');

DROP TABLE IF EXISTS `static_employee_join_marital_type`;
CREATE TABLE `static_employee_join_marital_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marital_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_employee_join_marital_type` (`id`, `marital_type`) VALUES
(1,	'Married'),
(2,	'Unmarried ');

DROP TABLE IF EXISTS `static_employee_join_religion`;
CREATE TABLE `static_employee_join_religion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `religion_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_employee_join_religion` (`id`, `religion_name`) VALUES
(1,	'Hinduism'),
(2,	'Christianity'),
(3,	'Islam'),
(4,	'Sikhism'),
(5,	'Others');

DROP TABLE IF EXISTS `static_endgame_method_switch`;
CREATE TABLE `static_endgame_method_switch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `method_check` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_endgame_method_switch` (`id`, `method_check`) VALUES
(1,	'ON'),
(2,	'OFF');

DROP TABLE IF EXISTS `static_leave_shift_type`;
CREATE TABLE `static_leave_shift_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_shift_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_leave_shift_type` (`id`, `leave_shift_type`) VALUES
(1,	'First Half'),
(2,	'Second Half');

DROP TABLE IF EXISTS `static_mispunch_timetype`;
CREATE TABLE `static_mispunch_timetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_mispunch_timetype` (`id`, `time_type`) VALUES
(1,	'In Time'),
(2,	'Out Time'),
(3,	'Both Time');

DROP TABLE IF EXISTS `static_request_leave_type`;
CREATE TABLE `static_request_leave_type` (
  `id` int(11) NOT NULL,
  `leave_day` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_request_leave_type` (`id`, `leave_day`) VALUES
(1,	'Full Day'),
(2,	'Half Day');

DROP TABLE IF EXISTS `static_sidebar`;
CREATE TABLE `static_sidebar` (
  `bar_id` int(11) NOT NULL AUTO_INCREMENT,
  `sidebar_title` varchar(255) DEFAULT NULL,
  `side_icon` varchar(255) DEFAULT NULL,
  `status` int(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`bar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_sidebar` (`bar_id`, `sidebar_title`, `side_icon`, `status`, `created_at`, `updated_at`) VALUES
(1,	'Dashboard',	'feather feather-home',	1,	'2023-09-02 10:28:55',	'0000-00-00 00:00:00'),
(2,	'Employee',	'feather feather-users',	1,	'2023-09-02 10:29:51',	'0000-00-00 00:00:00'),
(3,	'Attendance',	'feather feather-user-check',	1,	'2023-09-02 10:30:10',	'0000-00-00 00:00:00'),
(4,	'Request',	'feather feather-file-text',	1,	'2023-09-02 10:30:24',	'0000-00-00 00:00:00'),
(5,	'Setings',	'feather feather-settings',	1,	'2023-09-02 10:31:09',	'0000-00-00 00:00:00'),
(6,	'Roles & Permissions',	'fa fa-file',	1,	'2023-09-09 08:14:13',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `static_sidebar_menu`;
CREATE TABLE `static_sidebar_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) DEFAULT NULL,
  `menu_link` varchar(255) DEFAULT NULL,
  `sub_list` varchar(255) DEFAULT NULL,
  `sidebar_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_sidebar_menu` (`menu_id`, `menu_name`, `menu_link`, `sub_list`, `sidebar_id`, `status`, `updated_at`, `created_at`) VALUES
(1,	'Dashboard',	'/admin',	NULL,	1,	1,	'2023-09-02 10:16:05',	'2023-09-22 17:05:45'),
(2,	'Employee',	'/admin/employee',	NULL,	2,	1,	'2023-09-02 10:17:53',	'2023-09-02 11:29:09'),
(3,	'Attendance',	'/admin/attendance',	NULL,	3,	1,	'2023-09-02 10:18:27',	'2023-09-02 11:29:09'),
(4,	'Leave',	'/admin/requests/leaves',	NULL,	20,	1,	'2023-09-02 10:19:29',	'2023-09-23 09:47:01'),
(5,	'Miss Punch',	'/admin/requests/misspunch',	NULL,	20,	1,	'2023-09-02 10:20:10',	'2023-09-23 09:47:01'),
(6,	'Gate Pass',	'/admin/requests/gatepass',	NULL,	20,	1,	'2023-09-02 10:20:44',	'2023-09-23 09:47:01'),
(7,	'Roles & Permissions',	'/Role-permission/role_permission',	NULL,	7,	1,	'2023-09-09 08:15:43',	'2023-09-09 08:19:08'),
(8,	'Admin List',	'/Role-permission/admin-list',	NULL,	7,	1,	'2023-09-09 08:14:36',	'0000-00-00 00:00:00'),
(9,	'Attendance Setting',	'/admin/settings/attendance',	NULL,	6,	1,	'2023-09-02 10:22:16',	'2023-09-09 08:54:23'),
(10,	'Attendance Attedance-Mode',	'/admin/settings/attendance/attendance-mode',	NULL,	7,	1,	'2023-09-09 08:14:36',	'0000-00-00 00:00:00'),
(11,	'Attendance Access-List',	'/admin/settings/attendance/attendance-access',	NULL,	7,	1,	'2023-09-09 08:14:36',	'0000-00-00 00:00:00'),
(12,	'Attendance Shift',	'/admin/settings/attendance/create_shift',	NULL,	7,	1,	'2023-09-09 08:14:36',	'0000-00-00 00:00:00'),
(13,	'Attendance Automation-Rules',	'/admin/settings/attendance/automation',	NULL,	7,	1,	'2023-09-09 08:14:36',	'0000-00-00 00:00:00'),
(14,	'Attendance TrackIn-OutTime',	'/admin/settings/attendance/trackin_outtime',	NULL,	7,	1,	'2023-09-09 08:14:36',	'0000-00-00 00:00:00'),
(15,	'Attendance Holiday',	'/admin/settings/attendance/attendance-holiday',	NULL,	7,	1,	'2023-09-09 08:14:36',	'0000-00-00 00:00:00'),
(16,	'Business Setting',	'/admin/settings/business',	NULL,	6,	1,	'2023-09-02 10:22:42',	'2023-09-12 05:14:01'),
(17,	'Branch Setting',	'/admin/settings/business/branches',	NULL,	6,	1,	'2023-09-02 10:22:42',	'2023-09-12 05:14:01'),
(18,	'Department Setting',	'/admin/settings/business/department',	NULL,	6,	1,	'2023-09-02 10:22:42',	'2023-09-12 05:14:01'),
(19,	'Designation Setting',	'/admin/settings/business/designation',	NULL,	6,	1,	'2023-09-02 10:22:42',	'2023-09-12 05:14:01'),
(20,	'Holiday Setting',	'/admin/settings/business/holiday_policy',	NULL,	6,	1,	'2023-09-02 10:22:42',	'2023-09-12 05:14:01'),
(21,	'Leave Setting',	'/admin/settings/business/leave_policy',	NULL,	6,	1,	'2023-09-02 10:22:42',	'2023-09-12 05:14:01'),
(22,	'WeeklyHoliday Setting',	'/admin/settings/business/weekly_holiday',	NULL,	6,	1,	'2023-09-02 10:22:42',	'2023-09-12 05:14:01'),
(23,	'Manage Employee Data Setting',	'/admin/settings/business/manage_emp',	NULL,	6,	1,	'2023-09-02 10:22:42',	'2023-09-12 05:14:01'),
(24,	'Invite Employee',	'/admin/settings/business/invite_employee',	NULL,	6,	1,	'2023-09-02 10:22:42',	'2023-09-12 05:14:01'),
(25,	'Account Setting',	'/admin/settings/account',	NULL,	6,	1,	'2023-09-02 10:23:44',	'2023-09-04 06:14:39'),
(26,	'Localization Setting',	'/admin/settings/localization',	NULL,	6,	1,	'2023-09-09 11:15:13',	'0000-00-00 00:00:00'),
(27,	'Notification Setting',	'/admin/settings/notification',	NULL,	6,	1,	'2023-09-09 11:16:05',	'0000-00-00 00:00:00'),
(28,	'Report',	'/admin/report',	NULL,	5,	0,	'2023-09-02 10:21:35',	'2023-09-28 17:33:08');

DROP TABLE IF EXISTS `static_status_attendance`;
CREATE TABLE `static_status_attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_labels` varchar(255) DEFAULT NULL,
  `badge_colors` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_status_attendance` (`id`, `status_labels`, `badge_colors`) VALUES
(1,	'Present',	'success'),
(2,	'Absent',	'danger'),
(3,	'Late',	'success'),
(4,	'Mispunch',	'secondary'),
(5,	'Not Marked',	'secondary'),
(6,	'Holiday',	'primary'),
(7,	'Weekoff',	'primary'),
(8,	'Half day',	'danger'),
(9,	'Overtime',	'success'),
(10,	'paid leave',	'success'),
(11,	'unpaid leave',	'danger');

DROP TABLE IF EXISTS `static_status_request`;
CREATE TABLE `static_status_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_response` varchar(50) DEFAULT NULL,
  `request_color` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `static_status_request` (`id`, `request_response`, `request_color`) VALUES
(0,	'Requested',	'badge badge-primary-light'),
(1,	'Approved',	'badge badge-success-light'),
(2,	'Declined',	'badge badge-warning-light'),
(3,	'Pending',	'badge badge-danger-light');

DROP TABLE IF EXISTS `subscription`;
CREATE TABLE `subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `business_id` longtext NOT NULL,
  `packages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`packages`)),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `subscription` (`id`, `business_id`, `packages`) VALUES
(1,	'e3d64177e51bdff82b499e116796fe74',	'[\"{\\\"success\\\":true,\\\"code\\\":\\\"PAYMENT_SUCCESS\\\",\\\"message\\\":\\\"Your payment is successful.\\\",\\\"data\\\":{\\\"merchantId\\\":\\\"PGTESTPAYUAT\\\",\\\"merchantTransactionId\\\":\\\"65336c5973388\\\",\\\"transactionId\\\":\\\"T2310211144496972367197\\\",\\\"amount\\\":10000,\\\"state\\\":\\\"COMPLETED\\\",\\\"responseCode\\\":\\\"SUCCESS\\\",\\\"paymentInstrument\\\":{\\\"type\\\":\\\"NETBANKING\\\",\\\"pgTransactionId\\\":\\\"1995464773\\\",\\\"pgServiceTransactionId\\\":\\\"PG2212291607083344934300\\\",\\\"bankTransactionId\\\":null,\\\"bankId\\\":\\\"\\\"}}}\"]'),
(2,	'e3d64177e51bdff82b499e116796fe74',	'[\"{\\\"success\\\":true,\\\"code\\\":\\\"PAYMENT_SUCCESS\\\",\\\"message\\\":\\\"Your payment is successful.\\\",\\\"data\\\":{\\\"merchantId\\\":\\\"PGTESTPAYUAT\\\",\\\"merchantTransactionId\\\":\\\"65336efb3d2ad\\\",\\\"transactionId\\\":\\\"T2310211156034832367494\\\",\\\"amount\\\":10000,\\\"state\\\":\\\"COMPLETED\\\",\\\"responseCode\\\":\\\"SUCCESS\\\",\\\"paymentInstrument\\\":{\\\"type\\\":\\\"CARD\\\",\\\"cardType\\\":\\\"CREDIT_CARD\\\",\\\"pgTransactionId\\\":\\\"PG2207221432267522530776\\\",\\\"bankTransactionId\\\":null,\\\"pgAuthorizationCode\\\":null,\\\"arn\\\":null,\\\"bankId\\\":\\\"\\\",\\\"brn\\\":\\\"B12345\\\"}}}\"]');

-- 2023-11-03 05:34:55
