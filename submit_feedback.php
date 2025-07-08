<?php
session_start();

// 1) Database connection (procedural mysqli)
$host = "localhost";
$user = "root";
$pass = "";
$db   = "shop";
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    // If AJAX: return JSON error
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        echo json_encode([
            'success' => false,
            'message' => 'Database connection failed. Please try again later.'
        ]);
        exit;
    }
    die("Connection failed: " . mysqli_connect_error());
}

// 2) Ensure this is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method.'
        ]);
        exit;
    }
    header('Location: index.php');
    exit;
}

// 3) Check authentication: only logged‑in users may submit feedback
if (empty($_SESSION['auth']) || $_SESSION['auth'] !== true || empty($_SESSION['auth_user'])) {
    $errorMsg = "You must be logged in to submit a review.";

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        // AJAX: send JSON error
        echo json_encode([
            'success' => false,
            'message' => $errorMsg
        ]);
        exit;
    } else {
        // Non‑AJAX fallback: redirect back with session error
        $redirectBase = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        $redirectBase = preg_replace('/#.*$/', '', $redirectBase);
        $redirectUrl  = $redirectBase . '#feedback';

        $_SESSION['feedback_message'] = $errorMsg;
        $_SESSION['feedback_success'] = false;
        header("Location: {$redirectUrl}");
        exit;
    }
}

// 4) Gather + basic sanitization
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

// Override name + email from session
$name  = trim(
    $_SESSION['auth_user']['display_name']
    ?? ($_SESSION['auth_user']['first_name'] . ' ' . $_SESSION['auth_user']['last_name'])
    ?? ''
);
$email = trim($_SESSION['auth_user']['email'] ?? '');

// Title and feedback from POST
$title    = trim($_POST['title'] ?? '');
$feedback = trim($_POST['feedback'] ?? '');

$imageName = null; // If an image is uploaded successfully

// 5) Basic validation for required fields
$errors = [];
if ($product_id <= 0) {
    $errors[] = "Invalid product.";
}
if ($name === '') {
    // Shouldn’t happen if session is correct, but just in case:
    $errors[] = "Name is required.";
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "A valid email is required.";
}
if ($title === '') {
    $errors[] = "Review title is required.";
}
if ($feedback === '') {
    $errors[] = "Feedback text is required.";
}

// 6) Handle image upload (if provided)
if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
    $img = $_FILES['image'];

    // 6a) Check for upload errors
    if ($img['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Error uploading image.";
    } else {
        // 6b) Ensure size ≤ 2 MB
        if ($img['size'] > 2 * 1024 * 1024) {
            $errors[] = "Image file size must be under 2 MB.";
        }

        // 6c) Validate MIME type
        $allowedMime = ['image/jpeg', 'image/png', 'image/gif'];
        $finfo       = new finfo(FILEINFO_MIME_TYPE);
        $mime        = $finfo->file($img['tmp_name']);

        if (!in_array($mime, $allowedMime, true)) {
            $errors[] = "Only JPEG, PNG, or GIF images are allowed.";
        }

        // 6d) If no errors so far, move the file into uploads/feedback/
        if (empty($errors)) {
            switch ($mime) {
                case 'image/jpeg':
                    $ext = '.jpg';
                    break;
                case 'image/png':
                    $ext = '.png';
                    break;
                case 'image/gif':
                    $ext = '.gif';
                    break;
                default:
                    $ext = '';
                    break;
            }

            // Generate a random filename
            try {
                $baseName = bin2hex(random_bytes(8));
            } catch (Exception $e) {
                $baseName = uniqid('fb_', true);
            }
            $imageName = $baseName . $ext;

            $targetFolder = __DIR__ . '/uploads/feedback/';
            if (!is_dir($targetFolder)) {
                mkdir($targetFolder, 0755, true);
            }

            $destination = $targetFolder . $imageName;
            if (!move_uploaded_file($img['tmp_name'], $destination)) {
                $errors[] = "Failed to move uploaded image.";
            }
        }
    }
}

// Function to handle sending a JSON response
function sendJsonResponse($success, $message) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message
    ]);
    exit;
}

// 7) If there are validation errors, return JSON or redirect
if (!empty($errors)) {
    $allErrors = implode(' ', $errors);

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        sendJsonResponse(false, $allErrors);
    } else {
        $redirectBase = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        $redirectBase = preg_replace('/#.*$/', '', $redirectBase);
        $redirectUrl  = $redirectBase . '#feedback';

        $_SESSION['feedback_message'] = $allErrors;
        $_SESSION['feedback_success'] = false;
        header("Location: {$redirectUrl}");
        exit;
    }
}

// 8) Insert into `feedback` table with status = 0 (pending)
$sql = "
    INSERT INTO feedback
      (product_id, name, email, title, feedback, image, status, created_at)
    VALUES (?, ?, ?, ?, ?, ?, 0, NOW())
";
$stmt = mysqli_prepare($conn, $sql);
if ($stmt === false) {
    $dbErr = "Database error (prepare failed). Please try again later.";

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        sendJsonResponse(false, $dbErr);
    } else {
        $redirectBase = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        $redirectBase = preg_replace('/#.*$/', '', $redirectBase);
        $redirectUrl  = $redirectBase . '#feedback';

        $_SESSION['feedback_message'] = $dbErr;
        $_SESSION['feedback_success'] = false;
        header("Location: {$redirectUrl}");
        exit;
    }
}

mysqli_stmt_bind_param(
    $stmt,
    "isssss",
    $product_id,
    $name,
    $email,
    $title,
    $feedback,
    $imageName
);

if (mysqli_stmt_execute($stmt)) {
    $successMsg = "Thank you! Your review has been submitted and is awaiting approval.";

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        sendJsonResponse(true, $successMsg);
    } else {
        $redirectBase = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        $redirectBase = preg_replace('/#.*$/', '', $redirectBase);
        $redirectUrl  = $redirectBase . '#feedback';

        $_SESSION['feedback_message'] = $successMsg;
        $_SESSION['feedback_success'] = true;
        header("Location: {$redirectUrl}");
        exit;
    }
} else {
    $execErr = "There was an error saving your review. Please try again later.";

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        sendJsonResponse(false, $execErr);
    } else {
        $redirectBase = $_SERVER['HTTP_REFERER'] ?? 'index.php';
        $redirectBase = preg_replace('/#.*$/', '', $redirectBase);
        $redirectUrl  = $redirectBase . '#feedback';

        $_SESSION['feedback_message'] = $execErr;
        $_SESSION['feedback_success'] = false;
        header("Location: {$redirectUrl}");
        exit;
    }
}

mysqli_stmt_close($stmt);
