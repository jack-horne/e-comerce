-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2025 at 09:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_comerce_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`id_akun`, `id_user`, `username`, `password`, `role`) VALUES
(4, 1, 'admin@sekolah.com', '$2y$10$HrjiubpPQIeViMgg552fVuwGrG55vXXUMnbKyilQ7mHQnabCO1h.W', 'admin'),
(6, 3, 'besu@jojo.com', '$2y$10$XqcRNKO3wYQ5KWYExY2ZuuXiFFS7j8sb/F00thAtA4wrS7jAxQPZS', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail_penjualan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `harga` double(20,2) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `det_keranjang`
--

CREATE TABLE `det_keranjang` (
  `id_det_keranjang` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_keranjang` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kat_produk`
--

CREATE TABLE `kat_produk` (
  `id_kategori` int(11) NOT NULL,
  `nm_kategori` varchar(50) NOT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kat_produk`
--

INSERT INTO `kat_produk` (`id_kategori`, `nm_kategori`, `keterangan`) VALUES
(1, 'VGA Card', 'Kartu grafis untuk gaming dan rendering'),
(2, 'Processor', 'CPU untuk PC dan workstation'),
(3, 'Motherboard', 'Mainboard untuk PC'),
(4, 'RAM', 'Memory untuk PC'),
(5, 'Storage', 'SSD dan HDD'),
(6, 'Power Supply', 'PSU untuk PC'),
(7, 'Cooling', 'Pendingin CPU dan case');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tgl` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kd_invoice` varchar(100) NOT NULL,
  `total_harga` double(20,2) NOT NULL,
  `status_pembayaran` varchar(100) DEFAULT 'Belum Bayar',
  `status_pengiriman` varchar(100) DEFAULT 'Belum Dikirim'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `nm_produk` varchar(50) NOT NULL,
  `qyt` int(11) DEFAULT 0,
  `exp_date` date DEFAULT NULL,
  `kodisi` tinyint(1) DEFAULT 1,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `diskon` int(3) DEFAULT 0,
  `rate` int(11) DEFAULT NULL,
  `harga` double(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `id_supplier`, `nm_produk`, `qyt`, `exp_date`, `kodisi`, `deskripsi`, `gambar`, `diskon`, `rate`, `harga`) VALUES
(1, 1, 1, 'Gigabyte AORUS GeForce RTX 5090', 15, NULL, 1, 'MASTER ICE 32G - VGA Gaming Flagship dengan cooling terbaik', NULL, 5, 5, 35000000.00),
(2, 1, 1, 'MSI GeForce RTX 4080 SUPER', 8, NULL, 1, 'GAMING X TRIO 16GB - Perfect untuk 4K gaming', NULL, 10, 5, 18500000.00),
(3, 1, 2, 'ASUS ROG Strix RTX 4070 Ti', 12, NULL, 1, 'OC Edition 12GB - High performance dengan RGB', NULL, 8, 5, 12000000.00),
(4, 1, 3, 'AMD Radeon RX 7900 XTX', 10, NULL, 1, '24GB GDDR6 - Alternatif powerful untuk creator', NULL, 12, 5, 15000000.00),
(5, 2, 1, 'Intel Core i9-14900K', 20, NULL, 1, '24-Core 32-Thread - Fastest gaming processor', NULL, 5, 5, 8500000.00),
(6, 2, 2, 'AMD Ryzen 9 7950X', 18, NULL, 1, '16-Core 32-Thread - Beast untuk multitasking', NULL, 8, 5, 7800000.00),
(7, 2, 1, 'Intel Core i7-14700K', 25, NULL, 1, '20-Core 28-Thread - Sweet spot untuk gaming', NULL, 10, 5, 5500000.00),
(8, 2, 3, 'AMD Ryzen 7 7800X3D', 22, NULL, 1, '8-Core dengan 3D V-Cache - Best gaming CPU', NULL, 7, 5, 5200000.00),
(9, 3, 2, 'ASUS ROG Maximus Z790 Hero', 10, NULL, 1, 'ATX untuk Intel Gen 14 - Premium features', NULL, 5, 5, 7500000.00),
(10, 3, 1, 'MSI MPG X670E Carbon WiFi', 12, NULL, 1, 'ATX untuk AMD Ryzen 7000 - PCIe 5.0 ready', NULL, 8, 5, 6200000.00),
(11, 3, 3, 'Gigabyte B760 AORUS Elite', 30, NULL, 1, 'ATX budget friendly dengan fitur lengkap', NULL, 12, 5, 2800000.00),
(12, 4, 2, 'Corsair Dominator Platinum RGB', 40, NULL, 1, '32GB (2x16GB) DDR5-6000 - Premium RAM', NULL, 10, 5, 3200000.00),
(13, 4, 1, 'G.Skill Trident Z5 RGB', 35, NULL, 1, '32GB (2x16GB) DDR5-6400 - High speed gaming', NULL, 8, 5, 2900000.00),
(14, 4, 3, 'Kingston Fury Beast RGB', 50, NULL, 1, '16GB (2x8GB) DDR4-3600 - Best value', NULL, 15, 5, 950000.00),
(15, 5, 1, 'Samsung 990 PRO 2TB', 25, NULL, 1, 'NVMe Gen4 - Ultra fast read/write', NULL, 10, 5, 3500000.00),
(16, 5, 2, 'WD Black SN850X 1TB', 30, NULL, 1, 'NVMe Gen4 - Gaming optimized', NULL, 12, 5, 1800000.00),
(17, 5, 3, 'Crucial P3 Plus 500GB', 45, NULL, 1, 'NVMe Gen4 - Budget friendly option', NULL, 15, 5, 750000.00),
(18, 6, 1, 'Corsair HX1000i 1000W', 15, NULL, 1, '80+ Platinum Modular - Ultra reliable', NULL, 5, 5, 3200000.00),
(19, 6, 2, 'Seasonic FOCUS GX-850 850W', 20, NULL, 1, '80+ Gold Modular - Great efficiency', NULL, 8, 5, 2100000.00),
(20, 6, 4, 'ASUS TUF Gaming 750W', 28, NULL, 1, '80+ Bronze - Reliable budget PSU', NULL, 10, 5, 1200000.00),
(21, 7, 2, 'NZXT Kraken Z73 RGB', 12, NULL, 1, 'AIO 360mm dengan LCD display - Premium cooling', NULL, 8, 5, 4500000.00),
(22, 7, 1, 'Noctua NH-D15 chromax.black', 18, NULL, 1, 'Air cooler legendaris - Silent & powerful', NULL, 5, 5, 1800000.00),
(23, 7, 3, 'Cooler Master Hyper 212 RGB', 35, NULL, 1, 'Air cooler budget - Best seller', NULL, 12, 5, 550000.00),
(31, 1, 1, 'Gigabyte AORUS GeForce RTX 5090', 15, NULL, 1, 'MASTER ICE 32G - VGA Gaming Flagship dengan cooling terbaik', NULL, 5, 5, 35000000.00),
(32, 1, 1, 'MSI GeForce RTX 4080 SUPER', 8, NULL, 1, 'GAMING X TRIO 16GB - Perfect untuk 4K gaming', NULL, 10, 5, 18500000.00),
(33, 1, 2, 'ASUS ROG Strix RTX 4070 Ti', 12, NULL, 1, 'OC Edition 12GB - High performance dengan RGB', NULL, 8, 5, 12000000.00),
(34, 1, 3, 'AMD Radeon RX 7900 XTX', 10, NULL, 1, '24GB GDDR6 - Alternatif powerful untuk creator', NULL, 12, 5, 15000000.00),
(35, 2, 1, 'Intel Core i9-14900K', 20, NULL, 1, '24-Core 32-Thread - Fastest gaming processor', NULL, 5, 5, 8500000.00),
(36, 2, 2, 'AMD Ryzen 9 7950X', 18, NULL, 1, '16-Core 32-Thread - Beast untuk multitasking', NULL, 8, 5, 7800000.00),
(37, 2, 1, 'Intel Core i7-14700K', 25, NULL, 1, '20-Core 28-Thread - Sweet spot untuk gaming', NULL, 10, 5, 5500000.00),
(38, 2, 3, 'AMD Ryzen 7 7800X3D', 22, NULL, 1, '8-Core dengan 3D V-Cache - Best gaming CPU', NULL, 7, 5, 5200000.00),
(39, 3, 2, 'ASUS ROG Maximus Z790 Hero', 10, NULL, 1, 'ATX untuk Intel Gen 14 - Premium features', NULL, 5, 5, 7500000.00),
(40, 3, 1, 'MSI MPG X670E Carbon WiFi', 12, NULL, 1, 'ATX untuk AMD Ryzen 7000 - PCIe 5.0 ready', NULL, 8, 5, 6200000.00),
(41, 3, 3, 'Gigabyte B760 AORUS Elite', 30, NULL, 1, 'ATX budget friendly dengan fitur lengkap', NULL, 12, 5, 2800000.00),
(42, 4, 2, 'Corsair Dominator Platinum RGB', 40, NULL, 1, '32GB (2x16GB) DDR5-6000 - Premium RAM', NULL, 10, 5, 3200000.00),
(43, 4, 1, 'G.Skill Trident Z5 RGB', 35, NULL, 1, '32GB (2x16GB) DDR5-6400 - High speed gaming', NULL, 8, 5, 2900000.00),
(44, 4, 3, 'Kingston Fury Beast RGB', 50, NULL, 1, '16GB (2x8GB) DDR4-3600 - Best value', NULL, 15, 5, 950000.00),
(45, 5, 1, 'Samsung 990 PRO 2TB', 25, NULL, 1, 'NVMe Gen4 - Ultra fast read/write', NULL, 10, 5, 3500000.00),
(46, 5, 2, 'WD Black SN850X 1TB', 30, NULL, 1, 'NVMe Gen4 - Gaming optimized', NULL, 12, 5, 1800000.00),
(47, 5, 3, 'Crucial P3 Plus 500GB', 45, NULL, 1, 'NVMe Gen4 - Budget friendly option', NULL, 15, 5, 750000.00),
(48, 6, 1, 'Corsair HX1000i 1000W', 15, NULL, 1, '80+ Platinum Modular - Ultra reliable', NULL, 5, 5, 3200000.00),
(49, 6, 2, 'Seasonic FOCUS GX-850 850W', 20, NULL, 1, '80+ Gold Modular - Great efficiency', NULL, 8, 5, 2100000.00),
(50, 6, 4, 'ASUS TUF Gaming 750W', 28, NULL, 1, '80+ Bronze - Reliable budget PSU', NULL, 10, 5, 1200000.00),
(51, 7, 2, 'NZXT Kraken Z73 RGB', 12, NULL, 1, 'AIO 360mm dengan LCD display - Premium cooling', NULL, 8, 5, 4500000.00),
(52, 7, 1, 'Noctua NH-D15 chromax.black', 18, NULL, 1, 'Air cooler legendaris - Silent & powerful', NULL, 5, 5, 1800000.00),
(53, 7, 3, 'Cooler Master Hyper 212 RGB', 35, NULL, 1, 'Air cooler budget - Best seller', NULL, 12, 5, 551000.00);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nm_supplier` varchar(50) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(13) DEFAULT NULL,
  `kd_pos` varchar(6) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nm_supplier`, `alamat`, `no_telp`, `kd_pos`, `email`) VALUES
(1, 'PT Komputer Teknologi', 'Jakarta Pusat', '021-12345678', NULL, NULL),
(2, 'CV Gaming Hardware', 'Bandung', '022-87654321', NULL, NULL),
(3, 'Toko Sparepart PC Jaya', 'Surabaya', '031-11223344', NULL, NULL),
(4, 'Distributor PC Parts Indo', 'Tangerang', '021-99887766', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nm_user` varchar(50) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `tgl_komentar` date NOT NULL,
  `rate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nm_user` varchar(50) NOT NULL,
  `no_hp` varchar(13) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nm_user`, `no_hp`, `email`) VALUES
(1, 'Administrator', '081234567890', 'admin@pixelpart.com'),
(3, 'bejo sumerjo', '', 'besu@jojo.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_akun_user` (`id_user`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail_penjualan`),
  ADD KEY `idx_detail_penjualan_produk` (`id_produk`);

--
-- Indexes for table `det_keranjang`
--
ALTER TABLE `det_keranjang`
  ADD PRIMARY KEY (`id_det_keranjang`),
  ADD KEY `id_keranjang` (`id_keranjang`),
  ADD KEY `idx_det_keranjang_produk` (`id_produk`);

--
-- Indexes for table `kat_produk`
--
ALTER TABLE `kat_produk`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `idx_keranjang_user` (`id_user`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD UNIQUE KEY `kd_invoice` (`kd_invoice`),
  ADD KEY `idx_penjualan_user` (`id_user`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `idx_produk_kategori` (`id_kategori`),
  ADD KEY `idx_produk_supplier` (`id_supplier`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `idx_ulasan_produk` (`id_produk`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `id_detail_penjualan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `det_keranjang`
--
ALTER TABLE `det_keranjang`
  MODIFY `id_det_keranjang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kat_produk`
--
ALTER TABLE `kat_produk`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `akun`
--
ALTER TABLE `akun`
  ADD CONSTRAINT `akun_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON UPDATE CASCADE;

--
-- Constraints for table `det_keranjang`
--
ALTER TABLE `det_keranjang`
  ADD CONSTRAINT `det_keranjang_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `det_keranjang_ibfk_2` FOREIGN KEY (`id_keranjang`) REFERENCES `keranjang` (`id_keranjang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kat_produk` (`id_kategori`) ON UPDATE CASCADE,
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON UPDATE CASCADE;

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `ulasan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
