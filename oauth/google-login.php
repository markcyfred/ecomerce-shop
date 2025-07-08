<?php
session_start();
require_once 'GoogleOAuth.php';

// Initialize Google OAuth
$googleOAuth = new GoogleOAuth($conn);

// Get the authorization URL and redirect to Google
$authUrl = $googleOAuth->getAuthUrl();
header('Location: ' . $authUrl);
exit();
?> 