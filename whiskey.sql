-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2025 at 07:01 AM
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
(7, 'GitHub Cat', 'Nathania', 'Tabemono', 'github@mail.com', '0813472982', 'Mars', '132456', 'house', '2025-11-25 13:04:29', 'pending'),
(8, 'Puti', 'selin', 'selin', 'a@gmail.com', '129081201', 'sby', '84011', 'house', '2025-12-13 04:32:03', 'pending');

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
(4, 100000, '1234567890 (Mandiri)', 'uploads/proofs/donation_20251125_140448.jpg', '2025-11-25 13:04:48'),
(5, 100000, '081234567890 (OVO/Gopay)', 'uploads/proofs/donation_20251213_053127.jpg', '2025-12-13 04:31:27'),
(6, 100000, '1234567890 (Mandiri)', 'uploads/proofs/donation_20251213_085024.png', '2025-12-13 07:50:24');

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
(1, 'Apa saja makanan yang tidak boleh dimakan kucing?', 'Writer', '2025-11-12', 'Health', 'img/kucingMakan.png', 'Ini dia 5 makanan yang dikira menyehatkan tetapi malah dilarang...', 'Banyak pemilik kucing yang tanpa sadar memberikan makanan manusia kepada kucing peliharaannya dengan alasan ingin berbagi atau mengira makanan tersebut aman dan menyehatkan. Padahal, tidak semua makanan yang aman bagi manusia boleh dikonsumsi oleh kucing. Bahkan, beberapa di antaranya bisa sangat berbahaya dan mengancam kesehatan kucing.\r\n\r\nBerikut ini adalah 5 makanan yang sering dikira aman, tetapi sebenarnya dilarang untuk dimakan oleh kucing:\r\n\r\n1. Coklat\r\nCoklat mengandung zat bernama theobromine dan kafein yang sangat beracun bagi kucing. Meskipun kucing jarang tertarik pada coklat karena rasanya, jika tertelan sedikit saja dapat menyebabkan muntah, diare, jantung berdebar, kejang, hingga berujung kematian.\r\n\r\n2. Anggur dan Kismis\r\nAnggur, baik dalam bentuk segar maupun kering (kismis), dapat menyebabkan gangguan ginjal akut pada kucing. Hingga saat ini, penyebab pastinya belum diketahui, namun konsumsi dalam jumlah kecil saja sudah cukup berbahaya.\r\n\r\n3. Bawang (termasuk bawang merah dan bawang putih)\r\nBawang mengandung senyawa yang dapat merusak sel darah merah kucing. Konsumsi bawang secara terus-menerus maupun dalam jumlah besar dapat menyebabkan anemia, yang ditandai dengan lemas, nafsu makan menurun, dan gusi pucat.\r\n\r\n4. Susu Sapi\r\nBanyak orang menganggap susu adalah minuman sehat untuk kucing. Faktanya, sebagian besar kucing dewasa mengalami lactose intolerance, sehingga tidak mampu mencerna laktosa dengan baik. Akibatnya, kucing bisa mengalami diare, perut kembung, dan gangguan pencernaan.\r\n\r\n5. Alkohol\r\nAlkohol sangat beracun bagi kucing, bahkan dalam jumlah yang sangat kecil. Alkohol dapat menyebabkan gangguan pernapasan, kerusakan sistem saraf, penurunan kesadaran, hingga koma dan kematian.\r\n\r\nSebagai pemilik yang bertanggung jawab, penting untuk selalu memperhatikan makanan yang diberikan kepada kucing. Sebaiknya, kucing hanya diberi makanan khusus kucing yang sudah diformulasikan sesuai kebutuhan nutrisinya. Dengan begitu, kesehatan dan umur panjang kucing peliharaan dapat terjaga dengan baik.', '2025-11-25 09:20:37'),
(2, 'Tips Merawat Kucing dengan Baik', 'Writer', '2025-11-12', 'Tips', 'img/tipsmerawatkucing.png', 'Yuk ketahui cara yang benar dalam merawat kucing kamu!', 'Merawat kucing dengan baik merupakan tanggung jawab penting bagi setiap pemilik hewan peliharaan. Perawatan yang tepat tidak hanya membuat kucing terlihat bersih dan lucu, tetapi juga berperan besar dalam menjaga kesehatan fisik dan mentalnya. Berikut ini beberapa tips penting dalam merawat kucing dengan baik dan benar.\r\n\r\n1. Grooming Secara Rutin\r\nGrooming atau perawatan bulu perlu dilakukan secara rutin, terutama untuk kucing berbulu panjang. Menyisir bulu kucing secara teratur membantu mengurangi bulu rontok, mencegah kusut, serta mengurangi risiko hairball. Selain itu, memotong kuku, membersihkan telinga, dan memandikan kucing bila diperlukan juga termasuk bagian dari grooming.\r\n\r\n2. Vaksinasi dan Pemeriksaan Kesehatan\r\nVaksinasi sangat penting untuk melindungi kucing dari berbagai penyakit berbahaya seperti panleukopenia, calicivirus, dan rabies. Selain vaksinasi, lakukan pemeriksaan rutin ke dokter hewan agar kondisi kesehatan kucing selalu terpantau dan dapat ditangani lebih cepat jika terjadi masalah.\r\n\r\n3. Pemberian Makanan Bergizi\r\nPastikan kucing mendapatkan makanan yang sesuai dengan usia, berat badan, dan kondisi kesehatannya. Makanan khusus kucing telah diformulasikan dengan nutrisi yang dibutuhkan, seperti protein, vitamin, dan mineral. Hindari memberikan makanan manusia karena dapat berbahaya bagi kucing.\r\n\r\n4. Pemilihan Pasir Kucing yang Tepat\r\nPasir kucing berperan penting dalam menjaga kebersihan dan kenyamanan kucing. Pilih pasir yang memiliki daya serap tinggi, mampu mengurangi bau, dan tidak berdebu agar aman bagi saluran pernapasan kucing. Bersihkan kotak pasir secara rutin untuk mencegah bakteri dan bau tidak sedap.\r\n\r\n5. Lingkungan yang Nyaman dan Aman\r\nKucing membutuhkan lingkungan yang bersih, tenang, dan aman. Sediakan tempat tidur yang nyaman, area bermain, serta mainan untuk menstimulasi aktivitas fisik dan mentalnya. Lingkungan yang baik akan membantu kucing merasa lebih bahagia dan tidak mudah stres.\r\n\r\n6. Perhatian dan Kasih Sayang\r\nSelain perawatan fisik, kucing juga membutuhkan perhatian dan kasih sayang dari pemiliknya. Luangkan waktu untuk bermain dan berinteraksi dengan kucing agar ikatan emosional semakin kuat.\r\n\r\nDengan perawatan yang tepat dan konsisten, kucing akan tumbuh sehat, aktif, dan bahagia. Merawat kucing bukan hanya soal memberi makan, tetapi juga memastikan kesejahteraan hidupnya secara menyeluruh.', '2025-11-25 09:20:37'),
(3, 'Bahasa Ekor Kucing', 'Writer', '2025-11-10', 'Behavior', 'img/artikelEkorKucing.avif', 'Ternyata ekor kucing bisa bicara lho! Pahami artinya di sini.', 'Ekor kucing merupakan salah satu alat komunikasi penting yang sering digunakan kucing untuk mengekspresikan perasaan dan suasana hatinya. Dengan memperhatikan gerakan dan posisi ekor, pemilik dapat memahami kondisi emosional kucing dan berinteraksi dengannya dengan lebih tepat.\r\n\r\n1. Ekor Tegak\r\nKetika kucing mengangkat ekornya tegak ke atas, hal ini menandakan bahwa kucing sedang merasa senang, percaya diri, dan nyaman dengan lingkungannya. Biasanya, ekor tegak juga terlihat saat kucing menyapa pemiliknya atau saat ia merasa aman.\r\n\r\n2. Ekor Mengembang\r\nEkor yang mengembang atau terlihat besar menandakan bahwa kucing sedang merasa takut atau terancam. Gerakan ini merupakan bentuk refleks alami untuk membuat tubuhnya terlihat lebih besar guna melindungi diri dari bahaya. Pada kondisi ini, sebaiknya kucing diberi ruang dan tidak dipaksa untuk berinteraksi.\r\n\r\n3. Ekor Berkedut atau Bergerak Cepat\r\nJika ekor kucing terlihat berkedut atau bergerak cepat ke kiri dan kanan, hal ini bisa menandakan bahwa kucing sedang fokus, terstimulasi, atau mulai merasa kesal. Kondisi ini sering muncul saat kucing sedang bermain atau merasa terganggu, sehingga pemilik perlu lebih waspada.\r\n\r\nDengan memahami bahasa ekor kucing, pemilik dapat mengenali perasaan kucing dengan lebih baik dan menghindari kesalahpahaman saat berinteraksi. Perhatian terhadap gerakan ekor akan membantu menciptakan hubungan yang lebih harmonis antara kucing dan pemiliknya.', '2025-11-25 09:20:37'),
(7, 'Panduan Darurat: Menemukan Bayi Kucing Tanpa Induk di Jalanan', 'Writer', '2025-12-13', 'Tips', '../img/articles/img_693d0d6e55584.jpg', 'Ikuti langkah-langkah penyelamatan darurat ini untuk menjaga nyawa mereka.', 'Musim hujan seringkali menjadi masa sulit bagi kucing liar. Tak jarang kita menemukan bayi kucing (neonatal) yang terpisah dari induknya, kedinginan, dan kelaparan. Jika Anda memutuskan untuk menyelamatkan nyawa kecil ini, Anda harus bertindak cepat dan tepat.\r\n\r\n1. Hangatkan Tubuh Terlebih Dahulu! \r\nIni aturan emasnya: Jangan beri makan kitten yang tubuhnya dingin. Pencernaan mereka berhenti bekerja saat kedinginan. Jika dipaksa minum susu, mereka bisa kembung dan mati.\r\n- Bungkus kitten dengan kain flanel atau handuk kering.\r\n- Gunakan lampu belajar (bohlam kuning) untuk penghangat, atau masukkan air hangat ke dalam botol, bungkus botol dengan kain, dan letakkan di dekat kitten.\r\n\r\n2. Pantangan Susu Sapi \r\nSusu sapi mengandung laktosa tinggi yang menyebabkan diare parah pada kucing. Diare pada bayi kucing bisa menyebabkan dehidrasi fatal dalam hitungan jam.\r\nSolusi: Beli susu khusus kucing (cat milk replacer) di petshop. Jika darurat dan toko tutup, gunakan susu kambing murni atau susu steril (seperti Bear Brand) untuk sementara waktu, namun segera ganti ke susu khusus kucing secepatnya.\r\n\r\n3. Teknik Memberi Susu (Spuit/Dot) \r\nJangan menyuapi kitten seperti bayi manusia (telentang). Posisi kitten harus tengkurap (perut di bawah) seperti saat menyusu ke induknya. Gunakan pipet atau dot khusus. Teteskan perlahan agar tidak masuk ke paru-paru (aspirasi).\r\n\r\n4. Stimulasi Buang Air \r\nBayi kucing di bawah 3 minggu belum bisa pipis dan pup sendiri. Induknya biasa menjilati area genital untuk merangsangnya. Anda harus menggantikan peran ini dengan menggunakan kapas yang dibasahi air hangat. Usap lembut area genital dan anus setiap sebelum dan sesudah makan hingga mereka buang air.', '2025-12-13 06:53:34'),
(13, 'Mengenal Macan Akar: Kucing Hutan yang Dilindungi', 'Writer', '2025-12-15', 'Behavior', '../img/articles/img_693fa298a5f7e.jpg', 'Macan akar adalah kucing hutan mungil yang dilindungi karena populasinya terus menurun.', 'Macan akar, atau yang dikenal juga sebagai kucing hutan (Felis bengalensis), adalah satwa liar yang semakin menarik perhatian para pecinta hewan. Meskipun namanya mengandung kata “macan”, hewan ini berukuran kecil dan punya penampilan yang sangat mirip dengan kucing peliharaan di rumah. Namun, jangan tertipu oleh tampilannya yang menggemaskan. Macan akar adalah predator kecil yang hidup di alam liar dan punya peran penting dalam ekosistem. Yuk, kenali lebih dekat tentang apa itu macan akar, habitat alaminya, ciri-ciri fisik, alasan kenapa mereka dilindungi, hingga bagaimana manusia bisa membantu menjaga populasinya agar tidak punah.\r\n\r\nApa Itu Macan Akar?\r\nMacan akar merupakan sebutan lokal untuk kucing hutan Asia atau leopard cat (Felis bengalensis).  Hewan ini merupakan spesies kucing liar kecil yang tersebar luas di Asia, mulai dari India, Tiongkok, hingga Indonesia. Di Indonesia sendiri, macan akar bisa ditemukan di beberapa wilayah seperti Sumatera, Kalimantan, Jawa, dan Bali, meski populasinya semakin menyusut karena berbagai ancaman. Sebagai satwa liar, macan akar termasuk dalam daftar hewan yang dilindungi oleh pemerintah Indonesia melalui Peraturan Menteri Lingkungan Hidup dan Kehutanan. Perlindungan ini penting karena spesies ini berisiko tinggi mengalami penurunan populasi akibat perburuan, perdagangan ilegal, dan kerusakan habitat.\r\n\r\nCiri-Ciri Fisik Macan Akar\r\nMacan akar sering disalahartikan sebagai kucing peliharaan karena ukurannya yang kecil dan wajahnya yang lucu. Tapi sebenarnya ada beberapa perbedaan mencolok yang membuatnya unik:\r\n- Panjang tubuh berkisar antara 40–60 cm, dengan ekor sepanjang 20–30 cm.\r\n- Beratnya sekitar 3–7 kg.\r\n- Memiliki motif tutul-tutul hitam di sekujur tubuh seperti macan tutul mini.\r\n- Warna bulunya cokelat keemasan dengan garis-garis dan bintik gelap di bagian wajah, punggung, dan sisi tubuh.\r\n- Mata besar yang beradaptasi dengan penglihatan malam.\r\nDengan penampilannya yang eksotis, tak heran jika banyak orang tertarik untuk memelihara macan akar, meskipun hal ini sebenarnya dilarang karena statusnya sebagai satwa liar dilindungi.\r\n\r\nHabitat dan Kebiasaan Hidup Macan Akar\r\nMacan akar adalah hewan nokturnal yang aktif di malam hari. Mereka lebih suka hidup di hutan hujan tropis, pegunungan, hutan bakau, hingga wilayah pertanian yang dekat dengan hutan. Beberapa kebiasaan penting dari macan akar antara lain:\r\n- Pemangsa alami: Mereka memangsa tikus, burung, kadal, hingga serangga, sehingga punya peran penting dalam menjaga keseimbangan populasi hama.\r\n- Soliter dan teritorial: Biasanya hidup sendiri dan menjaga wilayahnya dari sesama kucing hutan.\r\n- Pemanjat ulung: Macan akar sangat ahli memanjat pohon untuk mencari makanan atau menghindari bahaya.\r\n- Sarang di tempat tersembunyi: Mereka sering membuat sarang di lubang pohon, semak lebat, atau celah bebatuan.\r\n\r\nSayangnya, perambahan hutan dan aktivitas manusia telah membuat habitat alami macan akar menyempit, memaksa mereka mendekati permukiman dan berisiko diburu.', '2025-12-15 05:54:32'),
(14, 'Panduan Merawat Anak Kucing yang Baru Lahir agar Tumbuh Sehat', 'Writer', '2025-12-15', 'Tips', '../img/articles/img_693fa39767cab.jpg', 'Anak kucing yang baru lahir terlihat menggemaskan, tetapi juga sangat rapuh sehingga perlu mendapat perawatan lebih.', 'Bayi kucing yang baru lahir memiliki suhu tuhuh yang sama dengan induknya. Untuk menjaga  suhu tubuhnya tidak turun, anak kucing harus tetap berdekatan dengan sang induk sebagai bentuk kehangatan.\r\n\r\nAnak kucing yang baru lahir harus tetap hangat dengan suhu sekitar 35-37 derajat Celsius hingga tiga minggu pertama kehidupannya. Kamu bisa menyediakan kandang untuk anak kucing dengan suhu ruangan hangat kurang-lebih sekitar 30 derajat Celsius karena anak kucing mampu mempertahankan suhu tubuh lima derajat Celsius lebih tinggi daripada suhu ruangan. \r\n\r\nSelanjutnya, hal yang harus disiapkan ketika merawat anak kucing yang baru lahir adalah  Anak kucing yang baru lahir hanya memiliki berat tubuh tiga atau empat ons setiap ekor.  Meski kecil, anak kucing yang baru lahir memiliki indra penciuman yang memungkinkannya menemukan puting susu induknya untuk menyusu. Anak kucing yang sehat biasanya mulai menyusu dalam waktu satu jam. Anak kucing harus mengonsumsi kolostrum yang cukup dalam beberapa jam setelah lahir untuk memastikan kelangsungan hidupnya.\r\n\r\nKucing setidaknya melahirkan lima sampai tujuh ekor anak kucing dalam sekali persalinan. Umumnya, anak kucing yang paling kecil sangat berisiko mengalami masalah kesehatan.', '2025-12-15 05:58:47');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cats`
--
ALTER TABLE `cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `education_content`
--
ALTER TABLE `education_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;