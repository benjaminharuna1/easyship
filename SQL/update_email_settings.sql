ALTER TABLE `setting`
ADD `smtp_host` VARCHAR(255) NOT NULL,
ADD `smtp_username` VARCHAR(255) NOT NULL,
ADD `smtp_password` VARCHAR(255) NOT NULL,
ADD `smtp_port` INT NOT NULL,
ADD `smtp_secure` VARCHAR(255) NOT NULL,
ADD `email_on_creation` INT NOT NULL,
ADD `email_on_update` INT NOT NULL;
