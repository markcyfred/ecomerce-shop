<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'admin/config/dbcon.php';

echo "<h2>Database Setup for Password Reset</h2>";

// Check if password_resets table exists
$check_table = "SHOW TABLES LIKE 'password_resets'";
$table_result = mysqli_query($conn, $check_table);

if (mysqli_num_rows($table_result) == 0) {
    echo "<p>Creating password_resets table...</p>";
    
    // Create password_resets table
    $create_table = "CREATE TABLE IF NOT EXISTS `password_resets` (
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
    echo "<p style='color: green;'>✅ password_resets table already exists</p>";
}

// Check if customer_code column exists in users table
$check_column = "SHOW COLUMNS FROM users LIKE 'customer_code'";
$column_result = mysqli_query($conn, $check_column);

if (mysqli_num_rows($column_result) == 0) {
    echo "<p>Adding customer_code column to users table...</p>";
    
    $add_column = "ALTER TABLE `users` ADD COLUMN `customer_code` varchar(20) DEFAULT NULL AFTER `id`";
    
    if (mysqli_query($conn, $add_column)) {
        echo "<p style='color: green;'>✅ customer_code column added successfully!</p>";
    } else {
        echo "<p style='color: red;'>❌ Error adding column: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p style='color: green;'>✅ customer_code column already exists</p>";
}

// Show table structure
echo "<h3>password_resets Table Structure:</h3>";
$structure_query = "DESCRIBE password_resets";
$structure_result = mysqli_query($conn, $structure_query);

echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";

while ($row = mysqli_fetch_assoc($structure_result)) {
    echo "<tr>";
    echo "<td>" . $row['Field'] . "</td>";
    echo "<td>" . $row['Type'] . "</td>";
    echo "<td>" . $row['Null'] . "</td>";
    echo "<td>" . $row['Key'] . "</td>";
    echo "<td>" . $row['Default'] . "</td>";
    echo "<td>" . $row['Extra'] . "</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h3>Actions:</h3>";
echo "<p><a href='reset.php'>Go to Password Reset Page</a></p>";
echo "<p><a href='debug_token.php'>Debug Token Issues</a></p>";
echo "<p><a href='setup_database.php'>Refresh Setup</a></p>";
?> 