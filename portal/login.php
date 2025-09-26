<?php
session_start();

// Handle device verification error messages
$error_message = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'device_verification_required':
            $error_message = 'Device verification required. Please login again.';
            break;
        case 'device_not_registered':
            $error_message = 'Device not registered. Please login from your registered device.';
            break;
        case 'device_blocked':
            $error_message = 'This device has been blocked by an administrator. Please contact support or request device access.';
            break;
    }
}

// Check if user is already logged in
$already_logged_in = false;
if (isset($_SESSION['auth_user']) && isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    $already_logged_in = true;
    $user_name = $_SESSION['auth_user']['user_name'] ?? 'User';
    
    // Auto-redirect if already logged in
    $redirect = $_GET['redirect'] ?? '';
    $user_role = $_SESSION['auth_user']['user_role'] ?? '0';
    
    if ($redirect === 'attendance' && $user_role === '0') {
        // Student wants to go to attendance page
        header('Location: ../student_portal/my-attendance.php');
        exit;
    } else {
        // Default redirect based on role
        switch ($user_role) {
            case '1': // Admin
                header('Location: ../admin/index.php');
                exit;
            case '2': // Lecturer
                header('Location: ../instructor/index.php');
                exit;
            case '0': // Student
            default:
                header('Location: ../student_portal/index.php');
                exit;
        }
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/logo.png">


    <link href="css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <script src="js/sweetalert2.all.min.js"></script>


    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>User Login - Ecommerce Shop </title>

    <style>
        form {
            margin: auto;
            min-width: 250px;
            max-width: 350px;
            border: none
        }

        /* Ecommerce Shop Color Scheme */
        :root {
            --inowey-primary: #0068D9;
            --inowey-secondary: #0496FF;
            --inowey-accent: #00305c;
            --inowey-light: #edf1fb;
            --inowey-dark: #13293D;
        }

        .btn-purple {
            background-color: var(--inowey-primary) !important;
            border-color: var(--inowey-primary) !important;
            color: white !important;
        }

        .btn-purple:hover {
            background-color: var(--inowey-accent) !important;
            border-color: var(--inowey-accent) !important;
            color: white !important;
        }

        .form-signin-heading {
            color: var(--inowey-primary) !important;
        }

        .text-muted a {
            color: var(--inowey-primary) !important;
        }

        .text-muted a:hover {
            color: var(--inowey-accent) !important;
        }

        /* Custom SweetAlert positioning for top-right corner */
        body.swal2-toast-shown .swal2-container.swal2-top-right {
            top: 1em !important;
            right: 1em !important;
        }

        .swal2-popup.swal2-toast.small-swal {
            font-size: 14px !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
            max-width: 350px !important;
            min-width: 250px !important;
            width: auto !important;
            word-wrap: break-word !important;
            white-space: normal !important;
        }

        /* Mobile Responsive Fixes */
        .login-container {
            min-height: 100vh;
        }

        /* Mobile unified scroll */
        @media (max-width: 767.98px) {
            html, body {
                overflow-x: hidden !important;
                overflow-y: auto !important;
                height: auto !important;
                width: 100% !important;
            }
            
            .d-flex, .login-container {
                overflow: visible !important;
                height: auto !important;
                min-height: auto !important;
                width: 100% !important;
                flex-direction: column !important;
                display: flex !important;
            }
        }

        .form-column {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            min-height: 100vh;
        }

        .brand-column {
            background: linear-gradient(135deg, var(--inowey-primary) 0%, var(--inowey-accent) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }

        /* Mobile Styles */
        @media (max-width: 767.98px) {
            .login-container {
                flex-direction: column !important;
                min-height: auto !important;
                height: auto !important;
            }
            
            .brand-column {
                height: auto !important;
                min-height: auto !important;
                order: 1;
                width: 100% !important;
                overflow: visible !important;
                display: block !important;
                padding: 40px 20px !important;
                position: relative !important;
            }
            
            .form-column {
                height: auto !important;
                min-height: auto !important;
                order: 2;
                padding: 40px 20px 60px 20px !important;
                display: block !important;
                width: 100% !important;
                overflow: visible !important;
                position: relative !important;
            }
            
            .form-column .container-fluid {
                width: 100% !important;
                max-width: 100% !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
            }
            
            .form-column form {
                width: 100% !important;
                max-width: 100% !important;
            }
            
            .brand-content {
                width: 90% !important;
                max-width: 400px;
                padding: 0 20px !important;
                box-sizing: border-box;
            }
            
            .brand-content .btn {
                width: 100% !important;
                max-width: 280px !important;
                font-size: 14px !important;
                padding: 12px 16px !important;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            
            .brand-content h1 {
                font-size: 1.8rem !important;
            }
            
            .brand-content p {
                font-size: 0.9rem !important;
            }
            
            form {
                width: 100%;
                max-width: 400px;
            }
            
            .form-signin-heading {
                font-size: 1.5rem !important;
                text-align: center;
            }
        }

        /* Tablet Styles */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .brand-content {
                width: 80% !important;
            }
            
            .form-column {
                padding: 40px;
            }
        }

        /* Desktop Styles */
        @media (min-width: 992px) {
            .brand-content {
                width: 300px;
            }
        }
    </style>
</head>



<body>
    <div class="d-flex login-container">

        <div class="col-md-6 form-column">
            <div class="container-fluid" id="formContainer">

                            <!--login form-->



                            <form action="code.php" class="form-signin" id="login_form" method="post" accept-charset="utf-8">

                                <h3 class="form-signin-heading" style="color: var(--goprimehost-primary); font-size: 1.7em">Log In</h3>

                                <?php if (!empty($error_message)): ?>
                                    <div class="alert alert-danger" id="error-alert" style="margin-bottom: 20px; padding: 15px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; color: #721c24; position: relative;">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-triangle me-2" style="margin-right: 8px;"></i>
                                            <div style="flex: 1;">
                                                <strong>Access Denied</strong><br>
                                                <small><?php echo htmlspecialchars($error_message); ?></small>
                                            </div>
                                            <button type="button" class="btn-close" id="close-error-btn" style="background: none; border: none; color: #721c24; font-size: 18px; cursor: pointer; padding: 0; margin-left: 10px;" title="Close">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($already_logged_in): ?>
                                    <div class="alert alert-info" style="margin-bottom: 20px; padding: 15px; background-color: #d1ecf1; border: 1px solid #bee5eb; border-radius: 8px; color: #0c5460;">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2" style="margin-right: 8px;"></i>
                                            <div>
                                                <strong>Already Logged In</strong><br>
                                                <small>You are currently logged in as <strong><?php echo htmlspecialchars($user_name); ?></strong>. <a href="<?php 
                                                    // Role-based dashboard redirect with attendance support
                                                    $user_role = $_SESSION['auth_user']['user_role'] ?? '0';
                                                    $redirect = $_GET['redirect'] ?? '';
                                                    
                                                    switch ($user_role) {
                                                        case '1': // Admin
                                                            echo '../admin/index.php';
                                                            break;
                                                        case '2': // Lecturer
                                                            echo '../instructor/index.php';
                                                            break;
                                                        case '0': // Student
                                                        default:
                                                            if ($redirect === 'attendance') {
                                                                echo '../student_portal/my-attendance.php';
                                                            } else {
                                                                echo '../student_portal/index.php';
                                                            }
                                                            break;
                                                    }
                                                ?>" style="color: #0c5460; text-decoration: underline;">Go to Dashboard</a> or logout first to login as a different user.</small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <p style="margin-bottom: 25px; font-size: 14.5px" class="text-muted">Welcome back! Kindly login to your account to access your orders and continue shopping.</p>

                                <!-- Inline notification area -->
                                <div id="inline-notification" style="display: none; margin-bottom: 20px; padding: 12px; border-radius: 6px; font-size: 14px; font-weight: 500;">
                                </div>

                                <div class="form-group">
                                    <label for="username" class="form-label">Email Address </label>
                                    <input type="text" class="form-control" size="20" name="username_email" placeholder="Enter your email address" required="">

                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label">Password </label>
                                    <input type="password" class="form-control" size="20" name="password" placeholder="Enter your password" required="">
                                </div>
                                <div style="margin-bottom: 20px;">
                                    <div>
                                        <a href="reset.php">Forgot Password?</a> |
                                        <a href="resend-verification.php">Resend Verification</a>
                                    </div>
                                </div>
                                

                                <div class="d-grid">
                                    <button class="btn btn-block btn-purple" id="loginButton" name="login_btn" style="margin-top:1em;" type="submit">TAKE ME IN <span class="fa fa-long-arrow-right"></span></button>
                                </div>


                            </form>
                        </td>


                <div class="text-center text-muted mt-4" style="font-size: 12.5px;"> GoprimeHost Ke 2025 • Powered by <a style="color: var(--inowey-primary)" href="https://www.goprimehost.com" target="_blank">GoprimeHost Ke</a></div>
            </div>
        </div>

        <div class="col-md-6 brand-column">
            <!-- Geometric Shapes -->
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.2); border-radius: 50%; z-index: 1;"></div>
            <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.15); transform: rotate(45deg); z-index: 1;"></div>
            <div style="position: absolute; top: 20%; left: 10%; width: 80px; height: 80px; background: rgba(255,255,255,0.12); border-radius: 20px; transform: rotate(30deg); z-index: 1;"></div>
            <div style="position: absolute; bottom: 30%; right: 15%; width: 60px; height: 60px; background: rgba(255,255,255,0.18); border-radius: 50%; z-index: 1;"></div>
            <div style="position: absolute; top: 50%; left: 5%; width: 40px; height: 40px; background: rgba(255,255,255,0.1); transform: rotate(60deg); z-index: 1;"></div>
            <div style="position: absolute; top: 60%; right: 8%; width: 100px; height: 100px; background: rgba(255,255,255,0.08); border-radius: 30px; transform: rotate(-20deg); z-index: 1;"></div>

            <div class="brand-content" style="position: relative; width: 90%; max-width: 350px; color: white; z-index: 10; text-align: center; padding: 0 20px; box-sizing: border-box; margin: 0 auto;">
                <h1>Ecommerce Shop</h1>
                <p class="" style="margin-bottom: 4px">Your Shopping Portal</p>
                <hr style="opacity:.2">
                <p>Access your account to view orders, manage your profile, and continue shopping with exclusive member benefits.</p>
                <p>*Shop Smart, Save More.*</p>

                <div style="margin-top: 2em">
                    <p>Don't have an account? </p>
                    <a class="btn btn-warning" href="register.php"> Sign Up → <span class="fi fi-sr-interactive"></span></a>
                </div>
            </div>

        </div>

    </div>




    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <!-- Device Fingerprinting -->
    <script src="../assets/js/device-fingerprint.js"></script>


    <!-- ALERT MESSAGE HERE -->

    <!-- email verification and account activation -->


    <script type="text/javascript">
        $(document).ready(function() {

            // Handle email verification status messages
            const urlParams = new URLSearchParams(window.location.search);
            const verified = urlParams.get('verified');

            if (verified === 'success') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Email Verified Successfully!',
                    text: 'You can now login to your account.',
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true,
                    width: 'auto',
                    padding: '0.1em',
                    background: 'white',
                    customClass: {
                        popup: 'small-swal'
                    }
                });
            } else if (verified === 'error') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Email Verification Failed',
                    text: 'Please try clicking the verification link again.',
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true,
                    width: 'auto',
                    padding: '0.1em',
                    background: 'white',
                    customClass: {
                        popup: 'small-swal'
                    }
                });
            } else if (verified === 'already') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'info',
                    title: 'Email Already Verified',
                    text: 'You can now login to your account.',
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true,
                    width: 'auto',
                    padding: '0.1em',
                    background: 'white',
                    customClass: {
                        popup: 'small-swal'
                    }
                });
            } else if (verified === 'invalid') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Invalid Token',
                    text: 'Please try clicking the verification link again.',
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true,
                    width: 'auto',
                    padding: '0.1em',
                    background: 'white',
                    customClass: {
                        popup: 'small-swal'
                    }
                });
            } else if (verified === 'denied') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Access Denied',
                    text: 'You are not allowed to access that page.',
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true,
                    width: 'auto',
                    padding: '0.1em',
                    background: 'white',
                    customClass: {
                        popup: 'small-swal'
                    }
                });
            }

            $("#login_form input:first").focus();

            // Function to show inline notification
            function showInlineNotification(message, type, duration = 8000) {
                var inlineNotification = $('#inline-notification');
                var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
                var bgColor = type === 'success' ? '#d4edda' : '#f8d7da';
                var textColor = type === 'success' ? '#155724' : '#721c24';
                var borderColor = type === 'success' ? '#c3e6cb' : '#f5c6cb';
                
                inlineNotification
                    .html(message)
                    .css({
                        'background-color': bgColor,
                        'color': textColor,
                        'border': '1px solid ' + borderColor,
                        'display': 'block'
                    })
                    .addClass('alert ' + alertClass)
                    .slideDown();
                
                setTimeout(function() {
                    inlineNotification.slideUp(function() {
                        $(this).removeClass('alert alert-success alert-danger').html('').css('display', 'none');
                    });
                }, duration);
            }

            // Function to submit device access request
            function submitDeviceAccessRequest(deviceInfo, reason, username, password) {
                // Use provided credentials instead of reading from form
                
                $.ajax({
                    url: 'ajax/submit-device-request.php',
                    method: 'POST',
                    data: {
                        username_email: username,
                        password: password,
                        device_fingerprint: deviceInfo.fingerprint,
                        device_info: JSON.stringify(deviceInfo),
                        request_reason: reason || ''
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Request Submitted',
                                text: 'Your device access request has been submitted. An admin will review it shortly.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Request Failed',
                                text: response.message || 'Failed to submit device access request.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Request Failed',
                            text: 'Failed to submit device access request. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }

            // Generate device fingerprint (available globally)
            var deviceInfo = window.deviceFingerprint.getCompleteDeviceInfo();

            // Store credentials globally for device requests
            var currentUsername = '';
            var currentPassword = '';

            // Handle login form submission with dual notifications
            $('#login_form').submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();
                var loginButton = $('#loginButton');
                
                // Capture credentials for device requests
                currentUsername = $('input[name="username_email"]').val();
                currentPassword = $('input[name="password"]').val();
                
                var deviceData = '&device_fingerprint=' + encodeURIComponent(deviceInfo.fingerprint) + 
                                '&device_info=' + encodeURIComponent(JSON.stringify(deviceInfo));

                // Show loading state
                var originalText = loginButton.html();
                loginButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Please wait...');

                $.ajax({
                    url: 'code.php',
                    method: 'POST',
                    data: formData + '&login_btn=1' + deviceData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // SweetAlert notification - short duration
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Login Successful!',
                                showConfirmButton: false,
                                timer: 1500,
                                toast: true,
                                width: 'auto',
                                padding: '0.1em',
                                background: 'white',
                                customClass: {
                                    popup: 'small-swal'
                                }
                            }).then(() => {
                                // Redirect based on user role or response
                                if (response.redirect) {
                                    window.location.href = response.redirect;
                                } else {
                                    // Fallback to home page if no redirect specified
                                    window.location.href = '../index.php';
                                }
                            });

                            // Inline notification - longer duration with full message
                            showInlineNotification(response.message || 'Login successful!', 'success', 8000);
                        } else {
                            // Check if it's a device access issue
                            if (response.requires_device && response.message && response.message.includes('already registered to another device')) {
                                // Use stored credentials instead of reading from form
                                const username = currentUsername;
                                const password = currentPassword;
                                
                                // Show device access request dialog
                                Swal.fire({
                                    title: 'Device Access Required',
                                    html: `
                                        <p>${response.message}</p>
                                        <p>Please provide a reason for requesting access to this device:</p>
                                        <div class="mt-3">
                                            <textarea id="requestReason" class="form-control" placeholder="Please explain why you need access to this device (10-200 characters)" rows="3" required></textarea>
                                            <small class="text-muted">Reason is required and must be between 10-200 characters</small>
                                        </div>
                                    `,
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Request Access',
                                    cancelButtonText: 'Cancel',
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    allowOutsideClick: false,
                                    preConfirm: () => {
                                        const reason = document.getElementById('requestReason').value.trim();
                                        
                                        // Validate reason length
                                        if (!reason) {
                                            Swal.showValidationMessage('Please provide a reason for your request');
                                            return false;
                                        }
                                        
                                        if (reason.length < 10) {
                                            Swal.showValidationMessage('Reason must be at least 10 characters long');
                                            return false;
                                        }
                                        
                                        if (reason.length > 200) {
                                            Swal.showValidationMessage('Reason must not exceed 200 characters');
                                            return false;
                                        }
                                        
                                        return { reason: reason };
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        // Submit device access request with credentials
                                        submitDeviceAccessRequest(deviceInfo, result.value.reason, username, password);
                                    }
                                });
                            } else {
                                // Regular error notification
                                Swal.fire({
                                    position: 'top-right',
                                    icon: 'error',
                                    title: 'Login Failed!',
                                    showConfirmButton: false,
                                    timer: 1500,
                                    toast: true,
                                    width: 'auto',
                                    padding: '0.8em',
                                    background: 'white',
                                    customClass: {
                                        popup: 'small-swal'
                                    }
                                });

                                // Inline notification - longer duration with full error message
                                showInlineNotification(response.message || 'Login failed!', 'error', 8000);
                            }
                        }
                        // Reset button to original state
                        loginButton.prop('disabled', false).html(originalText);
                    },
                    error: function(xhr, status, error) {
                        // SweetAlert notification - short duration
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Connection Error!',
                            showConfirmButton: false,
                            timer: 1500,
                            toast: true,
                            width: 'auto',
                            padding: '0.1em',
                            background: 'white',
                            customClass: {
                                popup: 'small-swal'
                            }
                        });

                        // Inline notification - longer duration with full error message
                        showInlineNotification('Connection error! Please try again.', 'error', 8000);
                        
                        // Reset button to original state on error
                        loginButton.prop('disabled', false).html(originalText);
                    }
                });
            });

            $('#forgot_password_form').submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $('#forgot-password-btn').prop('disabled', true);

                $.ajax({
                    url: '../admin/code.php',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2000,
                                toast: true,
                                width: 'auto',
                                padding: '0.1em',
                                background: 'white',
                                customClass: {
                                    popup: 'small-swal'
                                }
                            });
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2000,
                                toast: true,
                                width: 'auto',
                                padding: '0.1em',
                                background: 'white',
                                customClass: {
                                    popup: 'small-swal'
                                }
                            });
                        }
                        $('#forgot-password-btn').prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error! Email doesn\'t Exist. please contact support for assistance',
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true,
                            width: 'auto',
                            padding: '0.1em',
                            background: 'white',
                            customClass: {
                                popup: 'small-swal'
                            }
                        });
                        $('#forgot-password-btn').prop('disabled', false);
                    }
                });



            });

            $('#change_password_form').submit(function(event) {
                event.preventDefault();

                if ($('input[name="password"]').val() !== $('input[name="conf_password"]').val()) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Passwords do not match, please try again!',
                        showConfirmButton: false,
                        timer: 2000,
                        toast: true,
                        width: 'auto',
                        padding: '0.1em',
                        background: 'white',
                        customClass: {
                            popup: 'small-swal'
                        }
                    });
                    return;
                }

                var formData = $(this).serialize();


                $('#change-password-btn').prop('disabled', true);

                $.ajax({
                    url: '../admin/code.php',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2000,
                                toast: true,
                                width: 'auto',
                                padding: '0.1em',
                                background: 'white',
                                customClass: {
                                    popup: 'small-swal'
                                }
                            }).then(() => {
                                window.location.href = "login.php";
                            });
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2000,
                                toast: true,
                                width: 'auto',
                                padding: '0.1em',
                                background: 'white',
                                customClass: {
                                    popup: 'small-swal'
                                }
                            });
                        }
                        $('#change-password-btn').prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error sending the activation link, please contact support for assistance',
                            showConfirmButton: false,
                            timer: 2000,
                            toast: true,
                            width: 'auto',
                            padding: '0.1em',
                            background: 'white',
                            customClass: {
                                popup: 'small-swal'
                            }
                        });
                        $('#change-password-btn').prop('disabled', false);
                    }
                });


            });
        });

        $('#openPasswordResetBtn').click(function() {
            // Hide existing form
            $('#login_form').hide();

            // Show resetpassword form
            $('#forgot_password_form').show();
        });
    </script>

    <?php
    if (isset($_SESSION['message'])) {
        $icon = in_array($_SESSION['messageType'], ['success', 'error', 'info'])
            ? $_SESSION['messageType']
            : 'info'; // Default to info if unknown
    ?>
        <script>
            Swal.fire({
                position: 'top-end',
                icon: '<?php echo $icon; ?>', // Can now be success, error, or info
                title: '<?php echo $_SESSION['message']; ?>',
                showConfirmButton: false,
                timer: 3000,
                toast: true,
                width: 'auto',
                padding: '0.1em',
                background: 'white',
                customClass: {
                    popup: 'small-swal'
                }
            });
        </script>
    <?php
        unset($_SESSION['message']);
        unset($_SESSION['messageType']);
    }
    ?>

    <style>
        .small-swal {
            font-size: 14px !important;
        }
    </style>

    <script>
    // Auto-dismiss error messages
    document.addEventListener('DOMContentLoaded', function() {
        const errorAlert = document.getElementById('error-alert');
        const closeBtn = document.getElementById('close-error-btn');
        
        if (errorAlert) {
            // Function to hide the alert and clean URL
            function hideAlert() {
                errorAlert.style.transition = 'opacity 0.5s ease-out';
                errorAlert.style.opacity = '0';
                setTimeout(function() {
                    errorAlert.style.display = 'none';
                    // Clean the URL by removing error parameters
                    cleanUrl();
                }, 500);
            }
            
            // Function to clean URL parameters
            function cleanUrl() {
                const url = new URL(window.location);
                url.searchParams.delete('error');
                // Replace the current URL without reloading the page
                window.history.replaceState({}, document.title, url.pathname + url.search);
            }
            
            // Auto-dismiss after 8 seconds
            setTimeout(hideAlert, 8000);
            
            // Manual close button
            if (closeBtn) {
                closeBtn.addEventListener('click', hideAlert);
            }
        }
    });

    </script>
</body>

</html>