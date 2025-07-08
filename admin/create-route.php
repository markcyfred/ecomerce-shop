<?php
include('../middleware/adminMiddleware.php');
include('includes/header.php');


// Auto-generate a route code (e.g., ROUTE20240613XXXX)
$route_code = 'ROUTE' . date('Ymd') . rand(1000, 9999);
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Create Route</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Create Route</li>
                <a href="manage-routes.php" title="View routes">
                    <i class="ri-eye-line"></i> View routes
                </a>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Fill out</h5>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="search_start" class="form-label">Search Start Location</label>
                                <div class="input-group">
                                    <input type="text" id="search_start" class="form-control" placeholder="Search for start location...">
                                    <button class="btn btn-outline-secondary" type="button" id="btn_search_start">Search</button>
                                </div>
                                <div id="results_start" class="list-group"></div>
                            </div>
                            <div class="col-md-4">
                                <label for="search_end" class="form-label">Search End Location</label>
                                <div class="input-group">
                                    <input type="text" id="search_end" class="form-control" placeholder="Search for end location...">
                                    <button class="btn btn-outline-secondary" type="button" id="btn_search_end">Search</button>
                                </div>
                                <div id="results_end" class="list-group"></div>
                            </div>
                            <div class="col-md-4">
                                <label for="search_stop" class="form-label">Search Stop Location</label>
                                <div class="input-group">
                                    <input type="text" id="search_stop" class="form-control" placeholder="Search for stop location...">
                                    <button class="btn btn-outline-secondary" type="button" id="btn_search_stop">Search</button>
                                </div>
                                <div id="results_stop" class="list-group"></div>
                            </div>
                        </div>
                        <form action="code.php" method="POST" class="row g-3">
                            <div class="col-md-6">
                                <label for="route_name" class="form-label">Route Name</label>
                                <input type="text" class="form-control" id="route_name" name="route_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="route_code" class="form-label">Route Code</label>
                                <input type="text" class="form-control" id="route_code" name="route_code" value="<?= $route_code ?>" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Select Start, End, and Stops on the Map</label>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5em;">
                                    <div></div>
                                    <button type="button" id="fullscreen-btn" class="btn btn-outline-secondary btn-sm">Full Screen</button>
                                </div>
                                <div id="map" style="height: 400px; width: 100%; margin-bottom: 1em; position: relative;">
                                    <button type="button" class="fullscreen-exit-btn" id="fullscreen-exit-btn" title="Exit Full Screen">&times;</button>
                                </div>
                                <div class="alert alert-info">Click on the map to set: <b>Start</b> (first click), <b>End</b> (second click), then any <b>Stops</b> (optional, more clicks). Drag markers to adjust. Double-click a marker to remove it.</div>
                            </div>
                            <div class="col-md-12">
                                <label for="stops" class="form-label">Stops (auto-filled, editable)</label>
                                <textarea class="form-control" id="stops" name="stops" rows="3" placeholder="Stops will be auto-filled..." required readonly></textarea>
                                <input type="hidden" id="stops_coords" name="stops_coords" />
                            </div>
                            <div class="col-md-6">
                                <label for="distance_km" class="form-label">Distance (km)</label>
                                <input type="number" step="0.01" class="form-control" id="distance_km" name="distance_km" required readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="estimated_time" class="form-label">Estimated Time</label>
                                <input type="text" class="form-control" id="estimated_time" name="estimated_time" required readonly>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary" name="create_route_btn">Create Route</button>
                                <button type="reset" class="btn btn-secondary" onclick="window.location.reload()">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Leaflet CSS & JS -->
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
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script>
let map, markers = [], markerTypes = [], polyline;
let routePoints = [];

function initMap() {
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
        center: [-1.286389, 36.817223],
        zoom: 7,
        layers: [osm] // Default layer
    });

    // Add HQ Nairobi marker
    const hqMarker = L.marker([-1.286389, 36.817223], {
        icon: L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/149/149060.png',
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        })
    }).addTo(map).bindPopup('HQ Nairobi').openPopup();

    // Allow user to select HQ as Start
    hqMarker.on('click', function() {
        let idx = markerTypes.indexOf('Start');
        if (idx !== -1) {
            markers[idx].setLatLng([-1.286389, 36.817223]);
            markers[idx].openPopup();
        } else {
            addMarker(L.latLng(-1.286389, 36.817223), 'Start');
        }
        map.setView([-1.286389, 36.817223], 12);
        updateRoute();
    });

    // Layer control
    const baseLayers = {
        "OpenStreetMap": osm,
        "Satellite": satellite
    };
    L.control.layers(baseLayers).addTo(map);

    map.on('click', async function(e) {
        if (markers.length === 0) {
            addMarker(e.latlng, 'Start');
        } else if (markers.length === 1) {
            addMarker(e.latlng, 'End');
        } else {
            addMarker(e.latlng, 'Stop');
        }
        await updateRoute();
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
    if (markers.length < 2) return;
    let start = routePoints[0];
    let maxDist = -1, endIdx = 1;
    for (let i = 1; i < routePoints.length; i++) {
        let d = getDistance(start.lat, start.lng, routePoints[i].lat, routePoints[i].lng);
        if (d > maxDist) {
            maxDist = d;
            endIdx = i;
        }
    }
    // Move farthest to last position if not already
    if (endIdx !== routePoints.length-1) {
        const [endPoint] = routePoints.splice(endIdx, 1);
        const [endMarker] = markers.splice(endIdx, 1);
        routePoints.push(endPoint);
        markers.push(endMarker);
    }
}

function updateMarkerTypes() {
    recalculateTypesByFarthest();
    markerTypes = markers.map((m, idx) => idx === 0 ? 'Start' : (idx === markers.length-1 ? 'End' : 'Stop'));
    markers.forEach((marker, idx) => {
        marker.type = markerTypes[idx];
        let iconUrl;
        if (marker.type === 'Start') {
            const pos = marker.getLatLng();
            if (Math.abs(pos.lat - (-1.286389)) < 0.00001 && Math.abs(pos.lng - 36.817223) < 0.00001) {
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/149/149060.png'; // HQ green icon
            } else {
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/684/684908.png'; // default Start icon
            }
        } else if (marker.type === 'End') {
            iconUrl = 'https://cdn-icons-png.flaticon.com/512/149/149059.png';
        } else {
            iconUrl = 'https://cdn-icons-png.flaticon.com/512/252/252025.png';
        }
        marker.setIcon(L.icon({
            iconUrl: iconUrl,
            iconSize: [32, 32],
            iconAnchor: [16, 32],
            popupAnchor: [0, -32]
        }));
        marker.setPopupContent(marker.type);
    });
}

function addMarker(latlng, type) {
    let marker = L.marker(latlng, {icon: L.icon({
        iconUrl: type === 'Start' ? 'https://cdn-icons-png.flaticon.com/512/684/684908.png' :
                 type === 'End' ? 'https://cdn-icons-png.flaticon.com/512/149/149059.png' :
                 'https://cdn-icons-png.flaticon.com/512/252/252025.png',
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    }), draggable: true}).addTo(map)
        .bindPopup(type).openPopup();
    marker.type = type;
    marker.on('dragend', async function() {
        // Update marker position in markers array
        const idx = markers.indexOf(marker);
        if (idx !== -1) {
            routePoints[idx] = marker.getLatLng();
        }
        // If marker is not first or last, and is dragged to last position, swap with end
        if (idx !== 0 && idx !== markers.length-1 && idx === markers.length-2) {
            // Move this marker to end
            const movedMarker = markers.splice(idx, 1)[0];
            const movedPoint = routePoints.splice(idx, 1)[0];
            markers.push(movedMarker);
            routePoints.push(movedPoint);
        }
        updateMarkerTypes();
        await updateRoute();
    });
    marker.on('dblclick', function() {
        // Prevent removal if this is the HQ marker (by position and icon)
        const hqLat = -1.286389, hqLng = 36.817223;
        const pos = marker.getLatLng();
        const isHQ = Math.abs(pos.lat - hqLat) < 0.00001 && Math.abs(pos.lng - hqLng) < 0.00001 && marker.options.icon && marker.options.icon.options.iconUrl === 'https://cdn-icons-png.flaticon.com/512/149/149060.png';
        if (isHQ) return;
        const idx = markers.indexOf(marker);
        if (idx !== -1) {
            markers.splice(idx, 1);
            routePoints.splice(idx, 1);
            updateMarkerTypes();
            updateRoute();
        }
    });
    markers.push(marker);
    markerTypes.push(type);
    updateMarkerTypes();
}

async function updateRoute() {
    if (polyline) { map.removeLayer(polyline); polyline = null; }
    routePoints = markers.map(m => m.getLatLng());
    if (routePoints.length < 2) {
        document.getElementById('stops').value = '';
        document.getElementById('distance_km').value = '';
        document.getElementById('estimated_time').value = '';
        document.getElementById('route_name').value = '';
        document.getElementById('stops_coords').value = '';
        return;
    }
    let coords = routePoints.map(pt => pt.lng + ',' + pt.lat).join(';');
    let url = `https://router.project-osrm.org/route/v1/driving/${coords}?overview=full&geometries=geojson&steps=true`;
    let resp = await fetch(url);
    let data = await resp.json();
    if (data.code === 'Ok' && data.routes.length > 0) {
        let route = data.routes[0];
        polyline = L.geoJSON(route.geometry, {color: 'blue'}).addTo(map);
        map.fitBounds(polyline.getBounds(), {padding: [30, 30]});
        document.getElementById('distance_km').value = (route.distance / 1000).toFixed(2);
        let duration = route.duration;
        let hours = Math.floor(duration / 3600);
        let minutes = Math.round((duration % 3600) / 60);
        document.getElementById('estimated_time').value = `${hours}h ${minutes}m`;

        // Suggest route name (Start - End)
        let startName = await reverseGeocode(routePoints[0].lat, routePoints[0].lng);
        let endName = await reverseGeocode(routePoints[routePoints.length-1].lat, routePoints[routePoints.length-1].lng);
        let suggestedName = `${startName.split(',')[0].trim()} - ${endName.split(',')[0].trim()}`;
        let routeNameInput = document.getElementById('route_name');
        if (!routeNameInput.value || routeNameInput.value === routeNameInput.getAttribute('data-suggested')) {
            routeNameInput.value = suggestedName;
            routeNameInput.setAttribute('data-suggested', suggestedName);
        }

        // Show loading while fetching stops
        document.getElementById('stops').value = 'Loading...';
        // Reverse geocode all points
        let stopsArr = [];
        for (let i = 0; i < routePoints.length; i++) {
            let latlng = routePoints[i];
            let addr = await reverseGeocode(latlng.lat, latlng.lng);
            stopsArr.push({
                name: addr,
                lat: latlng.lat,
                lng: latlng.lng
            });
        }
        document.getElementById('stops_coords').value = JSON.stringify(stopsArr);
        // For the stops textarea, only show intermediate stops:
        let stops = [];
        for (let i = 1; i < stopsArr.length - 1; i++) {
            stops.push(stopsArr[i].name);
        }
        document.getElementById('stops').value = stops.join(', ');
    } else {
        document.getElementById('distance_km').value = '';
        document.getElementById('estimated_time').value = '';
        document.getElementById('stops').value = '';
        document.getElementById('route_name').value = '';
        document.getElementById('stops_coords').value = '';
    }
}

async function reverseGeocode(lat, lng) {
    try {
        let url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`;
        let resp = await fetch(url);
        let data = await resp.json();
        return data.display_name || `${lat.toFixed(5)},${lng.toFixed(5)}`;
    } catch {
        return `${lat.toFixed(5)},${lng.toFixed(5)}`;
    }
}

// Helper to search and display results
async function searchPlace(query, resultsDiv, callback) {
    resultsDiv.innerHTML = '<div class="list-group-item">Searching...</div>';
    let url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;
    let resp = await fetch(url);
    let data = await resp.json();
    resultsDiv.innerHTML = '';
    if (data.length === 0) {
        resultsDiv.innerHTML = '<div class="list-group-item">No results found.</div>';
        return;
    }
    data.forEach(place => {
        let item = document.createElement('button');
        item.type = 'button';
        item.className = 'list-group-item list-group-item-action';
        item.textContent = place.display_name;
        item.onclick = () => callback(place);
        resultsDiv.appendChild(item);
    });
}

// Update setupSearchBox for robust marker handling
function setupSearchBox(inputId, btnId, resultsId, markerType) {
    const input = document.getElementById(inputId);
    const btn = document.getElementById(btnId);
    const resultsDiv = document.getElementById(resultsId);
    btn.addEventListener('click', () => {
        if (input.value.trim()) {
            searchPlace(input.value.trim(), resultsDiv, place => {
                let latlng = L.latLng(place.lat, place.lon);
                if (markerType === 'Start') {
                    let idx = markerTypes.indexOf('Start');
                    if (idx !== -1) {
                        markers[idx].setLatLng(latlng);
                        markers[idx].openPopup();
                    } else {
                        addMarker(latlng, 'Start');
                    }
                } else if (markerType === 'End') {
                    let idx = markerTypes.indexOf('End');
                    if (idx !== -1) {
                        markers[idx].setLatLng(latlng);
                        markers[idx].openPopup();
                    } else {
                        if (markerTypes.indexOf('Start') === -1) addMarker(L.latLng(0,0), 'Start');
                        addMarker(latlng, 'End');
                    }
                } else if (markerType === 'Stop') {
                    if (markerTypes.indexOf('Start') === -1 || markerTypes.indexOf('End') === -1) {
                        alert('Please set Start and End locations first.');
                        return;
                    }
                    // Insert stop before the End marker
                    let endIdx = markerTypes.indexOf('End');
                    addMarkerAt(latlng, 'Stop', endIdx);
                }
                map.setView(latlng, 12);
                resultsDiv.innerHTML = '';
                updateRoute();
            });
        }
    });
}

// Helper to insert a marker at a specific index
function addMarkerAt(latlng, type, idx) {
    let icon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/252/252025.png',
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });
    let marker = L.marker(latlng, {icon: icon, draggable: true}).addTo(map)
        .bindPopup(type).openPopup();
    marker.type = type;
    marker.on('dragend', updateRoute);
    marker.on('dblclick', function() {
        // Prevent removal if this is the HQ marker (by position and icon)
        const hqLat = -1.286389, hqLng = 36.817223;
        const pos = marker.getLatLng();
        const isHQ = Math.abs(pos.lat - hqLat) < 0.00001 && Math.abs(pos.lng - hqLng) < 0.00001 && marker.options.icon && marker.options.icon.options.iconUrl === 'https://cdn-icons-png.flaticon.com/512/149/149060.png';
        if (isHQ) return;
        const idx = markers.indexOf(marker);
        if (idx !== -1) {
            markers.splice(idx, 1);
            routePoints.splice(idx, 1);
            updateMarkerTypes();
            updateRoute();
        }
    });
    markers.splice(idx, 0, marker);
    markerTypes.splice(idx, 0, type);
    return marker;
}

window.addEventListener('DOMContentLoaded', () => {
    initMap();
    setupSearchBox('search_start', 'btn_search_start', 'results_start', 'Start');
    setupSearchBox('search_end', 'btn_search_end', 'results_end', 'End');
    setupSearchBox('search_stop', 'btn_search_stop', 'results_stop', 'Stop');
});

document.addEventListener('DOMContentLoaded', function() {
    var form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            var btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.textContent = 'Saving...';
            }
        });
    }
});
</script>
<?php include('includes/footer.php'); ?> 