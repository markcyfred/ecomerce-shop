<?php
session_start();
include '../../admin/config/dbcon.php';
include '../includes/device-registration.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$username_email = $_POST['username_email'] ?? '';
$password = $_POST['password'] ?? '';
$device_fingerprint = $_POST['device_fingerprint'] ?? '';
$device_info = $_POST['device_info'] ?? '';
$request_reason = $_POST['request_reason'] ?? '';


if (empty($username_email) || empty($password) || empty($device_fingerprint) || empty($device_info)) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields: username=' . (!empty($username_email) ? 'OK' : 'MISSING') . ', password=' . (!empty($password) ? 'OK' : 'MISSING') . ', fingerprint=' . (!empty($device_fingerprint) ? 'OK' : 'MISSING') . ', device_info=' . (!empty($device_info) ? 'OK' : 'MISSING')]);
    exit;
}

// Validate request reason
if (empty($request_reason)) {
    echo json_encode(['success' => false, 'message' => 'Request reason is required']);
    exit;
}

$request_reason = trim($request_reason);
if (strlen($request_reason) < 10) {
    echo json_encode(['success' => false, 'message' => 'Request reason must be at least 10 characters long']);
    exit;
}

if (strlen($request_reason) > 200) {
    echo json_encode(['success' => false, 'message' => 'Request reason must not exceed 200 characters']);
    exit;
}

// Verify user credentials
$query = "SELECT id, first_name, last_name, email, password, user_role FROM users WHERE email = ? AND user_role IN (0, 2)";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 's', $username_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $row['password'])) {
        $user_id = $row['id'];
        $user_role = $row['user_role'];
        
        // Only allow students and lecturers to request device access
        if ($user_role === 0 || $user_role === 2) {
            // Parse device info
            $device_data = json_decode($device_info, true);
            $device_name = $device_data['deviceType'] === 'mobile' ? 'Mobile Device' : 
                          ($device_data['deviceType'] === 'tablet' ? 'Tablet Device' : 'Desktop Device');
            $device_type = $device_data['deviceType'] ?? 'desktop';
            $browser_info = json_encode($device_data['browserInfo'] ?? []);
            
            // Get IP address
            $ip_address = $_SERVER['HTTP_CLIENT_IP'] ?? 
                         $_SERVER['HTTP_X_FORWARDED_FOR'] ?? 
                         $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            
            // Check if user already has a pending request for this device
            $check_query = "SELECT id FROM device_requests WHERE user_id = ? AND device_fingerprint = ? AND status = 'pending'";
            $check_stmt = mysqli_prepare($con, $check_query);
            mysqli_stmt_bind_param($check_stmt, 'is', $user_id, $device_fingerprint);
            mysqli_stmt_execute($check_stmt);
            $check_result = mysqli_stmt_get_result($check_stmt);
            
            if (mysqli_num_rows($check_result) > 0) {
                echo json_encode(['success' => false, 'message' => 'You already have a pending request for this device']);
                exit;
            }
            
            // Insert device request
            $insert_query = "INSERT INTO device_requests (user_id, device_fingerprint, device_name, device_type, browser_info, ip_address, request_reason) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = mysqli_prepare($con, $insert_query);
            mysqli_stmt_bind_param($insert_stmt, 'issssss', $user_id, $device_fingerprint, $device_name, $device_type, $browser_info, $ip_address, $request_reason);
            
            if (mysqli_stmt_execute($insert_stmt)) {
                echo json_encode(['success' => true, 'message' => 'Device access request submitted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to submit device access request']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Only students and lecturers can request device access']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}
?>
