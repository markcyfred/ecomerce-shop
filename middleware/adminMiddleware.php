<?php
session_start();
include_once '../functions/myfunctions.php';

// Check if request is AJAX
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

if (!isset($_SESSION['auth'])) {
    if (is_ajax()) {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'You must be logged in']);
        exit;
    } else {
        redirect('../login.php', 'You are not authorized to access this page');
    }
}

if ($_SESSION['role_as'] != 1) {
    if (is_ajax()) {
        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
        exit;
    } else {
        redirect('../index.php', 'You are not authorized to access this page');
    }
}
