<?php
// checkout.php
include 'admin/config/dbcon.php'; // Ensure you include your DB connection file
session_start();

// Function to generate an order/shipment number including customer's first name, date, and random digits.
function generateOrderNumber($firstName) {
     $namePart = strtolower(trim($firstName));
     $randomPart = substr(str_shuffle('ABCDEFGHJKMNPQRSTUVWXYZ23456789'), 0, 4); // Avoid similar-looking chars
     return $namePart . '-ship-' . $randomPart;
 }
 

// Check if the checkout form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user and session details
    $user_id    = isset($_SESSION['auth_user']['id']) ? $_SESSION['auth_user']['id'] : null;
    $session_id = session_id();

    // Retrieve the user's first name (adjust this according to your session or database structure)
    $firstName = isset($_SESSION['auth_user']['first_name']) ? $_SESSION['auth_user']['first_name'] : 'CUSTOMER';

    // Get shipping and cart details from the form submission (make sure these are provided as hidden inputs)
    $destination      = isset($_POST['destination']) ? trim($_POST['destination']) : '';
    $state            = isset($_POST['state']) ? trim($_POST['state']) : '';
    $postcode         = isset($_POST['postcode']) ? trim($_POST['postcode']) : '';
    $shipping_cost    = isset($_POST['shipping_cost']) ? floatval($_POST['shipping_cost']) : 0;
    $cart_subtotal    = isset($_POST['cart_subtotal']) ? floatval($_POST['cart_subtotal']) : 0;
    $total_amount     = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0;

    // Optional: geolocation coordinates (if captured)
    $user_lat         = isset($_POST['user_lat']) ? floatval($_POST['user_lat']) : null;
    $user_lng         = isset($_POST['user_lng']) ? floatval($_POST['user_lng']) : null;
    $destination_lat  = isset($_POST['destination_lat']) ? floatval($_POST['destination_lat']) : null;
    $destination_lng  = isset($_POST['destination_lng']) ? floatval($_POST['destination_lng']) : null;

    // Validate that location details are provided
    if (empty($destination) || empty($state) || empty($postcode)) {
        die("Location details are incomplete. Please ensure you have selected a destination and entered your state and postcode.");
    }

    // Generate the order (shipment) number using the customer's first name
    $order_number = generateOrderNumber($firstName);

    // Prepare the insert statement for the checkout table, now including the order_number field.
    // Adjust the prepared statement to include your new column (e.g., order_number)
    $stmt = $conn->prepare("INSERT INTO checkout (user_id, session_id, shipment_number, cart_subtotal, shipping_cost, total_amount, destination, state, postcode, user_lat, user_lng, destination_lat, destination_lng) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind the parameters. The type string "issddssdddddd" represents:
    // i: user_id, s: session_id, s: shipment_number, d: cart_subtotal, d: shipping_cost, d: total_amount, 
    // s: destination, s: state, s: postcode, d: user_lat, d: user_lng, d: destination_lat, d: destination_lng.
    $stmt->bind_param("issddssdddddd", 
        $user_id, 
        $session_id,
        $order_number, 
        $cart_subtotal, 
        $shipping_cost, 
        $total_amount, 
        $destination, 
        $state, 
        $postcode, 
        $user_lat, 
        $user_lng, 
        $destination_lat, 
        $destination_lng
    );

    // Execute the statement and update the cart status to 'processed' if successful.
    if ($stmt->execute()) {
        // Update the cart items to 'processed'
        $update_query = "UPDATE cart SET cart_status = 'processed' WHERE session_id = '$session_id'";
        if ($user_id) {
            $update_query .= " OR user_id = '$user_id'";
        }
        if (!$conn->query($update_query)) {
            error_log("Error updating cart status: " . $conn->error);
        }
        // Redirect to the order confirmation page with the new order's id
        header("Location: order_confirmation.php?order_id=" . $stmt->insert_id);
        exit;
    } else {
        echo "Error storing checkout data: " . $stmt->error;
    }
    $stmt->close();
}
?>
