-- This script contains all necessary database schema changes for the new homepage content features.
-- Please execute this entire script in your database manager (e.g., phpMyAdmin).

-- --------------------------------------------------------

--
-- Add `is_featured` column to `services` table
--
ALTER TABLE `services`
ADD `is_featured` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_published`;


-- --------------------------------------------------------

--
-- Add new columns to `setting` table for homepage content
--
ALTER TABLE `setting`
ADD `hero_subtitle` VARCHAR(255) NOT NULL DEFAULT 'Smart Solutions' AFTER `geocode_api_key`,
ADD `hero_title` TEXT NOT NULL DEFAULT 'Streamlined<br> transportation for<br> a better tomorrow' AFTER `hero_subtitle`,
ADD `hero_text` TEXT NOT NULL DEFAULT 'We have been operating for over a decade, providing top-notch' AFTER `hero_title`,
ADD `years_experience` INT(11) NOT NULL DEFAULT '10' AFTER `hero_text`,
ADD `achievement_1_num` INT(11) NOT NULL DEFAULT '250' AFTER `years_experience`,
ADD `achievement_1_title` VARCHAR(255) NOT NULL DEFAULT 'Team member' AFTER `achievement_1_num`,
ADD `achievement_2_num` INT(11) NOT NULL DEFAULT '300' AFTER `achievement_1_title`,
ADD `achievement_2_title` VARCHAR(255) NOT NULL DEFAULT 'Complete project' AFTER `achievement_2_num`,
ADD `achievement_3_num` INT(11) NOT NULL DEFAULT '450' AFTER `achievement_2_title`,
ADD `achievement_3_title` VARCHAR(255) NOT NULL DEFAULT 'Winning award' AFTER `achievement_3_num`,
ADD `achievement_4_num` INT(11) NOT NULL DEFAULT '1' AFTER `achievement_3_title`,
ADD `achievement_4_suffix` VARCHAR(10) NOT NULL DEFAULT 'k' AFTER `achievement_4_num`,
ADD `achievement_4_title` VARCHAR(255) NOT NULL DEFAULT 'Worldwide clients' AFTER `achievement_4_suffix`,
ADD `video_bg_image` VARCHAR(255) NOT NULL DEFAULT 'assets/img/resource/video-one__img1.jpg' AFTER `achievement_4_title`,
ADD `video_url` VARCHAR(255) NOT NULL DEFAULT 'https://www.youtube.com/watch?v=06dV9txztKY' AFTER `video_bg_image`;

-- --------------------------------------------------------
