<?php
session_start();

// Check if user has pending 2FA verification
if (!isset($_SESSION['twofa_pending'])) {
    header('Location: login.php');
    exit();
}

$twofa_data = $_SESSION['twofa_pending'];
$user_email = $twofa_data['user_data']['email'];
$masked_email = substr($user_email, 0, 2) . '***' . substr($user_email, strpos($user_email, '@'));

// Check if 2FA code has expired
if (time() > $twofa_data['expires']) {
    unset($_SESSION['twofa_pending']);
    header('Location: login.php?expired=1');
    exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="shortcut icon" href="../assets/img/logo.png">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <script src="js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Two-Factor Authentication - Inowey College </title>

    <style>
        form {
            margin: auto;
            min-width: 250px;
            max-width: 400px;
            border: none
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
            background-color: var(--goprimehost-primary) !important;
            border-color: var(--goprimehost-primary) !important;
            color: white !important;
        }

        .btn-purple:hover {
            background-color: var(--goprimehost-secondary) !important;
            border-color: var(--goprimehost-secondary) !important;
            color: white !important;
        }

        .form-signin-heading {
            color: var(--goprimehost-primary) !important;
        }

        .text-muted a {
            color: var(--goprimehost-primary) !important;
        }

        .text-muted a:hover {
            color: var(--goprimehost-secondary) !important;
        }

        /* 2FA Code Input Styling */
        .twofa-code-input {
            font-size: 24px;
            letter-spacing: 8px;
            text-align: center;
            font-family: monospace;
            font-weight: bold;
            color: var(--goprimehost-primary);
        }

        .security-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            color: #856404;
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
    </style>
</head>

<body>
    <div class="d-flex">
        <div class="col-md-6">
            <table style="height: 100vh; width: 100%;">
                <tbody>
                    <tr>
                        <td class="container-fluid" id="formContainer">
                            <form action="code.php" class="form-signin" id="twofa_form" method="post" accept-charset="utf-8">
                                <h3 class="form-signin-heading" style="color: var(--goprimehost-primary); font-size: 1.7em;">Two-Factor Authentication</h3>

                                <p style="margin-bottom: 25px; font-size: 14.5px" class="text-muted">
                                    We've sent a 6-digit verification code to <strong><?php echo htmlspecialchars($masked_email); ?></strong>. Please enter the code below to complete your login.
                                </p>

                                <div class="form-group">
                                    <label for="twofa_code" class="form-label">Verification Code</label>
                                    <input type="text" class="form-control twofa-code-input" name="twofa_code" id="twofa_code" placeholder="000000" maxlength="6" required autocomplete="off">
                                </div>

                                <div class="security-notice">
                                    <strong>⚠️ Security Notice:</strong> This code expires in 5 minutes. Enter the code exactly as received.
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-block btn-purple" id="verifyButton" name="verify_2fa_btn" style="margin-top:1em;" type="submit">
                                        VERIFY CODE <i class="fa fa-shield-alt"></i>
                                    </button>
                                </div>

                                <div style="margin-bottom: 20px; margin-top: 20px;">
                                    <div>
                                        <a href="login.php">← Back to Login</a> |
                                        <a href="#" id="resendCode">Resend Code</a>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-6" style="height: 100vh; margin: 0px; background: linear-gradient(135deg, var(--goprimehost-primary) 0%, var(--goprimehost-secondary) 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden;">
            <!-- Geometric Shapes -->
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.2); border-radius: 50%; z-index: 1;"></div>
            <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.15); transform: rotate(45deg); z-index: 1;"></div>
            <div style="position: absolute; top: 20%; left: 10%; width: 80px; height: 80px; background: rgba(255,255,255,0.12); border-radius: 20px; transform: rotate(30deg); z-index: 1;"></div>
            <div style="position: absolute; bottom: 30%; right: 15%; width: 60px; height: 60px; background: rgba(255,255,255,0.18); border-radius: 50%; z-index: 1;"></div>
            <div style="position: absolute; top: 50%; left: 5%; width: 40px; height: 40px; background: rgba(255,255,255,0.1); transform: rotate(60deg); z-index: 1;"></div>
            <div style="position: absolute; top: 60%; right: 8%; width: 100px; height: 100px; background: rgba(255,255,255,0.08); border-radius: 30px; transform: rotate(-20deg); z-index: 1;"></div>

            <div style="position: absolute; width: 300px; color: white; z-index: 10; text-align: center;">
                <h1>Secure Login</h1>
                <p class="" style="margin-bottom: 4px">Two-Factor Authentication</p>
                <hr style="opacity:.2">
                <p>Two-factor authentication adds an extra layer of security to your account by requiring a verification code sent to your email.</p>
                <p><i class="fas fa-shield-alt" style="font-size: 48px; margin-top: 20px;"></i></p>
            </div>
        </div>
    </div>

    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // Auto-focus on code input
            $('#twofa_code').focus();

            // Format input as user types (add spaces for readability)
            $('#twofa_code').on('input', function() {
                let value = $(this).val().replace(/\D/g, ''); // Remove non-digits
                if (value.length > 6) value = value.substr(0, 6); // Limit to 6 digits
                $(this).val(value);
            });

            // Handle 2FA form submission
            $('#twofa_form').submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();
                var verifyButton = $('#verifyButton');
                var originalText = 'VERIFY CODE';

                // Function to reset button state
                function resetButton() {
                    verifyButton.prop('disabled', false);
                    verifyButton.empty().text('VERIFY CODE ').append('<i class="fa fa-shield-alt"></i>');
                }

                // Show loading state - first "Please wait" then "Verifying"
                verifyButton.prop('disabled', true).html('Please wait...');
                
                // After a brief moment, change to "Verifying..."
                setTimeout(function() {
                    verifyButton.html('<i class="fa fa-spinner fa-spin"></i> Verifying...');
                }, 300);

                // Safety timeout to reset button if request takes too long (15 seconds)
                var safetyTimeout = setTimeout(function() {
                    resetButton();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Request timeout. Please try again.',
                        showConfirmButton: false,
                        timer: 3000,
                        toast: true,
                        customClass: {
                            popup: 'small-swal'
                        }
                    });
                }, 15000);

                $.ajax({
                    url: 'code.php',
                    method: 'POST',
                    data: formData + '&verify_2fa_btn=1',
                    dataType: 'json',
                    timeout: 10000, // 10 second timeout
                    success: function(response) {
                        clearTimeout(safetyTimeout);
                        
                        if (response.success) {
                            // Keep button in loading state during redirect
                            verifyButton.html('<i class="fa fa-spinner fa-spin"></i> Redirecting...');
                            
                            // Show success message briefly
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Verification successful!',
                                showConfirmButton: false,
                                timer: 1000,
                                toast: true,
                                width: 'auto',
                                padding: '0.5em',
                                background: 'white',
                                customClass: {
                                    popup: 'small-swal'
                                }
                            });
                            
                            // Auto redirect after brief delay
                            setTimeout(function() {
                                if (response.redirect) {
                                    window.location.href = response.redirect;
                                } else {
                                    // Fallback to home page if no redirect specified
                                    window.location.href = '../index.php';
                                }
                            }, 1000);
                        } else {
                            // Immediately reset button for failed attempts
                            resetButton();
                            
                            // Clear the input field for retry
                            $('#twofa_code').val('').focus();
                            
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.message || 'Verification failed!',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                customClass: {
                                    popup: 'small-swal'
                                }
                            }).then(() => {
                                // Check if redirect is needed (e.g., too many attempts)
                                if (response.redirect) {
                                    window.location.href = response.redirect;
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        clearTimeout(safetyTimeout);
                        resetButton();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Connection error! Please try again.',
                            showConfirmButton: false,
                            timer: 3000,
                            toast: true,
                            customClass: {
                                popup: 'small-swal'
                            }
                        });
                    }
                });
            });

            // Handle resend code
            $('#resendCode').click(function(e) {
                e.preventDefault();
                
                var resendButton = $(this);
                var originalText = resendButton.text();
                
                // Show "Please wait" state
                resendButton.text('Please wait...').css('pointer-events', 'none').css('color', '#999');
                
                $.ajax({
                    url: 'code.php',
                    method: 'POST',
                    data: 'resend_2fa_code=1',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'New code sent to your email!',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                customClass: {
                                    popup: 'small-swal'
                                }
                            });
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.message || 'Failed to resend code',
                                showConfirmButton: false,
                                timer: 3000,
                                toast: true,
                                customClass: {
                                    popup: 'small-swal'
                                }
                            });
                        }
                        
                        // Reset button state
                        resendButton.text(originalText).css('pointer-events', 'auto').css('color', '');
                    },
                    error: function() {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Connection error! Please try again.',
                            showConfirmButton: false,
                            timer: 3000,
                            toast: true,
                            customClass: {
                                popup: 'small-swal'
                            }
                        });
                        
                        // Reset button state
                        resendButton.text(originalText).css('pointer-events', 'auto').css('color', '');
                    }
                });
            });
        });
    </script>
</body>

</html>
