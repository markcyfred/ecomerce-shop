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

    <title>Resend Email Verification - Inowey College </title>

    <style>
        form {
            margin: auto;
            min-width: 250px;
            max-width: 350px;
            border: none
        }
        
        /* Inowey College Color Scheme */
        :root {
            --inowey-primary: #0068D9;
            --inowey-secondary: #0496FF;
            --inowey-accent: #00305c;
            --goprimehost-light: #f5f5ff;
            --goprimehost-dark: #1f1346;
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
        .verification-container {
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

        /* Mobile Styles */
        @media (max-width: 767.98px) {
            .verification-container {
                flex-direction: column !important;
            }
            
            .brand-column {
                min-height: 40vh;
                order: 1;
            }
            
            .form-column {
                min-height: 60vh;
                order: 2;
                padding: 30px 20px;
            }
            
            .brand-content {
                width: 90% !important;
                max-width: 400px;
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
    <div class="d-flex verification-container">

        <div class="col-md-6 form-column">
            <div class="container-fluid" id="formContainer">

                        <form action="code.php" class="form-signin" id="resend_form" method="post" accept-charset="utf-8">

                            <h3 class="form-signin-heading" style="color: var(--goprimehost-primary); font-size: 1.7em">Resend Email Verification</h3>

                            <p style="margin-bottom: 25px; font-size: 14.5px" class="text-muted">Enter your email address to resend the verification link.</p>

                            <div class="form-group">
                                <label for="email" class="form-label">Email Address </label>
                                <input type="email" class="form-control" size="20" name="email" id="email" placeholder="Enter your email address" required="">

                            </div>

                            <div style="margin-bottom: 20px;">
                                <div>
                                    <a href="login.php">Back to Login</a> | 
                                    <a href="register.php">Create New Account</a>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button class="btn btn-block btn-purple" id="resendButton" name="resend_email_verify_btn" style="margin-top:1em;" type="submit">RESEND VERIFICATION <span class="fa fa-envelope"></span></button>
                            </div>

                        </form>
                        
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
            
            <div class="brand-content" style="position: absolute; width: 300px; color: white; z-index: 10; text-align: center;">
                <h1>Email Verification</h1>
                <p class="" style="margin-bottom: 4px">Verify Your Account</p>
                <hr style="opacity:.2">
                <p>Resend your email verification link to access all Inowey College services and features.</p>
                <p>*Secure your account today.*</p>

                <div style="margin-top: 2em">
                    <p>Don't have an account? </p>
                    <a class="btn btn-warning" href="register.php"> SignUp for Free → <span class="fi fi-sr-interactive"></span></a>
                </div>
            </div>

        </div>

    </div>

    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            
            $("#resend_form input:first").focus();

            // Handle resend form submission with SweetAlert
            $('#resend_form').submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();
                var resendButton = $('#resendButton');

                // Show loading state
                resendButton.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Sending...');

                $.ajax({
                    url: 'code.php',
                    method: 'POST',
                    data: formData + '&resend_email_verify_btn=1',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
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
                            // Clear the form
                            $('#email').val('');
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.message || 'Failed to send verification email!',
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
                        resendButton.prop('disabled', false).html('RESEND VERIFICATION <span class="fa fa-envelope"></span>');
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error sending verification email, please try again',
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
                        resendButton.prop('disabled', false).html('RESEND VERIFICATION <span class="fa fa-envelope"></span>');
                    }
                });
            });
        });
    </script>
</body>
</html>
