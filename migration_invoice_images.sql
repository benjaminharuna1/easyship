-- Add new columns to the setting table for invoice images
ALTER TABLE `setting`
ADD COLUMN `invoice_stamp` VARCHAR(255) DEFAULT NULL AFTER `site_favicon`,
ADD COLUMN `invoice_banner` VARCHAR(255) DEFAULT NULL AFTER `invoice_stamp`,
ADD COLUMN `payment_methods_image` VARCHAR(255) DEFAULT NULL AFTER `invoice_banner`;
