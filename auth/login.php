<?php
// auth/login.php - Proxy to Node.js API
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // If needed for JS calls
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

include '../config.php'; // Path to root config.php

start_session();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Parse JSON body
$input = json_decode(file_get_contents('php://input'), true);
$email = filter_var($input['email'] ?? '', FILTER_SANITIZE_EMAIL);
$password = $input['password'] ?? '';

if (empty($email) || empty($password)) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing email or password']);
    exit;
}

try {
    // Call Node.js API via cURL
    global $api_base_url; // From config.php
    $api_url = $api_base_url . '/auth/login';
    $ch = curl_init($api_url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode(['email' => $email, 'password' => $password]),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_TIMEOUT => 10 // Prevent hangs
    ]);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200 || !$response) {
        http_response_code($http_code ?: 500);
        echo json_encode(['error' => 'API error']);
        exit;
    }

    $api_result = json_decode($response, true);

    if (isset($api_result['error'])) {
        http_response_code(401);
        echo json_encode(['error' => $api_result['error']]);
        exit;
    }

    // Success: Decode token, set session
    $token = $api_result['token'];
    $payload = decode_jwt($token); // From config.php
    $_SESSION['user_id'] = $payload['id'];
    $_SESSION['role'] = $payload['role'];
    $_SESSION['email'] = $email;
    $_SESSION['token'] = $token; // Store for future API calls

    echo json_encode(['token' => $token]); // Return same as Node.js
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
