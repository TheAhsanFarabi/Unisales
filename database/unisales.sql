-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 10, 2024 at 07:28 AM
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
-- Database: `unisales`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `user1` int(11) NOT NULL,
  `user2` int(11) NOT NULL,
  `chat_message` text NOT NULL,
  `c_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `message_type` enum('text','photo') NOT NULL DEFAULT 'text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chat_id`, `user1`, `user2`, `chat_message`, `c_time`, `message_type`) VALUES
(85, 31, 28, 'Hi I need that', '2023-12-19 06:20:33', 'text'),
(86, 28, 31, 'data/chats/osx2RiVs4hQpTS32HAXDwduNfxYbOM3QKAgi2e6x.jpeg', '2023-12-19 09:52:57', 'photo');

-- --------------------------------------------------------

--
-- Table structure for table `gigs`
--

CREATE TABLE `gigs` (
  `g_id` int(11) NOT NULL,
  `g_title` varchar(200) NOT NULL,
  `g_details` text NOT NULL,
  `g_img` text NOT NULL,
  `g_amount` int(11) NOT NULL,
  `g_price` float NOT NULL,
  `g_category` varchar(100) NOT NULL,
  `g_location` varchar(100) NOT NULL,
  `g_creator` int(11) NOT NULL,
  `g_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `g_requests` int(11) NOT NULL,
  `g_flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gigs`
--

INSERT INTO `gigs` (`g_id`, `g_title`, `g_details`, `g_img`, `g_amount`, `g_price`, `g_category`, `g_location`, `g_creator`, `g_time`, `g_requests`, `g_flag`) VALUES
(16, 'We Need Cauliflower', 'Our culinary creations are incomplete without the addition of premium cauliflower, and we are in need of a 40kg supply. If your cauliflower boasts freshness, versatility, and is harvested with care, we are keen to discuss a partnership that aligns with our commitment to quality and variety.', 'GIG-657f9437a5e2b5.05266501.png', 2, 20, 'Vegetables', 'Dhaka', 32, '2023-12-18 00:37:11', 0, 0),
(17, 'Need Rupchada Fish', 'We are on the lookout for a substantial 70kg supply of fresh Rupchada fish. Our commitment to providing top-notch seafood to our clientele demands a source that ensures both quality and flavor. If you can supply us with this premium seafood option, we are eager to establish a partnership.', 'GIG-657f94525c1aa8.87669697.jpeg', 2, 50, 'Fish', 'Dhaka', 32, '2023-12-18 00:37:38', 1, 0),
(18, 'Need Fresh Carrots', 'Seeking a reliable and consistent source for 60kg of high-quality carrots. We value freshness, vibrant color, and crisp texture to enhance the nutritional content of our dishes. If your carrots meet these criteria, we are interested in exploring a collaboration that aligns with our dedication to delivering wholesome and delicious meals.', 'GIG-657f94732bb260.04399958.jpeg', 3, 40, 'Vegetables', 'Dhaka', 31, '2023-12-18 00:38:11', 2, 1),
(19, 'We Need Fresh Lemons', 'The zest and tang of lemons play a pivotal role in our recipes, and we are currently seeking a reliable supplier for 30kg of these citrus gems. If your lemons are known for their freshness, juiciness, and exceptional flavor, we are interested in establishing a partnership to ensure a consistent supply that enhances our culinary offerings.', 'GIG-657f94880cdea8.35753345.jpeg', 12, 80, 'Vegetables', 'Dhaka', 31, '2023-12-18 00:38:32', 0, 0),
(20, 'I need Matton', 'Plz provide organic', 'GIG-65812dc8b06e13.81355675.jpg', 12, 400, 'Meat', 'Sylhet', 31, '2023-12-19 05:44:40', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `seller` int(11) NOT NULL,
  `buyer` int(11) NOT NULL,
  `prop_id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `is_paid_half` int(1) NOT NULL,
  `is_paid_full` int(11) NOT NULL,
  `order_confirm` int(11) NOT NULL,
  `is_delivery_started` int(1) NOT NULL,
  `is_delivery_finished` int(11) NOT NULL,
  `transport` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `seller`, `buyer`, `prop_id`, `gig_id`, `is_paid_half`, `is_paid_full`, `order_confirm`, `is_delivery_started`, `is_delivery_finished`, `transport`, `time`) VALUES
(69, 28, 31, 0, 18, 1, 1, 1, 1, 1, 'Speed Transport', '2023-12-19 06:22:08'),
(70, 28, 31, 23, 0, 1, 1, 1, 1, 1, 'Speed Transport', '2023-12-19 06:23:30'),
(71, 28, 31, 0, 18, 1, 1, 1, 1, 1, 'Turbo Transport', '2023-12-19 09:53:36'),
(72, 28, 31, 23, 0, 0, 0, 0, 0, 0, '', '2023-12-19 10:14:33');

-- --------------------------------------------------------

--
-- Table structure for table `props`
--

CREATE TABLE `props` (
  `p_id` int(11) NOT NULL,
  `p_title` varchar(200) NOT NULL,
  `p_details` text NOT NULL,
  `p_img` text NOT NULL,
  `p_amount` int(11) NOT NULL,
  `p_price` int(11) NOT NULL,
  `p_category` varchar(100) NOT NULL,
  `p_location` varchar(100) NOT NULL,
  `p_creator` int(11) NOT NULL,
  `p_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `p_requests` int(11) NOT NULL,
  `p_flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `props`
--

INSERT INTO `props` (`p_id`, `p_title`, `p_details`, `p_img`, `p_amount`, `p_price`, `p_category`, `p_location`, `p_creator`, `p_time`, `p_requests`, `p_flag`) VALUES
(23, 'I can sell fresh Mango', '🌿 Embrace the taste of nature with our premium mango harvest! 🌞 We are delighted to offer you 100 kilograms of luscious mangoes at an unbeatable price of 20 BDT per kilogram. 🥭', 'PROP-657f8950cdcb59.33348800.jpg', 100, 20, 'Fruits', 'Dhaka', 28, '2023-12-17 23:50:41', 1, 1),
(24, ' 100 Pieces of Fresh Chicken Available Now!', '🍗 Dive into a world of taste with our succulent chicken! 🌟 We\'re excited to offer you 100 pieces of premium chicken, ready to bring flavor to your meals.', 'PROP-657f8c213d1761.01168508.jpg', 100, 100, 'Meat', 'Dhaka', 28, '2023-12-18 00:02:41', 0, 0),
(25, 'Premium Quality Beef Sale', ' Indulge in the richness of flavor with our exclusive offer on premium cow meat! 🌿 We\'re excited to bring you 100 kilograms of high-quality beef at a fantastic price of 200 BDT per kilogram.', 'PROP-657f910864fb71.41002974.jpg', 100, 200, 'Meat', 'Rajshahi', 29, '2023-12-18 00:23:36', 0, 0),
(26, 'Fresh Shrimp ', 'Dive into a world of flavor with our exclusive offer on succulent shrimp! 🌊 We\'re thrilled to present 60 kilograms of premium shrimp at an incredible price of just 100 BDT per kilogram.', 'PROP-657f918b64dfa0.22795157.jpg', 60, 100, 'Fish', 'Rajshahi', 29, '2023-12-18 00:25:47', 0, 0),
(27, 'Crisp and Fresh: 40KG of Cauliflower', '🌿 Elevate your meals with the freshness of our premium cauliflower! 🌼 We\'re excited to offer you 40 kilograms of crisp and delicious cauliflower at an unbeatable price of 20 BDT per kilogram.', 'PROP-657f92802ef378.71794246.jpg', 40, 20, 'Vegetables', 'Sylhet', 30, '2023-12-18 00:29:52', 0, 0),
(28, 'Best Spice ', 'Spice up your kitchen with our premium spice collection! We\'re thrilled to bring you 10 kilograms of top-quality spices at an irresistible price of 200 BDT per kilogram.', 'PROP-657f9339864670.67430087.jpg', 10, 200, 'Spice', 'Dhaka', 28, '2023-12-18 00:32:57', 0, 0),
(29, 'What is this', 'n', 'PROP-65812cb3b65c96.22559068.jpg', 10, 5, 'Spice', 'Rajshahi', 28, '2023-12-19 05:40:03', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `profileID` int(11) NOT NULL,
  `stars` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`rating_id`, `userID`, `profileID`, `stars`) VALUES
(12, 28, 32, 4);

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `request_id` int(11) NOT NULL,
  `gig_id` int(11) NOT NULL,
  `prop_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_message` text NOT NULL,
  `request_img` varchar(500) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`request_id`, `gig_id`, `prop_id`, `user_id`, `request_message`, `request_img`, `time`) VALUES
(42, 18, 0, 28, 'I have carrots. I can provide intime.', 'GIGR-657f9a5c125073.23908015.jpg', '2023-12-18 01:03:24'),
(43, 18, 0, 30, 'I have original carrots from my garden.', 'GIGR-657f9aafe357a7.05904079.jpg', '2023-12-18 01:04:48'),
(44, 0, 23, 31, 'I want that', '0', '2023-12-19 06:20:25'),
(45, 17, 0, 28, 'I will', '0', '2023-12-19 10:03:21');

-- --------------------------------------------------------

--
-- Table structure for table `transportations`
--

CREATE TABLE `transportations` (
  `truckName` varchar(100) NOT NULL,
  `cost` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `orders` varchar(100) NOT NULL,
  `orders_size` int(100) NOT NULL,
  `flag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transportations`
--

INSERT INTO `transportations` (`truckName`, `cost`, `capacity`, `orders`, `orders_size`, `flag`) VALUES
('Rapid Transport', 5, 500, '', 0, 0),
('Speed Transport', 10, 300, '', 0, 0),
('Turbo Transport', 20, 200, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `img` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `number` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `bio` varchar(200) NOT NULL,
  `theme_color` varchar(100) NOT NULL,
  `is_verified` int(11) NOT NULL,
  `balance` float NOT NULL,
  `rating` float NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`, `img`, `address`, `number`, `user_type`, `bio`, `theme_color`, `is_verified`, `balance`, `rating`, `joined_at`) VALUES
(28, 'ahsan', 'ahsan@gmail.com', '$2y$10$Yi/L7C8QFDVDmk3y/iKHoezSjWNoCMK0/EblR7LWXaGJI926iVGB.', 'Ahsan Farabi', 'IMG-657f905fe57180.80556565.jpg', 'Korotia, Tangail', 0, 1, '', '#f39c12', 1, 100, 0, '2023-12-17 23:35:51'),
(29, 'israt', 'israt@gmail.com', '$2y$10$9gYszCoMeKsyzVuHeG1aGOhBh4zvxfIjXHC3uNvTL/Vidll49lELG', 'Israt Khandaker', 'IMG-657f90775349d8.20021435.jpg', 'Rajshahi', 0, 1, '', '', 0, 0, 0, '2023-12-17 23:36:56'),
(30, 'mueid', 'mueid@gmail.com', '$2y$10$4tD8iBj73WcoHd8akQ8wFewC/6ZfqLPnvsT0fUoYjXCw0HvVjPXYC', 'Al Mueid Sarkar', 'IMG-657f92680d2d70.54690038.jpg', 'Shirajgong', 0, 1, '', '', 0, 0, 0, '2023-12-17 23:37:27'),
(31, 'agora', 'agora@gmail.com', '$2y$10$1.RGpwMa/TYIUFgPqbGE.ezucmuY5V8JDKllSSBU.F/CUE3RMdRwy', 'Agora', 'IMG-657f93eea96862.43633853.jpg', 'Uttara, Dhaka', 0, 2, '', '', 0, 0, 0, '2023-12-17 23:38:07'),
(32, 'meena', 'meena@gmail.com', '$2y$10$Eca7PbaR6oMG3mk9ffMSX.H/yHwi/ONFxwAQKq42wsqSOn.w2ujHW', 'Meena Bazar', 'IMG-657f9403c379f3.80026546.jpg', 'Badda, Dhaka', 0, 2, '', '', 0, 300, 4, '2023-12-17 23:39:10'),
(33, 'admin', 'admin@unisales.com', '1234', 'Admin', '', '', 0, 3, '', '', 0, 0, 0, '2023-12-17 23:39:50'),
(34, 'transport', '', '1234', '', '', '', 0, 4, '', '', 0, 0, 0, '2023-12-17 23:40:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `gigs`
--
ALTER TABLE `gigs`
  ADD PRIMARY KEY (`g_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `props`
--
ALTER TABLE `props`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `transportations`
--
ALTER TABLE `transportations`
  ADD PRIMARY KEY (`truckName`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `gigs`
--
ALTER TABLE `gigs`
  MODIFY `g_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `props`
--
ALTER TABLE `props`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
