-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 05, 2025 at 12:21 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` varchar(10) NOT NULL,
  `cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `judul` varchar(50) NOT NULL,
  `deskripsi` longtext NOT NULL,
  `pengarang` varchar(50) NOT NULL,
  `penerbit` varchar(50) NOT NULL,
  `tahun_terbit` year NOT NULL,
  `halaman` varchar(30) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `if_visible` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `cover`, `judul`, `deskripsi`, `pengarang`, `penerbit`, `tahun_terbit`, `halaman`, `kategori`, `if_visible`) VALUES
('BU10', '../assets/Buku/SNBT.jpeg', 'Buku Pintar SNBT', 'Buku Belajar Persiapan SNBT', 'Shiddiq', 'Firdaus', 2010, '211', 'Pendidikan', 0),
('BU22', '../assets/Buku/SNBT.jpeg', 'Buku Pintar SNBT', '', 'Shiddiq', 'Firdaus', 2022, '20', 'Pendidikan', 0),
('ON97', '../assets/Buku/OP.jpeg', 'One Piece', 'One Piece adalah manga Jepang yang ditulis dan diilustrasikan oleh Eiichiro Oda, mengikuti petualangan Monkey D. Luffy dan krunya dalam pencarian harta karun legendaris, One Piece, untuk menjadi Raja Bajak Laut. Cerita ini kaya akan tema persahabatan, petualangan, dan imajinasi.', 'Eiichiro Oda', 'Shueisha', 1997, '220', 'Komik', 1),
('P01', '../assets/Buku/POM.jpeg', 'Psychology Of Money', '-', 'Shiddiq', 'Eka', 2001, '21', 'Pendidikan', 1),
('PE17', '../assets/Buku/PKN.jpeg', 'Pendidikan Kewarganegaraan', '', 'Shiddiq', 'Andri', 2017, '320', 'Pendidikan', 1),
('SE18', '../assets/Buku/senbud.jpeg', 'Seni Budaya', '', 'Asep', 'Shiddiq', 2018, '222', 'Pendidikan', 1),
('SO19', '../assets/Buku/Solo leveling.jpeg', 'Solo Leveling', 'Solo Leveling adalah sebuah manhwa aksi-fantasi yang mengikuti petualangan Sung Jin-Woo, seorang pemburu terlemah yang secara misterius mendapatkan kemampuan untuk meningkatkan kekuatannya tanpa batas. Setelah mengalami insiden mengerikan dalam sebuah dungeon berbahaya, Jin-Woo menemukan dirinya memiliki sistem leveling yang mirip dengan game RPG, yang memungkinkannya untuk menjadi lebih kuat dan menyelesaikan berbagai misi. Kisah ini menampilkan pertempuran epik, peningkatan kekuatan yang menakjubkan, dan perjalanan Jin-Woo untuk menjadi pemburu terkuat di dunia.', 'Shiddiq', 'Firdaus', 2019, '200', 'Komik', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kat` int NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `Deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kat`, `nama_kategori`, `Deskripsi`) VALUES
(2, 'Fiksi', 'Buku yang berisi cerita imajinatif dan tidak berdasarkan fakta nyata.'),
(3, 'Non-Fiksi', 'Buku yang berisi informasi dan fakta yang dapat diverifikasi.'),
(4, 'Biografi', 'Buku yang menceritakan kehidupan seseorang.'),
(5, 'Fantasi', 'Buku yang mengandung elemen magis dan dunia yang tidak nyata.'),
(6, 'Ilmiah', 'Buku yang membahas topik-topik ilmiah dan penelitian.'),
(7, 'Sejarah', 'Buku yang membahas peristiwa-peristiwa masa lalu.'),
(8, 'Pendidikan', 'Buku yang ditujukan untuk tujuan pembelajaran dan pendidikan.'),
(9, 'Kesehatan', 'Buku yang membahas topik-topik terkait kesehatan dan kebugaran.'),
(10, 'Anak-anak', 'Buku yang ditujukan untuk pembaca muda dan anak-anak'),
(11, 'Komik', 'Buku yang berisi gambar dan cerita dalam format komik.');

-- --------------------------------------------------------

--
-- Table structure for table `kembali`
--

CREATE TABLE `kembali` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `id_buku` int NOT NULL,
  `judul` varchar(50) NOT NULL,
  `status` enum('Dikembalikan','Belum Dikembalikan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pinjam`
--

CREATE TABLE `pinjam` (
  `id_pinjam` int NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `id_buku` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `pengarang` varchar(50) NOT NULL,
  `penerbit` varchar(50) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `status` enum('Menunggu Konfirmasi','Dipinjam','Dikembalikan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Menunggu Konfirmasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Email` varchar(250) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` enum('Admin','Anggota') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Anggota',
  `verify` tinyint NOT NULL DEFAULT '0',
  `if_visible` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `Email`, `username`, `password`, `role`, `verify`, `if_visible`) VALUES
('0', 'admin@gmail.com', 'Admin', '$2y$10$Hv691UPJqS9vEL40f/v2iud7eK8gJENtWvzokm218o79pRhWuXLcS', 'Admin', 1, 0),
('SH0001', 'shiddiqduasatu@gmail.com', 'shiddiq211', '$2y$10$binS3HEHBTGax.TrfL3ByewbcaboAowQmJRIf0N5Fl4.ANCClvnia', 'Anggota', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kat`);

--
-- Indexes for table `kembali`
--
ALTER TABLE `kembali`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user` (`id_user`),
  ADD UNIQUE KEY `id_buku` (`id_buku`);

--
-- Indexes for table `pinjam`
--
ALTER TABLE `pinjam`
  ADD PRIMARY KEY (`id_pinjam`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `kembali`
--
ALTER TABLE `kembali`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pinjam`
--
ALTER TABLE `pinjam`
  MODIFY `id_pinjam` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
