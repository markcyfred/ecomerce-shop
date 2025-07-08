<?php
// ajax/blog_ajax.php
session_start();

// 1) Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db   = "shop";
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed. Please try again later.'
    ]);
    exit;
}

$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
          && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// 2) Must be POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$isAjax) {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request.'
    ]);
    exit;
}

// 3) Initialize response
$respOk  = false;
$respMsg = '';
$likeCount = null;

// 4) Handle “Like” if submitlike is set
if (isset($_POST['submitlike'])) {
    $blog_id    = intval($_POST['blog_id'] ?? 0);
    $ip_address = $_SERVER['REMOTE_ADDR'];

    if ($blog_id <= 0) {
        $respMsg = "Invalid blog ID.";
    } else {
        // Check if this IP already liked
        $check = $conn->prepare("SELECT id FROM likes WHERE blog_id = ? AND ip_address = ?");
        $check->bind_param("is", $blog_id, $ip_address);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) {
            $insert = $conn->prepare("INSERT INTO likes (blog_id, ip_address) VALUES (?, ?)");
            $insert->bind_param("is", $blog_id, $ip_address);
            if ($insert->execute()) {
                $respOk  = true;
                $respMsg = "You liked this blog!";
            } else {
                $respMsg = "Failed to like blog: " . $insert->error;
            }
            $insert->close();
        } else {
            $respMsg = "You already liked this blog.";
        }
        $check->close();

        // Fetch updated count
        $like_stmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE blog_id = ?");
        $like_stmt->bind_param("i", $blog_id);
        $like_stmt->execute();
        $like_stmt->bind_result($likeCount);
        $like_stmt->fetch();
        $like_stmt->close();
    }

    header('Content-Type: application/json');
    echo json_encode([
        'success'   => $respOk,
        'message'   => $respMsg,
        'likeCount' => $likeCount
    ]);
    exit;
}

// 5) Handle “Submit Comment” if submitcomment is set
if (isset($_POST['submitcomment'])) {
    $user_name  = trim($_POST['user_name'] ?? '');
    $user_email = trim($_POST['user_email'] ?? '');
    $comment    = trim($_POST['comment'] ?? '');
    $blog_id    = intval($_POST['blog_id'] ?? 0);

    if (empty($user_name) || empty($user_email) || empty($comment) || $blog_id <= 0) {
        $respMsg = "Please fill in all fields.";
    } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $respMsg = "Invalid email format.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO comments (blog_id, user_name, user_email, comment, created_at)
             VALUES (?, ?, ?, ?, NOW())"
        );
        if ($stmt) {
            $stmt->bind_param("isss", $blog_id, $user_name, $user_email, $comment);
            if ($stmt->execute()) {
                $respOk  = true;
                $respMsg = "Comment submitted successfully! It will be visible after approval.";
            } else {
                $respMsg = "Failed to submit comment: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $respMsg = "Database error: " . $conn->error;
        }
    }

    header('Content-Type: application/json');
    echo json_encode([
        'success' => $respOk,
        'message' => $respMsg
    ]);
    exit;
}

// 6) If neither action matched
header('Content-Type: application/json');
echo json_encode([
    'success' => false,
    'message' => 'No valid action provided.'
]);
exit;
