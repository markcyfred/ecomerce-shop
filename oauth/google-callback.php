<?php
session_start();
require_once 'GoogleOAuth.php';
require_once '../admin/config/dbcon.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    // Initialize Google OAuth
    $googleOAuth = new GoogleOAuth($conn);
    
    // Check if there's an error
    if (isset($_GET['error'])) {
        $_SESSION['message'] = 'Google OAuth error: ' . $_GET['error'];
        $_SESSION['messageType'] = 'error';
        header('Location: ../login.php');
        exit;
    }
    
    // Check if we have the authorization code
    if (!isset($_GET['code'])) {
        $_SESSION['message'] = OAUTH_ERROR_NO_CODE;
        $_SESSION['messageType'] = 'error';
        header('Location: ../login.php');
        exit;
    }
    
    // Validate state parameter
    if (!isset($_GET['state']) || !$googleOAuth->validateState($_GET['state'])) {
        $_SESSION['message'] = OAUTH_ERROR_INVALID_STATE;
        $_SESSION['messageType'] = 'error';
        header('Location: ../login.php');
        exit;
    }
    
    $code = $_GET['code'];
    
    // Exchange code for access token
    $tokenData = $googleOAuth->getAccessToken($code);
    if (!$tokenData) {
        $_SESSION['message'] = OAUTH_ERROR_TOKEN_FAILED;
        $_SESSION['messageType'] = 'error';
        header('Location: ../login.php');
        exit;
    }
    
    $accessToken = $tokenData['access_token'];
    
    // Get user information
    $userInfo = $googleOAuth->getUserInfo($accessToken);
    if (!$userInfo) {
        $_SESSION['message'] = OAUTH_ERROR_USERINFO_FAILED;
        $_SESSION['messageType'] = 'error';
        header('Location: ../login.php');
        exit;
    }
    
    // Check if user exists by OAuth ID
    $existingUser = $googleOAuth->getUserByOAuthId($userInfo['oauth_id']);
    if ($existingUser) {
        // User exists, log them in
        $googleOAuth->loginUser($existingUser);
        $_SESSION['message'] = OAUTH_SUCCESS_LOGIN;
        $_SESSION['messageType'] = 'success';
        if ($existingUser['role_as'] == '1') {
            header('Location: ../admin/index.php');
        } elseif ($existingUser['role_as'] == '2') {
            header('Location: ../supplier/index.php');
        } else {
        header('Location: ../index.php');
        }
        exit;
    }
    
    // Check if email already exists with different provider
    if (!empty($userInfo['email'])) {
        $existingUser = $googleOAuth->userExists($userInfo['email']);
        if ($existingUser) {
            $_SESSION['message'] = 'Email already registered with ' . ucfirst($existingUser['oauth_provider']);
            $_SESSION['messageType'] = 'error';
            header('Location: ../login.php');
            exit;
        }
    }
    
    // Create new user account
    $result = $googleOAuth->createUser($userInfo);
    if ($result['success']) {
        // Get the newly created user
        $newUser = $googleOAuth->getUserByOAuthId($userInfo['oauth_id']);
        if ($newUser) {
            $googleOAuth->loginUser($newUser);
            $_SESSION['message'] = OAUTH_SUCCESS_REGISTRATION;
            $_SESSION['messageType'] = 'success';
            if ($newUser['role_as'] == '1') {
                header('Location: ../admin/index.php');
            } elseif ($newUser['role_as'] == '2') {
                header('Location: ../supplier/index.php');
            } else {
            header('Location: ../index.php');
            }
            exit;
        }
    }
    
    // If we get here, something went wrong
    $_SESSION['message'] = OAUTH_ERROR_REGISTRATION_FAILED;
    $_SESSION['messageType'] = 'error';
    header('Location: ../login.php');
    exit;
    
} catch (Exception $e) {
    // Log the error
    error_log('Google OAuth Error: ' . $e->getMessage());
    
    $_SESSION['message'] = 'An error occurred during Google authentication. Please try again.';
    $_SESSION['messageType'] = 'error';
    header('Location: ../login.php');
    exit();
}
?> 