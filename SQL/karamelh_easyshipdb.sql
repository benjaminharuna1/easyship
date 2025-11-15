-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 15, 2024 at 08:16 AM
-- Server version: 10.11.7-MariaDB
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `karamelh_easyshipdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `addtracking`
--

CREATE TABLE `addtracking` (
  `id` int(11) NOT NULL,
  `tracking_id` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `sender_contact` varchar(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `sender_address` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `dispatch_location` varchar(255) NOT NULL,
  `carrier` varchar(255) NOT NULL,
  `carrier_refrence_number` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `receiver_contact` varchar(2555) NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `receiver_address` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `package_discription` varchar(255) NOT NULL,
  `dispach_date` date NOT NULL,
  `estimated_delivery_date` date NOT NULL,
  `shipment_mode` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `delivery_time` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `updated_time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `current_location` varchar(255) DEFAULT NULL,
  `delivery_message` text DEFAULT NULL,
  `date_added` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addtracking`
--

INSERT INTO `addtracking` (`id`, `tracking_id`, `sender_name`, `sender_contact`, `sender_email`, `sender_address`, `status`, `dispatch_location`, `carrier`, `carrier_refrence_number`, `weight`, `payment_mode`, `image`, `receiver_name`, `receiver_contact`, `receiver_email`, `receiver_address`, `destination`, `package_discription`, `dispach_date`, `estimated_delivery_date`, `shipment_mode`, `quantity`, `delivery_time`, `message`, `updated_time`, `current_location`, `delivery_message`, `date_added`) VALUES
(105, '1234567890', 'mike', '1234567890', 'funds12095@gmail.com', '16 lagos road', 'In Transit', 'Nigeria', 'DHL', '0013', '10', 'credit card 💳', '171155196327.png', 'smith', '09019378014', 'james2758543@gmail.com', '100 ediaken primary school road', 'london', 'laptop', '2024-03-28', '2024-03-30', 'air', '6', '20:03', NULL, '2024-03-28 15:47:27', 'lagos', NULL, '27-03-24 04:06:03pm'),
(106, 'CL041671498', 'Lyn Caryn', '+9876436373', 'sender@email.com', '12 Desmond Close 2367', 'Active', 'Germany', 'DHL', '5445666', '10KG', 'Transfer', '171273509110.png', 'Brown Kate', '+67543245678', 'gseun129@gmail.com', 'gseun129@gmail.com', 'Finland', 'Rolex Wrist watch Gold', '2024-04-07', '2024-04-20', 'DHL', '1', '10:00', NULL, '2024-04-10 08:44:51', NULL, NULL, '10-04-24 07:44:51am'),
(107, 'CL048134263', 'Lyn Caryn', '+9876436373', 'sender@email.com', '12 Desmond Close 2367', 'Delivered', 'Germany', 'DHL', '5445666', '10KG', 'Transfer', '171273512210.png', 'Brown Kate', '+67543245678', 'gseun129@gmail.com', 'gseun129@gmail.com', 'Finland', 'Rolex Wrist watch Gold', '2024-04-07', '2024-04-20', 'DHL', '1', '10:00', NULL, '2024-04-10 09:01:22', 'Bentley', NULL, '10-04-24 07:45:22am');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@mail.com', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `sitename` varchar(255) NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `site_url` varchar(255) NOT NULL,
  `tracking_num` varchar(255) NOT NULL,
  `email_name` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `sitename`, `site_title`, `site_url`, `tracking_num`, `email_name`, `email_address`) VALUES
(1, 'CargoLink', 'logistics', 'https://www.cargolink.com', '0987654321', 'CargoLink', 'CargoLink@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `track_update`
--

CREATE TABLE `track_update` (
  `id` int(11) NOT NULL,
  `track_num` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `note` varchar(255) NOT NULL,
  `current_location` varchar(255) NOT NULL,
  `invoice_sub_total` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `tax` varchar(255) NOT NULL,
  `invoice_total` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `track_update`
--

INSERT INTO `track_update` (`id`, `track_num`, `status`, `date`, `time`, `note`, `current_location`, `invoice_sub_total`, `discount`, `tax`, `invoice_total`, `updated_at`) VALUES
(99, '1234567890', 'Active', '2024-03-21', '16:32', ' Your package is on the way', 'benin', '10', '6', '50', '66', '2024-03-28 14:47:22'),
(100, '1234567890', 'In Transit', '2024-03-28', '22:31', ' package on the way', 'lagos', '10', '12', '50', '72', '2024-03-28 14:47:20'),
(101, 'CL048134263', 'In Transit', '2024-04-05', '11:00', ' Packing delivery on his way', 'USA', '$25000', '$1000', '$200', '0', '2024-04-10 07:48:47'),
(102, 'CL048134263', 'On Hold', '2024-04-06', '11:00', ' Goods on his way', 'New Jersey', '$25000', '$1000', '$200', '0', '2024-04-10 07:53:41'),
(103, 'CL048134263', 'Awaiting Delivery', '2024-04-07', '12:00', ' Waiting to be packed', 'California', '$25000', '$1000', '$200', '0', '2024-04-10 07:55:49'),
(104, 'CL048134263', 'Delivered', '2024-04-09', '15:00', ' Delivered to clients', 'Bentley', '$25000', '$1000', '$200', '0', '2024-04-10 08:01:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addtracking`
--
ALTER TABLE `addtracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `track_update`
--
ALTER TABLE `track_update`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addtracking`
--
ALTER TABLE `addtracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `track_update`
--
ALTER TABLE `track_update`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
