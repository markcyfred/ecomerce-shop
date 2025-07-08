<?php
// feedback_ajax.php

include "admin/config/dbcon.php"; // Include your functions file if needed
// Enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle AJAX feedback form submission
if (isset($_POST['submit_feedback_btn'])) {
    $status = 0; // Waiting for approval

    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    if (empty($email)) {
        echo json_encode([
            "status" => "error",
            "message" => "Email is required."
        ]);
        exit;
    }

    $checkEmailQuery = "SELECT id FROM users WHERE email = '$email' LIMIT 1";
    $emailResult = mysqli_query($conn, $checkEmailQuery);
    $isAnonymous = isset($_POST['anonymous']);

    // Handle fields
    $name = $isAnonymous ? "Anonymous" : (isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : "No Name");
    $title = isset($_POST['title']) ? mysqli_real_escape_string($conn, $_POST['title']) : '';
    $feedback = isset($_POST['feedback']) ? mysqli_real_escape_string($conn, $_POST['feedback']) : '';
    $filename = "default.jpg"; // fallback image

    // Handle image upload (only if not anonymous)
    if (!$isAnonymous && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext, $allowed)) {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid image format. Allowed: jpg, jpeg, png, gif."
            ]);
            exit;
        }

        $path = __DIR__ . "/uploads/feedbacks/";
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $ext;
        if (!move_uploaded_file($tmp_name, $path . $filename)) {
            echo json_encode([
                "status" => "error",
                "message" => "Failed to upload image."
            ]);
            exit;
        }
    }

    // If email is in users table
    if ($emailResult && mysqli_num_rows($emailResult) > 0) {
        $query = "INSERT INTO feedbacks (name, title, feedback, image, status, email) 
                  VALUES ('$name', '$title', '$feedback', '$filename', '$status', '$email')";
        $run = mysqli_query($conn, $query);

        if ($run) {
            echo json_encode([
                "status" => "success",
                "message" => "Thank you for your feedback. It’s under review."
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Database error: " . mysqli_error($conn)
            ]);
        }
    } else {
        // Email not found, auto-decline feedback
        $declinedStatus = 2; // declined
        $query = "INSERT INTO feedbacks (name, title, feedback, image, status, email) 
                  VALUES ('$name', '$title', '$feedback', '$filename', '$declinedStatus', '$email')";
        mysqli_query($conn, $query);

        echo json_encode([
            "status" => "error",
            "message" => "Email not recognized. Feedback declined."
        ]);
    }

    exit;
}

// If script accessed directly
echo json_encode([
    "status" => "error",
    "message" => "Invalid request."
]);
exit;
