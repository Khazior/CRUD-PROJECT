-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Mar 06, 2026 at 08:05 AM
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
-- Database: `db_perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `idBuku` varchar(12) NOT NULL COMMENT 'must be unique id',
  `namaBuku` varchar(255) NOT NULL,
  `tahunTerbit` varchar(12) NOT NULL,
  `pengarang` varchar(255) NOT NULL,
  `idKategori` varchar(12) NOT NULL,
  `gambar_sampul` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`idBuku`, `namaBuku`, `tahunTerbit`, `pengarang`, `idKategori`, `gambar_sampul`) VALUES
('B001', 'Petualangan di Desa Pelangi', '2021', 'Budi Santoso', '3', 'colorful-rainbow-appearing-sky-nature-landscape.jpg'),
('B002', 'Rahasia Kotak Musik Tua', '2019', 'Rina Wijaya', '3', 'heart-shaped-books-placed-retro-radio-receivers-with-dried-flowers-them.jpg'),
('B003', 'Sahabat Langit', '2022', 'Ahmad Fuadi', '3', 'group-happy-people-playing-summer-sunset-nature.jpg'),
('B004', 'Misteri Robot Kicil', '2023', 'Deni Setiawan', '3', 'Macro robotic insect AI-generated image.png'),
('B005', 'Belajar Jujur dari Kancil', '2018', 'Sri Mulyani', '3', 'Storybook design with deers by the river Free Vector.png'),
('B006', 'Gema di Balik Lembah', '2020', 'Pramoedya A.', '1', 'Adventure hike in the mountain range Free Vector.png'),
('B007', 'Senja di Kota Tua', '2018', 'Sapardi Djoko', '1', 'Breathtaking shot of a sunset along the street in the middle of a modern city Free Photo.png'),
('B008', 'Labirin Takdir', '2021', 'Dee Lestari', '1', 'Risk management concept flat 3d web Free Vector.png'),
('B009', 'Perempuan yang Menunggu Hujan', '2019', 'Eka Kurniawan', '1', 'Flat design urban lifestyle illustration Free Vector.png'),
('B010', 'Melodi Terakhir', '2022', 'Tere Liye', '1', 'Flat background for world music day celebration Free Vector.png'),
('B011', 'Membangun Kebiasaan Kecil', '2021', 'James Clear', '2', 'Medium shot woman working with wood Free Photo.png'),
('B012', 'Filosofi Teras', '2019', 'Henry Manampiring', '2', 'Filosofi-Teras.png'),
('B013', 'Rahasia Investasi Saham', '2022', 'Lo Kheng Hong', '2', 'Two young worker leading business meeting about cryptocurrencies in an office Free Photo.png'),
('B014', 'Seni Berbicara di Depan Publik', '2018', 'Dale Carnegie', '2', 'Medium shot young pastor preaching at church Free Photo.png'),
('B015', 'Panduan Menulis Kreatif', '2017', 'AS Laksana', '2', 'Colorful and overloaded bullet journal Free Photo.png');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idKategori` varchar(12) NOT NULL,
  `namaKategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idKategori`, `namaKategori`) VALUES
('1', 'Buku Fiksi'),
('2', 'Buku Non-Fiksi'),
('3', 'Buku Anak & Remaja');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT '''user''',
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `role`, `password`, `created_at`) VALUES
(1, 'admin', 'admin', '$2y$10$eTCpYgHNA46fFc7..2a4A.x0pOLRH.LOTs6fWWB00nC7d5AD72lje', '2026-03-06 06:56:46'),
(2, 'user', 'user', '$2y$10$7lVEBAH.XdSHV.v/3kzTa.jzvPta3QdXBpk7mazkOgMB/c9a1CG66', '2026-03-06 06:56:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`idBuku`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idKategori`);

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
