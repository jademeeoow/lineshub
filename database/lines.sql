-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2025 at 10:27 AM
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
-- Database: `lines`
--

-- --------------------------------------------------------

--
-- Table structure for table `lines_admin`
--

CREATE TABLE `lines_admin` (
  `admin_id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_logout` datetime DEFAULT NULL,
  `login_date` date DEFAULT NULL,
  `reset_code` varchar(255) DEFAULT NULL,
  `reset_code_expiry` datetime DEFAULT NULL,
  `last_password_change` timestamp NULL DEFAULT NULL,
  `order_nav` tinyint(1) DEFAULT 0,
  `product_nav` tinyint(1) DEFAULT 0,
  `sales_nav` tinyint(1) DEFAULT 0,
  `account_nav` tinyint(1) DEFAULT 0,
  `supplies_nav` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_admin`
--

INSERT INTO `lines_admin` (`admin_id`, `image_path`, `username`, `email`, `first_name`, `last_name`, `phone_number`, `password`, `role`, `last_login`, `last_logout`, `login_date`, `reset_code`, `reset_code_expiry`, `last_password_change`, `order_nav`, `product_nav`, `sales_nav`, `account_nav`, `supplies_nav`) VALUES
(697191, '../../static/images/member/yuna my love.jpg', 'delenajd6969@gmail.com', 'delenajd6969@gmail.com', 'jade', 'delena', '09123456789', '$2y$10$315MpGRC9PCoJPq.eGBesOkH6haISx0uq1r3MeS1RKhtqigzJlVbS', 'super_admin', '2024-12-11 16:27:08', '2024-11-11 00:24:54', '2024-12-11', NULL, NULL, NULL, 1, 1, 1, 1, 1),
(697192, '../../static/images/member/jdpixel.jpeg', 'jdaguidandelena@gmail.com', 'delenajd6969@gmail.com', 'ronson', 'delena', '09143395211', '$2y$10$ESf2W6SftNjQ9.W1Q8bcgOzdSNIimXqUHqm2n0yEoHdKBsCmpywR.', 'clerk', '2025-01-21 09:31:32', '2025-01-19 23:18:14', '2025-01-21', NULL, NULL, NULL, 1, 1, 1, 1, 1),
(697194, '../../static/images/member/photo_2022-12-02_14-04-24.jpg', 'franzxvaldez@gmail.com', 'franzxvaldez@gmail.com', 'Franz Nathaniel', 'Valdez', '09562256089', '$2y$10$uSH8cti8ZaDVCzM892fEbebXhR.OEJkRD7EOSrXvAJidn3PaM2PDa', 'super_admin', '2024-11-11 15:52:01', '2024-11-11 15:46:49', '2024-11-11', '$2y$10$EC3UtQy5HyJQ4ikiKtPqTuiyJ1DslF7N1WcVddr6rW.NufSXCFlHe', '2024-11-10 20:45:43', '2024-11-11 01:36:47', 1, 1, 1, 1, 1),
(697195, '../../static/images/member/aboutuspic.png', 'milbert@gmail.com', 'milbert@gmail.com', 'Milbert', 'Falcasantos', '09677664027', '$2y$10$PR/IvY7n7cKw63t8Y2.WLODe6YAxkbor2O21WgnumFi1SKAxdUqve', 'super_admin', '2024-11-11 15:14:23', '2024-11-11 14:19:28', '2024-11-11', NULL, NULL, NULL, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lines_capital_costs`
--

CREATE TABLE `lines_capital_costs` (
  `capital_id` int(11) NOT NULL,
  `expenditure_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_capital_costs`
--

INSERT INTO `lines_capital_costs` (`capital_id`, `expenditure_id`, `description`, `amount`) VALUES
(132, 468592, 'a', 120.00),
(134, 468592, 'b', 1.00),
(135, 468592, 'c', 2.00);

-- --------------------------------------------------------

--
-- Table structure for table `lines_category`
--

CREATE TABLE `lines_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `has_sub_categories` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_category`
--

INSERT INTO `lines_category` (`category_id`, `category_name`, `has_sub_categories`) VALUES
(59, 'Shoes', 1),
(60, 'pen', 1),
(65, 'watch', 1),
(66, 'bag', 1),
(67, 'Phone Case', 1),
(68, 'Mug', 1),
(90, 'Customized CCS Jersey', 1),
(91, 'CCS MERCH', 1),
(93, 'BUTTERFLY', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lines_customers`
--

CREATE TABLE `lines_customers` (
  `customer_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `house_no` varchar(255) NOT NULL,
  `street_address` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `landmark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_customers`
--

INSERT INTO `lines_customers` (`customer_id`, `company_name`, `first_name`, `last_name`, `phone_number`, `house_no`, `street_address`, `barangay`, `landmark`) VALUES
(191, 'WMSU-CCS CSC', 'Franz Nathaniel', 'Valdez', '09677664027', '111', 'WMSU ', 'Campus B', 'CCS Building'),
(192, 'National Athletes', 'Peter', 'Pan', '09677664027', '00256', 'Ranches Drive', 'Baliwasan', 'Mcdo '),
(193, 'National Athletes', 'Peter', 'valdez', '09677664027', '111', 'WMSU', 'e', 'Mcdo'),
(194, 'WMSU-CCS CSC', 'Peter', 'Pan', '09677664027', '00256', 'Ranches Drive', 'Baliwasan', 'Belo Carwash'),
(195, 'JD and Co', 'JD', 'Delena', '091584233', '123', 'Resurreccion', 'Guiwan', ''),
(196, 'Franz and Co', 'Franz', 'Valdez', '091521521515', '949', 'navarro drive', 'baliwasan', ''),
(197, 'Milbert and Co', 'Milbert', 'Falcasantos', '091582423931', '143', '1424', 'san ramon', ''),
(198, 'Arp and Co', 'Arp', 'Villares', '09214214212', '143', '1432', 'putik', ''),
(199, '155', '1555', '1515', '515151', '215215', '215215', '21521521', '52152151'),
(200, 'Milberta and Co.', 'Berting', 'Berta', '09214214212', '143', 'San Jojo', 'san ramon', ''),
(201, 'JD and Co', 'JD', 'Delena', '0915842142141', '155', 'Resurreccion', 'mampang', ''),
(202, 'Franz and Co', 'franz', 'valdez', '0915415151', '155', 'navarro drive', 'baliwasan', '');

-- --------------------------------------------------------

--
-- Table structure for table `lines_electricity_costs`
--

CREATE TABLE `lines_electricity_costs` (
  `electricity_id` int(11) NOT NULL,
  `expenditure_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_electricity_costs`
--

INSERT INTO `lines_electricity_costs` (`electricity_id`, `expenditure_id`, `description`, `amount`) VALUES
(74, 468592, 'b', 120.00);

-- --------------------------------------------------------

--
-- Table structure for table `lines_expenditures`
--

CREATE TABLE `lines_expenditures` (
  `expenditure_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `capital_total` decimal(10,2) DEFAULT 0.00,
  `electricity_total` decimal(10,2) DEFAULT 0.00,
  `maintenance_total` decimal(10,2) DEFAULT 0.00,
  `logistics_total` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_expenditures`
--

INSERT INTO `lines_expenditures` (`expenditure_id`, `date`, `total_amount`, `capital_total`, `electricity_total`, `maintenance_total`, `logistics_total`) VALUES
(468592, '2025-01-01', 483.00, 123.00, 120.00, 120.00, 120.00);

-- --------------------------------------------------------

--
-- Table structure for table `lines_logistics_costs`
--

CREATE TABLE `lines_logistics_costs` (
  `logistics_id` int(11) NOT NULL,
  `expenditure_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_logistics_costs`
--

INSERT INTO `lines_logistics_costs` (`logistics_id`, `expenditure_id`, `description`, `amount`) VALUES
(60, 468592, 'd', 120.00);

-- --------------------------------------------------------

--
-- Table structure for table `lines_maintenance_costs`
--

CREATE TABLE `lines_maintenance_costs` (
  `maintenance_id` int(11) NOT NULL,
  `expenditure_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_maintenance_costs`
--

INSERT INTO `lines_maintenance_costs` (`maintenance_id`, `expenditure_id`, `description`, `amount`) VALUES
(57, 468592, 'c', 120.00);

-- --------------------------------------------------------

--
-- Table structure for table `lines_orders`
--

CREATE TABLE `lines_orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `additional_instructions` text DEFAULT NULL,
  `delivery_method` enum('Delivery','Pickup') NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `order_type` enum('Regular','Rush') NOT NULL DEFAULT 'Regular',
  `payment_mode` varchar(50) NOT NULL,
  `rush_fee` decimal(10,2) DEFAULT 0.00,
  `delivery_fee` decimal(10,2) DEFAULT NULL,
  `customization_fee` decimal(10,2) DEFAULT 0.00,
  `discount` varchar(255) DEFAULT NULL,
  `downpayment` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `processed_by` int(11) DEFAULT NULL,
  `status` enum('Pending','To Deliver','Delivered','Cancelled','Returned') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_orders`
--

INSERT INTO `lines_orders` (`order_id`, `customer_id`, `additional_instructions`, `delivery_method`, `delivery_date`, `order_type`, `payment_mode`, `rush_fee`, `delivery_fee`, `customization_fee`, `discount`, `downpayment`, `total_amount`, `created_at`, `processed_by`, `status`) VALUES
(788604, 202, '', 'Delivery', '2025-01-02', 'Regular', 'Cash', 0.00, 0.00, 0.00, '0.00', 0.00, 540.00, '2024-12-31 16:11:01', 697192, 'Delivered'),
(809461, 201, '', 'Delivery', '2025-01-25', 'Regular', 'Cash', 0.00, 100.00, 100.00, '160514.00', 0.00, 200.00, '2025-01-20 15:54:27', 697192, 'Delivered');

-- --------------------------------------------------------

--
-- Table structure for table `lines_order_items`
--

CREATE TABLE `lines_order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `variant_color` varchar(50) DEFAULT NULL,
  `variant_size` varchar(50) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_order_items`
--

INSERT INTO `lines_order_items` (`order_item_id`, `order_id`, `product_name`, `variant_id`, `variant_color`, `variant_size`, `quantity`, `unit_price`, `total_price`, `created_at`) VALUES
(453, 809461, '143', 90, '143', '143', 1, 143.00, 143.00, '2025-01-20 15:54:27'),
(454, 809461, 'B-Ball Jerseyw', 144, 'Green', 'S', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(455, 809461, 'B-Ball Jerseyw', 145, 'Green', 'M', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(456, 809461, 'bag ni JD', 66, 'Purple', 'N/A', 1, 10000.00, 10000.00, '2025-01-20 15:54:27'),
(457, 809461, 'bag ni JD', 67, 'Beige', 'N/A', 1, 8000.00, 8000.00, '2025-01-20 15:54:27'),
(458, 809461, 'bag ni JD', 104, 'Violet', 'N/A', 1, 1500.00, 1500.00, '2025-01-20 15:54:27'),
(459, 809461, 'bag ni JD', 122, 'Yellow', 'XL', 1, 1500.00, 1500.00, '2025-01-20 15:54:27'),
(460, 809461, 'bag ni JD', 127, 'N/A', 'N/A', 1, 1500.00, 1500.00, '2025-01-20 15:54:27'),
(461, 809461, 'BKB', 65, 'White', 'XL', 1, 120.00, 120.00, '2025-01-20 15:54:27'),
(462, 809461, 'BKB', 68, 'whitesmoke', 'black', 1, 123131.00, 123131.00, '2025-01-20 15:54:27'),
(463, 809461, 'BKB', 69, 'Cyan', 'Xl', 1, 150.00, 150.00, '2025-01-20 15:54:27'),
(464, 809461, 'BKB', 71, 'Pink', 'Xl', 1, 150.00, 150.00, '2025-01-20 15:54:27'),
(465, 809461, 'BKB', 73, 'Gray', 'XL', 1, 1500.00, 1500.00, '2025-01-20 15:54:27'),
(466, 809461, 'IT DEPT SHIRT', 146, 'Green', 'XS', 1, 280.00, 280.00, '2025-01-20 15:54:27'),
(467, 809461, 'IT DEPT SHIRT', 147, 'Green', 'S', 1, 280.00, 280.00, '2025-01-20 15:54:27'),
(468, 809461, 'IT DEPT SHIRT', 148, 'Green', 'L', 1, 280.00, 280.00, '2025-01-20 15:54:27'),
(469, 809461, 'Phone Case ni JD', 131, 'Black', 'N/A', 1, 1500.00, 1500.00, '2025-01-20 15:54:27'),
(470, 809461, 'Phone Case ni JD', 132, 'Sky Blue', 'N/A', 1, 1500.00, 1500.00, '2025-01-20 15:54:27'),
(471, 809461, 'Product 4', 98, 'Black', 'N/A', 1, 120.00, 120.00, '2025-01-20 15:54:27'),
(472, 809461, 'Product 5', 99, 'N/A', 'N/A', 1, 150.00, 150.00, '2025-01-20 15:54:27'),
(473, 809461, 'Product2', 96, 'White', '25', 1, 1200.00, 1200.00, '2025-01-20 15:54:27'),
(474, 809461, 'T-Shirt Jersey', 133, 'Green', 'XS', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(475, 809461, 'T-Shirt Jersey', 134, 'Green', 'S', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(476, 809461, 'T-Shirt Jersey', 135, 'Green', 'M', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(477, 809461, 'T-Shirt Jersey', 136, 'Green', 'L', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(478, 809461, 'T-Shirt Jersey', 137, 'Green', 'XL', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(479, 809461, 'T-Shirt Jersey', 138, 'Green', 'XXL', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(480, 809461, 'The New Product of JD', 128, 'Magenta', 'N/A', 1, 1500.00, 1500.00, '2025-01-20 15:54:27'),
(481, 809461, 'The New Product of JD', 129, 'Charteuse', 'N/A', 1, 1000.00, 1000.00, '2025-01-20 15:54:27'),
(482, 809461, 'The New Product of JD', 130, 'Omega Blue', 'N/A', 1, 1500.00, 1500.00, '2025-01-20 15:54:27'),
(483, 809461, 'Warmer', 139, 'Green', 'XS', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(484, 809461, 'Warmer', 140, 'Green', 'S', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(485, 809461, 'Warmer', 141, 'Green', 'M', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(486, 809461, 'Warmer', 142, 'Green', 'L', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(487, 809461, 'Warmer', 143, 'Green', 'XL', 1, 270.00, 270.00, '2025-01-20 15:54:27'),
(488, 788604, 'B-Ball Jerseyw', 144, 'Green', 'S', 1, 270.00, 270.00, '2025-01-20 16:11:01'),
(489, 788604, 'B-Ball Jerseyw', 145, 'Green', 'M', 1, 270.00, 270.00, '2025-01-20 16:11:01');

-- --------------------------------------------------------

--
-- Table structure for table `lines_products`
--

CREATE TABLE `lines_products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_products`
--

INSERT INTO `lines_products` (`product_id`, `product_name`, `product_description`, `category_id`, `sub_category_id`) VALUES
(67, 'BKB', 'Ultimate BKB', 59, NULL),
(71, 'bag ni JD', 'Gucci bag na gawa ni JD', 66, 77),
(72, 'Name', 'Desc', 59, NULL),
(73, '143', '143', 59, NULL),
(76, 'Shoe1', 'Shoe1 and the house', 59, NULL),
(77, 'Product1', '151515', 59, NULL),
(78, 'Product2', 'Product2', 59, NULL),
(80, 'Product 4', 'Product 4', 60, 158),
(81, 'Product 5', 'Product5', 60, 157),
(82, 'Product 6', 'Product 6', 68, 83),
(83, 'Product 7', 'Product 7', 65, 74),
(84, 'Product ni JD na for sale', 'product na bag ni jd na for sale', 66, 78),
(94, 'Product NAme', 'Product Desc', 66, 77),
(97, 'The New Product of JD', 'The Newest Edition of Product of JD', 66, NULL),
(98, 'Phone Case ni JD', 'The Ultimate Phone Case ni JD', 67, 81),
(99, 'T-Shirt Jersey', 'For Palaro', 90, 169),
(100, 'Warmer', 'For Palaro', 90, 167),
(101, 'B-Ball Jerseyw', 'For Palaro', 90, 170),
(102, 'IT DEPT SHIRT', 'WMSU IT CCS', 91, 173);

-- --------------------------------------------------------

--
-- Table structure for table `lines_product_variants`
--

CREATE TABLE `lines_product_variants` (
  `variant_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant_color` varchar(255) DEFAULT NULL,
  `variant_size` varchar(255) DEFAULT NULL,
  `variant_price` decimal(10,2) DEFAULT NULL,
  `variant_stock` int(11) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `initial_stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_product_variants`
--

INSERT INTO `lines_product_variants` (`variant_id`, `product_id`, `variant_color`, `variant_size`, `variant_price`, `variant_stock`, `supplier`, `initial_stock`) VALUES
(65, 67, 'White', 'XL', 120.00, 78, '15', 20),
(66, 71, 'Purple', '', 10000.00, 48, '16', 42),
(67, 71, 'Beige', '', 8000.00, 6, '15', 10),
(68, 67, 'whitesmoke', 'black', 123131.00, 6, '15', 21),
(69, 67, 'Cyan', 'Xl', 150.00, 10, '15', 10),
(71, 67, 'Pink', 'Xl', 150.00, 32, '15', 20),
(73, 67, 'Gray', 'XL', 1500.00, 11, '16', 10),
(90, 73, '143', '143', 143.00, 160, '16', 143),
(95, 77, 'Whiter', 'XCL', 1500.00, 8, '16', 10),
(96, 78, 'White', '25', 1200.00, 107, '15', 110),
(98, 80, 'Black', '', 120.00, 200, '17', 200),
(99, 81, '', '', 150.00, 16, '15', 20),
(100, 82, 'black', '150mm', 1500.00, 17, '16', 20),
(101, 83, 'graqy', '36', 15000.00, 50, '15', 10),
(102, 84, 'White', 'XL', 1500.00, 1497, '15', 1500),
(104, 71, 'Violet', '', 1500.00, 7, '15', NULL),
(122, 71, 'Yellow', 'XL', 1500.00, 147, '16', 150),
(127, 71, '', '', 1500.00, 11, '15', 20),
(128, 97, 'Magenta', '', 1500.00, 2, '16', 10),
(129, 97, 'Charteuse', '', 1000.00, 104, '17', 10),
(130, 97, 'Omega Blue', '', 1500.00, 53, '17', 10),
(131, 98, 'Black', '', 1500.00, 6, '16', 10),
(132, 98, 'Sky Blue', '', 1500.00, 6, '16', 10),
(133, 99, 'Green', 'XS', 270.00, 17, '17', 50),
(134, 99, 'Green', 'S', 270.00, 46, '17', 50),
(135, 99, 'Green', 'M', 270.00, 45, '17', 50),
(136, 99, 'Green', 'L', 270.00, 45, '17', 50),
(137, 99, 'Green', 'XL', 270.00, 50, '17', 50),
(138, 99, 'Green', 'XXL', 270.00, 50, '17', 50),
(139, 100, 'Green', 'XS', 270.00, 49, '17', 50),
(140, 100, 'Green', 'S', 270.00, 45, '17', 50),
(141, 100, 'Green', 'M', 270.00, 43, '17', 50),
(142, 100, 'Green', 'L', 270.00, 44, '17', 50),
(143, 100, 'Green', 'XL', 270.00, 44, '17', 50),
(144, 101, 'Green', 'S', 270.00, 46, '17', 49),
(145, 101, 'Green', 'M', 270.00, 30, '17', 50),
(146, 102, 'Green', 'XS', 280.00, 98, '17', 100),
(147, 102, 'Green', 'S', 280.00, 98, '17', 100),
(148, 102, 'Green', 'L', 280.00, 98, '17', 100);

-- --------------------------------------------------------

--
-- Table structure for table `lines_sub_category`
--

CREATE TABLE `lines_sub_category` (
  `sub_category_id` int(11) NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_sub_category`
--

INSERT INTO `lines_sub_category` (`sub_category_id`, `sub_category_name`, `category_id`) VALUES
(74, 'rolex', 65),
(75, 'olevs', 65),
(77, 'Gucci', 66),
(78, 'LV', 66),
(79, 'Samsung A51', 67),
(80, 'Realme GT', 67),
(81, 'Infinix Note 30 5g', 67),
(82, 'Tecno Camon 20 5 g', 67),
(83, 'Glass', 68),
(84, 'Wooden', 68),
(157, 'Pentel', 60),
(158, 'Sign', 60),
(167, 'Long Sleeve with Hood', 90),
(168, 'Longsleeve', 90),
(169, 'Shirt', 90),
(170, 'Sleeveless', 90),
(173, 'shirt', 91),
(174, 'lanyard', 91),
(175, 'jacket', 91),
(183, 'Nike', 59),
(184, 'Puma', 59),
(185, 'LV', 59),
(186, 'None', 93);

-- --------------------------------------------------------

--
-- Table structure for table `lines_suppliers`
--

CREATE TABLE `lines_suppliers` (
  `supplier_id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `business_type` enum('manufacturer','supplier','distributor','wholesaler','retailer') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_suppliers`
--

INSERT INTO `lines_suppliers` (`supplier_id`, `company_name`, `contact_person`, `email`, `phone_number`, `address`, `business_type`, `created_at`) VALUES
(15, 'Cr4matix', 'Franz Nathaniel Valdez', 'franzxc@gmail.com', '09123456789', 'Baliwasan', 'supplier', '2024-10-22 09:05:47'),
(16, 'Milberzkie Company', 'Milbert Elizalde Falcasantos', 'milberta@gmail.com', '09696969699', 'San Ramon', 'supplier', '2024-10-22 09:06:43'),
(17, 'alymeeoow Co.', 'Ronson Aguidan Delena', 'jdpogi@gmail.com', '098080808', 'Guiwan', 'supplier', '2024-10-22 09:07:34'),
(18, 'Glens Bazar', 'Manny Pacquiao', 'manny@gmail.com', '09677664027', 'Town, Zamboanga City', 'manufacturer', '2024-11-10 14:47:07');

-- --------------------------------------------------------

--
-- Table structure for table `lines_suppliers_products`
--

CREATE TABLE `lines_suppliers_products` (
  `product_id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_suppliers_products`
--

INSERT INTO `lines_suppliers_products` (`product_id`, `supplier_id`, `product_name`, `created_at`) VALUES
(86, 15, 'Bag', '2024-10-28 16:34:35'),
(87, 15, 'Shirts', '2024-10-28 16:34:35'),
(96, 17, 'Clothes', '2025-01-15 18:00:27'),
(97, 17, 'Punda', '2025-01-15 18:00:27'),
(119, 18, 'Boxing Gloves', '2025-01-19 14:41:35'),
(120, 18, 'Dumbells', '2025-01-19 14:41:35'),
(121, 18, 'Basketball', '2025-01-19 14:41:35'),
(122, 16, 'Tarps', '2025-01-19 16:33:53'),
(123, 16, 'Watches', '2025-01-19 16:33:53'),
(124, 16, 'Crocs', '2025-01-19 16:33:53');

-- --------------------------------------------------------

--
-- Table structure for table `lines_supplies_category`
--

CREATE TABLE `lines_supplies_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `has_subcategories` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_supplies_category`
--

INSERT INTO `lines_supplies_category` (`category_id`, `category_name`, `has_subcategories`) VALUES
(58, 'BKB', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lines_supplies_product`
--

CREATE TABLE `lines_supplies_product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_supplies_product`
--

INSERT INTO `lines_supplies_product` (`product_id`, `product_name`, `product_description`, `category_id`, `sub_category_id`) VALUES
(49, 'Supply1', 'The Supply 1', 58, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lines_supplies_product_variants`
--

CREATE TABLE `lines_supplies_product_variants` (
  `variant_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant_color` varchar(255) DEFAULT NULL,
  `variant_size` varchar(255) DEFAULT NULL,
  `variant_price` decimal(10,2) DEFAULT NULL,
  `variant_stock` varchar(255) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `initial_stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_supplies_product_variants`
--

INSERT INTO `lines_supplies_product_variants` (`variant_id`, `product_id`, `variant_color`, `variant_size`, `variant_price`, `variant_stock`, `supplier`, `initial_stock`) VALUES
(62, 49, 'White', 'XL', 200.00, '5 ML', '18', 5),
(63, 49, 'Black', 'L', 100.00, '10', '15', 10);

-- --------------------------------------------------------

--
-- Table structure for table `lines_supplies_sub_category`
--

CREATE TABLE `lines_supplies_sub_category` (
  `sub_category_id` int(11) NOT NULL,
  `sub_category_name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lines_supply_request`
--

CREATE TABLE `lines_supply_request` (
  `request_id` int(11) NOT NULL,
  `variant_id` int(11) NOT NULL,
  `requested_quantity` varchar(255) NOT NULL,
  `requested_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lines_supply_request`
--

INSERT INTO `lines_supply_request` (`request_id`, `variant_id`, `requested_quantity`, `requested_by`, `created_at`) VALUES
(19, 62, '5', 697192, '2025-01-19 11:46:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lines_admin`
--
ALTER TABLE `lines_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `lines_capital_costs`
--
ALTER TABLE `lines_capital_costs`
  ADD PRIMARY KEY (`capital_id`),
  ADD KEY `expenditure_id` (`expenditure_id`);

--
-- Indexes for table `lines_category`
--
ALTER TABLE `lines_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `lines_customers`
--
ALTER TABLE `lines_customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `lines_electricity_costs`
--
ALTER TABLE `lines_electricity_costs`
  ADD PRIMARY KEY (`electricity_id`),
  ADD KEY `expenditure_id` (`expenditure_id`);

--
-- Indexes for table `lines_expenditures`
--
ALTER TABLE `lines_expenditures`
  ADD PRIMARY KEY (`expenditure_id`);

--
-- Indexes for table `lines_logistics_costs`
--
ALTER TABLE `lines_logistics_costs`
  ADD PRIMARY KEY (`logistics_id`),
  ADD KEY `expenditure_id` (`expenditure_id`);

--
-- Indexes for table `lines_maintenance_costs`
--
ALTER TABLE `lines_maintenance_costs`
  ADD PRIMARY KEY (`maintenance_id`),
  ADD KEY `expenditure_id` (`expenditure_id`);

--
-- Indexes for table `lines_orders`
--
ALTER TABLE `lines_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `processed_by` (`processed_by`);

--
-- Indexes for table `lines_order_items`
--
ALTER TABLE `lines_order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `lines_products`
--
ALTER TABLE `lines_products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `lines_products_ibfk_1` (`category_id`),
  ADD KEY `lines_products_ibfk_2` (`sub_category_id`);

--
-- Indexes for table `lines_product_variants`
--
ALTER TABLE `lines_product_variants`
  ADD PRIMARY KEY (`variant_id`),
  ADD KEY `lines_product_variants_ibfk_1` (`product_id`);

--
-- Indexes for table `lines_sub_category`
--
ALTER TABLE `lines_sub_category`
  ADD PRIMARY KEY (`sub_category_id`),
  ADD KEY `lines_sub_category_ibfk_1` (`category_id`);

--
-- Indexes for table `lines_suppliers`
--
ALTER TABLE `lines_suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `lines_suppliers_products`
--
ALTER TABLE `lines_suppliers_products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `lines_supplies_category`
--
ALTER TABLE `lines_supplies_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `lines_supplies_product`
--
ALTER TABLE `lines_supplies_product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_product_to_category` (`category_id`),
  ADD KEY `fk_product_to_sub_category` (`sub_category_id`);

--
-- Indexes for table `lines_supplies_product_variants`
--
ALTER TABLE `lines_supplies_product_variants`
  ADD PRIMARY KEY (`variant_id`),
  ADD KEY `fk_variant_to_product` (`product_id`);

--
-- Indexes for table `lines_supplies_sub_category`
--
ALTER TABLE `lines_supplies_sub_category`
  ADD PRIMARY KEY (`sub_category_id`),
  ADD KEY `fk_sub_category_to_category` (`category_id`);

--
-- Indexes for table `lines_supply_request`
--
ALTER TABLE `lines_supply_request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `variant_id` (`variant_id`),
  ADD KEY `requested_by` (`requested_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lines_admin`
--
ALTER TABLE `lines_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=697196;

--
-- AUTO_INCREMENT for table `lines_capital_costs`
--
ALTER TABLE `lines_capital_costs`
  MODIFY `capital_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `lines_category`
--
ALTER TABLE `lines_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `lines_customers`
--
ALTER TABLE `lines_customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `lines_electricity_costs`
--
ALTER TABLE `lines_electricity_costs`
  MODIFY `electricity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `lines_expenditures`
--
ALTER TABLE `lines_expenditures`
  MODIFY `expenditure_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=998011;

--
-- AUTO_INCREMENT for table `lines_logistics_costs`
--
ALTER TABLE `lines_logistics_costs`
  MODIFY `logistics_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `lines_maintenance_costs`
--
ALTER TABLE `lines_maintenance_costs`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `lines_orders`
--
ALTER TABLE `lines_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;

--
-- AUTO_INCREMENT for table `lines_order_items`
--
ALTER TABLE `lines_order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=490;

--
-- AUTO_INCREMENT for table `lines_products`
--
ALTER TABLE `lines_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `lines_product_variants`
--
ALTER TABLE `lines_product_variants`
  MODIFY `variant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `lines_sub_category`
--
ALTER TABLE `lines_sub_category`
  MODIFY `sub_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `lines_suppliers`
--
ALTER TABLE `lines_suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `lines_suppliers_products`
--
ALTER TABLE `lines_suppliers_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `lines_supplies_category`
--
ALTER TABLE `lines_supplies_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `lines_supplies_product`
--
ALTER TABLE `lines_supplies_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `lines_supplies_product_variants`
--
ALTER TABLE `lines_supplies_product_variants`
  MODIFY `variant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `lines_supplies_sub_category`
--
ALTER TABLE `lines_supplies_sub_category`
  MODIFY `sub_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;

--
-- AUTO_INCREMENT for table `lines_supply_request`
--
ALTER TABLE `lines_supply_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lines_capital_costs`
--
ALTER TABLE `lines_capital_costs`
  ADD CONSTRAINT `lines_capital_costs_ibfk_1` FOREIGN KEY (`expenditure_id`) REFERENCES `lines_expenditures` (`expenditure_id`) ON DELETE CASCADE;

--
-- Constraints for table `lines_electricity_costs`
--
ALTER TABLE `lines_electricity_costs`
  ADD CONSTRAINT `lines_electricity_costs_ibfk_1` FOREIGN KEY (`expenditure_id`) REFERENCES `lines_expenditures` (`expenditure_id`) ON DELETE CASCADE;

--
-- Constraints for table `lines_logistics_costs`
--
ALTER TABLE `lines_logistics_costs`
  ADD CONSTRAINT `lines_logistics_costs_ibfk_1` FOREIGN KEY (`expenditure_id`) REFERENCES `lines_expenditures` (`expenditure_id`) ON DELETE CASCADE;

--
-- Constraints for table `lines_maintenance_costs`
--
ALTER TABLE `lines_maintenance_costs`
  ADD CONSTRAINT `lines_maintenance_costs_ibfk_1` FOREIGN KEY (`expenditure_id`) REFERENCES `lines_expenditures` (`expenditure_id`) ON DELETE CASCADE;

--
-- Constraints for table `lines_orders`
--
ALTER TABLE `lines_orders`
  ADD CONSTRAINT `lines_orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `lines_customers` (`customer_id`),
  ADD CONSTRAINT `lines_orders_ibfk_2` FOREIGN KEY (`processed_by`) REFERENCES `lines_admin` (`admin_id`);

--
-- Constraints for table `lines_order_items`
--
ALTER TABLE `lines_order_items`
  ADD CONSTRAINT `lines_order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `lines_orders` (`order_id`);

--
-- Constraints for table `lines_products`
--
ALTER TABLE `lines_products`
  ADD CONSTRAINT `lines_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `lines_category` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lines_products_ibfk_2` FOREIGN KEY (`sub_category_id`) REFERENCES `lines_sub_category` (`sub_category_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `lines_product_variants`
--
ALTER TABLE `lines_product_variants`
  ADD CONSTRAINT `lines_product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `lines_products` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `lines_sub_category`
--
ALTER TABLE `lines_sub_category`
  ADD CONSTRAINT `lines_sub_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `lines_category` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `lines_suppliers_products`
--
ALTER TABLE `lines_suppliers_products`
  ADD CONSTRAINT `lines_suppliers_products_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `lines_suppliers` (`supplier_id`) ON DELETE CASCADE;

--
-- Constraints for table `lines_supplies_product`
--
ALTER TABLE `lines_supplies_product`
  ADD CONSTRAINT `fk_product_to_category` FOREIGN KEY (`category_id`) REFERENCES `lines_supplies_category` (`category_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product_to_sub_category` FOREIGN KEY (`sub_category_id`) REFERENCES `lines_supplies_sub_category` (`sub_category_id`) ON DELETE CASCADE;

--
-- Constraints for table `lines_supplies_product_variants`
--
ALTER TABLE `lines_supplies_product_variants`
  ADD CONSTRAINT `fk_variant_to_product` FOREIGN KEY (`product_id`) REFERENCES `lines_supplies_product` (`product_id`) ON DELETE CASCADE;

--
-- Constraints for table `lines_supplies_sub_category`
--
ALTER TABLE `lines_supplies_sub_category`
  ADD CONSTRAINT `fk_sub_category_to_category` FOREIGN KEY (`category_id`) REFERENCES `lines_supplies_category` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `lines_supply_request`
--
ALTER TABLE `lines_supply_request`
  ADD CONSTRAINT `fk_supply_request_variant` FOREIGN KEY (`variant_id`) REFERENCES `lines_supplies_product_variants` (`variant_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lines_supply_request_ibfk_2` FOREIGN KEY (`requested_by`) REFERENCES `lines_admin` (`admin_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
