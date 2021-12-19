-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2021 at 04:45 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beatus_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `back_order`
--

CREATE TABLE `back_order` (
  `id` int(30) NOT NULL,
  `po_id` int(30) NOT NULL,
  `receiving_id` int(30) NOT NULL,
  `bo_code` varchar(50) NOT NULL,
  `supplier_id` int(30) NOT NULL,
  `total_cost` float NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `inventory_ids` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `back_order`
--

INSERT INTO `back_order` (`id`, `po_id`, `receiving_id`, `bo_code`, `supplier_id`, `total_cost`, `remarks`, `status`, `inventory_ids`, `date_created`) VALUES
(10, 7, 15, 'BO-0001', 7, 5000, 'Back Order FROM PO-0001', 0, '86', '2021-11-10 13:26:43'),
(11, 9, 16, 'BO-0002', 9, 50, 'Back Order FROM PO-0003', 1, '86', '2021-11-13 19:08:29'),
(12, 21, 28, 'BO-0003', 9, 1980, 'Back Order FROM PO-0015', 1, '86', '2021-11-13 20:39:18'),
(13, 22, 29, 'BO-0004', 12, 1980, 'Back Order FROM PO-0016', 1, '86', '2021-11-13 20:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `bo_items`
--

CREATE TABLE `bo_items` (
  `bo_id` int(30) NOT NULL,
  `item_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL,
  `price` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bo_items`
--

INSERT INTO `bo_items` (`bo_id`, `item_id`, `qty`, `price`) VALUES
(10, 7, 50, 100),
(11, 14, 1, 50),
(12, 55, 20, 99),
(13, 56, 20, 99);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(30) NOT NULL,
  `supplier_id` int(30) DEFAULT NULL,
  `item_code` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `size` varchar(10) NOT NULL,
  `price` float NOT NULL,
  `alert_min` int(10) NOT NULL DEFAULT 20,
  `alert_max` int(10) NOT NULL DEFAULT 100,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `supplier_id`, `item_code`, `name`, `description`, `size`, `price`, `alert_min`, `alert_max`, `date_created`) VALUES
(10, 9, '397637995989', 'Circle Neck Buttondown Dark Blue', 'Knitted Ribbed', 'XS', 75, 1, 100, '2021-11-13 18:51:58'),
(11, 9, '889594947898', 'Circle Neck Buttondown Off White', 'Knitted Ribbed', 'XS', 75, 20, 100, '2021-11-13 18:53:13'),
(12, 9, '654323584687', 'Circle Neck Buttondown Gray', 'Knitted Ribbed', 'XS', 75, 20, 100, '2021-11-13 18:54:15'),
(13, 9, '751553147780', 'Circle Neck Buttondown Moss Green', 'Knitted Ribbed', 'XS', 75, 20, 100, '2021-11-13 18:54:43'),
(14, 9, '304511224050', 'Circle Neck Buttondown Night Pink', 'Knitted Ribbed', 'XS', 75, 20, 100, '2021-11-13 18:55:00'),
(15, 9, '476088779554', 'V-Neck Buttondown Off-white', 'Knitted Ribbed', 'S', 100, 20, 100, '2021-11-13 19:15:08'),
(16, 9, '308140605094', 'V-Neck Buttondown Unique Blue', 'Knitted Ribbed', 'S', 100, 20, 100, '2021-11-13 19:15:43'),
(17, 9, '706039128944', 'V-Neck Buttondown Army Green', 'Knitted Ribbed', 'XS', 100, 20, 100, '2021-11-13 19:16:14'),
(18, 9, '873366591930', 'V-Neck Buttondown Navy Blue', 'Knitted Ribbed', 'XS', 100, 20, 100, '2021-11-13 19:16:53'),
(19, 9, '821645265171', 'Strapless  Mustard', 'Knitted Ribbed', 'XS', 90, 20, 100, '2021-11-13 19:21:16'),
(20, 9, '464999979376', 'Strapless  Rusty', 'Knitted Ribbed', 'XS', 90, 20, 100, '2021-11-13 19:21:44'),
(21, 9, '043411648156', 'Soulmate White', 'Knitted Ribbed', 'XS', 110, 20, 100, '2021-11-13 19:25:16'),
(22, 9, '006649960873', 'Soulmate Brown', 'Knitted Ribbed', 'XS', 110, 20, 100, '2021-11-13 19:25:44'),
(23, 9, '991847231544', 'Soulmate Light Blue', '', 'XS', 110, 20, 100, '2021-11-13 19:26:04'),
(24, 9, '092914810027', 'Body Suit White', 'Cotton', 'S', 120, 20, 100, '2021-11-13 19:26:28'),
(25, 9, '844827323186', 'Body Suite Violet', '', 'M', 120, 20, 100, '2021-11-13 19:26:46'),
(26, 9, '702805721516', 'Body Suit Black', 'Cotton', 'XS', 120, 20, 100, '2021-11-13 19:27:08'),
(27, 9, '162168032489', 'Backless Dress Gray', 'Cotton Spandex', 'XS', 150, 1, 100, '2021-11-13 19:27:45'),
(28, 9, '640321812677', 'Backless Dress Red', '', 'XS', 150, 20, 100, '2021-11-13 19:28:16'),
(29, 9, '192475470728', 'Backless Dress Neon Green', '', 'XS', 150, 20, 100, '2021-11-13 19:28:36'),
(30, 9, '119238618657', 'Square Dress Blue', 'Cotton', 'XS', 130, 20, 100, '2021-11-13 19:29:05'),
(31, 9, '086612049891', 'Square Dress Yellow', 'Cotton', 'L', 110, 20, 100, '2021-11-13 19:29:26'),
(32, 10, '827907771324', 'Bra ', '', 'M', 200, 20, 100, '2021-11-13 19:40:35'),
(33, 11, '501644074415', 'Fashion Bra', 'Cotton', 'S', 200, 20, 100, '2021-11-13 19:47:41'),
(34, 12, '936662404094', 'Revitalized Plus ', '', 'None', 200, 20, 100, '2021-11-13 19:51:00'),
(35, 12, '457074173066', 'Vita Plus Gold Dalandan', '', 'None', 200, 20, 100, '2021-11-13 19:51:57'),
(36, 12, '259179654866', 'Vita Plus Gold Melon', '', 'None', 200, 20, 100, '2021-11-13 19:53:04'),
(37, 12, '520299717916', 'Vita Plus Original Dalandan', '', 'None', 200, 20, 100, '2021-11-13 19:53:30'),
(38, 12, '733222772715', 'Vita Plus Original Melon', '', 'None', 200, 20, 100, '2021-11-13 19:53:53'),
(39, 12, '549303792452', 'Vitaplus Guyabano', '', 'None', 200, 20, 100, '2021-11-13 19:54:41'),
(40, 13, '308123556616', 'HB Ginger Lavander Oil', '', 'None', 180, 20, 100, '2021-11-13 20:04:52'),
(41, 13, '051685515121', 'HB Lemon Grass Oil', '', 'None', 180, 20, 100, '2021-11-13 20:05:15'),
(42, 13, '842456853500', 'HB 3 in 1 Shampoo ', '', 'None', 180, 20, 100, '2021-11-13 20:05:42'),
(43, 13, '445794643893', 'HB 3 in 1 Purity Soap', '', 'None', 200, 20, 100, '2021-11-13 20:08:11'),
(44, 11, '914246361794', 'Vibe ', 'Fragrance', 'None', 300, 20, 100, '2021-11-13 20:16:14'),
(45, 11, '955016717102', 'Thrill ', 'Fragrance', 'None', 300, 20, 100, '2021-11-13 20:17:03'),
(46, 11, '075008845367', 'Heartbeat ', 'Fragrance', 'None', 300, 20, 100, '2021-11-13 20:17:31'),
(47, 14, '566879296424', 'Cooling', 'Fragrance', 'None', 240, 20, 100, '2021-11-13 20:22:23'),
(48, 14, '194407595527', 'Confidence', 'Fragrance', 'None', 240, 20, 100, '2021-11-13 20:22:43'),
(49, 14, '619499203252', 'Power ', '', 'None', 240, 20, 100, '2021-11-13 20:23:03'),
(50, 14, '579376291302', 'No Marks', '', 'None', 240, 20, 100, '2021-11-13 20:23:19'),
(51, 14, '642179364374', 'Women Whitening', '', 'None', 200, 20, 100, '2021-11-13 20:27:16'),
(52, 14, '897778658342', 'Deo Cream Quelch', '', 'None', 200, 20, 100, '2021-11-13 20:28:25'),
(53, 14, '101807848597', 'Deo Ultra Glutathione', '', 'None', 218, 20, 100, '2021-11-13 20:28:51'),
(54, 14, '070345136054', 'Deo White Pearl Beauty', '', 'None', 218, 20, 100, '2021-11-13 20:29:19'),
(56, 12, '718012637121', 'Earphone', '', 'None', 99, 20, 100, '2021-11-13 20:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `po_items`
--

CREATE TABLE `po_items` (
  `id` int(30) NOT NULL,
  `po_id` int(30) NOT NULL,
  `item_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL,
  `price` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `po_items`
--

INSERT INTO `po_items` (`id`, `po_id`, `item_id`, `qty`, `price`, `date_created`) VALUES
(9, 7, 7, 100, 100, '2021-11-10 13:26:30'),
(10, 9, 10, 2, 50, '2021-11-13 19:06:43'),
(11, 9, 12, 1, 50, '2021-11-13 19:06:43'),
(12, 9, 11, 1, 50, '2021-11-13 19:06:43'),
(13, 9, 13, 2, 50, '2021-11-13 19:06:43'),
(14, 9, 14, 1, 50, '2021-11-13 19:06:43'),
(15, 10, 17, 2, 50, '2021-11-13 19:18:38'),
(16, 10, 15, 2, 50, '2021-11-13 19:18:38'),
(17, 10, 18, 2, 50, '2021-11-13 19:18:38'),
(18, 10, 16, 2, 50, '2021-11-13 19:18:38'),
(19, 11, 19, 1, 45, '2021-11-13 19:22:58'),
(20, 11, 20, 2, 45, '2021-11-13 19:22:58'),
(21, 12, 27, 1, 75, '2021-11-13 19:33:57'),
(22, 12, 29, 1, 75, '2021-11-13 19:33:57'),
(23, 12, 28, 1, 75, '2021-11-13 19:33:57'),
(24, 12, 26, 1, 60, '2021-11-13 19:33:57'),
(25, 12, 24, 1, 60, '2021-11-13 19:33:57'),
(26, 12, 25, 1, 60, '2021-11-13 19:33:57'),
(27, 12, 21, 2, 55, '2021-11-13 19:33:57'),
(28, 12, 23, 1, 55, '2021-11-13 19:33:57'),
(29, 12, 22, 1, 55, '2021-11-13 19:33:57'),
(30, 12, 31, 1, 55, '2021-11-13 19:33:57'),
(31, 12, 30, 2, 65, '2021-11-13 19:33:57'),
(32, 13, 32, 5, 100, '2021-11-13 19:41:33'),
(33, 14, 33, 2, 100, '2021-11-13 19:48:32'),
(34, 15, 34, 8, 100, '2021-11-13 19:56:15'),
(35, 15, 35, 5, 100, '2021-11-13 19:56:15'),
(36, 15, 36, 1, 100, '2021-11-13 19:56:15'),
(37, 15, 37, 1, 100, '2021-11-13 19:56:15'),
(38, 15, 38, 1, 100, '2021-11-13 19:56:15'),
(39, 15, 39, 1, 100, '2021-11-13 19:56:15'),
(40, 16, 43, 3, 100, '2021-11-13 20:10:50'),
(41, 16, 42, 2, 90, '2021-11-13 20:10:50'),
(42, 16, 40, 6, 90, '2021-11-13 20:10:50'),
(43, 16, 41, 3, 90, '2021-11-13 20:10:50'),
(44, 17, 46, 1, 150, '2021-11-13 20:18:20'),
(45, 17, 45, 3, 150, '2021-11-13 20:18:20'),
(46, 17, 44, 1, 150, '2021-11-13 20:18:20'),
(47, 18, 48, 2, 120, '2021-11-13 20:24:12'),
(48, 18, 47, 1, 120, '2021-11-13 20:24:12'),
(49, 18, 49, 1, 120, '2021-11-13 20:24:12'),
(50, 18, 50, 1, 120, '2021-11-13 20:24:12'),
(51, 19, 51, 3, 100, '2021-11-13 20:27:40'),
(52, 20, 52, 1, 100, '2021-11-13 20:29:55'),
(53, 20, 53, 2, 109, '2021-11-13 20:29:55'),
(54, 20, 54, 3, 109, '2021-11-13 20:29:55'),
(55, 21, 55, 40, 99, '2021-11-13 20:38:55'),
(56, 22, 56, 40, 99, '2021-11-13 20:41:59');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `id` int(30) NOT NULL,
  `po_code` varchar(50) NOT NULL,
  `supplier_id` int(30) NOT NULL,
  `total_cost` float NOT NULL,
  `remarks` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=received',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`id`, `po_code`, `supplier_id`, `total_cost`, `remarks`, `status`, `date_created`) VALUES
(7, 'PO-0001', 7, 10000, 'asdas', 2, '2021-11-10 13:26:30'),
(9, 'PO-0003', 9, 350, 'Make sure that the items are correct and complete', 1, '2021-11-13 19:06:43'),
(10, 'PO-0004', 9, 400, 'Make Sure that all items are complete and good condition', 1, '2021-11-13 19:18:38'),
(11, 'PO-0005', 9, 135, 'Make sure that the item are complete and good condition', 1, '2021-11-13 19:22:58'),
(12, 'PO-0006', 9, 810, 'Make sure that the item are ok', 1, '2021-11-13 19:33:57'),
(13, 'PO-0007', 10, 500, 'Make sure that the items are complete', 1, '2021-11-13 19:41:33'),
(14, 'PO-0008', 11, 200, 'Make sure the items are complete', 1, '2021-11-13 19:48:32'),
(15, 'PO-0009', 12, 1700, 'Make sure the items are complete', 1, '2021-11-13 19:56:15'),
(16, 'PO-0010', 13, 1290, 'Make sure that items are complete', 1, '2021-11-13 20:10:50'),
(17, 'PO-0011', 11, 750, 'Make sure the bottles are okay', 1, '2021-11-13 20:18:20'),
(18, 'PO-0012', 14, 600, 'Make sure that the bottle are okay', 1, '2021-11-13 20:24:12'),
(19, 'PO-0013', 14, 300, 'Please the product', 1, '2021-11-13 20:27:40'),
(20, 'PO-0014', 14, 645, 'Make sure that the items are complete', 1, '2021-11-13 20:29:55'),
(21, 'PO-0015', 9, 3960, 'hgh', 1, '2021-11-13 20:38:55'),
(22, 'PO-0016', 12, 3960, 'uy', 1, '2021-11-13 20:41:59');

-- --------------------------------------------------------

--
-- Table structure for table `receiving`
--

CREATE TABLE `receiving` (
  `id` int(30) NOT NULL,
  `po_id` int(30) NOT NULL,
  `supplier_id` int(30) NOT NULL,
  `description` text NOT NULL,
  `total_cost` float NOT NULL,
  `inventory_ids` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receiving`
--

INSERT INTO `receiving` (`id`, `po_id`, `supplier_id`, `description`, `total_cost`, `inventory_ids`, `date_created`) VALUES
(15, 7, 7, '', 5000, '30', '2021-11-10 13:26:43'),
(16, 9, 9, '', 300, '34,35,36,37,38', '2021-11-13 19:08:29'),
(17, 10, 9, '', 400, '41,42,43,44', '2021-11-13 19:19:19'),
(18, 11, 9, '', 135, '45,46', '2021-11-13 19:23:14'),
(19, 13, 10, '', 500, '47', '2021-11-13 19:42:22'),
(20, 12, 9, '', 810, '48,49,50,51,52,53,54,55,56,57,58', '2021-11-13 19:43:51'),
(21, 14, 11, '', 200, '59', '2021-11-13 19:48:45'),
(22, 15, 12, '', 1700, '60,61,62,63,64,65', '2021-11-13 19:56:40'),
(23, 16, 13, '', 1290, '66,67,68,69', '2021-11-13 20:11:09'),
(24, 17, 11, '', 750, '70,71,72', '2021-11-13 20:19:11'),
(25, 18, 14, '', 600, '73,74,75,76', '2021-11-13 20:24:54'),
(26, 19, 14, '', 300, '77', '2021-11-13 20:27:49'),
(27, 20, 14, '', 645, '78,79,80', '2021-11-13 20:30:12'),
(28, 21, 9, '', 1980, '82', '2021-11-13 20:39:18'),
(29, 22, 12, '', 1980, '85', '2021-11-13 20:42:10');

-- --------------------------------------------------------

--
-- Table structure for table `return_order`
--

CREATE TABLE `return_order` (
  `id` int(30) NOT NULL,
  `ro_code` varchar(50) NOT NULL,
  `supplier_id` int(30) NOT NULL,
  `total_cost` float NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `inventory_ids` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `return_order`
--

INSERT INTO `return_order` (`id`, `ro_code`, `supplier_id`, `total_cost`, `remarks`, `status`, `inventory_ids`, `date_created`) VALUES
(1, 'RO-0001', 6, 500, 'Sample Issue', 0, '28', '2021-10-26 23:03:37'),
(2, 'RO-0002', 6, 100, 'Sample Issue', 0, '29', '2021-10-26 23:05:25'),
(3, 'RO-0003', 7, 3000, 'damage', 0, '31', '2021-11-10 13:27:32'),
(4, 'RO-0004', 12, 0, 'damage', 0, '81', '2021-11-13 20:31:00'),
(5, 'RO-0005', 9, 2376, 'gy', 0, '84', '2021-11-13 20:40:29'),
(6, 'RO-0006', 12, 1980, 'hgh', 0, '87', '2021-11-13 20:43:31');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `total_amount` float NOT NULL,
  `amount_tendered` int(30) NOT NULL,
  `inventory_ids` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `total_amount`, `amount_tendered`, `inventory_ids`, `date_created`) VALUES
(5, 1, 150, 150, '88', '2021-11-13 20:46:07');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(30) NOT NULL,
  `item_id` int(30) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1= in,2=out',
  `qty` int(30) NOT NULL,
  `price` float NOT NULL,
  `profit_perc` float NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `item_id`, `type`, `qty`, `price`, `profit_perc`, `date_created`) VALUES
(28, 5, 2, 10, 50, 0, '2021-10-26 23:03:37'),
(29, 5, 2, 5, 50, 0, '2021-10-26 23:05:25'),
(30, 7, 1, 50, 100, 0, '2021-11-10 13:26:43'),
(31, 7, 2, 30, 100, 0, '2021-11-10 13:27:32'),
(34, 10, 1, 2, 50, 50, '2021-11-13 19:08:29'),
(35, 12, 1, 1, 50, 50, '2021-11-13 19:08:29'),
(36, 11, 1, 1, 50, 50, '2021-11-13 19:08:29'),
(37, 13, 1, 2, 50, 50, '2021-11-13 19:08:29'),
(38, 14, 1, 0, 50, 50, '2021-11-13 19:08:29'),
(39, 14, 1, 1, 50, 0, '2021-11-13 19:10:11'),
(41, 17, 1, 2, 50, 100, '2021-11-13 19:19:19'),
(42, 15, 1, 2, 50, 100, '2021-11-13 19:19:19'),
(43, 18, 1, 2, 50, 100, '2021-11-13 19:19:19'),
(44, 16, 1, 2, 50, 100, '2021-11-13 19:19:19'),
(45, 19, 1, 1, 45, 100, '2021-11-13 19:23:14'),
(46, 20, 1, 2, 45, 100, '2021-11-13 19:23:14'),
(47, 32, 1, 5, 100, 100, '2021-11-13 19:42:22'),
(48, 27, 1, 1, 75, 100, '2021-11-13 19:43:51'),
(49, 29, 1, 1, 75, 100, '2021-11-13 19:43:51'),
(50, 28, 1, 1, 75, 100, '2021-11-13 19:43:51'),
(51, 26, 1, 1, 60, 100, '2021-11-13 19:43:51'),
(52, 24, 1, 1, 60, 100, '2021-11-13 19:43:51'),
(53, 25, 1, 1, 60, 100, '2021-11-13 19:43:51'),
(54, 21, 1, 2, 55, 100, '2021-11-13 19:43:51'),
(55, 23, 1, 1, 55, 100, '2021-11-13 19:43:51'),
(56, 22, 1, 1, 55, 100, '2021-11-13 19:43:51'),
(57, 31, 1, 1, 55, 100, '2021-11-13 19:43:51'),
(58, 30, 1, 2, 65, 100, '2021-11-13 19:43:51'),
(59, 33, 1, 2, 100, 100, '2021-11-13 19:48:45'),
(60, 34, 1, 8, 100, 100, '2021-11-13 19:56:40'),
(61, 35, 1, 5, 100, 100, '2021-11-13 19:56:40'),
(62, 36, 1, 1, 100, 100, '2021-11-13 19:56:40'),
(63, 37, 1, 1, 100, 100, '2021-11-13 19:56:40'),
(64, 38, 1, 1, 100, 100, '2021-11-13 19:56:40'),
(65, 39, 1, 1, 100, 100, '2021-11-13 19:56:40'),
(66, 43, 1, 3, 100, 100, '2021-11-13 20:11:09'),
(67, 42, 1, 2, 90, 100, '2021-11-13 20:11:09'),
(68, 40, 1, 6, 90, 100, '2021-11-13 20:11:09'),
(69, 41, 1, 3, 90, 100, '2021-11-13 20:11:09'),
(70, 46, 1, 1, 150, 100, '2021-11-13 20:19:11'),
(71, 45, 1, 3, 150, 100, '2021-11-13 20:19:11'),
(72, 44, 1, 1, 150, 100, '2021-11-13 20:19:11'),
(73, 48, 1, 2, 120, 100, '2021-11-13 20:24:54'),
(74, 47, 1, 1, 120, 100, '2021-11-13 20:24:54'),
(75, 49, 1, 1, 120, 100, '2021-11-13 20:24:54'),
(76, 50, 1, 1, 120, 100, '2021-11-13 20:24:54'),
(77, 51, 1, 3, 100, 100, '2021-11-13 20:27:49'),
(78, 52, 1, 1, 100, 100, '2021-11-13 20:30:12'),
(79, 53, 1, 2, 109, 100, '2021-11-13 20:30:12'),
(80, 54, 1, 3, 109, 100, '2021-11-13 20:30:12'),
(81, 35, 2, 2, 200, 0, '2021-11-13 20:31:00'),
(82, 55, 1, 20, 99, 20, '2021-11-13 20:39:18'),
(83, 55, 1, 20, 99, 0, '2021-11-13 20:39:55'),
(84, 55, 2, 20, 118.8, 0, '2021-11-13 20:40:29'),
(85, 56, 1, 20, 99, 0, '2021-11-13 20:42:10'),
(86, 56, 1, 20, 99, 0, '2021-11-13 20:42:42'),
(87, 56, 2, 20, 99, 0, '2021-11-13 20:43:31'),
(88, 27, 2, 1, 150, 0, '2021-11-13 20:46:07');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `contact_person` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `address`, `contact`, `contact_person`, `date_created`) VALUES
(9, 'Zara supplier', 'Taytay Rizal', '09085136646', 'Princess', '2021-11-13 18:50:20'),
(10, 'Everyday Comfort ', 'Talon Uno Las Pinas City', '09846372542', 'Regine', '2021-11-13 19:40:05'),
(11, 'Avon Supplier', 'Bacoor, Cavite City', '09857463473', 'Jean', '2021-11-13 19:46:27'),
(12, 'Vita Plus Supplier', 'Talon Uno, Las Pinas City', '09483726374', 'Phem', '2021-11-13 19:49:51'),
(13, 'Herbal Blessing Supplier', 'Pulang Lupa, Uno Las Pinas City', '095834725463', 'Jenesis', '2021-11-13 20:04:22'),
(14, 'Feeling Fresh Supplier', 'TayTay, Rizal', '0958473645', 'Rica May', '2021-11-13 20:21:55');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Beatus', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1=Admin,2=Staff',
  `recovery_question` text DEFAULT NULL,
  `recovery_answer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`, `recovery_question`, `recovery_answer`) VALUES
(1, 'admin', 'admin', '0192023a7bbd73250516f069df18b500', 1, '1 + 1', '2'),
(2, 'Renzo', 'renzo', '827ccb0eea8a706c4c34a16891f84e7b', 2, '1 + 1 =', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `back_order`
--
ALTER TABLE `back_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `po_items`
--
ALTER TABLE `po_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receiving`
--
ALTER TABLE `receiving`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_order`
--
ALTER TABLE `return_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
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
-- AUTO_INCREMENT for table `back_order`
--
ALTER TABLE `back_order`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `po_items`
--
ALTER TABLE `po_items`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `receiving`
--
ALTER TABLE `receiving`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `return_order`
--
ALTER TABLE `return_order`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
