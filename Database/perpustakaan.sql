-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 07, 2025 at 12:05 PM
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
('BU24', '../assets/Buku/Pendidikan/SNBT.jpeg', 'Buku Pintar SNBT', 'Seleksi Nasional Berdasarkan Tes (SNBT) merupakan seleksi masuk Perquruan Tinggi Negeri yang didasarkan pada hasil tes masuk calon mahasiswa baru.', 'Tim Edukasi Indonesia', 'Bintang Wahyu', 2024, '520', 'Pendidikan', 1),
('KA21', '../assets/Buku/Non-Fiksi/Kala senja menyapa.jpeg', 'Kala Senja Menyapa', 'mengisahkan perjalanan emosional seorang gadis muda bernama Aira yang jatuh cinta pada sosok pria bernama Muhammad Rivaldo Al-Hussein. Rivaldo adalah pria tampan dan menawan, yang terkenal di sekolahnya karena senyuman manisnya dan ketampanannya yang tak terbantahkan.', 'Halimatus Sakdiyah, Aksara Bercerita, dan LKPP', 'CV Kanaka Media', 2021, '100', 'Non-Fiksi', 1),
('MO24', '../assets/Buku/Fantasi/MONS MALEFICIORUM.jpeg', 'Mons Maleficiorum', '\"Monstrum Maleficiorum\" menyelidiki dunia sihir dan okultisme, menjelaskan berbagai praktik sihir yang dianggap berbahaya dan terlarang. Buku ini menguraikan karakteristik dan perilaku penyihir, serta makhluk-makhluk jahat yang berhubungan dengan dunia gelap. Dalam konteks sejarah, buku ini sering digunakan sebagai panduan oleh para inkuisitor untuk mengidentifikasi dan menangkap penyihir.', 'Jonas', 'Shiddiq', 2024, '405', 'Fantasi', 1),
('ON97', '../assets/Buku/Komik/OP.jpeg', 'One Piece', 'bercerita tentang petualangan Monkey D. Luffy, seorang remaja yang bercita-cita menjadi Raja Bajak Laut. Luffy berlayar dari desanya untuk menemukan harta karun legendaris, One Piece. ', 'Eiichiro Oda', 'Weekly Shonen Jump', 1997, '208', 'Komik', 1),
('PS20', '../assets/Buku/Pendidikan/POM.jpeg', 'Psychology Of Money', 'The Psychology of Money karya Morgan Housel adalah buku yang memadukan psikologi dan keuangan, menggali secara mendalam tentang cara pandang manusia terhadap uang. Tak hanya itu, buku ini juga membahas bagaimana pola pikir ini mempengaruhi keputusan keuangan yang dibuat', 'Morgan Housel ', 'Harriman House Limited', 2020, '262', 'Pendidikan', 1),
('SO18', '../assets/Buku/Komik/Solo leveling.jpeg', 'Solo Leveling', 'Cerita ini berfokus pada karakter utama, Sung Jin-Woo, seorang Hunter tingkat rendah yang berjuang untuk bertahan hidup di dunia di mana monster dan makhluk supernatural mengancam umat manusia.\r\n\r\nCerita dimulai ketika Jin-Woo melakukan sebuah misi yang sangat berbahaya dan mengalami kejadian yang mengubah hidupnya, setelahnya dia mendapatkan akses ke sistem level-up yang memungkinkan dia untuk meningkatkan kekuatannya secara drastis. Dengan kemampuan ini, Jin-Woo mulai \"menlevel up\" dan mengejar kekuatan, yang membawanya ke dalam berbagai pertarungan melawan monster yang kuat dan menjelajahi dungeon berbahaya.', 'Chugong & Dubu (SIU)', 'Tappytoon & Yen Press', 2018, '520', 'Komik', 1),
('SP19', '../assets/Buku/Komik/sxf.jpeg', 'Spy X Family', 'kisah tentang seorang agen mata-mata yang membentuk keluarga palsu untuk menjalankan misi. Cerita ini berlatar belakang dunia fiksi yang sedang berperang dingin. ', 'Tatsuya Endo', 'Shueisha ', 2019, '212', 'Komik', 1);

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
  `Email` varchar(50) NOT NULL,
  `cover` varchar(255) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `pengarang` varchar(50) NOT NULL,
  `penerbit` varchar(50) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `status` enum('Menunggu Konfirmasi','Dipinjam','Dikembalikan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Menunggu Konfirmasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pinjam`
--

INSERT INTO `pinjam` (`id_pinjam`, `id_user`, `id_buku`, `username`, `Email`, `cover`, `judul`, `pengarang`, `penerbit`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
(71, 'SH0004', ' SO18 ', 'shiddiq211', 'Shiddiqduasatu@gmail.com', '../assets/Buku/Komik/Solo leveling.jpeg', 'Solo Leveling', 'Chugong & Dubu (SIU)', 'Tappytoon & Yen Press', '2025-02-14', '2025-02-16', 'Dikembalikan'),
(72, 'SH0004', ' SP19 ', 'shiddiq211', 'Shiddiqduasatu@gmail.com', '../assets/Buku/Komik/sxf.jpeg', 'Spy X Family', 'Tatsuya Endo', 'Shueisha ', '2025-02-14', '2025-02-15', 'Dikembalikan'),
(79, 'SH0004', ' KA21 ', 'shiddiq211', 'Shiddiqduasatu@gmail.com', '../assets/Buku/Non-Fiksi/Kala senja menyapa.jpeg', 'Kala Senja Menyapa', 'Halimatus Sakdiyah, Aksara Bercerita, dan LKPP', 'CV Kanaka Media', '2025-02-26', '2025-02-28', 'Dikembalikan'),
(80, 'LE0002', ' MO24 ', 'LebahGans', 'libratech21@gmail.com', '../assets/Buku/Fantasi/MONS MALEFICIORUM.jpeg', 'Mons Maleficiorum', 'Jonas', 'Shiddiq', '2025-02-27', '2025-02-27', 'Dikembalikan');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int NOT NULL,
  `id_buku` varchar(50) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `username` varchar(10) NOT NULL,
  `rating` int DEFAULT '0',
  `ulasan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `id_buku`, `judul`, `username`, `rating`, `ulasan`) VALUES
(2, 'KA21', 'Kala Senja Menyapa', 'People', 4, 'WAAAAA SO SWEET'),
(18, 'SO18', 'Solo Leveling', 'Shiddiq211', 3, 'KEREEEEN'),
(22, 'KA21', 'Kala Senja Menyapa', 'shiddiq211', 5, 'Romantis Banget'),
(23, 'KA21', 'Kala Senja Menyapa', 'LebahGans', 1, 'APANSIH\r\n'),
(24, 'MO24', 'Mons Maleficiorum', 'LebahGans', 3, 'Lumayan lah');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Email` varchar(250) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nomorhp` varchar(15) NOT NULL DEFAULT '0',
  `role` enum('Admin','Anggota') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Anggota',
  `verify` tinyint NOT NULL DEFAULT '0',
  `verify_nohp` tinyint NOT NULL DEFAULT '0',
  `if_visible` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `Email`, `username`, `password`, `nomorhp`, `role`, `verify`, `verify_nohp`, `if_visible`) VALUES
('0', 'admin@gmail.com', 'Admin', '$2y$10$Hv691UPJqS9vEL40f/v2iud7eK8gJENtWvzokm218o79pRhWuXLcS', '0', 'Admin', 1, 0, 0),
('LE0002', 'libratech21@gmail.com', 'LebahGans', '$2y$10$7SYwanfsrthZ11/7gkAPwuPolf31yWRIcTUnI4aoyksdzGpxW8psm', '0', 'Anggota', 1, 0, 1),
('SH0004', 'Shiddiqduasatu@gmail.com', 'shiddiq211', '$2y$10$dmU4wZ3ltXGtAm8TgFYAx.CP7m8IRyFsjBkzDDvWencxctchWlaAC', '0853-2060-2504', 'Anggota', 1, 0, 1);

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
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id_pinjam` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
