<?php
include "admin/config/dbcon.php";
if (isset($_POST['submitcomment'])) {
    $user_name = trim($_POST['user_name'] ?? '');
    $user_email = trim($_POST['user_email'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    $blog_id = intval($_POST['blog_id'] ?? 0);

    // Fetch blog slug by id for redirection
    $stmtSlug = $conn->prepare("SELECT slug FROM blogs WHERE id = ?");
    $stmtSlug->bind_param("i", $blog_id);
    $stmtSlug->execute();
    $resultSlug = $stmtSlug->get_result();
    if ($resultSlug->num_rows == 0) {
        $_SESSION['message'] = "Blog post not found.";
        $_SESSION['messageType'] = "error";
        header("Location: ../blog-details.php");
        exit();
    }
    $blog = $resultSlug->fetch_assoc();
    $slug = $blog['slug'];
    $stmtSlug->close();

    // Validate input
    if (empty($user_name) || empty($user_email) || empty($comment) || !$blog_id) {
        $_SESSION['message'] = "Please fill all fields to continue.";
        $_SESSION['messageType'] = "error";
        header("Location: ../blog-details.php?slug=" . urlencode($slug));
        exit();
    }
    if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Invalid email format.";
        $_SESSION['messageType'] = "error";
        header("Location: ../blog-details.php?slug=" . urlencode($slug));
        exit();
    }

    // Correct column names here
    $stmt = $conn->prepare("INSERT INTO comments (blog_id, user_name, user_email, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
    if (!$stmt) {
        $_SESSION['message'] = "Database error: " . $conn->error;
        $_SESSION['messageType'] = "error";
        header("Location: ../blog-details.php?slug=" . urlencode($slug));
        exit();
    }
    $stmt->bind_param("isss", $blog_id, $user_name, $user_email, $comment);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Comment submitted successfully. It will be visible after approval.";
        $_SESSION['messageType'] = "success";
    } else {
        $_SESSION['message'] = "Failed to submit comment: " . $stmt->error;
        $_SESSION['messageType'] = "error";
    }
    $stmt->close();
    header("Location: ../blog-details.php?slug=" . urlencode($slug));
    exit();
}
