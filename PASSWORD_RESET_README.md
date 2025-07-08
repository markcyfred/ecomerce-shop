# Password Reset System

This document explains how to set up and use the password reset functionality for your e-commerce shop.

## Features

- **Secure Token Generation**: Uses cryptographically secure random tokens
- **Email Verification**: Sends reset links via email using SMTP
- **Token Expiration**: Tokens expire after 1 hour for security
- **One-time Use**: Each token can only be used once
- **Responsive Design**: Works on desktop and mobile devices
- **Form Validation**: Client-side and server-side validation
- **Security**: Doesn't reveal if email exists or not
- **SMTP Email**: Uses PHPMailer with GoPrimeHost SMTP

## Files Created/Modified

### New Files:
1. `reset.php` - Password reset request form
2. `reset_password.php` - New password entry form
3. `functions/reset_password.php` - Backend processing with SMTP email
4. `database/setup_password_reset.sql` - Database setup script
5. `database/password_reset_table.sql` - Password reset table structure

### Modified Files:
1. `oauth/config.php` - Removed GitHub OAuth, kept only Google
2. `composer.json` - Added PHPMailer dependency

## Setup Instructions

### 1. Database Setup

Run the database setup script to create the required tables:

```sql
-- Execute this in your MySQL database
SOURCE database/setup_password_reset.sql;
```

Or manually run these commands:

```sql
-- Add customer_code column to users table
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
```

### 2. Install Dependencies

Install PHPMailer using Composer:

```bash
composer update
```

### 3. Email Configuration

The system is configured to use GoPrimeHost SMTP with these settings:

```php
$mail->Host       = 'mail.goprimehost.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'support@goprimehost.com';
$mail->Password   = 'Markkinai@2023';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;
```

### 4. Update Reset Link URL

In `functions/reset_password.php`, update the reset link URL for production:

```php
$reset_link = "http://yourdomain.com/reset_password.php?token=" . $token;
```

## How It Works

### 1. User Requests Password Reset
- User visits `/reset.php`
- Enters their email address
- System validates email format
- If email exists, generates secure token
- Sends reset link via SMTP email

### 2. User Clicks Reset Link
- User clicks link in email
- System validates token
- If valid, shows password reset form
- If invalid/expired, shows error message

### 3. User Sets New Password
- User enters new password
- System validates password requirements
- Updates user password in database
- Marks token as used
- Redirects to login page

## Security Features

1. **Secure Tokens**: Uses `random_bytes(32)` for token generation
2. **Token Expiration**: Tokens expire after 1 hour
3. **One-time Use**: Tokens are marked as used after password reset
4. **Email Privacy**: Doesn't reveal if email exists in database
5. **Password Hashing**: Uses PHP's `password_hash()` function
6. **SQL Injection Protection**: Uses `mysqli_real_escape_string()`
7. **XSS Protection**: Uses `htmlspecialchars()` for output
8. **SMTP Authentication**: Secure email delivery

## User Flow

```
User forgets password
        ↓
   Visit /reset.php
        ↓
   Enter email address
        ↓
   System sends reset email via SMTP
        ↓
   User clicks email link
        ↓
   Visit /reset_password.php?token=xxx
        ↓
   Enter new password
        ↓
   Password updated
        ↓
   Redirect to /login.php
```

## Customization

### Styling
The pages use custom CSS that matches your existing design. You can modify the styles in:
- `reset.php` (lines with `<style>` tag)
- `reset_password.php` (lines with `<style>` tag)

### Email Template
The email template is in `functions/reset_password.php`. You can customize:
- Email subject
- Email content
- Email styling
- Company branding

### SMTP Settings
To change SMTP settings, edit `functions/reset_password.php`:

```php
$mail->Host       = 'your-smtp-server.com';
$mail->Username   = 'your-email@domain.com';
$mail->Password   = 'your-password';
$mail->Port       = 587; // or 465 for SSL
```

### Password Requirements
Current requirements:
- Minimum 6 characters
- Passwords must match

You can modify these in `functions/reset_password.php`:

```php
if (strlen($password) < 6) {
    // Change minimum length here
}
```

## Testing

1. **Test with valid email**: Use an email that exists in your database
2. **Test with invalid email**: Use an email that doesn't exist
3. **Test token expiration**: Wait 1 hour after requesting reset
4. **Test used tokens**: Try using the same token twice
5. **Test invalid tokens**: Use a random token string
6. **Test SMTP connection**: Verify emails are being sent

## Troubleshooting

### Email Not Sending
- Check SMTP credentials in `functions/reset_password.php`
- Verify GoPrimeHost SMTP settings
- Check spam folder
- Test SMTP connection manually
- Check error logs for SMTP errors

### Database Errors
- Ensure password_resets table exists
- Check database connection
- Verify user table has customer_code column

### Token Issues
- Check token expiration time
- Verify token is not already used
- Check database for token existence

### PHPMailer Issues
- Ensure PHPMailer is installed: `composer install`
- Check autoload.php path
- Verify SMTP credentials
- Test with different SMTP settings

## Maintenance

### Clean Up Expired Tokens
Run this periodically to clean up old tokens:

```sql
DELETE FROM password_resets WHERE expires_at < NOW() OR used = 1;
```

### Monitor Token Usage
Check for unusual activity:

```sql
SELECT email, COUNT(*) as token_count 
FROM password_resets 
WHERE created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)
GROUP BY email 
HAVING token_count > 5;
```

### Monitor Email Delivery
Check email delivery rates and SMTP logs for any issues.

## Support

If you encounter issues:
1. Check error logs
2. Verify database setup
3. Test SMTP functionality
4. Check file permissions
5. Verify URL configurations
6. Test PHPMailer installation

## Security Notes

- Keep your SMTP credentials secure
- Use HTTPS in production
- Regularly update PHP and dependencies
- Monitor for suspicious activity
- Consider rate limiting for reset requests
- Log password reset attempts for security monitoring
- Use strong SMTP passwords
- Consider using environment variables for sensitive data 