-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2025 at 02:35 PM
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
-- Database: `restaurant_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Mandi', 'Traditional Yemeni rice and chicken dish', '2024-12-01 00:00:00', '2024-12-01 00:00:00'),
(2, 'Zurbian', 'Spicy rice and chicken dish', '2024-12-01 00:00:00', '2024-12-01 00:00:00'),
(3, 'Desserts', 'Traditional Yemeni sweets', '2024-12-01 00:00:00', '2024-12-01 00:00:00'),
(4, 'Appetizers', 'Traditional Yemeni starters', '2024-12-02 00:00:00', '2024-12-02 00:00:00'),
(5, 'Beverages', 'Refreshing Yemeni drinks', '2024-12-02 00:00:00', '2024-12-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `menu_item_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(6,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `availability` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`menu_item_id`, `name`, `description`, `price`, `image_url`, `category_id`, `availability`, `created_at`, `updated_at`) VALUES
(1, 'Chicken Mandi', 'Delicious chicken mandi with basmati rice', 8.99, 'img/chickenmandi.jpeg', 1, 1, '2024-12-01 00:00:00', '2024-12-01 00:00:00'),
(2, 'Beef Mandi', 'Juicy beef mandi with spices', 10.99, 'img/beefmandi.jpg', 1, 1, '2024-12-01 00:00:00', '2024-12-01 00:00:00'),
(3, 'Chicken Zurbian', 'Spicy chicken zurbian with rice', 9.49, 'img/zurbian.jpg', 2, 1, '2024-12-01 00:00:00', '2024-12-01 00:00:00'),
(4, 'Basbousa', 'Traditional Yemeni sweet cake', 3.99, 'img/basbousa.jpg', 3, 1, '2024-12-01 00:00:00', '2024-12-02 00:00:00'),
(5, 'Haneeth Lamb', 'Yemeni slow-cooked lamb with rice', 12.99, 'img/haneeth.jpeg', 1, 1, '2024-12-01 00:00:00', '2024-12-02 00:00:00'),
(6, 'Saltah', 'Traditional Yemeni stew served with bread', 7.99, 'img/saltah.jpg', 2, 1, '2024-12-02 00:00:00', '2024-12-02 00:00:00'),
(7, 'Bint Al-Sahn', 'Yemeni honey cake served with ghee', 4.99, 'img/binta.jpg', 3, 1, '2024-12-02 00:00:00', '2024-12-02 00:00:00'),
(8, 'Qishr', 'Yemeni coffee with ginger', 2.49, 'img/qishr.jpeg', 5, 1, '2024-12-02 00:00:00', '2024-12-02 00:00:00'),
(9, 'Maraq', 'Yemeni broth served as a starter', 4.99, 'img/maraq.jpg', 4, 1, '2024-12-02 00:00:00', '2024-12-02 00:00:00'),
(10, 'Fattah', 'Yemeni bread pudding with honey and ghee', 6.99, 'img/fattah.jpeg', 3, 1, '2024-12-02 00:00:00', '2024-12-02 00:00:00'),
(11, 'Fahsa', 'Yemeni beef stew with fenugreek', 9.99, 'img/fahsa.jpg', 2, 1, '2024-12-02 00:00:00', '2024-12-02 00:00:00'),
(12, 'Malawah Bread', 'Traditional Yemeni flatbread', 2.99, 'malawah bread.jpg', 4, 0, '2024-12-02 00:00:00', '2024-12-02 00:00:00'),
(13, 'Shaffot', 'Yemeni layered bread with yogurt and herbs', 5.99, 'img/shaffot.jpg', 4, 1, '2024-12-02 00:00:00', '2024-12-02 00:00:00'),
(14, 'Yemeni Spiced Tea', 'Aromatic tea infused with cardamom and cinnamon', 1.99, 'img/shai.jpg', 5, 1, '2024-12-02 00:00:00', '2024-12-02 00:00:00'),
(15, 'Hilbeh', 'Fenugreek paste served as a side dish', 3.99, 'hilbeh.jpg', 4, 0, '2024-12-02 00:00:00', '2024-12-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_status` varchar(50) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `total_price` decimal(6,2) DEFAULT NULL,
  `delivery_address` varchar(255) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_status`, `order_date`, `total_price`, `delivery_address`, `payment_status`, `created_at`, `updated_at`) VALUES
(1, 1, 'delivered', '2024-12-03', 12.98, 'Sana\'a, Yemen', 'paid', '2024-12-03 00:00:00', '2024-12-03 00:00:00'),
(2, 2, 'pending', '2024-12-04', 18.48, 'Aden, Yemen', 'unpaid', '2024-12-04 00:00:00', '2024-12-04 00:00:00'),
(3, 4, 'in_progress', '2024-12-05', 15.99, 'Taiz, Yemen', 'unpaid', '2024-12-05 00:00:00', '2024-12-05 00:00:00'),
(4, 5, 'delivered', '2024-12-05', 19.48, 'Mukalla, Yemen', 'paid', '2024-12-05 00:00:00', '2024-12-05 00:00:00'),
(5, 9, 'delivered', '2024-12-05', 22.48, 'Taiz, Yemen', 'paid', '2024-12-05 00:00:00', '2024-12-05 00:00:00'),
(6, 10, 'in_progress', '2024-12-05', 15.98, 'Aden, Yemen', 'unpaid', '2024-12-05 00:00:00', '2024-12-05 00:00:00'),
(7, 11, 'pending', '2024-12-05', 18.99, 'Hodeidah, Yemen', 'unpaid', '2024-12-06 00:00:00', '2024-12-06 00:00:00'),
(8, 12, 'delivered', '2024-12-05', 25.47, 'Sana\'a, Yemen', 'paid', '2024-12-07 00:00:00', '2024-12-07 00:00:00'),
(9, 13, 'cancelled', '2024-12-05', 0.00, 'Mukalla, Yemen', 'unpaid', '2024-12-08 00:00:00', '2024-12-08 00:00:00'),
(14, 18, 'pending', '2024-12-13', 37.96, 'Aleea Zamora 3, bl. 112B, sc. B, ap. 40', 'pending', '2024-12-13 10:43:07', '2024-12-13 10:43:07'),
(15, 28, 'pending', '2024-12-17', 3.99, 'What is adresa livrare and bench', 'unpaid', '2024-12-17 17:11:54', '2024-12-17 17:11:54'),
(16, 18, 'pending', '2024-12-17', 2.49, 'Aleea Zamora 3, bl. 112B, sc. B, ap. 40', 'paid', '2024-12-17 20:09:43', '2024-12-17 20:09:43'),
(17, 31, 'pending', '2024-12-17', 6169.00, 'Storting building, Karl Johans gt. 22, 0026 Oslo, Norway', 'pending', '2024-12-17 22:41:21', '2024-12-17 22:41:21'),
(18, 31, 'pending', '2024-12-17', 3383.48, 'Storting building, Karl Johans gt. 22, 0026 Oslo, Norway', 'pending', '2024-12-17 22:43:34', '2024-12-17 22:43:34'),
(19, 18, 'pending', '2025-01-08', 32.97, 'Aleea Zamora 3, bl. 112B, sc. B, ap. 40', 'pending', '2025-01-08 14:24:12', '2025-01-08 14:24:12'),
(20, 18, 'pending', '2025-01-15', 21.98, 'Aleea Zamora 3, bl. 112B, sc. B, ap. 40', 'unpaid', '2025-01-15 22:03:41', '2025-01-15 22:03:41'),
(21, 18, 'pending', '2025-01-15', 8.99, 'Aleea Zamora 3, bl. 112B, sc. B, ap. 40', 'pending', '2025-01-15 22:04:14', '2025-01-15 22:04:14'),
(22, 29, 'pending', '2025-01-15', 51.43, 'Brașov, Strada Universității nr 1', 'pending', '2025-01-15 22:07:18', '2025-01-15 22:07:18'),
(23, 18, 'pending', '2025-01-15', 132.87, 'Aleea Zamora 3, bl. 112B, sc. B, ap. 40', 'paid', '2025-01-15 23:42:15', '2025-01-15 23:42:15'),
(24, 18, 'pending', '2025-01-15', 8.99, 'Aleea Zamora 3, bl. 112B, sc. B, ap. 40', 'pending', '2025-01-15 23:43:53', '2025-01-15 23:43:53'),
(25, 18, 'pending', '2025-01-15', 27.97, 'Aleea Zamora 3, bl. 112B, sc. B, ap. 40', 'pending', '2025-01-15 23:50:05', '2025-01-15 23:50:05'),
(26, 33, 'pending', '2025-01-16', 0.00, 'Brașov', 'pending', '2025-01-16 10:05:53', '2025-01-16 10:05:53');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `menu_item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal_price` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `menu_item_id`, `quantity`, `subtotal_price`) VALUES
(1, 1, 1, 1, 8.99),
(2, 2, 4, 1, 3.99),
(3, 2, 2, 1, 10.99),
(4, 2, 3, 1, 9.49),
(5, 3, 5, 1, 12.99),
(6, 4, 6, 2, 15.98),
(7, 4, 8, 1, 2.49),
(8, 5, 9, 1, 4.99),
(9, 5, 7, 1, 6.99),
(10, 6, 7, 1, 9.98),
(11, 7, 8, 1, 7.99),
(12, 8, 3, 1, 9.98),
(13, 8, 10, 1, 7.47),
(14, 8, 4, 1, 4.99),
(15, 9, 11, 0, 6.99),
(16, 6, 12, 1, 2.99),
(22, 14, 3, 4, 37.96),
(23, 15, 4, 1, 3.99),
(24, 16, 8, 1, 2.49),
(25, 17, 14, 3100, 6169.00),
(26, 18, 4, 251, 1001.49),
(27, 18, 3, 251, 2381.99),
(28, 19, 2, 3, 32.97),
(29, 20, 2, 2, 21.98),
(30, 21, 1, 1, 8.99),
(31, 22, 2, 1, 10.99),
(32, 22, 5, 1, 12.99),
(33, 22, 4, 1, 3.99),
(34, 22, 7, 1, 4.99),
(35, 22, 8, 1, 2.49),
(36, 22, 11, 1, 9.99),
(37, 22, 13, 1, 5.99),
(38, 23, 1, 5, 44.95),
(39, 23, 2, 8, 87.92),
(40, 24, 1, 1, 8.99),
(41, 25, 1, 1, 8.99),
(42, 25, 3, 2, 18.98),
(43, 26, 1, 0, 0.00),
(44, 26, 3, 0, 0.00),
(45, 26, 4, 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `amount` decimal(6,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `payment_method`, `payment_date`, `amount`, `status`) VALUES
(1, 1, 'card', '2024-12-03', 12.98, 'success'),
(2, 2, 'cash', '2024-12-04', 0.00, 'pending'),
(3, 3, 'paypal', '2024-12-05', 0.00, 'pending'),
(4, 4, 'card', '2024-12-05', 19.48, 'success'),
(5, 5, 'card', '2024-12-05', 22.49, 'success'),
(6, 6, 'cash', '2024-12-05', 0.00, 'pending'),
(7, 7, 'paypal', '2024-12-05', 18.99, 'pending'),
(8, 8, 'card', '2024-12-05', 25.47, 'success'),
(9, 9, 'cash', '2024-12-05', 0.00, 'cancelled'),
(14, 14, 'cash', '2024-12-13', 37.96, 'pending'),
(15, 16, 'card', '2024-12-17', 2.49, 'paid'),
(16, 17, 'cash', '2024-12-17', 6169.00, 'pending'),
(17, 18, 'cash', '2024-12-17', 3383.48, 'pending'),
(18, 19, 'cash', '2025-01-08', 32.97, 'pending'),
(19, 21, 'cash', '2025-01-15', 8.99, 'pending'),
(20, 22, 'cash', '2025-01-15', 51.43, 'pending'),
(21, 23, 'paypal', '2025-01-15', 132.87, 'paid'),
(22, 24, 'cash', '2025-01-15', 8.99, 'pending'),
(23, 25, 'cash', '2025-01-15', 27.97, 'pending'),
(24, 26, 'cash', '2025-01-16', 0.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time` time NOT NULL,
  `persons` int(11) NOT NULL,
  `details` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `user_id`, `reservation_date`, `reservation_time`, `persons`, `details`, `status`, `created_at`) VALUES
(1, 18, '2025-01-24', '13:24:00', 6, 'Am dori 2 mese, una de 4 persoane, alta de 2.\r\nMultumim!', 'pending', '2025-01-15 21:24:24'),
(2, 33, '2025-01-16', '11:47:00', 5, '', 'pending', '2025-01-16 10:06:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `is_confirmed` tinyint(1) DEFAULT 0,
  `confirmation_token` varchar(64) DEFAULT NULL,
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone`, `role`, `address`, `created_at`, `updated_at`, `profile_image`, `is_confirmed`, `confirmation_token`, `reset_token`, `reset_expires`) VALUES
(1, 'Ali Ahmed', 'ali.ahmed@gmail.com', 'hashed_password', '1234567890', 'customer', 'Sana\'a, Yemen', '2024-12-01 00:00:00', '2024-12-01 00:00:00', NULL, 0, NULL, NULL, NULL),
(2, 'Fatima Saeed', 'fatima.saeed@gmail.com', 'hashed_password', '1234567891', 'customer', 'Aden, Yemen', '2024-12-02 00:00:00', '2024-12-02 00:00:00', NULL, 0, NULL, NULL, NULL),
(3, 'Manager Hassan', 'manager.hassan@restaurant.com', 'hashed_password', '9876543210', 'admin', 'Office', '2024-12-01 00:00:00', '2024-12-05 00:00:00', NULL, 0, NULL, NULL, NULL),
(4, 'Khalid Mohamed', 'khalid.mohamed@gmail.com', 'hashed_password', '1234567892', 'customer', 'Taiz, Yemen', '2024-12-02 00:00:00', '2024-12-02 00:00:00', NULL, 0, NULL, NULL, NULL),
(5, 'Aisha Omar', 'aisha.omar@gmail.com', 'hashed_password', '1234567893', 'customer', 'Mukalla, Yemen', '2024-12-02 00:00:00', '2024-12-02 00:00:00', NULL, 0, NULL, NULL, NULL),
(6, 'Yousef Saleh', 'yousef.saleh@gmail.com', 'hashed_password', '1234567894', 'customer', 'Hodeidah, Yemen', '2024-12-02 00:00:00', '2024-12-02 00:00:00', NULL, 0, NULL, NULL, NULL),
(7, 'Sarah Ali', 'sarah.ali@gmail.com', 'hashed_password', '1234567895', 'customer', 'Aden, Yemen', '2024-12-02 00:00:00', '2024-12-02 00:00:00', NULL, 0, NULL, NULL, NULL),
(8, 'Ibrahim Said', 'ibrahim.said@gmail.com', 'hashed_password', '1234567895', 'customer', 'Sana\'a, Yemen', '2024-12-02 00:00:00', '2024-12-02 00:00:00', NULL, 0, NULL, NULL, NULL),
(9, 'Salma Naji', 'salma.naji@gmail.com', 'hashed_password', '1234567895', 'customer', 'Taiz, Yemen', '2024-12-02 00:00:00', '2024-12-02 00:00:00', NULL, 0, NULL, NULL, NULL),
(10, 'Omar Saeed', 'omar.saeed@gmail.com', 'hashed_password', '1564861684', 'delivery', 'Aden, Yemen', '2024-12-02 00:00:00', '2024-12-02 00:00:00', NULL, 0, NULL, NULL, NULL),
(11, 'Layla Al-Habsi', 'layla.habsi@gmail.com', 'hashed_password', '1568413215', 'delivery', 'Hodeidah, Yemen', '2024-12-02 00:00:00', '2024-12-02 00:00:00', NULL, 0, NULL, NULL, NULL),
(12, 'Abdul Karim', 'abdul.karim@gmail.com', 'hashed_password', '8791234984', 'chef', 'Sana\'a, Yemen', '2024-12-02 00:00:00', '2024-12-02 00:00:00', NULL, 0, NULL, NULL, NULL),
(13, 'Yasmin Fathi', 'yasmin.fathi@gmail.com', 'hashed_password', '1564841351', 'customer', 'Mukalla, Yemen', '2024-12-02 00:00:00', '2024-12-02 00:00:00', NULL, 0, NULL, NULL, NULL),
(18, 'Mihail-Eduard Caltun', 'caltun.niocol@gmail.com', '$2y$10$iXFkmkgOjUlMf.wEDzCXMu2n8KuXidHSZKQCsTGCvvvJ4AN/Sno4a', NULL, 'admin', 'Aleea Zamora 3, bl. 112B, sc. B, ap. 40', '2024-12-11 18:24:51', '2024-12-11 18:24:51', 'uploads/1736971139_logo.jpg', 1, NULL, '7137218b321ed25ef828a3c47470abc1620fce766ecd3beed9c04a0b398f1de8', '2025-01-21 20:01:15'),
(20, 'teo21', 'furnicadarius@gmail.com', '$2y$10$Ue.TUpJ/cHeSpXH6PspBYOo4EQXhB3rMUNTR88fDCsPbavhEAYzwi', NULL, 'customer', 'strada burebista', '2024-12-13 11:32:23', '2024-12-13 11:32:23', NULL, 0, '271b3161f4afe582fc6ad3d9e75e5c5ea10a9ca6ec90f4efcd9033172ea842d0', NULL, NULL),
(24, 'mert K', 'gogogo1_31@hotmail.com', '$2y$10$O6sbdY/7zhY367bM/puTPuCXKvCH9JjAg8rJkX3MjAtX5wd1JnEPC', NULL, 'customer', 'salut mihail', '2024-12-17 11:11:44', '2024-12-17 11:11:44', NULL, 0, '772cbac37fd67bed96e0eace38f49849b0a759d5819462595ea947b82b8dd31e', NULL, NULL),
(25, 'Osamah ', 'osamah.m.alarabi@gmail.com', '$2y$10$lhkawXRt6o06wUvhOlkm0uKuHwR94XiNHqtEW67jFKh9Q2Z4V0jXO', NULL, 'customer', 'Greenland, near Iceland ', '2024-12-17 11:13:05', '2024-12-17 11:13:05', NULL, 1, NULL, NULL, NULL),
(26, 'Muhammed Tetik', 'mtetik245@gmail.com', '$2y$10$BjQsi.06VKssyjDNIj39wecie3Os511GVcuiHHdzRbQyZY3gMO9E.', NULL, 'customer', 'Strada Universității Nr. 1', '2024-12-17 11:21:14', '2024-12-17 11:21:14', NULL, 1, NULL, NULL, NULL),
(27, 'Aydın', 'negiz1235_negiz5321@hotmail.com', '$2y$10$s7LfI1YX07zc5nEeKw0rkeo6rrm5wFhkqmH5gnygIkUj43y80LHT6', NULL, 'customer', 'Memo dorm', '2024-12-17 11:29:13', '2024-12-17 11:29:13', NULL, 1, NULL, NULL, NULL),
(28, 'Anna', 'akjanowi@gmail.com', '$2y$10$OnEONxM3zHXBJmh1NS0XMOD.e5Xyt1tzhi9Y3oYXN2S6dhNWDjqF2', NULL, 'customer', 'What is adresa livrare and bench', '2024-12-17 17:08:27', '2024-12-17 17:08:27', 'uploads/1734444507_C5503C06-749E-40EB-88F0-D4367E28D4E8.jpeg', 1, NULL, NULL, NULL),
(29, 'Kris', 'cristian.a.davidoiu@gmail.com', '$2y$10$0caThTTPc40GC/FzOCl1z.Pj/WCnpmD14juZb3C7USdD3mpzU/Y.C', NULL, 'customer', 'Brașov, Strada Universității nr 1', '2024-12-17 17:10:06', '2024-12-17 17:10:06', NULL, 1, NULL, NULL, NULL),
(30, 'Giota', 'mpozinipanagiota2@gmail.com', '$2y$10$TZV/iX/e2Cih8DohQ/72zee4jAwZnBfcTKkv/HVT.OOeFKrOFRQn.', NULL, 'customer', 'Arcca vitan', '2024-12-17 20:00:21', '2024-12-17 20:00:21', NULL, 1, NULL, 'a4362a532421a60bc3d46bd89e4ec3a80926910fc601f2c1d3d162ab6e6a628f', '2024-12-17 19:03:12'),
(31, 'Jonas Gahr Store', 'Boganescu.Stefan@gmail.com', '$2y$10$Mz5V/l0czYXW6z4if0XhDOhPjtLcNDgK22GArRAuz.tw7v1x.Asdy', NULL, 'customer', 'Storting building, Karl Johans gt. 22, 0026 Oslo, Norway', '2024-12-17 22:37:30', '2024-12-17 22:37:30', 'uploads/1734464250_Nordic_prime_ministers’_meeting_in_Helsinki_1.11.2022_-_52469398971_(cropped).jpg', 1, NULL, NULL, NULL),
(32, 'Posta Romana', 'caltun.mihail@gmail.com', '$2y$10$ntbagAyi/MxVFngj8oucNukRuHFwhXvLVCjHReSvh5MMlvEgHgs96', NULL, 'customer', 'Strada Universitatii', '2025-01-15 21:16:32', '2025-01-15 21:16:32', NULL, 1, NULL, NULL, NULL),
(33, 'Madalina Secara', 'madalina.elyza27@gmail.com', '$2y$10$xU6lkPXzIgy3r7D8GocXKe3t9YUrW7kghTdm/UZNFcGARxLBCFXkq', NULL, 'customer', 'Brașov', '2025-01-16 10:04:17', '2025-01-16 10:04:17', NULL, 1, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`menu_item_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_item_id` (`menu_item_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `menu_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu_items` (`menu_item_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
