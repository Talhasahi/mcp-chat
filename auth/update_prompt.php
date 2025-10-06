<?php
// auth/update_prompt.php - Proxy to Node.js /prompts/{id} API (PATCH)
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // If needed
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

include '../config.php'; // For $api_base_url and session

start_session();
require_login(); // Ensure logged in (uses $_SESSION['user_id'], etc.)

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Parse form data (from edit_prompt.php form)
$id = trim($_POST['id'] ?? '');
$title = trim($_POST['title'] ?? '');
$body = trim($_POST['body'] ?? '');
$categoryId = trim($_POST['category'] ?? null); // From select, null if empty
$version = trim($_POST['version'] ?? 'v1'); // Use posted value
$tags_str = trim($_POST['tags'] ?? ''); // Comma-separated from hidden input
$tags = $tags_str ? array_map('trim', explode(',', $tags_str)) : []; // To array

// Validation (simple)
if (empty($id) || empty($title) || empty($body)) {
    http_response_code(400);
    echo json_encode(['error' => 'ID, title and body are required']);
    exit;
}

// Simplified payload: only changed fields (title, body, tags, version, categoryId)
$data = [
    'title' => $title,
    'body' => $body,
    'tags' => $tags,
    'version' => $version
];
if ($categoryId) {
    $data['categoryId'] = $categoryId;
}

try {
    // Call with Bearer token (PATCH to /prompts/{id})
    $result = call_authenticated_api('/prompts/' . $id, $data, 'PATCH');
    $response = $result['response'];
    $http_code = $result['code'];

    if (!$response) {
        http_response_code(500);
        echo json_encode(['error' => 'API connection failed']);
        exit;
    }

    $api_result = json_decode($response, true);

    if (!is_array($api_result) || isset($api_result['error'])) {
        // Handle 401 token issues
        if ($http_code === 401) {
            logout(); // Redirect to login
        }
        http_response_code($http_code ?: 400);
        echo json_encode(['error' => $api_result['error'] ?? 'Invalid response']);
        exit;
    }

    // Success
    echo json_encode(['success' => true, 'message' => 'Prompt updated successfully', 'data' => $api_result]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error: ' . $e->getMessage()]); // Add message for debugging (remove in prod)
}
