-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2026 at 08:22 AM
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
-- Database: `spare_parts_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Engine Parts', 'Engine components', '2026-11-04 17:20:04'),
(2, 'Brake Parts', 'Brake system components', '2026-11-04 17:20:04'),
(3, 'Electrical', 'Electrical parts and accessories', '2026-11-04 17:20:04'),
(4, 'Filters', 'Oil, air and fuel filters', '2026-11-04 17:20:04'),
(5, 'HORSE', 'AIR HORSE OIL HORSE DIESEL HORSE', '2026-11-05 05:13:13');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(160) NOT NULL,
  `phone` varchar(40) DEFAULT NULL,
  `email` varchar(190) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `customer_type` enum('cash','credit') NOT NULL DEFAULT 'cash',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `email`, `address`, `customer_type`, `created_at`, `balance`) VALUES
(1, 'Walk-in Customer', '', NULL, NULL, 'cash', '2026-11-04 17:20:04', 0.00),
(2, 'Demo Credit Customer', '0710000000', NULL, NULL, 'credit', '2026-11-04 17:20:04', 12550.00),
(3, 'SUNIMAL FERNANDO', '0777123456', '', 'KATANA', 'credit', '2026-11-05 06:24:10', 13950.00);

-- --------------------------------------------------------

--
-- Table structure for table `customer_payments`
--

CREATE TABLE `customer_payments` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_payments`
--

INSERT INTO `customer_payments` (`id`, `customer_id`, `user_id`, `amount`, `note`, `created_at`) VALUES
(1, 2, 1, 2000.00, 'CASH', '2026-11-05 06:18:48'),
(2, 3, 2, 10000.00, 'CHEQUE#224835', '2026-11-05 06:32:45'),
(3, 2, 2, 1000.00, 'CASH', '2026-11-05 06:34:04');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(80) NOT NULL,
  `name` varchar(180) NOT NULL,
  `description` text DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand` varchar(120) DEFAULT NULL,
  `item_location` varchar(100) DEFAULT NULL,
  `cost_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `selling_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `stock_qty` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `reorder_level` int(10) UNSIGNED NOT NULL DEFAULT 5,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `description`, `category_id`, `brand`, `item_location`, `cost_price`, `selling_price`, `stock_qty`, `reorder_level`, `supplier_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 'ENG-001', 'Oil Filter', NULL, 4, 'Bosch', 'A-01', 850.00, 1100.00, 24, 5, 1, NULL, '2026-11-04 17:20:04', '2026-11-05 02:17:05'),
(2, 'BRK-001', 'Brake Pad Set', NULL, 2, 'Advics', 'B-03', 4500.00, 5900.00, 6, 3, 1, NULL, '2026-11-04 17:20:04', '2026-11-05 06:24:48'),
(3, 'ELC-001', 'Headlight Bulb', NULL, 3, 'Philips', 'C-02', 1200.00, 1650.00, 0, 5, 1, NULL, '2026-11-04 17:20:04', '2026-11-05 02:11:03'),
(4, 'A5002', 'Air Filter', NULL, 4, 'VIC', 'C-05', 1100.00, 2950.00, 1, 5, 1, NULL, '2026-11-04 17:57:22', '2026-11-05 02:34:23'),
(7, 'YN-6062', 'led head light', 'hilux', 3, 'Kaire', 'D-06', 5000.00, 13500.00, 3, 2, 1, NULL, '2026-11-05 03:21:44', '2026-11-05 06:28:20'),
(8, 'O305', 'O-305 OIL FILTER', 'CANTER OIL FILTER 4D33 4D34 4D35', 4, 'VIC', 'C-05', 1100.00, 2500.00, 4, 2, 2, NULL, '2026-11-05 05:07:10', '2026-11-05 06:28:20'),
(9, 'HRS2345', 'AIR CLEANER HORSE', 'ISUZU 4JJ1 AIR CLEANER HORSE', 5, 'NEW BRAND', 'F-01', 1100.00, 2050.00, 2, 2, 1, NULL, '2026-11-05 05:16:49', '2026-11-05 06:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `invoice_no`, `customer_id`, `user_id`, `total_amount`, `created_at`) VALUES
(1, 'INV-20261105-65C803', NULL, 1, 1650.00, '2026-11-05 02:06:24'),
(2, 'INV-20261105-16F9A5', NULL, 1, 1650.00, '2026-11-05 02:11:03'),
(3, 'INV-20261105-AA6AFD', NULL, 1, 7000.00, '2026-11-05 02:17:05'),
(4, 'INV-20261105-2CCFD1', NULL, 2, 5900.00, '2026-11-05 02:34:23'),
(5, 'INV-20261105-C71BB4', 2, 1, 2050.00, '2026-11-05 05:46:00'),
(9, 'INV-20261105-B3AE73', 2, 1, 2050.00, '2026-11-05 06:12:46'),
(10, 'INV-20261105-DD6136', 2, 1, 13500.00, '2026-11-05 06:19:19'),
(11, 'INV-20261105-701730', 3, 1, 5900.00, '2026-11-05 06:24:48'),
(12, 'INV-20261105-61E13D', 3, 2, 18050.00, '2026-11-05 06:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `cost_price` decimal(12,2) NOT NULL,
  `line_total` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `quantity`, `unit_price`, `cost_price`, `line_total`) VALUES
(1, 1, 3, 1, 1650.00, 1200.00, 1650.00),
(2, 2, 3, 1, 1650.00, 1200.00, 1650.00),
(3, 3, 1, 1, 1100.00, 850.00, 1100.00),
(4, 3, 2, 1, 5900.00, 4500.00, 5900.00),
(5, 4, 4, 2, 2950.00, 1100.00, 5900.00),
(6, 5, 9, 1, 2050.00, 1100.00, 2050.00),
(10, 9, 9, 1, 2050.00, 1100.00, 2050.00),
(11, 10, 7, 1, 13500.00, 5000.00, 13500.00),
(12, 11, 2, 1, 5900.00, 4500.00, 5900.00),
(13, 12, 7, 1, 13500.00, 5000.00, 13500.00),
(14, 12, 8, 1, 2500.00, 1100.00, 2500.00),
(15, 12, 9, 1, 2050.00, 1100.00, 2050.00);

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `movement_type` enum('IN','OUT','ADJUSTMENT') NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `product_id`, `user_id`, `movement_type`, `quantity`, `note`, `created_at`) VALUES
(1, 4, 1, 'IN', 1, 'Return', '2026-11-04 19:20:23'),
(2, 3, 1, 'OUT', 1, 'Sale INV-20261105-65C803', '2026-11-05 02:06:24'),
(3, 3, 1, 'OUT', 1, 'Sale INV-20261105-16F9A5', '2026-11-05 02:11:03'),
(4, 1, 1, 'OUT', 1, 'Sale INV-20261105-AA6AFD', '2026-11-05 02:17:05'),
(5, 2, 1, 'OUT', 1, 'Sale INV-20261105-AA6AFD', '2026-11-05 02:17:05'),
(6, 4, 2, 'OUT', 2, 'Sale INV-20261105-2CCFD1', '2026-11-05 02:34:23'),
(7, 9, 1, 'OUT', 1, 'Sale INV-20261105-C71BB4', '2026-11-05 05:46:00'),
(11, 9, 1, 'OUT', 1, 'Sale INV-20261105-B3AE73', '2026-11-05 06:12:46'),
(12, 7, 1, 'OUT', 1, 'Sale INV-20261105-DD6136', '2026-11-05 06:19:19'),
(13, 2, 1, 'OUT', 1, 'Sale INV-20261105-701730', '2026-11-05 06:24:48'),
(14, 7, 2, 'OUT', 1, 'Sale INV-20261105-61E13D', '2026-11-05 06:28:20'),
(15, 8, 2, 'OUT', 1, 'Sale INV-20261105-61E13D', '2026-11-05 06:28:20'),
(16, 9, 2, 'OUT', 1, 'Sale INV-20261105-61E13D', '2026-11-05 06:28:20');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(160) NOT NULL,
  `phone` varchar(40) DEFAULT NULL,
  `email` varchar(190) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `email`, `address`, `created_at`) VALUES
(1, 'Demo Auto Suppliers', '0770000000', 'supplier@example.com', 'Negombo, Sri Lanka', '2026-11-04 17:20:04'),
(2, 'Anura Traders ', '', '', 'Colombo', '2026-11-04 20:11:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','staff','sales_rep') NOT NULL DEFAULT 'staff',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `is_active`, `created_at`) VALUES
(1, 'System Administrator', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, '2026-11-04 17:20:04'),
(2, 'Store Staff', 'staff@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', 1, '2026-11-04 17:20:04'),
(3, 'Sales Counter', 'sales@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'sales_rep', 1, '2026-11-04 17:20:04'),
(4, 'Shamal Fonseka', 'Shamal@gmail.com', '$2y$10$cvhGB/3uyoyxC8kuM/T0v.sYe8ipR1TovSq1gX9rgh562nowtKGfC', 'admin', 1, '2026-11-05 07:08:16'),
(5, 'Test User', 'test@gmail.com', '$2y$10$oO19j8gFeOcT9OAdDu9xveNK9w3AaiDMAu4Lgv5qydLXYKRvBShhO', 'admin', 1, '2026-11-05 07:21:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_payments`
--
ALTER TABLE `customer_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `fk_product_category` (`category_id`),
  ADD KEY `fk_product_supplier` (`supplier_id`),
  ADD KEY `idx_product_name` (`name`),
  ADD KEY `idx_product_brand` (`brand`),
  ADD KEY `idx_product_location` (`item_location`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_no` (`invoice_no`),
  ADD KEY `idx_sales_created` (`created_at`),
  ADD KEY `idx_customer_id` (`customer_id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sale_item_sale` (`sale_id`),
  ADD KEY `idx_sale_id` (`sale_id`),
  ADD KEY `idx_product_id` (`product_id`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_movement_product` (`product_id`),
  ADD KEY `fk_movement_user` (`user_id`),
  ADD KEY `idx_movement_created` (`created_at`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_payments`
--
ALTER TABLE `customer_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_product_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_sale_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_sale_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `fk_item_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_item_sale` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `fk_movement_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_movement_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
