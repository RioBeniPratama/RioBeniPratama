-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 01:46 PM
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
-- Database: `rajawali_motor_sport`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `motor_brand` varchar(50) NOT NULL,
  `motor_type` varchar(50) NOT NULL,
  `motor_year` year(4) NOT NULL,
  `service_package` varchar(100) NOT NULL,
  `status` enum('Pending','Selesai','Dibatalkan') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `kerusakan` text DEFAULT NULL,
  `suku_cadang` text DEFAULT NULL,
  `harga_total` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT 'Pending',
  `payment_status` varchar(50) DEFAULT 'Pending',
  `proof_payment` varchar(255) DEFAULT NULL,
  `cost` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `booking_date`, `booking_time`, `motor_brand`, `motor_type`, `motor_year`, `service_package`, `status`, `created_at`, `kerusakan`, `suku_cadang`, `harga_total`, `payment_method`, `payment_status`, `proof_payment`, `cost`) VALUES
(3, 4, '2024-12-18', '11:00:00', 'Honda', 'Beat', '2021', 'Servis Berkala', 'Selesai', '2024-12-06 18:02:31', 'Rusak pada bagian mesin', 'Aki = Rp. 150.000\r\nKlep = Rp. 85.000', 235000.00, 'Pending', 'Pending', NULL, 0.00),
(4, 4, '2024-12-13', '13:00:00', 'Honda', 'Beat street', '2021', 'Perbaikan Mesin', 'Dibatalkan', '2024-12-06 18:31:35', NULL, NULL, NULL, 'Pending', 'Pending', NULL, 0.00),
(6, 6, '2024-12-08', '10:00:00', 'YAmaha', 'Nmax', '2023', 'Ganti Suku Cadang', 'Selesai', '2024-12-07 06:30:20', NULL, NULL, NULL, 'Pending', 'Pending', NULL, 0.00),
(7, 7, '2024-12-07', '14:00:00', 'Yamaha', 'Aerox', '2023', 'Cek Kerusakan', 'Selesai', '2024-12-07 07:16:22', NULL, NULL, NULL, 'Pending', 'Pending', NULL, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE `nota` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `kerusakan` text NOT NULL,
  `suku_cadang` text NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nota`
--

INSERT INTO `nota` (`id`, `booking_id`, `kerusakan`, `suku_cadang`, `harga`, `created_at`) VALUES
(1, 3, 'Rusak pada bagian mesin', 'Aki = Rp. 150.000,\r\nKlep = Rp. 85.000', 235000.00, '2024-12-06 19:07:24'),
(3, 6, 'udbubvu', 'jdncudu', 165341.00, '2024-12-07 06:32:04'),
(4, 7, 'jfieubfuebfeku', 'ncuncuenue', 100000.00, '2024-12-07 07:18:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@rajawali.com', '0192023a7bbd73250516f069df18b500', '', NULL, 'admin', '2024-12-06 17:53:57'),
(4, 'Rio Beni Pratama', 'pratama@gmail.com', '$2y$10$feZb4GQ7.Zv1w4P.9QmQxuDMH890uCvRj5hBBYmKTeIMqFvqdXL3e', '083843944721', 'Dusun III Desa Soak Batok', 'user', '2024-12-06 18:01:55'),
(6, 'Jare', 'fajar@gmail.com', '$2y$10$2nUQ/dzvaZFvwAmJoGEQBuRRGb9BL3SenG3YaNhC2rs3r8d3jVUoe', '083843944721', 'Palembang', 'user', '2024-12-07 06:29:21'),
(7, 'Nyimas Sopiah', 'Nyimassopiah@gmail.com', '$2y$10$WkJ6iqU6jfUT.DBVO3mQ6eXsFaQNrn2U0rfywSHkYaopA00iHzPzG', '083843944721', 'Palembang', 'user', '2024-12-07 07:13:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `nota_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
