-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2024 at 09:17 AM
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
-- Database: `food_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'ainnisriena', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(3, 'aireensofea', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(8, 2, 2, 'pandan cake', 15, 1, 'pandan cake.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `custommessage`
--

CREATE TABLE `custommessage` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 1, 'ain', 'ain123@gmail.com', '011111', 'sedap gila  kakak kedai you');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `receipt_filename` varchar(255) DEFAULT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `pickup_date` date DEFAULT NULL,
  `pickup_time` time DEFAULT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
  `custom_message` text DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `total_products`, `total_price`, `receipt_filename`, `placed_on`, `pickup_date`, `pickup_time`, `payment_status`, `custom_message`, `status`) VALUES
(1, 1, 'ryn', '0111111111', 'ain123@gmail.com', 'cookies (10 x 1) - ', 10, 'admin/receipts/uploaded_receipts/Receipt.pdf', '2024-07-07', '2024-07-23', '14:02:00', 'pending', 'haloo', 'completed'),
(2, 1, 'ryn', '0111111111', 'ain123@gmail.com', 'cookies (10 x 1) - ', 10, 'admin/receipts/uploaded_receipts/Receipt.pdf', '2024-07-07', '2024-07-23', '14:02:00', 'pending', 'haloo', 'completed'),
(3, 1, 'ryn', '0111111111', 'ain123@gmail.com', 'cookies (10 x 1) - ', 10, 'admin/receipts/uploaded_receipts/kucin.jpg', '2024-07-07', '2024-07-24', '21:35:00', 'pending', 'tambah 1', 'completed'),
(4, 1, 'ryn', '0111111111', 'ain123@gmail.com', 'pandan cake (15 x 3) - ', 45, 'admin/receipts/uploaded_receipts/pin bsn.png', '2024-07-07', '2024-07-31', '20:38:00', 'pending', 'extar pandan', 'completed'),
(6, 1, 'ryn', '0111111111', 'ain123@gmail.com', 'cookies (10 x 1) - ', 10, 'admin/receipts/uploaded_receipts/pin bsn.png', '2024-07-07', '2024-07-31', '07:03:00', 'pending', 'jkrfhlykg', 'completed'),
(8, 2, 'yeen', '0122222222', 'aireens@gmail.com', 'pandan cake (15 x 3) - ', 45, 'admin/receipts/uploaded_receipts/Screenshot 2024-07-03 120736.png', '2024-07-07', '2024-07-09', '16:54:00', 'pending', 'extra makan', 'completed'),
(9, 1, 'ryn', '0111111111', 'ain123@gmail.com', 'cookies (10 x 3) - ', 30, 'admin/receipts/uploaded_receipts/contactus.jpeg', '2024-07-08', '2024-07-23', '23:52:00', 'pending', 'maseh ', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(15000) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) VALUES
(1, 'cookies', 'eh tdila', 10, 'cookies.jpg'),
(2, 'pandan cake', 'sedap', 15, 'pandan cake.jpg'),
(3, 'brownies', 'moist', 15, 'brownies.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_id` int(11) DEFAULT NULL,
  `review` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`, `order_id`, `review`) VALUES
(1, 1, 0, 1, NULL, '2024-07-07 07:22:51', 1, 'sedap angat'),
(2, 1, 0, 3, NULL, '2024-07-07 08:38:41', 2, 'sedap'),
(3, 1, 0, 4, NULL, '2024-07-07 08:43:50', 4, 'ok'),
(4, 1, 0, 5, NULL, '2024-07-07 09:05:43', 6, 'dskjfhg'),
(5, 1, 0, 1, NULL, '2024-07-07 15:43:27', 3, 'hii beli ok'),
(6, 2, 0, 5, NULL, '2024-07-07 15:55:23', 8, 'okay je');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`) VALUES
(1, 'ryn', 'ain123@gmail.com', '0111111111', 'bf4db86a463c694b4af81e43d12e9310ee8fc36a'),
(2, 'yeen', 'aireens@gmail.com', '0122222222', 'ca2b4227155c3857e44368c8827fdea5d8f4e086');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custommessage`
--
ALTER TABLE `custommessage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `custommessage`
--
ALTER TABLE `custommessage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `custommessage`
--
ALTER TABLE `custommessage`
  ADD CONSTRAINT `custommessage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
