-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 26, 2025 at 09:15 AM
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
-- Database: `rental_barang`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `id_perental` int DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga_sewa` int DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` enum('tersedia','tidak tersedia') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `id_perental`, `nama_barang`, `kategori`, `deskripsi`, `harga_sewa`, `foto`, `status`) VALUES
(4, 2, 'Kamera Canon EOS 700D', 'Elektronik', 'Kamera DSLR lengkap dengan lensa kit', 150000, '1761199520_240.jpg', 'tersedia'),
(5, 2, 'Laptop ASUS VivoBook 17', 'Elektronik', 'Laptop Core i5 dengan RAM 8GB', 300000, '1761468812_113.png', 'tidak tersedia'),
(7, 4, 'qwert', '1234', '5678', 900000, '1761468947_947.png', 'tersedia');

-- --------------------------------------------------------

--
-- Table structure for table `sewa`
--

CREATE TABLE `sewa` (
  `id` int NOT NULL,
  `id_barang` int NOT NULL,
  `id_penyewa` int NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('menunggu','disetujui','ditolak','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'menunggu',
  `tanggal_pesan` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(4, 'zxcv', '3', '$2y$10$CH4pfQxK6LxqF15o7/8Dzu8FrsXJTKB4416lH60CvK8OFvaNoeDPK', '081804367202', 'perental'),
(5, 'rtyuu', '4', '$2y$10$7/vOMtiM2VG91hPLU6eMcuLFeb9lUdZvwqUZr.ukF6OFBsb5qiCPa', '081804367202', 'penyewa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_perental` (`id_perental`);

--
-- Indexes for table `sewa`
--
ALTER TABLE `sewa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_penyewa` (`id_penyewa`);

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
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sewa`
--
ALTER TABLE `sewa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_perental`) REFERENCES `users` (`id`);

--
-- Constraints for table `sewa`
--
ALTER TABLE `sewa`
  ADD CONSTRAINT `sewa_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sewa_ibfk_2` FOREIGN KEY (`id_penyewa`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
