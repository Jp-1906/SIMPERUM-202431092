-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2026 at 07:26 AM
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
-- Database: `simperum`
--

-- --------------------------------------------------------

--
-- Table structure for table `galeri_rumah`
--

CREATE TABLE `galeri_rumah` (
  `id_galeri` int(11) NOT NULL,
  `id_rumah` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pemesanan` int(11) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `status_verifikasi` enum('pending','valid','ditolak') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id_pemesanan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_rumah` int(11) NOT NULL,
  `tanggal_pemesanan` date DEFAULT NULL,
  `status` enum('pending','disetujui','ditolak') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penugasan_tukang`
--

CREATE TABLE `penugasan_tukang` (
  `id_penugasan` int(11) NOT NULL,
  `id_rumah` int(11) NOT NULL,
  `id_tukang` int(11) NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status_kerja` enum('aktif','selesai') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penugasan_tukang`
--

INSERT INTO `penugasan_tukang` (`id_penugasan`, `id_rumah`, `id_tukang`, `tanggal_mulai`, `tanggal_selesai`, `status_kerja`) VALUES
(3, 1, 2, '2026-06-18', NULL, 'aktif'),
(5, 3, 3, '2026-06-18', NULL, 'aktif'),
(6, 6, 4, '2026-06-18', NULL, 'aktif'),
(7, 6, 2, '2026-06-18', NULL, 'aktif'),
(9, 3, 2, '2026-06-18', NULL, 'aktif'),
(10, 6, 3, '2026-06-18', NULL, 'aktif'),
(11, 8, 2, '2026-06-19', NULL, 'aktif'),
(12, 8, 3, '2026-06-19', NULL, 'aktif'),
(14, 4, 4, '2026-06-02', '2026-06-08', 'selesai');

-- --------------------------------------------------------

--
-- Table structure for table `progress_pembangunan`
--

CREATE TABLE `progress_pembangunan` (
  `id_progress` int(11) NOT NULL,
  `id_rumah` int(11) NOT NULL,
  `persentase` int(11) NOT NULL,
  `status_progress` enum('belum_dimulai','berjalan','selesai') DEFAULT 'berjalan',
  `deskripsi` text DEFAULT NULL,
  `foto_progress` varchar(255) DEFAULT NULL,
  `tanggal_progress` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress_pembangunan`
--

INSERT INTO `progress_pembangunan` (`id_progress`, `id_rumah`, `persentase`, `status_progress`, `deskripsi`, `foto_progress`, `tanggal_progress`) VALUES
(1, 1, 40, 'berjalan', 'Pondasi dan Dinding telah selesai.', 'pondasi dan dinding R01.jpg', '2026-06-18'),
(2, 3, 20, 'berjalan', 'Fondasi selesai', 'pondasi R01.jpg', '2026-06-18'),
(3, 6, 20, 'berjalan', 'Fondasi Selesai', 'pondasi R01.jpg', '2026-06-18'),
(4, 8, 40, 'berjalan', 'pondasi dan dinding telah selesai', 'pondasi dan dinding R01.jpg', '2026-06-19'),
(5, 4, 100, 'selesai', 'SELESAI', 'rumah R03.png', '2026-06-08'),
(6, 5, 100, 'selesai', 'SELESAI', 'rumah R04.png', '2026-06-11'),
(7, 7, 70, 'berjalan', 'Masih belum di cat', 'dawsjnerkjawbweae.jpg', '2026-06-19'),
(8, 10, 100, 'selesai', 'SELESAI', 'rumah R08.png', '2026-06-15');

-- --------------------------------------------------------

--
-- Table structure for table `rumah`
--

CREATE TABLE `rumah` (
  `id_rumah` int(11) NOT NULL,
  `kode_rumah` varchar(10) NOT NULL,
  `alamat` text NOT NULL,
  `luas_tanah` int(11) NOT NULL,
  `luas_bangunan` int(11) NOT NULL,
  `jumlah_kamar` int(11) NOT NULL,
  `jumlah_kamar_mandi` int(11) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `status` enum('tersedia','dipesan','dibangun','terjual') DEFAULT 'tersedia',
  `foto_rumah` varchar(255) DEFAULT NULL,
  `denah_rumah` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `posisi_x` int(11) DEFAULT 0,
  `posisi_y` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rumah`
--

INSERT INTO `rumah` (`id_rumah`, `kode_rumah`, `alamat`, `luas_tanah`, `luas_bangunan`, `jumlah_kamar`, `jumlah_kamar_mandi`, `harga`, `status`, `foto_rumah`, `denah_rumah`, `deskripsi`, `posisi_x`, `posisi_y`) VALUES
(1, 'R01', 'Blok A No 1', 72, 45, 3, 1, 350000000, 'dibangun', 'rumah R01.png', 'denah rumah R01.png', 'Rumah minimalis modern warna putih', 50, 30),
(3, 'R02', 'Blok A No 2', 68, 50, 3, 2, 400000000, 'dibangun', 'rumah R02.png', 'denah rumah R02.png', 'Rumah Minimalis Modern warna emas', 150, 30),
(4, 'R03', 'Blok A No 3', 65, 76, 4, 2, 375000000, 'tersedia', 'rumah R03.png', 'denah rumah R03.png', 'Rumah luas berwarna abu-abu dan atap merah', 250, 30),
(5, 'R04', 'Blok A No 4', 45, 65, 2, 1, 449000000, 'terjual', 'rumah R04.png', 'denah rumah R04.png', 'rumah modern dengan atap merah', 150, 180),
(6, 'R05', 'Blok A No 5', 40, 55, 2, 1, 300000000, 'dibangun', 'rumah R05.png', 'denah rumah R05.png', 'Rumah Minimalis Warna Hijau', 150, 280),
(7, 'R06', 'Blok A No 6', 56, 76, 4, 2, 550000000, 'dipesan', 'rumah R06.png', 'denah rumah R06.png', 'Rumah dengan Vibes Kerajaan', 300, 180),
(8, 'R07', 'Blok A No 7', 58, 74, 3, 2, 525000000, 'dipesan', 'rumah R07.png', 'denah rumah R07.png', 'Rumah modern dengan warna hitam putih', 400, 180),
(10, 'R08', 'Blok A No 8', 57, 65, 3, 2, 475000000, 'terjual', 'rumah R08.png', 'denah rumah R08 (1).png', 'Rumah Modern Berwarna Biru Navy', 500, 180);

-- --------------------------------------------------------

--
-- Table structure for table `tukang`
--

CREATE TABLE `tukang` (
  `id_tukang` int(11) NOT NULL,
  `nama_tukang` varchar(100) NOT NULL,
  `spesialisasi` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tukang`
--

INSERT INTO `tukang` (`id_tukang`, `nama_tukang`, `spesialisasi`, `no_hp`, `alamat`, `foto_profil`) VALUES
(2, 'Budi', 'Mandor', '08123456789', 'Cengkareng', 'Budi.jpg'),
(3, 'Joko', 'Tukang Listrik', '08987654321', 'Bekasi', 'Joko.jpg'),
(4, 'Andi', 'Tukang Cat', '08234567891', 'Banjarmasin', 'Andi.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin@simperum.com', '0192023a7bbd73250516f069df18b500', 'admin', '2026-06-17 16:49:18'),
(2, 'Naufal', 'naufal@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-06-17 16:53:16'),
(3, 'Glenn', 'Glenn@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-06-18 15:25:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `galeri_rumah`
--
ALTER TABLE `galeri_rumah`
  ADD PRIMARY KEY (`id_galeri`),
  ADD KEY `id_rumah` (`id_rumah`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pemesanan` (`id_pemesanan`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_rumah` (`id_rumah`);

--
-- Indexes for table `penugasan_tukang`
--
ALTER TABLE `penugasan_tukang`
  ADD PRIMARY KEY (`id_penugasan`),
  ADD KEY `id_rumah` (`id_rumah`),
  ADD KEY `id_tukang` (`id_tukang`);

--
-- Indexes for table `progress_pembangunan`
--
ALTER TABLE `progress_pembangunan`
  ADD PRIMARY KEY (`id_progress`),
  ADD KEY `id_rumah` (`id_rumah`);

--
-- Indexes for table `rumah`
--
ALTER TABLE `rumah`
  ADD PRIMARY KEY (`id_rumah`),
  ADD UNIQUE KEY `kode_rumah` (`kode_rumah`);

--
-- Indexes for table `tukang`
--
ALTER TABLE `tukang`
  ADD PRIMARY KEY (`id_tukang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `galeri_rumah`
--
ALTER TABLE `galeri_rumah`
  MODIFY `id_galeri` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id_pemesanan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penugasan_tukang`
--
ALTER TABLE `penugasan_tukang`
  MODIFY `id_penugasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `progress_pembangunan`
--
ALTER TABLE `progress_pembangunan`
  MODIFY `id_progress` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rumah`
--
ALTER TABLE `rumah`
  MODIFY `id_rumah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tukang`
--
ALTER TABLE `tukang`
  MODIFY `id_tukang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `galeri_rumah`
--
ALTER TABLE `galeri_rumah`
  ADD CONSTRAINT `galeri_rumah_ibfk_1` FOREIGN KEY (`id_rumah`) REFERENCES `rumah` (`id_rumah`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanan` (`id_pemesanan`) ON DELETE CASCADE;

--
-- Constraints for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD CONSTRAINT `pemesanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `pemesanan_ibfk_2` FOREIGN KEY (`id_rumah`) REFERENCES `rumah` (`id_rumah`);

--
-- Constraints for table `penugasan_tukang`
--
ALTER TABLE `penugasan_tukang`
  ADD CONSTRAINT `penugasan_tukang_ibfk_1` FOREIGN KEY (`id_rumah`) REFERENCES `rumah` (`id_rumah`) ON DELETE CASCADE,
  ADD CONSTRAINT `penugasan_tukang_ibfk_2` FOREIGN KEY (`id_tukang`) REFERENCES `tukang` (`id_tukang`) ON DELETE CASCADE;

--
-- Constraints for table `progress_pembangunan`
--
ALTER TABLE `progress_pembangunan`
  ADD CONSTRAINT `progress_pembangunan_ibfk_1` FOREIGN KEY (`id_rumah`) REFERENCES `rumah` (`id_rumah`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
