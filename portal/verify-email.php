<?php
session_start();
include('../admin/config/dbcon.php');

// Check if token is provided
if (!isset($_GET['token']) || empty($_GET['token'])) {
    $_SESSION['message'] = 'Invalid verification link. Please try again.';
    $_SESSION['messageType'] = 'error';
    header('Location: login.php');
    exit();
}

$token = mysqli_real_escape_string($con, $_GET['token']);

// Check if token exists and is valid
$verify_query = "SELECT * FROM users WHERE verify_token='$token' LIMIT 1";
$verify_query_run = mysqli_query($con, $verify_query);

if (mysqli_num_rows($verify_query_run) > 0) {
    $row = mysqli_fetch_array($verify_query_run);
    
   // Check if already verified
if ($row['verify_status'] == 1) {
    $_SESSION['message'] = 'Your email is already verified.';
    $_SESSION['messageType'] = 'info'; // <-- Changed from success to info
    header('Location: login.php');
    exit();
}

    // Update verification status
    $update_query = "UPDATE users SET verify_status='1' WHERE verify_token='$token' LIMIT 1";
    $update_query_run = mysqli_query($con, $update_query);
    
    if ($update_query_run) {
        $_SESSION['message'] = 'Email verification successful!';
        $_SESSION['messageType'] = 'success';
        header('Location: login.php');
        exit();
    } else {
        $_SESSION['message'] = 'Verification failed. Please try again or contact support.';
        $_SESSION['messageType'] = 'error';
        header('Location: login.php');
        exit();
    }
} else {
    $_SESSION['message'] = 'Invalid or expired verification token.';
    $_SESSION['messageType'] = 'error';
    header('Location: login.php');
    exit();
}
?>
