-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2018 at 06:59 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `energy`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `id` int(25) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `admin_type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`id`, `user_name`, `passwd`, `admin_type`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'super'),
(12, 'anus68', '76cb50ee8cb95da975642228be451261', 'cust'),
(34, 'sanjudwr25', '7bab89cc315dcfca2ab51caee859f7f8', 'cust'),
(1233, 'onemed41', '21232f297a57a5a743894a0e4a801fc3', 'cust'),
(1503, 'anjalysad52', '2809daf55c4d7fce4210de4aba233deb', 'cust'),
(123456, 'akshaysha75', '67bb52626fcd2a930582b19914f54bef', 'cust');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) NOT NULL,
  `f_name` varchar(25) NOT NULL,
  `l_name` varchar(25) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(15) NOT NULL,
  `state` varchar(30) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `f_name`, `l_name`, `gender`, `address`, `city`, `state`, `phone`, `email`, `date_of_birth`, `created_at`, `updated_at`) VALUES
(12, 'anu', 's', 'female', 'aaa', '', 'Idukki', '', 'j@gmail.com', '2000-03-17', '2018-02-12 04:31:28', NULL),
(34, 'Sanju', 'Pazhankannur', 'male', 'Nilambur Road', '', ' ', '9072046461', 'spazhankannur@gmail.com', '2018-02-07', '2018-02-10 00:26:46', NULL),
(1233, 'One', 'Media', 'male', 'Nilambur Road', '', 'Kozhikode', '9072046461', 'entertainmentonemedia@gmail.com', '2000-11-30', '2018-02-11 09:46:16', NULL),
(1503, 'Anjaly', 'Sadasivan', 'female', 'Anjaly Bhavan,Ruby Nagar P.O,Changanacherry', '', 'Kottayam', '9497232803', 'anjalysadasivan18@gmail.com', '1996-01-27', '2018-02-11 23:32:45', NULL),
(123456, 'akshay', 'shaji', 'male', 'cheeramputhoor', '', 'Kottayam', '9048194693', 'akshayshaji525@gmail.com', '1997-02-08', '2018-02-12 02:04:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usagedetails`
--

CREATE TABLE `usagedetails` (
  `id` int(11) NOT NULL,
  `currentVal` int(11) NOT NULL,
  `lastMonth` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usagedetails`
--

INSERT INTO `usagedetails` (`id`, `currentVal`, `lastMonth`) VALUES
(34, 20, 0),
(1233, 10, 0),
(1503, 50, 150),
(123456, 0, 0),
(12, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usagedetails`
--
ALTER TABLE `usagedetails`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123457;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123457;
--
-- AUTO_INCREMENT for table `usagedetails`
--
ALTER TABLE `usagedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123457;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
