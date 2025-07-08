<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../admin/config/dbcon.php';
session_start();

header('Content-Type: application/json');

if (!isset($_POST['lat']) || !isset($_POST['lng'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
    exit;
}

$destination = $_POST['destination'] ?? 'Unknown Location';
$customer_lat = $_POST['lat'];
$customer_lng = $_POST['lng'];
$user_lat = $_POST['user_lat'] ?? $customer_lat;
$user_lng = $_POST['user_lng'] ?? $customer_lng;

// Get precise location name from search results or construct it
$precise_location_name = $_POST['precise_location_name'] ?? '';

// Debug: Log the received precise location name
error_log("Received precise_location_name: " . $precise_location_name);
error_log("POST data: " . print_r($_POST, true));

// If precise location name is not provided, try to get it from the search input
if (empty($precise_location_name)) {
    $search_term = $_POST['search_term'] ?? '';
    if (!empty($search_term)) {
        // Try to get full location details from OpenStreetMap
        $geocode_url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$customer_lat}&lon={$customer_lng}&addressdetails=1&zoom=10";
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'EcommerceShop/1.0'
            ]
        ]);
        
        $geocode_response = @file_get_contents($geocode_url, false, $context);
        
        if ($geocode_response !== false) {
            $geocode_data = json_decode($geocode_response, true);
            if ($geocode_data && isset($geocode_data['display_name'])) {
                $precise_location_name = $geocode_data['display_name'];
            }
        }
    }
}

// If still no precise location name, construct one from available data
if (empty($precise_location_name)) {
    $state = $_POST['state'] ?? '';
    $postcode = $_POST['postcode'] ?? '';
    
    $location_parts = [];
    if (!empty($destination)) $location_parts[] = $destination;
    if (!empty($state)) $location_parts[] = $state;
    if (!empty($postcode)) $location_parts[] = $postcode;
    $location_parts[] = 'Kenya';
    
    $precise_location_name = implode(', ', $location_parts);
}

// Store coordinates (Nairobi)
$store_lat = -1.2921;
$store_lng = 36.8219;

// Calculate distance using Haversine formula
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $earth_radius = 6371; // Radius of the earth in km

    $lat_delta = deg2rad($lat2 - $lat1);
    $lon_delta = deg2rad($lon2 - $lon1);

    $a = sin($lat_delta/2) * sin($lat_delta/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($lon_delta/2) * sin($lon_delta/2);
    
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $distance = $earth_radius * $c;

    return round($distance, 2);
}

$distance = calculateDistance($store_lat, $store_lng, $customer_lat, $customer_lng);

// Calculate shipping cost based on distance
// Base rate: Kes 100 for first 5km
// Additional Kes 20 per km after that
$shipping_cost = 100;
if ($distance > 5) {
    $shipping_cost += ($distance - 5) * 20;
}

// Get cart total
$session_id = session_id();
$user_id = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;

$cart_query = "SELECT SUM(p.selling_price * c.quantity) as total_price FROM cart c 
               JOIN products p ON c.product_id = p.id 
               WHERE c.cart_status = 'unprocessed' 
               AND (c.session_id = '$session_id'" . ($user_id ? " OR c.user_id = '$user_id'" : "") . ")";

$cart_result = mysqli_query($conn, $cart_query);
$cart_row = mysqli_fetch_assoc($cart_result);
$cart_total = $cart_row['total_price'] ?? 0;

// Calculate final total
$final_total = $cart_total + $shipping_cost;

// Store shipping info in session for checkout
$_SESSION['shipping_info'] = [
    'destination' => $destination,
    'state' => $_POST['state'] ?? '',
    'postcode' => $_POST['postcode'] ?? '',
    'lat' => $customer_lat,
    'lng' => $customer_lng,
    'user_lat' => $user_lat,
    'user_lng' => $user_lng,
    'distance' => $distance,
    'shipping_cost' => $shipping_cost,
    'final_total' => $final_total,
    'precise_location_name' => $precise_location_name,
    'location_method' => $_POST['location_method'] ?? ''
];

echo json_encode([
    'status' => 'success',
    'distance' => (float)$distance,
    'shipping_cost' => (float)$shipping_cost,
    'cart_total' => (float)$cart_total,
    'final_total' => (float)$final_total,
    'destination' => $destination,
    'precise_location_name' => $precise_location_name
]);

$conn->close();
?> 