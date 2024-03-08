<?php
include(__DIR__ . '/../admin/config/dbcon.php');

//category
function getAllActive($table)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE status='1'";
    return $query_run = mysqli_query($conn, $query);
}

function redirect($url, $message, $messageType = 'success')
{
    $_SESSION['message'] = $message;
    $_SESSION['messageType'] = $messageType;
    header("Location: $url");
    exit();
}

// Function to retrieve popular categories
function getPopularCategories($conn)
{
    global $conn;
    $query = "SELECT * FROM categories WHERE status='1' AND popularity='1'";
    return $query_run = mysqli_query($conn, $query);
}
function getAllProducts($table) {
    global $conn;
    $query = "SELECT * FROM $table WHERE status='1'";
    return mysqli_query($conn, $query);
}


?>