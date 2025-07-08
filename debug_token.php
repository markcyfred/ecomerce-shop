<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'admin/config/dbcon.php';

$token = '060e68fdfeab4780f01bd8532fda9d797841c4bcff7c1e4a3d1c88ffc5946791';

echo "<h2>Password Reset Token Debug</h2>";

// Check if password_resets table exists
$check_table = "SHOW TABLES LIKE 'password_resets'";
$table_result = mysqli_query($conn, $check_table);

if (mysqli_num_rows($table_result) == 0) {
    echo "<p style='color: red;'>❌ password_resets table does not exist!</p>";
    echo "<p>Please run the database setup script first:</p>";
    echo "<pre>SOURCE database/setup_password_reset.sql;</pre>";
} else {
    echo "<p style='color: green;'>✅ password_resets table exists</p>";
}

// Check if token exists in database
$check_token_query = "SELECT * FROM password_resets WHERE token = '$token'";
$check_token_result = mysqli_query($conn, $check_token_query);

if (mysqli_num_rows($check_token_result) == 0) {
    echo "<p style='color: red;'>❌ Token not found in database</p>";
} else {
    $token_data = mysqli_fetch_assoc($check_token_result);
    echo "<p style='color: green;'>✅ Token found in database</p>";
    echo "<h3>Token Details:</h3>";
    echo "<ul>";
    echo "<li><strong>Email:</strong> " . htmlspecialchars($token_data['email']) . "</li>";
    echo "<li><strong>Created:</strong> " . $token_data['created_at'] . "</li>";
    echo "<li><strong>Expires:</strong> " . $token_data['expires_at'] . "</li>";
    echo "<li><strong>Used:</strong> " . ($token_data['used'] ? 'Yes' : 'No') . "</li>";
    echo "</ul>";
    
    // Check if token is expired
    $now = date('Y-m-d H:i:s');
    $expires = $token_data['expires_at'];
    
    if (strtotime($now) > strtotime($expires)) {
        echo "<p style='color: red;'>❌ Token is expired (Current: $now, Expires: $expires)</p>";
    } else {
        echo "<p style='color: green;'>✅ Token is not expired</p>";
    }
    
    if ($token_data['used'] == 1) {
        echo "<p style='color: red;'>❌ Token has already been used</p>";
    } else {
        echo "<p style='color: green;'>✅ Token has not been used</p>";
    }
}

// Show all tokens for this email (if token was found)
if (mysqli_num_rows($check_token_result) > 0) {
    $email = $token_data['email'];
    echo "<h3>All tokens for email: " . htmlspecialchars($email) . "</h3>";
    
    $all_tokens_query = "SELECT * FROM password_resets WHERE email = '$email' ORDER BY created_at DESC";
    $all_tokens_result = mysqli_query($conn, $all_tokens_query);
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Token</th><th>Created</th><th>Expires</th><th>Used</th><th>Status</th></tr>";
    
    while ($row = mysqli_fetch_assoc($all_tokens_result)) {
        $now = date('Y-m-d H:i:s');
        $expired = strtotime($now) > strtotime($row['expires_at']);
        $status = '';
        
        if ($row['used'] == 1) {
            $status = 'Used';
        } elseif ($expired) {
            $status = 'Expired';
        } else {
            $status = 'Valid';
        }
        
        $token_short = substr($row['token'], 0, 10) . '...';
        echo "<tr>";
        echo "<td>" . htmlspecialchars($token_short) . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "<td>" . $row['expires_at'] . "</td>";
        echo "<td>" . ($row['used'] ? 'Yes' : 'No') . "</td>";
        echo "<td>" . $status . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Check database connection
if ($conn) {
    echo "<p style='color: green;'>✅ Database connection successful</p>";
} else {
    echo "<p style='color: red;'>❌ Database connection failed</p>";
}

echo "<h3>Current Time:</h3>";
echo "<p>" . date('Y-m-d H:i:s') . "</p>";

echo "<h3>Actions:</h3>";
echo "<p><a href='reset.php'>Request New Reset Link</a></p>";
echo "<p><a href='debug_token.php'>Refresh Debug Info</a></p>";

echo "<pre>";
echo "Token from URL: [" . (isset($_GET['token']) ? $_GET['token'] : '') . "]\n";
$token = isset($_GET['token']) ? $_GET['token'] : '';
$token = mysqli_real_escape_string($conn, $token);
echo "Token after escape: [$token]\n";
$check_token_query = "SELECT * FROM password_resets WHERE token = '$token' AND used = 0 AND expires_at > NOW()";
echo "Query: $check_token_query\n";
$check_token_result = mysqli_query($conn, $check_token_query);
if (!$check_token_result) {
    die("SQL Error: " . mysqli_error($conn));
}
echo "Rows found: " . mysqli_num_rows($check_token_result) . "\n";
if (mysqli_num_rows($check_token_result) > 0) {
    $row = mysqli_fetch_assoc($check_token_result);
    echo "DB Token: [{$row['token']}]\n";
    echo "Used: {$row['used']}\n";
    echo "Expires: {$row['expires_at']}\n";
}
echo "Current PHP time: " . date('Y-m-d H:i:s') . "\n";
echo "</pre>";

echo "<pre>";
print_r($_GET);
echo "</pre>";
?> 