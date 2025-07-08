<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../admin/config/dbcon.php';

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// At the top, before session_start()
if (isset($_POST['timezone'])) {
    date_default_timezone_set($_POST['timezone']);
} else {
    date_default_timezone_set('Africa/Nairobi');
}

// Function to generate secure random token
function generateResetToken() {
    return bin2hex(random_bytes(32));
}

// Function to send password reset email using PHPMailer
function sendPasswordResetEmail($email, $token, $user_name) {
    $reset_link = "http://localhost/ecomerce-shop/reset_password.php?token=" . $token;
    $first_name = explode(' ', trim($user_name))[0];
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'mail.goprimehost.com'; // GoPrimeHost SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'support@goprimehost.com';
        $mail->Password   = 'Markkinai@2023';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        // Recipients
        $mail->setFrom('support@goprimehost.com', 'Your E-commerce Shop');
        $mail->addAddress($email, $user_name);
        $mail->addReplyTo('support@goprimehost.com', 'Support Team');
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request - Your E-commerce Shop';
        $message = "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Password Reset Request</title>
</head>
<body style='font-family: Arial, sans-serif; background-color: white; margin: 0; padding: 0;'>
    <table role='presentation' width='100%' cellspacing='0' cellpadding='0' border='0' 
        style='background-color: #ffffff; max-width: 600px; margin: 40px auto; padding: 20px; 
                border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: center;
                border: 2px solid #ddd;'>
        <tr>
            <td>
                <img src='https://goprimehost.com/assets/img/hero/logo.png' alt='GoprimeHost Logo' width='100px' 
                    style='height: auto; margin-bottom: 20px;'>
                <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                <h2 style='color: #333; margin: 10px 0;'>Password Reset Request</h2>
                <p style='color: #666; font-size: 16px;'>Dear <strong>" . htmlspecialchars($first_name) . "</strong>,</p>
                <p style='color: #666; font-size: 14px;'>We received a request to reset your password for your account. If you didn't make this request, you can safely ignore this email.</p>
                <p>
                    <a href='" . $reset_link . "' 
                    style='background-color: #007bff; color: #ffffff; padding: 12px 24px; font-size: 16px; 
                            font-weight: bold; border-radius: 5px; text-decoration: none; display: inline-block;'>
                        Reset Password
                    </a>
                </p>
                <p style='color: #666; font-size: 14px;'>If you did not request a password reset, you can ignore this email.</p>
                <p style='color: #999; font-size: 12px;'>You can also reset your password by copying and pasting the following link into your browser:</p>
                <p style='background-color: #f8f9fa; padding: 10px; border-radius: 5px; word-break: break-word; font-size: 12px;'>
                    <a href='" . $reset_link . "' style='color: #007bff; text-decoration: none;'>
                        " . $reset_link . "
                    </a>
                </p>
                <div style='color: #d32f2f; font-size: 13px; margin: 10px 0;'>
                    <b>Important:</b> This link will expire in 5 minutes for security reasons.
                </div>
                <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                <p style='color: #999; font-size: 12px;'>For security reasons, please do not share this password reset link.</p>
                <p style='color: #999; font-size: 12px;'>GoprimeHost Team</p>
            </td>
        </tr>
    </table>
</body>
</html>";
        $mail->Body = $message;
        $mail->AltBody = strip_tags(str_replace(['<br>', '</p>'], ["\n", "\n\n"], $message));
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Password reset email failed: " . $mail->ErrorInfo);
        return false;
    }
}

// Handle password reset request
if (isset($_POST['reset_request'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Validate email
    if (empty($email)) {
        $_SESSION['message'] = "Please enter your email address.";
        $_SESSION['messageType'] = "error";
        header('location: ../reset.php');
        exit();
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Please enter a valid email address.";
        $_SESSION['messageType'] = "error";
        header('location: ../reset.php');
        exit();
    }
    
    // Check if user exists
    $check_user_query = "SELECT id, first_name, last_name, email FROM users WHERE email = '$email' AND user_status = 'active'";
    $check_user_result = mysqli_query($conn, $check_user_query);
    
    if (mysqli_num_rows($check_user_result) == 0) {
        // Don't reveal if email exists or not for security
        $_SESSION['message'] = "If an account with that email exists, we've sent a password reset link.";
        $_SESSION['messageType'] = "success";
        header('location: ../reset.php');
        exit();
    }
    
    $user_data = mysqli_fetch_assoc($check_user_result);
    $user_name = $user_data['first_name'] . ' ' . $user_data['last_name'];
    
    // Generate reset token
    $token = generateResetToken();
    $expires_at = date('Y-m-d H:i:s', time() + 5 * 60); // 5 minutes from now
    
    // Delete any existing reset tokens for this email
    $delete_old_tokens = "DELETE FROM password_resets WHERE email = '$email'";
    mysqli_query($conn, $delete_old_tokens);
    
    // Insert new reset token
    $insert_token_query = "INSERT INTO password_resets (email, token, expires_at) VALUES ('$email', '$token', '$expires_at')";
    
    if (mysqli_query($conn, $insert_token_query)) {
        // Send email
        if (sendPasswordResetEmail($email, $token, $user_name)) {
            $_SESSION['message'] = "Password reset link has been sent to your email address. Please check your inbox and spam folder.";
            $_SESSION['messageType'] = "success";
        } else {
            $_SESSION['message'] = "Failed to send email. Please try again later.";
            $_SESSION['messageType'] = "error";
        }
    } else {
        $_SESSION['message'] = "An error occurred. Please try again later.";
        $_SESSION['messageType'] = "error";
    }
    
    header('location: ../reset.php');
    exit();
}

// Handle password reset with token
if (isset($_POST['reset_password'])) {
    $token = mysqli_real_escape_string($conn, $_POST['token']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    
    // Validate token
    if (empty($token)) {
        $_SESSION['message'] = "Invalid reset link.";
        $_SESSION['messageType'] = "error";
        header('location: ../reset_password.php');
        exit();
    }
    
    // Check if token exists and is valid
    $check_token_query = "SELECT * FROM password_resets WHERE token = '$token' AND used = 0 AND expires_at > NOW()";
    $check_token_result = mysqli_query($conn, $check_token_query);
    
    if (mysqli_num_rows($check_token_result) == 0) {
        $_SESSION['message'] = "Invalid or expired reset link. Please request a new one.";
        $_SESSION['messageType'] = "error";
        header('location: ../reset.php');
        exit();
    }
    
    $reset_data = mysqli_fetch_assoc($check_token_result);
    $email = $reset_data['email'];
    
    // Validate password
    if (empty($password)) {
        $_SESSION['message'] = "Please enter a new password.";
        $_SESSION['messageType'] = "error";
        header('location: ../reset_password.php?token=' . $token);
        exit();
    }
    
    if (strlen($password) < 6) {
        $_SESSION['message'] = "Password must be at least 6 characters long.";
        $_SESSION['messageType'] = "error";
        header('location: ../reset_password.php?token=' . $token);
        exit();
    }
    
    if ($password !== $confirm_password) {
        $_SESSION['message'] = "Passwords do not match.";
        $_SESSION['messageType'] = "error";
        header('location: ../reset_password.php?token=' . $token);
        exit();
    }
    
    // Hash new password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Update user password
    $update_password_query = "UPDATE users SET password = '$hashed_password' WHERE email = '$email'";
    
    if (mysqli_query($conn, $update_password_query)) {
        // Mark token as used
        $mark_used_query = "UPDATE password_resets SET used = 1 WHERE token = '$token'";
        mysqli_query($conn, $mark_used_query);
        
        $_SESSION['message'] = "Password has been reset successfully. You can now login with your new password.";
        $_SESSION['messageType'] = "success";
        header('location: ../login.php');
        exit();
    } else {
        $_SESSION['message'] = "Failed to reset password. Please try again.";
        $_SESSION['messageType'] = "error";
        header('location: ../reset_password.php?token=' . $token);
        exit();
    }
}

// If no valid action, redirect to reset page
header('location: ../reset.php');
exit();
?> 