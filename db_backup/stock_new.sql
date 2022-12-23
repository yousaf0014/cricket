-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2017 at 01:09 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stock_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup`
--

CREATE TABLE IF NOT EXISTS `backup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `backup`
--

INSERT INTO `backup` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, '2017-01-07-113327.zip', NULL, NULL),
(2, '2017-01-07-114125.zip', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=243 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country`, `code`) VALUES
(1, 'United States', 'US'),
(2, 'Canada', 'CA'),
(3, 'Afghanistan', 'AF'),
(4, 'Albania', 'AL'),
(5, 'Algeria', 'DZ'),
(6, 'American Samoa', 'AS'),
(7, 'Andorra', 'AD'),
(8, 'Angola', 'AO'),
(9, 'Anguilla', 'AI'),
(10, 'Antarctica', 'AQ'),
(11, 'Antigua and/or Barbuda', 'AG'),
(12, 'Argentina', 'AR'),
(13, 'Armenia', 'AM'),
(14, 'Aruba', 'AW'),
(15, 'Australia', 'AU'),
(16, 'Austria', 'AT'),
(17, 'Azerbaijan', 'AZ'),
(18, 'Bahamas', 'BS'),
(19, 'Bahrain', 'BH'),
(20, 'Bangladesh', 'BD'),
(21, 'Barbados', 'BB'),
(22, 'Belarus', 'BY'),
(23, 'Belgium', 'BE'),
(24, 'Belize', 'BZ'),
(25, 'Benin', 'BJ'),
(26, 'Bermuda', 'BM'),
(27, 'Bhutan', 'BT'),
(28, 'Bolivia', 'BO'),
(29, 'Bosnia and Herzegovina', 'BA'),
(30, 'Botswana', 'BW'),
(31, 'Bouvet Island', 'BV'),
(32, 'Brazil', 'BR'),
(33, 'British lndian Ocean Territory', 'IO'),
(34, 'Brunei Darussalam', 'BN'),
(35, 'Bulgaria', 'BG'),
(36, 'Burkina Faso', 'BF'),
(37, 'Burundi', 'BI'),
(38, 'Cambodia', 'KH'),
(39, 'Cameroon', 'CM'),
(40, 'Cape Verde', 'CV'),
(41, 'Cayman Islands', 'KY'),
(42, 'Central African Republic', 'CF'),
(43, 'Chad', 'TD'),
(44, 'Chile', 'CL'),
(45, 'China', 'CN'),
(46, 'Christmas Island', 'CX'),
(47, 'Cocos (Keeling) Islands', 'CC'),
(48, 'Colombia', 'CO'),
(49, 'Comoros', 'KM'),
(50, 'Congo', 'CG'),
(51, 'Cook Islands', 'CK'),
(52, 'Costa Rica', 'CR'),
(53, 'Croatia (Hrvatska)', 'HR'),
(54, 'Cuba', 'CU'),
(55, 'Cyprus', 'CY'),
(56, 'Czech Republic', 'CZ'),
(57, 'Democratic Republic of Congo', 'CD'),
(58, 'Denmark', 'DK'),
(59, 'Djibouti', 'DJ'),
(60, 'Dominica', 'DM'),
(61, 'Dominican Republic', 'DO'),
(62, 'East Timor', 'TP'),
(63, 'Ecudaor', 'EC'),
(64, 'Egypt', 'EG'),
(65, 'El Salvador', 'SV'),
(66, 'Equatorial Guinea', 'GQ'),
(67, 'Eritrea', 'ER'),
(68, 'Estonia', 'EE'),
(69, 'Ethiopia', 'ET'),
(70, 'Falkland Islands (Malvinas)', 'FK'),
(71, 'Faroe Islands', 'FO'),
(72, 'Fiji', 'FJ'),
(73, 'Finland', 'FI'),
(74, 'France', 'FR'),
(75, 'France, Metropolitan', 'FX'),
(76, 'French Guiana', 'GF'),
(77, 'French Polynesia', 'PF'),
(78, 'French Southern Territories', 'TF'),
(79, 'Gabon', 'GA'),
(80, 'Gambia', 'GM'),
(81, 'Georgia', 'GE'),
(82, 'Germany', 'DE'),
(83, 'Ghana', 'GH'),
(84, 'Gibraltar', 'GI'),
(85, 'Greece', 'GR'),
(86, 'Greenland', 'GL'),
(87, 'Grenada', 'GD'),
(88, 'Guadeloupe', 'GP'),
(89, 'Guam', 'GU'),
(90, 'Guatemala', 'GT'),
(91, 'Guinea', 'GN'),
(92, 'Guinea-Bissau', 'GW'),
(93, 'Guyana', 'GY'),
(94, 'Haiti', 'HT'),
(95, 'Heard and Mc Donald Islands', 'HM'),
(96, 'Honduras', 'HN'),
(97, 'Hong Kong', 'HK'),
(98, 'Hungary', 'HU'),
(99, 'Iceland', 'IS'),
(100, 'India', 'IN'),
(101, 'Indonesia', 'ID'),
(102, 'Iran (Islamic Republic of)', 'IR'),
(103, 'Iraq', 'IQ'),
(104, 'Ireland', 'IE'),
(105, 'Israel', 'IL'),
(106, 'Italy', 'IT'),
(107, 'Ivory Coast', 'CI'),
(108, 'Jamaica', 'JM'),
(109, 'Japan', 'JP'),
(110, 'Jordan', 'JO'),
(111, 'Kazakhstan', 'KZ'),
(112, 'Kenya', 'KE'),
(113, 'Kiribati', 'KI'),
(114, 'Korea, Democratic People''s Republic of', 'KP'),
(115, 'Korea, Republic of', 'KR'),
(116, 'Kuwait', 'KW'),
(117, 'Kyrgyzstan', 'KG'),
(118, 'Lao People''s Democratic Republic', 'LA'),
(119, 'Latvia', 'LV'),
(120, 'Lebanon', 'LB'),
(121, 'Lesotho', 'LS'),
(122, 'Liberia', 'LR'),
(123, 'Libyan Arab Jamahiriya', 'LY'),
(124, 'Liechtenstein', 'LI'),
(125, 'Lithuania', 'LT'),
(126, 'Luxembourg', 'LU'),
(127, 'Macau', 'MO'),
(128, 'Macedonia', 'MK'),
(129, 'Madagascar', 'MG'),
(130, 'Malawi', 'MW'),
(131, 'Malaysia', 'MY'),
(132, 'Maldives', 'MV'),
(133, 'Mali', 'ML'),
(134, 'Malta', 'MT'),
(135, 'Marshall Islands', 'MH'),
(136, 'Martinique', 'MQ'),
(137, 'Mauritania', 'MR'),
(138, 'Mauritius', 'MU'),
(139, 'Mayotte', 'TY'),
(140, 'Mexico', 'MX'),
(141, 'Micronesia, Federated States of', 'FM'),
(142, 'Moldova, Republic of', 'MD'),
(143, 'Monaco', 'MC'),
(144, 'Mongolia', 'MN'),
(145, 'Montserrat', 'MS'),
(146, 'Morocco', 'MA'),
(147, 'Mozambique', 'MZ'),
(148, 'Myanmar', 'MM'),
(149, 'Namibia', 'NA'),
(150, 'Nauru', 'NR'),
(151, 'Nepal', 'NP'),
(152, 'Netherlands', 'NL'),
(153, 'Netherlands Antilles', 'AN'),
(154, 'New Caledonia', 'NC'),
(155, 'New Zealand', 'NZ'),
(156, 'Nicaragua', 'NI'),
(157, 'Niger', 'NE'),
(158, 'Nigeria', 'NG'),
(159, 'Niue', 'NU'),
(160, 'Norfork Island', 'NF'),
(161, 'Northern Mariana Islands', 'MP'),
(162, 'Norway', 'NO'),
(163, 'Oman', 'OM'),
(164, 'Pakistan', 'PK'),
(165, 'Palau', 'PW'),
(166, 'Panama', 'PA'),
(167, 'Papua New Guinea', 'PG'),
(168, 'Paraguay', 'PY'),
(169, 'Peru', 'PE'),
(170, 'Philippines', 'PH'),
(171, 'Pitcairn', 'PN'),
(172, 'Poland', 'PL'),
(173, 'Portugal', 'PT'),
(174, 'Puerto Rico', 'PR'),
(175, 'Qatar', 'QA'),
(176, 'Republic of South Sudan', 'SS'),
(177, 'Reunion', 'RE'),
(178, 'Romania', 'RO'),
(179, 'Russian Federation', 'RU'),
(180, 'Rwanda', 'RW'),
(181, 'Saint Kitts and Nevis', 'KN'),
(182, 'Saint Lucia', 'LC'),
(183, 'Saint Vincent and the Grenadines', 'VC'),
(184, 'Samoa', 'WS'),
(185, 'San Marino', 'SM'),
(186, 'Sao Tome and Principe', 'ST'),
(187, 'Saudi Arabia', 'SA'),
(188, 'Senegal', 'SN'),
(189, 'Serbia', 'RS'),
(190, 'Seychelles', 'SC'),
(191, 'Sierra Leone', 'SL'),
(192, 'Singapore', 'SG'),
(193, 'Slovakia', 'SK'),
(194, 'Slovenia', 'SI'),
(195, 'Solomon Islands', 'SB'),
(196, 'Somalia', 'SO'),
(197, 'South Africa', 'ZA'),
(198, 'South Georgia South Sandwich Islands', 'GS'),
(199, 'Spain', 'ES'),
(200, 'Sri Lanka', 'LK'),
(201, 'St. Helena', 'SH'),
(202, 'St. Pierre and Miquelon', 'PM'),
(203, 'Sudan', 'SD'),
(204, 'Suriname', 'SR'),
(205, 'Svalbarn and Jan Mayen Islands', 'SJ'),
(206, 'Swaziland', 'SZ'),
(207, 'Sweden', 'SE'),
(208, 'Switzerland', 'CH'),
(209, 'Syrian Arab Republic', 'SY'),
(210, 'Taiwan', 'TW'),
(211, 'Tajikistan', 'TJ'),
(212, 'Tanzania, United Republic of', 'TZ'),
(213, 'Thailand', 'TH'),
(214, 'Togo', 'TG'),
(215, 'Tokelau', 'TK'),
(216, 'Tonga', 'TO'),
(217, 'Trinidad and Tobago', 'TT'),
(218, 'Tunisia', 'TN'),
(219, 'Turkey', 'TR'),
(220, 'Turkmenistan', 'TM'),
(221, 'Turks and Caicos Islands', 'TC'),
(222, 'Tuvalu', 'TV'),
(223, 'Uganda', 'UG'),
(224, 'Ukraine', 'UA'),
(225, 'United Arab Emirates', 'AE'),
(226, 'United Kingdom', 'GB'),
(227, 'United States minor outlying islands', 'UM'),
(228, 'Uruguay', 'UY'),
(229, 'Uzbekistan', 'UZ'),
(230, 'Vanuatu', 'VU'),
(231, 'Vatican City State', 'VA'),
(232, 'Venezuela', 'VE'),
(233, 'Vietnam', 'VN'),
(234, 'Virgin Islands (British)', 'VG'),
(235, 'Virgin Islands (U.S.)', 'VI'),
(236, 'Wallis and Futuna Islands', 'WF'),
(237, 'Western Sahara', 'EH'),
(238, 'Yemen', 'YE'),
(239, 'Yugoslavia', 'YU'),
(240, 'Zaire', 'ZR'),
(241, 'Zambia', 'ZM'),
(242, 'Zimbabwe', 'ZW');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `symbol` char(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`, `symbol`) VALUES
(1, 'USD', '$');

-- --------------------------------------------------------

--
-- Table structure for table `cust_branch`
--

CREATE TABLE IF NOT EXISTS `cust_branch` (
  `branch_code` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `debtor_no` int(11) NOT NULL,
  `br_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `br_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `br_contact` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `billing_country_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_state` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shipping_country_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`branch_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `cust_branch`
--

INSERT INTO `cust_branch` (`branch_code`, `debtor_no`, `br_name`, `br_address`, `br_contact`, `billing_street`, `billing_city`, `billing_state`, `billing_zip_code`, `billing_country_id`, `shipping_street`, `shipping_city`, `shipping_state`, `shipping_zip_code`, `shipping_country_id`) VALUES
(1, 1, 'Stone Jacobson', '', '', '82394 Ottilie Wells', 'Reingerberg', 'Utah', '72491', 'Uruguay', '82394 Ottilie Wells', 'Reingerberg', 'Utah', '72491', 'Uruguay'),
(2, 2, 'Reggie Kautzer', '', 'Test', '823 Arthur Lights', 'Joannehaven', 'Alabama', '34063-6102', 'AL', '823 Arthur Lights', 'Joannehaven', 'Alabama', '34063-6102', 'AL'),
(3, 3, 'Pinky Techvill ', '', '', 'Muktijoddha Road', 'Dhaka', 'Uttora', '1230', 'BD', 'Muktijoddha Road', 'Dhaka', 'Uttora', '1230', 'BD'),
(4, 4, 'Tauhidul Hasan', '', '', 'Nikunja-2, Khilkhet', 'Dhaka', 'Dhaka', '1229', 'BD', 'Nikunja-2, Khilkhet', 'Dhaka', 'Dhaka', '1229', 'BD'),
(5, 5, 'Consul General', '', '', '2430', 'Washington', 'Washington', '', 'USA', '2430', 'Washington', 'Washington', '', 'USA'),
(6, 6, 'Consul General', '', '', '2430', 'Washington', 'Washington', '', 'US', '2430', 'Washington', 'Washington', '', 'US'),
(7, 7, 'Consul General', '', '', '2430', 'Washington', 'Washington', '1234', 'US', '2430', 'Washington', 'Washington', '1234', 'US');

-- --------------------------------------------------------

--
-- Table structure for table `debtors_master`
--

CREATE TABLE IF NOT EXISTS `debtors_master` (
  `debtor_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `sales_type` int(11) NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`debtor_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `debtors_master`
--

INSERT INTO `debtors_master` (`debtor_no`, `name`, `email`, `password`, `address`, `phone`, `sales_type`, `remember_token`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'Stone Jacobson', 'skiles.arnoldo@example.com', '$2y$10$u/7xQtlh77oM6DP.4vPrIulAr8t6lUxK01H.6oD9eGvE4T0mR9Fkq', '', '967.979.3838', 0, '', 0, '2017-01-05 00:29:30', NULL),
(2, 'Reggie Kautzer', 'pinkie16@example.com', '$2y$10$yXWL4GQbU7mErk2gWz5PAOpkoSOhWLQpuDxHY/CEQDwS.f82wY8D2', '', '417-870-5110', 0, 'qPE7RE8cHnokLuiBqjLzm2vWxSsaiVtpXtnvOvGdgHi7bkC3SMgsGMYPs2tc', 0, '2017-01-05 00:31:23', '2017-01-07 02:14:18'),
(3, 'Pinky Techvill ', 'pinky.techvill@gmail.com', '$2y$10$t/hCAILwVSKpevjI4EHV8e5XGh3iTijDZqYA5uc6yeFacEBRfRpQu', '', '12345', 0, 'QssqRTMwodBQHFZnwouEsLbRo7GP2WVEC9itWXsaHsegu668eV9UVfyn7jXl', 0, '2017-01-05 02:50:09', '2017-01-07 01:04:41'),
(4, 'Tauhidul Hasan', 'lenin.rock@gmail.com', '$2y$10$I2xrPbOtmGbt66OOUCC1/.DjTBzo3Jx7J.rKA.LBhQ7nV9u.NRchO', '', '1717170543', 0, '', 0, '2017-01-06 01:32:56', NULL),
(5, 'Michel Dan', 'sample8@gmail.com', '', '', '123456789', 0, '', 0, NULL, NULL),
(6, 'Test', 'saaample8@gmail.com', '', '', '123456789', 0, '', 0, NULL, '2017-01-07 03:31:35'),
(7, 'John Test', 'sampsdale@gmail.com', '$2y$10$Q6mDgyDDwOj9HrRb5HyCuebFzz0lj5oPGmpC9/.8zeXrCLBc.UDHu', '', '123456789', 0, 'YpF4fBYAnf2rXZIZ1ytalOqk8n7Oo9JrjjO9soe3AZZO4haDb73oWzfuZR8L', 0, NULL, '2017-01-07 05:38:27');

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

CREATE TABLE IF NOT EXISTS `email_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_protocol` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_encryption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_port` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `email_config`
--

INSERT INTO `email_config` (`id`, `email_protocol`, `email_encryption`, `smtp_host`, `smtp_port`, `smtp_email`, `smtp_username`, `smtp_password`, `from_address`, `from_name`) VALUES
(1, 'smtp', 'tls', 'smtp.gmail.com', '587', 'stockpile.techvill@gmail.com', 'stockpile.techvill@gmail.com', 'xgldhlpedszmglvj', 'stockpile.techvill@gmail.com', 'stockpile');

-- --------------------------------------------------------

--
-- Table structure for table `email_temp_details`
--

CREATE TABLE IF NOT EXISTS `email_temp_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `temp_id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=49 ;

--
-- Dumping data for table `email_temp_details`
--

INSERT INTO `email_temp_details` (`id`, `temp_id`, `subject`, `body`, `lang`, `lang_id`) VALUES
(1, 2, 'Your Order # {order_reference_no} from {company_name} has been shipped', 'Hi {customer_name},<br><br>Thank you for your order. Here’s a brief overview of your shipment:<br>Sales Order # {order_reference_no} was packed on {packed_date} and shipped on {delivery_date}.<br> <br><b>Shipping address   </b><br><br>{shipping_street}<br>{shipping_city}, {shipping_state}<br>{shipping_country}, \r\n{shipping_zip_code}\r\n\r\n<br><br><b>Item Summery</b><br>{item_information}<br> <br>If you have any questions, please feel free to reply to this email.<br><br>Regards<br>{company_name}<br><br><br>', 'en', 1),
(2, 2, 'Subject', 'Body', 'ar', 2),
(3, 2, 'Subject', 'Body', 'ch', 3),
(4, 2, 'Subject', 'Body', 'fr', 4),
(5, 2, 'Subject', 'Body', 'po', 5),
(6, 2, 'Subject', 'Body', 'rs', 6),
(7, 2, 'Subject', 'Body', 'sp', 7),
(8, 2, 'Subject', 'Body', 'tu', 8),
(9, 1, 'Payment information for Order#{order_reference_no} and Invoice#{invoice_reference_no}.', '<p>Hi {customer_name},</p><p>Thank you for purchase our product and pay for this.</p><p>We just want to confirm a few details about payment information:</p><p><b>Customer Information</b></p><p>{billing_street}</p><p>{billing_city}, {billing_state}</p><p>{billing_country}, \r\n{billing_zip_code}\r\n\r\n<br></p><p><b>Payment Summary<br></b></p><p><b></b><i>Payment No : {payment_id}</i></p><p><i>Payment Date : {payment_date}&nbsp;</i></p><p><i>Payment Method : {payment_method} <br></i></p><p><i><b>Total Amount : {total_amount}</b></i></p><p><i>Order No : {order_reference_no}</i><br><i></i></p><p><i>Invoice No : {invoice_reference_no}</i><br></p><p><br></p><p>Regards,</p><p>{company_name}<br></p><br><br><br><br><br><br>', 'en', 1),
(10, 1, 'Subject', 'Body', 'ar', 2),
(11, 1, 'Subject', 'Body', 'ch', 3),
(12, 1, 'Subject', 'Body', 'fr', 4),
(13, 1, 'Subject', 'Body', 'po', 5),
(14, 1, 'Subject', 'Body', 'rs', 6),
(15, 1, 'Subject', 'Body', 'sp', 7),
(16, 1, 'Subject', 'Body', 'tu', 8),
(17, 3, 'Payment information for Order#{order_reference_no} and Invoice#{invoice_reference_no}.', '<p>Hi {customer_name},</p><p>Thank you for purchase our product and pay for this.</p><p>We just want to confirm a few details about payment information:</p><p><b>Customer Information</b></p><p>{billing_street}</p><p>{billing_city}</p><p>{billing_state}</p><p>{billing_zip_code}<br></p><p>{billing_country}<br>&nbsp; &nbsp; &nbsp; &nbsp; <br></p><p><b>Payment Summary<br></b></p><p><b></b><i>Payment No : {payment_id}</i></p><p><i>Payment Date : {payment_date}&nbsp;</i></p><p><i>Payment Method : {payment_method} <br></i></p><p><i><b>Total Amount : {total_amount}</b><br>Order No : {order_reference_no}<br>&nbsp;</i><i>Invoice No : {invoice_reference_no}<br>&nbsp;</i>Regards,</p><p>{company_name} <br></p><br>', 'en', 1),
(18, 3, 'Subject', 'Body', 'ar', 2),
(19, 3, 'Subject', 'Body', 'ch', 3),
(20, 3, 'Subject', 'Body', 'fr', 4),
(21, 3, 'Subject', 'Body', 'po', 5),
(22, 3, 'Subject', 'Body', 'rs', 6),
(23, 3, 'Subject', 'Body', 'sp', 7),
(24, 3, 'Subject', 'Body', 'tu', 8),
(25, 4, 'Your Invoice # {invoice_reference_no} for sales Order #{order_reference_no} from {company_name} has been created.', '<p>Hi {customer_name},</p><p>Thank you for your order. Here’s a brief overview of your invoice: Invoice #{invoice_reference_no} is for Sales Order #{order_reference_no}. The invoice total is {currency}{total_amount}, please pay before {due_date}.</p><p>If you have any questions, please feel free to reply to this email. </p><p><b>Billing address</b></p><p>&nbsp;{billing_street}</p><p>&nbsp;{billing_city}, {billing_state}</p><p>&nbsp;{billing_country}, \r\n{billing_zip_code}<br></p><p><br></p><p><b>Order summary<br></b></p><p><b></b>{invoice_summery}<br></p><p>Regards,</p><p>{company_name}<br></p><br><br>', 'en', 1),
(26, 4, 'Subject', 'Body', 'ar', 2),
(27, 4, 'Subject', 'Body', 'ch', 3),
(28, 4, 'Subject', 'Body', 'fr', 4),
(29, 4, 'Subject', 'Body', 'po', 5),
(30, 4, 'Subject', 'Body', 'rs', 6),
(31, 4, 'Subject', 'Body', 'sp', 7),
(32, 4, 'Subject', 'Body', 'tu', 8),
(33, 5, 'Your Order# {order_reference_no} from {company_name} has been created.', '<p>Hi {customer_name},</p><p>Thank you for your order. Here’s a brief overview of your Order #{order_reference_no} that was created on {order_date}. The order total is {currency}{total_amount}.</p><p>If you have any questions, please feel free to reply to this email. </p><p><b>Billing address</b></p><p>&nbsp;{billing_street}</p><p>&nbsp;{billing_city}, {billing_state}</p><p>&nbsp;{billing_country}, \r\n&nbsp;{billing_zip_code}\r\n\r\n<br></p><p><br></p><p><b>Order summary<br></b></p><p><b></b>{order_summery}<br></p><p>Regards,</p><p>{company_name}</p><br><br>', 'en', 1),
(34, 5, 'Subject', 'Body', 'ar', 2),
(35, 5, 'Subject', 'Body', 'ch', 3),
(36, 5, 'Subject', 'Body', 'fr', 4),
(37, 5, 'Subject', 'Body', 'po', 5),
(38, 5, 'Subject', 'Body', 'rs', 6),
(39, 5, 'Subject', 'Body', 'sp', 7),
(40, 5, 'Subject', 'Body', 'tu', 8),
(41, 6, 'Your Order # {order_reference_no} from {company_name} has been packed', 'Hi {customer_name},<br><br>Thank you for your order. Here’s a brief overview of your shipment:<br>Sales Order # {order_reference_no} was packed on {packed_date}.<br> <br><b>Shipping address   </b><br><br>{shipping_street}<br>{shipping_city}, {shipping_state}<br>{shipping_country}, \r\n{shipping_zip_code}\r\n\r\n<br><br><b>Item Summery</b><br>{item_information}<br> <br>If you have any questions, please feel free to reply to this email.<br><br>Regards<br>{company_name}<br><br><br>', 'en', 1),
(42, 6, 'Subject', 'Body', 'ar', 2),
(43, 6, 'Subject', 'Body', 'ch', 3),
(44, 6, 'Subject', 'Body', 'fr', 4),
(45, 6, 'Subject', 'Body', 'po', 5),
(46, 6, 'Subject', 'Body', 'rs', 6),
(47, 6, 'Subject', 'Body', 'sp', 7),
(48, 6, 'Subject', 'Body', 'tu', 8);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payment_terms`
--

CREATE TABLE IF NOT EXISTS `invoice_payment_terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `terms` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `days_before_due` int(11) NOT NULL,
  `defaults` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `invoice_payment_terms`
--

INSERT INTO `invoice_payment_terms` (`id`, `terms`, `days_before_due`, `defaults`) VALUES
(1, 'Cash on delivery', 0, 1),
(2, 'Net15', 15, 0),
(3, 'Net30', 30, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_code`
--

CREATE TABLE IF NOT EXISTS `item_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` smallint(6) NOT NULL,
  `item_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `item_code`
--

INSERT INTO `item_code` (`id`, `stock_id`, `description`, `category_id`, `item_image`, `inactive`, `deleted_status`, `created_at`, `updated_at`) VALUES
(1, 'IPHONE7', 'IPHONE 7', 2, 'iPhone-5SE-render-tomas-4(1).jpg', 0, 0, '2017-01-04 23:59:34', '2017-01-05 02:08:24'),
(2, 'HP430', 'HP LAPTOP 430', 3, 'index.jpg', 0, 0, '2017-01-05 00:05:32', NULL),
(3, 'OVEN', 'MICROWAVE OVEN', 4, '5500981666848-ven-hamilton-beach-countertop-oven-with-rotisserie-31104-de.jpg', 0, 0, '2017-01-05 00:19:54', '2017-01-05 00:26:51'),
(4, 'HITTER', 'WATER HITTER ', 4, 'inalsa-msg-10-storage-water-heater-large_afe92f4c9529ce58cc2c78df7af106a9.jpg', 0, 0, '2017-01-05 00:21:24', '2017-01-05 00:27:09'),
(5, 'HOODI', 'BLUE LONG HOODI', 6, 'b0eeafcf400ee71385519fecfa877274.jpg', 0, 0, '2017-01-05 00:22:56', '2017-01-05 00:26:30'),
(6, 'STRAIGHTNER', 'HAIR STRAIGHTNER', 3, '', 0, 0, '2017-01-05 01:35:12', NULL),
(7, 'LED', 'SAMSUNG LED TV', 4, '', 0, 0, '2017-01-05 01:35:47', NULL),
(8, 'LG', 'LG REFRIGERATOR ', 4, '', 0, 0, '2017-01-05 01:36:29', NULL),
(9, 'TOSTER', 'SONY TOSTER', 4, '', 0, 0, '2017-01-05 01:37:23', NULL),
(10, 'SAMSUNG', 'SAMSUNG J5', 2, '', 0, 0, NULL, NULL),
(11, 'LOGITECH', 'LOGITECH HEADPHONE', 3, '', 0, 0, '2017-01-05 01:41:50', NULL),
(12, 'WATERPOT', 'TUPPER WATER POT', 4, '', 0, 0, '2017-01-05 01:42:48', NULL),
(13, 'MYONE', 'MYONE TV', 4, '', 0, 0, NULL, NULL),
(14, 'SONY', 'SONY LED TV', 4, '', 0, 0, NULL, NULL),
(15, 'WALTON', 'WALTON LED TV', 4, '', 0, 0, NULL, NULL),
(16, 'BUTTERFLY', 'BUTTERFLY FRIDGE', 4, '', 0, 0, NULL, NULL),
(17, 'SINGER', 'SINGER REFREGARETER', 4, '', 0, 0, NULL, NULL),
(18, 'VISON', 'VISON REFREGARETER', 4, '', 0, 0, NULL, NULL),
(19, 'ASUS', 'ASUS MOBILE', 2, '', 0, 0, NULL, '2017-01-06 23:47:46'),
(20, 'HTC', 'HTC MOBILE', 2, '', 0, 0, NULL, '2017-01-05 02:08:09'),
(21, 'MI', 'XWAMI PHONE', 2, '', 0, 0, NULL, '2017-01-05 02:09:23'),
(22, 'OPPO', 'OPPO F1', 2, '', 0, 0, NULL, '2017-01-05 02:08:56'),
(23, 'SYMPHONE', 'SYMPHONE F8', 4, '', 0, 0, NULL, NULL),
(24, 'AC-LG', 'LG AIRCONDITIONER', 4, '', 0, 0, NULL, NULL),
(25, 'NIPPON', 'NIPPON TV', 4, '', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_tax_types`
--

CREATE TABLE IF NOT EXISTS `item_tax_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_rate` double(8,2) NOT NULL,
  `exempt` tinyint(4) NOT NULL,
  `defaults` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `item_tax_types`
--

INSERT INTO `item_tax_types` (`id`, `name`, `tax_rate`, `exempt`, `defaults`) VALUES
(1, 'Tax Exempt', 0.00, 1, 0),
(2, 'Sales Tax', 15.00, 0, 1),
(3, 'Purchases Tax', 15.00, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `item_unit`
--

CREATE TABLE IF NOT EXISTS `item_unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `abbr` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `item_unit`
--

INSERT INTO `item_unit` (`id`, `abbr`, `name`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'each', 'Each', 0, '2017-01-04 23:35:07', NULL),
(2, 'Kg', 'kilogram', 0, '2017-01-05 00:06:38', NULL),
(3, 'Box', 'Box', 0, '2017-01-05 00:06:54', NULL),
(4, 'pc', 'Pc', 0, '2017-01-05 00:07:18', '2017-01-05 00:08:43');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `loc_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `location_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_address` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `loc_code`, `location_name`, `delivery_address`, `email`, `phone`, `fax`, `contact`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'PL', 'Primary Location', 'Primary Location', '', '', '', 'Primary Location', 0, '2017-01-04 23:35:07', NULL),
(2, 'GL101', 'Gulshan ', 'DCC market, Gulshan-2,Dhaka', 'dcc@gmail.com', '12345', '123', 'DCC Manager', 0, '2017-01-05 00:35:28', NULL),
(3, 'BD102', 'Badda', 'Badda link road, badda,dhaka', 'badda@test.com', '12345', '4636', 'Rabin Ahmed', 0, '2017-01-05 00:36:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_100000_create_password_resets_table', 1),
('2016_08_30_100832_create_users_table', 1),
('2016_08_30_104058_create_security_role_table', 1),
('2016_08_30_104506_create_stock_category_table', 1),
('2016_08_30_105339_create_location_table', 1),
('2016_08_30_110408_create_item_code_table', 1),
('2016_08_30_114231_create_item_unit_table', 1),
('2016_09_02_070031_create_stock_master_table', 1),
('2016_09_20_123717_create_stock_move_table', 1),
('2016_10_05_113244_create_debtor_master_table', 1),
('2016_10_05_113333_create_sales_orders_table', 1),
('2016_10_05_113356_create_sales_order_details_table', 1),
('2016_10_18_060431_create_supplier_table', 1),
('2016_10_18_063931_create_purch_order_table', 1),
('2016_10_18_064211_create_purch_order_detail_table', 1),
('2016_11_15_121343_create_preference_table', 1),
('2016_12_01_130110_create_shipment_table', 1),
('2016_12_01_130443_create_shipment_details_table', 1),
('2016_12_03_051429_create_sale_price_table', 1),
('2016_12_03_052017_create_sales_types_table', 1),
('2016_12_03_061206_create_purchase_price_table', 1),
('2016_12_03_062131_create_payment_term_table', 1),
('2016_12_03_062247_create_payment_history_table', 1),
('2016_12_03_062932_create_item_tax_type_table', 1),
('2016_12_03_063827_create_invoice_payment_term_table', 1),
('2016_12_03_064157_create_email_temp_details_table', 1),
('2016_12_03_064747_create_email_config_table', 1),
('2016_12_03_065532_create_cust_branch_table', 1),
('2016_12_03_065915_create_currency_table', 1),
('2016_12_03_070030_create_country_table', 1),
('2016_12_03_070030_create_stock_transfer_table', 1),
('2016_12_03_071018_create_backup_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE IF NOT EXISTS `payment_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `payment_type_id` smallint(6) NOT NULL,
  `order_reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_date` date NOT NULL,
  `amount` double DEFAULT '0',
  `person_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `payment_history`
--

INSERT INTO `payment_history` (`id`, `payment_type_id`, `order_reference`, `invoice_reference`, `payment_date`, `amount`, `person_id`, `customer_id`, `reference`, `created_at`, `updated_at`) VALUES
(1, 1, 'SO-0001', 'INV-0001', '2017-01-05', 20000, 1, 1, '', NULL, NULL),
(2, 2, 'SO-0002', 'INV-0002', '2017-01-05', 6762, 1, 2, '', NULL, NULL),
(3, 1, 'SO-0006', 'INV-0005', '2017-01-05', 3000, 1, 3, '', NULL, NULL),
(4, 1, 'SO-0007', 'INV-0008', '2017-01-07', 2000, 1, 4, '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment_terms`
--

CREATE TABLE IF NOT EXISTS `payment_terms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `defaults` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `payment_terms`
--

INSERT INTO `payment_terms` (`id`, `name`, `defaults`) VALUES
(1, 'Bank', 1),
(2, 'Cash', 0);

-- --------------------------------------------------------

--
-- Table structure for table `preference`
--

CREATE TABLE IF NOT EXISTS `preference` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `preference`
--

INSERT INTO `preference` (`id`, `category`, `field`, `value`) VALUES
(1, 'preference', 'row_per_page', '10'),
(2, 'preference', 'date_format', '0'),
(3, 'preference', 'date_sepa', '-'),
(4, 'preference', 'soft_name', 'Stockpile'),
(5, 'company', 'site_short_name', 'SP'),
(6, 'preference', 'percentage', '0'),
(7, 'preference', 'quantity', '0'),
(8, 'preference', 'date_format_type', 'yyyy-mm-dd'),
(9, 'company', 'company_name', 'StockPiles'),
(10, 'company', 'company_email', 'demo@demo.com'),
(11, 'company', 'company_phone', '123465798'),
(12, 'company', 'company_street', '19/19 (2nd Floor)'),
(13, 'company', 'company_city', 'Dhaka'),
(14, 'company', 'company_state', 'Dhaka'),
(15, 'company', 'company_zipCode', '1200'),
(16, 'company', 'company_country_id', 'Bangladesh'),
(17, 'company', 'dflt_lang', 'en'),
(18, 'company', 'dflt_currency_id', '1'),
(19, 'company', 'sates_type_id', '1');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_prices`
--

CREATE TABLE IF NOT EXISTS `purchase_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `suppliers_uom` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `conversion_factor` double DEFAULT '1',
  `supplier_description` char(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `purchase_prices`
--

INSERT INTO `purchase_prices` (`id`, `stock_id`, `price`, `suppliers_uom`, `conversion_factor`, `supplier_description`) VALUES
(1, 'IPHONE7', 40000, '', 1, ''),
(2, 'HP430', 25000, '', 1, ''),
(3, 'OVEN', 3000, '', 1, ''),
(4, 'HITTER', 1000, '', 1, ''),
(5, 'HOODI', 800, '', 1, ''),
(6, 'STRAIGHTNER', 1200, '', 1, ''),
(7, 'LED', 2800, '', 1, ''),
(8, 'LG', 4200, '', 1, ''),
(9, 'TOSTER', 1600, '', 1, ''),
(10, 'SAMSUNG', 15000, '', 1, ''),
(11, 'LOGITECH', 500, '', 1, ''),
(12, 'WATERPOT', 220, '', 1, ''),
(13, 'MYONE', 2800, '', 1, ''),
(14, 'SONY', 3000, '', 1, ''),
(15, 'WALTON', 5000, '', 1, ''),
(16, 'BUTTERFLY', 2800, '', 1, ''),
(17, 'SINGER', 5000, '', 1, ''),
(18, 'VISON', 3000, '', 1, ''),
(19, 'ASUS', 3000, '', 1, ''),
(20, 'HTC', 2800, '', 1, ''),
(21, 'MI', 2300, '', 1, ''),
(22, 'OPPO', 2500, '', 1, ''),
(23, 'SYMPHONE', 5000, '', 1, ''),
(24, 'AC-LG', 3000, '', 1, ''),
(25, 'NIPPON', 5000, '', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `purch_orders`
--

CREATE TABLE IF NOT EXISTS `purch_orders` (
  `order_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `comments` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `ord_date` date NOT NULL,
  `reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `requisition_no` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `into_stock_location` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_address` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `tax_included` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `purch_orders`
--

INSERT INTO `purch_orders` (`order_no`, `supplier_id`, `comments`, `ord_date`, `reference`, `requisition_no`, `into_stock_location`, `delivery_address`, `total`, `tax_included`, `created_at`, `updated_at`) VALUES
(1, 1, 'test', '2017-01-05', 'PO-0001', NULL, 'GL101', '', 46270000, 'yes', '2017-01-05 00:37:40', NULL),
(2, 2, '', '2017-01-05', 'PO-0002', NULL, 'PL', '', 345000, 'yes', '2017-01-05 01:32:40', NULL),
(3, 3, '', '2017-01-05', 'PO-0003', NULL, 'PL', '', 100000, 'yes', '2017-01-05 01:33:05', NULL),
(4, 3, '', '2017-01-05', 'PO-0004', NULL, 'PL', '', 55200, 'yes', '2017-01-05 01:33:35', NULL),
(5, 2, '', '2017-01-05', 'PO-0005', NULL, 'PL', '', 445000, 'yes', '2017-01-05 01:38:21', NULL),
(6, 1, '', '2017-01-05', 'PO-0006', NULL, 'PL', '', 1725000, 'yes', '2017-01-05 01:40:25', NULL),
(7, 3, '', '2017-01-05', 'PO-0007', NULL, 'GL101', '', 1449000, 'yes', '2017-01-05 01:40:55', NULL),
(8, 3, '', '2017-01-05', 'PO-0008', NULL, 'PL', '', 753000, 'yes', '2017-01-05 01:43:38', NULL),
(9, 1, '', '2017-01-05', 'PO-0009', NULL, 'PL', '', 3151000, 'yes', '2017-01-05 02:13:12', NULL),
(10, 3, '', '2017-01-05', 'PO-0010', NULL, 'GL101', '', 1817000, 'yes', '2017-01-05 02:14:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purch_order_details`
--

CREATE TABLE IF NOT EXISTS `purch_order_details` (
  `po_detail_item` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL,
  `item_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `qty_invoiced` double NOT NULL DEFAULT '0',
  `unit_price` double NOT NULL DEFAULT '0',
  `act_price` double NOT NULL DEFAULT '0',
  `tax_type_id` int(11) NOT NULL,
  `std_cost_unit` double NOT NULL DEFAULT '0',
  `quantity_ordered` double NOT NULL DEFAULT '0',
  `quantity_received` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`po_detail_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `purch_order_details`
--

INSERT INTO `purch_order_details` (`po_detail_item`, `order_no`, `item_code`, `description`, `qty_invoiced`, `unit_price`, `act_price`, `tax_type_id`, `std_cost_unit`, `quantity_ordered`, `quantity_received`, `created_at`, `updated_at`) VALUES
(1, 1, 'HOODI', 'BLUE LONG HOODI', 1000, 800, 0, 2, 0, 1000, 1000, NULL, NULL),
(2, 1, 'HP430', 'HP LAPTOP 430', 700, 25000, 0, 2, 0, 700, 700, NULL, NULL),
(3, 1, 'IPHONE7', 'IPHONE 7', 500, 40000, 0, 3, 0, 500, 500, NULL, NULL),
(4, 1, 'HITTER', 'WATER HITTER ', 500, 1000, 0, 1, 0, 500, 500, NULL, NULL),
(5, 1, 'OVEN', 'MICROWAVE OVEN', 500, 3000, 0, 2, 0, 500, 500, NULL, NULL),
(6, 2, 'OVEN', 'MICROWAVE OVEN', 100, 3000, 0, 2, 0, 100, 100, NULL, NULL),
(7, 3, 'HITTER', 'WATER HITTER ', 100, 1000, 0, 1, 0, 100, 100, NULL, NULL),
(8, 4, 'HOODI', 'BLUE LONG HOODI', 60, 800, 0, 2, 0, 60, 60, NULL, NULL),
(9, 5, 'LED', 'SAMSUNG LED TV', 100, 3000, 0, 3, 0, 100, 100, NULL, NULL),
(10, 5, 'TOSTER', 'SONY TOSTER', 100, 1000, 0, 1, 0, 100, 100, NULL, NULL),
(11, 6, 'STRAIGHTNER', 'HAIR STRAIGHTNER', 100, 0, 0, 2, 0, 100, 100, NULL, NULL),
(12, 6, 'SAMSUNG', 'SAMSUNG J5', 100, 15000, 0, 2, 0, 100, 100, NULL, NULL),
(13, 6, 'LED', 'SAMSUNG LED TV', 100, 0, 0, 3, 0, 100, 100, NULL, NULL),
(14, 7, 'LG', 'LG REFRIGERATOR ', 300, 4200, 0, 3, 0, 300, 300, NULL, NULL),
(15, 8, 'LOGITECH', 'LOGITECH HEADPHONE', 1000, 500, 0, 1, 0, 1000, 1000, NULL, NULL),
(16, 8, 'WATERPOT', 'TUPPER WATER POT', 1000, 220, 0, 3, 0, 1000, 1000, NULL, NULL),
(17, 9, 'BUTTERFLY', 'BUTTERFLY FRIDGE', 100, 2800, 0, 2, 0, 100, 100, NULL, NULL),
(18, 9, 'HTC', 'HTC MOBILE', 100, 2800, 0, 2, 0, 100, 100, NULL, NULL),
(19, 9, 'AC-LG', 'LG AIRCONDITIONER', 100, 3000, 0, 2, 0, 100, 100, NULL, NULL),
(20, 9, 'SYMPHONE', 'SYMPHONE F8', 100, 5000, 0, 2, 0, 100, 100, NULL, NULL),
(21, 9, 'MI', 'XWAMI PHONE', 100, 2300, 0, 2, 0, 100, 100, NULL, NULL),
(22, 9, 'OPPO', 'OPPO F1', 100, 2500, 0, 2, 0, 100, 100, NULL, NULL),
(23, 9, 'ASUS', 'ASUS MOBILE', 100, 3000, 0, 2, 0, 100, 100, NULL, NULL),
(24, 9, 'VISON', 'VISON REFREGARETER', 200, 3000, 0, 2, 0, 200, 200, NULL, NULL),
(25, 10, 'NIPPON', 'NIPPON TV', 100, 5000, 0, 2, 0, 100, 100, NULL, NULL),
(26, 10, 'MYONE', 'MYONE TV', 100, 2800, 0, 2, 0, 100, 100, NULL, NULL),
(27, 10, 'SINGER', 'SINGER REFREGARETER', 100, 5000, 0, 2, 0, 100, 100, NULL, NULL),
(28, 10, 'SONY', 'SONY LED TV', 100, 3000, 0, 2, 0, 100, 100, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_orders`
--

CREATE TABLE IF NOT EXISTS `sales_orders` (
  `order_no` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `trans_type` int(11) NOT NULL,
  `debtor_no` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `version` tinyint(4) NOT NULL,
  `reference` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `customer_ref` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_reference_id` int(11) NOT NULL,
  `order_reference` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ord_date` date NOT NULL,
  `order_type` int(11) NOT NULL,
  `delivery_address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deliver_to` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_stk_loc` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `payment_id` tinyint(4) NOT NULL,
  `total` double NOT NULL DEFAULT '0',
  `paid_amount` double NOT NULL DEFAULT '0',
  `choices` enum('no','partial_created','full_created') COLLATE utf8_unicode_ci NOT NULL,
  `payment_term` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`order_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `sales_orders`
--

INSERT INTO `sales_orders` (`order_no`, `trans_type`, `debtor_no`, `branch_id`, `version`, `reference`, `customer_ref`, `order_reference_id`, `order_reference`, `comments`, `ord_date`, `order_type`, `delivery_address`, `contact_phone`, `contact_email`, `deliver_to`, `from_stk_loc`, `delivery_date`, `payment_id`, `total`, `paid_amount`, `choices`, `payment_term`, `created_at`, `updated_at`) VALUES
(1, 201, 1, 1, 1, 'SO-0001', NULL, 0, NULL, '', '2017-01-05', 0, NULL, NULL, NULL, NULL, 'GL101', NULL, 1, 440021.75, 0, 'no', 0, '2017-01-05 00:39:13', NULL),
(2, 202, 1, 1, 0, 'INV-0001', NULL, 1, 'SO-0001', '', '2017-01-05', 0, NULL, NULL, NULL, NULL, 'GL101', NULL, 1, 382375, 20000, 'no', 1, '2017-01-05 00:39:22', NULL),
(3, 201, 2, 2, 1, 'SO-0002', NULL, 0, NULL, '', '2017-01-05', 0, NULL, NULL, NULL, NULL, 'GL101', NULL, 1, 6762, 0, 'no', 0, '2017-01-05 00:43:24', NULL),
(4, 202, 2, 2, 0, 'INV-0002', NULL, 3, 'SO-0002', '', '2017-01-05', 0, NULL, NULL, NULL, NULL, 'GL101', NULL, 1, 6762, 6762, 'no', 1, '2017-01-05 00:43:24', NULL),
(5, 201, 1, 1, 0, 'SO-0003', NULL, 0, NULL, '', '2017-01-05', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 32052, 0, 'no', 0, '2017-01-05 01:44:56', NULL),
(6, 202, 1, 1, 0, 'INV-0003', NULL, 5, 'SO-0003', '', '2017-01-05', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 32052, 0, 'no', 1, '2017-01-05 01:44:56', NULL),
(7, 201, 1, 1, 1, 'SO-0004', NULL, 0, NULL, '', '2017-01-05', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 0, 0, 'no', 0, '2017-01-05 01:45:55', '2017-01-05 06:11:11'),
(8, 201, 1, 1, 1, 'SO-0005', NULL, 0, NULL, '', '2017-01-05', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 101200, 0, 'no', 0, '2017-01-05 01:49:13', NULL),
(9, 202, 1, 1, 0, 'INV-0004', NULL, 8, 'SO-0005', '', '2017-01-05', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 101200, 0, 'no', 1, '2017-01-05 01:49:13', NULL),
(10, 201, 3, 3, 0, 'SO-0006', NULL, 0, NULL, '', '2017-01-05', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 55250, 0, 'no', 0, '2017-01-05 02:50:46', NULL),
(12, 202, 3, 3, 0, 'INV-0005', NULL, 10, 'SO-0006', '', '2017-01-05', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 55250, 3000, 'no', 1, '2017-01-05 05:32:30', NULL),
(13, 202, 1, 1, 0, 'INV-0006', NULL, 7, 'SO-0004', '', '2017-01-05', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 0, 0, 'no', 1, '2017-01-05 06:13:17', NULL),
(14, 201, 4, 4, 1, 'SO-0007', NULL, 0, NULL, '', '2017-01-06', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 420175, 0, 'no', 0, '2017-01-06 01:35:46', NULL),
(15, 202, 4, 4, 0, 'INV-0007', NULL, 14, 'SO-0007', '', '2017-01-06', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 74080, 0, 'no', 2, '2017-01-06 01:36:50', '2017-01-06 01:37:13'),
(16, 202, 4, 4, 0, 'INV-0008', NULL, 14, 'SO-0007', 'Delivery 1', '2017-01-06', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 31280, 2000, 'no', 1, '2017-01-06 01:38:02', NULL),
(17, 202, 1, 1, 0, 'INV-0009', NULL, 7, 'SO-0004', '', '2017-01-07', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 0, 0, 'no', 1, '2017-01-07 03:38:51', NULL),
(18, 202, 4, 4, 0, 'INV-0010', NULL, 14, 'SO-0007', '', '2017-01-07', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 271565, 0, 'no', 1, '2017-01-07 03:42:31', '2017-01-07 03:42:46'),
(19, 201, 4, 4, 1, 'SO-0008', NULL, 0, NULL, '', '2017-01-07', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 40250, 0, 'no', 0, '2017-01-07 03:56:35', NULL),
(20, 202, 4, 4, 0, 'INV-0011', NULL, 19, 'SO-0008', '', '2017-01-07', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 40250, 0, 'no', 1, '2017-01-07 03:56:39', NULL),
(21, 201, 4, 4, 0, 'SO-0009', NULL, 0, NULL, '', '2017-01-07', 0, NULL, NULL, NULL, NULL, 'PL', NULL, 1, 4600, 0, 'no', 0, '2017-01-07 05:12:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_details`
--

CREATE TABLE IF NOT EXISTS `sales_order_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL,
  `trans_type` int(11) NOT NULL,
  `stock_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tax_type_id` tinyint(4) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `unit_price` double NOT NULL DEFAULT '0',
  `qty_sent` double NOT NULL DEFAULT '0',
  `quantity` double NOT NULL DEFAULT '0',
  `shipment_qty` double NOT NULL DEFAULT '0',
  `discount_percent` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=62 ;

--
-- Dumping data for table `sales_order_details`
--

INSERT INTO `sales_order_details` (`id`, `order_no`, `trans_type`, `stock_id`, `tax_type_id`, `description`, `unit_price`, `qty_sent`, `quantity`, `shipment_qty`, `discount_percent`, `created_at`, `updated_at`) VALUES
(1, 1, 201, 'OVEN', 2, 'MICROWAVE OVEN', 3500, 0, 11, 0, 3, NULL, NULL),
(2, 1, 201, 'HITTER', 1, 'WATER HITTER ', 1500, 0, 10, 0, 2, NULL, NULL),
(3, 1, 201, 'HP430', 2, 'HP LAPTOP 430', 35000, 0, 10, 6, 5, NULL, NULL),
(4, 2, 202, 'HP430', 2, 'HP LAPTOP 430', 35000, 10, 10, 0, 5, NULL, NULL),
(5, 3, 201, 'HOODI', 2, 'BLUE LONG HOODI', 1000, 6, 6, 6, 2, NULL, NULL),
(6, 4, 202, 'HOODI', 2, 'BLUE LONG HOODI', 1000, 6, 6, 0, 2, NULL, NULL),
(7, 5, 201, 'LOGITECH', 1, 'LOGITECH HEADPHONE', 700, 15, 15, 0, 2, NULL, NULL),
(8, 6, 202, 'LOGITECH', 1, 'LOGITECH HEADPHONE', 700, 15, 15, 0, 2, NULL, NULL),
(9, 5, 201, 'HITTER', 1, 'WATER HITTER ', 1500, 10, 10, 0, 0, NULL, NULL),
(10, 6, 202, 'HITTER', 1, 'WATER HITTER ', 1500, 10, 10, 0, 0, NULL, NULL),
(11, 5, 201, 'WATERPOT', 3, 'TUPPER WATER POT', 300, 20, 20, 0, 2, NULL, NULL),
(12, 6, 202, 'WATERPOT', 3, 'TUPPER WATER POT', 300, 20, 20, 0, 2, NULL, NULL),
(13, 7, 201, 'LED', 3, 'SAMSUNG LED TV', 0, 2, 2, 0, 0, NULL, NULL),
(14, 7, 201, 'STRAIGHTNER', 2, 'HAIR STRAIGHTNER', 0, 3, 3, 2, 0, NULL, NULL),
(15, 8, 201, 'LED', 3, 'SAMSUNG LED TV', 3200, 10, 10, 2, 0, NULL, NULL),
(16, 9, 202, 'LED', 3, 'SAMSUNG LED TV', 3200, 10, 10, 0, 0, NULL, NULL),
(17, 8, 201, 'TOSTER', 2, 'SONY TOSTER', 2000, 14, 14, 0, 0, NULL, NULL),
(18, 9, 202, 'TOSTER', 2, 'SONY TOSTER', 2000, 14, 14, 0, 0, NULL, NULL),
(19, 8, 201, 'OVEN', 2, 'MICROWAVE OVEN', 3500, 8, 8, 8, 0, NULL, NULL),
(20, 9, 202, 'OVEN', 2, 'MICROWAVE OVEN', 3500, 8, 8, 0, 0, NULL, NULL),
(21, 10, 201, 'HITTER', 1, 'WATER HITTER ', 1500, 0, 10, 0, 0, NULL, NULL),
(22, 10, 201, 'OVEN', 2, 'MICROWAVE OVEN', 3500, 0, 10, 0, 0, NULL, NULL),
(24, 12, 202, 'OVEN', 2, 'MICROWAVE OVEN', 3500, 10, 10, 0, 0, NULL, NULL),
(25, 12, 202, 'HITTER', 1, 'WATER HITTER ', 1500, 10, 10, 0, 0, NULL, NULL),
(26, 13, 202, 'STRAIGHTNER', 2, 'HAIR STRAIGHTNER', 0, 2, 2, 0, 0, NULL, NULL),
(27, 13, 202, 'LED', 3, 'SAMSUNG LED TV', 0, 1, 1, 0, 0, NULL, NULL),
(28, 14, 201, 'VISON', 2, 'VISON REFREGARETER', 3200, 0, 15, 0, 0, NULL, NULL),
(29, 14, 201, 'SINGER', 2, 'SINGER REFREGARETER', 5200, 0, 13, 0, 0, NULL, NULL),
(30, 14, 201, 'WALTON', 2, 'WALTON LED TV', 5200, 0, 11, 0, 0, NULL, NULL),
(31, 14, 201, 'WATERPOT', 3, 'TUPPER WATER POT', 300, 0, 9, 0, 0, NULL, NULL),
(32, 14, 201, 'LOGITECH', 1, 'LOGITECH HEADPHONE', 700, 0, 7, 0, 0, NULL, NULL),
(33, 14, 201, 'SAMSUNG', 2, 'SAMSUNG J5', 16000, 0, 6, 1, 0, NULL, NULL),
(34, 14, 201, 'LG', 3, 'LG REFRIGERATOR ', 5000, 0, 5, 2, 0, NULL, NULL),
(35, 14, 201, 'STRAIGHTNER', 2, 'HAIR STRAIGHTNER', 1400, 0, 15, 2, 0, NULL, NULL),
(36, 14, 201, 'HITTER', 1, 'WATER HITTER ', 1500, 0, 2, 0, 0, NULL, NULL),
(37, 14, 201, 'HOODI', 2, 'BLUE LONG HOODI', 1000, 0, 6, 1, 0, NULL, NULL),
(38, 14, 201, 'HP430', 2, 'HP LAPTOP 430', 35000, 0, 1, 0, 0, NULL, NULL),
(39, 15, 202, 'HOODI', 2, 'BLUE LONG HOODI', 1000, 2, 2, 0, 0, NULL, NULL),
(40, 15, 202, 'STRAIGHTNER', 2, 'HAIR STRAIGHTNER', 1400, 3, 3, 0, 0, NULL, NULL),
(41, 15, 202, 'LG', 3, 'LG REFRIGERATOR ', 5000, 5, 5, 0, 0, NULL, NULL),
(42, 15, 202, 'SAMSUNG', 2, 'SAMSUNG J5', 16000, 2, 2, 0, 0, NULL, NULL),
(43, 15, 202, 'LOGITECH', 1, 'LOGITECH HEADPHONE', 700, 2, 2, 0, 0, NULL, NULL),
(44, 16, 202, 'WALTON', 2, 'WALTON LED TV', 5200, 2, 2, 0, 0, NULL, NULL),
(45, 16, 202, 'SINGER', 2, 'SINGER REFREGARETER', 5200, 2, 2, 0, 0, NULL, NULL),
(46, 16, 202, 'VISON', 2, 'VISON REFREGARETER', 3200, 2, 2, 0, 0, NULL, NULL),
(47, 17, 202, 'STRAIGHTNER', 2, 'HAIR STRAIGHTNER', 0, 0, 0, 0, 0, NULL, NULL),
(48, 17, 202, 'LED', 3, 'SAMSUNG LED TV', 0, 1, 1, 0, 0, NULL, NULL),
(49, 18, 202, 'HP430', 2, 'HP LAPTOP 430', 35000, 0, 0, 0, 0, NULL, NULL),
(50, 18, 202, 'HITTER', 1, 'WATER HITTER ', 1500, 0, 0, 0, 0, NULL, NULL),
(51, 18, 202, 'HOODI', 2, 'BLUE LONG HOODI', 1000, 4, 4, 0, 0, NULL, NULL),
(52, 18, 202, 'STRAIGHTNER', 2, 'HAIR STRAIGHTNER', 1400, 12, 12, 0, 0, NULL, NULL),
(53, 18, 202, 'SAMSUNG', 2, 'SAMSUNG J5', 16000, 4, 4, 0, 0, NULL, NULL),
(54, 18, 202, 'LOGITECH', 1, 'LOGITECH HEADPHONE', 700, 5, 5, 0, 0, NULL, NULL),
(55, 18, 202, 'WATERPOT', 3, 'TUPPER WATER POT', 300, 9, 9, 0, 0, NULL, NULL),
(56, 18, 202, 'WALTON', 2, 'WALTON LED TV', 5200, 9, 9, 0, 0, NULL, NULL),
(57, 18, 202, 'SINGER', 2, 'SINGER REFREGARETER', 5200, 11, 11, 0, 0, NULL, NULL),
(58, 18, 202, 'VISON', 2, 'VISON REFREGARETER', 3200, 13, 13, 0, 0, NULL, NULL),
(59, 19, 201, 'HP430', 2, 'HP LAPTOP 430', 35000, 0, 1, 1, 0, NULL, NULL),
(60, 20, 202, 'HP430', 2, 'HP LAPTOP 430', 35000, 1, 1, 0, 0, NULL, NULL),
(61, 21, 201, 'TOSTER', 2, 'SONY TOSTER', 2000, 0, 2, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_types`
--

CREATE TABLE IF NOT EXISTS `sales_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sales_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_included` int(11) NOT NULL,
  `factor` double NOT NULL,
  `defaults` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sales_types`
--

INSERT INTO `sales_types` (`id`, `sales_type`, `tax_included`, `factor`, `defaults`) VALUES
(1, 'Retail', 1, 0, 1),
(2, 'Wholesale', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sale_prices`
--

CREATE TABLE IF NOT EXISTS `sale_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sales_type_id` int(11) NOT NULL,
  `curr_abrev` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

--
-- Dumping data for table `sale_prices`
--

INSERT INTO `sale_prices` (`id`, `stock_id`, `sales_type_id`, `curr_abrev`, `price`) VALUES
(1, 'IPHONE7', 1, 'USD', 60000),
(2, 'IPHONE7', 2, 'USD', 50000),
(3, 'HP430', 1, 'USD', 35000),
(4, 'HP430', 2, 'USD', 30000),
(5, 'OVEN', 1, 'USD', 3500),
(6, 'OVEN', 2, 'USD', 3200),
(7, 'HITTER', 1, 'USD', 1500),
(8, 'HITTER', 2, 'USD', 1300),
(9, 'HOODI', 1, 'USD', 1000),
(10, 'HOODI', 2, 'USD', 900),
(11, 'STRAIGHTNER', 1, 'USD', 1400),
(12, 'STRAIGHTNER', 2, 'USD', 1300),
(13, 'LED', 1, 'USD', 3200),
(14, 'LED', 2, 'USD', 3000),
(15, 'LG', 1, 'USD', 5000),
(16, 'LG', 2, 'USD', 4500),
(17, 'TOSTER', 1, 'USD', 2000),
(18, 'TOSTER', 2, 'USD', 1800),
(19, 'SAMSUNG', 1, 'USD', 16000),
(20, 'SAMSUNG', 2, 'USD', 15500),
(21, 'LOGITECH', 1, 'USD', 700),
(22, 'LOGITECH', 2, 'USD', 600),
(23, 'WATERPOT', 1, 'USD', 300),
(24, 'WATERPOT', 2, 'USD', 270),
(25, 'MYONE', 1, 'USD', 3000),
(26, 'SONY', 1, 'USD', 3200),
(27, 'WALTON', 1, 'USD', 5200),
(28, 'MYONE', 2, 'USD', 2900),
(29, 'SONY', 2, 'USD', 3100),
(30, 'WALTON', 2, 'USD', 5100),
(31, 'BUTTERFLY', 1, 'USD', 3000),
(32, 'SINGER', 1, 'USD', 5200),
(33, 'VISON', 1, 'USD', 3200),
(34, 'BUTTERFLY', 2, 'USD', 2900),
(35, 'SINGER', 2, 'USD', 5100),
(36, 'VISON', 2, 'USD', 3100),
(37, 'ASUS', 1, 'USD', 3200),
(38, 'HTC', 1, 'USD', 3000),
(39, 'MI', 1, 'USD', 2500),
(40, 'OPPO', 1, 'USD', 2800),
(41, 'SYMPHONE', 1, 'USD', 5200),
(42, 'ASUS', 2, 'USD', 3100),
(43, 'HTC', 2, 'USD', 2900),
(44, 'MI', 2, 'USD', 2400),
(45, 'OPPO', 2, 'USD', 2700),
(46, 'SYMPHONE', 2, 'USD', 5100),
(47, 'AC-LG', 1, 'USD', 3200),
(48, 'NIPPON', 1, 'USD', 5200),
(49, 'AC-LG', 2, 'USD', 3100),
(50, 'NIPPON', 2, 'USD', 5100);

-- --------------------------------------------------------

--
-- Table structure for table `security_role`
--

CREATE TABLE IF NOT EXISTS `security_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sections` text COLLATE utf8_unicode_ci,
  `areas` text COLLATE utf8_unicode_ci,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `security_role`
--

INSERT INTO `security_role` (`id`, `role`, `description`, `sections`, `areas`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'System Administrator', 'System Administrator', 'a:21:{s:8:"category";s:3:"100";s:4:"unit";s:3:"600";s:3:"loc";s:3:"200";s:4:"item";s:3:"300";s:4:"user";s:3:"400";s:4:"role";s:3:"500";s:8:"customer";s:3:"700";s:5:"sales";s:3:"800";s:8:"purchese";s:3:"900";s:8:"supplier";s:4:"1000";s:8:"transfer";s:4:"1100";s:5:"order";s:4:"1200";s:8:"shipment";s:4:"1300";s:7:"payment";s:4:"1400";s:6:"backup";s:4:"1500";s:5:"email";s:4:"1600";s:3:"tax";s:4:"1900";s:9:"salestype";s:4:"2000";s:10:"currencies";s:4:"2100";s:11:"paymentterm";s:4:"2200";s:13:"paymentmethod";s:4:"2300";}', 'a:62:{s:7:"cat_add";s:3:"101";s:8:"cat_edit";s:3:"102";s:10:"cat_delete";s:3:"103";s:8:"unit_add";s:3:"601";s:9:"unit_edit";s:3:"602";s:11:"unit_delete";s:3:"603";s:7:"loc_add";s:3:"201";s:8:"loc_edit";s:3:"202";s:10:"loc_delete";s:3:"203";s:8:"item_add";s:3:"301";s:9:"item_edit";s:3:"302";s:11:"item_delete";s:3:"303";s:9:"item_copy";s:3:"304";s:8:"user_add";s:3:"401";s:9:"user_edit";s:3:"402";s:11:"user_delete";s:3:"403";s:9:"user_role";s:3:"501";s:12:"customer_add";s:3:"701";s:13:"customer_edit";s:3:"702";s:15:"customer_delete";s:3:"703";s:9:"sales_add";s:3:"801";s:10:"sales_edit";s:3:"802";s:12:"sales_delete";s:3:"803";s:12:"purchese_add";s:3:"901";s:13:"purchese_edit";s:3:"902";s:15:"purchese_delete";s:3:"903";s:12:"supplier_add";s:4:"1001";s:13:"supplier_edit";s:4:"1002";s:15:"supplier_delete";s:4:"1003";s:12:"transfer_add";s:4:"1101";s:13:"transfer_edit";s:4:"1102";s:15:"transfer_delete";s:4:"1103";s:9:"order_add";s:4:"1201";s:10:"order_edit";s:4:"1202";s:12:"order_delete";s:4:"1203";s:12:"shipment_add";s:4:"1301";s:13:"shipment_edit";s:4:"1302";s:15:"shipment_delete";s:4:"1303";s:11:"payment_add";s:4:"1401";s:12:"payment_edit";s:4:"1402";s:14:"payment_delete";s:4:"1403";s:10:"backup_add";s:4:"1501";s:15:"backup_download";s:4:"1502";s:9:"email_add";s:4:"1601";s:9:"emailtemp";s:4:"1700";s:10:"preference";s:4:"1800";s:7:"tax_add";s:4:"1901";s:8:"tax_edit";s:4:"1902";s:10:"tax_delete";s:4:"1903";s:13:"salestype_add";s:4:"2001";s:14:"salestype_edit";s:4:"2002";s:16:"salestype_delete";s:4:"2003";s:14:"currencies_add";s:4:"2101";s:15:"currencies_edit";s:4:"2102";s:17:"currencies_delete";s:4:"2103";s:15:"paymentterm_add";s:4:"2201";s:16:"paymentterm_edit";s:4:"2202";s:18:"paymentterm_delete";s:4:"2203";s:17:"paymentmethod_add";s:4:"2301";s:18:"paymentmethod_edit";s:4:"2302";s:20:"paymentmethod_delete";s:4:"2303";s:14:"companysetting";s:4:"2400";}', 0, '2017-01-04 23:35:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipment`
--

CREATE TABLE IF NOT EXISTS `shipment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL,
  `trans_type` int(11) NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `packed_date` date NOT NULL,
  `delivery_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `shipment`
--

INSERT INTO `shipment` (`id`, `order_no`, `trans_type`, `comments`, `status`, `packed_date`, `delivery_date`, `created_at`, `updated_at`) VALUES
(1, 1, 301, '', 0, '2017-01-05', '0000-00-00', NULL, NULL),
(2, 3, 301, '', 1, '2017-01-05', '2017-01-05', NULL, NULL),
(3, 8, 301, '', 1, '2017-01-05', '2017-01-05', NULL, NULL),
(4, 14, 301, '', 1, '2017-01-06', '2017-01-06', NULL, NULL),
(5, 7, 301, '', 0, '2017-01-07', '0000-00-00', NULL, NULL),
(6, 19, 301, 'Auto shipment', 1, '2017-01-07', '2017-01-07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shipment_details`
--

CREATE TABLE IF NOT EXISTS `shipment_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shipment_id` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `stock_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_type_id` tinyint(4) NOT NULL,
  `unit_price` double NOT NULL,
  `quantity` double NOT NULL,
  `discount_percent` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `shipment_details`
--

INSERT INTO `shipment_details` (`id`, `shipment_id`, `order_no`, `stock_id`, `tax_type_id`, `unit_price`, `quantity`, `discount_percent`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'HP430', 2, 35000, 6, 5, NULL, NULL),
(2, 2, 3, 'HOODI', 2, 1000, 6, 2, NULL, NULL),
(3, 3, 8, 'OVEN', 2, 3500, 8, 0, NULL, NULL),
(4, 3, 8, 'LED', 3, 3200, 2, 0, NULL, NULL),
(5, 3, 8, 'TOSTER', 2, 2000, 0, 0, NULL, NULL),
(6, 4, 14, 'HOODI', 2, 1000, 1, 0, NULL, NULL),
(7, 4, 14, 'STRAIGHTNER', 2, 1400, 2, 0, NULL, NULL),
(8, 4, 14, 'LG', 3, 5000, 2, 0, NULL, NULL),
(9, 4, 14, 'SAMSUNG', 2, 16000, 1, 0, NULL, NULL),
(10, 5, 7, 'STRAIGHTNER', 2, 0, 2, 0, NULL, NULL),
(11, 5, 7, 'LED', 3, 0, 0, 0, NULL, NULL),
(12, 6, 19, 'HP430', 2, 35000, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_category`
--

CREATE TABLE IF NOT EXISTS `stock_category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dflt_units` int(11) NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `stock_category`
--

INSERT INTO `stock_category` (`category_id`, `description`, `dflt_units`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'Default Category', 1, 0, '2017-01-04 23:35:07', NULL),
(2, 'Mobile', 1, 0, '2017-01-05 00:02:35', NULL),
(3, 'Hardware ', 1, 0, '2017-01-05 00:02:46', '2017-01-05 00:10:06'),
(4, 'Home Appliance', 1, 0, '2017-01-05 00:09:20', NULL),
(6, 'Apparel ', 4, 0, '2017-01-05 00:09:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_master`
--

CREATE TABLE IF NOT EXISTS `stock_master` (
  `stock_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `tax_type_id` int(11) NOT NULL,
  `description` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `long_description` text COLLATE utf8_unicode_ci NOT NULL,
  `units` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `deleted_status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stock_master`
--

INSERT INTO `stock_master` (`stock_id`, `category_id`, `tax_type_id`, `description`, `long_description`, `units`, `inactive`, `deleted_status`, `created_at`, `updated_at`) VALUES
('AC-LG', 4, 2, 'LG AIRCONDITIONER', 'test', 'Each', 0, 0, NULL, NULL),
('ASUS', 2, 2, 'ASUS MOBILE', 'test', 'Each', 0, 0, NULL, '2017-01-06 23:47:46'),
('BUTTERFLY', 4, 2, 'BUTTERFLY FRIDGE', 'test', 'Each', 0, 0, NULL, NULL),
('HITTER', 4, 1, 'WATER HITTER ', '3 different colour available', 'Each', 0, 0, '2017-01-05 00:21:24', '2017-01-05 00:27:09'),
('HOODI', 6, 2, 'BLUE LONG HOODI', 'FEMALE HOODI , SIze- S,M,L', 'Pc', 0, 0, '2017-01-05 00:22:56', '2017-01-05 00:26:30'),
('HP430', 3, 2, 'HP LAPTOP 430', 'This is a hp laptop', 'Each', 0, 0, '2017-01-05 00:05:32', NULL),
('HTC', 2, 2, 'HTC MOBILE', 'test', 'Each', 0, 0, NULL, '2017-01-05 02:08:09'),
('IPHONE7', 2, 3, 'IPHONE 7', 'This is an iphone7', 'Each', 0, 0, '2017-01-04 23:59:35', '2017-01-05 02:08:24'),
('LED', 4, 3, 'SAMSUNG LED TV', '', 'Each', 0, 0, '2017-01-05 01:35:48', NULL),
('LG', 4, 3, 'LG REFRIGERATOR ', '', 'Each', 0, 0, '2017-01-05 01:36:29', NULL),
('LOGITECH', 3, 1, 'LOGITECH HEADPHONE', '', 'Each', 0, 0, '2017-01-05 01:41:50', NULL),
('MI', 2, 2, 'XWAMI PHONE', 'test', 'Each', 0, 0, NULL, '2017-01-05 02:09:23'),
('MYONE', 4, 2, 'MYONE TV', 'test', 'Each', 0, 0, NULL, NULL),
('NIPPON', 4, 2, 'NIPPON TV', 'test', 'Each', 0, 0, NULL, NULL),
('OPPO', 2, 2, 'OPPO F1', 'test', 'Each', 0, 0, NULL, '2017-01-05 02:08:56'),
('OVEN', 4, 2, 'MICROWAVE OVEN', 'Large size', 'Each', 0, 0, '2017-01-05 00:19:54', '2017-01-05 00:26:51'),
('SAMSUNG', 2, 2, 'SAMSUNG J5', 'This is a mobile phone', 'pc', 0, 0, NULL, NULL),
('SINGER', 4, 2, 'SINGER REFREGARETER', 'test', 'Each', 0, 0, NULL, NULL),
('SONY', 4, 2, 'SONY LED TV', 'test', 'Each', 0, 0, NULL, NULL),
('STRAIGHTNER', 3, 2, 'HAIR STRAIGHTNER', '', 'Each', 0, 0, '2017-01-05 01:35:12', NULL),
('SYMPHONE', 4, 2, 'SYMPHONE F8', 'test', 'Each', 0, 0, NULL, NULL),
('TOSTER', 4, 2, 'SONY TOSTER', '', 'Each', 0, 0, '2017-01-05 01:37:23', NULL),
('VISON', 4, 2, 'VISON REFREGARETER', 'test', 'Each', 0, 0, NULL, NULL),
('WALTON', 4, 2, 'WALTON LED TV', 'test', 'Each', 0, 0, NULL, NULL),
('WATERPOT', 4, 3, 'TUPPER WATER POT', '', 'Each', 0, 0, '2017-01-05 01:42:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stock_moves`
--

CREATE TABLE IF NOT EXISTS `stock_moves` (
  `trans_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stock_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `order_no` int(11) NOT NULL,
  `trans_type` smallint(6) NOT NULL DEFAULT '0',
  `loc_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `tran_date` date NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `order_reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_reference_id` int(11) NOT NULL,
  `transfer_id` int(11) DEFAULT NULL,
  `note` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `qty` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`trans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=72 ;

--
-- Dumping data for table `stock_moves`
--

INSERT INTO `stock_moves` (`trans_id`, `stock_id`, `order_no`, `trans_type`, `loc_code`, `tran_date`, `person_id`, `order_reference`, `reference`, `transaction_reference_id`, `transfer_id`, `note`, `qty`, `price`) VALUES
(1, 'HOODI', 0, 102, 'GL101', '2017-01-05', 1, '', 'store_in_1', 1, NULL, '', 1000, 800),
(2, 'HP430', 0, 102, 'GL101', '2017-01-05', 1, '', 'store_in_1', 1, NULL, '', 700, 25000),
(3, 'IPHONE7', 0, 102, 'GL101', '2017-01-05', 1, '', 'store_in_1', 1, NULL, '', 500, 40000),
(4, 'HITTER', 0, 102, 'GL101', '2017-01-05', 1, '', 'store_in_1', 1, NULL, '', 500, 1000),
(5, 'OVEN', 0, 102, 'GL101', '2017-01-05', 1, '', 'store_in_1', 1, NULL, '', 500, 3000),
(6, 'OVEN', 0, 401, 'BD102', '2017-01-05', 1, '', 'moved_from_GL101', 1, 1, '', 100, 0),
(7, 'OVEN', 0, 402, 'GL101', '2017-01-05', 1, '', 'moved_in_BD102', 1, NULL, '', -100, 0),
(8, 'HITTER', 0, 401, 'BD102', '2017-01-05', 1, '', 'moved_from_GL101', 1, 1, '', 100, 0),
(9, 'HITTER', 0, 402, 'GL101', '2017-01-05', 1, '', 'moved_in_BD102', 1, NULL, '', -100, 0),
(10, 'HP430', 1, 202, 'GL101', '2017-01-05', 1, 'SO-0001', 'store_out_2', 2, NULL, '', -10, 35000),
(11, 'HOODI', 3, 202, 'GL101', '2017-01-05', 1, 'SO-0002', 'store_out_4', 4, NULL, '', -6, 1000),
(12, 'OVEN', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_2', 2, NULL, '', 100, 3000),
(13, 'HITTER', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_3', 3, NULL, '', 100, 1000),
(14, 'HOODI', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_4', 4, NULL, '', 60, 800),
(15, 'HOODI', 0, 401, 'BD102', '2017-01-05', 1, '', 'moved_from_PL', 2, 2, '', 10, 0),
(16, 'HOODI', 0, 402, 'PL', '2017-01-05', 1, '', 'moved_in_BD102', 2, NULL, '', -10, 0),
(17, 'HITTER', 0, 401, 'BD102', '2017-01-05', 1, '', 'moved_from_PL', 2, 2, '', 10, 0),
(18, 'HITTER', 0, 402, 'PL', '2017-01-05', 1, '', 'moved_in_BD102', 2, NULL, '', -10, 0),
(19, 'LED', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_5', 5, NULL, '', 100, 3000),
(20, 'TOSTER', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_5', 5, NULL, '', 100, 1000),
(21, 'STRAIGHTNER', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_6', 6, NULL, '', 100, 0),
(22, 'SAMSUNG', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_6', 6, NULL, '', 100, 15000),
(23, 'LED', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_6', 6, NULL, '', 100, 0),
(24, 'LG', 0, 102, 'GL101', '2017-01-05', 1, '', 'store_in_7', 7, NULL, '', 300, 4200),
(25, 'LOGITECH', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_8', 8, NULL, '', 1000, 500),
(26, 'WATERPOT', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_8', 8, NULL, '', 1000, 220),
(27, 'LOGITECH', 5, 202, 'PL', '2017-01-05', 1, 'SO-0003', 'store_out_6', 6, NULL, '', -15, 700),
(28, 'HITTER', 5, 202, 'PL', '2017-01-05', 1, 'SO-0003', 'store_out_6', 6, NULL, '', -10, 1500),
(29, 'WATERPOT', 5, 202, 'PL', '2017-01-05', 1, 'SO-0003', 'store_out_6', 6, NULL, '', -20, 300),
(30, 'LED', 8, 202, 'PL', '2017-01-05', 1, 'SO-0005', 'store_out_9', 9, NULL, '', -10, 3200),
(31, 'TOSTER', 8, 202, 'PL', '2017-01-05', 1, 'SO-0005', 'store_out_9', 9, NULL, '', -14, 2000),
(32, 'OVEN', 8, 202, 'PL', '2017-01-05', 1, 'SO-0005', 'store_out_9', 9, NULL, '', -8, 3500),
(33, 'BUTTERFLY', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_9', 9, NULL, '', 100, 2800),
(34, 'HTC', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_9', 9, NULL, '', 100, 2800),
(35, 'AC-LG', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_9', 9, NULL, '', 100, 3000),
(36, 'SYMPHONE', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_9', 9, NULL, '', 100, 5000),
(37, 'MI', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_9', 9, NULL, '', 100, 2300),
(38, 'OPPO', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_9', 9, NULL, '', 100, 2500),
(39, 'ASUS', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_9', 9, NULL, '', 100, 3000),
(40, 'VISON', 0, 102, 'PL', '2017-01-05', 1, '', 'store_in_9', 9, NULL, '', 200, 3000),
(41, 'NIPPON', 0, 102, 'GL101', '2017-01-05', 1, '', 'store_in_10', 10, NULL, '', 100, 5000),
(42, 'MYONE', 0, 102, 'GL101', '2017-01-05', 1, '', 'store_in_10', 10, NULL, '', 100, 2800),
(43, 'SINGER', 0, 102, 'GL101', '2017-01-05', 1, '', 'store_in_10', 10, NULL, '', 100, 5000),
(44, 'SONY', 0, 102, 'GL101', '2017-01-05', 1, '', 'store_in_10', 10, NULL, '', 100, 3000),
(45, 'OVEN', 10, 202, 'PL', '2017-01-05', 1, 'SO-0006', 'store_out_12', 12, NULL, '', -10, 3500),
(46, 'HITTER', 10, 202, 'PL', '2017-01-05', 1, 'SO-0006', 'store_out_12', 12, NULL, '', -10, 1500),
(47, 'STRAIGHTNER', 7, 202, 'PL', '2017-01-05', 1, 'SO-0004', 'store_out_13', 13, NULL, '', -2, 0),
(48, 'LED', 7, 202, 'PL', '2017-01-05', 1, 'SO-0004', 'store_out_13', 13, NULL, '', -1, 0),
(49, 'HOODI', 14, 202, 'PL', '2017-01-06', 1, 'SO-0007', 'store_out_15', 15, NULL, '', -2, 1000),
(50, 'STRAIGHTNER', 14, 202, 'PL', '2017-01-06', 1, 'SO-0007', 'store_out_15', 15, NULL, '', -3, 1400),
(51, 'LG', 14, 202, 'PL', '2017-01-06', 1, 'SO-0007', 'store_out_15', 15, NULL, '', -5, 5000),
(52, 'SAMSUNG', 14, 202, 'PL', '2017-01-06', 1, 'SO-0007', 'store_out_15', 15, NULL, '', -2, 16000),
(53, 'LOGITECH', 14, 202, 'PL', '2017-01-06', 1, 'SO-0007', 'store_out_15', 15, NULL, '', -2, 700),
(54, 'WALTON', 14, 202, 'PL', '2017-01-06', 1, 'SO-0007', 'store_out_16', 16, NULL, '', -2, 5200),
(55, 'SINGER', 14, 202, 'PL', '2017-01-06', 1, 'SO-0007', 'store_out_16', 16, NULL, '', -2, 5200),
(56, 'VISON', 14, 202, 'PL', '2017-01-06', 1, 'SO-0007', 'store_out_16', 16, NULL, '', -2, 3200),
(59, 'STRAIGHTNER', 7, 202, 'PL', '2017-01-07', 1, 'SO-0004', 'store_out_17', 17, NULL, '', 0, 0),
(60, 'LED', 7, 202, 'PL', '2017-01-07', 1, 'SO-0004', 'store_out_17', 17, NULL, '', -1, 0),
(61, 'HP430', 14, 202, 'PL', '2017-01-07', 1, 'SO-0007', 'store_out_18', 18, NULL, '', -0, 35000),
(62, 'HITTER', 14, 202, 'PL', '2017-01-07', 1, 'SO-0007', 'store_out_18', 18, NULL, '', -0, 1500),
(63, 'HOODI', 14, 202, 'PL', '2017-01-07', 1, 'SO-0007', 'store_out_18', 18, NULL, '', -4, 1000),
(64, 'STRAIGHTNER', 14, 202, 'PL', '2017-01-07', 1, 'SO-0007', 'store_out_18', 18, NULL, '', -12, 1400),
(65, 'SAMSUNG', 14, 202, 'PL', '2017-01-07', 1, 'SO-0007', 'store_out_18', 18, NULL, '', -4, 16000),
(66, 'LOGITECH', 14, 202, 'PL', '2017-01-07', 1, 'SO-0007', 'store_out_18', 18, NULL, '', -5, 700),
(67, 'WATERPOT', 14, 202, 'PL', '2017-01-07', 1, 'SO-0007', 'store_out_18', 18, NULL, '', -9, 300),
(68, 'WALTON', 14, 202, 'PL', '2017-01-07', 1, 'SO-0007', 'store_out_18', 18, NULL, '', -9, 5200),
(69, 'SINGER', 14, 202, 'PL', '2017-01-07', 1, 'SO-0007', 'store_out_18', 18, NULL, '', -11, 5200),
(70, 'VISON', 14, 202, 'PL', '2017-01-07', 1, 'SO-0007', 'store_out_18', 18, NULL, '', -13, 3200),
(71, 'HP430', 19, 202, 'PL', '2017-01-07', 1, 'SO-0008', 'store_out_20', 20, NULL, '', -1, 35000);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

CREATE TABLE IF NOT EXISTS `stock_transfer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `source` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `destination` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `note` text COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `stock_transfer`
--

INSERT INTO `stock_transfer` (`id`, `source`, `destination`, `note`, `qty`, `transfer_date`) VALUES
(1, 'GL101', 'BD102', '', 200, '2017-01-05'),
(2, 'PL', 'BD102', '', 20, '2017-01-05');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `supplier_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `supp_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supp_name`, `email`, `address`, `contact`, `city`, `state`, `zipcode`, `country`, `inactive`, `created_at`, `updated_at`) VALUES
(1, 'Shahin Alam', 'shahinict06@gmail.com', '249/01(East kazipara)', '01722113736', 'Dhaka', 'Dhaka', '1216', 'Bangladesh', 0, '2017-01-05 00:08:12', NULL),
(2, 'Shawon Khan', 'khan@gmail.com', '55/09(Mirpur)', '01722113796', 'Kustia', 'Kustia', '4550', 'Bangladesh', 0, '2017-01-05 00:09:40', NULL),
(3, 'Alfred Gleichner', 'lonnie.kirlin@example.net', '1401 Catherine Villages Apt. 334', '+17063292730', 'Alexandriaborough', 'Rhode Island', '57756-1433', 'Sweden', 0, '2017-01-05 00:33:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `real_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `password`, `real_name`, `role_id`, `phone`, `email`, `picture`, `inactive`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '', '$2y$10$37L49cYzicos3942koQENOw1Gg2K9sgWwA5wf3DLpVZIo5j9xLjOK', 'Admin', 1, '', 'admin@admin.com', '', 0, 'CUqRmUoXx7MqwcgXV0R8TxtlMbjKCjgNV0xDOJjyUgkDyhBHhCBFWdK0rCtX', '2017-01-04 23:35:25', '2017-01-07 05:37:43');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
