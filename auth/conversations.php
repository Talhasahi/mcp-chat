<?php
session_start(); // Ensure session is started
require_once '../config.php'; // Adjust path if needed for $GLOBALS['api_base_url'] and call_authenticated_api

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);
$title = trim($input['title'] ?? '');

if (empty($title)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Conversation title is required']);
    exit;
}

// Prepare data for API: { "title": "My first chat" }
$api_data = ['title' => $title];

// Call the API endpoint /conversations with POST
$endpoint = '/conversations';
$result = call_authenticated_api($endpoint, $api_data, 'POST');
$response = $result['response'];
$http_code = $result['code'];

if ($http_code === 201 || $http_code === 200) {
    $conv = json_decode($response, true);
    $id = $conv['id'] ?? '';
    if ($id) {
        echo json_encode(['success' => true, 'id' => $id, 'message' => 'Conversation created successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Invalid response from API - no ID returned']);
    }
} else {
    // Decode error if possible
    $error_data = json_decode($response, true);
    $error_msg = $error_data ? ($error_data['error'] ?? $error_data['message'] ?? 'Unknown error') : 'API request failed (HTTP ' . $http_code . ')';
    http_response_code($http_code);
    echo json_encode(['success' => false, 'error' => $error_msg]);
}
