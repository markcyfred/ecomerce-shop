<?php
// OAuth Configuration for Google Provider
// You need to get these credentials from Google Developer Console

// ===== GOOGLE OAUTH =====
define('GOOGLE_CLIENT_ID', '');
define('GOOGLE_CLIENT_SECRET', '');

define('GOOGLE_REDIRECT_URI', 'http://localhost/ecomerce-shop/oauth/google-callback.php');
define('GOOGLE_SCOPES', 'email profile');
define('GOOGLE_AUTH_URL', 'https://accounts.google.com/o/oauth2/v2/auth');
define('GOOGLE_TOKEN_URL', 'https://oauth2.googleapis.com/token');
define('GOOGLE_USERINFO_URL', 'https://www.googleapis.com/oauth2/v2/userinfo');

// Database table for OAuth users
define('OAUTH_USERS_TABLE', 'oauth_users');

// Session keys
define('OAUTH_STATE_KEY', 'oauth_state');
define('OAUTH_ACCESS_TOKEN_KEY', 'oauth_access_token');
define('OAUTH_PROVIDER_KEY', 'oauth_provider');

// Error messages
define('OAUTH_ERROR_INVALID_STATE', 'Invalid OAuth state parameter');
define('OAUTH_ERROR_NO_CODE', 'No authorization code received');
define('OAUTH_ERROR_TOKEN_FAILED', 'Failed to get access token');
define('OAUTH_ERROR_USERINFO_FAILED', 'Failed to get user information');
define('OAUTH_ERROR_EMAIL_EXISTS', 'Email already registered with different method');
define('OAUTH_ERROR_REGISTRATION_FAILED', 'Failed to create account');
define('OAUTH_ERROR_PROVIDER_NOT_SUPPORTED', 'OAuth provider not supported');

// Success messages
define('OAUTH_SUCCESS_REGISTRATION', 'Account created successfully!');
define('OAUTH_SUCCESS_LOGIN', 'Welcome back! You are now logged in.');

// Provider names for display (only Google)
define('OAUTH_PROVIDERS', [
    'google' => 'Google'
]);

// Provider colors for UI (only Google)
define('OAUTH_PROVIDER_COLORS', [
    'google' => '#4285F4'
]);

// Provider icons (only Google)
define('OAUTH_PROVIDER_ICONS', [
    'google' => 'fab fa-google'
]);
?> 