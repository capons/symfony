-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: 192.168.0.253:3306
-- Generation Time: Nov 02, 2016 at 11:52 AM
-- Server version: 5.6.29
-- PHP Version: 5.5.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `symfony`
--

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `code` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=215 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `code`) VALUES
(1, 'Albania', 'ALB'),
(2, 'Algeria', 'DZA'),
(3, 'American Samoa', 'ASM'),
(4, 'Andorra', 'AND'),
(5, 'Angola', 'AGO'),
(6, 'Anguilla', 'AIA'),
(7, 'Antigua and Barbuda', 'ATG'),
(8, 'Argentina', 'ARG'),
(9, 'Armenia', 'ARM'),
(10, 'Aruba', 'ABW'),
(11, 'Australia', 'AUS'),
(12, 'Austria', 'AUT'),
(13, 'Azerbaijan', 'AZE'),
(14, 'Bahamas', 'BHS'),
(15, 'Bahrain', 'BHR'),
(16, 'Bangladesh', 'BGD'),
(17, 'Barbados', 'BRB'),
(18, 'Belarus', 'BLR'),
(19, 'Belgium', 'BEL'),
(20, 'Belize', 'BLZ'),
(21, 'Benin', 'BEN'),
(22, 'Bermuda', 'BMU'),
(23, 'Bhutan', 'BTN'),
(24, 'Bolivia', 'BOL'),
(25, 'Bosnia and Herzegovina', 'BIH'),
(26, 'Botswana', 'BWA'),
(27, 'Brazil', 'BRA'),
(28, 'Brunei Darussalam', 'BRN'),
(29, 'Bulgaria', 'BGR'),
(30, 'Burkina Faso', 'BFA'),
(31, 'Burundi', 'BDI'),
(32, 'Cambodia', 'KHM'),
(33, 'Cameroon', 'CMR'),
(34, 'Canada', 'CAN'),
(35, 'Cape Verde', 'CPV'),
(36, 'Cayman Islands', 'CYM'),
(37, 'Central African Republic', 'CAF'),
(38, 'Chad', 'TCD'),
(39, 'Chile', 'CHL'),
(40, 'China', 'CHN'),
(41, 'Colombia', 'COL'),
(42, 'Comoros', 'COM'),
(43, 'Congo', 'COG'),
(44, 'Cook Islands', 'COK'),
(45, 'Costa Rica', 'CRI'),
(46, 'Cote D''Ivoire', 'CIV'),
(47, 'Croatia', 'HRV'),
(48, 'Cuba', 'CUB'),
(49, 'Cyprus', 'CYP'),
(50, 'Czech Republic', 'CZE'),
(51, 'Denmark', 'DNK'),
(52, 'Djibouti', 'DJI'),
(53, 'Dominica', 'DMA'),
(54, 'Dominican Republic', 'DOM'),
(55, 'Ecuador', 'ECU'),
(56, 'Egypt', 'EGY'),
(57, 'El Salvador', 'SLV'),
(58, 'Equatorial Guinea', 'GNQ'),
(59, 'Eritrea', 'ERI'),
(60, 'Estonia', 'EST'),
(61, 'Ethiopia', 'ETH'),
(62, 'Falkland Islands (Malvinas)', 'FLK'),
(63, 'Faroe Islands', 'FRO'),
(64, 'Fiji', 'FJI'),
(65, 'Finland', 'FIN'),
(66, 'France', 'FRA'),
(67, 'French Guiana', 'GUF'),
(68, 'French Polynesia', 'PYF'),
(69, 'Gabon', 'GAB'),
(70, 'Gambia', 'GMB'),
(71, 'Georgia', 'GEO'),
(72, 'Germany', 'DEU'),
(73, 'Ghana', 'GHA'),
(74, 'Gibraltar', 'GIB'),
(75, 'Greece', 'GRC'),
(76, 'Greenland', 'GRL'),
(77, 'Grenada', 'GRD'),
(78, 'Guadeloupe', 'GLP'),
(79, 'Guam', 'GUM'),
(80, 'Guatemala', 'GTM'),
(81, 'Guinea', 'GIN'),
(82, 'Guinea-Bissau', 'GNB'),
(83, 'Guyana', 'GUY'),
(84, 'Haiti', 'HTI'),
(85, 'Holy See (Vatican City State)', 'VAT'),
(86, 'Honduras', 'HND'),
(87, 'Hong Kong', 'HKG'),
(88, 'Hungary', 'HUN'),
(89, 'Iceland', 'ISL'),
(90, 'India', 'IND'),
(91, 'Indonesia', 'IDN'),
(92, 'Iraq', 'IRQ'),
(93, 'Ireland', 'IRL'),
(94, 'Israel', 'ISR'),
(95, 'Italy', 'ITA'),
(96, 'Jamaica', 'JAM'),
(97, 'Japan', 'JPN'),
(98, 'Jordan', 'JOR'),
(99, 'Kazakhstan', 'KAZ'),
(100, 'Kenya', 'KEN'),
(101, 'Kiribati', 'KIR'),
(102, 'Kuwait', 'KWT'),
(103, 'Kyrgyzstan', 'KGZ'),
(104, 'Lao People''s Democratic Republic', 'LAO'),
(105, 'Latvia', 'LVA'),
(106, 'Lebanon', 'LBN'),
(107, 'Lesotho', 'LSO'),
(108, 'Liberia', 'LBR'),
(109, 'Libyan Arab Jamahiriya', 'LBY'),
(110, 'Liechtenstein', 'LIE'),
(111, 'Lithuania', 'LTU'),
(112, 'Luxembourg', 'LUX'),
(113, 'Macao', 'MAC'),
(114, 'Madagascar', 'MDG'),
(115, 'Malawi', 'MWI'),
(116, 'Malaysia', 'MYS'),
(117, 'Maldives', 'MDV'),
(118, 'Mali', 'MLI'),
(119, 'Malta', 'MLT'),
(120, 'Marshall Islands', 'MHL'),
(121, 'Martinique', 'MTQ'),
(122, 'Mauritania', 'MRT'),
(123, 'Mauritius', 'MUS'),
(124, 'Mexico', 'MEX'),
(125, 'Monaco', 'MCO'),
(126, 'Mongolia', 'MNG'),
(127, 'Montserrat', 'MSR'),
(128, 'Morocco', 'MAR'),
(129, 'Mozambique', 'MOZ'),
(130, 'Myanmar', 'MMR'),
(131, 'Namibia', 'NAM'),
(132, 'Nauru', 'NRU'),
(133, 'Nepal', 'NPL'),
(134, 'Netherlands', 'NLD'),
(135, 'Netherlands Antilles', 'ANT'),
(136, 'New Caledonia', 'NCL'),
(137, 'New Zealand', 'NZL'),
(138, 'Nicaragua', 'NIC'),
(139, 'Niger', 'NER'),
(140, 'Nigeria', 'NGA'),
(141, 'Niue', 'NIU'),
(142, 'Norfolk Island', 'NFK'),
(143, 'Northern Mariana Islands', 'MNP'),
(144, 'Norway', 'NOR'),
(145, 'Oman', 'OMN'),
(146, 'Pakistan', 'PAK'),
(147, 'Palau', 'PLW'),
(148, 'Panama', 'PAN'),
(149, 'Papua New Guinea', 'PNG'),
(150, 'Paraguay', 'PRY'),
(151, 'Peru', 'PER'),
(152, 'Philippines', 'PHL'),
(153, 'Pitcairn', 'PCN'),
(154, 'Poland', 'POL'),
(155, 'Portugal', 'PRT'),
(156, 'Puerto Rico', 'PRI'),
(157, 'Qatar', 'QAT'),
(158, 'Reunion', 'REU'),
(159, 'Romania', 'ROM'),
(160, 'Russian Federation', 'RUS'),
(161, 'Rwanda', 'RWA'),
(162, 'Saint Helena', 'SHN'),
(163, 'Saint Kitts and Nevis', 'KNA'),
(164, 'Saint Lucia', 'LCA'),
(165, 'Saint Pierre and Miquelon', 'SPM'),
(166, 'Saint Vincent and the Grenadines', 'VCT'),
(167, 'Samoa', 'WSM'),
(168, 'San Marino', 'SMR'),
(169, 'Sao Tome and Principe', 'STP'),
(170, 'Saudi Arabia', 'SAU'),
(171, 'Senegal', 'SEN'),
(172, 'Seychelles', 'SYC'),
(173, 'Sierra Leone', 'SLE'),
(174, 'Singapore', 'SGP'),
(175, 'Slovakia', 'SVK'),
(176, 'Slovenia', 'SVN'),
(177, 'Solomon Islands', 'SLB'),
(178, 'Somalia', 'SOM'),
(179, 'South Africa', 'ZAF'),
(180, 'Spain', 'ESP'),
(181, 'Sri Lanka', 'LKA'),
(182, 'Sudan', 'SDN'),
(183, 'Suriname', 'SUR'),
(184, 'Svalbard and Jan Mayen', 'SJM'),
(185, 'Swaziland', 'SWZ'),
(186, 'Sweden', 'SWE'),
(187, 'Switzerland', 'CHE'),
(188, 'Syrian Arab Republic', 'SYR'),
(189, 'Tajikistan', 'TJK'),
(190, 'Thailand', 'THA'),
(191, 'Togo', 'TGO'),
(192, 'Tokelau', 'TKL'),
(193, 'Tonga', 'TON'),
(194, 'Trinidad and Tobago', 'TTO'),
(195, 'Tunisia', 'TUN'),
(196, 'Turkey', 'TUR'),
(197, 'Turkmenistan', 'TKM'),
(198, 'Turks and Caicos Islands', 'TCA'),
(199, 'Tuvalu', 'TUV'),
(200, 'Uganda', 'UGA'),
(201, 'Ukraine', 'UKR'),
(202, 'United Arab Emirates', 'ARE'),
(203, 'United Kingdom', 'GBR'),
(204, 'United States', 'USA'),
(205, 'Uruguay', 'URY'),
(206, 'Uzbekistan', 'UZB'),
(207, 'Vanuatu', 'VUT'),
(208, 'Venezuela', 'VEN'),
(209, 'Viet Nam', 'VNM'),
(210, 'Wallis and Futuna', 'WLF'),
(211, 'Western Sahara', 'ESH'),
(212, 'Yemen', 'YEM'),
(213, 'Zambia', 'ZMB'),
(214, 'Zimbabwe', 'ZWE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=215;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
