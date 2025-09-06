-- Complete Refined SQL Dump for OK Tours & Travel
-- Enhanced with better constraints, security practices, and normalization

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Database: oktours
-- --------------------------------------------------------
DROP DATABASE IF EXISTS `oktours`;
CREATE DATABASE IF NOT EXISTS `oktours` 
  DEFAULT CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;
USE `oktours`;

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `id_number` VARCHAR(50) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `profile_photo` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` 
(`id`, `name`, `id_number`, `phone`, `email`, `password`, `profile_photo`) VALUES
(1, 'Hassan Adam', 'ID001', '0749973736', 'hassan@gmail.com', 
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL),
(2, 'Venus Njeri', 'ID002', '+25457792029', 'venus@gmail.com', 
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL);

-- --------------------------------------------------------
-- Table: admins
-- --------------------------------------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admins` (`username`, `password`) VALUES
('admin', 'admin123'),
('hassanadamu', 'king1234');

-- --------------------------------------------------------
-- Table: tour_packages
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tour_packages`;
CREATE TABLE `tour_packages` (
  `package_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `category` ENUM('safari', 'beach', 'mountain', 'cultural') NOT NULL,
  `base_price` DECIMAL(10,2) NOT NULL CHECK (`base_price` >= 0),
  `duration_days` INT NOT NULL CHECK (`duration_days` > 0),
  `image_url` VARCHAR(255) DEFAULT NULL,
  `is_active` BOOLEAN DEFAULT TRUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_category` (`category`),
  INDEX `idx_price` (`base_price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tour_packages` 
(`name`, `description`, `category`, `base_price`, `duration_days`, `image_url`) VALUES
('Masai Mara Safari', 'Experience wildlife in Masai Mara', 'safari', 800.00, 10, 'images/masaimara.jpg'),
('Beach Holiday', 'Relax at Diani Beach', 'beach', 500.00, 7, 'images/diani.jpg');

-- --------------------------------------------------------
-- Table: user_cart
-- --------------------------------------------------------
DROP TABLE IF EXISTS `user_cart`;
CREATE TABLE `user_cart` (
  `cart_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `package_id` INT NOT NULL,
  `destination` VARCHAR(255) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `travelers` INT NOT NULL DEFAULT 1 CHECK (`travelers` > 0),
  `price_per_person` DECIMAL(10,2) NOT NULL CHECK (`price_per_person` >= 0),
  `subtotal` DECIMAL(10,2) NOT NULL CHECK (`subtotal` >= 0),
  `status` ENUM('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `payment_status` ENUM('unpaid','partial','paid') DEFAULT 'unpaid',
  `amount_paid` DECIMAL(10,2) DEFAULT 0.00 CHECK (`amount_paid` >= 0),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cart_package` FOREIGN KEY (`package_id`) REFERENCES `tour_packages`(`package_id`) ON DELETE CASCADE,
  INDEX `idx_user_status` (`user_id`, `status`),
  INDEX `idx_dates` (`start_date`, `end_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_cart` 
(`user_id`, `package_id`, `destination`, `start_date`, `end_date`, `travelers`, `price_per_person`, `subtotal`) VALUES
(1, 1, 'Masai Mara', '2025-07-15', '2025-07-25', 4, 800.00, 3200.00);

-- --------------------------------------------------------
-- Table: cart_extras
-- --------------------------------------------------------
DROP TABLE IF EXISTS `cart_extras`;
CREATE TABLE `cart_extras` (
  `extra_id` INT AUTO_INCREMENT PRIMARY KEY,
  `cart_id` INT NOT NULL,
  `extra_name` VARCHAR(255) NOT NULL,
  `extra_price` DECIMAL(10,2) NOT NULL CHECK (`extra_price` >= 0),
  CONSTRAINT `fk_extra_cart` FOREIGN KEY (`cart_id`) REFERENCES `user_cart`(`cart_id`) ON DELETE CASCADE,
  INDEX `idx_cart` (`cart_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `cart_extras` (`cart_id`, `extra_name`, `extra_price`) VALUES
(1, 'Hot Air Balloon', 200.00);

-- --------------------------------------------------------
-- Table: bookings
-- --------------------------------------------------------
DROP TABLE IF EXISTS `bookings`;
CREATE TABLE `bookings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `place` VARCHAR(150) NOT NULL,
  `contact` VARCHAR(20) NOT NULL,
  `id_number` VARCHAR(50) NOT NULL,
  `num_people` INT NOT NULL,
  `num_days` INT NOT NULL,
  `travel_date` DATE NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_travel_date` (`travel_date`),
  INDEX `idx_contact` (`contact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `bookings` 
(`name`, `email`, `place`, `contact`, `id_number`, `num_people`, `num_days`, `travel_date`) VALUES
('Hassan Adam', 'hassan@gmail.com', 'Egypt', '0786124786', '345667', 2, 2, '2025-08-20');

-- --------------------------------------------------------
-- Table: enquiries
-- --------------------------------------------------------
DROP TABLE IF EXISTS `enquiries`;
CREATE TABLE `enquiries` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `message` TEXT,
  `status` ENUM('pending','resolved') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_status` (`status`),
  INDEX `idx_phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `enquiries` (`name`, `phone`, `message`) VALUES
('Venus Njeri', '+25457792029', 'I need more info');

-- --------------------------------------------------------
-- Table: gallery_items
-- --------------------------------------------------------
DROP TABLE IF EXISTS `gallery_items`;
CREATE TABLE `gallery_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `location` VARCHAR(100) NOT NULL,
  `continent` VARCHAR(50) NOT NULL,
  `image_path` VARCHAR(500) DEFAULT NULL,
  `video_path` VARCHAR(500) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CHECK (`image_path` IS NOT NULL OR `video_path` IS NOT NULL),
  INDEX `idx_location` (`location`),
  INDEX `idx_continent` (`continent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gallery_items` 
(`title`, `description`, `location`, `continent`, `image_path`, `video_path`) VALUES
('Eiffel Tower', 'Iconic landmark of Paris', 'Paris, France', 'Europe', 'images/eiffel.jpg', NULL);

-- --------------------------------------------------------
-- Table: website_background
-- --------------------------------------------------------
DROP TABLE IF EXISTS `website_background`;
CREATE TABLE `website_background` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `image_path` VARCHAR(255) NOT NULL,
  `is_active` BOOLEAN DEFAULT FALSE,
  `uploaded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `website_background` (`image_path`, `is_active`) VALUES
('uploads/background.jpg', TRUE);

-- --------------------------------------------------------
-- Example optimized query
-- --------------------------------------------------------
SELECT 
  uc.*, 
  tp.name AS package_name, 
  tp.category,
  COALESCE(SUM(ce.extra_price), 0) AS total_extras,
  (uc.subtotal + COALESCE(SUM(ce.extra_price), 0)) AS grand_total
FROM user_cart uc
JOIN tour_packages tp ON uc.package_id = tp.package_id
LEFT JOIN cart_extras ce ON uc.cart_id = ce.cart_id
WHERE uc.user_id = 1 
  AND uc.status = 'pending'
GROUP BY uc.cart_id;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- End of SQL Dump
  