-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 10:16 PM
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
-- Database: `brs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `phone` int(11) NOT NULL,
  `password` text NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `name`, `email`, `phone`, `password`, `address`, `created_at`) VALUES
(1, 'Alice Johnson', 'alice@example.com', 1234567890, 'alice123', '123 Elm Street', '2025-05-04 18:02:54'),
(2, 'Bob Smith', 'bob@example.com', 2147483647, 'bob123', '456 Oak Avenue', '2025-05-04 18:02:54'),
(3, 'Charlie Lee', 'charlie@example.com', 1122334455, 'charlie123', '789 Pine Road', '2025-05-04 18:02:54'),
(4, 'Disahnta Adhikari', 'dishanta.adhikari@zohomail.in', 1234123456, '1234', '1234asdf,asdf', '2025-05-04 19:32:45');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `img` text NOT NULL,
  `author_id` int(11) NOT NULL,
  `vol` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `img`, `author_id`, `vol`, `created_at`, `pdf`) VALUES
(4, 'Disahnta Adhikari', 'book.jpg', 1, '123', '2025-05-04 19:13:17', '6817bc4d4a0f2.pdf'),
(6, 'Disahnta Adhikari', '6817c14c0da2c.png', 4, '123', '2025-05-04 19:34:36', '6817c14c0da2e.pdf'),
(7, 'Don Quixote', '6817c696f07bf.jpeg', 1, '1', '2025-05-04 19:57:10', '6817c696f07c2.pdf'),
(8, 'Pride and Prejudice', '6817c706e6c7a.jpeg', 1, '2', '2025-05-04 19:59:02', '6817c706e6c7d.pdf'),
(9, 'Rich Dad Poor Dad', '6817c783470ae.jpeg', 2, '123', '2025-05-04 20:01:07', '6817c783470b2.pdf'),
(10, 'The Lord of the Rings', '6817c8a7e1ca7.jpeg', 3, '234', '2025-05-04 20:05:59', '6817c8a7e1caa.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `book_id`, `user_name`, `rating`, `comment`, `created_at`) VALUES
(4, 4, 'Daniel Ray', 5, 'goodone', '2025-05-04 19:13:52'),
(5, 4, 'dishanta', 5, 'sadfsdf', '2025-05-04 19:14:18'),
(6, 9, 'dishanta', 5, 'v.good book', '2025-05-04 20:01:45'),
(7, 7, 'ajay', 5, 'asdfasdf', '2025-05-04 20:03:02'),
(8, 6, 'xcxcf', 5, 'asdasd', '2025-05-04 20:03:30'),
(9, 4, 'ajay', 5, 'sdfasdf', '2025-05-04 20:03:46'),
(10, 6, 'das', 5, 'q2131', '2025-05-04 20:04:47'),
(11, 4, 'ajay', 5, 'qweqwe', '2025-05-04 20:06:58'),
(12, 4, 'Daniel Ray', 5, 'sdasd', '2025-05-04 20:09:16'),
(13, 6, 'dishanta', 5, 'asdasd', '2025-05-04 20:09:40'),
(14, 6, 'Daniel Ray', 5, 'asdas', '2025-05-04 20:10:13'),
(15, 10, 'Daniel Ray', 5, 'awdaw', '2025-05-04 20:13:19'),
(16, 7, 'Daniel Ray', 5, 'asad', '2025-05-04 20:14:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `phone` int(11) NOT NULL,
  `address` text NOT NULL,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `password`, `created_at`) VALUES
(1, 'Daniel Ray', 'daniel@example.com', 2147483647, '901 Maple Street', 'daniel123', '2025-05-04 18:02:54'),
(2, 'Emily Carter', 'emily@example.com', 2147483647, '802 Birch Avenue', 'emily123', '2025-05-04 18:02:54'),
(3, 'Frank Miller', 'frank@example.com', 2147483647, '703 Cedar Lane', 'frank123', '2025-05-04 18:02:54'),
(4, 'Disahnta Adhikari', 'dishanta.adhikari@zohomail.in', 1234123456, 'sdfsdfg', '1234', '2025-05-04 19:37:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id_fr` (`author_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `author_id_fr` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
