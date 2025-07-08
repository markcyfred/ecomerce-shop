<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');
include '../admin/config/dbcon.php';

// Get order ID from query string
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($order_id <= 0) {
    echo '<div class="alert alert-danger">Invalid order ID.</div>';
    include('includes/footer.php');
    exit;
}

// Fetch order data
$order = mysqli_query($conn, "SELECT * FROM checkout WHERE id='$order_id' LIMIT 1");
if (!$order || mysqli_num_rows($order) == 0) {
    echo '<div class="alert alert-danger">Order not found.</div>';
    include('includes/footer.php');
    exit;
}
$order = mysqli_fetch_assoc($order);

// Fetch stops for the route if route_id is present
$route_id = isset($order['route_id']) ? intval($order['route_id']) : 0;
$stops_coords = [];
if ($route_id > 0) {
    $stopsQ = mysqli_query($conn, "SELECT l.name, l.lat, l.lng FROM route_stops rs JOIN locations l ON rs.location_id = l.id WHERE rs.route_id = $route_id ORDER BY rs.stop_order ASC");
    while($stop = mysqli_fetch_assoc($stopsQ)) {
        $stops_coords[] = $stop;
    }
}

$current_page = basename($_SERVER['PHP_SELF']);
$transport_pages = [
  'picking-list.php', 'packing-list.php', 'vehicle-allocation.php',
  'route-to-vehicle.php', 'create-route.php', 'vehicle-management.php', 'shipment-confirmation.php'
];
$is_transport = in_array($current_page, $transport_pages);
?>
<style>
    .breadcrumb {
        display: flex;
        justify-content: space-between;
    }
</style>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Order</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Edit Order Forms</li>
                <li class="breadcrumb-item active">
                    <a href="orders-view.php">
                        <i class="ri-arrow-go-back-fill"></i> Orders
                    </a>
                </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Order Details</h5>
                        <div class="col-md-12">
                            <label class="form-label">Order Route Map</label>
                            <div id="order-map" style="height: 400px; width: 100%; margin-bottom: 1em;"></div>
                        </div>
                        <form method="POST" action="code.php" class="row g-3">
                            <input type="hidden" name="order_id" value="<?= $order_id ?>">
                            <input type="hidden" name="route_id" value="<?= isset($order['route_id']) ? $order['route_id'] : '' ?>">
                            <div class="col-md-6">
                                <label class="form-label">Order Status (ERP)</label>
                                <select name="order_status" class="form-select" required>
                                    <option value="on hold" <?= $order['order_status'] == 'on hold' ? 'selected' : '' ?>>On Hold</option>
                                    <option value="picking" <?= $order['order_status'] == 'picking' ? 'selected' : '' ?>>Picking</option>
                                    <option value="picked" <?= $order['order_status'] == 'picked' ? 'selected' : '' ?>>Picked</option>
                                    <option value="packed" <?= $order['order_status'] == 'packed' ? 'selected' : '' ?>>Packed</option>
                                    <option value="shipped" <?= $order['order_status'] == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option value="delivered" <?= $order['order_status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                    <option value="returned" <?= $order['order_status'] == 'returned' ? 'selected' : '' ?>>Returned</option>
                                    <option value="refunded" <?= $order['order_status'] == 'refunded' ? 'selected' : '' ?>>Refunded</option>
                                    <option value="cancelled" <?= $order['order_status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                    <option value="processing" <?= $order['order_status'] == 'processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="failed" <?= $order['order_status'] == 'failed' ? 'selected' : '' ?>>Failed</option>
                                    <option value="completed" <?= $order['order_status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Shipment Number</label>
                                <input type="text" name="shipment_number" class="form-control" value="<?= htmlspecialchars($order['shipment_number']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Cart Subtotal</label>
                                <input type="number" step="0.01" name="cart_subtotal" class="form-control" value="<?= htmlspecialchars($order['cart_subtotal']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Shipping Cost</label>
                                <input type="number" step="0.01" name="shipping_cost" class="form-control" value="<?= htmlspecialchars($order['shipping_cost']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Total Amount</label>
                                <input type="number" step="0.01" name="total_amount" class="form-control" value="<?= htmlspecialchars($order['total_amount']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Discount</label>
                                <input type="number" step="0.01" name="discount" class="form-control" value="<?= htmlspecialchars($order['discount']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Destination</label>
                                <input type="text" name="destination" class="form-control" value="<?= htmlspecialchars($order['destination']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control" value="<?= htmlspecialchars($order['state']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Postcode</label>
                                <input type="text" name="postcode" class="form-control" value="<?= htmlspecialchars($order['postcode']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">User Latitude</label>
                                <input type="text" name="user_lat" class="form-control" value="<?= htmlspecialchars($order['user_lat']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">User Longitude</label>
                                <input type="text" name="user_lng" class="form-control" value="<?= htmlspecialchars($order['user_lng']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Destination Latitude</label>
                                <input type="text" name="destination_lat" class="form-control" value="<?= htmlspecialchars($order['destination_lat']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Destination Longitude</label>
                                <input type="text" name="destination_lng" class="form-control" value="<?= htmlspecialchars($order['destination_lng']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="paid" <?= $order['status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
                                    <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Distance</label>
                                <input type="number" step="0.01" name="distance" class="form-control" value="<?= htmlspecialchars($order['distance']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Precise Location</label>
                                <input type="text" name="precise_location_name" class="form-control" value="<?= htmlspecialchars($order['precise_location_name']) ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location Method</label>
                                <input type="text" name="location_method" class="form-control" value="<?= htmlspecialchars($order['location_method']) ?>">
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary" name="update_order_btn">Update Order</button>
                                <a href="orders-view.php" class="btn btn-secondary">Back to Orders</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var startLat = <?= json_encode($order['user_lat']) ?>;
    var startLng = <?= json_encode($order['user_lng']) ?>;
    var endLat = <?= json_encode($order['destination_lat']) ?>;
    var endLng = <?= json_encode($order['destination_lng']) ?>;
    var stops = <?= json_encode($stops_coords) ?>;

    var map = L.map('order-map').setView([(parseFloat(startLat) + parseFloat(endLat))/2, (parseFloat(startLng) + parseFloat(endLng))/2], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Start marker
    var startMarker = L.marker([startLat, startLng], {
        icon: L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        })
    }).addTo(map).bindPopup('Start').openPopup();

    // Stops (if any)
    var routePoints = [[startLat, startLng]];
    stops.forEach(function(stop, idx) {
        if(stop.lat && stop.lng) {
            L.marker([stop.lat, stop.lng], {
                icon: L.icon({
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/252/252025.png',
                    iconSize: [32, 32],
                    iconAnchor: [16, 32],
                    popupAnchor: [0, -32]
                })
            }).addTo(map).bindPopup('Stop ' + (idx+1) + ': ' + (stop.name || ''));
            routePoints.push([parseFloat(stop.lat), parseFloat(stop.lng)]);
        }
    });

    // End marker
    var endMarker = L.marker([endLat, endLng], {
        icon: L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/149/149059.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        })
    }).addTo(map).bindPopup('End');
    routePoints.push([endLat, endLng]);

    // Draw polyline for route
    var polyline = L.polyline(routePoints, {color: 'blue'}).addTo(map);
    map.fitBounds(polyline.getBounds(), {padding: [30, 30]});
});
</script>
<?php
include('includes/footer.php');
?> 