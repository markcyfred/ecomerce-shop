<?php
/**
 * Paystack Integration Installation Script
 * 
 * This script helps set up the Paystack integration by:
 * 1. Running database migrations
 * 2. Creating necessary directories
 * 3. Setting up file permissions
 * 4. Validating the installation
 */

require_once __DIR__ . '/../admin/config/dbcon.php';

echo "<h1>Paystack Integration Installation</h1>";

// Function to run SQL queries
function runSQL($conn, $sql, $description) {
    echo "<h3>$description</h3>";
    try {
        if ($conn->query($sql)) {
            echo "✅ Success: $description<br>";
            return true;
        } else {
            echo "❌ Error: " . $conn->error . "<br>";
            return false;
        }
    } catch (Exception $e) {
        echo "❌ Exception: " . $e->getMessage() . "<br>";
        return false;
    }
}

// Step 1: Create logs directory
echo "<h2>Step 1: Creating Logs Directory</h2>";
$logsDir = __DIR__ . '/logs';
if (!is_dir($logsDir)) {
    if (mkdir($logsDir, 0755, true)) {
        echo "✅ Logs directory created successfully<br>";
    } else {
        echo "❌ Failed to create logs directory<br>";
    }
} else {
    echo "✅ Logs directory already exists<br>";
}

// Step 2: Database Migration
echo "<h2>Step 2: Database Migration</h2>";

// Add token field to checkout table if it doesn't exist
$sql = "ALTER TABLE `checkout` ADD COLUMN IF NOT EXISTS `token` VARCHAR(255) UNIQUE AFTER `id`";
runSQL($conn, $sql, "Adding token field to checkout table");

// Add checkout_token field to checkout table if it doesn't exist
$sql = "ALTER TABLE `checkout` ADD COLUMN IF NOT EXISTS `checkout_token` VARCHAR(255) AFTER `token`";
runSQL($conn, $sql, "Adding checkout_token field to checkout table");

// Add checkout_token field to cart table if it doesn't exist
$sql = "ALTER TABLE `cart` ADD COLUMN IF NOT EXISTS `checkout_token` VARCHAR(255) AFTER `cart_status`";
runSQL($conn, $sql, "Adding checkout_token field to cart table");

// Create paystack_transactions table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS `paystack_transactions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `reference` VARCHAR(255) UNIQUE NOT NULL,
    `order_id` INT NOT NULL,
    `user_id` INT NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `currency` VARCHAR(3) DEFAULT 'NGN',
    `status` VARCHAR(50) NOT NULL,
    `gateway_response` TEXT,
    `paid_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_reference` (`reference`),
    INDEX `idx_order_id` (`order_id`),
    INDEX `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
runSQL($conn, $sql, "Creating paystack_transactions table");

// Create indexes if they don't exist
$sql = "CREATE INDEX IF NOT EXISTS `idx_checkout_token` ON `checkout` (`token`)";
runSQL($conn, $sql, "Creating index on checkout token");

$sql = "CREATE INDEX IF NOT EXISTS `idx_cart_checkout_token` ON `cart` (`checkout_token`)";
runSQL($conn, $sql, "Creating index on cart checkout_token");

// Step 3: Update existing orders with tokens (if any)
echo "<h2>Step 3: Updating Existing Orders</h2>";
$sql = "SELECT id FROM checkout WHERE token IS NULL OR token = ''";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "Found " . $result->num_rows . " orders without tokens. Updating...<br>";
    
    while ($row = $result->fetch_assoc()) {
        $token = 'ord_' . $row['id'] . '_' . time() . '_' . bin2hex(random_bytes(8));
        $updateSql = "UPDATE checkout SET token = '$token' WHERE id = " . $row['id'];
        runSQL($conn, $updateSql, "Updating order ID " . $row['id'] . " with token");
    }
} else {
    echo "✅ All orders already have tokens or no orders found<br>";
}

// Step 4: Validate Installation
echo "<h2>Step 4: Installation Validation</h2>";

// Check if all required tables exist
$requiredTables = ['paystack_transactions', 'checkout', 'cart'];
foreach ($requiredTables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        echo "✅ Table '$table' exists<br>";
    } else {
        echo "❌ Table '$table' missing<br>";
    }
}

// Check if required columns exist
$requiredColumns = [
    'checkout' => ['token', 'checkout_token'],
    'cart' => ['checkout_token']
];

foreach ($requiredColumns as $table => $columns) {
    foreach ($columns as $column) {
        $result = $conn->query("SHOW COLUMNS FROM $table LIKE '$column'");
        if ($result && $result->num_rows > 0) {
            echo "✅ Column '$column' exists in table '$table'<br>";
        } else {
            echo "❌ Column '$column' missing in table '$table'<br>";
        }
    }
}

// Check file permissions
echo "<h3>File Permissions Check</h3>";
if (is_writable($logsDir)) {
    echo "✅ Logs directory is writable<br>";
} else {
    echo "❌ Logs directory is not writable<br>";
    echo "Please run: chmod 755 " . $logsDir . "<br>";
}

// Step 5: Configuration Check
echo "<h2>Step 5: Configuration Check</h2>";
$configFile = __DIR__ . '/config.php';
if (file_exists($configFile)) {
    echo "✅ Configuration file exists<br>";
    
    // Check if API keys are still default
    $configContent = file_get_contents($configFile);
    if (strpos($configContent, 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx') !== false) {
        echo "⚠️  Warning: API keys are still set to default values<br>";
        echo "Please update the API keys in config.php<br>";
    } else {
        echo "✅ API keys appear to be configured<br>";
    }
} else {
    echo "❌ Configuration file missing<br>";
}

// Step 6: Next Steps
echo "<h2>Step 6: Next Steps</h2>";
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 5px;'>";
echo "<h4>To complete the installation:</h4>";
echo "<ol>";
echo "<li><strong>Update API Keys:</strong> Edit paystack/config.php and replace the placeholder API keys with your actual Paystack keys</li>";
echo "<li><strong>Configure Webhooks:</strong> In your Paystack dashboard, set the webhook URL to: " . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/paystack/callback.php</li>";
echo "<li><strong>Test Payment Flow:</strong> Create an order and test the complete payment flow</li>";
echo "</ol>";
echo "</div>";

// Step 7: Quick Links
echo "<h2>Step 7: Quick Links</h2>";
echo "<p>";
echo "<a href='../order-confirmation.php' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>View Order Confirmation</a>";
echo "</p>";

echo "<hr>";
echo "<p><small>Installation completed at: " . date('Y-m-d H:i:s') . "</small></p>";
?>

<style>
body { font-family: Arial, sans-serif; margin: 20px; line-height: 1.6; }
h1 { color: #333; border-bottom: 2px solid #007bff; padding-bottom: 10px; }
h2 { color: #666; margin-top: 30px; }
h3 { color: #888; margin-top: 20px; }
.btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
.btn:hover { background: #0056b3; }
</style> 