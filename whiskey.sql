-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2025 at 03:43 PM
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
-- Database: `whiskey`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoption_applications`
--

CREATE TABLE `adoption_applications` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL COMMENT 'Nama kucing yang diadopsi',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `residence_type` enum('apartment','house') NOT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption_applications`
--

INSERT INTO `adoption_applications` (`id`, `cat_name`, `first_name`, `last_name`, `email`, `phone_number`, `city`, `postal_code`, `residence_type`, `application_date`, `status`) VALUES
(6, 'Tob', 'Nathania', 'Tabemono', 'c14240027@john.petra.ac.id', '081233169218', 'Surabaya', '132456', 'house', '2025-11-25 12:13:30', 'pending'),
(7, 'GitHub Cat', 'Nathania', 'Tabemono', 'github@mail.com', '0813472982', 'Mars', '132456', 'house', '2025-11-25 13:04:29', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `cats`
--

CREATE TABLE `cats` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` varchar(50) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `backstory` text NOT NULL,
  `bg_color` varchar(50) NOT NULL DEFAULT 'bg-soft-pink',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cats`
--

INSERT INTO `cats` (`id`, `name`, `age`, `gender`, `image_url`, `backstory`, `bg_color`, `created_at`) VALUES
(1, 'Puti', '2 years', 'female', 'img/puti.jpg', 'Puti adalah kucing yang pemalu namun penyayang. Ia suka berjemur di dekat jendela dan cocok dengan rumah yang tenang.', 'bg-soft-pink', '2025-11-25 09:20:57'),
(2, 'Moka', '2 years', 'female', 'img/moka.jpg', 'Moka adalah kucing yang penuh energi dan selalu penasaran. Ia membutuhkan banyak mainan dan interaksi aktif setiap hari.', 'bg-soft-yellow', '2025-11-25 09:20:57'),
(3, 'Tob', '1 year', 'male', 'img/tob.jpg', 'Tob sangat tenang dan lembut. Ia suka tidur dan sangat penyabar, menjadikannya teman yang sempurna untuk keluarga.', 'bg-soft-pink', '2025-11-25 09:20:57'),
(4, 'Snow', '1 year', 'male', 'img/snow.jpg', 'Snow diselamatkan dari lingkungan tempat tinggal yang kurang terawat. Saat pertama kali datang ke Whiskey, dia tampak sehat tapi sangat sensitif terhadap lingkungan baru. Snow kucing yang tenang dan cenderung menjaga jarak dari orang asing. Dia butuh waktu dan pendekatan lembut untuk merasa aman.', 'bg-soft-yellow', '2025-11-25 09:20:57'),
(5, 'Oreo', '6 months', 'male', 'img/oreo.jpg', 'Oreo adalah anak kucing yang baru diselamatkan. Dia sangat suka bermain dan butuh teman di rumah barunya.', 'bg-soft-pink', '2025-11-25 09:20:57'),
(6, 'Luna', '3 years', 'female', 'img/luna.jpg', 'Luna adalah kucing senior yang mencari tempat peristirahatan yang damai. Dia butuh kesabaran ekstra dan perhatian lembut.', 'bg-soft-yellow', '2025-11-25 09:20:57'),
(8, 'GitHub Cat', '1 year', 'female', 'img/cats/img_69259e2ae83c1.png', 'GitHub Cat?', 'bg-soft-pink', '2025-11-25 12:16:42');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `proof_image_url` varchar(255) DEFAULT NULL,
  `donation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `amount`, `payment_method`, `proof_image_url`, `donation_date`) VALUES
(3, 500000, '1234567890 (Mandiri)', 'uploads/proofs/donation_20251125_131419.png', '2025-11-25 12:14:19'),
(4, 100000, '1234567890 (Mandiri)', 'uploads/proofs/donation_20251125_140448.jpg', '2025-11-25 13:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `education_content`
--

CREATE TABLE `education_content` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) NOT NULL,
  `publish_date` date NOT NULL,
  `category` enum('Tips','Health','Behavior') NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `teaser_content` text NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `education_content`
--

INSERT INTO `education_content` (`id`, `title`, `author`, `publish_date`, `category`, `image_url`, `teaser_content`, `content`, `created_at`) VALUES
(1, 'Apa saja makanan yang tidak boleh dimakan kucing?', 'Writer', '2025-11-12', 'Health', 'img/kucingMakan.png', 'Ini dia 5 makanan yang dikira menyehatkan tetapi malah dilarang...', 'Ini dia 5 makanan yang dikira menyehatkan tetapi malah dilarang untuk dimakan oleh kucing! Coklat, Anggur, Bawang, Susu Sapi, dan Alkohol adalah musuh utama.', '2025-11-25 09:20:37'),
(2, 'Tips Merawat Kucing dengan Baik', 'Writer', '2025-11-12', 'Tips', 'img/tipsmerawatkucing.png', 'Yuk ketahui cara yang benar dalam merawat kucing kamu!', 'Penjelasan lengkap tentang cara merawat kucing, mulai dari grooming rutin, vaksinasi, hingga pemilihan pasir yang tepat.', '2025-11-25 09:20:37'),
(3, 'Bahasa Ekor Kucing', 'Writer', '2025-11-10', 'Behavior', 'img/artikelEkorKucing.avif', 'Ternyata ekor kucing bisa bicara lho! Pahami artinya di sini.', 'Ekor tegak berarti senang. Ekor mengembang berarti takut. Ekor berkedut berarti sedang fokus atau kesal.', '2025-11-25 09:20:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL COMMENT 'Gunakan fungsi hash aman untuk kata sandi',
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `full_name` varchar(150) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `email`, `role`, `full_name`, `created_at`) VALUES
(1, 'user', '*0D22657BD7E16A953E5DEF4EC9E5933C4931755C', 'user@example.com', 'user', 'Pengguna Biasa', '2025-11-25 09:22:17'),
(2, 'admin', '*01A6717B58FF5C7EAFFF6CB7C96F7428EA65FE4C', 'admin@example.com', 'admin', 'Administrator Sistem', '2025-11-25 09:22:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cats`
--
ALTER TABLE `cats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `education_content`
--
ALTER TABLE `education_content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption_applications`
--
ALTER TABLE `adoption_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cats`
--
ALTER TABLE `cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `education_content`
--
ALTER TABLE `education_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
