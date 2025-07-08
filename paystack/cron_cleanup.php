<?php
/**
 * Paystack Transaction Cleanup - Cron Job Script
 * 
 * This script is designed to be run via cron job to automatically
 * clean up abandoned transactions and prevent storage waste.
 * 
 * Recommended cron schedule: 0 2 * * * (daily at 2 AM)
 * 
 * Usage: php /path/to/your/project/paystack/cron_cleanup.php
 */

// Prevent web access
if (php_sapi_name() !== 'cli') {
    die('This script can only be run from command line');
}

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start timing
$startTime = microtime(true);

echo "=== Paystack Transaction Cleanup Cron Job ===\n";
echo "Started at: " . date('Y-m-d H:i:s') . "\n\n";

try {
    // Include required files
    require_once __DIR__ . '/../admin/config/dbcon.php';
    require_once __DIR__ . '/PaystackHelper.php';
    
    // Initialize Paystack helper
    $paystack = new PaystackHelper($conn);
    
    // Get statistics before cleanup
    $beforeStats = [
        'total' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions")->fetch_assoc()['count'],
        'pending' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions WHERE status = 'pending'")->fetch_assoc()['count'],
        'abandoned' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions WHERE status = 'pending' AND created_at < DATE_SUB(NOW(), INTERVAL 24 HOUR)")->fetch_assoc()['count']
    ];
    
    echo "Before cleanup:\n";
    echo "- Total transactions: {$beforeStats['total']}\n";
    echo "- Pending transactions: {$beforeStats['pending']}\n";
    echo "- Abandoned transactions (>24h): {$beforeStats['abandoned']}\n\n";
    
    // Perform cleanup
    echo "Performing cleanup...\n";
    $cleanedCount = $paystack->cleanupAbandonedTransactions();
    
    // Get statistics after cleanup
    $afterStats = [
        'total' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions")->fetch_assoc()['count'],
        'pending' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions WHERE status = 'pending'")->fetch_assoc()['count']
    ];
    
    echo "After cleanup:\n";
    echo "- Total transactions: {$afterStats['total']}\n";
    echo "- Pending transactions: {$afterStats['pending']}\n";
    echo "- Transactions cleaned: $cleanedCount\n\n";
    
    // Calculate storage saved (approximate)
    $storageSaved = $cleanedCount * 1024; // Assume ~1KB per transaction record
    echo "Storage optimization:\n";
    echo "- Records removed: $cleanedCount\n";
    echo "- Approximate storage saved: " . number_format($storageSaved) . " bytes (" . round($storageSaved / 1024, 2) . " KB)\n\n";
    
    // Log the cleanup
    $logMessage = sprintf(
        "Paystack cleanup cron: Removed %d abandoned transactions. Before: %d total, %d pending. After: %d total, %d pending. Storage saved: ~%s KB",
        $cleanedCount,
        $beforeStats['total'],
        $beforeStats['pending'],
        $afterStats['total'],
        $afterStats['pending'],
        round($storageSaved / 1024, 2)
    );
    
    error_log($logMessage);
    
    // Calculate execution time
    $executionTime = microtime(true) - $startTime;
    
    echo "Cleanup completed successfully!\n";
    echo "Execution time: " . round($executionTime, 3) . " seconds\n";
    echo "Finished at: " . date('Y-m-d H:i:s') . "\n";
    
    // Exit with success code
    exit(0);
    
} catch (Exception $e) {
    $error = $e->getMessage();
    $executionTime = microtime(true) - $startTime;
    
    echo "ERROR: $error\n";
    echo "Execution time: " . round($executionTime, 3) . " seconds\n";
    echo "Finished at: " . date('Y-m-d H:i:s') . "\n";
    
    // Log the error
    error_log("Paystack cleanup cron error: $error");
    
    // Exit with error code
    exit(1);
}
?> 