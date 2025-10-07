<?php
session_start(); // Ensure session is started
require_once '../config.php'; // Adjust path if needed for $GLOBALS['api_base_url']

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$name = trim($_POST['name'] ?? '');

if (empty($name)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Category name is required']);
    exit;
}

// Prepare data for API: { "name": "SEO" }
$api_data = ['name' => $name];

// Call the API endpoint /prompt-categories with POST
$endpoint = '/prompt-categories';
$result = call_authenticated_api($endpoint, $api_data, 'POST');
$response = $result['response'];
$http_code = $result['code'];

if ($http_code === 201 || $http_code === 200) { // Assuming 201 Created or 200 OK
    echo json_encode(['success' => true, 'message' => 'Category created successfully']);
} else {
    // Decode error if possible
    $error_msg = $response ? json_decode($response, true)['error'] ?? 'Unknown error' : 'API request failed';
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $error_msg]);
}
