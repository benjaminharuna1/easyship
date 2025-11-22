-- This script alters the geocache table to use appropriate DECIMAL types for lat/lon.
-- It includes checks to prevent errors if the script is run more than once.

-- Change lat column
ALTER TABLE `geocache` MODIFY COLUMN `lat` DECIMAL(10, 8) NOT NULL;

-- Change lon column
ALTER TABLE `geocache` MODIFY COLUMN `lon` DECIMAL(11, 8) NOT NULL;
