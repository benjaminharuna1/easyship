-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 02, 2026 at 11:18 AM
-- Server version: 11.4.12-MariaDB-cll-lve-log
-- PHP Version: 8.4.24


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exprkfmf_easyship`
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
  `total_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) NOT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `receiver_contact` varchar(2555) NOT NULL,
  `receiver_email` varchar(255) NOT NULL,
  `receiver_address` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `package_discription` varchar(255) NOT NULL,
  `dispatch_date` date NOT NULL,
  `estimated_delivery_date` date NOT NULL,
  `shipment_mode` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `delivery_time` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `updated_time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `current_location` varchar(255) DEFAULT NULL,
  `delivery_message` text DEFAULT NULL,
  `coordinates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`coordinates`)),
  `date_added` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  `total_freight` decimal(10,2) DEFAULT NULL,
  `courier` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `datetimepicker` datetime DEFAULT NULL,
  `type_of_shipment` varchar(255) DEFAULT NULL,
  `total_volumetric_weight` decimal(10,2) DEFAULT NULL,
  `total_actual_weight` decimal(10,2) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addtracking`
--

INSERT INTO `addtracking` (`id`, `tracking_id`, `sender_name`, `sender_contact`, `sender_email`, `sender_address`, `status`, `dispatch_location`, `carrier`, `carrier_refrence_number`, `weight`, `payment_mode`, `total_cost`, `image`, `receiver_name`, `receiver_contact`, `receiver_email`, `receiver_address`, `destination`, `package_discription`, `dispatch_date`, `estimated_delivery_date`, `shipment_mode`, `quantity`, `delivery_time`, `message`, `updated_time`, `current_location`, `delivery_message`, `coordinates`, `date_added`, `remarks`, `total_freight`, `courier`, `origin`, `comments`, `datetimepicker`, `type_of_shipment`, `total_volumetric_weight`, `total_actual_weight`, `published`) VALUES
(105, '12345678901', 'mikes', '1234567890', 'ben@yopmail.com', '16 lagos road', 'Pending', 'Kaduna', 'DHL', '0013', '10', 'Cash', 200.00, '171155196327', 'smith', '09019378014', 'king@yopmail.com', '100 ediaken primary school road', 'benue', 'laptop', '2025-11-07', '2024-03-30', 'Land Shipping', '6', '20:03', NULL, '2025-11-25 06:35:00', 'Jos', NULL, '{\"history\": [{\"lat\": null, \"lon\": null, \"name\": \"Abuja\"}, {\"lat\": null, \"lon\": null, \"name\": \"Kaduna\"}, {\"lat\": \"9.91751250\", \"lon\": \"8.89794010\", \"name\": \"Jos\"}, {\"lat\": null, \"lon\": null, \"name\": \"Kaduna\"}, {\"lat\": \"9.91751250\", \"lon\": \"8.89794010\", \"name\": \"Jos\"}], \"dispatch\": {\"error\": \"API request failed with HTTP status 0. Check your API key and server\'s internet connection.\"}, \"destination\": {\"error\": \"API request failed with HTTP status 0. Check your API key and server\'s internet connection.\"}}', '27-03-24 04:06:03pm', NULL, 0.00, 'DHL', NULL, '', NULL, 'Express', NULL, NULL, 0),
(106, 'CL041671498', 'Lyn Caryn', '+9876436373', 'sender@email.com', '12 Desmond Close 2367', 'Active', 'Germany', 'DHL', '5445666', '10KG', 'Transfer', 0.00, '171273509110.png', 'Brown Kate', '+67543245678', 'gseun129@gmail.com', 'gseun129@gmail.com', 'Finland', 'Rolex Wrist watch Gold', '2024-04-07', '2024-04-20', 'DHL', '1', '10:00', NULL, '2024-04-10 08:44:51', NULL, NULL, NULL, '10-04-24 07:44:51am', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(107, 'CL048134263', 'Lyn Caryn', '+9876436373', 'sender@email.com', '12 Desmond Close 2367', 'Delivered', 'Germany', 'DHL', '5445666', '10KG', 'Transfer', 0.00, '171273512210.png', 'Brown Kate', '+67543245678', 'gseun129@gmail.com', 'gseun129@gmail.com', 'Finland', 'Rolex Wrist watch Gold', '2024-04-07', '2024-04-20', 'DHL', '1', '10:00', NULL, '2024-04-10 09:01:22', 'Bentley', NULL, NULL, '10-04-24 07:45:22am', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(108, '0987654321118913625', 'sam', '87998797', 'dot@dot.com', 'FKGLKJLKS', '', 'Nigeria', 'DHL', '404', '4', 'Cash', 200.00, '', 'sammy', '0994089', 'dot@dot2.com', 'ddkkjsjksd', 'london', 'dfoifkk', '2025-11-21', '2025-12-04', 'Land Shipping', '4', '', NULL, '2025-11-22 16:07:15', NULL, NULL, '{\"history\": [], \"dispatch\": null, \"destination\": null}', '20-11-25 11:44:23pm', NULL, 2.00, 'DHL', NULL, '', NULL, 'Standard', 0.00, 1.00, 0),
(109, '0987654321110699160', 'snow', '0989890', 'ben@yopmail.com', 'jkhjhlh', '', 'Nigeria', 'DHL', '98877', '10', 'Cash', 200.00, '0', 'carla', '879879', 'ben@yopmail.com', 'jhjl', 'london', 'mnb,nb,nb', '2025-11-05', '2025-11-27', 'Land Shipping', '7', '', NULL, '2025-11-21 17:45:04', NULL, NULL, NULL, '2025-11-21 16:42:43', NULL, 4.00, 'DHL', NULL, 'hjjhkjl', NULL, 'Express', NULL, NULL, 0),
(111, '0987654321112020434', 'snow', '3075277639', 'funds12095@gmail.com', '2111 Pioneer Ave', '', 'Kenya', 'DHL', 'bn777', '6', 'Cash', 200.00, '', 'sammy', '3075277639', 'gen@yopmail.com', '2111 Pioneer Ave', 'liberia', 'hggkhgkh', '2025-11-15', '2025-12-04', 'Air Shipping', '6', '', NULL, '2025-11-21 17:49:13', NULL, NULL, NULL, '2025-11-21 16:49:13', NULL, 5.00, 'DHL', NULL, '', NULL, 'Express', 0.00, 0.00, 0),
(113, 'CL112274035', 'snow', '3075277639', 'ben@yopmail.com', '2111 Pioneer Ave', '', 'Nigeria', 'DHL', 'skdsldk22', '25', 'Cash', 2000.00, '', 'sammy', '3075277639', 'king@yopmail.com', '2111 Pioneer Ave', 'benue', 'gja;kgj;ds', '2025-11-26', '2025-12-05', 'Land Shipping', '1', '', NULL, '2025-11-25 07:34:23', NULL, NULL, NULL, '2025-11-25 05:45:54', NULL, 2.00, 'DHL', NULL, 'dkjfhsldsjafhdj', NULL, 'Express', NULL, NULL, 0),
(114, 'CL111708284', 'GUANGDONG PANATA.CO.LTD FOR (MARK WARREN)', '+18082293158', 'markwarren802@gmail.com', 'Honolulu, Hawaii USA', '', 'CHINA', 'Rapid Routes Express', 'GP6138014', '49450KG', 'Transfer', 39381.00, '1764298267_WhatsApp Image 2025-11-28 at 01.56.53_8ddd82e1.jpg', 'ANDREA DAWN LOFTS', '07526552797', 'andrealofts1966@gmail.com', 'Nicolson Way, Burton-on-Trent, DE14 2AW', 'UNITED KINGDOM', 'Gym,Cafeteria,Well-being center equipment and Vehicle (minivan)', '2025-12-01', '2026-02-07', 'Sea Shipping', '73', '', NULL, '2025-11-27 21:55:21', NULL, NULL, NULL, '2025-11-28 02:51:07', NULL, 5.00, 'Rapid Routes Express', NULL, 'THANKS YOU FOR CHOSEN US..', NULL, 'Standard', NULL, NULL, 0),
(115, 'CL080537692', 'MR MARK WARREN', '+18082293158', 'markwarren802@gmail.com', 'Honolulu, Hawaii USA', '', 'HONOLULU HAWAII US state', 'Rapid Routes Express', '3255FG', '2497kg', 'Transfer', 23777.15, '1788036107_cargo-airplane-loading-with-large-pallet-for-international-trade-and-global-supply-chain-photo.jpeg', 'MRS LENA GRUPE', '+491752184585', 'lgrupe6@gmail.com', 'PoststraÃŸe 11B, 35767 Breitscheid, Germany', 'Breitscheid Germany ', 'Household items, jewelry&amp;watches, safe box', '2026-08-30', '2026-09-02', 'Air Shipping', '27', '', NULL, '2026-09-01 07:58:54', NULL, NULL, NULL, '2026-08-29 20:41:47', NULL, 3.00, 'Rapid Routes Express', NULL, 'Shipment successfully registered for delivery. Confirmation and tracking updates will follow accordingly.', NULL, 'Express', NULL, NULL, 0);

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
(1, 'admin@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `geocache`
--

CREATE TABLE `geocache` (
  `id` int(11) NOT NULL,
  `place` varchar(255) NOT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lon` decimal(11,8) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `geocache`
--

INSERT INTO `geocache` (`id`, `place`, `lat`, `lon`, `updated_at`) VALUES
(1, 'jos', 9.91751250, 8.89794010, '2025-11-22 16:47:58');

-- --------------------------------------------------------

--
-- Table structure for table `legal_pages`
--

CREATE TABLE `legal_pages` (
  `id` int(11) NOT NULL,
  `page_slug` varchar(100) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` longtext NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `legal_pages`
--

INSERT INTO `legal_pages` (`id`, `page_slug`, `page_title`, `page_content`, `last_updated`) VALUES
(1, 'terms-and-conditions', 'Terms &amp;amp; Conditions', '<h1><strong>Terms and Conditions</strong></h1><p>Welcome to <strong>[site-name]</strong> (we, our, or us). By accessing or using <strong>[site-url]</strong>, you agree to comply with and be bound by these Terms and Conditions. If you do not agree with any part of these terms, please stop using our services immediately.</p><p><br></p><h2><strong>1. Acceptance of Terms</strong></h2><p>By accessing our website or using any of our courier and delivery services, you agree to these Terms and Conditions and our Privacy Policy.</p><p><br></p><h2><strong>2. Our Services</strong></h2><p><strong>[site-name]</strong> provides courier, parcel delivery, logistics, and related services. We reserve the right to modify, suspend, or discontinue any aspect of our services at any time without prior notice.</p><p><br></p><h2><strong>3. User Responsibilities</strong></h2><p>You agree to:</p><ul><li>Provide accurate and complete information when placing delivery orders.</li><li>Ensure that items sent comply with all applicable laws and regulations.</li><li>Not ship prohibited, illegal, hazardous, or dangerous items.</li><li>Properly package the items for safe delivery.</li></ul><p>We are not liable for loss or damage caused by improper packaging or restricted items.</p><p><br></p><h2><strong>4. Prohibited Items</strong></h2><p>The following items are strictly prohibited:</p><ul><li>Illegal goods or contraband</li><li>Explosives, flammable items, or hazardous materials</li><li>Weapons or ammunition</li><li>Perishable food not properly packaged</li><li>Cash, jewelry, or highly valuable items (unless agreed upon in writing)</li></ul><p>We reserve the right to refuse any shipment that violates these restrictions.</p><p><br></p><h2><strong>5. Delivery Timeframes</strong></h2><p>Delivery times provided on <strong>[site-url]</strong> are estimates and not guaranteed. Delays may occur due to traffic, weather, security checks, or unforeseen circumstances.</p><p><br></p><h2><strong>6. Liability and Limitations</strong></h2><p>We exercise reasonable care in handling all packages; however, <strong>[site-name]</strong> is not liable for:</p><ul><li>Delays beyond our control</li><li>Damaged or lost items due to improper packaging</li><li>Items containing prohibited materials</li><li>Losses arising from inaccurate delivery information provided by the user</li></ul><p>Any claim for loss or damage must be reported within 24ï¿½48 hours of delivery with supporting evidence.</p><p><br></p><h2><strong>7. Fees and Payments</strong></h2><p>Service fees will be clearly displayed on <strong>[site-url]</strong>. By placing an order, you agree to pay the total cost associated with the selected delivery service. Prices may be updated without prior notice.</p><p><br></p><h2><strong>8. Cancellations</strong></h2><p>Users may cancel delivery requests only before the dispatch process begins. Once a rider/driver has been assigned, cancellation fees may apply.</p><p><br></p><h2><strong>9. Privacy Policy</strong></h2><p>We collect personal information to provide courier services. Your information is stored securely and will not be shared with third parties except as required to complete your delivery or comply with the law. For more details, contact us at <strong>[email-address]</strong>.</p><p><br></p><h2><strong>10. Intellectual Property</strong></h2><p>All content on <strong>[site-url]</strong>, including logos, images, text, and design elements, is the property of <strong>[site-name]</strong> and protected under applicable copyright laws. You may not copy or reproduce any content without written permission.</p><p><br></p><h2><strong>11. Termination of Service</strong></h2><p>We may suspend or terminate access to our services for users who violate these Terms and Conditions or misuse the platform.</p><p><br></p><h2><strong>12. Governing Law</strong></h2><p>These Terms and Conditions are governed by applicable laws within the jurisdiction of <strong>[site-address]</strong>. Any disputes must be resolved in competent courts within that jurisdiction.</p><p><br></p><h2><strong>13. Contact Information</strong></h2><p>For inquiries or support, you may contact us at:</p><ul><li><strong>Email:</strong> [email-address]</li><li><strong>Phone:</strong> [phone-number]</li><li><strong>Fax:</strong> [fax-number]</li><li><strong>Address:</strong> [site-address]</li></ul><h2><strong>14. Updates to These Terms</strong></h2><p><strong>[site-name]</strong> reserves the right to update or modify these Terms and Conditions at any time. Continued use of <strong>[site-url]</strong> after changes are posted constitutes acceptance of the revised terms.</p>', '2025-11-26 01:42:12'),
(2, 'privacy-policy', 'Privacy Policy', '<h1><strong>Privacy Policy</strong></h1><p>This Privacy Policy explains how <strong>[site-name]</strong> (“we,” “our,” or “us”) collects, uses, stores, and protects your information when you visit <strong>[site-url]</strong> or use our courier and delivery services. By accessing our website or using our services, you agree to the practices described in this policy.</p><p><br></p><h2><strong>1. Information We Collect</strong></h2><h3><strong>a. Personal Information</strong></h3><p>We may collect the following personal details when you use our services:</p><ul><li>Full name</li><li>Email address (<strong>[email-address]</strong>)</li><li>Phone number (<strong>[phone-number]</strong>)</li><li>Delivery and pickup addresses</li><li>Payment information (processed securely by third-party providers)</li></ul><h3><strong>b. Non-Personal Information</strong></h3><p>We may also collect:</p><ul><li>Browser type and device information</li><li>IP address</li><li>Pages visited on <strong>[site-url]</strong></li><li>Cookies and usage data</li></ul><h2><strong>2. How We Use Your Information</strong></h2><p>We use your information to:</p><ul><li>Process and complete delivery orders</li><li>Provide updates and notifications about your shipment</li><li>Improve our website and services</li><li>Respond to inquiries sent to <strong>[email-name]</strong> or <strong>[email-address]</strong></li><li>Ensure security and prevent fraud</li><li>Comply with legal obligations</li></ul><p>We do <strong>not</strong> sell, rent, or trade your personal information.</p><p><br></p><h2><strong>3. Sharing of Information</strong></h2><p>We may share your information with trusted third parties such as:</p><ul><li>Delivery personnel assigned to your order</li><li>Payment processors</li><li>IT and hosting service providers</li><li>Legal authorities (only when required by law)</li></ul><p>These third parties are required to protect your data and use it only for the intended purpose.</p><p><br></p><h2><strong>4. Cookies and Tracking Technologies</strong></h2><p><strong>[site-url]</strong> may use cookies to:</p><ul><li>Improve user experience</li><li>Track website performance</li><li>Remember user preferences</li></ul><p>You may choose to disable cookies through your browser settings, but some features may not function properly.</p><p><br></p><h2><strong>5. Data Security</strong></h2><p>We use administrative, technical, and physical safeguards to protect your personal information against:</p><ul><li>Loss</li><li>Theft</li><li>Unauthorized access</li><li>Disclosure or modification</li></ul><p>Although we implement strong security measures, no method of transmission over the internet is 100% secure.</p><p><br></p><h2><strong>6. Data Retention</strong></h2><p>We retain your information only as long as necessary to:</p><ul><li>Provide our services</li><li>Meet legal requirements</li><li>Resolve disputes</li><li>Maintain accurate delivery records</li></ul><h2><strong>7. Your Rights</strong></h2><p>Depending on your location, you may have the right to:</p><ul><li>Access the personal information we hold about you</li><li>Request corrections to inaccurate data</li><li>Request deletion of your data</li><li>Withdraw consent to processing</li><li>Opt-out of marketing communications</li></ul><p>To exercise any rights, contact us at <strong>[email-address]</strong>.</p><p><br></p><h2><strong>8. Links to Third-Party Websites</strong></h2><p>Our website <strong>[site-url]</strong> may contain links to external websites. We are not responsible for the privacy practices or content of those third-party platforms.</p><p><br></p><h2><strong>9. Children’s Privacy</strong></h2><p>Our services are not intended for individuals under 18 years of age. We do not knowingly collect personal data from minors.</p><p><br></p><h2><strong>10. Changes to This Privacy Policy</strong></h2><p>We may update this Privacy Policy from time to time. Changes will be posted on <strong>[site-url]</strong>, and continued use of our services means acceptance of the updated policy.</p><p><br></p><h2><strong>11. Contact Information</strong></h2><p>If you have questions or concerns about this Privacy Policy, contact us at:</p><ul><li><strong>Email:</strong> [email-address]</li><li><strong>Phone:</strong> [phone-number]</li><li><strong>Fax:</strong> [fax-number]</li><li><strong>Address:</strong> [site-address]</li></ul><p><br></p>', '2025-11-25 23:56:09');

-- --------------------------------------------------------

--
-- Table structure for table `package_items`
--

CREATE TABLE `package_items` (
  `id` int(11) NOT NULL,
  `tracking_id` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `piece_type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `length` decimal(10,2) NOT NULL,
  `width` decimal(10,2) NOT NULL,
  `height` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package_items`
--

INSERT INTO `package_items` (`id`, `tracking_id`, `quantity`, `piece_type`, `description`, `length`, `width`, `height`, `weight`) VALUES
(14, '0987654321119852177', 1, 'nbn,', 'bhghjgjh', 3.00, 3.00, 3.00, 3.00),
(16, '0987654321110699160', 1, 'nbn,', 'bhghjgjh', 3.00, 3.00, 3.00, 3.00),
(17, '0987654321116421318', 1, 'dskfj', 'kjfdksa;j', 2.00, 2.00, 2.00, 2.00),
(28, '12345678901', 1, 'ddk', 'tlkjsakj;aklej', 1.00, 1.00, 1.00, 1.00),
(30, 'CL112274035', 1, '1', '1', 1.00, 1.00, 1.00, 1.00),
(53, 'CL111708284', 1, 'CAR', 'Mini Van', 0.00, 0.00, 0.00, 2268.00),
(54, 'CL111708284', 4, 'EQUIPMENT/TOOLS', 'Gym,Cafeteria,Well-being center equipment and tools', 0.00, 0.00, 0.00, 47182.00),
(115, 'CL080537692', 23, 'HOUSEHOLD ITEMS', 'includes clothing,electronics and more', 0.00, 0.00, 0.00, 2467.00),
(116, 'CL080537692', 3, 'VALUABLE ITEMS', 'jewelry, watches/bar', 0.00, 0.00, 0.00, 2.00),
(117, 'CL080537692', 1, 'SAFE BOX', 'box', 0.00, 0.00, 0.00, 28.00);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon_class` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `icon_class`, `image`, `is_published`, `is_featured`, `created_at`) VALUES
(1, 'Air Freight', 'Our air freight services provide fast and reliable delivery for your time-sensitive shipments. We offer a range of options to meet your specific needs, including door-to-door and airport-to-airport services.', 'icon-paper-plane', 'assets/img/service/service-three__img6.jpg', 1, 0, '2025-11-25 19:08:52'),
(2, 'Ocean Freight', 'For larger shipments with flexible delivery schedules, our ocean freight services are a cost-effective solution. We provide full container load (FCL) and less-than-container load (LCL) options to destinations worldwide.', 'icon-cargo-ship', 'assets/img/service/ocean-freight-scaled.jpeg', 1, 0, '2025-11-25 19:08:52'),
(3, 'Road Freight', 'Our comprehensive road freight services ensure your goods are transported safely and efficiently. We offer a modern fleet of vehicles and a network of partners to provide reliable ground transportation.', 'icon-delivery-truck2', 'assets/img/service/service-details-img2.jpg', 1, 0, '2025-11-25 19:08:52'),
(4, 'Warehousing', 'We provide secure and flexible warehousing solutions to meet your storage needs. Our facilities are equipped with modern technology to ensure the safety and proper management of your inventory.', 'icon-warehouse1', 'assets/img/service/service-three__img5.jpg', 1, 0, '2025-11-25 19:08:52'),
(5, 'Project Cargo', 'Our project cargo services are designed to handle oversized, heavy, or complex shipments. We provide customized solutions and expert handling to ensure your specialized cargo reaches its destination safely.', 'icon-cargo', 'assets/img/service/projectcargo_image02.png', 1, 0, '2025-11-25 19:08:52'),
(6, 'Customs Clearance', 'Navigating customs regulations can be complex. Our experienced team handles all aspects of customs clearance to ensure your shipments cross borders smoothly and without delay, ensuring compliance and efficiency.', 'icon-post-office', 'assets/img/service/service-three__img4.jpg', 1, 0, '2025-11-25 19:08:52');

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
  `email_address` varchar(255) NOT NULL,
  `site_logo` varchar(255) NOT NULL,
  `site_favicon` varchar(255) NOT NULL,
  `invoice_stamp` varchar(255) DEFAULT NULL,
  `invoice_banner` varchar(255) DEFAULT NULL,
  `payment_methods_image` varchar(255) DEFAULT NULL,
  `smtp_host` varchar(255) NOT NULL,
  `smtp_username` varchar(255) NOT NULL,
  `smtp_password` varchar(255) NOT NULL,
  `smtp_port` int(11) NOT NULL,
  `smtp_secure` varchar(255) NOT NULL,
  `geocode_api_key` varchar(255) NOT NULL,
  `hero_subtitle` varchar(255) NOT NULL DEFAULT 'Smart Solutions',
  `hero_title` varchar(255) DEFAULT NULL,
  `hero_text` text NOT NULL,
  `years_experience` int(11) NOT NULL DEFAULT 10,
  `achievement_1_num` int(11) NOT NULL DEFAULT 250,
  `achievement_1_title` varchar(255) NOT NULL DEFAULT 'Team member',
  `achievement_2_num` int(11) NOT NULL DEFAULT 300,
  `achievement_2_title` varchar(255) NOT NULL DEFAULT 'Complete project',
  `achievement_3_num` int(11) NOT NULL DEFAULT 450,
  `achievement_3_title` varchar(255) NOT NULL DEFAULT 'Winning award',
  `achievement_4_num` int(11) NOT NULL DEFAULT 1,
  `achievement_4_suffix` varchar(10) NOT NULL DEFAULT 'k',
  `achievement_4_title` varchar(255) NOT NULL DEFAULT 'Worldwide clients',
  `video_bg_image` varchar(255) NOT NULL DEFAULT 'assets/img/resource/video-one__img1.jpg',
  `video_url` varchar(255) NOT NULL DEFAULT 'https://www.youtube.com/watch?v=06dV9txztKY',
  `site_currency` varchar(10) NOT NULL DEFAULT '$',
  `phone_number` varchar(255) DEFAULT NULL,
  `fax_number` varchar(255) DEFAULT NULL,
  `site_address` text DEFAULT NULL,
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT 0,
  `search_engine_indexing` tinyint(1) NOT NULL DEFAULT 1,
  `working_days` varchar(255) DEFAULT 'Monday - Friday',
  `working_hours` varchar(255) DEFAULT '9 AM - 5 PM'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `sitename`, `site_title`, `site_url`, `tracking_num`, `email_name`, `email_address`, `site_logo`, `site_favicon`, `invoice_stamp`, `invoice_banner`, `payment_methods_image`, `smtp_host`, `smtp_username`, `smtp_password`, `smtp_port`, `smtp_secure`, `geocode_api_key`, `hero_subtitle`, `hero_title`, `hero_text`, `years_experience`, `achievement_1_num`, `achievement_1_title`, `achievement_2_num`, `achievement_2_title`, `achievement_3_num`, `achievement_3_title`, `achievement_4_num`, `achievement_4_suffix`, `achievement_4_title`, `video_bg_image`, `video_url`, `site_currency`, `phone_number`, `fax_number`, `site_address`, `maintenance_mode`, `search_engine_indexing`, `working_days`, `working_hours`) VALUES
(1, 'Rapid Routes Express', 'Rapid Routes Express', 'https://rapidroutsexpress.com', '0987654321', 'Rapid Routes Express', 'info@rapidroutsexpress.com', 'uploads/1764121226_logo1.png', 'uploads/1764121226_cropped-favicon.png', 'uploads/1764307183_rapid-routes-express-stamp.png', 'uploads/1764301664_banner.jpg', 'uploads/1764301664_securepayment.png', 'rapidroutsexpress.com', 'info@rapidroutsexpress.com', 'RPE.Admin@Maison', 465, 'ssl', 'pk.01682cb67d93596fbb5d646c24723c75', 'Smart Solutions', 'Streamlined transportation for a better tomorrow', 'We have been operating for over a decade, providing top-notch', 10, 250, 'Team member', 300, 'Complete project', 450, '0', 1, 'k', 'Worldwide clients', 'assets/img/resource/video-one__img1.jpg', 'https://www.youtube.com/watch?v=06dV9txztKY', '$', '+8675548830161', '+8675548830161', 'No. 16 Qinglong Road, Qinghua Community, \r\nLonghua Street, Longhua District,Â Shenzhen', 0, 1, 'Monday - Saturday', '8 AM - 6 PM');

-- --------------------------------------------------------

--
-- Table structure for table `shipment_history`
--

CREATE TABLE `shipment_history` (
  `id` int(11) NOT NULL,
  `tracking_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipment_history`
--

INSERT INTO `shipment_history` (`id`, `tracking_id`, `date`, `time`, `location`, `status`, `updated_by`, `remarks`) VALUES
(21, '0987654321118913625', '2025-11-21', '00:44:23', 'Nigeria', 'Pending', 'System', 'Shipment Created'),
(24, '0987654321119852177', '2025-11-21', '17:43:00', 'Kaduna', 'Pending', 'Admin', 'hhhj'),
(25, '0987654321119852177', '2025-11-21', '17:43:35', 'Nigeria', 'Pending', 'System', 'Shipment Created'),
(27, '0987654321110699160', '2025-11-21', '17:42:43', 'Nigeria', 'Pending', 'System', 'Shipment Created'),
(28, '0987654321112020434', '2025-11-21', '17:49:13', 'Kenya', 'Pending', 'System', 'Shipment Created'),
(29, '0987654321116421318', '2025-11-21', '18:51:54', 'Kenya', 'Pending', 'System', 'Shipment Created'),
(32, '', '2025-11-22', '12:32:00', 'Abuja', 'Pending', 'Admin', 'Test'),
(33, '', '2025-11-22', '02:26:00', 'Kaduna', 'Pending', 'Admin', 'Test'),
(57, '12345678901', '2025-11-19', '06:31:00', 'Abuja', 'Delivered', 'Admin', 'Test'),
(58, '12345678901', '2025-11-21', '12:25:00', 'Kaduna', 'Delivered', 'Admin', 'Test'),
(60, 'CL112274035', '2025-11-25', '06:45:54', 'Nigeria', 'Pending', 'System', 'Shipment Created'),
(152, 'CL111708284', '2025-11-24', '05:10:00', 'Ningbo, China', 'Pending', 'Delivery manager', 'Arrives Sea port Terminal( Ningbo)'),
(153, 'CL111708284', '2025-11-27', '14:52:00', 'Ningbo, China', 'In Process', 'Delivery manager', 'Loaded and Sealed (Ningbo port)'),
(154, 'CL111708284', '2025-11-24', '21:51:07', 'CHINA', 'In Process', 'Delivery manager', 'Shipment Created'),
(155, 'CL111708284', '2025-11-30', '16:35:00', 'Ningbo, China', 'In Process', 'Delivery manager', 'Gate-In ( Ningbo Sea Port)'),
(156, 'CL111708284', '2025-12-01', '23:52:00', 'Ningbo, China', 'In Transit', 'Delivery manager', ' Vessel Departure --Ningbo (First Log)'),
(157, 'CL111708284', '2025-12-03', '09:19:00', 'Shanghai, China', 'In Transit', 'Delivery manager', 'Port Call (Minor transshipment/bunkering stop. All onboard checks complete).'),
(158, 'CL111708284', '2025-12-22', '06:20:00', 'Singapore', 'In Process', 'Delivery manager', 'Arrived/Transshipment In Progress'),
(159, 'CL111708284', '2025-12-27', '15:59:00', 'Colombo', 'In Process', 'Delivery manager', 'Port call ( Documentation checks )'),
(160, 'CL111708284', '2025-12-29', '06:32:00', 'Suez Canal, Egypt', 'In Transit', 'Delivery manager', 'Canal transit completed; vessel cleared into mediterranean.'),
(161, 'CL111708284', '2026-01-12', '23:06:00', 'Algeciras, Spain', 'In Process', 'Delivery manager', 'Pilotage/Customs Check{Vessel completed European entry formalities}'),
(162, 'CL111708284', '2026-01-16', '04:18:00', 'Rotterdam, Netherlands', 'In Transit', 'Delivery manager', 'On-carrier Operations'),
(163, 'CL111708284', '2026-01-19', '08:42:00', 'United Kingdom', 'In Transit', 'Delivery manager', 'Vessel within UK terrestrial AIS range'),
(164, 'CL111708284', '2026-01-25', '09:29:00', 'Port of Felixstowe, united kingdom', 'In Process', 'Delivery manager', 'Import masnifest updated. Container moved to import yard for customs processing'),
(165, 'CL111708284', '2026-02-09', '19:54:00', 'Port of Felixstowe, united kingdom', 'On Hold', 'Delivery manager', 'No physical examination required.  Proceed to clear/sort  your required charges Due updated to  consignee email. '),
(298, 'CL080537692', '2026-08-29', '16:41:47', 'HONOLULU HAWAII US state', 'Completed', 'Delivery manager', 'delivery registration completed'),
(299, 'CL080537692', '2026-08-29', '16:48:00', 'HONOLULU HAWAII US state', 'Completed', 'Delivery manager', 'shipment collection & receipt'),
(300, 'CL080537692', '2026-08-29', '17:02:00', 'HONOLULU HAWAII US state', 'Completed', 'Delivery manager', 'weight & cargo verification'),
(301, 'CL080537692', '2026-08-29', '17:18:00', 'HONOLULU HAWAII US state', 'Completed', 'Delivery manager', 'security & special cargo processing'),
(302, 'CL080537692', '2026-08-29', '19:10:00', 'HONOLULU HAWAII US state', 'Completed', 'Delivery manager', 'Export documentation processing'),
(303, 'CL080537692', '2026-08-30', '06:40:00', 'HONOLULU HAWAII US state', 'Completed', 'Delivery manager', 'FREIGHT CONSOLIDATION (cargo secured and assign for international transportation.)'),
(304, 'CL080537692', '2026-08-30', '22:23:00', 'Daniel K. Inouye International Airport HONOLULU HAWAII US state', 'In Transit', 'Delivery manager', 'INTERNATIONAL DEPARTURE ( Shipment released from the Honolulu origin facility and dispatched for international transportation.)'),
(305, 'CL080537692', '2026-08-31', '00:47:00', 'Daniel K. Inouye International Airport HONOLULU HAWAII US state', 'In Transit', 'Delivery manager', 'INTERNATIONAL TRANSIT ( Cargo travelling toward Germany under the assigned freight/airway transport documentation.)'),
(306, 'CL080537692', '2026-08-31', '14:42:00', 'International airport in Los Angeles, California US state ', 'In Transit', 'Delivery manager', 'INTERNATIONAL TRANSIT (One stop/transfer travelling towards Germany.)'),
(307, 'CL080537692', '2026-09-01', '18:14:00', 'Frankfurt International airport Germany ', 'Completed', 'Delivery manager', 'GERMANY ARRIVAL (Shipment arrives at the designated German gateway and is transferred into the destination-country import process.)'),
(308, 'CL080537692', '2026-09-01', '22:09:00', 'Frankfurt International airport Germany ', 'In Process', 'Delivery manager', 'IMPORT DOCUMENTATION REVIEW ( German import documentation, inventory and declared shipment information reviewed.)');

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support_messages`
--

INSERT INTO `support_messages` (`id`, `name`, `email`, `mobile`, `company`, `message`, `created_at`) VALUES
(1, 'Simon', 'king@yopmail.com', '', 'rapidroutsexpress', 'tjhelahejhle', '2025-11-21 22:49:16'),
(2, 'Simon', 'king@yopmail.com', '3075277639', 'rapidroutsexpress', 'thhthtjejeje', '2025-11-21 23:20:05'),
(3, 'Paypal', 'admin@admin.com', '3075277639', 'rapidroutsexpress', 'jghaljghldhdjhalgdjs', '2025-11-22 00:08:39'),
(4, 'Paypal', 'admin@gmail.com', '3075277639', 'rapidroutsexpress', 'jglhrjthle', '2025-11-22 00:11:59'),
(5, 'ddde', 'jekk@fk.com', '40993', 'dsjflk', 'dskfjhlkjfhlsjd', '2025-11-22 00:16:24'),
(6, 'Paypal', 'admin@gmail.com', '3075277639', 'rapidroutsexpress', 'ljksddjfglksfd', '2025-11-22 00:17:54'),
(7, 'Euro', 'admin@gmail.com', '3075277639', 'rapidroutsexpress', 'dskjjkdkds', '2025-11-22 00:24:09'),
(8, 'Simon', 'admin@gmail.com', '3075277639', 'rapidroutsexpress', 'jsdlfahdjkfhajd', '2025-11-22 00:24:58'),
(9, 'Simon', 'jekk@fk.com', '3075277639', 'rapidroutsexpress', 'kldsafja;lk', '2025-11-22 00:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--

CREATE TABLE `team_members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `social_facebook` varchar(255) DEFAULT NULL,
  `social_twitter` varchar(255) DEFAULT NULL,
  `social_linkedin` varchar(255) DEFAULT NULL,
  `social_pinterest` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `team_members`
--

INSERT INTO `team_members` (`id`, `name`, `title`, `image`, `social_facebook`, `social_twitter`, `social_linkedin`, `social_pinterest`, `is_published`, `created_at`) VALUES
(1, 'Ina Adkins', 'Port Director.', 'assets/img/team/team-1-1.png', NULL, NULL, NULL, NULL, 1, '2025-11-25 13:36:12'),
(2, 'Cameron Williamson', 'Operations Head', 'assets/img/team/team-1-2.png', NULL, NULL, NULL, NULL, 1, '2025-11-25 13:36:12'),
(3, 'Ronald Richards', 'Lead Dispatcher', 'assets/img/team/team-1-3.png', NULL, NULL, NULL, NULL, 1, '2025-11-25 13:36:12'),
(4, 'Albert Flores', 'Marketing Coordinator', 'assets/img/team/team-1-4.png', NULL, NULL, NULL, NULL, 1, '2025-11-25 13:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `review_text` text NOT NULL,
  `rating` int(11) DEFAULT 5,
  `is_published` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `title`, `image`, `review_text`, `rating`, `is_published`, `created_at`) VALUES
(1, 'Savannah Nguyen', 'President of Sales', 'assets/img/testimonial/testimonials-one__img1.jpg', 'We\'ve been using this courier service for all our international shipments, and their service is second to none. The real-time tracking is incredibly accurate, and their customer support is always responsive and helpful. They’ve become a vital partner for our business.', 5, 1, '2025-11-25 13:36:12'),
(2, 'Cody Fisher', 'Web Designer', 'assets/img/testimonial/testimonials-one__img2.jpg', 'As a small business, we need a courier service that is both reliable and affordable. They have consistently exceeded our expectations. Their team is professional, and our packages always arrive on time and in perfect condition. Highly recommended!', 5, 1, '2025-11-25 13:36:12'),
(3, 'Marvin McKinney', 'Medical Assistant', 'assets/img/testimonial/testimonials-two__img1.jpg', 'The team here is a pleasure to work with. They are professional, responsive, and always willing to go the extra mile to ensure our shipments are handled with care. Their commitment to customer satisfaction is truly commendable.', 5, 1, '2025-11-25 13:36:12'),
(4, 'Albert Flores', 'Marketing Coordinator', 'assets/img/testimonial/testimonials-two__img2.jpg', 'I\'ve used several courier services in the past, but none have matched the level of service I\'ve received here. Their attention to detail and commitment to ensuring my packages arrive safely and on time is unmatched. I wouldn\'t trust my shipments with anyone else.', 5, 1, '2025-11-25 13:36:12'),
(5, 'John Dale', 'CEO, Tech Solutions', 'uploads/photo-1605980776566-0486c3ac7617.jpeg', 'Incredible service! Our shipments always arrive on time, and the customer support is second to none. They have streamlined our logistics and have become a vital partner in our supply chain. Highly recommended for any business looking for reliability and efficiency.', 5, 1, '2025-11-25 17:30:16'),
(6, 'Jane Satika', 'E-commerce Store Owner', 'uploads/images.jpeg', 'Switching to this courier service was the best decision we made for our business. The real-time tracking is a fantastic feature that our customers love, and we have seen a significant reduction in delivery issues. Their team is always professional and helpful.', 5, 1, '2025-11-25 17:30:16');

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
(104, 'CL048134263', 'Delivered', '2024-04-09', '15:00', ' Delivered to clients', 'Bentley', '$25000', '$1000', '$200', '0', '2024-04-10 08:01:22'),
(105, '1234567890', 'Pending', '2025-02-22', '10:20', 'Landed inJOs ', 'Jos', '20', '10', '2', '32', '2025-11-15 09:20:26');

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
-- Indexes for table `geocache`
--
ALTER TABLE `geocache`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `place` (`place`);

--
-- Indexes for table `legal_pages`
--
ALTER TABLE `legal_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_slug` (`page_slug`);

--
-- Indexes for table `package_items`
--
ALTER TABLE `package_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipment_history`
--
ALTER TABLE `shipment_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_members`
--
ALTER TABLE `team_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `geocache`
--
ALTER TABLE `geocache`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `legal_pages`
--
ALTER TABLE `legal_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `package_items`
--
ALTER TABLE `package_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shipment_history`
--
ALTER TABLE `shipment_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=309;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `team_members`
--
ALTER TABLE `team_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `track_update`
--
ALTER TABLE `track_update`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
