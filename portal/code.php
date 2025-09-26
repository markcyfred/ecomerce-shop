<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Africa/Nairobi');
session_start();
include('../admin/config/dbcon.php');
// include('../admin/userfunctions.php'); // File doesn't exist - commented out

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

// Function to send verification email
function sendemail_verify($first_name, $email, $verify_token)
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $base_url = $protocol . '://' . $host;

    if (strpos($host, 'localhost') !== false) {
        $base_url .= '/shcool-lms';
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'mail.inowey.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'support@inowey.com';
        $mail->Password   = 'support@inowey@3020';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('support@inowey.com', 'Inowey College');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verify your email';

        $email_template = 
        "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Verify Your Email</title>
            </head>
            <body style='font-family: Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0;'>
                <table role='presentation' width='100%' cellspacing='0' cellpadding='0' border='0'>
                    <tr>
                        <td align='center'>
                            <table width='100%' style='max-width: 600px; background-color: #ffffff; margin: 40px auto; padding: 20px; 
                                    border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid #e0e0e0;'>
                                <tr>
                                    <td align='center'>
                                        <img src='$base_url/assets/img/logo.png' alt='Inowey College Logo' width='120' 
                                            style='height: auto; margin-bottom: 20px;'>
                                        <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                                        <h2 style='color: #0068D9; margin: 10px 0; font-size: 22px;'>Welcome to Inowey College!</h2>
                                        <p style='color: #555; font-size: 16px; margin-bottom: 10px;'>Dear <strong>$first_name</strong>,</p>
                                        <p style='color: #666; font-size: 14px; margin-bottom: 20px;'>Welcome to Inowey College! We're excited to have you join our learning community. To complete your registration and start your educational journey, please verify your email address by clicking the button below.</p>
                                        <p>
                                            <a href='$base_url/portal/verify-email.php?token=$verify_token' 
                                                style='background-color: #0068D9; color: #ffffff; padding: 12px 24px; font-size: 16px; 
                                                font-weight: bold; border-radius: 6px; text-decoration: none; display: inline-block;'>
                                                Verify Email
                                            </a>
                                        </p>
                                        <p style='color: #777; font-size: 14px; margin-top: 20px;'>If the button above does not work, copy and paste this link into your browser:</p>
                                        <p style='background-color: #f8f9fa; padding: 10px; border-radius: 5px; word-break: break-word; font-size: 12px;'>
                                            <a href='$base_url/portal/verify-email.php?token=$verify_token' style='color: #0068D9; text-decoration: none;'>
                                                $base_url/portal/verify-email.php?token=$verify_token
                                            </a>
                                        </p>
                                        <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                                        <p style='color: #999; font-size: 12px;'>For security reasons, please do not share this email verification link.</p>
                                        <p style='color: #999; font-size: 12px;'>&copy; " . date('Y') . " Inowey College Team</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            </html>
        ";
        $mail->Body = $email_template;
        $mail->AltBody = 'Please verify your email by clicking the link provided in the HTML content.';

        // Send the email
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isHTML(true);
        $mail->SMTPDebug = 0; // Set to 2 for verbose debug output

        // Attempt to send the email
        if (!$mail->send()) {
            throw new Exception('Email could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }

        // Log success
        error_log("Email sent successfully to $email");

        // Optionally, you can also set a session variable or return a value
        $_SESSION['email_sent'] = true; // For debugging purposes
        $_SESSION['email'] = $email; // Store email for later use

        // Return true to indicate success
        return true;
    } catch (Exception $e) {
        // Log the error message
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");

        // Optionally, you can set a session variable to store the error message
        $_SESSION['mail_error'] = $mail->ErrorInfo; // For debugging

        // Return false to indicate failure
        return false;
    }
}

// Function to resend verification email
function resend_email_verify($first_name, $email, $token)
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $base_url = $protocol . '://' . $host;

    if (strpos($host, 'localhost') !== false) {
        $base_url .= '/shcool-lms';
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        //goprimehsotcreditials
        //support@goprimehost.com
        //pass= Markkinai@2023
        $mail->Host       = 'mail.inowey.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'support@inowey.com';
        $mail->Password   = 'support@inowey@3020';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('support@inowey.com', 'Inowey College');
        $mail->addAddress($email);

        $mail->isHTML(true);

        $email_template = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title><b>Email Verification Reminder</b></title>
        </head>
        <body style='font-family: Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0;'>
            <table role='presentation' width='100%' cellspacing='0' cellpadding='0' border='0'>
                <tr>
                    <td align='center'>
                        <table width='100%' style='max-width: 600px; background-color: #ffffff; margin: 40px auto; padding: 20px; 
                                border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid #e0e0e0;'>
                            <tr>
                                <td align='center'>
                                    <img src='$base_url/assets/img/logo.png' alt='Inowey College Logo' width='120'
                                        style='height: auto; margin-bottom: 20px;'>
                                    <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>

                                    <h2 style='color: #0068D9; margin: 10px 0; font-size: 22px;'>Complete Your Registration</h2>
                                    <p style='color: #555; font-size: 16px; margin-bottom: 10px;'>Dear <strong>$first_name</strong>,</p>
                                    <p style='color: #666; font-size: 14px; margin-bottom: 20px;'>We noticed your Inowey College account is almost ready! To complete your registration and gain full access to our learning platform, please verify your email address by clicking the button below.</p>
                                    <p>
                                        <a href='$base_url/portal/verify-email.php?token=$token'
                                            style='background-color: #0068D9; color: #ffffff; padding: 12px 24px; font-size: 16px; 
                                            font-weight: bold; border-radius: 6px; text-decoration: none; display: inline-block;'>
                                            Verify Email Address
                                        </a>
                                    </p>
                                    <p style='color: #777; font-size: 14px; margin-top: 20px;'>If the button above does not work, copy and paste this link into your browser:</p>
                                    <p style='background-color: #f8f9fa; padding: 10px; border-radius: 5px; word-break: break-word; font-size: 12px;'>
                                        <a href='$base_url/portal/verify-email.php?token=$token' style='color: #0068D9; text-decoration: none;'>
                                            $base_url/portal/verify-email.php?token=$token
                                        </a>
                                    </p>
                                    <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                                    <p style='color: #999; font-size: 12px;'>For security reasons, please do not share this email verification link.</p>
                                    <p style='color: #999; font-size: 12px;'>&copy; " . date('Y') . " Inowey College Team</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        ";

        $mail->Subject = 'Complete Your Inowey College Registration';
        $mail->Body    = $email_template;
        $mail->AltBody = "Dear $first_name,\n\nWe noticed your Inowey College account is almost ready! To complete your registration and gain full access to our learning platform, please verify your email by visiting this link:\n\n$base_url/portal/verify-email.php?token=$token\n\nInowey College Team";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

// Function to send password reset email
function send_password_reset($first_name, $email, $token)
{
    // Detect the base URL dynamically
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $base_url = $protocol . '://' . $host;

    if (strpos($host, 'localhost') !== false) {
        $base_url .= '/shcool-lms';
    }

    $mail = new PHPMailer(true);

    try {
        // Same SMTP settings as email verification
        $mail->isSMTP();
        $mail->Host       = 'mail.inowey.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'support@inowey.com';
        $mail->Password   = 'support@inowey@3020'; // same as verification
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('support@inowey.com', 'Inowey College');
        $mail->addAddress($email);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request from Inowey College';
        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Password Reset</title>
        </head>
        <body style='font-family: Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 0;'>
            <table role='presentation' width='100%' cellspacing='0' cellpadding='0' border='0'>
                <tr>
                    <td align='center'>
                        <table width='100%' style='max-width: 600px; background-color: #ffffff; margin: 40px auto; padding: 20px; 
                                border-radius: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); border: 1px solid #e0e0e0;'>
                            <tr>
                                <td align='center'>
                                    <img src='$base_url/assets/img/logo.png' alt='Inowey College Logo' width='120' style='margin-bottom: 20px;'>
                                    <h2 style='color: #0068D9;'>Secure Password Reset</h2>
                                    <p style='color: #555; font-size: 16px;'>Dear <strong>$first_name</strong>,</p>
                                    <p style='color: #666; font-size: 14px;'>We received a request to reset your password for your Inowey College account. To maintain the security of your educational account and protect your learning progress, please click the button below to create a new secure password:</p>
                                    <p>
                                        <a href='$base_url/portal/password-change.php?token=$token&email=$email' 
                                           style='background-color:#0068D9; color:#fff; padding:12px 24px; text-decoration:none; border-radius:6px; display:inline-block;'>
                                           Reset Password
                                        </a>
                                    </p>
                                    <p style='color: #777; font-size: 14px;'>If you didn't request this, you can ignore this email.</p>
                                    <p style='background-color: #f8f9fa; padding: 10px; border-radius: 5px; font-size: 12px;'>
                                        <a href='$base_url/portal/password-change.php?token=$token&email=$email' style='color:#0068D9; text-decoration:none;'>
                                            $base_url/portal/password-change.php?token=$token&email=$email
                                        </a>
                                    </p>
                                    <p style='color:#999; font-size:12px;'>This link will expire in 24 hours.</p>
                                    <p style='color:#999; font-size:12px;'>&copy; ".date('Y')." Inowey College Team</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>";

        $mail->SMTPDebug = 0;
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Password reset email failed: " . $mail->ErrorInfo);
        return false;
    }
}

// Function to send 2FA code via email
function send_twofa_code($first_name, $email, $twofa_code)
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $base_url = $protocol . '://' . $host;

    if (strpos($host, 'localhost') !== false) {
        $base_url .= '/shcool-lms';
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'mail.inowey.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'support@inowey.com';
        $mail->Password   = 'support@inowey@3020';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('support@inowey.com', 'Inowey College Security');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your 2FA Login Code - Inowey College';

        $email_template = 
        "
                <!DOCTYPE html>
                <html>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title><b>Two-Factor Authentication Code</b></title>
                    </head>
                <body style='font-family: Arial, sans-serif; background-color: white; margin: 0; padding: 0;'>
                    <table role='presentation' width='100%' cellspacing='0' cellpadding='0' border='0' 
                        style='background-color: #ffffff; max-width: 600px; margin: 40px auto; padding: 20px; 
                                border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); text-align: center;
                                border: 2px solid #ddd;'>  <!-- Added border here -->
                        <tr>
                            <td>
                                <img src='$base_url/assets/img/logo.png' alt='Inowey College Logo' width='100px' 
                                    style='height: auto; margin-bottom: 20px;'>
                                <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>

                                <h2 style='color: #0068D9; margin: 10px 0;'>Secure Login Verification</h2>
                                <p style='color: #666; font-size: 16px;'>Dear <strong>" . htmlspecialchars($first_name) . "</strong>,</p>
                                <p style='color: #666; font-size: 14px;'>We detected a login attempt to your Inowey College account. To ensure the security of your educational data and maintain access to your learning materials, please enter the verification code below to complete your secure login.</p>
                                
                                <div style='background: #f8f9fa; border: 2px solid #0068D9; border-radius: 8px; padding: 25px; text-align: center; margin: 30px 0;'>
                                    <h1 style='color: #0068D9; font-size: 36px; letter-spacing: 8px; margin: 0; font-family: monospace;'>" . $twofa_code . "</h1>
                                </div>
                                
                                <p style='color: #666; font-size: 14px;'>If this wasn't you, please secure your account immediately.</p>
                                <p style='color: #999; font-size: 12px;'>This verification code expires in 5 minutes for your security.</p>
                                <p style='background-color: #fff3cd; padding: 10px; border-radius: 5px; word-break: break-word; font-size: 12px; color: #856404;'>
                                    <strong>⚠️ Security Notice:</strong> This code expires in 5 minutes. Enter the code exactly as shown above.
                                </p>
                                <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                                <p style='color: #999; font-size: 12px;'>For security reasons, please do not share this verification code.</p>
                                <p style='color: #999; font-size: 12px;'>Inowey College Team</p>
                            </td>
                        </tr>
                    </table>
                </body>
            </html>

        ";

        $mail->Body = $email_template;
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("2FA Email Error: " . $mail->ErrorInfo);
        return false;
    }
}

// Function to generate unique student number
function generateStudentNumber($con) {
    $prefix = 'STU';
    $max_attempts = 10;
    
    for ($i = 0; $i < $max_attempts; $i++) {
        // Generate a 6-digit number
        $number = str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        $student_number = $prefix . $number;
        
        // Check if this student number already exists
        $check_query = "SELECT id FROM users WHERE student_number = ? LIMIT 1";
        $check_stmt = mysqli_prepare($con, $check_query);
        mysqli_stmt_bind_param($check_stmt, 's', $student_number);
        mysqli_stmt_execute($check_stmt);
        $result = mysqli_stmt_get_result($check_stmt);
        
        if (mysqli_num_rows($result) == 0) {
            return $student_number;
        }
    }
    
    // If we can't generate a unique number after max attempts, use timestamp
    return $prefix . date('Ymd') . rand(100, 999);
}

// User Registration
if (isset($_POST['register_btn'])) {
    // Validate all required fields exist
    $required_fields = ['first_name', 'last_name', 'email_address', 'phone_number', 'password', 'street_address', 'city', 'postal_code', 'agreed_to_terms'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || $_POST[$field] === '') {
            echo json_encode(['success' => false, 'message' => 'All fields are required']);
            exit();
        }
    }

    $first_name = mysqli_real_escape_string($con, trim($_POST['first_name']));
    $last_name  = mysqli_real_escape_string($con, trim($_POST['last_name']));
    $email      = mysqli_real_escape_string($con, trim($_POST['email_address']));
    
    $phone = mysqli_real_escape_string($con, trim($_POST['phone_number']));
    $password   = mysqli_real_escape_string($con, $_POST['password']);
    $user_role  = 0; // Default all registrations to student role
    $street_address = mysqli_real_escape_string($con, $_POST['street_address']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $postal_code = mysqli_real_escape_string($con, $_POST['postal_code']);
    $agreed_to_terms = isset($_POST['agreed_to_terms']) ? 1 : 0;
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;
    $verify_token = md5(rand());

    // Check if user already exists
    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($con, $check_email_query);

    if (mysqli_num_rows($check_email_query_run) > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already registered']);
        exit();
    }

    // Validate password strength
    if (strlen($password) < 8) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long']);
        exit();
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        echo json_encode(['success' => false, 'message' => 'Password must contain at least one uppercase letter']);
        exit();
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        echo json_encode(['success' => false, 'message' => 'Password must contain at least one lowercase letter']);
        exit();
    }
    
    if (!preg_match('/\d/', $password)) {
        echo json_encode(['success' => false, 'message' => 'Password must contain at least one number']);
        exit();
    }
    
    if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
        echo json_encode(['success' => false, 'message' => 'Password must contain at least one special character']);
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate unique student number
    $student_number = generateStudentNumber($con);

    // Handle profile picture upload
    $profile_picture = 'default.png';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/profile/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($file_extension, $allowed_extensions)) {
            $profile_picture = uniqid() . '.' . $file_extension;
            $upload_path = $upload_dir . $profile_picture;
            
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
                // File uploaded successfully
            } else {
                $profile_picture = 'default.png';
            }
        }
    }

    // Insert user data
    $query = "INSERT INTO users (first_name, last_name, email, phone, phonenumber, street_address, city, postal_code, password, verify_token, user_role, verify_status, agreed_to_terms, profile_picture) 
              VALUES ('$first_name', '$last_name', '$email', '$phone', '$phone', '$street_address', '$city', '$postal_code', '$hashed_password', '$verify_token', '$user_role', '0', '$agreed_to_terms', '$profile_picture')";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        // Send verification email
        $email_sent = sendemail_verify($first_name, $email, $verify_token);

        if ($email_sent) {
            echo json_encode([
                'success' => true,
                'message' => 'Registration successful! Please check your email to verify your account.'
            ]);
        } else {
            // Get the specific email error if available
            $error_msg = isset($_SESSION['mail_error']) ? $_SESSION['mail_error'] : 'Email service temporarily unavailable.';
            
            echo json_encode([
                'success' => true,
                'message' => "Registration successful! Your account has been created. However, we couldn't send the verification email at this time. Please contact support for assistance."
            ]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed. Please try again.']);
    }
    exit();
}

// User Login
if (isset($_POST['login_btn'])) {
    // Rate limiting for login attempts
    $max_attempts = 3;
    $rate_limit_time = 1800; // 30 minutes
    $current_time = time();
    
    // Get client IP address
    $client_ip = $_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
        $client_ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    
    // Clean up old login attempts (older than 30 minutes) from database
    $cleanup_time = $current_time - $rate_limit_time;
    $cleanup_query = "DELETE FROM password_reset_attempts WHERE attempt_time < $cleanup_time AND attempt_type IN ('login_failed', 'login_success')";
    mysqli_query($con, $cleanup_query);
    
    // Check current login attempts for this IP
    $check_attempts_query = "SELECT COUNT(*) as attempt_count FROM password_reset_attempts 
                            WHERE ip_address = '$client_ip' 
                            AND attempt_type = 'login_failed' 
                            AND attempt_time > $cleanup_time";
    $attempts_result = mysqli_query($con, $check_attempts_query);
    $attempts_data = mysqli_fetch_assoc($attempts_result);
    $current_attempts = $attempts_data['attempt_count'];
    
    // If user has reached max attempts, check if they are Super Admin before blocking
    if ($current_attempts >= $max_attempts) {
        // Check if the user trying to login is a Super Admin (role 3)
        $username_email = mysqli_real_escape_string($con, $_POST['username_email']);
        $check_super_admin_query = "SELECT user_role FROM users WHERE email='$username_email' LIMIT 1";
        $super_admin_result = mysqli_query($con, $check_super_admin_query);
        $is_super_admin = false;
        
        if (mysqli_num_rows($super_admin_result) > 0) {
            $user_data = mysqli_fetch_assoc($super_admin_result);
            $is_super_admin = ($user_data['user_role'] == 3);
        }
        
        // Only block if not Super Admin
        if (!$is_super_admin) {
        // Get the time of the first failed attempt to calculate unlock time
        $first_attempt_query = "SELECT MIN(attempt_time) as first_attempt FROM password_reset_attempts 
                               WHERE ip_address = '$client_ip' 
                               AND attempt_type = 'login_failed' 
                               AND attempt_time > $cleanup_time";
        $first_attempt_result = mysqli_query($con, $first_attempt_query);
        $first_attempt_data = mysqli_fetch_assoc($first_attempt_result);
        $first_attempt_time = $first_attempt_data['first_attempt'];
        
        $unlock_time = $first_attempt_time + $rate_limit_time;
        $remaining_time = $unlock_time - $current_time;
        
        if ($remaining_time > 0) {
            $unlock_datetime = date('H:i', $unlock_time);
            $remaining_minutes = ceil($remaining_time / 60);
            
            echo json_encode([
                'success' => false, 
                'message' => "Too many failed login attempts! Please try again at $unlock_datetime (in $remaining_minutes minutes)."
            ]);
            exit();
            }
        }
    }
    
    if (!empty(trim($_POST['username_email'])) && !empty(trim($_POST['password']))) {
        $username_email = mysqli_real_escape_string($con, $_POST['username_email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        $login_query = "SELECT * FROM users WHERE email='$username_email' LIMIT 1";
        $login_query_run = mysqli_query($con, $login_query);

        if (mysqli_num_rows($login_query_run) > 0) {
            $row = mysqli_fetch_array($login_query_run);

            if ($row['verify_status'] == "1") {
                if (password_verify($password, $row['password'])) {
                    // Successful login - log it and clear any failed attempts
                    $log_query = "INSERT INTO password_reset_attempts (ip_address, email_attempted, attempt_time, attempt_type, success) 
                                 VALUES ('$client_ip', '$username_email', $current_time, 'login_success', 1)";
                    mysqli_query($con, $log_query);
                    
                    // Clear failed login attempts for this IP on successful login
                    $clear_failed_query = "DELETE FROM password_reset_attempts 
                                          WHERE ip_address = '$client_ip' AND attempt_type = 'login_failed'";
                    mysqli_query($con, $clear_failed_query);
                    
                    // Check if 2FA is enabled for this user
                    if (isset($row['twofa_enabled']) && $row['twofa_enabled'] == 1) {
                        // Generate 2FA code and store in session
                        $twofa_code = sprintf('%06d', mt_rand(0, 999999));
                        $twofa_expires = time() + 300; // 5 minutes expiry
                        
                        // Store 2FA data in session (not fully authenticated yet)
                        $_SESSION['twofa_pending'] = [
                            'user_id' => $row['id'],
                            'user_data' => $row,
                            'code' => $twofa_code,
                            'expires' => $twofa_expires,
                            'attempts' => 0
                        ];
                        
                        // Send 2FA code via email
                        send_twofa_code($row['first_name'], $row['email'], $twofa_code);
                        
                        echo json_encode([
                            'success' => true, 
                            'message' => '2FA code sent to your email!', 
                            'redirect' => 'twofa-verify.php',
                            'requires_2fa' => true
                        ]);
                    } else {
                        // No 2FA required - complete login
                        $_SESSION['authenticated'] = true;
                        $_SESSION['auth_user'] = [
                            'user_id' => $row['id'],
                            'user_name' => $row['first_name'] . ' ' . $row['last_name'],
                            'user_email' => $row['email'],
                            'first_name' => $row['first_name'],
                            'last_name' => $row['last_name'],
                            'email' => $row['email'],
                            'phone' => $row['phonenumber'],
                            'user_role' => $row['user_role']
                        ];

                        // Role-based redirection: 0=student, 1=admin, 2=lecturer
                        $user_role = (int)$row['user_role'];
                        $_SESSION['user_role'] = $user_role;
                        
                        // Device verification for students and lecturers (exclude admin and super admin)
                        if ($user_role === 0 || $user_role === 2) {
                            // Check if device is provided in POST data
                            $device_fingerprint = $_POST['device_fingerprint'] ?? '';
                            
                            
                            if (empty($device_fingerprint)) {
                                echo json_encode([
                                    'success' => false, 
                                    'message' => 'Device verification required. Please refresh the page and try again.',
                                    'requires_device' => true
                                ]);
                                exit;
                            }
                            
                            // Verify device registration
                            include 'includes/device-registration.php';
                            $device_result = verifyUserDevice($row['id'], $device_fingerprint);
                            
                            if (!$device_result['success']) {
                                // Check if user has any registered devices
                                $count_query = "SELECT COUNT(*) as device_count FROM student_devices WHERE user_id = ? AND is_active = 1";
                                $stmt = mysqli_prepare($con, $count_query);
                                mysqli_stmt_bind_param($stmt, 'i', $row['id']);
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                $device_count = mysqli_fetch_assoc($result)['device_count'];
                                
                                if ($device_count === 0) {
                                    // No devices registered yet, register this one
                                    $device_info = json_decode($_POST['device_info'] ?? '{}', true);
                                    $register_result = registerUserDevice($row['id'], $device_fingerprint, $device_info);
                                    
                                    if (!$register_result['success']) {
                                        echo json_encode([
                                            'success' => false, 
                                            'message' => 'Device registration failed: ' . $register_result['message'],
                                            'requires_device' => true
                                        ]);
                                        exit;
                                    }
                                } else {
                                    // User already has registered devices, deny login
                                    echo json_encode([
                                        'success' => false, 
                                        'message' => 'Access denied: This account is already registered to another device. Please use your registered device to login.',
                                        'requires_device' => true
                                    ]);
                                    exit;
                                }
                            }
                            
                            // Store device info in session
                            $_SESSION['device_fingerprint'] = $device_fingerprint;
                        } else {
                            // Admin and Super Admin - bypass device verification
                        }
                        
                        switch ($user_role) {
                            case 1: // Admin
                                echo json_encode(['success' => true, 'message' => 'Welcome Administrator!', 'redirect' => '../admin/index.php']);
                                break;
                            case 2: // Lecturer
                                echo json_encode(['success' => true, 'message' => 'Welcome Lecturer!', 'redirect' => '../instructor/index.php']);
                                break;
                            case 3: // Super Admin
                                echo json_encode(['success' => true, 'message' => 'Welcome Super Administrator!', 'redirect' => '../admin/index.php']);
                                break;
                            case 0: // Customer (default)
                            default:
                                echo json_encode(['success' => true, 'message' => 'Welcome back!', 'redirect' => '../index.php']);
                                break;
                        }
                    }
                } else {
                    // Failed login - log it and show remaining attempts
                    $log_query = "INSERT INTO password_reset_attempts (ip_address, email_attempted, attempt_time, attempt_type, success) 
                                 VALUES ('$client_ip', '$username_email', $current_time, 'login_failed', 0)";
                    mysqli_query($con, $log_query);
                    
                    $remaining_attempts = $max_attempts - ($current_attempts + 1);
                    $message = 'Invalid password';
                    
                    if ($remaining_attempts > 0) {
                        if ($remaining_attempts == 2) {
                            $message .= ". You have $remaining_attempts login attempts remaining in the next 30 minutes.";
                        } elseif ($remaining_attempts == 1) {
                            $message .= ". You have $remaining_attempts login attempt remaining in the next 30 minutes.";
                        }
                    } else {
                        $unlock_time = $current_time + $rate_limit_time;
                        $unlock_datetime = date('H:i', $unlock_time);
                        $message .= ". Account temporarily locked. Please try again at $unlock_datetime.";
                    }
                    
                    echo json_encode(['success' => false, 'message' => $message]);
                }
            } else {
                // Account not verified - log as failed attempt
                $log_query = "INSERT INTO password_reset_attempts (ip_address, email_attempted, attempt_time, attempt_type, success) 
                             VALUES ('$client_ip', '$username_email', $current_time, 'login_failed', 0)";
                mysqli_query($con, $log_query);
                
                $remaining_attempts = $max_attempts - ($current_attempts + 1);
                $message = 'Please verify your email address first';
                
                if ($remaining_attempts > 0 && $remaining_attempts < 3) {
                    if ($remaining_attempts == 2) {
                        $message .= ". You have $remaining_attempts login attempts remaining in the next 30 minutes.";
                    } elseif ($remaining_attempts == 1) {
                        $message .= ". You have $remaining_attempts login attempt remaining in the next 30 minutes.";
                    }
                } elseif ($remaining_attempts <= 0) {
                    $unlock_time = $current_time + $rate_limit_time;
                    $unlock_datetime = date('H:i', $unlock_time);
                    $message .= ". Account temporarily locked. Please try again at $unlock_datetime.";
                }
                
                echo json_encode(['success' => false, 'message' => $message]);
            }
        } else {
            // No account found - log as failed attempt
            $log_query = "INSERT INTO password_reset_attempts (ip_address, email_attempted, attempt_time, attempt_type, success) 
                         VALUES ('$client_ip', '$username_email', $current_time, 'login_failed', 0)";
            mysqli_query($con, $log_query);
            
            $remaining_attempts = $max_attempts - ($current_attempts + 1);
            $message = 'No account found with this email';
            
            if ($remaining_attempts > 0 && $remaining_attempts < 3) {
                if ($remaining_attempts == 2) {
                    $message .= ". You have $remaining_attempts login attempts remaining in the next 30 minutes.";
                } elseif ($remaining_attempts == 1) {
                    $message .= ". You have $remaining_attempts login attempt remaining in the next 30 minutes.";
                }
            } elseif ($remaining_attempts <= 0) {
                $unlock_time = $current_time + $rate_limit_time;
                $unlock_datetime = date('H:i', $unlock_time);
                $message .= ". Account temporarily locked. Please try again at $unlock_datetime.";
            }
            
            echo json_encode(['success' => false, 'message' => $message]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
    }
    exit();
}

// Password Reset Request
if (isset($_POST['password_reset_link'])) {
    // Security: Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $max_attempts = 3;
    $rate_limit_time = 1800; // 30 minutes
    $current_time = time();
    
    // Get client IP address
    $client_ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
        $client_ip = $_SERVER['HTTP_X_REAL_IP'];
    }

    // Clean up old attempts (older than 30 minutes) from database
    $cleanup_time = $current_time - $rate_limit_time;
    $cleanup_query = "DELETE FROM password_reset_attempts WHERE attempt_time < $cleanup_time";
    mysqli_query($con, $cleanup_query);
    
    // Check current attempts for this IP
    $check_attempts_query = "SELECT COUNT(*) as attempt_count, MIN(attempt_time) as first_attempt, MAX(attempt_time) as last_attempt 
                            FROM password_reset_attempts 
                            WHERE ip_address = '$client_ip' AND attempt_time > $cleanup_time";
    $attempts_result = mysqli_query($con, $check_attempts_query);
    $attempts_data = mysqli_fetch_assoc($attempts_result);
    
    $current_attempts = $attempts_data['attempt_count'];
    $remaining_attempts = $max_attempts - $current_attempts;

    // Check if rate limit exceeded
    if ($current_attempts >= $max_attempts) {
        $wait_time_seconds = $rate_limit_time - ($current_time - $attempts_data['first_attempt']);
        $wait_minutes = ceil($wait_time_seconds / 60);
        
        echo json_encode([
            'success' => false,
            'message' => "Too many reset attempts! You have 0 attempts remaining. Please wait {$wait_minutes} minutes before trying again."
        ]);
        exit();
    }

    // Security: Check for honeypot field (bot detection)
    if (isset($_POST['website']) && !empty($_POST['website'])) {
        // Record honeypot attempt
        $honeypot_query = "INSERT INTO password_reset_attempts (ip_address, email_attempted, attempt_time, attempt_type) 
                          VALUES ('$client_ip', 'honeypot_detected', $current_time, 'honeypot')";
        mysqli_query($con, $honeypot_query);
        
        echo json_encode([
            'success' => false, 
            'message' => 'Bot behavior detected! Please ensure you are using the form properly. If you are human, please contact support.'
        ]);
        exit();
    }

    if (!isset($_POST['email']) || empty($_POST['email'])) {
        echo json_encode(['success' => false, 'message' => 'Email address is required']);
        exit();
    }

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $token = md5(rand() . time());

    $check_email = "SELECT first_name, email FROM users WHERE email='$email' LIMIT 1";
    $check_email_run = mysqli_query($con, $check_email);

    if (mysqli_num_rows($check_email_run) > 0) {
        $row = mysqli_fetch_array($check_email_run);
        $first_name = $row['first_name'];
        $get_email = $row['email'];

        $update_token = "UPDATE users SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
        $update_token_run = mysqli_query($con, $update_token);

        if ($update_token_run) {
            $email_sent = send_password_reset($first_name, $get_email, $token);

            if ($email_sent) {
                // Record successful attempt in database
                $record_attempt = "INSERT INTO password_reset_attempts (ip_address, email_attempted, attempt_time, attempt_type, success) 
                                  VALUES ('$client_ip', '$email', $current_time, 'password_reset', 1)";
                mysqli_query($con, $record_attempt);
                
                // Recalculate remaining attempts
                $remaining_after = $max_attempts - ($current_attempts + 1);
                
                $message = 'Password reset link sent to your email';
                
                // Add remaining attempts warning
                if ($remaining_after == 2) {
                    $message .= ". You have {$remaining_after} reset attempts remaining in the next 30 minutes.";
                } elseif ($remaining_after == 1) {
                    $message .= ". You have {$remaining_after} reset attempt remaining in the next 30 minutes.";
                } elseif ($remaining_after <= 0) {
                    $message .= ". You have reached your reset limit. Please wait before requesting another reset.";
                }
                
                echo json_encode(['success' => true, 'message' => $message]);
            } else {
                // Record failed attempt
                $record_attempt = "INSERT INTO password_reset_attempts (ip_address, email_attempted, attempt_time, attempt_type, success) 
                                  VALUES ('$client_ip', '$email', $current_time, 'password_reset', 0)";
                mysqli_query($con, $record_attempt);
                
                echo json_encode(['success' => false, 'message' => 'Failed to send reset email. Please try again.']);
            }
        } else {
            // Record failed attempt
            $record_attempt = "INSERT INTO password_reset_attempts (ip_address, email_attempted, attempt_time, attempt_type, success) 
                              VALUES ('$client_ip', '$email', $current_time, 'database_error', 0)";
            mysqli_query($con, $record_attempt);
            
            echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again.']);
        }
    } else {
        // Record failed attempt for invalid email
        $record_attempt = "INSERT INTO password_reset_attempts (ip_address, email_attempted, attempt_time, attempt_type, success) 
                          VALUES ('$client_ip', '$email', $current_time, 'invalid_email', 0)";
        mysqli_query($con, $record_attempt);
        
        // Recalculate remaining attempts
        $remaining_after = $max_attempts - ($current_attempts + 1);
        
        $message = 'No account found with this email address';
        
        // Add remaining attempts warning for failed attempts too
        if ($remaining_after == 2) {
            $message .= ". You have {$remaining_after} reset attempts remaining.";
        } elseif ($remaining_after == 1) {
            $message .= ". You have {$remaining_after} reset attempt remaining.";
        } elseif ($remaining_after <= 0) {
            $message .= ". You have reached your reset limit.";
        }
        
        echo json_encode(['success' => false, 'message' => $message]);
    }
    exit();
}

// AJAX Email Availability Check
if (isset($_POST['check_email'])) {
    // Debug: Log all POST data
    error_log("Email check POST data: " . print_r($_POST, true));
    
    if (isset($_POST['check_email']) && !empty($_POST['check_email'])) {
        $email = mysqli_real_escape_string($con, $_POST['check_email']);
        $query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
        
        // Debug: Check if connection exists
        if (!$con) {
            error_log("Email check: No database connection!");
            echo "true";
            exit();
        }
        
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $count = mysqli_num_rows($query_run);

            // Debug info
            error_log("Email check SUCCESS: Email='$email', Count=$count, Query='$query'");

            if ($count > 0) {
                error_log("Email check: Email EXISTS in database");
                echo "false"; // Email exists
            } else {
                error_log("Email check: Email AVAILABLE");
                echo "true"; // Email available
            }
        } else {
            // Database query failed
            $error = mysqli_error($con);
            error_log("Email check: Database query FAILED - " . $error);
            echo "true"; // Assume available if query fails
        }
    } else {
        error_log("Email check: Invalid or empty email parameter");
        echo "true";
    }
    exit();
}

// AJAX Phone Availability Check
if (isset($_POST['check_phone'])) {
    // Debug: Log all POST data
    error_log("Phone check POST data: " . print_r($_POST, true));
    
    if (isset($_POST['check_phone']) && !empty($_POST['check_phone'])) {
        $phone = mysqli_real_escape_string($con, $_POST['check_phone']);
        $query = "SELECT phonenumber FROM users WHERE phonenumber='$phone' LIMIT 1";
        
        // Debug: Check if connection exists
        if (!$con) {
            error_log("Phone check: No database connection!");
            echo "true";
            exit();
        }
        
        $query_run = mysqli_query($con, $query);

        if ($query_run) {
            $count = mysqli_num_rows($query_run);

            // Debug info
            error_log("Phone check SUCCESS: Phone='$phone', Count=$count, Query='$query'");

            if ($count > 0) {
                error_log("Phone check: Phone EXISTS in database");
                echo "false"; // Phone exists
            } else {
                error_log("Phone check: Phone AVAILABLE");
                echo "true"; // Phone available
            }
        } else {
            // Database query failed
            $error = mysqli_error($con);
            error_log("Phone check: Database query FAILED - " . $error);
            echo "true"; // Assume available if query fails
        }
    } else {
        error_log("Phone check: Invalid or empty phone parameter");
        echo "true";
    }
    exit();
}

// Password Change (from reset link)
if (isset($_POST['password_update'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    $token = mysqli_real_escape_string($con, $_POST['password_change_token']);

    if (!empty($token)) {
        if (!empty($email) && !empty($new_password) && !empty($confirm_password)) {
            // Password validation
            if (strlen($new_password) < 6) {
                echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters long']);
                exit();
            }
            
            // Check for weak passwords
            $weak_passwords = ['123456', '123456789', 'password', 'qwerty', '111111', '123123', 'admin', 'letmein', 'welcome'];
            if (in_array(strtolower($new_password), $weak_passwords)) {
                echo json_encode(['success' => false, 'message' => 'This password is too common and not secure. Please choose a stronger password']);
                exit();
            }
            
            // Check if token exists and get current password
            $check_token = "SELECT verify_token, password FROM users WHERE verify_token='$token' LIMIT 1";
            $check_token_run = mysqli_query($con, $check_token);

            if (mysqli_num_rows($check_token_run) > 0) {
                $user_data = mysqli_fetch_array($check_token_run);
                $current_password = $user_data['password'];
                
                // Check if new password is same as current password
                if (password_verify($new_password, $current_password)) {
                    echo json_encode(['success' => false, 'message' => 'New password cannot be the same as your current password']);
                    exit();
                }
                
                if ($new_password == $confirm_password) {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $new_token = md5(rand()) . "goprimehost";

                    $update_password = "UPDATE users SET password='$hashed_password', verify_token='$new_token' WHERE verify_token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($con, $update_password);

                    if ($update_password_run) {
                        echo json_encode(['success' => true, 'message' => 'Password updated successfully']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Password could not be updated']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid or expired token']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'All fields are required']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No token provided']);
    }
    exit();
}

// Resend Email Verification
// Resend Email Verification
if (isset($_POST['resend_email_verify_btn'])) {
    if (!empty(trim($_POST['email']))) {
        $email = mysqli_real_escape_string($con, $_POST['email']);

        $check_email_query = "SELECT email, verify_status, first_name, verify_token 
                              FROM users WHERE email = '$email' LIMIT 1";
        $checkemail_query_run = mysqli_query($con, $check_email_query);

        if (mysqli_num_rows($checkemail_query_run) > 0) {
            $row = mysqli_fetch_assoc($checkemail_query_run);
            $verify_status = $row['verify_status'] ?? null;

            if ($verify_status == 0) {
                $first_name = $row['first_name'];
                $verify_token = $row['verify_token'];

                // ✅ Use the same function used during registration
                $email_sent = sendemail_verify($first_name, $email, $verify_token);

                if ($email_sent) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Verification link has been sent to your email address'
                    ]);
                } else {
                    $error_msg = isset($_SESSION['mail_error']) ? $_SESSION['mail_error'] : 'SMTP issue, check logs.';
                    echo json_encode([
                        'success' => false,
                        'message' => "Failed to send verification email. Error: $error_msg"
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Email is already verified. You can now login'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Email address not found. Please check your email or register a new account'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Please enter your email address'
        ]);
    }
    exit();
}

// 2FA Code Verification
if (isset($_POST['verify_2fa_btn'])) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check if 2FA verification is pending
    if (!isset($_SESSION['twofa_pending'])) {
        echo json_encode(['success' => false, 'message' => '2FA session expired. Please login again.']);
        exit();
    }
    
    $twofa_data = $_SESSION['twofa_pending'];
    
    // Check if code has expired
    if (time() > $twofa_data['expires']) {
        unset($_SESSION['twofa_pending']);
        echo json_encode(['success' => false, 'message' => '2FA code expired. Please login again.']);
        exit();
    }
    
    if (!empty(trim($_POST['twofa_code']))) {
        $entered_code = trim($_POST['twofa_code']);
        $correct_code = $twofa_data['code'];
        
        // Increment attempt counter
        $_SESSION['twofa_pending']['attempts']++;
        
        // Check max attempts (3 attempts allowed)
        if ($_SESSION['twofa_pending']['attempts'] > 3) {
            unset($_SESSION['twofa_pending']);
            echo json_encode([
                'success' => false, 
                'message' => 'Too many failed attempts. Redirecting to login...', 
                'redirect' => 'login.php'
            ]);
            exit();
        }
        
        if ($entered_code === $correct_code) {
            // 2FA verification successful - complete login
            $user_data = $twofa_data['user_data'];
            
            $_SESSION['authenticated'] = true;
            $_SESSION['auth_user'] = [
                'user_id' => $user_data['id'],
                'user_name' => $user_data['first_name'] . ' ' . $user_data['last_name'],
                'user_email' => $user_data['email'],
                'first_name' => $user_data['first_name'],
                'last_name' => $user_data['last_name'],
                'email' => $user_data['email'],
                'phone' => $user_data['phonenumber'],
                'user_role' => $user_data['user_role']
            ];
            
            // Role-based redirection: 0=student, 1=admin, 2=lecturer
            $user_role = (int)$user_data['user_role'];
            $_SESSION['user_role'] = $user_role;
            
            // Device verification for students and lecturers (exclude admin only)
            if ($user_role === 0 || $user_role === 2) {
                // Check if device is provided in POST data
                $device_fingerprint = $_POST['device_fingerprint'] ?? '';
                
                if (empty($device_fingerprint)) {
                    echo json_encode([
                        'success' => false, 
                        'message' => 'Device verification required. Please refresh the page and try again.',
                        'requires_device' => true
                    ]);
                    exit;
                }
                
                // Verify device registration
                include 'includes/device-registration.php';
                $device_result = verifyUserDevice($user_data['id'], $device_fingerprint);
                
                if (!$device_result['success']) {
                    // Check if user has any registered devices
                    $count_query = "SELECT COUNT(*) as device_count FROM student_devices WHERE user_id = ? AND is_active = 1";
                    $stmt = mysqli_prepare($con, $count_query);
                    mysqli_stmt_bind_param($stmt, 'i', $user_data['id']);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $device_count = mysqli_fetch_assoc($result)['device_count'];
                    
                    if ($device_count === 0) {
                        // No devices registered yet, register this one
                        $device_info = json_decode($_POST['device_info'] ?? '{}', true);
                        $register_result = registerUserDevice($user_data['id'], $device_fingerprint, $device_info);
                        
                        if (!$register_result['success']) {
                            echo json_encode([
                                'success' => false, 
                                'message' => 'Device registration failed: ' . $register_result['message'],
                                'requires_device' => true
                            ]);
                            exit;
                        }
                    } else {
                        // User already has registered devices, deny login
                        echo json_encode([
                            'success' => false, 
                            'message' => 'Access denied: This account is already registered to another device. Please use your registered device to login.',
                            'requires_device' => true
                        ]);
                        exit;
                    }
                }
                
                // Store device info in session
                $_SESSION['device_fingerprint'] = $device_fingerprint;
            } else {
                // Admin only - bypass device verification
            }
            
            // Clear 2FA session data
            unset($_SESSION['twofa_pending']);
            
            // Determine redirect and message based on role
            switch ($user_role) {
                case 1: // Admin
                    $redirect = '../admin/index.php';
                    $message = 'Welcome Administrator!';
                    break;
                case 2: // Lecturer
                    $redirect = '../instructor/index.php';
                    $message = 'Welcome Lecturer!';
                    break;
                case 0: // Customer (default)
                default:
                    $redirect = '../index.php';
                    $message = 'Welcome back!';
                    break;
            }
            
            echo json_encode([
                'success' => true, 
                'message' => $message, 
                'redirect' => $redirect
            ]);
        } else {
            $remaining_attempts = 3 - $_SESSION['twofa_pending']['attempts'];
            $message = 'Invalid verification code.';
            
            if ($remaining_attempts > 0) {
                $message .= " You have $remaining_attempts attempt(s) remaining.";
            }
            
            echo json_encode(['success' => false, 'message' => $message]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Please enter the verification code.']);
    }
    exit();
}

// Resend 2FA Code
if (isset($_POST['resend_2fa_code'])) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check if 2FA verification is pending
    if (!isset($_SESSION['twofa_pending'])) {
        echo json_encode(['success' => false, 'message' => '2FA session expired. Please login again.']);
        exit();
    }
    
    $twofa_data = $_SESSION['twofa_pending'];
    $user_data = $twofa_data['user_data'];
    
    // Generate new 2FA code
    $new_twofa_code = sprintf('%06d', mt_rand(0, 999999));
    $new_expires = time() + 300; // 5 minutes expiry
    
    // Update session with new code
    $_SESSION['twofa_pending']['code'] = $new_twofa_code;
    $_SESSION['twofa_pending']['expires'] = $new_expires;
    $_SESSION['twofa_pending']['attempts'] = 0; // Reset attempts
    
    // Send new 2FA code
    $email_sent = send_twofa_code($user_data['first_name'], $user_data['email'], $new_twofa_code);
    
    if ($email_sent) {
        echo json_encode([
            'success' => true,
            'message' => 'New verification code sent to your email!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to send verification code. Please try again.'
        ]);
    }
    exit();
}

// Debug test endpoint
if (isset($_POST['test_connection'])) {
    echo json_encode(['success' => true, 'message' => 'Connection successful', 'timestamp' => date('Y-m-d H:i:s')]);
    exit();
}

// Database test endpoint
if (isset($_POST['test_database'])) {
    $test_query = "SELECT COUNT(*) as total FROM users";
    $test_result = mysqli_query($con, $test_query);

    if ($test_result) {
        $row = mysqli_fetch_assoc($test_result);
        $total_users = $row['total'];

        // Get table structure
        $structure_query = "DESCRIBE users";
        $structure_result = mysqli_query($con, $structure_query);
        $columns = [];

        if ($structure_result) {
            while ($col = mysqli_fetch_assoc($structure_result)) {
                $columns[] = $col['Field'];
            }
        }

        echo json_encode([
            'success' => true,
            'total_users' => $total_users,
            'table_exists' => true,
            'columns' => $columns,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => mysqli_error($con),
            'table_exists' => false,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
    exit();
}

// If no matching POST request, return error
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo json_encode(['success' => false, 'message' => 'No matching endpoint found', 'post_data' => array_keys($_POST)]);
    exit();
}
