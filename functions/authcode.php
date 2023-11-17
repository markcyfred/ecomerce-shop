<?php
session_start();

include '../admin/config/dbcon.php';

if (isset($_POST['register'])) {
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


    // Check if passwords match
    if ($password === $confirm_password) {
        // Check if email already exists
        $check_email_query = "SELECT * FROM `users` WHERE `email`='$email'";
        $check_email_result = mysqli_query($conn, $check_email_query);

        if (mysqli_num_rows($check_email_result) > 0) {
            $_SESSION['message'] = "Email is already registered";
            header('location: ../register.php');
            exit();
        }

        // Insert user data
        $insert_query = "INSERT INTO `users` (`first_name`, `last_name`, `email`, `phone`, `street_address`, `city`, `postal_code`, `additional_info`, `password`,`role_as`) VALUES ('$first_name', '$last_name', '$email', '$phone', '$street_address', '$city', '$postal_code', '$additional_info', '$password','$role_as')";

        $insert_query_run = mysqli_query($conn, $insert_query);

        if ($insert_query_run) {
            $_SESSION['message'] = "You are now registered";
            header('location: ../login.php');
        } else {
            $_SESSION['message'] = "You are not registered";
            header('location: register.php');
        }
    } else {
        $_SESSION['message'] = "Password does not match";
        header('location: ../register.php');
    }
} elseif (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate the login credentials
    $login_query = "SELECT * FROM `users` WHERE `email`='$email' AND `password`='$password'";
    $login_query_run = mysqli_query($conn, $login_query);

    if (mysqli_num_rows($login_query_run) > 0) {
        $_SESSION['auth'] = true;

        $userdata = mysqli_fetch_array($login_query_run);
        $user_id = $userdata['id'];
        $user_email = $userdata['email'];
        $user_role = $userdata['role_as'];

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
        $_SESSION['message'] = "Invalid credentials";
        header('location: ../login.php');
    }
}
