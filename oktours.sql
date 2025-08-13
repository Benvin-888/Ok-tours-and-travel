-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 17, 2025 at 07:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oktours`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123'),
(5, 'hassanadamu', '1234'),
(7, 'stan chokoe', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `place` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `num_people` int(11) NOT NULL,
  `num_days` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `travel_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `email`, `place`, `contact`, `id_number`, `num_people`, `num_days`, `created_at`, `travel_date`) VALUES
(1, NULL, NULL, 'Egypt', '0786124786', '345667', 2, 2, '2025-05-29 10:54:26', NULL),
(2, NULL, NULL, 'France', '0786124786', '345667', 1, 1, '2025-06-02 11:18:13', NULL),
(3, NULL, NULL, 'South Africa', '0786124786', '345667', 3, 4, '2025-06-02 11:44:26', NULL),
(4, NULL, NULL, 'Japan', '0786124786', '3456789', 4, 100, '2025-06-02 11:54:30', NULL),
(5, 'hassan adam', 'fredricknjiru.014@gmail.com', 'Tanzania', '0786124786', '345667', 5, 5, '2025-06-02 12:12:49', NULL),
(6, 'benvin mwikali', 'hassanadamabdul@gmail.com', 'Morocco', '0786124786', '345667', 5, 10, '2025-06-03 17:38:09', NULL),
(7, 'Hassan Abdul', 'hassanadamabdul@gmail.com', 'Australia', '0790404755', '26511146', 4, 2, '2025-06-09 11:29:34', '2025-06-20'),
(8, 'stan chokoe 2', 'stanchokoe6@gmail.com', 'Tanzania', '0786124786', '67338447', 5, 2, '2025-06-12 16:32:17', '2025-06-27'),
(9, 'john', 'john@gmail.com', 'Japan', '0718922875', '27039686', 1, 1, '2025-06-17 17:31:41', '2025-06-17'),
(10, 'chris', 'chris@gmail.com', 'japan', '078888888', '12345', 2, 3, '2025-06-17 18:46:10', '2025-06-24'),
(11, 'chris', 'chris@gmail.com', 'Kenya', '0718922875', '27039686', 2, 2, '2025-06-18 07:45:34', '2025-06-28'),
(12, 'mercy', 'mercy35@gmail.com', 'USA', '0722354019', '12345', 1, 1, '2025-06-19 07:08:11', '2025-08-28'),
(13, 'christa', 'chris@gmail.com', 'Egypt', '078888888', '12345', 1, 1, '2025-06-19 08:25:59', '2025-06-26'),
(14, 'mercy msoo', 'msoo888@gmail.com', 'Kenya', '079999999', '7777777', 3, 4, '2025-07-07 07:18:44', '2025-07-31'),
(16, 'Benah', 'df@gmail.com', 'France', '0712364511', '777777', 1, 2, '2025-07-07 12:37:36', '2025-09-05'),
(17, 'mutugi gift kinyua', 'gift@gmail.com', 'France', '0797442098', '23310541', 2, 28, '2025-07-09 13:48:05', '2025-07-10'),
(18, 'sharon ngendo', 'sharonshazzy@gmail.com', 'France', '0705026707', '41545454', 1, 1, '2025-07-17 14:39:08', '2025-07-31');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','resolved') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `name`, `phone`, `message`, `created_at`, `status`) VALUES
(1, 'hassan adam', '+25457792029', 'dfvececbechebuicebhc', '2025-05-29 11:02:10', 'resolved'),
(2, 'venus njeri', '+25457792029', 'asdfvgbhnjsdcfvgbh', '2025-06-02 12:14:52', 'resolved'),
(3, 'rahmna', '0799518807', 'i need more explanation about your system', '2025-06-02 15:30:11', 'resolved'),
(4, 'hassan adam', '0799518807', 'hassan adam', '2025-06-02 15:46:12', 'resolved'),
(5, 'benvin', '+25457792029', 'i need bus', '2025-06-03 17:39:17', 'pending'),
(6, 'stan chokoe', '0799518807', 'i want to go to the pinnacle.', '2025-06-12 16:37:51', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_items`
--

CREATE TABLE `gallery_items` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_items`
--

INSERT INTO `gallery_items` (`id`, `title`, `image_path`, `video_path`, `created_at`) VALUES
(1, 'Eiffel Tower, Paris tttt', 'images/4.png', 'images/videos/JPK.png', '2025-06-03 11:00:16'),
(2, 'Great Wall of China', 'images/sha.png', 'images/videos/greatwall.mp4', '2025-06-03 11:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_number` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_photo`, `created_at`, `id_number`, `phone`) VALUES
(1, 'hassan', 'hassan@gmail.com', '1234', NULL, '2025-05-29 08:58:02', '6733844', '0749973736'),
(2, 'hassan adam', 'user2@gmail.com', '$2y$10$8iRyNMc6.eShIdbVYkVRhOmw4h4Tc1gTEgi5JEG1HOubum7sHAFZe', NULL, '2025-05-29 09:41:31', '67338447', '07567474768'),
(5, 'hassan', 'Mutwiriobadiah3@gmail.com', '$2y$10$Y8W/RPrslEOCLiorL9br0eJe/SVNWBsg1a1kTcMuL9pIx6lgJj5TO', '', '2025-06-02 11:17:06', '343455', '+25457792029'),
(6, 'venus njeri', 'fredricknjiru.014@gmail.com', '$2y$10$pL1taNSeAwcFQ3NY6iK4z.K/R7NOpGoxKKPpAq6CCPpaq0ndeL.QO', '', '2025-06-02 11:43:54', '4788399', '+25457792029'),
(7, 'venus njeri', 'h@gmail.com', '$2y$10$TJDoES12EnlpEcvSOtj9uOnHV3G3pxj4Kv7fbEMHEXdO7QSi0Rh0e', '', '2025-06-02 11:54:06', '1223456789', '20756747476'),
(8, 'abdushakur murmadi', 'abdushakur@gmail.com', '$2y$10$8zXxqdh0lFFtuzlqKlCmee7bkyU3D9pMErjn6AD.mmOiWKwbzalkS', 'uploads/1748946355_2025-05-10_09-01.png', '2025-06-03 09:25:55', '345667', '+25457792029'),
(10, 'abdushakur murmadi', 'abdushakuriiiiiiiiiiii@gmail.com', '$2y$10$zPn67/Oo29N8pYGZtGvBZO0hXEMELJYzA1PcrUtPGKO9yAo002HIW', 'uploads/1748946678_2025-05-10_09-01.png', '2025-06-03 09:31:18', '345667', '+25457792029'),
(11, 'benvin mwikali', 'hs@gmail.com', '$2y$10$4Af/15dniqn1.x4/e2CqcO2GPOxo8CsO9wo7Zp8iIYVa0f7daUh22', '', '2025-06-03 17:37:16', '4788399', '+25457792029'),
(15, 'Hassan Abdul', 'hassanadamabdul2@gmail.com', '$2y$10$0P6OsIb/9TbvPXND8D/8YeB0CJQZpLhz38Fn2jYChEQW0VsISxuE2', '', '2025-06-09 11:45:29', '666667', '+254790404755'),
(19, 'stan chokoe 2', 'stanchokoe@gmail.com', '$2y$10$zRsM01R35cr/GQIDgpDs5eK0cpf6v5H7R1ybMY4fuc3RXSRxMht0u', '', '2025-06-09 17:55:15', '5675677', '0756747476'),
(20, 'stan chokoe 1', 'stanchokoe55@gmail.com', '$2y$10$kC8jF2wH05N.v96vjZOFwuKijDutfIsIfdmfF9Ahkz3GHAdecjSZy', 'uploads/1749745496_DreamWorks\' Home_ Tip lead character - mixed race….jpeg', '2025-06-12 15:24:56', '90900', '0756747474'),
(23, 'chris', 'chris@gmail.com', '$2y$10$cJRGmWHSvfctcFKGwSiHgejfpEE910/JGBr.ApZp9l0HAcWUJ9n16', '', '2025-06-17 18:43:25', '12345', '0706467999'),
(25, 'dev', 'dev@gmail.com', '$2y$10$6QRFYQzkwU68oC.Fq9pzzOZjiCojj7MVH4gKIsLSn.QnWLjYQhTUm', '', '2025-06-21 18:27:37', '12345', '079335990'),
(26, 'vf', 'chris@gm.com', '$2y$10$S47vN4V9mwmPpO3fC95laeJ6TnLRwQK3XLUght5DRhojJtFexEauC', '', '2025-07-19 11:18:39', 'vdfvv', '0718922857');

-- --------------------------------------------------------

--
-- Table structure for table `website_background`
--

CREATE TABLE `website_background` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `website_background`
--

INSERT INTO `website_background` (`id`, `image_path`, `uploaded_at`) VALUES
(14, 'uploads/Hacking Wallpaper 4K For Pc Gallery.jpeg', '2025-06-12 16:19:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_items`
--
ALTER TABLE `gallery_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `website_background`
--
ALTER TABLE `website_background`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gallery_items`
--
ALTER TABLE `gallery_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `website_background`
--
ALTER TABLE `website_background`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
