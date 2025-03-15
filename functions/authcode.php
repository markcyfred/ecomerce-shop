<?php
session_start();
include '../admin/config/dbcon.php';

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

    if (!isset($_FILES["profile_picture"]["tmp_name"]) || empty($_FILES["profile_picture"]["tmp_name"])) {
        $emptyFields[] = 'profile_picture';
    }

    if (!empty($emptyFields)) {
        $_SESSION['message'] = "The following fields are required and must not be empty: " . implode(", ", $emptyFields);
        header('location: ../register.php');
        exit();
    }

    // Check if passwords match
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $_SESSION['message'] = "Passwords do not match. Please try again.";
        header('location: ../register.php');
        exit();
    }

    // Check if email already exists
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_email_query = "SELECT * FROM `users` WHERE `email`='$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        $_SESSION['message'] = "Email is already registered.";
        header('location: ../register.php');
        exit();
    }

    // File upload handling
    $targetDirectory = "../uploads/profile/";
    $targetFile = $targetDirectory . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['message'] = "File is not an image.";
        $uploadOk = 0;
    }

    if ($_FILES["profile_picture"]["size"] > 5000000) {
        $_SESSION['message'] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedExtensions)) {
        $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk === 1) {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
            $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
            $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $street_address = mysqli_real_escape_string($conn, $_POST['street_address']);
            $city = mysqli_real_escape_string($conn, $_POST['city']);
            $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
            $additional_info = mysqli_real_escape_string($conn, $_POST['additional_info']);
            $role_as = mysqli_real_escape_string($conn, $_POST['role_as']);
            $agreed_to_terms = 1;

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $filename = basename($_FILES["profile_picture"]["name"]);

            $insert_query = "INSERT INTO `users` 
                (`first_name`, `last_name`, `email`, `phone`, `street_address`, `city`, `postal_code`, `additional_info`, `password`, `role_as`, `profile_picture`, `agreed_to_terms`) 
                VALUES 
                ('$first_name', '$last_name', '$email', '$phone', '$street_address', '$city', '$postal_code', '$additional_info', '$hashed_password', '$role_as', '$filename', '$agreed_to_terms')";

            if (mysqli_query($conn, $insert_query)) {
                $_SESSION['message'] = "You are now registered.";
                header('location: ../login.php');
                exit();
            } else {
                $_SESSION['message'] = "Registration failed. Please try again.";
                header('location: ../register.php');
                exit();
            }
        } else {
            $_SESSION['message'] = "Sorry, there was an error uploading your file.";
            header('location: ../register.php');
            exit();
        }
    } else {
        $_SESSION['message'] .= " Your file was not uploaded.";
        header('location: ../register.php');
        exit();
    }
}
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fetch the user's data from the database
    $fetch_user_query = "SELECT * FROM `users` WHERE `email`='$email'";
    $fetch_user_result = mysqli_query($conn, $fetch_user_query);

    if ($fetch_user_result && $user_data = mysqli_fetch_assoc($fetch_user_result)) {
        // Check user status
        if ($user_data['user_status'] === 'inactive') {
            $_SESSION['message'] = "Your account is inactive. Please contact support for assistance.";
            $_SESSION['messageType'] = "error";
            header('location: ../login.php');
            exit;
        }

        if ($user_data['user_status'] === 'request_for_deletion') {
            $_SESSION['message'] = "Your account is marked for deletion. Please contact support for recovery.";
            $_SESSION['messageType'] = "error";
            header('location: ../login.php');
            exit;
        }
        if (password_verify($password, $user_data['password'])) {
            $_SESSION['auth'] = true;
        
            // User data to be stored in the session
            $user_id = $user_data['id'];
            $user_email = $user_data['email'];
        
            // Set session variables
            $_SESSION['auth_user'] = [
                'id' => $user_id,
                'email' => $user_email,
                // Other user details...
            ];
        
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
        
            // Redirect based on the role
            if ($user_role == '1') {
                $_SESSION['message'] = "Welcome to Admin dashboard";
                $_SESSION['messageType'] = "success";
                header('location: ../admin/index.php');
            } elseif ($user_role == '2') {
                $_SESSION['message'] = "Welcome to Supplier dashboard";
                $_SESSION['messageType'] = "success";
                header('location: ../supplier/index.php');
            } else {
                $_SESSION['message'] = "You are now logged in";
                $_SESSION['messageType'] = "success";
                header('location: ../index.php');
            }
        
        
        } else {
            // Invalid password
            $_SESSION['message'] = "Invalid credentials";
            $_SESSION['messageType'] = "error";
            header('location: ../login.php');
        }
    } else {
        // User not found
        $_SESSION['message'] = "Invalid credentials";
        $_SESSION['messageType'] = "error";
        header('location: ../login.php');
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
