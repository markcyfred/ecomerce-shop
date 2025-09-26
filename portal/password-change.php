<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="shortcut icon" href="../assets/img/logo.png">


    <link href="css/bootstrap.min.css" rel="stylesheet">
    
   

    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <script src="js/sweetalert2.all.min.js"></script>


    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Change Password - Inowey College </title>

<style>
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    form {
        margin: auto;
        min-width: 250px;
        max-width: 350px;
        border: none;
    }
    
    /* Inowey College Color Scheme */
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
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-purple:hover {
        background-color: var(--inowey-accent) !important;
        border-color: var(--inowey-accent) !important;
        color: white !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 48, 92, 0.3);
    }
    
    .form-signin-heading {
        color: var(--inowey-primary) !important;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .text-muted a {
        color: var(--inowey-primary) !important;
        text-decoration: none;
        font-weight: 500;
    }
    
    .text-muted a:hover {
        color: var(--inowey-accent) !important;
        text-decoration: underline;
    }
    
    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 10;
    }
    
    .password-field-container {
        position: relative;
    }
    
    
    .container-fluid {
        padding: 20px;
    }
    
    /* Mobile Responsive Fixes */
    .login-container {
        min-height: 100vh;
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
        
        .col-md-6 {
            width: 100% !important;
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }
        
        /* Force mobile layout */
        .login-container > .col-md-6 {
            display: block !important;
            float: none !important;
            width: 100% !important;
        }
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
</style></head>

<body>
    <div class="d-flex login-container">

        <div class="col-md-6 form-column">
            <div class="container-fluid" id="formContainer">

                <form action="code.php" class="form-signin" id="password_change_form" method="post" accept-charset="utf-8">
                    <input type="hidden" name="password_change_token" value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token']) : ''; ?>">
                    <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">

                    <h3 class="form-signin-heading" style="color: var(--inowey-primary); font-size: 1.7em">Change Password</h3>

                    <p style="margin-bottom: 25px; font-size: 14.5px" class="text-muted">Enter your new password below</p>

                    <div class="form-group">
                        <label for="email_display" class="form-label">Email Address </label>
                        <input type="email" class="form-control" size="20" id="email_display" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>" readonly>

                    </div>

                    <div class="form-group">
                        <label for="new_password" class="form-label">New Password </label>
                        <div class="password-field-container">
                            <input type="password" class="form-control" size="20" id="new_password" name="new_password" placeholder="Enter your new password" required="">
                            <i class="fa fa-eye password-toggle" onclick="togglePassword('new_password', this)"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm Password </label>
                        <div class="password-field-container">
                            <input type="password" class="form-control" size="20" id="confirm_password" name="confirm_password" placeholder="Confirm your new password" required="">
                            <i class="fa fa-eye password-toggle" onclick="togglePassword('confirm_password', this)"></i>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <div>
                            <a href="login.php">Remember your password?</a>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-block btn-purple" id="changePasswordButton" name="password_update" style="margin-top:1em;" type="submit">UPDATE PASSWORD <span class="fa fa-key"></span></button>
                    </div>

                </form>

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
                <h1>Secure Password Update</h1>
                <p class="" style="margin-bottom: 4px">Your Security Matters</p>
                <hr style="opacity:.2">
                <p>Choose a strong password with at least 8 characters, including uppercase, lowercase, numbers, and special characters.</p>
                <p>*Your data is always protected.*</p>

                <div style="margin-top: 2em">
                    <p>Need help? </p>
                    <a class="btn btn-warning" href="mailto:support@inoweycollege.com"> Contact Support → <span class="fi fi-sr-interactive"></span></a>
                </div>
            </div>

        </div>

    </div>




<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#new_password").focus();

            // Handle password change form submission with SweetAlert
            $('#password_change_form').submit(function(event) {
                event.preventDefault();

                var newPassword = $('#new_password').val();
                var confirmPassword = $('#confirm_password').val();
                
                // Client-side validation
                if (newPassword.length < 6) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Password Too Short',
                        text: 'Password must be at least 6 characters long.',
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
                    return;
                }
                
                // Check for weak passwords
                var weakPasswords = ['123456', '123456789', 'password', 'qwerty', '111111', '123123', 'admin', 'letmein', 'welcome'];
                if (weakPasswords.includes(newPassword.toLowerCase())) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Weak Password',
                        text: 'This password is too common and not secure. Please choose a stronger password.',
                        showConfirmButton: false,
                        timer: 4000,
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

                if (newPassword !== confirmPassword) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Passwords Don\'t Match',
                        text: 'Please ensure both password fields match.',
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
                    return;
                }

                var formData = $(this).serialize() + '&password_update=1';
                var changePasswordButton = $('#changePasswordButton');

                // Show loading state
                changePasswordButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Updating...');

                $.ajax({
                    url: 'code.php',
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Password Updated!',
                                text: response.message || 'Your password has been updated successfully.',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                width: 'auto',
                                padding: '0.1em',
                                background: 'white',
                                customClass: {
                                    popup: 'small-swal'
                                }
                            }).then(() => {
                                // Redirect to login page
                                window.location.href = "login.php";
                            });
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Update Failed',
                                text: response.message || 'Failed to update password. Please try again.',
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
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Connection Error',
                            text: 'Unable to process request. Please try again.',
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
                    },
                    complete: function() {
                        // Reset button state
                        changePasswordButton.prop('disabled', false).html('UPDATE PASSWORD <span class="fa fa-key"></span>');
                    }
                });
            });
        });

        // Function to toggle password visibility
        function togglePassword(fieldId, icon) {
            var field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                field.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
