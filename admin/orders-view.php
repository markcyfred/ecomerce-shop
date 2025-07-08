<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');
include '../admin/config/dbcon.php';
?>

<style>
    .breadcrumb {
        display: flex;
        justify-content: space-between;
    }

    /* Hide the Zip For Me upload form initially */
    #zipUploadForm {
        display: none;
        margin-top: 20px;
    }

    /* Place the Zip For Me button in the top right */
    .zip-for-me-btn {
        float: right;
        margin: 10px 0;
    }

    /* Style for processing message */
    #processingMsg {
        display: none;
        margin-top: 20px;
        font-weight: bold;
        color: #007bff;
    }

    /* Ensure horizontal scroll for wide tables */
    .orders-scroll-x {
        overflow-x: auto;
        width: 100vw;
        margin-left: -12px;
        margin-right: -12px;
        padding-left: 12px;
        padding-right: 12px;
    }
    .table {
        min-width: 1400px;
    }
</style>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>View Orders</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">View Orders Forms</li>
                <li class="breadcrumb-item active">
                    <a href="index.php">
                        <i class="ri-arrow-go-back-fill"></i> Home
                    </a>
                </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="orders-scroll-x">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Customer Code</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Order Status</th>
                                <th scope="col">Shipment Number</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Destination</th>
                                <th scope="col">Precise Location</th>
                                <th scope="col">Location Method</th>
                                <th scope="col">Distance</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $orders = mysqli_query($conn, "SELECT c.id, u.customer_code, u.first_name, u.last_name, c.status, c.order_status, c.shipment_number, c.total_amount, c.discount, c.destination, c.precise_location_name, c.location_method, c.distance FROM checkout c LEFT JOIN users u ON c.user_id = u.id ORDER BY c.created_at DESC");
                            if (mysqli_num_rows($orders) > 0) {
                                $i = 1;
                                foreach ($orders as $order) {
                            ?>
                                    <tr>
                                        <th><?= $i++; ?></th>
                                        <td><?= htmlspecialchars($order['customer_code']) ?></td>
                                        <td><?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?></td>
                                        <td>
                                            <?php if ($order['status'] == 'paid') : ?>
                                                <span class="badge bg-success">Paid</span>
                                            <?php elseif ($order['status'] == 'pending') : ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php elseif ($order['status'] == 'cancelled') : ?>
                                                <span class="badge bg-danger">Cancelled</span>
                                            <?php else : ?>
                                                <span class="badge bg-secondary">Other</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php
                                            $statusClass = 'btn-secondary';
                                            switch (strtolower($order['order_status'])) {
                                                case 'on hold': $statusClass = 'btn-secondary'; break;
                                                case 'picking': $statusClass = 'btn-info'; break;
                                                case 'picked': $statusClass = 'btn-primary'; break;
                                                case 'packed': $statusClass = 'btn-primary'; break;
                                                case 'shipped': $statusClass = 'btn-warning'; break;
                                                case 'delivered': $statusClass = 'btn-success'; break;
                                                case 'returned': $statusClass = 'btn-danger'; break;
                                                case 'refunded': $statusClass = 'btn-dark'; break;
                                                case 'cancelled': $statusClass = 'btn-danger'; break;
                                                case 'processing': $statusClass = 'btn-info'; break;
                                                case 'failed': $statusClass = 'btn-danger'; break;
                                                case 'completed': $statusClass = 'btn-success'; break;
                                            }
                                            ?>
                                            <span class="btn btn-sm <?= $statusClass ?> disabled"><?= htmlspecialchars(ucwords($order['order_status'])) ?></span>
                                        </td>
                                        <td><?= htmlspecialchars($order['shipment_number']) ?></td>
                                        <td><?= htmlspecialchars($order['total_amount']) ?></td>
                                        <td><?= htmlspecialchars($order['discount']) ?></td>
                                        <td><?= htmlspecialchars($order['destination']) ?></td>
                                        <td><?= htmlspecialchars($order['precise_location_name']) ?></td>
                                        <td><?= htmlspecialchars($order['location_method']) ?></td>
                                        <td><?= htmlspecialchars($order['distance']) ?></td>
                                        <td>
                                            <a href="edit-order.php?id=<?= $order['id']; ?>" class="text-primary me-2"><i class="ri-edit-2-fill fs-4"></i></a>
                                            <a href="delete-order.php?id=<?= $order['id']; ?>" class="text-danger delete-btn"><i class="bi bi-trash fs-4"></i></a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='13'>No orders found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
<?php
include('includes/footer.php');
?> 