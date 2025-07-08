<?php
/**
 * Paystack Configuration
 * 
 * This file contains the configuration for Paystack payment integration.
 * Replace the placeholder values with your actual Paystack API keys.
 */

// Paystack API Configuration
define('PAYSTACK_SECRET_KEY', 'sk_live_05b8d15ae974659f8a0d7cbddb1ebde45b5c1d00'); // Live secret key
define('PAYSTACK_PUBLIC_KEY', 'pk_live_5996f9883468740d4d758f12031ad491e3bc3aed'); // Live public key

// Paystack API URLs
define('PAYSTACK_BASE_URL', 'https://api.paystack.co');
define('PAYSTACK_INITIALIZE_URL', PAYSTACK_BASE_URL . '/transaction/initialize');
define('PAYSTACK_VERIFY_URL', PAYSTACK_BASE_URL . '/transaction/verify/');

// Currency and country settings
define('PAYSTACK_CURRENCY', 'KES'); // Kenyan Shillings
define('PAYSTACK_COUNTRY', 'KE'); // Kenya

// Callback URLs
define('PAYSTACK_CALLBACK_URL', 'http://localhost/ecomerce-shop/paystack/callback.php');
define('PAYSTACK_SUCCESS_URL', 'http://localhost/ecomerce-shop/paystack/success.php');
define('PAYSTACK_FAILURE_URL', 'http://localhost/ecomerce-shop/paystack/failure.php');

// Database table for storing payment transactions
define('PAYSTACK_TRANSACTIONS_TABLE', 'paystack_transactions');

// Logging
define('PAYSTACK_LOG_ENABLED', true);
define('PAYSTACK_LOG_FILE', __DIR__ . '/logs/paystack.log');

// Create logs directory if it doesn't exist
if (!file_exists(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}
?> 