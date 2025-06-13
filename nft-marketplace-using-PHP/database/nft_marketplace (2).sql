-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2025 at 12:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nft_marketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `artist`
--

CREATE TABLE `artist` (
  `Artist_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `DOB` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artist`
--

INSERT INTO `artist` (`Artist_ID`, `Name`, `Email`, `DOB`) VALUES
(11, 'artist1', 'artist1@example.com', NULL),
(12, 'artist2', 'artist2@example.com', NULL),
(13, 'artist3', 'artist3@example.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `artwork`
--

CREATE TABLE `artwork` (
  `Artwork_ID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Photo` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Artist_ID` int(11) NOT NULL,
  `Created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artwork`
--

INSERT INTO `artwork` (`Artwork_ID`, `Title`, `Price`, `Photo`, `Description`, `Artist_ID`, `Created_At`, `Status`) VALUES
(6, 'NFT1', 9999.00, 'uploads/download (1).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 11, '2025-06-05 22:18:25', 'active'),
(7, 'NFT2', 9999.00, 'uploads/download (1).png', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 11, '2025-06-05 22:18:37', 'active'),
(8, 'NFT3', 9900.00, 'uploads/download (2).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 11, '2025-06-05 22:18:51', 'active'),
(9, 'NFT4', 9999.00, 'uploads/download (3).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 12, '2025-06-05 22:21:10', 'active'),
(10, 'NFT5', 9999.00, 'uploads/download.jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 12, '2025-06-05 22:21:24', 'active'),
(11, 'NFT6', 9999.00, 'uploads/download.png', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 12, '2025-06-05 22:21:35', 'active'),
(12, 'NFT7', 9999.00, 'uploads/images (1).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 13, '2025-06-05 22:21:53', 'active'),
(13, 'NFT8', 9999.00, 'uploads/images (2).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 13, '2025-06-05 22:22:08', 'active'),
(14, 'NFT9', 7777.00, 'uploads/images.jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', 13, '2025-06-05 22:22:25', 'active'),
(15, 'NFT10', 9999.00, 'uploads/images (4).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic', 11, '2025-06-05 22:42:16', 'disabled'),
(16, 'NFT11', 9999.00, 'uploads/images (5).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic', 12, '2025-06-05 22:42:29', 'disabled'),
(17, 'NFT12', 9999.00, 'uploads/images.jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic', 13, '2025-06-05 22:42:39', 'disabled');

-- --------------------------------------------------------

--
-- Table structure for table `nft`
--

CREATE TABLE `nft` (
  `nft_id` int(11) NOT NULL,
  `owning_date` timestamp NULL DEFAULT current_timestamp(),
  `token_id` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `artwork_id` int(11) DEFAULT NULL,
  `Owner_User_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nft`
--

INSERT INTO `nft` (`nft_id`, `owning_date`, `token_id`, `user_id`, `artwork_id`, `Owner_User_ID`) VALUES
(1, NULL, NULL, NULL, 6, 7),
(2, '2025-06-05 22:40:25', NULL, NULL, 9, 7),
(3, '2025-06-05 22:40:34', NULL, NULL, 12, 7),
(4, '2025-06-05 22:40:45', NULL, NULL, 7, 8),
(5, '2025-06-05 22:40:50', NULL, NULL, 10, 8),
(6, '2025-06-05 22:40:56', NULL, NULL, 13, 8),
(7, '2025-06-05 22:41:04', NULL, NULL, 8, 9),
(8, '2025-06-05 22:41:09', NULL, NULL, 11, 9),
(9, '2025-06-05 22:41:12', NULL, NULL, 14, 9),
(10, '2025-06-05 22:43:33', NULL, NULL, 17, 7);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `Transaction_ID` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `Date` datetime DEFAULT current_timestamp(),
  `Sender` int(11) NOT NULL,
  `Receiver` int(11) NOT NULL,
  `NFT_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `DOB` date DEFAULT NULL,
  `Role` enum('admin','user') DEFAULT 'user',
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_ID`, `Name`, `Email`, `DOB`, `Role`, `Password`) VALUES
(6, 'admin', 'admin@example.com', '2025-06-01', 'admin', '$2y$10$vxx8R7mg56Kwv1cRgOWRu.tymoZmcQUXo0GdZCScni7mMBgqIiTQi'),
(7, 'user1', 'user1@example.com', '2025-06-06', 'user', '$2y$10$wcU3b6uyjfwLo7NtSp69Qu2m7i6mL.vRu2hWM9vs6q1OOeIiNuXQ2'),
(8, 'user2', 'user2@example.com', '2025-06-06', 'user', '$2y$10$sq4.Je0XO77KEVkOQ8p77eIM6yrQ8SQigStAiFLnHIHfdGV8y9nGe'),
(9, 'user3', 'user3@example.com', '2025-06-06', 'user', '$2y$10$qJ.tTe/WZaWObiGhFzsslObfEaJswR6PQ0XGksSqE9jlzwrxRjqOG'),
(10, 'admin2', 'admin2@example.com', '2025-06-07', 'admin', '$2y$10$aswzBUZgIvD4b8YOUUCloevq3am0nmRMnYfHYGs7msNcvJc/zG36e'),
(11, 'admin3', 'admin3@example.com', '2025-06-07', 'admin', '$2y$10$KqfOpt6CSoS6vYKMGUdbIegGqmd3dZPc5bdZccYv0Qq3eW2cnL5fC');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artist`
--
ALTER TABLE `artist`
  ADD PRIMARY KEY (`Artist_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- Indexes for table `artwork`
--
ALTER TABLE `artwork`
  ADD PRIMARY KEY (`Artwork_ID`),
  ADD KEY `Artist_ID` (`Artist_ID`);

--
-- Indexes for table `nft`
--
ALTER TABLE `nft`
  ADD PRIMARY KEY (`nft_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `artwork_id` (`artwork_id`),
  ADD KEY `nft_ibfk_1` (`Owner_User_ID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`Transaction_ID`),
  ADD KEY `Sender` (`Sender`),
  ADD KEY `Receiver` (`Receiver`),
  ADD KEY `NFT_ID` (`NFT_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artist`
--
ALTER TABLE `artist`
  MODIFY `Artist_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `artwork`
--
ALTER TABLE `artwork`
  MODIFY `Artwork_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `nft`
--
ALTER TABLE `nft`
  MODIFY `nft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `Transaction_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artwork`
--
ALTER TABLE `artwork`
  ADD CONSTRAINT `artwork_ibfk_1` FOREIGN KEY (`Artist_ID`) REFERENCES `artist` (`Artist_ID`) ON DELETE CASCADE;

--
-- Constraints for table `nft`
--
ALTER TABLE `nft`
  ADD CONSTRAINT `nft_ibfk_1` FOREIGN KEY (`Owner_User_ID`) REFERENCES `user` (`User_ID`),
  ADD CONSTRAINT `nft_ibfk_2` FOREIGN KEY (`artwork_id`) REFERENCES `artwork` (`Artwork_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
