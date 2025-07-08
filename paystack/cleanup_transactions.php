<?php
/**
 * Paystack Transaction Cleanup Script
 * 
 * This script removes abandoned transactions that are older than 24 hours
 * to prevent storage waste and keep the database clean.
 * 
 * Note: With the new system, only successful transactions are stored in DB,
 * so this script mainly handles legacy data and session cleanup.
 * 
 * Run this script periodically (e.g., daily via cron job)
 */

require_once __DIR__ . '/../admin/config/dbcon.php';
require_once __DIR__ . '/PaystackHelper.php';

// Start session
session_start();

// Check if this is a CLI request or web request
$isCli = php_sapi_name() === 'cli';

if ($isCli) {
    echo "Starting Paystack transaction cleanup...\n";
} else {
    echo "<h2>Paystack Transaction Cleanup</h2>";
}

try {
    // Initialize Paystack helper
    $paystack = new PaystackHelper($conn);
    
    // Get count of transactions before cleanup
    $sql = "SELECT COUNT(*) as count FROM paystack_transactions";
    $result = $conn->query($sql);
    $beforeCount = $result->fetch_assoc()['count'];
    
    if ($isCli) {
        echo "Found $beforeCount total transactions in database\n";
    } else {
        echo "<p>Found <strong>$beforeCount</strong> total transactions in database</p>";
    }
    
    // Clean up any legacy pending transactions (should be none with new system)
    $cleanedCount = $paystack->cleanupAbandonedTransactions();
    
    if ($isCli) {
        echo "Cleaned up $cleanedCount legacy pending transactions\n";
    } else {
        echo "<p>Cleaned up <strong>$cleanedCount</strong> legacy pending transactions</p>";
    }
    
    // Clean up old session data
    $sessionCleaned = 0;
    if (isset($_SESSION['paystack_pending_transactions'])) {
        $originalSessionCount = count($_SESSION['paystack_pending_transactions']);
        
        foreach ($_SESSION['paystack_pending_transactions'] as $ref => $data) {
            if (time() - $data['created_at'] > 3600) { // Older than 1 hour
                unset($_SESSION['paystack_pending_transactions'][$ref]);
                $sessionCleaned++;
            }
        }
        
        if ($isCli) {
            echo "Cleaned up $sessionCleaned old session entries\n";
        } else {
            echo "<p>Cleaned up <strong>$sessionCleaned</strong> old session entries</p>";
        }
    }
    
    // Get count after cleanup
    $result = $conn->query($sql);
    $afterCount = $result->fetch_assoc()['count'];
    
    if ($isCli) {
        echo "Remaining transactions: $afterCount\n";
        echo "Cleanup completed successfully!\n";
    } else {
        echo "<p>Remaining transactions: <strong>$afterCount</strong></p>";
        echo "<p style='color: green;'><strong>Cleanup completed successfully!</strong></p>";
    }
    
    // Log the cleanup
    error_log("Paystack cleanup: Removed $cleanedCount legacy transactions and $sessionCleaned session entries. Remaining: $afterCount");
    
} catch (Exception $e) {
    $error = $e->getMessage();
    
    if ($isCli) {
        echo "Error during cleanup: $error\n";
    } else {
        echo "<p style='color: red;'>Error during cleanup: $error</p>";
    }
    
    error_log("Paystack cleanup error: $error");
}

// Show additional statistics if web request
if (!$isCli) {
    echo "<h3>Transaction Statistics</h3>";
    
    // Get transaction statistics
    $stats = [
        'total' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions")->fetch_assoc()['count'],
        'successful' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions WHERE status = 'success'")->fetch_assoc()['count'],
        'pending' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions WHERE status = 'pending'")->fetch_assoc()['count'],
        'failed' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions WHERE status = 'failed'")->fetch_assoc()['count']
    ];
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Status</th><th>Count</th><th>Description</th></tr>";
    echo "<tr><td>Total Transactions</td><td>{$stats['total']}</td><td>All transactions in database</td></tr>";
    echo "<tr><td>Successful</td><td>{$stats['successful']}</td><td>Completed payments (permanent)</td></tr>";
    echo "<tr><td>Pending</td><td>{$stats['pending']}</td><td>Legacy pending transactions</td></tr>";
    echo "<tr><td>Failed</td><td>{$stats['failed']}</td><td>Failed payments (kept for analysis)</td></tr>";
    echo "</table>";
    
    // Show session statistics
    $sessionCount = isset($_SESSION['paystack_pending_transactions']) ? count($_SESSION['paystack_pending_transactions']) : 0;
    echo "<h3>Session Statistics</h3>";
    echo "<p>Pending transactions in session: <strong>$sessionCount</strong></p>";
    
    echo "<h3>Storage Optimization Benefits</h3>";
    echo "<div class='alert alert-success'>";
    echo "<h6><i class='fas fa-check-circle me-2'></i>New System Benefits</h6>";
    echo "<ul class='mb-0'>";
    echo "<li><strong>Zero storage waste:</strong> No database records created until payment succeeds</li>";
    echo "<li><strong>Session-based tracking:</strong> Pending transactions stored in session (temporary)</li>";
    echo "<li><strong>Automatic cleanup:</strong> Session data expires after 1 hour</li>";
    echo "<li><strong>100% efficiency:</strong> Only successful payments consume database storage</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<p><small>Run this script daily to keep your database clean and prevent storage waste.</small></p>";
}
?> 