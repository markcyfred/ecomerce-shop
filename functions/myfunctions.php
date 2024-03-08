<?php

//category
function getAll($table)
{
    global $conn;
    $query = "SELECT * FROM $table";
    return $query_run = mysqli_query($conn, $query);
}
//edit category 
function getByID($table,$id)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE id = $id";
    return $query_run = mysqli_query($conn, $query);
}

function redirect($url, $message, $messageType = 'success')
{
    $_SESSION['message'] = $message;
    $_SESSION['messageType'] = $messageType;
    header("Location: $url");
    exit();
}


//display user
function getbyRole ($table,$role_as)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE role_as = '$role_as'";
    return $query_run = mysqli_query($conn, $query);
}

// Get user details based on session data
function getUserDetailsByEmail($email)
{
    global $conn;
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    } else {
        return false; // User not found
    }
}

function getUserByID($table,$id)
{
    global $conn;
    $query = "SELECT * FROM users WHERE id = $id";
   return $query_run = mysqli_query($conn, $query);
}



?>