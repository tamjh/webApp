-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 03:20 PM
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
(1, 4, 'No.22', '12/5 Jalan Indah, Taman Bukit Indah', '81200', 'Johor bahru', 'Johor'),
(4, 7, 'No.44', '4/4 jalan 4, Taman empat', '44444', 'batu pahat', 'Kuala Lumpur'),
(5, 8, '11', 'jalan cuba, 12/13 Taman Cuba', '81200', 'batu pahat', 'johor'),
(6, 12, '12', '1111', '1111', '1111', 'Perlis'),
(15, 2, '22', '222', '222', '22', 'Kelantan'),
(16, 13, '33', '33', '33', '33', 'Johor'),
(17, 14, '11', 'jalan cuba, 12/13 Taman Cuba', '81200', 'Johor Bahru', 'Johor'),
(18, 15, '11', 'jalan example. 11/12 Taman example', '81200', 'Batu Pahat', 'Johor');

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
  `inventory` int(11) NOT NULL,
  `promotion` int(233) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `category`, `publisher`, `year`, `price`, `cover`, `description`, `inventory`, `promotion`) VALUES
(3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 3, 3, 2022, 4.2, 'Latihan-Asas-Mengarang-SK-EnglishYear123.jpg', 'THIS BOOK ARE SPECIALLY DESIGNED FOR PUPILS IN YEAR 1,2 AND 3. OTHER THAN THAT, EXERCISES ARE BASED ON THE LATEST CEFR-aligned CURRICULUM AND EXERCISES ARE ORGANISED INTO 3 DIFFERENT CATEGORIES WHICH ARE REARRANGE THE WORDS, COMPLETE THE SCIENCES AND CONSTRUCT SENTENCES. LASTLY, EACH CATEGORY IS SPECIFICALLY FORMULATED TO CULTIVATED TO CULTIVATE PUPILS’ INTERESTING IN SENTENCE CONSTRUCTION AND ULTIMATELY MASTER THE ART OF WRITING.', 91, 0),
(4, 'Tahun 4 - 6 Pentaksiran Siap Sedia SK Sains', 5, 3, 2022, 4.2, 'Tahun-4-6-Pentaksiran-Siap-Sedia-SK.jpg', 'PENTAKSIRAN TOPIKAL SIAP SEDIA SK DITULIS BERDASARKAN KSSR SEMAKAN YANG TERKINI DAN FORMAT TERBAHARU UJIAN AKHIR SESI AKADEMIK (UASA). BUKU INI DAPAT MEMBANTU MENINGKATKAN KEFAHAMAN DAN MEMUDAHKAN MURID-MURID MENGULANG KAJI PELAJARAN.', 105, 0),
(5, 'Tahun 4 - 6 Kertas Model UASA SK Sains', 5, 4, 2022, 6.5, 'Tahun-4-6-Kertas-Model-UASA-SK.jpg', 'KOLEKSI KERTAS MODEL INI DITULIS KHAS UNTUK MURID-MURID TAHUN 4, 5 & 6 YANG BAKAL MENDUDUKI PEPERIKSAAN UASA.TERDAPAT CIRI UNGGUL ANTARANYA IALAH BERORIENTASIKAN FORMAT UASA 100%, BERDASARKAN TOPIK-TOPIK DALAM BUKU TEKS, BOLEH DILERAIKAN DAN DIKERJAKAN SECARA      BERASINGAN. SELAIN ITU, TERDAPAT JAWAPAN LENGKAP UNTUK DIJADIKAN PANDUAN', 11, 0),
(6, 'Tahun 4 - 6 Kertas Model UASA PBD SK Matematik', 5, 0, 2022, 5.9, 'Tahun4-6-Kertas-Model-UASA-PBD-SK.jpg', 'TERDAPAT BANYAK CIRI ISTIMEWA BUKU INI DAN ANTARANYA ADALAH MENGANDUNGI 5 SET KERTAS MODEL, MENEPATI FORMAT TERKINI UJIAN AKHIR SESI AKADEMIK (UASA), SET KERTAS MODEL YANG BOLEH DILERAIKAN DAN CADANGAN JAWAPAN UNTUK RUJUKAN', 109, 0),
(7, 'Conquer A+ Koleksi Soalan UPKK SK Ulum Syariah', 5, 6, 2020, 7.9, 'Conquer-A+-Koleksi-Soalan-UPKK-SK-Ulum-Syariah.jpg', 'BUKU INI MENGANDUNGI KOLEKSI SOALAN UPKK YANG TERKINI BERSERTA MODUL SOALAN FOKUS. SELAIN ITU, BUKU INI DAPAT MEMBANTU MURID MELAKUKAN LATIH TUBI DENGAN LEBIH EFEKTIF DAN MEMBANTU MENGASAH KEMAMPUAN KOGNITIF. AKHIR SEKALI, MENINGKATKAN KEKUATAN DAYA FIKIR MURID-MURID', 94, 20),
(8, 'Tahun 1 - 3 Skor Minda SK English', 5, 7, 2020, 5.5, 'Tahun-1-3-Skor-Minda-SK-english.jpg', 'SIRI INI DITULIS BERDASARKAN KURIKULUM STANDARD SEKOLAH RENDAH (KSSR) KEMENTERIAN PENDIDIKAN MALAYSIA.BUKU INI MENYEDIAKAN LATIHAN TOPIKAL YANG MEMENUHI KEHENDAK BOKUMEN STANDARD KURIKULAM DAN PENTAKSIRAN (DKSP) TERKINI. IA MEMBANTU MURID-MURID BERFIKIR SECARA ARAS TINGGI DENGAN LEBIH KREATIF DAN INOVATIF.DILENGKAPI SOALAN KBAT UNTUK MENINGKAGTKAN KEMAHIRAN BERFIKIR.DIOAH SEJAJAR DENGAN PENTAKSIRAN BILIK DARJAH (PBD) SECARA BERTERUSAN DAN MENYELURUH BAGI MENILAI PENGUASAAN MURID DAN MEMUDAHKAN KERJA MEREKOD.', 0, 0),
(9, 'Simple Guide To Essay Writing English SPM', 6, 5, 2023, 8.9, 'Simple-Guide-To-Essay-Writing-English-SPM-(Paper 2).jpg', 'SIMPLE GUIDE TO ESSAY WRITING SPM ENGLISH (CEFR) IS AN ESSAY WRITING WORKBOOK DESIGNED TO HELP STUDENTS IN FORM 4 & 5 WHO ARE WEAK IN ESSAY WRITING. THE BOOK FOCUSES ON HELPING STUDENTS PASS THE SPM WRITING PAPER.THE SPECIAL FEATURES OF THIS BOOK ARE COMPREHENSIVE GUIDELINES FOR EACH SECTION, UNITS ON VOCABULARY BUILDER, SENTENCES CONSTRUCTION AND USING PUNCTUATION TO IMPROVE ESSAY WRITING SKILLS. OTHER THAN THAT, GUIDED PRACTICES FOR DIFFERENT TEXT TYPES AND SPM-FORMAT PRACTICES. LASTLY, IT HAVE COMPLETE ANSWERS.', 11, 0),
(10, 'Modul Instruksi Karangan Mulus + MMI SPM Bahasa Melayu', 6, 5, 2022, 9.9, 'Modul-Instruksi-Karangan-Mulus+MMI-SPM-Bahasa-Melayu-(Kertas 1).jpg', 'MULUS+LMS BAHASA MELAYU SPM IALAH BUKU LATIH TUBI TERANCANG YANG DIBINA OLEH GURU-GURU YANG BERKALIBER DAN BERPANGALAMAN UNTUK MEMBANTU MURID-MURID YANG LEMAH DALAM PELAJARAN BAHASA MELAYU KERTAS 1. BUKU INI MEMFOKUSKAN MURID YANG INGIN LULUS DALAM PENULISAN KARANGAN SPM SEHINGGA LAYAK MENDAPAT SIJIL.TERDAPAT BANYAK CIRI ISTIMEWA BUKU INI ANTARNYA ADALAH BAHASA YANG RINGKAS DAN MUDAH DIFAHAMI, FORMULA MENULIS KARANGAN DENGAN MUDAH DAN SOALAN LATIH TUBI MIRIP SOALAN SPM YANG SEBENAR. AKHIR SEKALI, PETA MINDA UNTUK MEMBANTU MURID MENULIS KARANGAN DAN CADANGAN JAWAPAN.', 111, 0),
(11, 'Kertas Model Top Score SPM Bahasa Melayu', 0, 0, 2022, 8.5, 'Kertas-Model-Top-Score-SPM-Bahasa-Melayu.jpg', 'KERTAS MODEL TOP SCORE SPM MERUPAKAN KOLEKSI KERTAS SOALAN YANG DIHASIKAN BERDASARKAN FORMAT PENTAKSIRAN SPM TERKINI. KOLEKSI KERTAS SOALAN INI DISEDIAKAN UNTUK MEMBIASAKAN MURID DENGAN SOALAN DAN FORMAT SPM SEBENAR, MENINGKATKAN KEMAHIRAN MURID MENJAWAB SOALAN SPM DAN MEMBOLEHKAN MURID MENJAWAB SOALAN DENGAN LEBIH YAKIN', 108, 0),
(12, 'Koleksi Soalan SPM Matematik-Tambahan', 6, 8, 2019, 4.9, 'Koleksi-Soalan-SPM-Matematik-Tambahan.jpg', 'SIRI KOLEKSI SOALAN SPM INI DITERBITKAN KHUSUS UNTUK MEMBANTU MURID MEMBUAT PERSEDIAAN AWAL DAN SEWAJARNYA UNTUK MEMAHAMI FORMAT SOALAN, STANDARD SOALAN, KEPERLUAN SOALAN SPM SERTA MELAKUKAN LATIH TUBI SPM SEBELUM MENGHADAPI PEPERIKSAAN SIJIL PELAJARAN MALAYSIA (SPM).OLEH ITU, SETAP LATIHAN DAN SOALAN DALAM BUKU INI DIOLAH DENGAN MERUJUK FORMAT PENTAKSIRAN SPM DAN KERTAS SPM TERKINI YANG DIKELUARKAN OLEH LEMBAGA PEPERIKSAAN (LP) SERTA GURU-GURU PAKAR PERINGKAT SPM. SETAP TOPIK DALAM BUKU INI MEMUATKAN LATIHAN DAN SOALAN YANG MENGIKUT FORMAT DAN KEPERLUAN SPM TERKINI.', 108, 0),
(13, 'Kertas Soalan Peperiksaan Sebenar SPM', 6, 9, 2022, 9.95, 'Kertas-Soalan-Peperiksaan-Sebenar-SPM-Sejarah.jpg', 'SIRI KERTAS SOALAN PEPERIKSAAN SEBENAR SPM INI MENGANDUNGI SOALAN PEPERIKSAAN SEBENAR SPM TAHUN 2021-2022 DAN SOALAN PEPERIKSAAN SEBENAR SPM TAHUN 2022 (SEPTEMBER). TERDAPAT 1 SET KERTAS MODEL SPM (BAHASA MELAYU, MATEMATIK, SEJARAH) DAN 2 SET KERTAS MODEL SPM (BAHASA INGGERIS, BAHASA CINA, FIZIK, KIMIA, BIOLOGI, BAHASA ARAB, MATEMATIK TAMBAHAN)', 108, 0),
(14, 'Crazy Rich Asians (FTI)', 1, 12, 2013, 37.95, 'Crazy-Rich-Asians-(FTI).jpg', 'From the author of the Goodreads Choice Award winner The Spanish Love Deception, the eagerly anticipated follow-up featuring Rosie Graham and Lucas Martin, who are forced to share a New York apartment.Rosie Graham has a problem.', 102, 0),
(15, 'Harry Potter And The Cursed Child', 1, 13, 2016, 57.9, 'Harry-Potter-And-The-Cursed-Child.jpg', 'The Eighth Story. Nineteen Years Later. Based on an original new story by J.K. Rowling, John Tiffany, and Jack Thorne, a new play by Jack Thorne, Harry Potter and the Cursed Child is the eighth story in the Harry Potter series and the first official Harry Potter story to be presented on stage. ', 103, 10),
(16, 'Girls Made Of Snow And Glass', 1, 13, 2017, 47.9, 'Girls-Made-Of-Snow-And-Glass.png', 'Sixteen-year-old Mina is motherless, her magician father is vicious, and her silent heart has never beat with love for anyone—has never beat at all, in fact, but she’d always thought that fact normal. She never guessed that her father cut out her heart and replaced it with one of glass. When she moves to Whitespring Castle and sees its king for the first time, Mina forms a plan: win the king’s heart with her beauty, become queen, and finally know love. The only catch is that she’ll have to become a stepmother.', 96, 0),
(17, 'Wicked Like A Wildfire', 1, 11, 2017, 75.9, 'Wicked-Like-A-Wildfire.jpg', 'Fans of Holly Black and Leigh Bardugo will be bewitched by Lana Popovic\'s debut YA fantasy novel about a bargain that binds the fates - and hearts - of twin sisters to a force larger than life.All the women in Iris and Malina’s family have the unique magical ability or \"gleam\" to manipulate beauty. Iris sees flowers as fractals and turns her kaleidoscope visions into glasswork, while Malina interprets moods as music. But their mother has strict rules to keep their gifts a secret, even in their secluded sea-side town. Iris and Malina are not allowed to share their magic with anyone, and above all, they are forbidden from falling in love. But when their mother is mysteriously attacked, the sisters will have to unearth the truth behind the quiet lives their mother has built for them. They will discover a wicked curse that haunts their family line - but will they find that the very magic that bonds them together is destined to tear them apart forever?', 100, 0),
(18, 'Fire With Fire', 1, 13, 2013, 35.9, 'Fire-With-Fire.png', 'Dani and Eden Rivera were both born to kill dragons, but the sisters couldn\'t be more different. For Dani, dragon slaying takes a back seat to living a normal high school life in their Tennessee town, while Eden prioritizes training above everything else. Yet they both agree on one thing: it\'s kill or be killed where dragons are concerned.', 98, 0),
(19, 'Word Search PS - English', 3, 3, 2018, 3.2, 'Word-Search-PS-English.jpg', 'RECOGNISE WORDS THROUGH VARIOUS WORD SEARCH PUZZLES. LEARN TO SPELL THROUGH VARIOUS CROSSWORD PUZZLES ', 100, 0),
(20, '123 Dot-To-Dot PS - Numbers 1-50', 3, 3, 2023, 4.2, '123-Dot-To-Dot-PS-Numbers1-50.jpg', 'LEARNING LINK DOT TO DOT BY USING NUMBER FROM 1 TO 50 UNTIL FINISH THE PICTURES', 96, 0),
(21, 'My Colouring Style & Activity Book', 3, 11, 2022, 6.9, 'My-Colouring-Style-&-Activity-Book.jpg', 'MY COLOURING STYLE & OTHER ACTIVITIES SERIES HAS BEEN SPECIALLY DESIGNED IN ORDER TO ENCHANCE AND DEVELOP THE PRACTISING CHILDS IMAGINATION, CREATIVITY AND MOTOR-SKILLS. THE ACTIVITIES PRESENTED WILL ALSO PROVIDE FUN AND JOY FOR THE CHILDREN.', 102, 0),
(22, 'Thomas & Friends : Let\'s Learn With Sticker', 3, 1, 2023, 8.9, 'Thomas-Friends-Lets-Learn-With-Sticker.jpg', 'GET READY FOR LOTS OF FUN AND LEARNING WITH THIS THOMAS & FRIENDS LET’S LEARN SERIES. WHETHER IT’S DEVELOPING LETTER AND NUMBER SKILLS, LEARNING BASIC CONCEPTS, OR SIMPLY HAVING FUN WITH COLOURING AND STICKER ACTIVITIES, THIS SERIES OF 5 BOOKS IS DESIGNED TO INSPIRE CREATIVITY AND FOSTER A LOVE FOR LEARNING. KIDS, AGES 4 AND ABOVE WILL ENJOY THESE ACTIVITY BOOKS. SO, GET A PENCIL, GET COMFORTABLE, AND LET THE LEARNING ADVENTURE BEGIN!', 100, 0),
(23, '101 Copy Colouring', 3, 11, 2019, 12.9, '101-Copy-Colouring.jpg', 'COPY COLOURING IS AN ALL-TIME FAVOURITE ACTIVITY FOR CERTAIN CHILDREN TO EXPRESS THEMSELVES AND SHOWCASE THEIR CREATIVITY. THE COLOURING ACTIVITY ASSISTS THE CHILD TO BUILD FINE MOTOR SKILL AND HAND STRENGTH, THUS PROVIDING THEM THE PLEASURE OF CREATING ARTWORK. THE ACTIVITIES WILL ULTIMATELY FACILITATE THE CHILD’S PHYSICAL AND COGNITIVE DEVELOPMENT.', 1, 0),
(24, 'Nursery Think And Draw Book 1 - 4', 3, 1, 2020, 9, 'Nursery-Think-And-Draw-Book-1-4.jpg', 'CHILDREN WILL BE AMAZED AT WHAT THEY CAN DRAW USING PHOTOS OF EVERYDAY OBJECTS. WHETHER IT’S FORMING AN ELEPHANT FROM AN APPLE, OR A LADYBIRD FROM A BISCUIT, THE ACTIVITIES IN THIS BOOK WILL SPARK CHILDREN’S IMAGINATION, BOOST THEIR CREATIVITY, WIDEN THEIR VOCABULARY. SO, WHAT CAN YOU DRAW USING AN ORANGE? LET’S THINK AND DRAW!', 998, 10);

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
(1, 'NOVEL'),
(3, 'CHILDREN BOOK'),
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
  `status` int(11) NOT NULL DEFAULT 1,
  `comment` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `grand_total`, `created`, `order_number`, `status`, `comment`) VALUES
(1, 1, 44, '2023-12-09 14:58:15', 'ORD239308', 1, ''),
(2, 1, 15, '2023-12-09 16:46:13', 'ORD928461', 1, ''),
(3, NULL, 11, '2023-12-11 08:37:47', 'ORD719791', 1, ''),
(4, 3, 20, '2023-12-11 08:39:50', 'ORD533732', 1, ''),
(5, 1, 121, '2023-12-13 17:08:10', 'ORD030047', 1, ''),
(6, NULL, 29, '2023-12-14 04:17:12', 'ORD777455', 1, ''),
(7, 1, 29, '2023-12-14 04:18:02', 'ORD134393', 1, ''),
(8, 1, 4, '2023-12-14 04:18:29', 'ORD843671', 1, ''),
(9, 6, 8, '2023-12-15 16:31:48', 'ORD305588', 1, ''),
(10, 4, 4, '2023-12-16 12:43:01', 'ORD722845', 2, ''),
(11, 7, 22, '2023-12-16 16:27:11', 'ORD151382', 3, ''),
(12, 4, 40, '2023-12-16 16:27:37', 'ORD022793', 1, ''),
(13, 1, 9, '2023-12-17 03:20:24', 'ORD323947', 1, ''),
(14, 8, 13, '2023-12-17 09:32:11', 'ORD618383', 2, 'fast'),
(15, 6, 13, '2023-12-18 12:30:55', 'ORD348897', 1, ''),
(16, 8, 23, '2023-12-18 14:50:52', 'ORD359008', 1, 'fast'),
(17, 8, 22, '2023-12-18 14:51:26', 'ORD382041', 3, 'slow slow'),
(18, 1, 37, '2023-12-19 01:15:22', 'ORD576283', 1, ''),
(19, 1, 21, '2023-12-19 02:31:17', 'ORD203584', 1, ''),
(20, NULL, 9, '2023-12-19 02:38:31', 'ORD603564', 1, ''),
(21, 4, 109.25, '2023-12-27 10:02:42', 'ORD445548', 1, 'please'),
(22, 8, 42.15, '2023-12-27 15:44:39', 'ORD575559', 3, ''),
(23, 8, 133.81, '2023-12-27 15:47:57', 'ORD274821', 1, ''),
(24, 8, 135.7, '2023-12-27 15:51:07', 'ORD235405', 1, '135.7'),
(25, 8, 220.15, '2023-12-28 15:20:21', 'ORD612674', 1, ''),
(26, 8, 220.15, '2023-12-28 15:20:58', 'ORD671783', 1, ''),
(27, 8, 261.35, '2023-12-29 15:16:29', 'ORD738029', 3, ''),
(28, NULL, 22.8, '2023-12-29 15:57:51', 'ORD993416', 1, '12345testing'),
(29, 13, 22, '2023-12-30 03:34:54', 'ORD494707', 1, ''),
(30, 8, 22.1, '2023-12-30 06:00:39', 'ORD908733', 1, 'try1111'),
(31, 14, 55.050000000000004, '2023-12-30 10:23:43', 'ORD560935', 1, 'comment 1'),
(32, 14, 55.050000000000004, '2023-12-30 10:24:17', 'ORD358289', 1, 'comment 1'),
(33, 14, 83.8, '2023-12-30 10:24:42', 'ORD465350', 1, 'comment 1'),
(34, 14, 19.85, '2023-12-30 10:24:58', 'ORD896261', 1, ''),
(35, 8, 102.96000000000001, '2023-12-30 12:28:11', 'ORD711313', 1, 'As fast as possible'),
(36, 8, 37.92, '2024-01-02 02:55:37', 'ORD054706', 2, '11111');

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
(3, 2, 'ORD928461', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 1),
(5, 4, 'ORD533732', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 5),
(8, 6, 'ORD777455', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 1),
(9, 6, 'ORD777455', 6, 'Tahun 4 - 6 Kertas Model UASA PBD SK Matematik', 6, 1),
(10, 6, 'ORD777455', 5, 'Tahun 4 - 6 Kertas Model UASA SK Sains', 4, 1),
(11, 6, 'ORD777455', 4, 'Tahun 4 - 6 Pentaksiran Siap Sedia SK Sains', 4, 1),
(13, 7, 'ORD134393', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 1),
(14, 7, 'ORD134393', 6, 'Tahun 4 - 6 Kertas Model UASA PBD SK Matematik', 6, 1),
(15, 7, 'ORD134393', 5, 'Tahun 4 - 6 Kertas Model UASA SK Sains', 4, 1),
(16, 7, 'ORD134393', 4, 'Tahun 4 - 6 Pentaksiran Siap Sedia SK Sains', 4, 1),
(17, 8, 'ORD843671', 5, 'Tahun 4 - 6 Kertas Model UASA SK Sains', 4, 1),
(18, 9, 'ORD305588', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 1),
(19, 9, 'ORD305588', 5, 'Tahun 4 - 6 Kertas Model UASA SK Sains', 4, 1),
(20, 10, 'ORD722845', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 1),
(22, 11, 'ORD151382', 6, 'Tahun 4 - 6 Kertas Model UASA PBD SK Matematik', 6, 1),
(23, 12, 'ORD022793', 4, 'Tahun 4 - 6 Pentaksiran Siap Sedia SK Sains', 4, 10),
(24, 13, 'ORD323947', 4, 'Tahun 4 - 6 Pentaksiran Siap Sedia SK Sains', 4, 1),
(25, 14, 'ORD618383', 5, 'Tahun 4 - 6 Kertas Model UASA SK Sains', 4, 1),
(26, 14, 'ORD618383', 4, 'Tahun 4 - 6 Pentaksiran Siap Sedia SK Sains', 4, 1),
(27, 15, 'ORD348897', 4, 'Tahun 4 - 6 Pentaksiran Siap Sedia SK Sains', 4, 2),
(28, 16, 'ORD359008', 5, 'Tahun 4 - 6 Kertas Model UASA SK Sains', 4, 2),
(30, 16, 'ORD359008', 4, 'Tahun 4 - 6 Pentaksiran Siap Sedia SK Sains', 4, 1),
(33, 18, 'ORD576283', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 1),
(34, 19, 'ORD203584', 4, 'Tahun 4 - 6 Pentaksiran Siap Sedia SK Sains', 4, 1),
(35, 19, 'ORD203584', 6, 'Tahun 4 - 6 Kertas Model UASA PBD SK Matematik', 6, 2),
(36, 20, 'ORD603564', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4, 1),
(37, 21, 'ORD445548', 14, 'Crazy Rich Asians (FTI)', 37.95, 1),
(38, 21, 'ORD445548', 15, 'Harry Potter And The Cursed Child', 57.9, 1),
(39, 21, 'ORD445548', 11, 'Kertas Model Top Score SPM Bahasa Melayu', 8.5, 1),
(40, 21, 'ORD445548', 12, 'Koleksi Soalan SPM Matematik-Tambahan', 4.9, 1),
(41, 22, 'ORD575559', 14, 'Crazy Rich Asians (FTI)', 37.95, 1),
(42, 22, 'ORD575559', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4.2, 1),
(43, 23, 'ORD274821', 14, 'Crazy Rich Asians (FTI)', 37.95, 2),
(44, 23, 'ORD274821', 15, 'Harry Potter And The Cursed Child', 57.9, 1),
(45, 24, 'ORD235405', 15, 'Harry Potter And The Cursed Child', 57.9, 2),
(46, 24, 'ORD235405', 13, 'Kertas Soalan Peperiksaan Sebenar SPM', 9.95, 2),
(47, 25, 'ORD612674', 14, 'Crazy Rich Asians (FTI)', 37.95, 1),
(48, 25, 'ORD612674', 11, 'Kertas Model Top Score SPM Bahasa Melayu', 8.5, 1),
(49, 25, 'ORD612674', 15, 'Harry Potter And The Cursed Child', 57.9, 3),
(50, 27, 'ORD738029', 24, 'Nursery Think And Draw Book 1 - 4', 5.9, 1),
(51, 27, 'ORD738029', 20, '123 Dot-To-Dot PS - Numbers 1-50', 4.2, 1),
(52, 27, 'ORD738029', 14, 'Crazy Rich Asians (FTI)', 37.95, 1),
(53, 27, 'ORD738029', 11, 'Kertas Model Top Score SPM Bahasa Melayu', 8.5, 1),
(54, 27, 'ORD738029', 16, 'Girls Made Of Snow And Glass', 47.9, 3),
(55, 27, 'ORD738029', 18, 'Fire With Fire', 35.9, 1),
(56, 27, 'ORD738029', 3, 'Latihan Asas Mengarang SK - English Year 1/2/3', 4.2, 6),
(57, 28, 'ORD993416', 23, '101 Copy Colouring', 12.9, 1),
(58, 28, 'ORD993416', 12, 'Koleksi Soalan SPM Matematik-Tambahan', 4.9, 1),
(59, 29, 'ORD494707', 8, 'Tahun 1 - 3 Skor Minda SK English', 5.5, 4),
(60, 30, 'ORD908733', 23, '101 Copy Colouring', 12.9, 1),
(61, 30, 'ORD908733', 20, '123 Dot-To-Dot PS - Numbers 1-50', 4.2, 1),
(62, 31, 'ORD560935', 23, '101 Copy Colouring', 12.9, 1),
(63, 31, 'ORD560935', 20, '123 Dot-To-Dot PS - Numbers 1-50', 4.2, 1),
(64, 31, 'ORD560935', 14, 'Crazy Rich Asians (FTI)', 37.95, 1),
(65, 32, 'ORD358289', 23, '101 Copy Colouring', 12.9, 1),
(66, 32, 'ORD358289', 20, '123 Dot-To-Dot PS - Numbers 1-50', 4.2, 1),
(67, 32, 'ORD358289', 14, 'Crazy Rich Asians (FTI)', 37.95, 1),
(68, 33, 'ORD465350', 18, 'Fire With Fire', 35.9, 1),
(69, 33, 'ORD465350', 16, 'Girls Made Of Snow And Glass', 47.9, 1),
(70, 34, 'ORD896261', 13, 'Kertas Soalan Peperiksaan Sebenar SPM', 9.95, 1),
(71, 34, 'ORD896261', 12, 'Koleksi Soalan SPM Matematik-Tambahan', 4.9, 1),
(72, 35, 'ORD711313', 14, 'Crazy Rich Asians (FTI)', 37.95, 1),
(73, 35, 'ORD711313', 15, 'Harry Potter And The Cursed Child', 52.11, 1),
(74, 35, 'ORD711313', 23, '101 Copy Colouring', 12.9, 1),
(75, 36, 'ORD054706', 7, 'Conquer A+ Koleksi Soalan UPKK SK Ulum Syariah', 6.32, 6);

-- --------------------------------------------------------

--
-- Table structure for table `page_views`
--

CREATE TABLE `page_views` (
  `id` int(11) NOT NULL,
  `page` varchar(255) NOT NULL,
  `view_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_views`
--

INSERT INTO `page_views` (`id`, `page`, `view_date`) VALUES
(1, 'homepage', '2023-12-23 17:25:41'),
(2, 'homepage', '2023-12-23 17:26:15'),
(3, 'homepage', '2023-12-23 17:27:14'),
(4, 'homepage', '2023-12-23 17:29:02'),
(5, 'homepage', '2023-12-24 03:20:40'),
(6, 'homepage', '2023-12-24 03:22:16'),
(7, 'homepage', '2023-12-24 03:50:49'),
(8, 'homepage', '2023-12-24 14:31:02'),
(9, 'homepage', '2023-12-26 15:08:44'),
(10, 'homepage', '2023-12-26 15:10:44'),
(11, 'homepage', '2023-12-26 15:13:11'),
(12, 'homepage', '2023-12-26 15:22:25'),
(13, 'homepage', '2023-12-27 04:19:52'),
(14, 'homepage', '2023-12-27 04:21:55'),
(15, 'homepage', '2023-12-27 09:10:34'),
(16, 'homepage', '2023-12-27 09:15:00'),
(17, 'homepage', '2023-12-27 09:17:27'),
(18, 'homepage', '2023-12-27 09:20:48'),
(19, 'homepage', '2023-12-27 10:03:20'),
(20, 'homepage', '2023-12-27 13:21:22'),
(21, 'homepage', '2023-12-27 15:25:06'),
(22, 'homepage', '2023-12-27 15:39:57'),
(23, 'homepage', '2023-12-27 15:45:13'),
(24, 'homepage', '2023-12-28 02:31:38'),
(25, 'homepage', '2023-12-28 02:32:00'),
(26, 'homepage', '2023-12-28 12:05:43'),
(27, 'homepage', '2023-12-28 12:14:15'),
(28, 'homepage', '2023-12-28 12:14:45'),
(29, 'homepage', '2023-12-28 15:22:22'),
(30, 'homepage', '2023-12-28 15:31:48'),
(31, 'homepage', '2023-12-28 16:35:26'),
(32, 'homepage', '2023-12-28 16:38:26'),
(33, 'homepage', '2023-12-28 17:10:29'),
(34, 'homepage', '2023-12-28 17:25:23'),
(35, 'homepage', '2023-12-28 17:33:33'),
(36, 'homepage', '2023-12-28 17:41:39'),
(37, 'homepage', '2023-12-28 17:41:46'),
(38, 'homepage', '2023-12-29 02:45:18'),
(39, 'homepage', '2023-12-29 03:24:33'),
(40, 'homepage', '2023-12-29 04:39:20'),
(41, 'homepage', '2023-12-29 05:32:51'),
(42, 'homepage', '2023-12-29 06:10:32'),
(43, 'homepage', '2023-12-29 07:16:38'),
(44, 'homepage', '2023-12-29 07:33:37'),
(45, 'homepage', '2023-12-29 08:10:28'),
(46, 'homepage', '2023-12-29 10:03:59'),
(47, 'homepage', '2023-12-29 11:24:06'),
(48, 'homepage', '2023-12-29 12:43:20'),
(49, 'homepage', '2023-12-29 13:07:43'),
(50, 'homepage', '2023-12-29 14:46:58'),
(51, 'homepage', '2023-12-29 15:13:34'),
(52, 'homepage', '2023-12-29 15:17:33'),
(53, 'homepage', '2023-12-29 15:17:44'),
(54, 'homepage', '2023-12-29 15:22:24'),
(55, 'homepage', '2023-12-29 16:41:35'),
(56, 'homepage', '2023-12-29 16:54:37'),
(57, 'homepage', '2023-12-29 16:58:03'),
(58, 'homepage', '2023-12-29 16:59:07'),
(59, 'homepage', '2023-12-29 16:59:39'),
(60, 'homepage', '2023-12-29 16:59:46'),
(61, 'homepage', '2023-12-29 17:03:58'),
(62, 'homepage', '2023-12-29 17:08:02'),
(63, 'homepage', '2023-12-29 17:08:58'),
(64, 'homepage', '2023-12-29 17:45:33'),
(65, 'homepage', '2023-12-30 03:32:20'),
(66, 'homepage', '2023-12-30 03:38:42'),
(67, 'homepage', '2023-12-30 04:12:47'),
(68, 'homepage', '2023-12-30 04:14:40'),
(69, 'homepage', '2023-12-30 05:24:46'),
(70, 'homepage', '2023-12-30 05:26:18'),
(71, 'homepage', '2023-12-30 05:34:48'),
(72, 'homepage', '2023-12-30 05:35:12'),
(73, 'homepage', '2023-12-30 05:40:44'),
(74, 'homepage', '2023-12-30 08:12:10'),
(75, 'homepage', '2023-12-30 08:19:44'),
(76, 'homepage', '2023-12-30 09:12:07'),
(77, 'homepage', '2023-12-30 09:16:17'),
(78, 'homepage', '2023-12-30 09:20:28'),
(79, 'homepage', '2023-12-30 09:29:00'),
(80, 'homepage', '2023-12-30 09:29:30'),
(81, 'homepage', '2023-12-30 09:53:52'),
(82, 'homepage', '2023-12-30 09:57:37'),
(83, 'homepage', '2023-12-30 10:22:06'),
(84, 'homepage', '2023-12-30 10:29:15'),
(85, 'homepage', '2023-12-30 12:23:52'),
(86, 'homepage', '2023-12-30 12:31:43'),
(87, 'homepage', '2023-12-31 13:51:57'),
(88, 'homepage', '2023-12-31 14:59:05'),
(89, 'homepage', '2023-12-31 15:07:50'),
(90, 'homepage', '2024-01-01 05:51:18'),
(91, 'homepage', '2024-01-01 05:53:25'),
(92, 'homepage', '2024-01-01 08:25:36'),
(93, 'homepage', '2024-01-01 08:47:31'),
(94, 'homepage', '2024-01-01 09:47:09'),
(95, 'homepage', '2024-01-01 09:56:01'),
(96, 'homepage', '2024-01-01 10:50:44'),
(97, 'homepage', '2024-01-01 11:04:45'),
(98, 'homepage', '2024-01-01 11:31:48'),
(99, 'homepage', '2024-01-01 14:13:43'),
(100, 'homepage', '2024-01-01 14:15:01'),
(101, 'homepage', '2024-01-02 00:21:38'),
(102, 'homepage', '2024-01-02 00:27:49'),
(103, 'homepage', '2024-01-02 02:05:55'),
(104, 'homepage', '2024-01-02 02:11:49'),
(105, 'homepage', '2024-01-02 02:40:00'),
(106, 'homepage', '2024-01-02 02:47:40'),
(107, 'homepage', '2024-01-02 02:47:51'),
(108, 'homepage', '2024-01-02 02:48:44'),
(109, 'homepage', '2024-01-02 02:52:27'),
(110, 'homepage', '2024-01-02 02:54:41'),
(111, 'homepage', '2024-01-02 03:07:05'),
(112, 'homepage', '2024-01-02 03:15:41'),
(113, 'homepage', '2024-01-02 13:46:38'),
(114, 'homepage', '2024-01-02 14:05:46'),
(115, 'homepage', '2024-01-02 14:07:22'),
(116, 'homepage', '2024-01-02 14:17:09');

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
(3, 'EPH (M)'),
(4, 'PEP PUBLISHIER'),
(5, 'ILMU BAKTI'),
(6, 'TELAGA BIRU'),
(7, 'PENERBITAN FARGOES'),
(8, 'SASBADI'),
(9, 'PUSTAKA YAKIN'),
(10, 'BECKY ALBERTALLY '),
(11, 'MIND TO MIND'),
(12, 'Doubleday'),
(13, 'arthur a levine books');

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
(2, 'admin', 'admin@gmail.com', '$2y$10$Y25CL10Q6RAfyg.CqUvFZO.BaA.1KXCQw/qJiURUk7kbThHXdQfna', 'admin', '1111'),
(3, 'c2', 'c2@gmail.com', '$2y$10$4G2gjcKLX2SeOt2INrTM4e7OvUl5speym2ZNqTrFjChHtEk2mC8sW', 'customer', '012-3456789'),
(4, 'c3', 'c3@gmail.com', '$2y$10$zSMZTpoyUZ4vVC1ofDjzEO2t6lgpapN1JHtOW6s4AnKR1OgdVR3h6', 'customer', '0133333333'),
(6, 'c5', 'c5@gmail.com', '$2y$10$u9T74qNb/seivxY2a7FNp.qgKFEjrNiJyEWIfioKzs4zg5DC5Mez.', 'customer', '015555555'),
(7, 'c4', 'c4@gmail.com', '$2y$10$isXIDd7WWHLXeb.cR1oB.u1dyw4hhi6KxKcFzf0okafhXaxRMYmWG', 'customer', '0144444444'),
(8, 'c9', 'c9@gmail.com', '$2y$10$XTHoap2CTptvRA2ROCY0gOSIHcMyGMikqYRAeGoc32S69fHMwRK36', 'customer', '019999999'),
(9, 'cc', 'cc@gmail.com', '$2y$10$NH3dkmooJ3.xdiXMgHCEFeZ6g5VfvIGrXLXGUUP5qQqPUqSMFi3s6', 'customer', '0123456789'),
(10, 'dd', 'dd@hotmail.com', '$2y$10$ebs7y7QPA96M8.sTs3OLn.UUNAeYgPX0HkcVW9nvTWYKt5dfmU4Qi', 'customer', '0987765432'),
(11, 'dd', 'dd@gmail.com', '$2y$10$rOZCAwr50mhyzQCLwZRmdeeRuKeBZ2CEfhysxpKKeul2YXU6BDOje', 'customer', '0987654321'),
(12, 'jh', 'jh@gmail.com', '$2y$10$i8cGm5TGhflQV6LwLYJtbe9/4viWWG.EnVMWD7Bvus/lenW3TpDSS', 'customer', '0182345677'),
(13, 'jh', 'jhh@hotmail.com', '$2y$10$zhzNZpplSWLcE/W9c8OOfOjGdw2SsaogEuKcBpGmA5bWWD5Pp3clm', 'customer', '11111'),
(14, 'user', 'user@hotmail.com', '$2y$10$zk6W26sn4h.baywmd7jd7OTttBlj5ly8pJ6BuNOzLXFb2HWnYqdQu', 'customer', '019123456789'),
(15, 'example Name', 'example_email@gmail.com', '111111', 'customer', '012-123456789'),
(17, 'admin2', 'admin2@gmail.com', '$2y$10$O1GJvcuGDXENaV9iGRCaqOOlnWVBFz1x4ZSRUF.Db6c.IVwaGz7OW', 'admin', '1234567890'),
(18, 'imran', 'aqilah81@gmail.com', '$2y$10$3hJAdzrfiRqG8VNA9omtB.Z36BeRWssAtK.Ty57kfk3aEn/TPgMnq', 'customer', '0135567888'),
(19, 'admin3', 'admin3@gmail.com', '$2y$10$j5Bph4.xRa5.9Xhp7TZ.DexIp6B2HGZi7OqsacHg8bmPo1x15AZ9q', 'admin', '333333333333333');

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
  ADD KEY `order_number` (`order_number`),
  ADD KEY `fk_product` (`product_id`);

--
-- Indexes for table `page_views`
--
ALTER TABLE `page_views`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `page_views`
--
ALTER TABLE `page_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `books` (`id`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`order_number`) REFERENCES `orders` (`order_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
