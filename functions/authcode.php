<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../admin/config/dbcon.php';

// Function to generate unique customer code
function generateCustomerCode($conn) {
    do {
        $code = 'CUST' . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $result = $conn->query("SELECT id FROM users WHERE customer_code = '$code'");
    } while ($result && $result->num_rows > 0);
    return $code;
}

if (isset($_POST['register'])) {
    // Validate required fields
    $requiredFields = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'street_address',
        'city',
        'postal_code',
        'password',
        'confirm_password'
    ];

    $emptyFields = [];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            $emptyFields[] = $field;
        }
    }

    if (!isset($_POST['agreed_to_terms'])) {
        $emptyFields[] = 'agreed_to_terms';
    }

    // Make profile picture optional instead of required
    // if (!isset($_FILES["profile_picture"]["tmp_name"]) || empty($_FILES["profile_picture"]["tmp_name"])) {
    //     $emptyFields[] = 'profile_picture';
    // }

    if (!empty($emptyFields)) {
        $_SESSION['message'] = "The following fields are required and must not be empty: " . implode(", ", $emptyFields);
        $_SESSION['messageType'] = "error";
        header('location: ../register.php');
        exit();
    }

    // Check if passwords match
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $_SESSION['message'] = "Passwords do not match. Please try again.";
        $_SESSION['messageType'] = "error";
        header('location: ../register.php');
        exit();
    }

    // Check if email already exists
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_email_query = "SELECT * FROM `users` WHERE `email`='$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        $_SESSION['message'] = "Email is already registered.";
        $_SESSION['messageType'] = "error";
        header('location: ../register.php');
        exit();
    }

    // File upload handling - make it optional
    $filename = ''; // Default empty filename
    $uploadOk = 1;
    
    if (isset($_FILES["profile_picture"]["tmp_name"]) && !empty($_FILES["profile_picture"]["tmp_name"])) {
        $targetDirectory = "../uploads/profile/";
        $targetFile = $targetDirectory . basename($_FILES["profile_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check === false) {
            $_SESSION['message'] = "File is not an image.";
            $_SESSION['messageType'] = "error";
            $uploadOk = 0;
        }

        if ($_FILES["profile_picture"]["size"] > 5000000) {
            $_SESSION['message'] = "Sorry, your file is too large.";
            $_SESSION['messageType'] = "error";
            $uploadOk = 0;
        }

        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedExtensions)) {
            $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $_SESSION['messageType'] = "error";
            $uploadOk = 0;
        }

        if ($uploadOk === 1) {
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                $filename = basename($_FILES["profile_picture"]["name"]);
            } else {
                $_SESSION['message'] = "Sorry, there was an error uploading your file.";
                $_SESSION['messageType'] = "error";
                header('location: ../register.php');
                exit();
            }
        } else {
            $_SESSION['message'] .= " Your file was not uploaded.";
            $_SESSION['messageType'] = "error";
            header('location: ../register.php');
            exit();
        }
    }

    // If we reach here, file upload was successful or no file was uploaded
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $street_address = mysqli_real_escape_string($conn, $_POST['street_address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
    $additional_info = isset($_POST['additional_info']) ? mysqli_real_escape_string($conn, $_POST['additional_info']) : '';
    $role_as = '0'; // Default role for regular users
    $agreed_to_terms = 1;
    
    // Generate unique customer code
    $customer_code = generateCustomerCode($conn);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $insert_query = "INSERT INTO `users` 
        (`customer_code`, `first_name`, `last_name`, `email`, `phone`, `street_address`, `city`, `postal_code`, `additional_info`, `password`, `role_as`, `profile_picture`, `agreed_to_terms`, `user_status`) 
        VALUES 
        ('$customer_code', '$first_name', '$last_name', '$email', '$phone', '$street_address', '$city', '$postal_code', '$additional_info', '$hashed_password', '$role_as', '$filename', '$agreed_to_terms', 'active')";

    if (mysqli_query($conn, $insert_query)) {
        $_SESSION['message'] = "Account created successfully! Your customer code is: " . $customer_code;
        $_SESSION['messageType'] = "success";
        header('location: ../login.php');
        exit();
    } else {
        $_SESSION['message'] = "Registration failed. Please try again.";
        $_SESSION['messageType'] = "error";
        header('location: ../register.php');
        exit();
    }
}
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate input
    if (empty($email) || empty($password)) {
        $_SESSION['message'] = "Please enter both email and password.";
        $_SESSION['messageType'] = "error";
        header('location: ../login.php');
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Please enter a valid email address.";
        $_SESSION['messageType'] = "error";
        header('location: ../login.php');
        exit();
    }

    // Fetch the user's data from the database
    $fetch_user_query = "SELECT * FROM `users` WHERE `email`='$email'";
    $fetch_user_result = mysqli_query($conn, $fetch_user_query);

    if ($fetch_user_result && $user_data = mysqli_fetch_assoc($fetch_user_result)) {
        // Check user status
        if ($user_data['user_status'] === 'inactive') {
            $_SESSION['message'] = "Your account is inactive. Please contact support for assistance.";
            $_SESSION['messageType'] = "error";
            header('location: ../login.php');
            exit();
        }

        if ($user_data['user_status'] === 'request_for_deletion') {
            $_SESSION['message'] = "Your account is marked for deletion. Please contact support for recovery.";
            $_SESSION['messageType'] = "error";
            header('location: ../login.php');
            exit();
        }

        // Verify the entered password with the stored hashed password
        if (password_verify($password, $user_data['password'])) {
            $_SESSION['auth'] = true;

            // User data to be stored in the session
            $user_id = $user_data['id'];
            $user_email = $user_data['email'];
            $user_first_name = $user_data['first_name'];
            $user_last_name = $user_data['last_name'];
            $user_display_name = $user_data['display_name'];
            $user_role = $user_data['role_as'];
            $user_phone = $user_data['phone'];
            $user_city = $user_data['city'];
            $user_street_address = $user_data['street_address'];
            $user_postal_code = $user_data['postal_code'];
            $user_additional_info = $user_data['additional_info'];
            $user_profile_picture = $user_data['profile_picture'];

            // Set session variables
            $_SESSION['auth_user'] = [
                'id' => $user_id,
                'email' => $user_email,
                'first_name' => $user_first_name,
                'last_name' => $user_last_name,
                'display_name' => $user_display_name,
                'phone' => $user_phone,
                'city' => $user_city,
                'street_address' => $user_street_address,
                'postal_code' => $user_postal_code,
                'additional_info' => $user_additional_info,
                'profile_picture' => $user_profile_picture
            ];

            $_SESSION['role_as'] = $user_role;

            // Now, update the cart for this user
            $session_id = session_id(); // Get the session ID of the user
            $update_cart_query = "
                UPDATE cart
                SET user_id = ?, email = ?
                WHERE session_id = ? AND user_id IS NULL"; // Only update items that have user_id = NULL
        
            if ($stmt = mysqli_prepare($conn, $update_cart_query)) {
                // Bind parameters to update cart with user data
                mysqli_stmt_bind_param($stmt, 'iss', $user_id, $user_email, $session_id);
                
                if (mysqli_stmt_execute($stmt)) {
                    // Optional: redirect or show success
                    // You could redirect to the cart page, or wherever you'd like after login
                    $_SESSION['message'] = "Cart updated with your details";
                    $_SESSION['messageType'] = "success";
                } else {
                    error_log("MySQL Error: " . mysqli_error($conn));
                }
        
                // Close prepared statement
                mysqli_stmt_close($stmt);
            } else {
                error_log("MySQL Prepare Error: " . mysqli_error($conn));
            }

            // Now, update the favorites for this user
            $update_favorite_query = "
            UPDATE favorite
            SET user_id = ?, email = ?
            WHERE session_id = ? AND user_id IS NULL"; // Only update items that have user_id = NULL

            if ($stmt_fav = mysqli_prepare($conn, $update_favorite_query)) {
                mysqli_stmt_bind_param($stmt_fav, 'iss', $user_id, $user_email, $session_id);
                
                if (!mysqli_stmt_execute($stmt_fav)) {
                    error_log("MySQL Error (favorite update): " . mysqli_error($conn));
                }
                mysqli_stmt_close($stmt_fav);
            } else {
                error_log("MySQL Prepare Error (favorite update): " . mysqli_error($conn));
            }

            // Redirect based on the role
            if ($user_role == '1') {
                $_SESSION['message'] = "Welcome to Admin dashboard";
                $_SESSION['messageType'] = "success";
                header('location: ../admin/index.php');
                exit();
            } elseif ($user_role == '2') {
                $_SESSION['message'] = "Welcome to Supplier dashboard";
                $_SESSION['messageType'] = "success";
                header('location: ../supplier/index.php');
                exit();
            } else {
                $_SESSION['message'] = "Welcome back, " . $user_first_name . "! You are now logged in.";
                $_SESSION['messageType'] = "success";
                header('location: ../index.php');
                exit();
            }
        } else {
            // Invalid password
            $_SESSION['message'] = "Incorrect password. Please check your password and try again.";
            $_SESSION['messageType'] = "error";
            header('location: ../login.php');
            exit();
        }
    } else {
        // User not found
        $_SESSION['message'] = "Email address not found. Please check your email or create a new account.";
        $_SESSION['messageType'] = "error";
        header('location: ../login.php');
        exit();
    }
}


//update account
if (isset($_POST['update_account_btn'])) {
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $street_address = $_POST['street_address'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $additional_info = $_POST['additional_info'];
    $role_as = $_POST['role_as'];


    $new_image = $_FILES['profile_picture']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {
        $update_filename = $new_image;
    } else {
        $update_filename = $old_image;
    }

    $update_query = "UPDATE `users` SET `first_name`='$first_name', `last_name`='$last_name', `email`='$email', `phone`='$phone', `street_address`='$street_address', `city`='$city', `postal_code`='$postal_code', `additional_info`='$additional_info', `role_as`='$role_as', `profile_picture`='$update_filename' WHERE `id`='$user_id'";

    $update_query_run = mysqli_query($conn, $update_query);

    if ($update_query_run) {
        if ($new_image != "") {
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], '../uploads/profile/' . $new_image);
            if ($old_image != "") {
                unlink('../uploads/profile/' . $old_image);
            }
        }
        $_SESSION['message'] = "Your account has been updated";
        $_SESSION['messageType'] = "success";
        header('location: ../profile.php');
    } else {
        $_SESSION['message'] = "Your account has not been updated";
        $_SESSION['messageType'] = "error";
        header('location: ../profile.php');
    }
}

//verify user email so that he can change password
if (isset($_POST['verify_user_email'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);

    $check_email_query = "SELECT * FROM `users` WHERE `email`='$email' AND `first_name`='$first_name'";
    $check_email_result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        $_SESSION['message'] = "Email and first name are verified";
        $_SESSION['messageType'] = "success";
        $_SESSION['email'] = $email;
        header('location: ../reset_password.php');
    } else {
        // Check if the email exists but first name doesn't match
        $check_email_only_query = "SELECT * FROM `users` WHERE `email`='$email'";
        $check_email_only_result = mysqli_query($conn, $check_email_only_query);

        if (mysqli_num_rows($check_email_only_result) > 0) {
            $_SESSION['message'] = "First name is incorrect";
        } else {
            $_SESSION['message'] = "Email is not verified";
        }

        $_SESSION['messageType'] = "error";
        header('location: ../reset.php');
    }
}

//updte the user password after verification
if (isset($_POST['update_user_password'])) {
    // Check if the session variables are set (verification)
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // Retrieve the new password and confirm new password from the form
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
        $confirm_new_password = mysqli_real_escape_string($conn, $_POST['confirm_new_password']);

        // Check if the passwords match
        if ($new_password === $confirm_new_password) {
            // Hash the new password before updating
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the user's password in the database
            $update_password_query = "UPDATE `users` SET `password`='$hashed_password' WHERE `email`='$email'";
            $update_password_result = mysqli_query($conn, $update_password_query);

            if ($update_password_result) {
                // Password updated successfully
                $_SESSION['message'] = "Password updated successfully";
                $_SESSION['messageType'] = "success";
                // Clear the email session variable
                unset($_SESSION['email']);
                header('location: ../login.php'); // Redirect to login page or any other appropriate page
                exit();
            } else {
                // Failed to update password
                $_SESSION['message'] = "Failed to update password";
                $_SESSION['messageType'] = "error";
                header('location: ../reset_password.php');
                exit();
            }
        } else {
            // Passwords don't match
            $_SESSION['message'] = "Passwords do not match";
            $_SESSION['messageType'] = "error";
            header('location: ../reset_password.php');
            exit();
        }
    } else {
        // Session variables not set (verification not done)
        $_SESSION['message'] = "Email verification not done";
        $_SESSION['messageType'] = "error";
        header('location: ../reset.php');
        exit();
    }
}
