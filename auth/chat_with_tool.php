<?php
// auth/chat_with_tool.php - Modified to default args to {} instead of []

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
$toolInput = $input['tool'] ?? null;

// Log empty checks to text file
$logFile = '../chat_with_tool_log.txt';
$logData = "Timestamp: " . date('Y-m-d H:i:s') . "\n";
$logData .= "Empty Check:\n";
$errors = [];

if (empty($conversationId)) {
    $errors[] = "conversationId is empty";
}
if (empty($message)) {
    $errors[] = "message is empty";
}
if (empty($toolInput)) {
    $errors[] = "toolInput is empty";
} else {
    if (empty($toolInput['category'])) {
        $errors[] = "toolInput['category'] is empty";
    }
    if (empty($toolInput['name'])) {
        $errors[] = "toolInput['name'] is empty";
    }
}

if (!empty($errors)) {
    $logData .= "Errors: " . implode(", ", $errors) . "\n";
    $logData .= "Input Received: " . json_encode($input, JSON_PRETTY_PRINT) . "\n";
    $logData .= "----------------------------------------\n";
    file_put_contents($logFile, $logData, FILE_APPEND);
    http_response_code(400);
    echo json_encode(['error' => 'Missing conversationId, message, or tool details']);
    exit;
}

if (!is_logged_in()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Lookup serverId from session based on category
$categoryKey = strtolower($toolInput['category']) . '_server_id';
$serverId = $_SESSION[$categoryKey] ?? null;
if (empty($serverId)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing serverId for category']);
    exit;
}

// Build tool obj
$tool = [
    'serverId' => $serverId,
    'name' => $toolInput['name'],
    'args' => (object)($toolInput['args'] ?? [])
];

// Build full data payload
$data = [
    'tool' => $tool,
    'messages' => [
        [
            'role' => 'user',
            'content' => $message
        ]
    ],
    'conversationId' => $conversationId
];

// Call API via send_message_with_tool (from config.php)
$result = send_message_with_tool($data);

if (isset($result['error'])) {
    http_response_code(400);
    echo json_encode($result);
} else {
    http_response_code(200);
    echo json_encode($result);
}
