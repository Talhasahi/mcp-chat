<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

include '../config.php';
start_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$enabledProviders = $input['enabledProviders'] ?? [];
$defaultProvider = $input['defaultProvider'] ?? '';
$models = $input['models'] ?? [];

if (empty($enabledProviders)) {
    http_response_code(400);
    echo json_encode(['error' => 'At least one provider must be enabled']);
    exit;
}
if ($defaultProvider && !in_array($defaultProvider, $enabledProviders)) {
    http_response_code(400);
    echo json_encode(['error' => 'Default provider must be enabled']);
    exit;
}

$data = [
    'enabledProviders' => $enabledProviders,
    'defaultProvider' => $defaultProvider ?: null,
    'models' => [
        'openai' => $models['openai'] ?? null,
        'deepseek' => $models['deepseek'] ?? null,
        'perplexity' => $models['perplexity'] ?? null
    ]
];
$result = put_user_preferences($data);

if (isset($result['error'])) {
    http_response_code(400);
    echo json_encode(['error' => $result['error']]);
    exit;
}

$_SESSION['prefs'] = $result['userPrefs'] ?? $data;
echo json_encode(['message' => 'Preferences saved successfully']);
