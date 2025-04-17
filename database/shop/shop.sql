-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2025 at 09:02 PM
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
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `brand_image` varchar(255) NOT NULL,
  `brand_description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`, `brand_image`, `brand_description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Nike', '1743250943.png', 'Nike is a global leader in athletic shoes\r\nand apparel.', 1, '2025-03-21 11:43:20', '2025-03-29 12:22:23'),
(2, 'Adidas', '1743249921.png', 'Adidas is known for innovative sportswear and fashion-forward designs.', 1, '2025-03-21 11:43:20', '2025-03-29 12:05:21'),
(3, 'Puma', '1743250205.png', 'Puma offers high-quality athletic and casual footwear and clothing.', 1, '2025-03-21 11:43:20', '2025-03-29 12:10:05'),
(4, 'Mkurugenzi', '1743250228.jpg', 'Mkurugenzi is a trendy online boutique specializing in contemporary clothing and shoes.', 1, '2025-03-21 11:43:20', '2025-03-29 12:10:28'),
(5, 'GoPrimeHost', '1743250251.jpg', 'GoPrimeHost stands out as an online boutique offering exclusive styles in clothing and shoes.', 1, '2025-03-21 11:43:20', '2025-03-29 12:10:51'),
(6, 'Gucci', '1743250670.png', 'Gucci brings modern elegance to everyday fashion with unique designs.', 1, '2025-03-21 11:43:20', '2025-03-29 12:17:50'),
(7, 'Swahili Elegance', '1743250709.jpg', 'Swahili Elegance features a blend of traditional and modern fashion pieces for a unique look.', 1, '2025-03-21 11:43:20', '2025-03-29 12:18:29'),
(8, 'N/A', '1743250791.png', 'This option is used for products without a specific brand.', 1, '2025-03-21 11:43:20', '2025-03-29 12:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cart_order` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_id` varchar(255) DEFAULT NULL,
  `cart_status` enum('unprocessed','processed') NOT NULL DEFAULT 'unprocessed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `product_id`, `product_name`, `selling_price`, `image`, `quantity`, `user_id`, `email`, `cart_order`, `created_at`, `updated_at`, `session_id`, `cart_status`) VALUES
(23, 4, 'Basketball Sneakers', 4445.00, '1732551333.jpg', 1, 14, 'mark1kinai1@gmail.com', 1, '2025-04-15 18:52:39', '2025-04-15 18:52:48', 'cv5b14jlkea4ptdh4vf224dlj8', 'processed'),
(24, 6, 'Fashion Black Laced', 1500.00, '1732607538.jpg', 1, 14, 'mark1kinai1@gmail.com', 1, '2025-04-15 18:56:33', '2025-04-15 18:56:42', 'cv5b14jlkea4ptdh4vf224dlj8', 'processed'),
(25, 27, 'Manchester United Jersey ', 1700.00, '1732627742.avif', 1, 14, 'mark1kinai1@gmail.com', 1, '2025-04-15 18:57:34', '2025-04-15 18:57:50', 'cv5b14jlkea4ptdh4vf224dlj8', 'processed'),
(26, 17, 'Fashion 4 PCS Women Bags', 1400.00, '1732555217.jpg', 16, 14, 'mark1kinai1@gmail.com', 1, '2025-04-15 18:59:19', '2025-04-15 18:59:31', 'cv5b14jlkea4ptdh4vf224dlj8', 'processed');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) DEFAULT 0,
  `popularity` tinyint(1) DEFAULT 0,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `status`, `popularity`, `meta_title`, `meta_description`, `meta_keywords`, `image`, `created_at`) VALUES
(1, 'Men Shoes', 'Men Shoes', 'A wide variety of stylish and comfortable shoes for men, including formal, casual, and sports shoes.', 1, 1, 'Men Shoes - Stylish and Comfortable Footwear for Men', '  Explore our exclusive collection of men\'s shoes. Find the perfect pair for every occasion, from formal to casual styles.', 'men shoes, formal shoes, casual shoes, sports shoes, stylish men\'s footwear', '1732550227.jpg', '2024-11-25 15:57:07'),
(2, ' Women Shoes', 'women-shoes', 'Discover a diverse range of women\'s shoes, from heels to flats and everything in between, perfect for all occasions.', 1, 1, 'Women Shoes - Trendy and Comfortable Footwear for Women', 'Browse our stunning collection of women\'s shoes. From elegant heels to casual flats, find the right pair for your style.', 'women shoes, heels, flats, sandals, stylish women\'s footwear', '1732550296.jpg', '2024-11-25 15:58:16'),
(3, 'Men Clothing', 'Men Clothing', 'A collection of stylish and trendy clothing for men, women, and children, for both casual and formal occasions.', 1, 1, 'Clothing - Fashionable Apparel for All Ages', ' Shop a wide selection of clothing for men, women, and kids. Find casual wear, formal wear, and everything in between.', 'clothing, casual wear, formal wear, fashion, apparel', '1732615725.jpg', '2024-11-25 15:59:29'),
(4, 'Accessories', 'accessories', 'Complete your look with stylish accessories such as bags, hats, scarves, and jewelry to match your outfit.', 1, 1, 'Accessories - Stylish Bags, Hats, and More', 'Find the perfect accessories to complement your style. Shop our range of bags, belts, scarves, and other trendy items.', 'accessories, bags, scarves, hats, jewelry, stylish accessories', '1732550432.jpg', '2024-11-25 16:00:32'),
(5, 'Jewelry', 'Jewelry', 'A beautiful selection of necklaces, rings, earrings, and bracelets that add sparkle and elegance to any outfit.', 1, 1, 'Jewelry - Elegant Necklaces, Rings, and More', 'Browse our exquisite collection of jewelry for every occasion. From timeless rings to elegant necklaces, find the perfect piece.', 'jewelry, necklaces, rings, earrings, bracelets, elegant jewelry', '1732550519.jpg', '2024-11-25 16:01:59'),
(6, 'Kids Wear', 'kids-wear', 'Fashionable and comfortable clothing for kids, from baby clothes to school uniforms, designed for everyday use.', 1, 1, 'Kids Wear - Comfortable and Stylish Clothing for Children', 'Shop our collection of kids\' clothing for all ages. From baby clothes to school uniforms, keep your child stylish and comfortable.', 'kids wear, children\'s clothing, baby clothes, school uniforms, kids fashion', '1732550671.jpg', '2024-11-25 16:04:31'),
(7, 'Women Clothing', 'women-clothing', 'A wide selection of trendy and stylish clothing for women, including casual wear, formal attire, and seasonal collections.', 1, 1, 'Women Clothing - Trendy Apparel for Every Occasion', '  Shop the latest styles in women\'s clothing, from casual outfits to elegant formal wear and seasonal must-haves.', 'women clothing, casual wear, formal wear, trendy outfits, women fashion', '1732638370.jpg', '2024-11-25 16:07:11');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `session_id` varchar(255) NOT NULL,
  `shipment_number` varchar(50) DEFAULT NULL,
  `cart_subtotal` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postcode` varchar(20) NOT NULL,
  `user_lat` decimal(10,6) DEFAULT NULL,
  `user_lng` decimal(10,6) DEFAULT NULL,
  `destination_lat` decimal(10,6) DEFAULT NULL,
  `destination_lng` decimal(10,6) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`id`, `user_id`, `session_id`, `shipment_number`, `cart_subtotal`, `shipping_cost`, `total_amount`, `destination`, `state`, `postcode`, `user_lat`, `user_lng`, `destination_lat`, `destination_lng`, `created_at`) VALUES
(11, 14, 'cv5b14jlkea4ptdh4vf224dlj8', 'mark-ship-XSHZ', 4445.00, 50.71, 4495.71, 'Uasin Gishu County', '0', '30100', 0.489744, 35.303038, 0.477194, 35.305060, '2025-04-15 21:52:48'),
(12, 14, 'cv5b14jlkea4ptdh4vf224dlj8', 'mark-ship-JP8U', 1500.00, 50.71, 1550.71, 'Uasin Gishu County', '0', '30100', 0.489744, 35.303038, 0.477194, 35.305060, '2025-04-15 21:56:42'),
(13, 14, 'cv5b14jlkea4ptdh4vf224dlj8', 'mark-ship-MF5V', 1700.00, 50.71, 1750.71, 'Uasin Gishu County', '0', '30100', 0.489721, 35.303014, 0.477194, 35.305060, '2025-04-15 21:57:50'),
(14, 14, 'cv5b14jlkea4ptdh4vf224dlj8', 'mark-ship-SW4K', 1400.00, 50.71, 1450.71, 'Uasin Gishu County', '0', '30100', 0.489721, 35.303014, 0.477194, 35.305060, '2025-04-15 21:59:31');

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cart_order` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`id`, `product_id`, `product_name`, `selling_price`, `image`, `quantity`, `user_id`, `email`, `cart_order`, `created_at`, `updated_at`, `session_id`) VALUES
(1, 12, 'Berrykey Men\\\'s Hawaiian', 880.00, '1732552958.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 08:40:41', '2025-03-20 08:40:59', 'rlco7660j3jgq771ci9uj8lbsh'),
(2, 11, 'Berrykey Men\\\'s Hawaiian', 900.00, '1732552849.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 08:42:25', '2025-03-20 08:42:25', 'rlco7660j3jgq771ci9uj8lbsh'),
(3, 6, 'Fashion Black Laced', 1500.00, '1732607538.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 08:42:31', '2025-03-20 08:42:31', 'rlco7660j3jgq771ci9uj8lbsh'),
(4, 4, 'Basketball Sneakers', 5398.00, '1732551333.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 08:45:17', '2025-03-20 08:45:17', 'rlco7660j3jgq771ci9uj8lbsh'),
(5, 21, 'Male Calendar Watch', 730.00, '1732600622.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 08:54:55', '2025-03-20 08:54:55', 'rlco7660j3jgq771ci9uj8lbsh'),
(6, 2, 'Basketball Shoes', 1499.00, '1732551155.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 08:55:02', '2025-03-20 08:55:02', 'rlco7660j3jgq771ci9uj8lbsh'),
(7, 14, 'Berrykey Mens Vintage', 750.00, '1732553142.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 09:00:07', '2025-03-20 09:00:07', 'rlco7660j3jgq771ci9uj8lbsh'),
(8, 29, 'MEN DENIM ', 1400.00, '1732602417.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 09:00:32', '2025-03-20 09:00:32', 'rlco7660j3jgq771ci9uj8lbsh'),
(9, 7, 'Fashion Official Laced', 1900.00, '1732552111.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 09:00:33', '2025-03-20 09:00:33', 'rlco7660j3jgq771ci9uj8lbsh'),
(10, 17, 'Fashion 4 PCS Women Bags', 1400.00, '1732555217.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 09:05:19', '2025-03-20 09:05:19', 'rlco7660j3jgq771ci9uj8lbsh'),
(11, 16, 'Fashion 3 PCS Women Bags', 1100.00, '1732555098.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 09:05:20', '2025-03-20 09:05:20', 'rlco7660j3jgq771ci9uj8lbsh'),
(12, 25, 'Women Shoulder Bags', 800.00, '1732601599.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 09:05:40', '2025-03-20 09:05:40', 'rlco7660j3jgq771ci9uj8lbsh'),
(13, 23, 'ASHION Fashion Casual Baseball', 2380.00, '1732601306.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 09:06:49', '2025-03-20 09:06:49', 'rlco7660j3jgq771ci9uj8lbsh'),
(14, 18, 'Fashion Beautiful ', 700.00, '1732555348.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 09:07:02', '2025-03-20 09:07:02', 'rlco7660j3jgq771ci9uj8lbsh'),
(15, 13, 'Fashion Men\\\'s Casual', 1200.00, '1732553073.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-03-20 09:08:20', '2025-03-20 09:08:20', 'rlco7660j3jgq771ci9uj8lbsh'),
(16, 4, 'Basketball Sneakers', 4445.00, '1732551333.jpg', 1, NULL, NULL, 1, '2025-03-25 06:47:48', '2025-03-25 06:47:48', 'jrn8cpfvmv5pealtf7k59cka01'),
(17, 3, 'Basketball Shoes ', 2606.00, '1732551233.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-04-12 13:04:49', '2025-04-12 13:04:49', 'hr1f6q0712go0f6uff5b8km0e1'),
(18, 12, 'Berrykey Men\\\'s Hawaiian', 880.00, '1732552958.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-04-14 20:13:12', '2025-04-14 20:23:56', 'lah7b54i8uk34bsh3ml801n2tv'),
(19, 4, 'Basketball Sneakers', 4445.00, '1732551333.jpg', 1, 6, 'markkinai3@gmail.com', 1, '2025-04-14 20:13:22', '2025-04-14 20:23:56', 'lah7b54i8uk34bsh3ml801n2tv'),
(20, 27, 'Manchester United Jersey ', 1700.00, '1732627742.avif', 1, NULL, NULL, 1, '2025-04-14 20:53:35', '2025-04-14 20:53:35', 'lah7b54i8uk34bsh3ml801n2tv'),
(21, 11, 'Berrykey Men\\\'s Hawaiian', 900.00, '1732552849.jpg', 1, NULL, NULL, 1, '2025-04-14 20:53:40', '2025-04-14 20:53:40', 'lah7b54i8uk34bsh3ml801n2tv');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `rating` int(11) DEFAULT 0,
  `status` tinyint(1) DEFAULT 0,
  `discount` float DEFAULT 0,
  `deal_start` datetime DEFAULT NULL,
  `deal_end` datetime DEFAULT NULL,
  `deal_of_day_status` enum('open','closed') DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `trending` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `size` varchar(255) DEFAULT NULL,
  `featured` enum('new','best_selling','trending','popular','featured') DEFAULT NULL,
  `brand_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_name`, `rating`, `status`, `discount`, `deal_start`, `deal_end`, `deal_of_day_status`, `product_name`, `description`, `original_price`, `selling_price`, `image`, `quantity`, `trending`, `created_at`, `updated_at`, `size`, `featured`, `brand_name`) VALUES
(1, 'Men Shoes', 4, 1, 3, NULL, NULL, NULL, 'MISSLAI Men\\\'s', 'MISSLAI Men\\\'s Basketball Shoes Breathable High Top Stretch Sneakers.', 2338.00, 2268.00, '1742628937.jpg', 35, 1, '2024-11-25 16:10:13', '2025-03-22 07:35:37', '', 'new', NULL),
(2, 'Men Shoes', 3, 1, 43, NULL, NULL, NULL, 'Basketball Shoes', 'Fashion Men\\\'s Basketball Shoes Breathable High Top Stretch Sneakers.', 1999.00, 1139.00, '1732551155.jpg', 25, 1, '2024-11-25 16:12:35', '2025-03-20 11:32:10', '', 'best_selling', NULL),
(3, 'Men Shoes', 2, 1, 1, NULL, NULL, NULL, 'Basketball Shoes ', 'Fashion Men\\\'s Basketball Shoes PU Sports Shoes Running Shoes.', 2743.00, 2606.00, '1732551233.jpg', 110, 1, '2024-11-25 16:13:53', '2025-03-20 11:33:24', '', 'new', NULL),
(4, 'Men Shoes', 5, 1, 2, NULL, NULL, NULL, 'Basketball Sneakers', 'Fashion Men\\\'s Breathable Basketball Sneakers Trend Boy\\\'s Basketball Shoes Hight Cut Outdoor BasketBall Shoes For Men Shoes', 4679.00, 4445.00, '1732551333.jpg', 150, 1, '2024-11-25 16:15:33', '2025-03-20 11:33:03', '', 'featured', NULL),
(5, 'Men Shoes', 4, 1, 5, NULL, NULL, NULL, 'Basketball Shoes, Non-Slip', 'Fashion Basketball Shoes, Non-Slip, Wear-Resistant, Breathable Sports Shoes Purple', 4700.00, 4060.00, '1732551678.jpg', 50, 1, '2024-11-25 16:21:18', '2024-11-25 16:21:18', 'medium', 'popular', NULL),
(6, 'Men Shoes', 5, 1, 28, NULL, NULL, NULL, 'Fashion Black Laced', 'Fashion Black Laced Official Leather Shoes For Men', 2500.00, 1500.00, '1732607538.jpg', 25, 1, '2024-11-25 16:26:10', '2024-11-26 07:52:18', 'large', 'featured', NULL),
(7, 'Men Shoes', 3, 1, 51, NULL, NULL, NULL, 'Fashion Official Laced', 'Fashion Official Laced Leather Shoes - Brown\\r\\n', 3780.00, 1900.00, '1732552111.jpg', 10, 1, '2024-11-25 16:28:31', '2024-11-25 16:28:31', 'medium', 'new', NULL),
(8, 'Men Shoes', 3, 1, 6, NULL, NULL, NULL, 'Fashion Official Laced', 'Fashion Official Laced Suede Leather Shoes - Navy Blue', 3500.00, 3000.00, '1732552181.jpg', 25, 1, '2024-11-25 16:29:41', '2024-11-25 16:29:41', 'medium', 'featured', NULL),
(9, 'Men Shoes', 4, 1, 26, NULL, NULL, NULL, 'Fashion Men\\\'s Comfortable', 'Fashion Men\\\'s Comfortable Gentle Casual Sport Running Sneakers Shoes Solid White', 1500.00, 1200.00, '1732552542.jpg', 25, 1, '2024-11-25 16:35:42', '2024-11-25 16:35:42', 'Select Size', 'trending', NULL),
(10, 'Men Clothing', 3, 1, 59, NULL, NULL, NULL, 'Berrykey Men\\\'s', 'Berrykey Men\\\'s Casual Vintage Turtleneck Polo Long Sleeve Office Shirts', 1200.00, 1000.00, '1732552650.jpg', 23, 1, '2024-11-25 16:37:30', '2024-11-27 10:16:27', '', '', NULL),
(11, 'Men Clothing', 5, 1, 7, NULL, NULL, NULL, 'Berrykey Men\\\'s Hawaiian', 'Berrykey Men\\\'s Hawaiian Ink Print Bottom-down Beach Short Sleeve T-Shirt Casual Tops', 950.00, 900.00, '1732552849.jpg', 52, 1, '2024-11-25 16:40:49', '2024-11-25 16:41:08', 'medium', 'featured', NULL),
(12, 'Men Clothing', 3, 1, 27, NULL, NULL, NULL, 'Berrykey Men\\\'s Hawaiian', 'Berrykey Men\\\'s Hawaiian Ink Print Bottom-down Beach Short Sleeve T-Shirt Casual Tops', 1000.00, 880.00, '1732552958.jpg', 15, 1, '2024-11-25 16:42:38', '2024-11-25 16:42:38', 'Select Size', 'featured', NULL),
(13, 'Men Clothing', 3, 1, 21, NULL, NULL, NULL, 'Fashion Men\\\'s Casual', 'Fashion Men\\\'s Casual Vibrant Hawaii Pattern Shirt Breathable Fast Dry Short Sleeve Big Size Blouse', 1230.00, 1200.00, '1732553073.jpg', 90, 1, '2024-11-25 16:44:33', '2024-11-25 16:44:33', 'medium', 'featured', NULL),
(14, 'Men Shoes', 4, 1, 25, NULL, NULL, NULL, 'Berrykey Mens Vintage', 'Berrykey Mens Vintage Graffiti Shirts Beach Casual Official T-Shirts - Multi', 800.00, 750.00, '1732553142.jpg', 20, 1, '2024-11-25 16:45:42', '2024-11-25 16:45:42', 'Select Size', 'best_selling', NULL),
(15, 'Men Clothing', 4, 1, 55, NULL, NULL, NULL, 'Fashion Mens', 'Fashion Mens Vintage Graffiti Short Patterned Sleeve Button-Down Hawaii Beach Shirt-Red', 1500.00, 1100.00, '1732553513.jpg', 11, 1, '2024-11-25 16:51:53', '2024-11-29 17:27:14', '', '', NULL),
(16, 'Accessories', 4, 1, 7, NULL, NULL, NULL, 'Fashion 3 PCS Women Bags', 'Fashion 3 PCS Women Bags Ladies Bags Handbags Purse Shoulder Bags Tote Bags Hobo Bags\\r\\n', 1150.00, 1100.00, '1732555098.jpg', 23, 1, '2024-11-25 17:18:18', '2024-11-25 17:18:18', 'medium', 'featured', NULL),
(17, 'Accessories', 3, 1, 6, NULL, NULL, NULL, 'Fashion 4 PCS Women Bags', 'Fashion 4 PCS Women Bags Ladies Bags Handbags Purse Shoulder Bags Tote Bags Hobo Bags', 1700.00, 1400.00, '1732555217.jpg', 25, 1, '2024-11-25 17:20:17', '2024-11-25 17:20:17', 'large', 'featured', NULL),
(18, 'Women Clothing', 4, 1, 8, NULL, NULL, NULL, 'Fashion Beautiful ', 'Fashion Beautiful Shinny Black Floral Shades Maxi Dera Dress(Size14/16/18', 699.00, 700.00, '1732555348.jpg', 120, 1, '2024-11-25 17:22:28', '2024-11-25 17:22:28', 'Select Size', 'popular', NULL),
(19, 'Women Clothing', 3, 1, 6, NULL, NULL, NULL, 'Wine Red', 'New Arrived Flared Sleeves Ruffles V Neck Dress Women Spring Autumn Long Sleeve A-Line Solid Sashes Mini Dresses DON', 2300.00, 2200.00, '1732555488.jpg', 25, 1, '2024-11-25 17:24:48', '2024-11-29 17:26:50', '', '', NULL),
(20, 'Select Category', 3, 1, 6, NULL, NULL, NULL, 'Machislet Fashion', 'Machislet Fashion Party Wear Rave Clothing Festival Outfits Multi Color Print Cover Up Dresses ODM', 650.00, 600.00, '1732555581.jpg', 230, 1, '2024-11-25 17:26:21', '2024-11-25 17:26:21', 'large', 'popular', NULL),
(21, 'Accessories', 4, 1, 5, NULL, NULL, NULL, 'Male Calendar Watch', 'Fashion Large Dial Retro Trendy Male Calendar Watch Sports Quartz Leather Belt Watch', 800.00, 730.00, '1732600622.jpg', 20, 1, '2024-11-26 05:57:02', '2024-11-26 05:57:02', 'medium', 'popular', NULL),
(22, 'Select Category', 2, 1, 0, NULL, NULL, NULL, 'Fashion Mens', 'Fashion Mens Long Sleeve Denim Jacket Casual Jeans Shirts-Blue', 2000.00, 1800.00, '1732600709.jpg', 21, 1, '2024-11-26 05:58:29', '2024-11-29 15:05:33', '', '', NULL),
(23, 'Men Shoes', 4, 1, 50, NULL, NULL, NULL, 'ASHION Fashion Casual Baseball', 'ASHION Fashion Casual Baseball Sweatshirt Casual Jacket - Green/White', 1190.00, 2380.00, '1732601306.jpg', 50, 1, '2024-11-26 06:03:16', '2024-11-26 06:08:26', 'small', 'popular', NULL),
(24, 'Kids Wear', 3, 1, 13, NULL, NULL, NULL, 'Fashion Trousers Men\\\'s', 'Fashion Trousers Men\\\'s 2-in-1 Short Sleeved T-shirt And Pants Set - Black', 900.00, 800.00, '1732601477.jpg', 25, 1, '2024-11-26 06:11:17', '2024-11-26 06:11:17', 'Select Size', 'popular', NULL),
(25, 'Accessories', 4, 1, 35, NULL, NULL, NULL, 'Women Shoulder Bags', 'Fashion Women Shoulder Bags PU Leather Backpack Bag Travel Bag-Black', 1200.00, 800.00, '1732601599.jpg', 25, 1, '2024-11-26 06:13:19', '2024-11-26 06:19:30', 'medium', 'new', NULL),
(26, 'Accessories', 4, 1, 43, NULL, NULL, NULL, 'Laptop Backpack', 'EkoShay Men Oxford Laptop Backpack Back School Bags-Black', 1200.00, 800.00, '1732601668.jpg', 20, 1, '2024-11-26 06:14:28', '2024-11-26 06:14:28', 'medium', 'new', NULL),
(27, 'Accessories', 5, 1, 14, NULL, NULL, NULL, 'Manchester United Jersey ', 'Manchester United adidas Home Jersey 2024-25\\r\\n', 1800.00, 1700.00, '1732627742.avif', 150, 1, '2024-11-26 06:22:26', '2024-11-30 15:40:59', '', 'featured', NULL),
(28, 'Select Category', 3, 1, 6, NULL, NULL, NULL, 'Chelsea 24/25 Home Kit New Season', 'Chelsea 24/25 Home Kit New Season Authentic Jersey as in picture\\r\\n', 1500.00, 1400.00, '1732627302.avif', 230, 1, '2024-11-26 06:24:28', '2024-11-29 14:07:49', '', '', NULL),
(29, 'Men Clothing', 4, 1, 6, NULL, NULL, NULL, 'MEN DENIM', 'Fashion MEN DENIM SLIM FIT NON FADE JEANS-BLUE', 1500.00, 1400.00, '1743057068.jpg', 15, 1, '2024-11-26 06:26:57', '2025-03-27 06:31:08', 'medium', 'new', NULL),
(30, 'Men Clothing', 4, 1, 9, NULL, NULL, NULL, 'Berrykey Mens', 'Berrykey Men\\\'s Spring Casual Slim Fit Floral Long Sleeve T Shirts Sweatshirts-Coffee', 780.00, 710.00, '1742740762.jpg', 37, 1, '2024-11-26 07:44:04', '2025-03-27 07:27:40', '', 'new', NULL),
(65, 'Men Clothing', 3, 1, 45, '2025-03-29 10:26:00', '2025-04-30 15:33:00', 'open', 'Loose Men\'s shirts', 'High quality Casual Loose Men\'s shirts camisas Hawaiian Printed Cotton Linen Short Sleeve shirt', 2557.00, 1406.00, '1743248979.jpg', 123, 1, '2025-03-29 07:26:36', '2025-04-12 15:08:54', '', 'new', 'Select Brand'),
(66, 'Men Shoes', 1, 1, 50, '2025-04-12 18:07:00', '2025-05-30 12:00:00', 'open', 'FDFDF', 'men shoes', 121.00, 212.00, '1743254809.jpg', 211, 1, '2025-03-29 07:29:26', '2025-04-14 19:24:45', '', 'best_selling', 'Mkurugenzi');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `additional_info` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_as` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=User, 1=Admin, 2=Supplier',
  `profile_picture` varchar(255) DEFAULT NULL,
  `agreed_to_terms` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `street_address`, `city`, `postal_code`, `additional_info`, `password`, `role_as`, `profile_picture`, `agreed_to_terms`, `created_at`, `updated_at`, `user_status`) VALUES
(3, 'Mark', 'Kinai', 'mark@gmail.com', '0111893789', '50100', 'Nairobi', 'N50100', 'fdsdf', '$2y$10$osm5XRy/z2x7IHlXaiKKpOEqig8POyYCP3lv8YTMMimVRs3iWgvf6', 2, '1732445429.png', 1, '2024-11-21 13:05:04', '2025-03-21 08:30:47', 'active'),
(6, 'Mark', 'Kinai', 'markkinai3@gmail.com', '0111893789', '00100', 'Nairobi', '00100', '', '$2y$10$7nM/F9PBqaHZJ9KYhDQLQOqgZP1HOgHy2ag7cqw3eqpsij/bVzifm', 1, 'DSIC.png', 0, '2024-11-24 11:03:24', '2025-04-12 12:54:49', ''),
(12, 'Mark', 'Kinai', 'mar@gmail.com', '0111893789', NULL, NULL, NULL, NULL, '$2y$10$AUjekjxMmMaWFz1Zv3.o2OAqhewF/BlQdkOwWadj0rZZ43VFE/aP2', 2, '1732451741.jpg', 0, '2024-11-24 12:35:41', '2025-03-21 08:29:37', 'active'),
(13, 'Mark', 'Kinai', 'mark1kinai@gmail.com', '0111893789', '50100', 'Nairobi', 'N50100', '', '$2y$10$Wjf8k5shXFdqt/E8UogqkuPxU.5sdxJr1rp2XwMlWlo6VlAWVdIu.', 2, 'GD.png', 1, '2025-03-21 08:40:55', '2025-03-21 08:41:26', 'active'),
(14, 'Mark', 'Kinai', 'mark1kinai1@gmail.com', '0111893789', '50100', 'Nairobi', 'N50100', '', '$2y$10$xRV7.3rM9HXk4tQSZRx64evtOYF.jVzkRMY9Jvb4eyf6jdmJMpCSK', 0, 'feature-5.png', 1, '2025-04-15 10:47:14', '2025-04-15 10:47:14', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
