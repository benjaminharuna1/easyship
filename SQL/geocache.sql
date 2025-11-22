--
-- Table structure for table `geocache`
--

CREATE TABLE `geocache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place` varchar(255) NOT NULL,
  `lat` decimal(10,8) NOT NULL,
  `lon` decimal(11,8) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `place` (`place`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
