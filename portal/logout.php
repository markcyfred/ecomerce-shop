<?php
session_start();

// Store logout message before destroying session
$logout_message = 'You have been logged out successfully';
$logout_type = 'success';

// Destroy all session data
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session
session_destroy();

// Start a fresh session for the logout message
session_start();
session_regenerate_id(true);

// Set logout message in the new session
$_SESSION['message'] = $logout_message;
$_SESSION['messageType'] = $logout_type;

// Ensure session is written before redirect
session_write_close();

// Redirect to main GoprimeHost page
header("Location: ../index.php");
exit();
?>
