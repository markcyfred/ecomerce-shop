<?php
session_start();

if (isset($_SESSION['auth'])) {
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
    $_SESSION['message'] = "You are logged out";
    $_SESSION['messageType'] = "success";
    header('location: ../index.php');
} else {
    header('location: ../index.php');
}
?>
