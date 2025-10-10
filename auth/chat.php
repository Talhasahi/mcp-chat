<?php
// auth/chat.php - Proxy for sending messages to /chat API

include '../config.php'; // Path to root config.php
start_session();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // If needed for JS
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Parse JSON body
$input = json_decode(file_get_contents('php://input'), true);
$conversationId = $input['conversationId'] ?? null;
$message = $input['content'] ?? trim($input['message'] ?? '');

if (empty($conversationId) || empty($message)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing conversationId or message']);
    exit;
}

if (!is_logged_in()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Call API via send_message (from config.php)
$result = send_message($conversationId, $message);

if (isset($result['error'])) {
    http_response_code(400);
    echo json_encode($result);
} else {
    http_response_code(200);
    echo json_encode($result);
}
