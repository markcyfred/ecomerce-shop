<?php
include '../admin/config/dbcon.php';
session_start();

header('Content-Type: application/json');

if (!isset($_POST['address']) || !isset($_POST['lat']) || !isset($_POST['lng']) || !isset($_POST['token'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required parameters']);
    exit;
}

$address = $_POST['address'];
$customer_lat = $_POST['lat'];
$customer_lng = $_POST['lng'];
$token = $_POST['token'];

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

// Update the checkout table with shipping details
$stmt = $conn->prepare("UPDATE checkout SET 
    destination = ?,
    destination_lat = ?, 
    destination_lng = ?, 
    distance = ?, 
    shipping_cost = ?,
    total_amount = cart_subtotal + ? 
    WHERE token = ?");

$stmt->bind_param("sddddds", $address, $customer_lat, $customer_lng, $distance, $shipping_cost, $shipping_cost, $token);

if ($stmt->execute()) {
    // Get the updated total
    $stmt = $conn->prepare("SELECT total_amount FROM checkout WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    echo json_encode([
        'status' => 'success',
        'distance' => $distance,
        'shipping_cost' => $shipping_cost,
        'final_total' => $row['total_amount']
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update shipping details']);
}

$stmt->close();
$conn->close();
?>

<h3>Shipping Method</h3>
<div>
  <label>
    <input type="radio" name="shipping_method" value="store" checked>
    <strong>Cash and Carry</strong><br>
    <small>Collect from our store <b>Free</b></small>
  </label>
</div>
<div>
  <label>
    <input type="radio" name="shipping_method" value="delivery">
    <strong>Home Delivery</strong><br>
    <small>Delivery to your location</small>
  </label>
</div>

<!-- Location selection UI, hidden by default, inline only -->
<div id="delivery-location-section" style="display:none; margin-top: 20px;">
  <div id="initial-location-options" style="margin: 15px 0;">
      <h5>How would you like to specify your delivery location?</h5>
      <div class="btn-group" role="group">
          <button type="button" class="btn btn-primary" id="use-current-location">
              <i class="fas fa-location-arrow"></i> Use My Current Location
          </button>
          <button type="button" class="btn btn-secondary" id="select-from-list">
              <i class="fas fa-list"></i> Select from List
          </button>
      </div>
  </div>

  <div id="location-selection-container" style="display:none;">
    <div class="form-group">
        <label for="main-location">Select Town/City:</label>
        <select id="main-location" class="form-control" required>
            <option value="">-- Select Town/City --</option>
            <option value="Nairobi">Nairobi</option>
            <option value="Mombasa">Mombasa</option>
            <option value="Kisumu">Kisumu</option>
            <option value="Machakos">Machakos</option>
            <!-- Add more towns/cities -->
        </select>
    </div>

    <div id="sublocation-group" style="display:none;">
        <label for="sub-location">Select Area/Estate:</label>
        <select id="sub-location" class="form-control" name="sub_location" required>
            <option value="">-- Select Area/Estate --</option>
        </select>
    </div>
  </div>

  <div id="customer-location-map" style="height: 400px; width: 100%; margin-bottom: 1em; display:none;"></div>
  <div id="location-info" style="margin-bottom: 1em; display:none;">
    <strong>Selected Location:</strong>
    <div>Latitude: <span id="lat"></span></div>
    <div>Longitude: <span id="lng"></span></div>
    <button id="save-precise-location" class="btn btn-success" style="margin-top:10px;">Save Location</button>
  </div>

  <div id="selected-location-message" style="margin-top:10px; display:none;">
    <strong>Selected Location:</strong> <span id="selected-location"></span>
  </div>

  <!-- For select from list -->
  <div id="save-list-location-section" style="display:none; margin-top:10px;">
    <button id="save-list-location" class="btn btn-success">Save Location</button>
  </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const initialLocationOptions = document.getElementById('initial-location-options');
    const locationSelectionContainer = document.getElementById('location-selection-container');
    const useCurrentLocationBtn = document.getElementById('use-current-location');
    const selectFromListBtn = document.getElementById('select-from-list');
    const mainLocation = document.getElementById('main-location');
    const sublocationGroup = document.getElementById('sublocation-group');
    const mapDiv = document.getElementById('customer-location-map');
    let map = null;
    let marker = null;

    useCurrentLocationBtn.addEventListener('click', function() {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                // Hide initial options and show map
                initialLocationOptions.style.display = 'none';
                locationSelectionContainer.style.display = 'none';
                mapDiv.style.display = 'block';
                
                if (!map) {
                    map = L.map('customer-location-map').setView([lat, lng], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '© OpenStreetMap contributors'
                    }).addTo(map);
                } else {
                    map.setView([lat, lng], 15);
                }

                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker([lat, lng]).addTo(map);
                
                document.getElementById('lat').textContent = lat.toFixed(6);
                document.getElementById('lng').textContent = lng.toFixed(6);
                document.getElementById('location-info').style.display = 'block';
            }, function(error) {
                alert('Error getting your location. Please select from list instead.');
            });
        } else {
            alert('Geolocation is not supported by your browser. Please select from list instead.');
        }
    });

    selectFromListBtn.addEventListener('click', function() {
        initialLocationOptions.style.display = 'none';
        locationSelectionContainer.style.display = 'block';
    });

    mainLocation.addEventListener('change', function() {
        const town = this.value;
        const sublocationSelect = document.getElementById('sub-location');
        sublocationSelect.innerHTML = '<option value="">-- Select Area/Estate --</option>';
        
        if (locations[town]) {
            locations[town].forEach(function(area) {
                const opt = document.createElement('option');
                opt.value = area;
                opt.textContent = area;
                sublocationSelect.appendChild(opt);
            });
            sublocationGroup.style.display = 'block';
        } else {
            sublocationGroup.style.display = 'none';
        }
    });

    const locations = {
        "Nairobi": [
            "Westlands", "Kilimani", "Karen", "Lavington", "Eastleigh", "Kasarani", "Embakasi", "South B", "South C", "Lang'ata", "Runda", "Parklands", "Gikambura", "Donholm", "Kangemi"
        ],
        "Mombasa": [
            "Nyali", "Likoni", "Kisauni", "Changamwe", "Bamburi", "Port Reitz", "Tudor"
        ],
        "Kisumu": [
            "Milimani", "Nyalenda", "Manyatta", "Mamboleo"
        ],
        "Machakos": [
            "Mua Hills", "Mavoko", "Kangundo", "Kathiani"
        ]
    };

    // Show/hide location section based on shipping method
    document.querySelectorAll('input[name="shipping_method"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.value === 'delivery') {
                document.getElementById('delivery-location-section').style.display = 'block';
            } else {
                document.getElementById('delivery-location-section').style.display = 'none';
            }
        });
    });

    document.getElementById('sub-location').addEventListener('change', function() {
        if (this.value) {
            document.getElementById('save-list-location-section').style.display = 'block';
        } else {
            document.getElementById('save-list-location-section').style.display = 'none';
        }
    });
});
</script> 