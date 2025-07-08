<?php
/**
 * Orders Page - Clean Table Layout
 */

include 'admin/config/dbcon.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
session_start();
}

// Check if user is logged in
if (!isset($_SESSION['auth_user']['id'])) {
    header('Location: login.php?error=Please login to view your orders');
    exit();
}

$user_id = $_SESSION['auth_user']['id'];

// Check if payment was successful (for fireworks)
$payment_success = isset($_GET['payment_success']) && $_GET['payment_success'] === 'true';
$payment_reference = $_GET['reference'] ?? '';

// Handle payment success notification (but don't update status here - let verification handle it)
if ($payment_success && !empty($payment_reference)) {
    // Set success message for display
    $_SESSION['message'] = "Payment successful! Your order has been confirmed.";
    $_SESSION['message_type'] = "success";
    
    // Log the success notification
    error_log("Payment success notification received for reference: $payment_reference");
}

// Get user details
$stmt = $conn->prepare("SELECT first_name, last_name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Check if user data exists
if (!$user) {
    header('Location: login.php?error=User not found');
    exit();
}

// Get all orders for this user
$orders_query = "SELECT c.*, 
                        pt.reference as payment_reference,
                        pt.status as payment_status,
                        pt.amount as payment_amount,
                        pt.created_at as payment_date
    FROM checkout c
                 LEFT JOIN paystack_transactions pt ON c.id = pt.order_id 
    WHERE c.user_id = ?
                 ORDER BY c.created_at DESC";
$stmt = $conn->prepare($orders_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
$stmt->close();

// Function to get order items count
function getOrderItemsCount($conn, $token) {
    if (empty($token)) {
        return 0;
    }
    $cart_query = "SELECT COUNT(*) as count FROM cart WHERE checkout_token = ? AND cart_status = 'processed'";
    $stmt = $conn->prepare($cart_query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['count'];
}

// Function to get status badge class
function getStatusBadgeClass($status) {
    switch ($status) {
        case 'paid':
            return 'badge-success';
        case 'pending':
            return 'badge-warning';
        case 'cancelled':
            return 'badge-danger';
        default:
            return 'badge-secondary';
    }
}

// Function to get status icon
function getStatusIcon($status) {
    switch ($status) {
        case 'paid':
            return 'fas fa-check-circle';
        case 'pending':
            return 'fas fa-clock';
        case 'cancelled':
            return 'fas fa-times-circle';
        default:
            return 'fas fa-question-circle';
    }
}

// Ensure user data is safe with proper fallbacks
$user_first_name = trim($user['first_name'] ?? '');
$user_last_name = trim($user['last_name'] ?? '');
$user_email = trim($user['email'] ?? '');

// If first_name is empty, try to get it from session
if (empty($user_first_name) && isset($_SESSION['auth_user']['first_name'])) {
    $user_first_name = trim($_SESSION['auth_user']['first_name']);
}

// Fallback display name
$display_name = !empty($user_first_name) ? $user_first_name : 'User';

include 'includes/header.php';
?>

<aside id="notifications">
    <div class="container">
        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-' . $_SESSION['message_type'] . ' alert-dismissible fade show" role="alert">
                ' . $_SESSION['message'] . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        ?>
    </div>
</aside>

<nav style="margin-bottom: 20px;" data-depth="3" class="breadcrumb">
    <div class="container">
        <ol>
            <li>
                <a href="index.php"><span>Home</span></a>
            </li>
            <li>
                <span>My Orders</span>
            </li>
        </ol>
    </div>
</nav>

<style>
    .breadcrumb {
        text-align: left;
    }

    .breadcrumb .container {
        display: flex;
        justify-content: flex-start;
    }

    .breadcrumb ol {
        display: flex;
        gap: 5px;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .breadcrumb ol {
        justify-content: flex-end;
        width: 80%;
    }

    .orders-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .orders-header {
        background: #f8f9fa;
        padding: 20px;
        border-bottom: 1px solid #dee2e6;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .orders-table th {
        background: #f8f9fa;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #dee2e6;
    }

    .orders-table td {
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
    }

    .orders-table tr:hover {
        background-color: #f8f9fa;
    }

    .order-number {
        font-weight: 600;
        color: #007bff;
    }

    .order-date {
        color: #6c757d;
        font-size: 0.9em;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85em;
        font-weight: 500;
        text-transform: uppercase;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-secondary {
        background: #e2e3e5;
        color: #383d41;
    }

    .order-total {
        font-weight: 600;
        color: #28a745;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 5px 12px;
        font-size: 0.85em;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: #007bff;
        color: white;
        border: 1px solid #007bff;
    }

    .btn-primary:hover {
        background: #0056b3;
        border-color: #0056b3;
        color: white;
    }

    .btn-success {
        background: #28a745;
        color: white;
        border: 1px solid #28a745;
    }

    .btn-success:hover {
        background: #1e7e34;
        border-color: #1e7e34;
        color: white;
    }

    .btn-info {
        background: #17a2b8;
        color: white;
        border: 1px solid #17a2b8;
    }

    .btn-info:hover {
        background: #117a8b;
        border-color: #117a8b;
        color: white;
    }

    .empty-orders {
        text-align: center;
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 8px;
        margin: 20px 0;
    }

    .empty-orders i {
        font-size: 4rem;
        color: #6c757d;
        margin-bottom: 20px;
    }

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        text-align: center;
    }

    .stat-card .number {
        font-size: 2rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 5px;
    }

    .stat-card .label {
        color: #6c757d;
        font-size: 0.9em;
    }

    @media (max-width: 768px) {
        .orders-table {
            font-size: 0.9em;
        }
        
        .orders-table th,
        .orders-table td {
            padding: 10px 8px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-sm {
            width: 100%;
            justify-content: center;
        }
    }
    
    /* Fireworks container */
    #fireworks-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        pointer-events: none;
        display: none;
    }
</style>

<section id="wrapper">
    <div class="container">
        <div id="columns_inner">
            <div id="content-wrapper" class="js-content-wrapper">
                <section id="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h1><i class="fas fa-shopping-bag me-2"></i>My Orders</h1>
                                <div>
                                    <span class="text-muted">Welcome, <?= htmlspecialchars($display_name) ?>!</span>
                                </div>
                            </div>

        <?php if (empty($orders)): ?>
                                <div class="empty-orders">
                                    <i class="fas fa-shopping-bag"></i>
                                    <h3>No Orders Yet</h3>
                                    <p class="text-muted">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                                    <a href="shop.php" class="btn btn-primary">
                                        <i class="fas fa-shopping-cart me-1"></i>Start Shopping
                                    </a>
            </div>
        <?php else: ?>
                                <!-- Order Statistics -->
                                <?php 
                                $total_orders = count($orders);
                                $paid_orders = count(array_filter($orders, function($order) { return $order['status'] === 'paid'; }));
                                $pending_orders = count(array_filter($orders, function($order) { return $order['status'] === 'pending'; }));
                                ?>
                                
                                <div class="stats-cards">
                                    <div class="stat-card">
                                        <div class="number"><?= $total_orders ?></div>
                                        <div class="label">Total Orders</div>
                                    </div>
                                    <div class="stat-card">
                                        <div class="number"><?= $paid_orders ?></div>
                                        <div class="label">Paid Orders</div>
                                    </div>
                                    <div class="stat-card">
                                        <div class="number"><?= $pending_orders ?></div>
                                        <div class="label">Pending Payment</div>
                                    </div>
                        </div>

                                <!-- Orders Table -->
                                <div class="orders-container">
                                    <div class="orders-header">
                                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Order History</h5>
                        </div>

                                    <div class="table-responsive">
                                        <table class="orders-table">
                                            <thead>
                                                <tr>
                                                    <th>Order</th>
                                                    <th>Date</th>
                                                    <th>Items</th>
                                                    <th>Status</th>
                                                    <th>Total</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($orders as $order): ?>
                                                    <?php 
                                                    // Use the correct token field - try both token and checkout_token
                                                    $order_token = $order['token'] ?? $order['checkout_token'] ?? '';
                                                    $items_count = $order_token ? getOrderItemsCount($conn, $order_token) : 0;
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <div class="order-number">
                                                                #<?= htmlspecialchars($order['shipment_number'] ?? 'N/A') ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="order-date">
                                                                <?= date('M d, Y', strtotime($order['created_at'])) ?><br>
                                                                <small><?= date('H:i', strtotime($order['created_at'])) ?></small>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted"><?= $items_count ?> item<?= $items_count != 1 ? 's' : '' ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="status-badge <?= getStatusBadgeClass($order['status']) ?>">
                                                                <i class="<?= getStatusIcon($order['status']) ?>"></i>
                                                                <?= ucfirst($order['status']) ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="order-total">
                                                                Kes <?= number_format($order['total_amount'], 2) ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="action-buttons">
                                                                <a href="order-details.php?token=<?= urlencode($order_token) ?>" class="btn btn-info btn-sm">
                                                                    <i class="fas fa-eye"></i> View
                                                                </a>
                                                                
                                                                <?php if ($order['status'] === 'paid'): ?>
                                                                    <a href="customer-receipts.php?token=<?= urlencode($order_token) ?>" class="btn btn-success btn-sm">
                                                                        <i class="fas fa-receipt"></i> Receipt
                                                                    </a>
                                                                <?php elseif ($order['status'] === 'pending'): ?>
                                                                    <a href="order-confirmation.php?token=<?= urlencode($order_token) ?>" class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-credit-card"></i> Pay Now
                                                                    </a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

<!-- Fireworks Container -->
<div id="fireworks-container"></div>

    <?php include 'includes/footer.php'; ?>

<!-- Particles.js Library -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Fireworks and Success Handling -->
<script>
<?php if ($payment_success): ?>
// Fireworks Configuration
const fireworksConfig = {
    particles: {
        number: {
            value: 0,
            density: {
                enable: true,
                value_area: 800
            }
        },
        color: {
            value: ["#ff0000", "#00ff00", "#0000ff", "#ffff00", "#ff00ff", "#00ffff"]
        },
        shape: {
            type: "circle",
            stroke: {
                width: 0,
                color: "#000000"
            },
            polygon: {
                nb_sides: 5
            }
        },
        opacity: {
            value: 1,
            random: false,
            anim: {
                enable: false,
                speed: 1,
                opacity_min: 0.1,
                sync: false
            }
        },
        size: {
            value: 3,
            random: true,
            anim: {
                enable: false,
                speed: 40,
                size_min: 0.1,
                sync: false
            }
        },
        line_linked: {
            enable: false,
            distance: 150,
            color: "#ffffff",
            opacity: 0.4,
            width: 1
        },
        move: {
            enable: true,
            speed: 6,
            direction: "none",
            random: false,
            straight: false,
            out_mode: "out",
            bounce: false,
            attract: {
                enable: false,
                rotateX: 600,
                rotateY: 1200
            }
        }
    },
    interactivity: {
        detect_on: "canvas",
        events: {
            onhover: {
                enable: true,
                mode: "repulse"
            },
            onclick: {
                enable: true,
                mode: "push"
            },
            resize: true
        },
        modes: {
            grab: {
                distance: 400,
                line_linked: {
                    opacity: 1
                }
            },
            bubble: {
                distance: 400,
                size: 40,
                duration: 2,
                opacity: 8,
                speed: 3
            },
            repulse: {
                distance: 200,
                duration: 0.4
            },
            push: {
                particles_nb: 4
            },
            remove: {
                particles_nb: 2
            }
        }
    },
    retina_detect: true
};

// Initialize fireworks
let fireworksParticles;

function initFireworks() {
    const container = document.getElementById('fireworks-container');
    container.style.display = 'block';
    
    fireworksParticles = particlesJS('fireworks-container', fireworksConfig);
}

function stopFireworks() {
    if (fireworksParticles) {
        fireworksParticles.destroy();
    }
    const container = document.getElementById('fireworks-container');
    container.style.display = 'none';
}

function showSuccess() {
    // Show fireworks
    initFireworks();
    
    // Stop fireworks after exactly 4 seconds
    setTimeout(() => {
        stopFireworks();
    }, 4000);
}

function hideSuccess() {
    stopFireworks();
    
    // Clean up URL parameters
    const newUrl = window.location.pathname;
    window.history.replaceState({}, document.title, newUrl);
}

// Show fireworks and success message when page loads
document.addEventListener('DOMContentLoaded', function() {
    showSuccess();
});
<?php endif; ?>
</script>

<!-- Handle URL parameters for SweetAlert messages -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    const messageType = urlParams.get('message_type');
    
    // If message parameters exist, show SweetAlert
    if (message && messageType) {
        // Determine icon based on message type
        let icon = 'info';
        switch(messageType) {
            case 'success':
                icon = 'success';
                break;
            case 'error':
            case 'danger':
                icon = 'error';
                break;
            case 'warning':
                icon = 'warning';
                break;
            default:
                icon = 'info';
        }
        
        // Show SweetAlert toast
        Swal.fire({
            position: 'top-end',
            icon: icon,
            title: message,
            toast: true,
            showConfirmButton: false,
            timer: 3000,
            width: 'auto',
            padding: '0.1em',
            background: 'white',
            customClass: {
                container: 'my-swal-container'
            }
        });
        
        // Clean up URL parameters without page reload
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
});
</script>

</body>
</html> 