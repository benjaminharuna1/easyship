ALTER TABLE `addtracking`
ADD COLUMN `total_cost` DECIMAL(10, 2) NOT NULL DEFAULT 0.00 AFTER `payment_mode`;
