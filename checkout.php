<?php
// checkout.php
include 'admin/config/dbcon.php'; // Ensure you include your DB connection file
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Function to generate unique tokens
function generateUniqueToken($prefix = '') {
    $token = $prefix . '_' . uniqid() . '_' . bin2hex(random_bytes(16));
    return $token;
}

// Function to generate an order/shipment number including customer's first name, date, and random digits.
function generateOrderNumber($firstName) {
     $namePart = strtolower(trim($firstName));
     $randomPart = substr(str_shuffle('ABCDEFGHJKMNPQRSTUVWXYZ23456789'), 0, 4); // Avoid similar-looking chars
     return $namePart . '-ship-' . $randomPart;
 }
 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$session_id = session_id();

// Get cart items
$cart_items = getCartItems($conn, $session_id);

if (empty($cart_items)) {
    header('Location: cart.php');
    exit();
}

// Calculate totals
$cart_subtotal = 0;
foreach ($cart_items as $item) {
    $cart_subtotal += $item['price'] * $item['quantity'];
}

// Get shipping cost (you can implement your own shipping calculation logic)
$shipping_cost = calculateShippingCost($cart_subtotal);
$total_amount = $cart_subtotal + $shipping_cost;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $destination = $_POST['destination'] ?? '';
    $state = $_POST['state'] ?? '';
    $postcode = $_POST['postcode'] ?? '';
    $user_lat = $_POST['user_lat'] ?? null;
    $user_lng = $_POST['user_lng'] ?? null;
    $destination_lat = $_POST['destination_lat'] ?? null;
    $destination_lng = $_POST['destination_lng'] ?? null;

    // Generate unique shipment number
    $shipment_number = 'SHIP-' . strtoupper(substr(md5(uniqid()), 0, 8));

    // Generate unique checkout token
    $checkout_token = generateUniqueToken('ord');

    try {
        // Start transaction
        $conn->begin_transaction();

        // Insert checkout record with token
        $stmt = $conn->prepare("INSERT INTO checkout (token, user_id, session_id, shipment_number, cart_subtotal, shipping_cost, total_amount, destination, state, postcode, user_lat, user_lng, destination_lat, destination_lng, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'unprocessed')");
        $stmt->bind_param("sissddddsssddd", $checkout_token, $user_id, $session_id, $shipment_number, $cart_subtotal, $shipping_cost, $total_amount, $destination, $state, $postcode, $user_lat, $user_lng, $destination_lat, $destination_lng);
        $stmt->execute();
        $checkout_id = $conn->insert_id;

        // Update cart items with checkout token and mark as processed
        $stmt = $conn->prepare("UPDATE cart SET checkout_token = ?, cart_status = 'processed' WHERE session_id = ?");
        $stmt->bind_param("ss", $checkout_token, $session_id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        // Redirect to order confirmation page
        header("Location: order-confirmation.php?token=" . $checkout_token);
        exit();

    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $error = "An error occurred while processing your order. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Your Store</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places"></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container">
        <h1>Checkout</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="checkout-container">
            <div class="order-summary">
                <h2>Order Summary</h2>
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="item-details">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p>Quantity: <?php echo $item['quantity']; ?></p>
                            <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="order-totals">
                    <p>Subtotal: $<?php echo number_format($cart_subtotal, 2); ?></p>
                    <p>Shipping: $<?php echo number_format($shipping_cost, 2); ?></p>
                    <p class="total">Total: $<?php echo number_format($total_amount, 2); ?></p>
                </div>
            </div>

            <form method="POST" class="checkout-form" id="checkoutForm">
                <h2>Shipping Information</h2>
                
                <div class="form-group">
                    <label for="destination">Destination Address</label>
                    <input type="text" id="destination" name="destination" required>
                </div>

                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" id="state" name="state" required>
                </div>

                <div class="form-group">
                    <label for="postcode">Postal Code</label>
                    <input type="text" id="postcode" name="postcode" required>
                </div>

                <input type="hidden" id="user_lat" name="user_lat">
                <input type="hidden" id="user_lng" name="user_lng">
                <input type="hidden" id="destination_lat" name="destination_lat">
                <input type="hidden" id="destination_lng" name="destination_lng">

                <div id="map" style="height: 300px; margin: 20px 0;"></div>

                <button type="submit" class="btn btn-primary">Place Order</button>
            </form>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script>
        let map;
        let userMarker;
        let destinationMarker;
        let directionsService;
        let directionsRenderer;

        function initMap() {
            // Initialize map
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 0, lng: 0 },
                zoom: 2
            });

            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            // Get user's location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;

                        // Set user location
                        document.getElementById('user_lat').value = userLat;
                        document.getElementById('user_lng').value = userLng;

                        // Add user marker
                        userMarker = new google.maps.Marker({
                            position: { lat: userLat, lng: userLng },
                            map: map,
                            title: 'Your Location',
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 10,
                                fillColor: '#4285F4',
                                fillOpacity: 1,
                                strokeColor: '#ffffff',
                                strokeWeight: 2
                            }
                        });

                        // Center map on user location
                        map.setCenter({ lat: userLat, lng: userLng });
                        map.setZoom(12);
                    },
                    (error) => {
                        console.error('Error getting location:', error);
                    }
                );
            }

            // Initialize autocomplete for destination
            const destinationInput = document.getElementById('destination');
            const autocomplete = new google.maps.places.Autocomplete(destinationInput);

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                if (place.geometry) {
                    const destinationLat = place.geometry.location.lat();
                    const destinationLng = place.geometry.location.lng();

                    // Set destination coordinates
                    document.getElementById('destination_lat').value = destinationLat;
                    document.getElementById('destination_lng').value = destinationLng;

                    // Update destination marker
                    if (destinationMarker) {
                        destinationMarker.setMap(null);
                    }

                    destinationMarker = new google.maps.Marker({
                        position: { lat: destinationLat, lng: destinationLng },
                        map: map,
                        title: 'Destination',
                        icon: {
                            path: google.maps.SymbolPath.CIRCLE,
                            scale: 10,
                            fillColor: '#EA4335',
                            fillOpacity: 1,
                            strokeColor: '#ffffff',
                            strokeWeight: 2
                        }
                    });

                    // Calculate and display route
                    calculateRoute();
                }
            });
        }

        function calculateRoute() {
            const userLat = parseFloat(document.getElementById('user_lat').value);
            const userLng = parseFloat(document.getElementById('user_lng').value);
            const destinationLat = parseFloat(document.getElementById('destination_lat').value);
            const destinationLng = parseFloat(document.getElementById('destination_lng').value);

            if (userLat && userLng && destinationLat && destinationLng) {
                const request = {
                    origin: { lat: userLat, lng: userLng },
                    destination: { lat: destinationLat, lng: destinationLng },
                    travelMode: google.maps.TravelMode.DRIVING
                };

                directionsService.route(request, (result, status) => {
                    if (status === 'OK') {
                        directionsRenderer.setDirections(result);
                    }
                });
            }
        }

        // Initialize map when page loads
        window.onload = initMap;
    </script>
</body>
</html>
