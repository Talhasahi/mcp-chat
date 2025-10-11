<?php
// auth/feedback.php - Proxy for sending feedback to /messages/{assistantMessageId}/feedback API

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
$assistantMessageId = $input['assistantMessageId'] ?? null;
$reaction = $input['reaction'] ?? null;
$reason = $input['reason'] ?? null;
$comment = $input['comment'] ?? null;

if (empty($assistantMessageId) || empty($reaction)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing assistantMessageId or reaction']);
    exit;
}

if (!in_array($reaction, ['like', 'dislike', 'none'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid reaction: must be like, dislike, or none']);
    exit;
}

// Optional fields for like/dislike
$data = ['reaction' => $reaction];
if ($reaction !== 'none') {
    if (empty($reason)) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing reason for reaction']);
        exit;
    }
    $data['reason'] = $reason;
    $data['comment'] = $comment ?? ''; // Comment optional
}

if (!is_logged_in()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Call API via authenticated helper (endpoint: /messages/{id}/feedback)
$endpoint = '/messages/' . $assistantMessageId . '/feedback';
$result = call_authenticated_api($endpoint, $data, 'POST');

if (isset($result['error']) || $result['code'] !== 200) {
    http_response_code(400);
    echo json_encode(['error' => $result['error'] ?? 'Failed to send feedback']);
} else {
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Feedback sent successfully']);
}
