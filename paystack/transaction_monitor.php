<?php
/**
 * Paystack Transaction Monitor
 * 
 * This page provides a dashboard to monitor Paystack transactions
 * and identify potential issues or abandoned payments.
 */

require_once __DIR__ . '/../admin/config/dbcon.php';
require_once __DIR__ . '/PaystackHelper.php';

// Start session
session_start();

// Check if user is admin
if (!isset($_SESSION['auth_user']['role_as']) || $_SESSION['auth_user']['role_as'] != 1) {
    header('Location: ../login.php?error=Access denied');
    exit();
}

// Handle cleanup action
if (isset($_POST['cleanup'])) {
    try {
        $paystack = new PaystackHelper($conn);
        $cleanedCount = $paystack->cleanupAbandonedTransactions();
        $message = "Successfully cleaned up $cleanedCount abandoned transactions";
        $messageType = "success";
    } catch (Exception $e) {
        $message = "Error during cleanup: " . $e->getMessage();
        $messageType = "error";
    }
}

// Get transaction statistics
$stats = [
    'total' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions")->fetch_assoc()['count'],
    'successful' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions WHERE status = 'success'")->fetch_assoc()['count'],
    'pending' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions WHERE status = 'pending'")->fetch_assoc()['count'],
    'failed' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions WHERE status = 'failed'")->fetch_assoc()['count'],
    'abandoned' => $conn->query("SELECT COUNT(*) as count FROM paystack_transactions WHERE status = 'pending' AND created_at < DATE_SUB(NOW(), INTERVAL 24 HOUR)")->fetch_assoc()['count']
];

// Get recent transactions
$recentTransactions = [];
$sql = "SELECT pt.*, c.shipment_number, u.first_name, u.last_name 
        FROM paystack_transactions pt 
        JOIN checkout c ON pt.order_id = c.id 
        JOIN users u ON pt.user_id = u.id 
        ORDER BY pt.created_at DESC 
        LIMIT 20";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $recentTransactions[] = $row;
}

include '../includes/header.php';
?>

<style>
    .stats-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .stats-number {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .stats-label {
        color: #6c757d;
        font-size: 0.9em;
    }
    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.8em;
        font-weight: bold;
    }
    .status-success { background: #d4edda; color: #155724; }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-failed { background: #f8d7da; color: #721c24; }
    .transaction-table {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .transaction-table th {
        background: #f8f9fa;
        padding: 12px;
        font-weight: 600;
    }
    .transaction-table td {
        padding: 12px;
        border-bottom: 1px solid #dee2e6;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1><i class="fas fa-chart-line me-2"></i>Paystack Transaction Monitor</h1>
            
            <?php if (isset($message)): ?>
                <div class="alert alert-<?= $messageType === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-2">
                    <div class="stats-card">
                        <div class="stats-number text-primary"><?= $stats['total'] ?></div>
                        <div class="stats-label">Total Transactions</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stats-card">
                        <div class="stats-number text-success"><?= $stats['successful'] ?></div>
                        <div class="stats-label">Successful</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stats-card">
                        <div class="stats-number text-warning"><?= $stats['pending'] ?></div>
                        <div class="stats-label">Pending</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stats-card">
                        <div class="stats-number text-danger"><?= $stats['failed'] ?></div>
                        <div class="stats-label">Failed</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stats-card">
                        <div class="stats-number text-info"><?= $stats['abandoned'] ?></div>
                        <div class="stats-label">Abandoned (>24h)</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stats-card">
                        <form method="POST" style="margin: 0;">
                            <button type="submit" name="cleanup" class="btn btn-warning btn-sm" 
                                    onclick="return confirm('Are you sure you want to clean up abandoned transactions?')">
                                <i class="fas fa-broom me-1"></i>Cleanup
                            </button>
                        </form>
                        <div class="stats-label mt-2">Remove Abandoned</div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Transactions -->
            <div class="transaction-table">
                <h5 class="p-3 mb-0 border-bottom">Recent Transactions</h5>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Customer</th>
                                <th>Order</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentTransactions as $transaction): ?>
                                <tr>
                                    <td>
                                        <code><?= htmlspecialchars($transaction['reference']) ?></code>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($transaction['first_name'] . ' ' . $transaction['last_name']) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($transaction['shipment_number']) ?>
                                    </td>
                                    <td>
                                        <strong>Kes <?= number_format($transaction['amount'], 2) ?></strong>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?= $transaction['status'] ?>">
                                            <?= ucfirst($transaction['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small><?= date('M d, Y H:i', strtotime($transaction['created_at'])) ?></small>
                                    </td>
                                    <td>
                                        <small><?= date('M d, Y H:i', strtotime($transaction['updated_at'])) ?></small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Storage Optimization Info -->
            <div class="alert alert-info mt-4">
                <h6><i class="fas fa-info-circle me-2"></i>Storage Optimization</h6>
                <p class="mb-2">This system automatically manages transaction storage:</p>
                <ul class="mb-0">
                    <li><strong>Pending transactions</strong> are stored temporarily and cleaned up after 24 hours</li>
                    <li><strong>Successful transactions</strong> are kept permanently for record-keeping</li>
                    <li><strong>Failed transactions</strong> are kept for analysis but can be cleaned up manually</li>
                    <li>Run the cleanup script daily to prevent storage waste</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?> 