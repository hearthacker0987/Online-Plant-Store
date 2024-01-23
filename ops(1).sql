-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2023 at 08:01 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ops`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_to_cart`
--

CREATE TABLE `add_to_cart` (
  `id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `prod_quantity` int(11) NOT NULL DEFAULT 1,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cate_id` int(11) NOT NULL,
  `cate_name` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cate_id`, `cate_name`, `date`) VALUES
(24, 'Outdoor Plants', '2023-08-07'),
(25, 'Indoor Plants', '2023-08-07'),
(26, 'Winter Plants', '2023-08-07'),
(27, 'Summer Plants', '2023-08-07');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `u_number` varchar(12) NOT NULL,
  `shipping_address` varchar(500) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `product_ids` varchar(255) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT 'status = 0 (pending)\r\nstatus = 1 (Packed)\r\nstatus = 2 (Shipped)\r\nstatus = 3 (delivered)\r\nstatus = 4 (Cancel)',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `u_number`, `shipping_address`, `city`, `country`, `zip_code`, `product_ids`, `total_products`, `total_price`, `status`, `order_date`) VALUES
(15, 21, '03036985755', 'Street 21,House # 23 Shad Bagh ', 'Lahore', 'Pakistan', 5223, '11(2),14(1)', 'Yucca(2),Rose(1)', 25000, 1, '2023-08-07 15:30:59');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `sub_cate_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_desc` varchar(500) NOT NULL,
  `prod_img` text NOT NULL,
  `price` float NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prod_id`, `sub_cate_id`, `prod_name`, `prod_desc`, `prod_img`, `price`, `stock`, `created_at`, `updated_at`) VALUES
(10, 12, 'Bamboo', 'Fast-growing grass-like plants that add height and a touch of exotic beauty to outdoor spaces.', 'Images/c2.jpg', 3000, 0, '2023-08-07', '2023-08-07'),
(11, 12, 'Yucca', 'Succulent plants with spiky leaves and tall flower spikes, known for their resilience and architectural appeal.', 'Images/c1.jpg', 12000, 50, '2023-08-07', '2023-08-07'),
(12, 14, 'Snake Plant', 'Hardy and low-maintenance succulent with long, sword-like leaves; thrives in a variety of light conditions and helps purify indoor air.', 'Images/snake_plant_varieties_1.jpg', 1200, 30, '2023-08-07', '2023-08-07'),
(13, 14, 'Peace Lily', 'Elegant plant with dark green foliage and white flowers; thrives in low to moderate light conditions and helps improve indoor air quality.', 'Images/Peace Lily.jpg', 6000, 40, '2023-08-07', '2023-08-07'),
(14, 13, 'Rose', 'Classic and elegant flowers available in various colours and fragrances.', 'Images/rose.jpg', 1000, 196, '2023-08-07', '2023-08-07'),
(15, 13, 'Tulip', 'Spring-blooming flowers with a wide range of colors and shapes.', 'Images/Tuli.webp', 400, 0, '2023-08-07', '2023-08-07'),
(16, 15, 'Orchid', 'Exquisite and elegant flowers available in a variety of colors; known for their beauty and sophistication.', 'Images/Orchid.jpg', 1000, 4, '2023-08-07', '2023-08-07'),
(17, 15, 'Cyclamen', 'Delicate and dainty flowers in shades of pink, red, or white that bloom during the winter months.', 'Images/Cyclamen.jpg', 5000, 8, '2023-08-07', '2023-08-07');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `setting_id` int(11) NOT NULL,
  `web_logo` text DEFAULT NULL,
  `web_name` varchar(255) DEFAULT NULL,
  `car_1_img` text DEFAULT NULL,
  `car_1_heading` varchar(255) DEFAULT NULL,
  `car_1_text` varchar(300) DEFAULT NULL,
  `car_2_img` text DEFAULT NULL,
  `car_2_heading` varchar(255) DEFAULT NULL,
  `car_2_text` varchar(300) DEFAULT NULL,
  `car_3_img` text DEFAULT NULL,
  `car_3_heading` varchar(255) DEFAULT NULL,
  `car_3_text` varchar(300) DEFAULT NULL,
  `sEmail` varchar(255) DEFAULT NULL,
  `app_pass` varchar(255) DEFAULT NULL,
  `fb_link` text DEFAULT 'https://www.facebook.com/',
  `insta_link` text DEFAULT 'https://www.instagram.com/',
  `you_link` text DEFAULT 'https://www.Youtube.com/',
  `whatsapp` text DEFAULT 'https://web.whatsapp.com/'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`setting_id`, `web_logo`, `web_name`, `car_1_img`, `car_1_heading`, `car_1_text`, `car_2_img`, `car_2_heading`, `car_2_text`, `car_3_img`, `car_3_heading`, `car_3_text`, `sEmail`, `app_pass`, `fb_link`, `insta_link`, `you_link`, `whatsapp`) VALUES
(11, NULL, 'Online Plants Store', '/Images/setting/c4.jpg', 'Welcome to Online Plant Store', 'At our store, we offer a wide variety of beautiful and healthy plants to bring nature\'s touch to your home, office, or any space you desire. Whether you\'re an experienced gardener or a beginner looking to add some greenery to your life, we\'ve got the perfect plants for you.', NULL, NULL, NULL, NULL, NULL, NULL, 'expandnetwork0@gmail.com', 'ipxcoaakifvlemai', 'https://www.facebook.com/', 'https://www.instagram.com/', 'https://www.Youtube.com/', 'https://web.whatsapp.com/');

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE `sub_category` (
  `sub_cate_id` int(11) NOT NULL,
  `sub_cate_name` varchar(255) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`sub_cate_id`, `sub_cate_name`, `cate_id`, `created_at`) VALUES
(12, 'Outdoor Plants', 24, '2023-08-07'),
(13, 'Outdoor Flowers', 24, '2023-08-07'),
(14, 'Indoor Plants', 25, '2023-08-07'),
(15, 'Indoor Flowers', 25, '2023-08-07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_number` varchar(255) NOT NULL,
  `user_add` text NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `role_as` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_number`, `user_add`, `user_password`, `role_as`, `created_at`) VALUES
(20, 'Admin', 'syedmoin569@gmail.com', '', '', '$2y$10$ma6bO19o3DYPTBmsD7bRIOEtNP.vaF1UEO1/Mb9daNoNsEeP1WDni', 'admin', '2023-08-07 11:02:31'),
(21, 'Syed Moin Ahmad', 'bc190411266@vu.edu.pk', '03036985755', '', '$2y$10$Wo7efkBE6gZvi.x3ANflP.gET4VFMgGm3W9HUmgW/XIdco.BFn5Ru', 'user', '2023-08-07 11:31:12'),
(22, 'Muneeb Ahmad', 'munirahmed4friends@gmail.com', '0305878897', '', '$2y$10$pbaIDRBW1HaSAYOc7N96.OZ15ZiDQAwlVIAtW8F7ChQ6BB7qW2VN2', 'user', '2023-08-07 12:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `user_feedback`
--

CREATE TABLE `user_feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `admin_reply` text DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `reply_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_to_cart`
--
ALTER TABLE `add_to_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prod_id_fk` (`prod_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cate_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id_fk` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `sub_cate_id_fk` (`sub_cate_id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD PRIMARY KEY (`sub_cate_id`),
  ADD KEY `cate_id_fk` (`cate_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_feedback`
--
ALTER TABLE `user_feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_to_cart`
--
ALTER TABLE `add_to_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sub_category`
--
ALTER TABLE `sub_category`
  MODIFY `sub_cate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user_feedback`
--
ALTER TABLE `user_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `add_to_cart`
--
ALTER TABLE `add_to_cart`
  ADD CONSTRAINT `prod_id_fk` FOREIGN KEY (`prod_id`) REFERENCES `products` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `sub_cate_id_fk` FOREIGN KEY (`sub_cate_id`) REFERENCES `sub_category` (`sub_cate_id`);

--
-- Constraints for table `sub_category`
--
ALTER TABLE `sub_category`
  ADD CONSTRAINT `cate_id_fk` FOREIGN KEY (`cate_id`) REFERENCES `category` (`cate_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
