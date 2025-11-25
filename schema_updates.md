-- This script contains all necessary database schema changes for the new features.
-- Please execute this entire script in your database manager (e.g., phpMyAdmin).

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--
CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `review_text` text NOT NULL,
  `rating` int(1) NOT NULL DEFAULT 5,
  `image` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `testimonials`
--
INSERT INTO `testimonials` (`name`, `title`, `review_text`, `rating`, `image`, `is_published`) VALUES
('John Doe', 'CEO, Tech Solutions', 'Incredible service! Our shipments always arrive on time, and the customer support is second to none. They have streamlined our logistics and have become a vital partner in our supply chain. Highly recommended for any business looking for reliability and efficiency.', 5, 'uploads/171155196327.png', 1),
('Jane Smith', 'E-commerce Store Owner', 'Switching to this courier service was the best decision we made for our business. The real-time tracking is a fantastic feature that our customers love, and we have seen a significant reduction in delivery issues. Their team is always professional and helpful.', 5, 'uploads/author-2.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `team_members`
--
CREATE TABLE `team_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `social_facebook` varchar(255) DEFAULT NULL,
  `social_twitter` varchar(255) DEFAULT NULL,
  `social_linkedin` varchar(255) DEFAULT NULL,
  `social_pinterest` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_members`
--
INSERT INTO `team_members` (`name`, `title`, `image`, `social_facebook`, `social_twitter`, `social_linkedin`, `social_pinterest`, `is_published`) VALUES
('Cameron Williamson', 'Logistics Manager', 'assets/img/team/team-1-1.png', '#', '#', '#', '', 1),
('Esther Howard', 'Operations Head', 'assets/img/team/team-1-2.png', '#', '#', '#', '', 1),
('Ronald Richards', 'Lead Dispatcher', 'assets/img/team/team-1-3.png', '#', '#', '#', '', 1),
('Albert Flores', 'Marketing Coordinator', 'assets/img/team/team-1-4.png', '#', '#', '#', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `icon_class` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--
INSERT INTO `services` (`title`, `description`, `icon_class`, `image`, `is_published`) VALUES
('Air Freight', 'Our air freight services provide fast and reliable delivery for your time-sensitive shipments. We offer a range of options to meet your specific needs, including door-to-door and airport-to-airport services.', 'icon-air-freight', 'assets/img/service/services-one__img1.jpg', 1),
('Ocean Freight', 'For larger shipments with flexible delivery schedules, our ocean freight services are a cost-effective solution. We provide full container load (FCL) and less-than-container load (LCL) options to destinations worldwide.', 'icon-boat', 'assets/img/service/services-one__img2.jpg', 1),
('Road Freight', 'Our comprehensive road freight services ensure your goods are transported safely and efficiently. We offer a modern fleet of vehicles and a network of partners to provide reliable ground transportation.', 'icon-delivery-truck-1', 'assets/img/service/services-one__img3.jpg', 1),
('Warehousing', 'We provide secure and flexible warehousing solutions to meet your storage needs. Our facilities are equipped with modern technology to ensure the safety and proper management of your inventory.', 'icon-warehouse-1', 'assets/img/service/services-one__img4.jpg', 1),
('Project Cargo', 'Our project cargo services are designed to handle oversized, heavy, or complex shipments. We provide customized solutions and expert handling to ensure your specialized cargo reaches its destination safely.', 'icon-container-1', 'assets/img/service/services-one__img5.jpg', 1),
('Customs Clearance', 'Navigating customs regulations can be complex. Our experienced team handles all aspects of customs clearance to ensure your shipments cross borders smoothly and without delay, ensuring compliance and efficiency.', 'icon-certificate', 'assets/img/service/services-one__img6.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `legal_pages`
--
CREATE TABLE `legal_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_slug` varchar(100) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` longtext NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_slug` (`page_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `legal_pages`
--
INSERT INTO `legal_pages` (`page_slug`, `page_title`, `page_content`) VALUES
('terms-and-conditions', 'Terms & Conditions', '<p>This is the placeholder content for the Terms and Conditions page. Please update this from the admin panel.</p>'),
('privacy-policy', 'Privacy Policy', '<p>This is the placeholder content for the Privacy Policy page. Please update this from the admin panel.</p>');

-- --------------------------------------------------------

--
-- Modifying `setting` table
--
ALTER TABLE `setting`
ADD `site_currency` VARCHAR(10) NOT NULL DEFAULT '$' AFTER `site_address`,
ADD `phone_number` VARCHAR(50) DEFAULT NULL AFTER `site_currency`,
ADD `fax_number` VARCHAR(50) DEFAULT NULL AFTER `phone_number`,
ADD `geocode_api_key` VARCHAR(255) DEFAULT NULL AFTER `fax_number`;
