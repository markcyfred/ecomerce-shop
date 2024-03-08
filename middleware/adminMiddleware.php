<?php
// Define the redirect function


// Include session_start() to handle session variables
session_start();

// Include your functions file
include_once '../functions/myfunctions.php';

// Check if user is authenticated
if (isset($_SESSION['auth'])) {
    // Check user role
    if ($_SESSION['role_as'] != 1) {
        redirect('../index.php', 'You are not authorized to access this page', 'error');
    } 
} else {
    redirect('../login.php', 'You are not authorized to access this page', 'error');
}
?>
