-- Add maintenance_mode and search_engine_indexing to the setting table

ALTER TABLE `setting`
ADD COLUMN `maintenance_mode` BOOLEAN NOT NULL DEFAULT FALSE,
ADD COLUMN `search_engine_indexing` BOOLEAN NOT NULL DEFAULT TRUE;
