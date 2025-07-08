# Paystack Payment Integration

This directory contains the Paystack payment gateway integration for the e-commerce shop.

## Files Overview

### Core Files
- `config.php` - Configuration file with API keys and settings
- `PaystackHelper.php` - Main helper class for Paystack API interactions
- `initialize.php` - Handles payment initialization and redirects to Paystack
- `callback.php` - Processes Paystack webhook callbacks
- `success.php` - Success page displayed after successful payment
- `failure.php` - Failure page displayed when payment fails
- `database_migration.sql` - SQL script to add required database fields

## Setup Instructions

### 1. Database Setup
Run the database migration to add required fields:

```sql
-- Execute the contents of database_migration.sql
-- This adds token and checkout_token fields to the checkout and cart tables
```

### 2. Configuration
Update `config.php` with your Paystack API keys:

```php
// Replace with your actual Paystack API keys
define('PAYSTACK_SECRET_KEY', 'sk_test_your_secret_key_here');
define('PAYSTACK_PUBLIC_KEY', 'pk_test_your_public_key_here');
```

### 3. Update URLs
Update the callback URLs in `config.php` to match your domain:

```php
define('PAYSTACK_CALLBACK_URL', 'https://yourdomain.com/ecomerce-shop/paystack/callback.php');
define('PAYSTACK_SUCCESS_URL', 'https://yourdomain.com/ecomerce-shop/paystack/success.php');
define('PAYSTACK_FAILURE_URL', 'https://yourdomain.com/ecomerce-shop/paystack/failure.php');
```

### 4. File Permissions
Ensure the logs directory is writable:

```bash
chmod 755 paystack/logs
```

## How It Works

### Payment Flow
1. **Order Creation**: When a user completes checkout, an order is created with a unique token
2. **Payment Initialization**: User clicks "Pay with Paystack" → `initialize.php` creates a Paystack transaction
3. **Payment Processing**: User is redirected to Paystack's payment page
4. **Callback Processing**: After payment, Paystack calls `callback.php` to verify the transaction
5. **Order Update**: Order status is updated based on payment result
6. **User Redirect**: User is redirected to success or failure page

### Key Features
- **Secure**: All transactions are verified server-side
- **Logging**: Complete transaction logging for debugging
- **Error Handling**: Comprehensive error handling and user feedback
- **Database Integration**: Stores transaction details in database
- **User-Friendly**: Clear success/failure pages with next steps

## API Integration

### PaystackHelper Class Methods

#### `initializeTransaction($orderData)`
Initializes a new Paystack transaction.

**Parameters:**
- `$orderData` (array): Order information including amount, email, reference, etc.

**Returns:**
- Success: `['status' => true, 'authorization_url' => 'url']`
- Failure: `['status' => false, 'message' => 'error_message']`

#### `verifyTransaction($reference)`
Verifies a Paystack transaction.

**Parameters:**
- `$reference` (string): Paystack transaction reference

**Returns:**
- Success: `['status' => true, 'is_successful' => true/false, 'data' => transaction_data]`
- Failure: `['status' => false, 'message' => 'error_message']`

## Database Tables

### paystack_transactions
Stores all Paystack transaction details:

```sql
CREATE TABLE paystack_transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reference VARCHAR(255) UNIQUE NOT NULL,
    order_id INT NOT NULL,
    user_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'NGN',
    status VARCHAR(50) NOT NULL,
    gateway_response TEXT,
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### checkout table updates
- Added `token` field for unique order identification
- Added `checkout_token` field for linking cart items

### cart table updates
- Added `checkout_token` field for linking cart items to orders

## Testing

### Test Cards (Paystack Test Mode)
- **Visa**: 4084 0840 8408 4081
- **Mastercard**: 5105 1051 0510 5100
- **Verve**: 5061 4603 6000 0000

### Test PIN/OTP
- **PIN**: 1234
- **OTP**: 123456

## Security Considerations

1. **API Keys**: Never commit API keys to version control
2. **HTTPS**: Always use HTTPS in production
3. **Verification**: Always verify transactions server-side
4. **Logging**: Monitor transaction logs for suspicious activity
5. **Error Handling**: Don't expose sensitive information in error messages

## Troubleshooting

### Common Issues

1. **"Invalid reference" error**
   - Check that the reference is being generated correctly
   - Ensure the reference is unique

2. **"Transaction not found" error**
   - Verify the transaction was created in the database
   - Check Paystack dashboard for transaction status

3. **Callback not working**
   - Ensure callback URL is accessible
   - Check server logs for errors
   - Verify Paystack webhook configuration

4. **Payment not updating order status**
   - Check database connection
   - Verify transaction verification is working
   - Check order status update queries

### Debug Mode
Enable debug logging in `config.php`:

```php
define('PAYSTACK_LOG_ENABLED', true);
```

Check logs at `paystack/logs/paystack.log`

## Support

For issues with:
- **Paystack Integration**: Check this README and logs
- **Paystack API**: Contact Paystack support
- **Database Issues**: Check migration script and table structure

## Production Checklist

- [ ] Update API keys to production keys
- [ ] Update callback URLs to production domain
- [ ] Enable HTTPS
- [ ] Test payment flow end-to-end
- [ ] Monitor transaction logs
- [ ] Set up error monitoring
- [ ] Configure webhook security (if applicable) 