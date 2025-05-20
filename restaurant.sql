-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2025 at 11:42 PM
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
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `image_id` int(11) NOT NULL,
  `image` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`image_id`, `image`, `description`) VALUES
(1, 'assets\\images\\dentist-atmosphere\\dentist17.jpg', 'image 1'),
(2, 'assets\\images\\dentist-atmosphere\\dentist16.jpeg', 'image 2'),
(3, 'assets\\images\\dentist-atmosphere\\dentist19.jpg', 'image 3'),
(4, 'assets\\images\\dentist-atmosphere\\dentist21.jpg', 'image 4'),
(5, 'assets\\images\\dentist-atmosphere\\dentist23.jpg', 'image 5'),
(6, 'assets\\images\\dentist-atmosphere\\dentist20.jpg', 'image 6'),
(7, 'assets\\images\\dentist-atmosphere\\dentist22.jpg', 'image 7');

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `issue_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `telephone` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`issue_id`, `type`, `name`, `surname`, `telephone`, `email`, `message`) VALUES
(3, 0, 'sv', 'asd', 99098232, 'alex123@gmail.com', 'i love it');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categ`
--

CREATE TABLE `tbl_categ` (
  `Id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_categ`
--

INSERT INTO `tbl_categ` (`Id`, `description`) VALUES
(1, 'Cosmetic Dentistry'),
(2, 'Dental Implants'),
(3, 'Dental Prosthetics'),
(4, 'Crowns and Bridgework'),
(5, 'Removable prosthesis'),
(6, 'Orthodontics'),
(7, 'Periodontology'),
(8, 'Root Canal Treatment'),
(9, 'Teeth Whitening'),
(10, 'Veneers');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gen`
--

CREATE TABLE `tbl_gen` (
  `genID` int(11) NOT NULL,
  `descgen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_gen`
--

INSERT INTO `tbl_gen` (`genID`, `descgen`) VALUES
(1, 'female'),
(2, 'male');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_housebooks`
--

CREATE TABLE `tbl_housebooks` (
  `houseID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `category_fk` int(11) NOT NULL,
  `path` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `phone` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_housebooks`
--

INSERT INTO `tbl_housebooks` (`houseID`, `name`, `email`, `category_fk`, `path`, `date`, `phone`, `subject`, `message`) VALUES
(5, 'Kat', 'Kat@gmail.com', 4, 'images/images.jpeg', '2025-02-28', 1231343, 'i tired', 'i pain tooth');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `faceID` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `facepath` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `number` int(11) NOT NULL,
  `gender_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`faceID`, `email`, `password`, `facepath`, `name`, `surname`, `number`, `gender_fk`) VALUES
(7, 'pavel123@gmail.com', '$2y$10$ohtxRxSDbNMCZldzq2GrSeLvzfwXp3obKo4rv3m70ybKvfuHhNqZy', 'faceimages/lomonosov-sm.jpg', 'pavelSP', 'gon', 111111, 2),
(9, 'sp@gmail.com', '$2y$10$tbaTM0dWFsLzbJWhttPRleaPoLP/KHtW50lI0tKeXTTOne8ouAH.O', 'faceimages/lomonosov-sm.jpg', 'SP', 'SP', 8237242, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`issue_id`);

--
-- Indexes for table `tbl_categ`
--
ALTER TABLE `tbl_categ`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `tbl_gen`
--
ALTER TABLE `tbl_gen`
  ADD PRIMARY KEY (`genID`);

--
-- Indexes for table `tbl_housebooks`
--
ALTER TABLE `tbl_housebooks`
  ADD PRIMARY KEY (`houseID`),
  ADD KEY `Test` (`category_fk`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`faceID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_categ`
--
ALTER TABLE `tbl_categ`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_gen`
--
ALTER TABLE `tbl_gen`
  MODIFY `genID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_housebooks`
--
ALTER TABLE `tbl_housebooks`
  MODIFY `houseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `faceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_housebooks`
--
ALTER TABLE `tbl_housebooks`
  ADD CONSTRAINT `Test` FOREIGN KEY (`category_fk`) REFERENCES `tbl_categ` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
