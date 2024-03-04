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

function getAddress($url, $message)
{
    $_SESSION['message'] = $message;
    header("Location: $url");
    exit();
}






?>