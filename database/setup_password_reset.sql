-- Setup script for password reset functionality
-- Run this script in your database to enable password reset features

-- Add customer_code column to users table if it doesn't exist
ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `customer_code` varchar(20) DEFAULT NULL AFTER `id`;

-- Create password_resets table
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` timestamp NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `token` (`token`),
  KEY `expires_at` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add index for customer_code if it was added
ALTER TABLE `users` ADD INDEX IF NOT EXISTS `idx_customer_code` (`customer_code`);

-- Clean up expired tokens (optional - you can run this periodically)
DELETE FROM `password_resets` WHERE `expires_at` < NOW() OR `used` = 1; 