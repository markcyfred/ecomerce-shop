<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');

// Get route ID
$route_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($route_id <= 0) {
    echo '<div class="alert alert-danger">Invalid route ID.</div>';
    include('includes/footer.php');
    exit;
}

// Fetch route data
$routeQ = mysqli_query($conn, "SELECT * FROM routes WHERE id='$route_id' LIMIT 1");
if (!$routeQ || mysqli_num_rows($routeQ) == 0) {
    echo '<div class="alert alert-danger">Route not found.</div>';
    include('includes/footer.php');
    exit;
}
$route = mysqli_fetch_assoc($routeQ);

// Fetch stops
$stopsQ = mysqli_query($conn, "SELECT stop_name, stop_lat, stop_lng FROM route_stops WHERE route_id = $route_id ORDER BY stop_order ASC");
$stops = [];
while($stop = mysqli_fetch_assoc($stopsQ)) {
    $stops[] = $stop;
}

// Prepare all points: start, stops, end
$all_points = [];
$all_points[] = [
    'name' => $route['start_name'],
    'lat' => $route['start_lat'],
    'lng' => $route['start_lng']
];
foreach ($stops as $stop) {
    $all_points[] = [
        'name' => $stop['stop_name'],
        'lat' => $stop['stop_lat'],
        'lng' => $stop['stop_lng']
    ];
}
$all_points[] = [
    'name' => $route['end_name'],
    'lat' => $route['end_lat'],
    'lng' => $route['end_lng']
];

?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Route</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="manage-routes.php">Routes</a></li>
                <li class="breadcrumb-item active">Edit Route</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Edit Route Details</h5>
                        <form action="code.php" method="POST" class="row g-3" id="route-form">
                            <input type="hidden" name="route_id" value="<?= $route_id ?>">
                            <div class="col-md-6">
                                <label for="route_name" class="form-label">Route Name</label>
                                <input type="text" class="form-control" id="route_name" name="route_name" value="<?= htmlspecialchars($route['route_name']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="route_code" class="form-label">Route Code</label>
                                <input type="text" class="form-control" id="route_code" name="route_code" value="<?= htmlspecialchars($route['route_code']) ?>" required readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Route Map (Start, Stops, End)</label>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5em;">
                                    <div></div>
                                    <button type="button" id="fullscreen-btn" class="btn btn-outline-secondary btn-sm">Full Screen</button>
                                </div>
                                <div id="map" style="height: 400px; width: 100%; margin-bottom: 1em; position: relative;">
                                    <button type="button" class="fullscreen-exit-btn" id="fullscreen-exit-btn" title="Exit Full Screen">&times;</button>
                                </div>
                                <div class="alert alert-info">Markers: <b>Start</b> (green), <b>Stops</b> (blue), <b>End</b> (red). Drag to adjust. Double-click to remove a stop. Click map to add a stop between start and end.</div>
                            </div>
                            <input type="hidden" id="stops_coords" name="stops_coords" />
                            <div class="col-md-6">
                                <label for="distance_km" class="form-label">Distance (km)</label>
                                <input type="number" step="0.01" class="form-control" id="distance_km" name="distance_km" value="<?= htmlspecialchars($route['distance_km']) ?>" required readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="estimated_time" class="form-label">Estimated Time</label>
                                <input type="text" class="form-control" id="estimated_time" name="estimated_time" value="<?= htmlspecialchars($route['estimated_time']) ?>" required readonly>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary" name="update_route_btn">Update Route</button>
                                <a href="manage-routes.php" class="btn btn-secondary">Back to Routes</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
#map.fullscreen {
    position: fixed !important;
    top: 0; left: 0; right: 0; bottom: 0;
    width: 100vw !important;
    height: 100vh !important;
    z-index: 9999;
    margin: 0 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
}
#fullscreen-btn.fullscreen-active {
    background: #333;
    color: #fff;
}
#map .fullscreen-exit-btn {
    display: none;
}
#map.fullscreen .fullscreen-exit-btn {
    display: block;
    position: absolute;
    top: 16px;
    right: 24px;
    z-index: 10001;
    background: rgba(0,0,0,0.7);
    color: #fff;
    border: none;
    font-size: 2rem;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    cursor: pointer;
    line-height: 38px;
    text-align: center;
}
</style>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
let allPoints = <?= json_encode($all_points) ?>;
let map, markers = [], polyline;

function getIcon(type, lat, lng) {
    if (type === 'Start') {
        if (Math.abs(lat - (-1.286389)) < 0.00001 && Math.abs(lng - 36.817223) < 0.00001) {
            return L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/149/149060.png',
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });
        } else {
            return L.icon({
                iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                iconSize: [32, 32],
                iconAnchor: [16, 32],
                popupAnchor: [0, -32]
            });
        }
    } else if (type === 'End') {
        return L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/149/149059.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });
    } else {
        return L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/252/252025.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        });
    }
}

function getDistance(lat1, lng1, lat2, lng2) {
    // Haversine formula
    const R = 6371; // km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLng/2) * Math.sin(dLng/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

function recalculateTypesByFarthest() {
    if (allPoints.length < 2) return;
    // Start is always first
    let start = allPoints[0];
    let maxDist = -1, endIdx = 1;
    for (let i = 1; i < allPoints.length; i++) {
        let d = getDistance(start.lat, start.lng, allPoints[i].lat, allPoints[i].lng);
        if (d > maxDist) {
            maxDist = d;
            endIdx = i;
        }
    }
    // Move farthest to last position if not already
    if (endIdx !== allPoints.length-1) {
        const [endPoint] = allPoints.splice(endIdx, 1);
        allPoints.push(endPoint);
    }
}

function renderMarkers() {
    recalculateTypesByFarthest();
    markers.forEach(m => map.removeLayer(m));
    markers = [];
    allPoints.forEach((pt, idx) => {
        let type = idx === 0 ? 'Start' : (idx === allPoints.length-1 ? 'End' : 'Stop');
        let marker = L.marker([pt.lat, pt.lng], {icon: getIcon(type, pt.lat, pt.lng), draggable: type !== 'End' && type !== 'Start'}).addTo(map)
            .bindPopup(type + ': ' + pt.name);
        marker.type = type;
        marker.on('dragend', function() {
            allPoints[idx].lat = marker.getLatLng().lat;
            allPoints[idx].lng = marker.getLatLng().lng;
            renderMarkers();
            updateRoute();
        });
        marker.on('dblclick', function() {
            // Prevent removal if this is the HQ marker (by position and icon)
            const hqLat = -1.286389, hqLng = 36.817223;
            const pos = marker.getLatLng();
            const isHQ = Math.abs(pos.lat - hqLat) < 0.00001 && Math.abs(pos.lng - hqLng) < 0.00001 && marker.options.icon && marker.options.icon.options.iconUrl === 'https://cdn-icons-png.flaticon.com/512/149/149060.png';
            if (isHQ) return;
            if (allPoints.length <= 2) return;
            allPoints.splice(idx, 1);
            renderMarkers();
            updateRoute();
        });
        markers.push(marker);
    });
    drawPolyline();
}

function drawPolyline() {
    if (polyline) map.removeLayer(polyline);
    let latlngs = allPoints.map(pt => [pt.lat, pt.lng]);
    polyline = L.polyline(latlngs, {color: 'blue'}).addTo(map);
    map.fitBounds(polyline.getBounds(), {padding: [30, 30]});
}

function updateRoute() {
    // Update allPoints from marker positions
    markers.forEach((marker, idx) => {
        allPoints[idx].lat = marker.getLatLng().lat;
        allPoints[idx].lng = marker.getLatLng().lng;
    });
    // Update hidden input
    document.getElementById('stops_coords').value = JSON.stringify(allPoints);
    // Optionally, recalculate distance/time via OSRM API
    if (allPoints.length >= 2) {
        let coords = allPoints.map(pt => pt.lng + ',' + pt.lat).join(';');
        let url = `https://router.project-osrm.org/route/v1/driving/${coords}?overview=full&geometries=geojson&steps=true`;
        fetch(url).then(resp => resp.json()).then(data => {
            if (data.code === 'Ok' && data.routes.length > 0) {
                let route = data.routes[0];
                document.getElementById('distance_km').value = (route.distance / 1000).toFixed(2);
                let duration = route.duration;
                let hours = Math.floor(duration / 3600);
                let minutes = Math.round((duration % 3600) / 60);
                document.getElementById('estimated_time').value = `${hours}h ${minutes}m`;
                if (polyline) map.removeLayer(polyline);
                polyline = L.geoJSON(route.geometry, {color: 'blue'}).addTo(map);
                map.fitBounds(polyline.getBounds(), {padding: [30, 30]});
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Define base layers
    const osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap contributors'
    });
    const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 18,
        attribution: 'Tiles © Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
    });

    map = L.map('map', {
        center: [allPoints[0].lat, allPoints[0].lng],
        zoom: 10,
        layers: [osm] // Default layer
    });

    // Add HQ Nairobi marker
    const hqMarker = L.marker([-1.286389, 36.817223], {
        icon: L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/149/149060.png', // green map pin icon
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        })
    }).addTo(map).bindPopup('HQ Nairobi').openPopup();

    // Allow user to select HQ as Start
    hqMarker.on('click', function() {
        // Find Start marker in allPoints
        if (allPoints.length > 0) {
            allPoints[0].lat = -1.286389;
            allPoints[0].lng = 36.817223;
            allPoints[0].name = 'HQ Nairobi';
        } else {
            allPoints.unshift({name: 'HQ Nairobi', lat: -1.286389, lng: 36.817223});
        }
        renderMarkers();
        updateRoute();
        map.setView([-1.286389, 36.817223], 12);
    });

    // Layer control
    const baseLayers = {
        "OpenStreetMap": osm,
        "Satellite": satellite
    };
    L.control.layers(baseLayers).addTo(map);
    renderMarkers();
    updateRoute();
    // Add stop on map click (between start and end)
    map.on('click', function(e) {
        if (allPoints.length < 2) return;
        // Insert before last (end)
        allPoints.splice(allPoints.length-1, 0, {
            name: `Stop (${e.latlng.lat.toFixed(5)},${e.latlng.lng.toFixed(5)})`,
            lat: e.latlng.lat,
            lng: e.latlng.lng
        });
        renderMarkers();
        updateRoute();
    });
    // On submit, update hidden input
    document.getElementById('route-form').addEventListener('submit', function() {
        document.getElementById('stops_coords').value = JSON.stringify(allPoints);
    });
    // Full screen toggle
    const mapDiv = document.getElementById('map');
    const fsBtn = document.getElementById('fullscreen-btn');
    const fsExitBtn = document.getElementById('fullscreen-exit-btn');
    function exitFullScreen() {
        mapDiv.classList.remove('fullscreen');
        fsBtn.classList.remove('fullscreen-active');
        fsBtn.textContent = 'Full Screen';
        setTimeout(() => { map.invalidateSize(); }, 300);
    }
    fsBtn.addEventListener('click', function() {
        const isFull = mapDiv.classList.toggle('fullscreen');
        fsBtn.classList.toggle('fullscreen-active');
        fsBtn.textContent = isFull ? 'Exit Full Screen' : 'Full Screen';
        setTimeout(() => { map.invalidateSize(); }, 300);
    });
    fsExitBtn.addEventListener('click', function(event) {
        event.stopPropagation();
        exitFullScreen();
    });
    document.addEventListener('keydown', function(e) {
        if (mapDiv.classList.contains('fullscreen') && (e.key === 'Escape' || e.key === 'Esc')) {
            exitFullScreen();
        }
    });
});
</script>
<?php include('includes/footer.php'); ?> 