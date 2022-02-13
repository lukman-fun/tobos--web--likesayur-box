-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2022 at 01:24 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tobos_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(16) UNSIGNED NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(16) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `fullname`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@admin.com', '$2y$10$mYzY7C7mOv6ew6E2rnsGO.UWUWL1WekDyMBgSND1uAsLhHK16Nhxe', '2022-01-31 04:05:14', '2022-01-31 04:05:14');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(16) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `image` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(6, 'Granda Launching Skinner Diskon 50 Persen', 'granda-launching-skinner-diskon-50-persen', 'files/slider/1641014129_a497a011f7ff3ec01a31.jpeg', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Promo Kartu Perdana Murah Mantap', 'promo-kartu-perdana-murah-mantap', 'files/slider/1641014269_9fe13f6bbf87e93cbfb4.jpeg', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(16) UNSIGNED NOT NULL,
  `user_id` int(16) UNSIGNED DEFAULT NULL,
  `product_id` int(16) UNSIGNED DEFAULT NULL,
  `qty` int(16) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `qty`) VALUES
(183, 1, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `catalog`
--

CREATE TABLE `catalog` (
  `id` int(16) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `sub_title` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `image` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `catalog`
--

INSERT INTO `catalog` (`id`, `title`, `sub_title`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Spesial Hari ini', 'Hanya untuk kamu spesial hari ini', 'spesial-hari-ini', NULL, '2022-01-03 08:37:24', '2022-01-03 08:37:24'),
(2, 'Hantu Malam', 'ini untuk menakutimu', 'hantu-malam', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Gratis Ongkir', 'hanya untuk user baru', 'gratis-ongkir', 'files/content/1641975343_49fee1be7d7fa2e606de.webp', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(16) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `image` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(4, 'Buah-buahan', 'buah-buahan', 'files/category/1641391012_53d4062382127b0310f1.png', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Makanan Berat Sekali\'s', 'makanan-berat-sekalis', 'files/category/1641391600_0093cba4f0ad34a3d866.png', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaction`
--

CREATE TABLE `detail_transaction` (
  `id` int(16) UNSIGNED NOT NULL,
  `transaction_id` int(16) UNSIGNED DEFAULT NULL,
  `product_id` int(16) UNSIGNED DEFAULT NULL,
  `product_data` varchar(255) NOT NULL,
  `qty` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detail_transaction`
--

INSERT INTO `detail_transaction` (`id`, `transaction_id`, `product_id`, `product_data`, `qty`) VALUES
(5, 3, 5, '{\"product_price\":11400,\"product_name\":\"Kayu Manis Sekali\"}', 1),
(6, 3, 6, '{\"product_price\":\"32000\",\"product_name\":\"Burger Besar\"}', 1),
(7, 4, 5, '{\"product_price\":11400,\"product_name\":\"Kayu Manis Sekali\"}', 4),
(8, 5, 5, '{\"product_price\":11400,\"product_name\":\"Kayu Manis Sekali\"}', 6),
(9, 6, 6, '{\"product_price\":\"32000\",\"product_name\":\"Burger Besar\"}', 10),
(10, 6, 5, '{\"product_price\":11400,\"product_name\":\"Kayu Manis Sekali\"}', 1),
(11, 6, 7, '{\"product_price\":\"20000\",\"product_name\":\"Kelapa\"}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_catalog`
--

CREATE TABLE `item_catalog` (
  `id` int(16) UNSIGNED NOT NULL,
  `catalog_id` int(16) UNSIGNED DEFAULT NULL,
  `product_id` int(16) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_catalog`
--

INSERT INTO `item_catalog` (`id`, `catalog_id`, `product_id`) VALUES
(1, 1, 6),
(10, 3, 7),
(11, 3, 5),
(12, 3, 6),
(13, 2, 7),
(14, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `kurir`
--

CREATE TABLE `kurir` (
  `id` int(16) UNSIGNED NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kurir`
--

INSERT INTO `kurir` (`id`, `fullname`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(8, 'Moh.Lukman Hakim', '6285608658161', 'Jauh', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2021-12-09-082018', 'App\\Database\\Migrations\\AddUsers', 'default', 'App', 1639041960, 1),
(2, '2021-12-09-082029', 'App\\Database\\Migrations\\AddCategory', 'default', 'App', 1639041960, 1),
(3, '2021-12-09-082034', 'App\\Database\\Migrations\\AddProduct', 'default', 'App', 1639041960, 1),
(4, '2021-12-09-082039', 'App\\Database\\Migrations\\AddBanner', 'default', 'App', 1639041960, 1),
(7, '2021-12-09-082117', 'App\\Database\\Migrations\\AddAdmin', 'default', 'App', 1639041960, 1),
(8, '2021-12-09-090312', 'App\\Database\\Migrations\\AddSupplier', 'default', 'App', 1639041960, 1),
(9, '2022-01-02-121656', 'App\\Database\\Migrations\\AddCatalog', 'default', 'App', 1641127088, 2),
(10, '2022-01-02-121707', 'App\\Database\\Migrations\\AddItemCatalog', 'default', 'App', 1641127088, 2),
(11, '2022-01-18-025339', 'App\\Database\\Migrations\\AddCart', 'default', 'App', 1642475049, 3),
(22, '2021-12-09-082053', 'App\\Database\\Migrations\\AddTransaction', 'default', 'App', 1643523056, 4),
(23, '2021-12-09-082108', 'App\\Database\\Migrations\\AddDetailTransaction', 'default', 'App', 1643523056, 4),
(24, '2022-01-30-060111', 'App\\Database\\Migrations\\AddKurir', 'default', 'App', 1643523056, 4),
(25, '2022-02-01-063226', 'App\\Database\\Migrations\\AddWaktu', 'default', 'App', 1643697383, 5);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(16) UNSIGNED NOT NULL,
  `category_id` int(16) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` int(16) NOT NULL,
  `discon` varchar(16) NOT NULL DEFAULT '0',
  `max_buy_discon` int(16) NOT NULL DEFAULT 0,
  `stock` int(16) NOT NULL DEFAULT 0,
  `information` text NOT NULL,
  `image` text NOT NULL,
  `per` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `discon`, `max_buy_discon`, `stock`, `information`, `image`, `per`, `created_at`, `updated_at`) VALUES
(5, 5, 'Kayu Manis Sekali', 'kayu-manis-sekali', 'Manis bro', 12000, '5%', 2, 100, '{\"product_information\":\"Ini Informasi Produknya\",\"nutrition_and_benefits\":\"Mantaps\",\"how_to_save\":\"Kulkas Lah\",\"farmers_and_suppliers\":[\"1\",\"4\"]}', 'files/product/1641651893_66a9c9ae003128960d0b.jpeg', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 5, 'Burger Besar', 'burger-besar', 'nice', 32000, '0', 0, 34, '{\"product_information\":\"Info Burger\",\"nutrition_and_benefits\":\"Nutrisi Burger\",\"how_to_save\":\"Save Lah\",\"farmers_and_suppliers\":[\"4\"]}', 'files/product/1641989650_009408cf4f502f44d4ee.png', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 4, 'Kelapa', 'kelapa', 'Kelapa Tua/gram', 20000, '0', 0, 20, '{\"product_information\":\"Info Kelapa\",\"nutrition_and_benefits\":\"Nutrisi Kelapa\",\"how_to_save\":\"Save Lah\",\"farmers_and_suppliers\":[\"1\"]}', 'files/product/1642145225_20c3ca0bedf23f799bc6.jpeg', 'gram', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 5, 'App', 'app', '500 per kg', 20000, '5%', 5, 200, '{\"product_information\":\"Gabskjbakjbd\",\"nutrition_and_benefits\":\"bener\",\"how_to_save\":\"save lah\",\"farmers_and_suppliers\":[\"1\",\"4\"]}', 'files/product/1643608114_a1a1940555076914ac3d.jpeg', 'kg', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(16) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'APlikasi', 'files/supplier/1643601031_2c927a57687f6fc45b5c.jpeg', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Toefl', 'files/supplier/1643601269_295053bb5d3165096500.png', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Buah', 'files/supplier/1643601197_4162fce7549f4ea4dd31.png', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(16) UNSIGNED NOT NULL,
  `no_transaction` varchar(100) NOT NULL,
  `user_id` int(16) UNSIGNED DEFAULT NULL,
  `data_delivery` text NOT NULL,
  `process` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `status` enum('0','1','-1') NOT NULL DEFAULT '0',
  `kurir_id` int(16) UNSIGNED DEFAULT NULL,
  `kurir_status` enum('0','1','-1') NOT NULL,
  `payment_id` varchar(60) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `no_transaction`, `user_id`, `data_delivery`, `process`, `status`, `kurir_id`, `kurir_status`, `payment_id`, `created_at`, `updated_at`) VALUES
(3, 'TBS-2279V0279V05-QA', 1, '{\"address\":\"jauh\",\"phone\":\"6285608658161\",\"waktu\":\"Slot Pagi | 12:00 - 14:00 WIB\",\"catatan\":\"nice\",\"fullname\":\"Lukman Hakim\"}', '1', '0', NULL, '0', '61ff3ef35c046534b0e42427', '2022-02-07 21:22:29', '2022-02-07 21:22:29'),
(4, 'TBS-2279V0279V05-SA', 1, '{\"address\":\"jauh\",\"phone\":\"6285608658161\",\"waktu\":\"Slot Pagi | 12:00 - 14:00 WIB\",\"catatan\":\"nice\",\"fullname\":\"Lukman Hakim\"}', '0', '-1', NULL, '0', '', '2022-02-07 21:22:29', '2022-02-07 21:22:29'),
(5, 'TBS-2279V0279V05-LU', 1, '{\"address\":\"jauh\",\"phone\":\"6285608658161\",\"waktu\":\"Slot Pagi | 12:00 - 14:00 WIB\",\"catatan\":\"nice\",\"fullname\":\"Lukman Hakim\"}', '3', '1', NULL, '0', '61ff3ef35c046534b0e42427', '2022-02-07 21:22:29', '2022-02-07 21:22:29'),
(6, 'TBS-22HJB02HJB07-BY', 1, '{\"address\":\"jauh\",\"phone\":\"6285608658161\",\"waktu\":\"Slot Pagi | 12:00 - 14:00 WIB\",\"catatan\":\"bb\",\"fullname\":\"Lukman Hakim\"}', '1', '0', NULL, '0', '', '2022-02-07 22:51:43', '2022-02-07 22:51:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(16) UNSIGNED NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `phone`, `password`, `address`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Lukman Hakim', '6285608658161', '$2y$10$dic/pYZQHXl7XBg/BMFpbeZ4QfaAPyn7NcGroHrsgaTZkSBNtbZjK', 'jauh', NULL, '2022-02-05 14:57:53', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `waktu`
--

CREATE TABLE `waktu` (
  `id` int(16) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `start` varchar(16) DEFAULT NULL,
  `end` varchar(16) DEFAULT NULL,
  `timezone` varchar(16) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `waktu`
--

INSERT INTO `waktu` (`id`, `name`, `start`, `end`, `timezone`, `created_at`, `updated_at`) VALUES
(3, 'Slot Pagi', '12:00', '14:00', 'WIB', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Slot SOre', '15:00', '16:00', 'WIB', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `detail_transaction`
--
ALTER TABLE `detail_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_catalog`
--
ALTER TABLE `item_catalog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kurir`
--
ALTER TABLE `kurir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`phone`);

--
-- Indexes for table `waktu`
--
ALTER TABLE `waktu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `detail_transaction`
--
ALTER TABLE `detail_transaction`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `item_catalog`
--
ALTER TABLE `item_catalog`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kurir`
--
ALTER TABLE `kurir`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `waktu`
--
ALTER TABLE `waktu`
  MODIFY `id` int(16) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
