CREATE TABLE `package_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tracking_id` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `piece_type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `length` decimal(10,2) NOT NULL,
  `width` decimal(10,2) NOT NULL,
  `height` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `addtracking`
ADD `remarks` text DEFAULT NULL,
ADD `total_freight` decimal(10,2) DEFAULT NULL,
ADD `courier` varchar(255) DEFAULT NULL,
ADD `origin` varchar(255) DEFAULT NULL,
ADD `departure_time` time DEFAULT NULL,
ADD `pickup_date` date DEFAULT NULL,
ADD `pickup_time` time DEFAULT NULL,
ADD `comments` text DEFAULT NULL,
ADD `datetimepicker` datetime DEFAULT NULL,
ADD `type_of_shipment` varchar(255) DEFAULT NULL,
ADD `total_volumetric_weight` decimal(10,2) DEFAULT NULL,
ADD `total_actual_weight` decimal(10,2) DEFAULT NULL,
ADD `published` tinyint(1) NOT NULL DEFAULT 0;

CREATE TABLE `shipment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tracking_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `remarks` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
