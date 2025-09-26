<?php
/**
 * Device Registration and Verification Functions
 * Handles device fingerprinting and registration for students
 */

// Include database connection if not already included
if (!isset($con)) {
    include_once __DIR__ . '/../../admin/config/dbcon.php';
}

/**
 * Register a user's device
 * @param int $user_id User ID
 * @param string $device_fingerprint Device fingerprint
 * @param array $device_info Device information array
 * @return array Result array with success status and message
 */
function registerUserDevice($user_id, $device_fingerprint, $device_info) {
    global $con;
    
    try {
        // Check if device already exists for this user (regardless of active status)
        $check_query = "SELECT id, is_active FROM student_devices WHERE user_id = ? AND device_fingerprint = ?";
        $check_stmt = mysqli_prepare($con, $check_query);
        mysqli_stmt_bind_param($check_stmt, 'is', $user_id, $device_fingerprint);
        mysqli_stmt_execute($check_stmt);
        $existing_device = mysqli_stmt_get_result($check_stmt);
        
        if (mysqli_num_rows($existing_device) > 0) {
            $device = mysqli_fetch_assoc($existing_device);
            
            // If device exists and is already active, just update last_used
            if ($device['is_active'] == 1) {
                $update_query = "UPDATE student_devices SET last_used = NOW() WHERE id = ?";
                $update_stmt = mysqli_prepare($con, $update_query);
                mysqli_stmt_bind_param($update_stmt, 'i', $device['id']);
                mysqli_stmt_execute($update_stmt);
                
                return [
                    'success' => true,
                    'message' => 'Device already registered',
                    'requires_registration' => false
                ];
            } else {
                // Device exists but is inactive (blocked), deny access
                return [
                    'success' => false,
                    'message' => 'Device has been blocked by administrator',
                    'requires_registration' => false,
                    'device_blocked' => true
                ];
            }
        }
        
        // Device doesn't exist, create new registration
        $device_type = $device_info['deviceType'] ?? 'unknown';
        $browser_info = json_encode($device_info['browserInfo'] ?? []);
        $device_name = generateDeviceName($device_type, $device_info['browserInfo'] ?? []);
        $ip_address = getClientIP();
        
        // Insert device registration
        $insert_query = "INSERT INTO student_devices (user_id, device_fingerprint, device_name, device_type, browser_info, ip_address, registered_at, last_used, is_active) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW(), 1)";
        $insert_stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($insert_stmt, 'isssss', $user_id, $device_fingerprint, $device_name, $device_type, $browser_info, $ip_address);
        
        if (mysqli_stmt_execute($insert_stmt)) {
            return [
                'success' => true,
                'message' => 'Device registered successfully',
                'requires_registration' => false
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Failed to register device: ' . mysqli_error($con),
                'requires_registration' => true
            ];
        }
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Device registration failed: ' . $e->getMessage(),
            'requires_registration' => true
        ];
    }
}

/**
 * Verify a user's device
 * @param int $user_id User ID
 * @param string $device_fingerprint Device fingerprint
 * @return array Result array with success status and message
 */
function verifyUserDevice($user_id, $device_fingerprint) {
    global $con;
    
    try {
        // First check if device exists for this user (regardless of active status)
        $check_query = "SELECT id, device_name, last_used, is_active FROM student_devices WHERE user_id = ? AND device_fingerprint = ?";
        $check_stmt = mysqli_prepare($con, $check_query);
        mysqli_stmt_bind_param($check_stmt, 'is', $user_id, $device_fingerprint);
        mysqli_stmt_execute($check_stmt);
        $device_result = mysqli_stmt_get_result($check_stmt);
        
        if (mysqli_num_rows($device_result) > 0) {
            $device = mysqli_fetch_assoc($device_result);
            
            // Check if device is blocked (is_active = 0)
            if ($device['is_active'] == 0) {
                return [
                    'success' => false,
                    'message' => 'Device has been blocked by administrator',
                    'requires_registration' => false,
                    'device_blocked' => true
                ];
            }
            
            // Device is active, update last used timestamp
            $update_query = "UPDATE student_devices SET last_used = NOW() WHERE user_id = ? AND device_fingerprint = ? AND is_active = 1";
            $update_stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($update_stmt, 'is', $user_id, $device_fingerprint);
            mysqli_stmt_execute($update_stmt);
            
            return [
                'success' => true,
                'message' => 'Device verified successfully',
                'requires_registration' => false
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Device not registered',
                'requires_registration' => true
            ];
        }
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Device verification failed: ' . $e->getMessage(),
            'requires_registration' => true
        ];
    }
}

/**
 * Generate a device name based on device type and browser info
 * @param string $device_type Device type (desktop, mobile, tablet)
 * @param array $browser_info Browser information
 * @return string Generated device name
 */
function generateDeviceName($device_type, $browser_info) {
    $browser_name = $browser_info['name'] ?? 'Unknown Browser';
    $browser_version = $browser_info['version'] ?? '';
    
    $device_names = [
        'desktop' => 'Desktop',
        'mobile' => 'Mobile',
        'tablet' => 'Tablet',
        'unknown' => 'Unknown Device'
    ];
    
    $device_name = $device_names[$device_type] ?? 'Unknown Device';
    
    if ($browser_name !== 'Unknown Browser') {
        $device_name .= ' - ' . $browser_name;
        if ($browser_version) {
            $device_name .= ' ' . $browser_version;
        }
    }
    
    return $device_name;
}

/**
 * Get client IP address
 * @return string Client IP address
 */
function getClientIP() {
    $ip_keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
    
    foreach ($ip_keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
    
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}
?>
