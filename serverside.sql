-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2022 at 05:50 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `serverside`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Bracelets'),
(3, 'Rings'),
(9, 'Necklaces');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `image_url` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_name`, `stock`, `description`, `price`, `image_url`) VALUES
(1, 1, 'Chakra Bracelet', 20, 'Gold adjustable arrow bracelet. This is a test description to test the database setup. A more thorough description will be provided later. ', 25, 'chakra-bracelet.jpg'),
(2, 1, 'Black Buddha Bracelet', 9, 'Description for test black bracelet. Features matte black beads and buddha feature. One size fits all.', 20, 'black-buddha-bracelet.jpg'),
(8, 9, 'Tree of Life Talisman', 6, 'The tree of life on this talisman symbolizes our journey of continuous growth and the interconnectedness of life.\r\nSterling Silver', 100, ''),
(9, 1, 'Silver Chain Bracelet', 5, 'Details:\r\nLength: Adjustable chain length from 6 to 7 inches. \r\nWidth: 3mm.\r\n \r\nMaterials:\r\nSterling silver.', 74, ''),
(10, 3, 'Knot Gold Vermeil Ring', 10, '18K gold vermeil braided ring, bold and audacious.\r\n\r\nDetails:\r\nBand measures 6mm.\r\n\r\nMaterials:\r\n18k gold vermeil.', 85, ''),
(11, 3, 'Thin Silver Signet Ring', 10, 'Sterling silver signet ring with a slim, minimalist look. This thin flat-top ring features a 12 x 2.5mm rectangular platform.\r\n\r\nDetails:\r\nBand width: 2mm (at it&#039;s widest point)\r\nSignet measures 12 x 2.5mm \r\n\r\nMaterials:\r\nSterling silver.', 40, ''),
(12, 3, 'Ribbed Silver Ring', 20, 'Sterling silver ribbed ring featuring a crown shape. At its highest point, it is 6mm wide. \r\n\r\nDetails:\r\nBand width: 6mm. \r\n\r\nMaterials:\r\nSterling silver.', 55, ''),
(13, 1, 'Gold Plated Cuff Bracelet', 30, 'Gold plated cuff with meaningful sayings. \r\n\r\nDetails:\r\nWidth @ widest point: 3&quot;\r\n\r\nMaterials:\r\nGold plated over brass. ﻿', 70, ''),
(14, 1, 'Higher Power Talisman Bracelet', 10, 'This talisman reads &#039;May It Watch Over You,&#039; invoking guidance and protection from a higher power. The eye surrounded by rays of light is a symbol of divine providence.\r\n\r\nDetails:\r\nBracelet measures 6.5 inches. \r\nFastens to itself with a clasp. \r\n\r\nMaterials:\r\nSterling silver.', 160, ''),
(15, 9, 'Owl Imprint Necklace', 5, 'The Owl represents wisdom and intelligence. They have the ability to see what others do not see. \r\n\r\nDetails:\r\nPendant Diameter: .5&quot;.\r\nChain Length: 18&quot;.\r\n\r\nMaterials:\r\nRecycled and oxidized sterling silver. ', 80, ''),
(16, 9, 'Lion Talisman Necklace', 10, 'The lion on this talisman symbolizes bravery and determination. The heart&mdash;engraved with &#039;cor,&#039; meaning &#039;heart&#039; in Latin&mdash;held between its paws inspires the wearer to choose courage over fear.\r\n\r\nDetails:\r\nLength: 20mm.\r\nWidth: 17mm.\r\n\r\nMaterials:\r\nBronze.\r\nSterling silver.', 160, '');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_name`, `comment`, `product_id`, `created_on`) VALUES
(22, 'Evan', 'This is a test comment for the gold plated cuff bracelet. ', 13, '2022-04-11 18:32:26'),
(23, 'Second', 'Another comment for the gold plated bracelet. This is to test the reverse-chronological order.', 13, '2022-04-11 18:35:56'),
(24, 'Evan', 'The first comment for the higher power talisman bracelet. ', 14, '2022-04-11 19:14:58'),
(25, 'Test', 'This is the third comment to test.', 13, '2022-04-11 19:24:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_FK_1` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `reviews_FK_1` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_FK_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_FK_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
