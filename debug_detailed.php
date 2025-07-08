<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Detailed Password Reset Debug</h1>";

// Test database connection
echo "<h2>1. Database Connection Test</h2>";
try {
    include 'admin/config/dbcon.php';
    echo "<p style='color: green;'>✅ Database connection successful</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
    exit;
}

// Check if password_resets table exists
echo "<h2>2. Table Check</h2>";
$check_table = "SHOW TABLES LIKE 'password_resets'";
$table_result = mysqli_query($conn, $check_table);

if (mysqli_num_rows($table_result) == 0) {
    echo "<p style='color: red;'>❌ password_resets table does not exist!</p>";
    echo "<p>Creating table now...</p>";
    
    $create_table = "CREATE TABLE `password_resets` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `email` varchar(255) NOT NULL,
        `token` varchar(255) NOT NULL,
        `expires_at` timestamp NOT NULL,
        `used` tinyint(1) NOT NULL DEFAULT 0,
        `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`),
        KEY `email` (`email`),
        KEY `token` (`token`),
        KEY `expires_at` (`expires_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    
    if (mysqli_query($conn, $create_table)) {
        echo "<p style='color: green;'>✅ password_resets table created successfully!</p>";
    } else {
        echo "<p style='color: red;'>❌ Error creating table: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color: green;'>✅ password_resets table exists</p>";
}

// Check specific token
echo "<h2>3. Token Analysis</h2>";
$token = '74e47ff45e37b739fec9063d9f4e780fcafb2978fbdcedd13594e573d4c0c58d';
echo "<p><strong>Token to check:</strong> " . htmlspecialchars($token) . "</p>";

// Check if token exists (without any conditions)
$basic_check = "SELECT * FROM password_resets WHERE token = '$token'";
$basic_result = mysqli_query($conn, $basic_check);

if (mysqli_num_rows($basic_result) == 0) {
    echo "<p style='color: red;'>❌ Token not found in database at all</p>";
} else {
    $token_data = mysqli_fetch_assoc($basic_result);
    echo "<p style='color: green;'>✅ Token found in database</p>";
    
    echo "<h3>Token Details:</h3>";
    echo "<ul>";
    echo "<li><strong>Email:</strong> " . htmlspecialchars($token_data['email']) . "</li>";
    echo "<li><strong>Created:</strong> " . $token_data['created_at'] . "</li>";
    echo "<li><strong>Expires:</strong> " . $token_data['expires_at'] . "</li>";
    echo "<li><strong>Used:</strong> " . ($token_data['used'] ? 'Yes' : 'No') . "</li>";
    echo "</ul>";
    
    // Check each condition separately
    echo "<h3>Condition Checks:</h3>";
    
    // Check if used
    if ($token_data['used'] == 1) {
        echo "<p style='color: red;'>❌ Token has been used</p>";
    } else {
        echo "<p style='color: green;'>✅ Token has not been used</p>";
    }
    
    // Check if expired
    $now = date('Y-m-d H:i:s');
    $expires = $token_data['expires_at'];
    
    if (strtotime($now) > strtotime($expires)) {
        echo "<p style='color: red;'>❌ Token is expired (Current: $now, Expires: $expires)</p>";
    } else {
        echo "<p style='color: green;'>✅ Token is not expired</p>";
    }
    
    // Test the exact query from reset_password.php
    echo "<h3>4. Testing Exact Query from reset_password.php</h3>";
    $exact_query = "SELECT * FROM password_resets WHERE token = '$token' AND used = 0 AND expires_at > NOW()";
    echo "<p><strong>Query:</strong> " . htmlspecialchars($exact_query) . "</p>";
    
    $exact_result = mysqli_query($conn, $exact_query);
    
    if (mysqli_num_rows($exact_result) == 0) {
        echo "<p style='color: red;'>❌ Query returns no results (this is why the link is invalid)</p>";
        
        // Let's see what NOW() returns
        $now_query = "SELECT NOW() as current_time";
        $now_result = mysqli_query($conn, $now_query);
        $now_data = mysqli_fetch_assoc($now_result);
        echo "<p><strong>Database NOW():</strong> " . $now_data['current_time'] . "</p>";
        echo "<p><strong>PHP date():</strong> " . date('Y-m-d H:i:s') . "</p>";
        
    } else {
        echo "<p style='color: green;'>✅ Query returns results (token should be valid)</p>";
    }
}

// Show all tokens in the database
echo "<h2>5. All Tokens in Database</h2>";
$all_tokens = "SELECT * FROM password_resets ORDER BY created_at DESC LIMIT 10";
$all_result = mysqli_query($conn, $all_tokens);

if (mysqli_num_rows($all_result) == 0) {
    echo "<p>No tokens found in database</p>";
} else {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Email</th><th>Token (first 10 chars)</th><th>Created</th><th>Expires</th><th>Used</th><th>Status</th></tr>";
    
    while ($row = mysqli_fetch_assoc($all_result)) {
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
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($token_short) . "</td>";
        echo "<td>" . $row['created_at'] . "</td>";
        echo "<td>" . $row['expires_at'] . "</td>";
        echo "<td>" . ($row['used'] ? 'Yes' : 'No') . "</td>";
        echo "<td>" . $status . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Test creating a new token
echo "<h2>6. Test Token Creation</h2>";
echo "<form method='post'>";
echo "<input type='email' name='test_email' placeholder='Enter email to test' required>";
echo "<input type='submit' name='create_test_token' value='Create Test Token'>";
echo "</form>";

if (isset($_POST['create_test_token']) && !empty($_POST['test_email'])) {
    $test_email = mysqli_real_escape_string($conn, $_POST['test_email']);
    
    // Generate test token
    $test_token = bin2hex(random_bytes(32));
    $test_expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    $insert_test = "INSERT INTO password_resets (email, token, expires_at) VALUES ('$test_email', '$test_token', '$test_expires')";
    
    if (mysqli_query($conn, $insert_test)) {
        echo "<p style='color: green;'>✅ Test token created successfully!</p>";
        echo "<p><strong>Test Token:</strong> " . $test_token . "</p>";
        echo "<p><strong>Test Link:</strong> <a href='reset_password.php?token=" . $test_token . "'>Click here to test</a></p>";
    } else {
        echo "<p style='color: red;'>❌ Error creating test token: " . mysqli_error($conn) . "</p>";
    }
}

echo "<h2>7. Actions</h2>";
echo "<p><a href='reset.php'>Go to Password Reset Page</a></p>";
echo "<p><a href='debug_detailed.php'>Refresh Debug Info</a></p>";
echo "<p><a href='setup_database.php'>Run Database Setup</a></p>";
?> 