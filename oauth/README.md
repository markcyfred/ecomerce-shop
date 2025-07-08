# Dual-Provider OAuth Implementation

This directory contains a streamlined OAuth implementation supporting two popular providers:
- Google
- GitHub

## Features

- **Unified OAuth System**: Both providers use the same base class and follow consistent patterns
- **Security**: State parameter validation, CSRF protection
- **User Management**: Automatic account creation and login
- **Email Conflict Resolution**: Prevents duplicate accounts with different providers
- **Responsive UI**: Beautiful, mobile-friendly OAuth buttons

## Setup Instructions

### 1. Database Setup

Run the database update script to add OAuth fields:

```sql
-- Add OAuth fields to users table
ALTER TABLE users 
ADD COLUMN oauth_provider VARCHAR(50) NULL AFTER password,
ADD COLUMN oauth_id VARCHAR(255) NULL AFTER oauth_provider;

-- Add index for OAuth lookups
CREATE INDEX idx_oauth_provider_id ON users(oauth_provider, oauth_id);
CREATE INDEX idx_email_oauth ON users(email, oauth_provider);

-- Update existing users to have NULL oauth_provider (regular registration)
UPDATE users SET oauth_provider = NULL WHERE oauth_provider IS NULL;
```

### 2. Provider Configuration

Update `oauth/config.php` with your OAuth credentials:

#### Google OAuth
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing one
3. Enable Google+ API
4. Go to Credentials → Create Credentials → OAuth 2.0 Client ID
5. Set authorized redirect URI: `http://yourdomain.com/oauth/google-callback.php`
6. Copy Client ID and Client Secret to config

#### GitHub OAuth
1. Go to [GitHub Developer Settings](https://github.com/settings/developers)
2. Click "New OAuth App"
3. Set Homepage URL: `http://yourdomain.com`
4. Set Authorization callback URL: `http://yourdomain.com/oauth/github-callback.php`
5. Copy Client ID and Client Secret to config

### 3. Configuration File

Update `oauth/config.php` with your credentials:

```php
// Replace placeholder values with your actual credentials
define('GITHUB_CLIENT_SECRET', 'your_github_client_secret');
```

**Note**: Google credentials are already configured in your setup.

### 4. File Structure

```
oauth/
├── BaseOAuth.php              # Base class for all OAuth providers
├── config.php                 # Configuration file
├── GoogleOAuth.php           # Google OAuth implementation
├── GitHubOAuth.php           # GitHub OAuth implementation
├── OAuthFactory.php          # Factory class for OAuth instances
├── google-login.php          # Google login redirect
├── github-login.php          # GitHub login redirect
├── google-callback.php       # Google OAuth callback
├── github-callback.php       # GitHub OAuth callback
├── database_update.sql       # Database schema updates
└── README.md                 # This file
```

## Usage

### Frontend Integration

The OAuth buttons are already integrated into the login page (`login.php`). Users can click any provider button to authenticate.

### Backend Integration

The system automatically:
1. Redirects users to the OAuth provider
2. Handles the callback and token exchange
3. Creates new accounts or logs in existing users
4. Manages session data
5. Redirects to the appropriate page

### Custom Integration

To add OAuth to other pages:

```php
require_once 'oauth/GoogleOAuth.php';
require_once 'admin/config/dbcon.php';

$googleOAuth = new GoogleOAuth($conn);
$authUrl = $googleOAuth->getAuthUrl();

// Redirect user to OAuth provider
header('Location: ' . $authUrl);
exit;
```

## Security Features

- **State Parameter**: Prevents CSRF attacks
- **Email Validation**: Prevents duplicate accounts across providers
- **Secure Token Storage**: Tokens are not stored in database
- **Input Sanitization**: All user inputs are properly escaped
- **Session Management**: Secure session handling

## Error Handling

The system handles various error scenarios:
- Invalid OAuth state
- Missing authorization code
- Token exchange failures
- User info retrieval failures
- Email conflicts between providers
- Account creation failures

## Customization

### Adding New Providers

1. Create a new class extending `BaseOAuth`
2. Implement the required abstract methods
3. Add configuration constants
4. Create login and callback files
5. Update the UI to include the new provider

### Styling

OAuth button styles can be customized in `login.php`. Each provider has its own CSS class:
- `.google-btn`
- `.github-btn`

## Troubleshooting

### Common Issues

1. **Redirect URI Mismatch**: Ensure callback URLs match exactly in provider settings
2. **Missing Permissions**: Check that required scopes are configured
3. **Database Errors**: Verify database schema is updated
4. **SSL Issues**: Some providers require HTTPS in production

### Debug Mode

Enable error reporting in callback files for debugging:

```php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

## Production Considerations

1. **HTTPS**: Use HTTPS in production for all OAuth flows
2. **Environment Variables**: Store sensitive credentials in environment variables
3. **Rate Limiting**: Implement rate limiting for OAuth endpoints
4. **Logging**: Add proper logging for OAuth events
5. **Error Monitoring**: Set up error monitoring for OAuth failures

## Support

For issues or questions:
1. Check the error logs
2. Verify provider configuration
3. Test with a single provider first
4. Ensure all files are properly included

## License

This OAuth implementation is part of the ecommerce shop project. 