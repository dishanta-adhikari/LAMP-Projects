-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2025 at 09:06 AM
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
(14, 'artist1', 'artist1@example.com', NULL),
(15, 'artist2', 'artist2@example.com', NULL),
(16, 'artist3', 'artist3@example.com', NULL);

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
(18, 'NFT 01', 9999.00, 'uploads/download (1).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 14, '2025-06-06 06:35:42', 'active'),
(19, 'NFT 02', 9999.00, 'uploads/download (1).png', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 14, '2025-06-06 06:35:53', 'active'),
(20, 'NFT 03', 9999.00, 'uploads/download (2).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 14, '2025-06-06 06:36:07', 'active'),
(21, 'NFT 04', 9999.00, 'uploads/download (3).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 15, '2025-06-06 06:36:17', 'active'),
(22, 'NFT 05', 9999.00, 'uploads/download.jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 15, '2025-06-06 06:36:32', 'active'),
(23, 'NFT 06', 9999.00, 'uploads/download.png', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 15, '2025-06-06 06:36:44', 'active'),
(24, 'NFT 07', 9999.00, 'uploads/images (1).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 15, '2025-06-06 06:36:58', 'active'),
(25, 'NFT 08', 999.00, 'uploads/images (2).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 16, '2025-06-06 06:37:33', 'active'),
(26, 'NAFT 09', 9999.00, 'uploads/images (3).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 16, '2025-06-06 06:37:46', 'active'),
(27, 'NFT 10', 9999.00, 'uploads/images (4).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 16, '2025-06-06 06:38:02', 'active'),
(28, 'NFT 11', 9999.00, 'uploads/images (5).jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 14, '2025-06-06 06:38:59', 'active'),
(29, 'NFT 12', 9999.00, 'uploads/images.jpeg', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s,', 16, '2025-06-06 06:39:10', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `nft`
--

CREATE TABLE `nft` (
  `nft_id` int(11) NOT NULL,
  `owning_date` timestamp NULL DEFAULT current_timestamp(),
  `artwork_id` int(11) DEFAULT NULL,
  `Owner_User_ID` int(11) DEFAULT NULL,
  `Is_Paid` tinyint(1) DEFAULT 0,
  `token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nft`
--

INSERT INTO `nft` (`nft_id`, `owning_date`, `artwork_id`, `Owner_User_ID`, `Is_Paid`, `token`) VALUES
(15, '2025-06-06 06:41:40', 18, 12, 1, '02f1526328137c618179837c55a6a31f'),
(16, '2025-06-06 06:41:48', 19, 12, 0, 'e3e2edcb6cad8f140b94bbd763825db9'),
(17, '2025-06-06 06:41:51', 20, 12, 0, '5265e6818225d4ef61a2f26f8c580d22'),
(18, '2025-06-06 06:43:39', 28, 14, 0, '41daa8435f2bf19ed7679333ca9ca53c'),
(19, '2025-06-06 06:43:43', 21, 14, 0, 'e5fa679185efbd1e0f253151f3573c81'),
(20, '2025-06-06 06:43:47', 22, 14, 1, 'c7c02e42c42b4a575cde91c8185bcc04'),
(21, '2025-06-06 06:44:24', 26, 13, 1, '11cfeca6807f09ec08b80e4aef6f714b'),
(22, '2025-06-06 06:44:29', 27, 13, 0, '8f43455cbbd779ec96dddfc614dc260e'),
(23, '2025-06-06 06:44:33', 29, 13, 0, '051e77728083945407b7c1c56cd20a69');

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

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`Transaction_ID`, `Amount`, `Date`, `Sender`, `Receiver`, `NFT_ID`) VALUES
(18, 9999.00, '2025-06-06 12:11:57', 12, 0, 15),
(19, 9999.00, '2025-06-06 12:13:49', 14, 0, 20),
(20, 9999.00, '2025-06-06 12:14:35', 13, 0, 21);

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
(12, 'user1', 'user1@example.com', '2025-06-06', 'user', '$2y$10$kkagKoE4NnX8v0ulA7L2g.hZkpBZ1m7UZZhgmgNRT1YHgJu4DkqiS'),
(13, 'user2', 'user2@example.com', '2025-06-06', 'user', '$2y$10$4M45B2yEkmrutZzc1YJuHuNHr/phkFm620CH9M1/0Y4J6zOCiOMAC'),
(14, 'user3', 'user3@example.com', '2025-06-06', 'user', '$2y$10$2s7yccZHOFJAC6JnSFZZA.Cw.Cc1O1kx82a8BOiIrN9.4.pEcTS.G'),
(15, 'admin', 'admin@example.com', '2025-06-06', 'admin', '$2y$10$gcD2rFIgXH.mNWWgXa22aeyC.j9twBwRkOC28gGQR.84maVz1ulUi'),
(16, 'admin2', 'admin2@example.com', '2025-06-06', 'admin', '$2y$10$S9SytDqz8Uj0o7ocr7eR5uhjW3IOwXX8eenbHxPJd4mmra81Ab7FG'),
(17, 'admin3', 'admin3@example.com', '2025-06-07', 'admin', '$2y$10$..bCs1CNlNw58if/olGO2unPcqtS5Al.snGDDoGW/op69mUtRYNu6');

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
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `artwork_id` (`artwork_id`),
  ADD KEY `nft_ibfk_1` (`Owner_User_ID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`Transaction_ID`);

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
  MODIFY `Artist_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `artwork`
--
ALTER TABLE `artwork`
  MODIFY `Artwork_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `nft`
--
ALTER TABLE `nft`
  MODIFY `nft_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `Transaction_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
