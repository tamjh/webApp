-- Date : 16 / 12 / 2023

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2023 at 01:28 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sem3_biw`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `postcode` varchar(10) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `customer_id`, `unit`, `street`, `postcode`, `city`, `state`) VALUES
(1, 4, 'No.21', '12/5 Jalan Indah, Taman Bukit Indah', '81200', 'Johor bahru', 'Johor'),
(4, 7, 'No.44', '4/4 jalan 4, Taman empat', '44444', 'batu pahat', 'Kuala Lumpur');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `publisher` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `inventory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `category`, `publisher`, `year`, `price`, `cover`, `description`, `inventory`) VALUES
(2, 'Harry porter', 1, 1, 1888, 11, 'Harry-Potter-and-Sorcerers-Stone.jpg', 'harry porter....', 1111),
(3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 3, 3, 1999, 4, 'Latihan-Asas-Mengarang-SK-EnglishYear123.jpg', 'THIS BOOK ARE SPECIALLY DESIGNED FOR PUPILS IN YEAR 1,2 AND 3. OTHER THAN THAT, EXERCISES ARE BASED ON THE LATEST CEFR-aligned CURRICULUM AND EXERCISES ARE ORGANISED INTO 3 DIFFERENT CATEGORIES WHICH ARE REARRANGE THE WORDS, COMPLETE THE SCIENCES AND CONSTRUCT SENTENCES. LASTLY, EACH CATEGORY IS SPECIFICALLY FORMULATED TO CULTIVATED TO CULTIVATE PUPILS’ INTERESTING IN SENTENCE CONSTRUCTION AND ULTIMATELY MASTER THE ART OF WRITING.', 100),
(4, 'Tahun 4 - 6 Pentaksiran Siap Sedia SK Sains', 5, 3, 0, 4, 'Tahun-4-6-Pentaksiran-Siap-Sedia-SK.jpg', 'PENTAKSIRAN TOPIKAL SIAP SEDIA SK DITULIS BERDASARKAN KSSR SEMAKAN YANG TERKINI DAN FORMAT TERBAHARU UJIAN AKHIR SESI AKADEMIK (UASA). BUKU INI DAPAT MEMBANTU MENINGKATKAN KEFAHAMAN DAN MEMUDAHKAN MURID-MURID MENGULANG KAJI PELAJARAN.', 111),
(5, 'Tahun 4 - 6 Kertas Model UASA SK Sains', 5, 4, 0, 4, 'Tahun-4-6-Kertas-Model-UASA-SK.jpg', 'KOLEKSI KERTAS MODEL INI DITULIS KHAS UNTUK MURID-MURID TAHUN 4, 5 & 6 YANG BAKAL MENDUDUKI PEPERIKSAAN UASA.TERDAPAT CIRI UNGGUL ANTARANYA IALAH BERORIENTASIKAN FORMAT UASA 100%, BERDASARKAN TOPIK-TOPIK DALAM BUKU TEKS, BOLEH DILERAIKAN DAN DIKERJAKAN SECARA      BERASINGAN. SELAIN ITU, TERDAPAT JAWAPAN LENGKAP UNTUK DIJADIKAN PANDUAN', 111),
(6, 'Tahun 4 - 6 Kertas Model UASA PBD SK Matematik', 5, 0, 0, 6, 'Tahun4-6-Kertas-Model-UASA-PBD-SK.jpg', 'TERDAPAT BANYAK CIRI ISTIMEWA BUKU INI DAN ANTARANYA ADALAH MENGANDUNGI 5 SET KERTAS MODEL, MENEPATI FORMAT TERKINI UJIAN AKHIR SESI AKADEMIK (UASA), SET KERTAS MODEL YANG BOLEH DILERAIKAN DAN CADANGAN JAWAPAN UNTUK RUJUKAN', 111);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`) VALUES
(1, 'novel'),
(2, 'comic'),
(3, 'CHILDREN BOOK'),
(4, 'MOTIVATION BOOK'),
(5, 'PRIMARY SCHOOL BOOK'),
(6, 'HIGH SCHOOL BOOK');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `grand_total` double DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_number` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `grand_total`, `created`, `order_number`, `status`) VALUES
(1, 1, 44, '2023-12-09 14:58:15', 'ORD239308', 1),
(2, 1, 15, '2023-12-09 16:46:13', 'ORD928461', 1),
(3, NULL, 11, '2023-12-11 08:37:47', 'ORD719791', 1),
(4, 3, 20, '2023-12-11 08:39:50', 'ORD533732', 1),
(5, 1, 121, '2023-12-13 17:08:10', 'ORD030047', 1),
(6, NULL, 29, '2023-12-14 04:17:12', 'ORD777455', 1),
(7, 1, 29, '2023-12-14 04:18:02', 'ORD134393', 1),
(8, 1, 4, '2023-12-14 04:18:29', 'ORD843671', 1),
(9, 6, 8, '2023-12-15 16:31:48', 'ORD305588', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_price` double DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `order_number`, `product_id`, `product_name`, `product_price`, `quantity`) VALUES
(1, 1, 'ORD239308', 2, 'Harry porter', 11, 4),
(2, 2, 'ORD928461', 2, 'Harry porter', 11, 1),
(3, 2, 'ORD928461', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 1),
(4, 3, 'ORD719791', 2, 'Harry porter', 11, 1),
(5, 4, 'ORD533732', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 5),
(6, 5, 'ORD030047', 2, 'Harry porter', 11, 11),
(7, 6, 'ORD777455', 2, 'Harry porter', 11, 1),
(8, 6, 'ORD777455', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 1),
(9, 6, 'ORD777455', 6, 'Tahun 4 - 6 Kertas Model UASA PBD SK Matematik', 6, 1),
(10, 6, 'ORD777455', 5, 'Tahun 4 - 6 Kertas Model UASA SK Sains', 4, 1),
(11, 6, 'ORD777455', 4, 'Tahun 4 - 6 Pentaksiran Siap Sedia SK Sains', 4, 1),
(12, 7, 'ORD134393', 2, 'Harry porter', 11, 1),
(13, 7, 'ORD134393', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 1),
(14, 7, 'ORD134393', 6, 'Tahun 4 - 6 Kertas Model UASA PBD SK Matematik', 6, 1),
(15, 7, 'ORD134393', 5, 'Tahun 4 - 6 Kertas Model UASA SK Sains', 4, 1),
(16, 7, 'ORD134393', 4, 'Tahun 4 - 6 Pentaksiran Siap Sedia SK Sains', 4, 1),
(17, 8, 'ORD843671', 5, 'Tahun 4 - 6 Kertas Model UASA SK Sains', 4, 1),
(18, 9, 'ORD305588', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 1),
(19, 9, 'ORD305588', 5, 'Tahun 4 - 6 Kertas Model UASA SK Sains', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `id` int(11) NOT NULL,
  `publisher_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`id`, `publisher_name`) VALUES
(1, 'pelangi'),
(2, 'p2'),
(3, 'EPH (M)'),
(4, 'PEP PUBLISHIER'),
(5, 'ILMU BAKTI'),
(6, 'TELAGA BIRU'),
(7, 'PENERBITAN FARGOES'),
(8, 'SASBADI'),
(9, 'PUSTAKA YAKIN'),
(10, 'BECKY ALBERTALLY '),
(11, 'MIND TO MIND');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `condition` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `condition`) VALUES
(1, 'Preparing'),
(2, 'Shipping'),
(3, 'Complete');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `usertype` varchar(255) NOT NULL DEFAULT 'customer',
  `phone_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `usertype`, `phone_number`) VALUES
(1, 'c1', 'c1@gmail.com', '$2y$10$LGOkShIAeGK5XPy2SCvkl.Q6wmcStD7HZ8ejOLA5cBWSX6Y.JVOM6', 'customer', '010-1122344'),
(2, 'admin', 'admin@gmail.com', '$2y$10$Y25CL10Q6RAfyg.CqUvFZO.BaA.1KXCQw/qJiURUk7kbThHXdQfna', 'admin', ''),
(3, 'c2', 'c2@gmail.com', '$2y$10$4G2gjcKLX2SeOt2INrTM4e7OvUl5speym2ZNqTrFjChHtEk2mC8sW', 'customer', '012-3456789'),
(4, 'c3', 'c3@gmail.com', '$2y$10$zSMZTpoyUZ4vVC1ofDjzEO2t6lgpapN1JHtOW6s4AnKR1OgdVR3h6', 'customer', '0133333333'),
(6, 'c5', 'c5@gmail.com', '$2y$10$u9T74qNb/seivxY2a7FNp.qgKFEjrNiJyEWIfioKzs4zg5DC5Mez.', 'customer', '0144444445'),
(7, 'c4', 'c4@gmail.com', '$2y$10$isXIDd7WWHLXeb.cR1oB.u1dyw4hhi6KxKcFzf0okafhXaxRMYmWG', 'customer', '0144444444');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_order_number` (`order_number`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_number` (`order_number`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`order_number`) REFERENCES `orders` (`order_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
