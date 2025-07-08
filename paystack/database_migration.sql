-- Database Migration for Paystack Integration
-- Add missing fields to support Paystack payment processing

-- Add token field to checkout table if it doesn't exist
ALTER TABLE `checkout` 
ADD COLUMN IF NOT EXISTS `token` VARCHAR(255) UNIQUE AFTER `id`,
ADD COLUMN IF NOT EXISTS `checkout_token` VARCHAR(255) AFTER `token`;

-- Add checkout_token field to cart table if it doesn't exist
ALTER TABLE `cart` 
ADD COLUMN IF NOT EXISTS `checkout_token` VARCHAR(255) AFTER `cart_status`;

-- Add payment_method column to paystack_transactions table if it doesn't exist
ALTER TABLE `paystack_transactions` 
ADD COLUMN IF NOT EXISTS `payment_method` VARCHAR(50) AFTER `status`;

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS `idx_checkout_token` ON `checkout` (`token`);
CREATE INDEX IF NOT EXISTS `idx_cart_checkout_token` ON `cart` (`checkout_token`);
CREATE INDEX IF NOT EXISTS `idx_payment_method` ON `paystack_transactions` (`payment_method`);

-- Update existing records to have tokens (if any exist)
-- This is a sample update - you may need to adjust based on your data
-- UPDATE checkout SET token = CONCAT('ord_', id, '_', UNIX_TIMESTAMP()) WHERE token IS NULL; 