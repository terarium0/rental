-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 23, 2025 at 11:55 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_native`
--

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `id` int NOT NULL,
  `id_perental` int DEFAULT NULL,
  `nama_mobil` varchar(100) DEFAULT NULL,
  `harga_sewa` int DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('tersedia','tidak tersedia') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`id`, `id_perental`, `nama_mobil`, `harga_sewa`, `gambar`, `status`) VALUES
(1, 2, 'wqwqw', 10, '1761199520_240.jpg', 'tidak tersedia'),
(2, 2, 'sas', 123, '1761199550_113.png', 'tersedia'),
(3, 4, 'tyu', 1234, '1761218175_505.png', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `id_mobil` int NOT NULL,
  `id_penyewa` int NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('menunggu','disetujui','ditolak') DEFAULT 'menunggu',
  `tanggal_pesan` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `id_mobil`, `id_penyewa`, `tanggal_mulai`, `tanggal_selesai`, `total_harga`, `status`, `tanggal_pesan`) VALUES
(1, 1, 3, '2025-10-23', '2025-10-30', 70.00, 'disetujui', '2025-10-23 06:22:57'),
(2, 3, 3, '2025-10-23', '2025-10-31', 9872.00, 'ditolak', '2025-10-23 11:24:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `telepon` varchar(20) NOT NULL,
  `role` enum('admin','perental','penyewa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `telepon`, `role`) VALUES
(1, 'admin', 'admin', '$2y$10$it8U8NRKP8F3DO6oxfnx2uxoUqyqxHyJXM.pulE/OQoD4a57AqBay', '00000', 'admin'),
(2, 'qwerty', '1', '$2y$10$7TkWYhL39M6AOz5UEaj0n.vR5azXyS/O40jYl.OTCwlFkJ5rqGEsC', '081325606519', 'perental'),
(3, 'asdf', '2', '$2y$10$8HnbNNWBT2NzIf5sKOWuretpZt7c8hNyUYSh.FVh0wvhJLL.9nD9W', '081325606519', 'penyewa'),
(4, 'zxcv', '3', '$2y$10$CH4pfQxK6LxqF15o7/8Dzu8FrsXJTKB4416lH60CvK8OFvaNoeDPK', '081804367202', 'perental');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_perental` (`id_perental`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mobil`
--
ALTER TABLE `mobil`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mobil`
--
ALTER TABLE `mobil`
  ADD CONSTRAINT `mobil_ibfk_1` FOREIGN KEY (`id_perental`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
