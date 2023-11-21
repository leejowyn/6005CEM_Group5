-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 20, 2023 at 03:47 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `in_haus`
--

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `consultation_id` int(10) UNSIGNED NOT NULL,
  `created_datetime` datetime NOT NULL,
  `last_modified_datetime` datetime DEFAULT NULL,
  `consultation_status` varchar(50) NOT NULL,
  `consultation_date` date NOT NULL,
  `consultation_time` time NOT NULL,
  `consultation_type` varchar(30) NOT NULL,
  `preferred_style` varchar(300) NOT NULL,
  `design_range` varchar(30) NOT NULL,
  `consultation_remark` varchar(300) NOT NULL,
  `cust_id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`consultation_id`, `created_datetime`, `last_modified_datetime`, `consultation_status`, `consultation_date`, `consultation_time`, `consultation_type`, `preferred_style`, `design_range`, `consultation_remark`, `cust_id`, `admin_id`) VALUES
(1, '2022-10-23 12:18:32', '2023-11-16 21:49:40', 'Project Confirmed', '2022-10-29', '18:18:33', 'In Home', 'Modern Minimalist', 'Condo', 'Call be before when you on the way', 5, 3),
(2, '2022-10-23 19:30:54', '2022-10-23 19:42:54', 'Project Confirmed', '2022-10-29', '19:42:00', 'In Home', 'Industrial Style', 'Condo', 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quas minima placeat id omnis doloremque earum illum possimus tenetur dolores vel recusandae distinctio iure, facere odit quaerat doloribus laborum fuga explicabo?', 5, 3),
(3, '2022-10-24 19:30:54', '2022-11-19 13:12:25', 'Project Confirmed', '2022-10-30', '08:20:54', 'Virtual Meeting', 'Traditional / Classic Style,Art Deco Style,Eclectic Style', 'design range updated', 'I prefer Google Meet', 5, 2),
(4, '2022-10-24 19:30:54', '2022-10-27 17:31:05', 'Project Confirmed', '2022-10-30', '20:18:54', 'Virtual Meeting', 'Art Deco Style,Eclectic Style', 'design range updated', 'Please use Google Meet, thx', 6, 3),
(5, '2022-10-30 19:30:54', '2023-11-20 11:24:37', 'Project Confirmed', '2022-10-30', '08:18:54', 'Virtual Meeting', 'Industrial Style,Eclectic Style', 'design range updated', '', 6, 2),
(6, '2023-11-16 00:00:00', '2023-11-20 11:24:26', 'Project Confirmed', '2023-11-25', '16:00:00', 'Phone Call', 'Eclectic Style', 'bathroom', 'nooooo', 16, 2),
(7, '2023-11-20 00:00:00', '2023-11-20 11:19:09', 'Project Confirmed', '2023-11-21', '11:00:00', 'In Store', ' Modern Minimalist,Industrial Style', 'test', 'additional', 19, 16),
(12, '2023-11-20 00:00:00', '2023-11-20 11:21:07', 'Project Confirmed', '2023-11-23', '11:00:00', 'In Store', ' Traditional/Classic Style', 'dgfdg', 'dfgdf', 19, 16),
(13, '2023-11-20 00:00:00', NULL, 'Pending', '2023-11-30', '11:00:00', 'In Store', ' English Country Style', 'I would like to visit the shop', 'To look for interior design', 19, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(10) UNSIGNED NOT NULL,
  `feedback_date` date NOT NULL,
  `project_id` int(10) UNSIGNED NOT NULL,
  `cust_id` int(10) UNSIGNED NOT NULL,
  `expectation` text NOT NULL,
  `workAgn` text NOT NULL,
  `compare` text NOT NULL,
  `communication` text NOT NULL,
  `explanation` text NOT NULL,
  `goal` text NOT NULL,
  `comment` text NOT NULL,
  `comment2` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `feedback_date`, `project_id`, `cust_id`, `expectation`, `workAgn`, `compare`, `communication`, `explanation`, `goal`, `comment`, `comment2`) VALUES
(1, '2022-10-30', 2, 5, 'expectation1', 'workAgn1', 'compare1', 'communication1', 'explanation1', 'goal1', 'comment bla', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quaerat a repellendus, necessitatibus aut ipsa vero dolores laboriosam eos debitis ipsam. Magni, nobis. Illum sed molestias minima laborum cum quaerat ipsam!'),
(2, '2022-11-01', 1, 6, 'expectation2', 'workAgn2', 'compare2', 'communication2', 'explanation2', 'goal2', 'comment bla', 'comment blabla'),
(3, '2017-11-22', 1, 6, 'N/A - Dont know what to expect', 'Slightly Likel', 'Inferior', 'Disagree', 'Neutral', 'Agree', 'good service', 'In Haus has a great team, friendly relation, they designed the ideal house for my needs. It is a fantastic project, we are very happy! They were originally recommended to us by a friend and now we recommend them.'),
(4, '2017-11-22', 1, 6, 'Did Not Meet Expectations', 'Slightly Likel', 'Equal', 'Neutral', 'Agree', 'Strongly Agree', '123', 'The entire In Haus interior design team was truly amazing to work with. The design team fully captured our vision and need for functionality and gave us our dream home! They also made the process fun and exciting along the way and we trusted them completely. They truly are the best interior designers in Miami and would recommend them 100000%!!'),
(5, '2017-11-22', 1, 6, 'Did Not Meet Expectations', 'Slightly Likel', 'Equal', 'Neutral', 'Agree', 'Strongly Agree', '123', 'From the ﬁrst moment that we walked into the oﬃce at In Haus, the staff was AMAZING! We were greeted by a cool, hip, young interior design team that took our request to make “NOT your grandpa’s condo” and turned it into our rock and roll dream! Although we were '),
(6, '2019-11-22', 2, 2, 'Met Expectations', 'Moderately Likely', 'Slightly Inferior', 'Disagree', 'Strongly Disagree', 'Agree', 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `log_activity`
--

CREATE TABLE `log_activity` (
  `log_activity_id` int(11) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `consultation_id` int(11) UNSIGNED DEFAULT NULL,
  `datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_activity`
--

INSERT INTO `log_activity` (`log_activity_id`, `event_type`, `user_id`, `consultation_id`, `datetime`) VALUES
(9, 'login', 19, NULL, '2023-11-20 20:33:01'),
(10, 'login', 19, NULL, '2023-11-20 21:04:49'),
(12, 'admin_login', 18, NULL, '2023-11-20 21:30:49'),
(13, 'consultation', 19, 13, '2023-11-20 21:37:30');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) UNSIGNED NOT NULL,
  `outgoing_msg_id` int(255) UNSIGNED NOT NULL,
  `msg` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`) VALUES
(6, 4, 5, 'hi'),
(7, 5, 4, 'Hi, how may I help you?'),
(8, 5, 4, '666');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE `portfolio` (
  `portfolio_id` int(10) UNSIGNED NOT NULL,
  `portfolio_category` varchar(50) NOT NULL,
  `portfolio_style` varchar(50) NOT NULL,
  `portfolio_description` varchar(500) NOT NULL,
  `portfolio_thumbnail` varchar(260) NOT NULL,
  `portfolio_panorama` varchar(260) NOT NULL,
  `portfolio_images` text NOT NULL,
  `portfolio_views` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolio`
--

INSERT INTO `portfolio` (`portfolio_id`, `portfolio_category`, `portfolio_style`, `portfolio_description`, `portfolio_thumbnail`, `portfolio_panorama`, `portfolio_images`, `portfolio_views`) VALUES
(1, 'Commercial', 'Industrial Style', '888', 'sample1.jpg', '83106866_2767832416648005_2945533269321449472_o.jpg', ',sample4.jpg,sample3.jpg,sample2.jpg,sample1.jpg', 1217),
(2, 'Commercial', 'Modern Minimalist', '666', 'sample3.jpg', '', 'sample1.jpg,sample4.jpg,sample3.jpg,sample2.jpg,sample1.jpg', 124),
(3, 'Commercial', 'Rustic Style', 'testing updated', 'sample2.jpg', '83106866_2767832416648005_2945533269321449472_o.jpg', 'sample1.jpg,83106866_2767832416648005_2945533269321449472_o.jpg', 521),
(4, 'Residential', 'Coastal Style', '666', 'sample4.jpg', '', '83106866_2767832416648005_2945533269321449472_o.jpg', 309),
(5, 'Residential', 'Modern Minimalist', '123', 'sample5.jpg', 'sample3.jpg', 'sample4.jpg,sample3.jpg,sample1.jpg', 0),
(6, 'Residential', 'Modern Minimalist', '123', 'sample6.jpg', 'sample2.jpg', 'sample4.jpg,sample3.jpg', 0),
(7, 'Residential', 'Modern Minimalist', '123', 'sample7.jpg', 'sample2.jpg', 'sample4.jpg,sample3.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(10) UNSIGNED NOT NULL,
  `created_datetime` datetime NOT NULL,
  `last_modified_datetime` datetime NOT NULL,
  `project_name` varchar(50) NOT NULL,
  `project_status` varchar(50) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `payment_datetime` varchar(100) NOT NULL,
  `project_fee` double NOT NULL,
  `project_remark` varchar(500) NOT NULL,
  `project_details` varchar(1000) NOT NULL,
  `project_contract` varchar(260) NOT NULL,
  `cust_id` int(10) UNSIGNED NOT NULL,
  `consultation_id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `created_datetime`, `last_modified_datetime`, `project_name`, `project_status`, `payment_status`, `payment_datetime`, `project_fee`, `project_remark`, `project_details`, `project_contract`, `cust_id`, `consultation_id`, `admin_id`) VALUES
(1, '2021-10-23 15:43:35', '2022-10-23 13:48:19', 'Urban Suites', 'Cancelled', '3rd Payment Done', '{\"1\":\"2022-10-30 00:18:11\",\"2\":\"2022-10-30 00:18:30\",\"3\":\"2022-10-30 01:16:28\"}', 20000, 'project 1 remarkkkkkk', 'project 1 detailsssss', 'sample.pdf', 5, 2, 3),
(2, '2021-10-24 13:48:19', '2022-11-19 13:17:53', 'test name', 'Completed', '3rd Payment Done', '{\"1\":\"2022-10-23 19:50:12\",\"2\":\"2022-10-28 17:12:16\",\"3\":\"2022-11-19 13:17:53\"}', 888, 'test remark', 'test details', 'sample.pdf', 5, 2, 2),
(16, '2022-10-26 17:00:18', '2022-10-27 17:53:34', 'Surin Modern Minimalist', 'Completed', 'Waiting for 3rd Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"2022-11-02 00:57:07\"}', 62345, 'remark 16', 'details 16', 'sample.pdf', 5, 3, 2),
(17, '2022-11-01 00:25:23', '2022-11-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 20000, '', '', '', 6, 4, 3),
(18, '2022-11-01 14:00:01', '2023-11-17 01:18:06', '', 'Completed', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 123, '', '', 'sample.pdf', 6, 1, 3),
(19, '2022-01-01 00:25:23', '2022-01-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 20000, '', '', '', 6, 4, 3),
(20, '2022-02-01 00:25:23', '2022-02-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 25000, '', '', '', 6, 4, 3),
(21, '2022-03-01 00:25:23', '2022-03-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 20000, '', '', '', 6, 4, 3),
(22, '2022-03-01 00:25:23', '2022-03-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 20000, '', '', '', 6, 4, 3),
(23, '2022-01-01 00:25:23', '2022-01-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 20000, '', '', '', 6, 4, 3),
(24, '2022-04-01 00:25:23', '2022-04-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 45000, '', '', '', 6, 4, 3),
(25, '2022-05-01 00:25:23', '2022-05-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 30000, '', '', '', 6, 4, 3),
(26, '2022-06-01 00:25:23', '2022-06-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 35000, '', '', '', 6, 4, 3),
(27, '2022-07-01 00:25:23', '2022-07-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 30000, '', '', '', 6, 4, 3),
(28, '2022-08-01 00:25:23', '2022-08-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 50000, '', '', '', 6, 4, 3),
(29, '2022-09-01 00:25:23', '2022-09-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 35000, '', '', '', 6, 4, 3),
(30, '2021-01-01 00:25:23', '2021-01-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 20000, '', '', '', 6, 4, 3),
(31, '2021-02-01 00:25:23', '2021-02-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 25000, '', '', '', 6, 4, 3),
(32, '2021-03-01 00:25:23', '2021-03-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 35000, '', '', '', 6, 4, 3),
(33, '2021-04-01 00:25:23', '2021-04-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 30000, '', '', '', 6, 4, 3),
(34, '2021-05-01 00:25:23', '2021-05-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Completed', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 20000, '', '', '', 6, 4, 3),
(35, '2021-06-01 00:25:23', '2021-06-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Completed', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 20000, '', '', '', 6, 4, 3),
(36, '2021-07-01 00:25:23', '2021-07-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Completed', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 25000, '', '', '', 6, 4, 3),
(37, '2021-08-01 00:25:23', '2021-08-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Completed', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 35000, '', '', '', 6, 4, 3),
(38, '2021-09-01 00:25:23', '2021-09-16 00:25:23', 'Central Park', 'Completed', 'Completed', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 35000, '', '', '', 6, 4, 3),
(39, '2021-10-01 00:25:23', '2021-10-16 00:25:23', '', 'Waiting for Staff to Upload Contract', 'Completed', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 35000, '', '', '', 6, 4, 3),
(40, '2021-11-01 00:25:23', '2021-11-16 00:25:23', 'Surin Condo', 'Cancelled', 'Completed', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 35000, '', '', '', 6, 4, 3),
(41, '2021-12-01 00:25:23', '2021-12-16 00:25:23', 'Urban Suites', 'In Progress - Designing', 'Completed', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 35000, '', '', '', 6, 4, 3),
(42, '2022-11-19 13:12:25', '2022-11-19 13:12:25', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 0, '', '', '', 5, 3, 2),
(45, '2023-11-20 11:24:26', '2023-11-20 11:24:26', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 0, '', '', '', 16, 6, 2),
(46, '2023-11-20 11:24:31', '2023-11-20 11:24:31', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 0, '', '', '', 6, 5, 2),
(47, '2023-11-20 11:24:37', '2023-11-20 11:24:37', '', 'Waiting for Staff to Upload Contract', 'Waiting for 1st Payment', '{\"1\":\"\",\"2\":\"\",\"3\":\"\"}', 0, '', '', '', 6, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `settings_id` int(10) UNSIGNED NOT NULL,
  `settings_name` varchar(50) NOT NULL,
  `settings_value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`settings_id`, `settings_name`, `settings_value`) VALUES
(1, 'email', 'inhaus@gmail.com'),
(2, 'contact_no', '04-1234567'),
(3, 'address', '17, Jalan Aman, 11600 Georgetown, Pulau Pinang.'),
(4, 'first_payment', '22'),
(5, 'second_payment', '33'),
(6, 'third_payment', '44');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `access_level` varchar(50) NOT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `password`, `phone_no`, `access_level`, `status`) VALUES
(2, 'Joey Cheng', 'chengxinye@gmail.com', '$2y$10$QCljfGxLgSN4WRRTxWe2tu8Nzyf/kwuD/ru6P0sLbmGhf3ExWSHVO', NULL, 'Project Leader', 'Active now'),
(3, 'Mickey Mouse', 'mickeymouse@gmail.com', '$2y$10$O0OhespCFm0iTqJxthvZG.H9aHsfPTgUpXitwTvPmcTwG8gkuabuW', NULL, 'Project Leader', NULL),
(4, 'Minnie Mouse', 'minniemouse@gmail.com', '$2y$10$O0OhespCFm0iTqJxthvZG.H9aHsfPTgUpXitwTvPmcTwG8gkuabuW', NULL, 'Customer Service', 'Active now'),
(5, 'Ah Beng', 'tansinyi12@gmail.com', '$2y$10$oNfWVoVKBuXB5DenjuA3IOO0pJeuywBFpUgXNtE5tk/HuwdeBz8re', '0161234567', 'Normal User', 'Offline now'),
(6, 'Mei Ling', 'meiling@gmail.com', '$2y$10$oNfWVoVKBuXB5DenjuA3IOO0pJeuywBFpUgXNtE5tk/HuwdeBz8re', '0161234567', 'Normal User', 'Active now'),
(16, 'TeohS4', 'lee@supermail.com', 'Thsfhdgh', '1', 'Project Leader', 'Offline now'),
(18, 'Teoh', 'weijieteoh26@gmail.com', '$2y$10$P.XP/xHTSKN9H.sycfcn4.TVQCXDjLhubH0H.bkRMxY8XKGVZ/j52', '0123435465', 'Project Manager', 'Active now'),
(19, 'Weijie', 'teohs4@hotmail.com', '$2y$10$YVkkmmKiLDzEmN6.0mzRRefAseaPBXtbFVTmnSjtMkqaxHKdSdALC', '8046547', 'Normal User', 'Offline now');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`consultation_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `cust_id` (`cust_id`) USING BTREE;

--
-- Indexes for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD PRIMARY KEY (`log_activity_id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_consultation` (`consultation_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `msg_incoming_msg_id_fk` (`incoming_msg_id`),
  ADD KEY `msg_outgoing_msg_id_fk` (`outgoing_msg_id`);

--
-- Indexes for table `portfolio`
--
ALTER TABLE `portfolio`
  ADD PRIMARY KEY (`portfolio_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `cust_id` (`cust_id`),
  ADD KEY `consultation_id` (`consultation_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultation`
--
ALTER TABLE `consultation`
  MODIFY `consultation_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `log_activity`
--
ALTER TABLE `log_activity`
  MODIFY `log_activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `portfolio`
--
ALTER TABLE `portfolio`
  MODIFY `portfolio_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `settings_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_admin_id_fk` FOREIGN KEY (`admin_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `consultation_cust_id_fk` FOREIGN KEY (`cust_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_cust_id_fk` FOREIGN KEY (`cust_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `feedback_project_id_fk` FOREIGN KEY (`project_id`) REFERENCES `project` (`project_id`);

--
-- Constraints for table `log_activity`
--
ALTER TABLE `log_activity`
  ADD CONSTRAINT `fk_consultation` FOREIGN KEY (`consultation_id`) REFERENCES `consultation` (`consultation_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `msg_incoming_msg_id_fk` FOREIGN KEY (`incoming_msg_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `msg_outgoing_msg_id_fk` FOREIGN KEY (`outgoing_msg_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_admin_id_fk` FOREIGN KEY (`admin_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `project_consultation_id_fk` FOREIGN KEY (`consultation_id`) REFERENCES `consultation` (`consultation_id`),
  ADD CONSTRAINT `project_cust_id_fk` FOREIGN KEY (`cust_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
