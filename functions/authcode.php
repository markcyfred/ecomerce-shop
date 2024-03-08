<?php
session_start();

include '../admin/config/dbcon.php';
if (isset($_POST['register'])) {
    // File upload handling
    $targetDirectory = "../assets/imgs/profile/";
    $targetFile = $targetDirectory . basename($_FILES["profile_picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['message'] = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["profile_picture"]["size"] > 5000000) {
        $_SESSION['message'] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedExtensions)) {
        $_SESSION['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk === 1) {
        // Move the uploaded file to the destination directory
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {

            // Escaping user inputs to prevent SQL injection
            $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
            $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $street_address = mysqli_real_escape_string($conn, $_POST['street_address']);
            $city = mysqli_real_escape_string($conn, $_POST['city']);
            $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
            $additional_info = mysqli_real_escape_string($conn, $_POST['additional_info']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
            $role_as = mysqli_real_escape_string($conn, $_POST['role_as']);  // Added this line to get the selected user type

            // Check if email already exists
            $check_email_query = "SELECT * FROM `users` WHERE `email`='$email'";
            $check_email_result = mysqli_query($conn, $check_email_query);

            if (mysqli_num_rows($check_email_result) > 0) {
                $_SESSION['message'] = "Email is already registered";
                header('location: ../register.php');
                exit();
            }

            // Check if passwords match
            if ($password === $confirm_password) {
                // Hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert user data
                $filename = basename($_FILES["profile_picture"]["name"]);

                $insert_query = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `phone`, `street_address`, `city`, `postal_code`, `additional_info`, `password`, `role_as`, `profile_picture`) VALUES ('$first_name', '$last_name', '$email', '$phone', '$street_address', '$city', '$postal_code', '$additional_info', '$hashed_password', '$role_as', '$filename')";
                $insert_query_run = mysqli_query($conn, $insert_query);

                if ($insert_query_run) {
                    $_SESSION['message'] = "You are now registered";
                    header('location: ../login.php');
                    exit();
                } else {
                    $_SESSION['message'] = "You are not registered";
                    header('location: register.php');
                    exit();
                }
            } else {
                $_SESSION['message'] = "Password does not match";
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
        // Verify the entered password with the stored hashed password
        if (password_verify($password, $user_data['password'])) {
            $_SESSION['auth'] = true;

            $user_id = $user_data['id'];
            $user_email = $user_data['email'];
            $user_role = $user_data['role_as'];

            $_SESSION['auth_user']  = [
                'id' => $user_id,
                'email' => $user_email
            ];

            $_SESSION['role_as'] = $user_role;

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
            header('location: ../login.php');
        }
    } else {
        // User not found
        $_SESSION['message'] = "Invalid credentials";
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
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], '../assets/imgs/profile/' . $new_image);
            if ($old_image != "") {
                unlink('../assets/imgs/profile/' . $old_image);
            }
        }
        $_SESSION['message'] = "Your account has been updated";
        $_SESSION['messageType'] = "success";
        header('location: ../account.php');
    } else {
        $_SESSION['message'] = "Your account has not been updated";
        $_SESSION['messageType'] = "error";
        header('location: ../account.php');
    }
}

//delete_user_btn
else if (isset($_POST['delete_user_btn'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    $user_query = "SELECT * FROM users WHERE id='$user_id'";
    $user_query_run = mysqli_query($conn, $user_query);
    $user_data = mysqli_fetch_array($user_query_run);
    $image = $user_data['profile_picture'];

    $delete_query = "DELETE FROM users WHERE id='$user_id'";

    $delete_query_run = mysqli_query($conn, $delete_query);

    if ($delete_query_run) {
        if (file_exists(("../assets/imgs/profile/" . $image)) && !empty($image)) {
            unlink("../assets/imgs/profile/" . $image);
        }
        $_SESSION['message'] = "User has been deleted";
        $_SESSION['messageType'] = "success";
        header('location: ../index.php');
    } else {
        $_SESSION['message'] = "User has not been deleted";
        $_SESSION['messageType'] = "error";
        header('location: ../account.php');
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