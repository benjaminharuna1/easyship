ALTER TABLE `addtracking`
CHANGE COLUMN `dispach_date` `dispatch_date` DATE NOT NULL,
DROP COLUMN `pickup_date`,
DROP COLUMN `pickup_time`,
DROP COLUMN `departure_time`;
