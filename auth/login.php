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

    // Only fail on no response (connection issue)
    if (!$response) {
        http_response_code(500);
        echo json_encode(['error' => 'API connection failed']);
        exit;
    }

    // Always parse JSON response
    $api_result = json_decode($response, true);

    // Fail if invalid JSON
    if (!is_array($api_result)) {
        http_response_code(500);
        echo json_encode(['error' => 'Invalid API response']);
        exit;
    }

    // Forward any error from API (e.g., "Invalid credentials")
    if (isset($api_result['error'])) {
        http_response_code(401);
        echo json_encode(['error' => $api_result['error']]);
        exit;
    }

    // Success: Must have token
    if (!isset($api_result['token'])) {
        http_response_code(500);
        echo json_encode(['error' => 'Missing token in response']);
        exit;
    }

    // Decode token, set session
    $token = $api_result['token'];
    // Step 2: Call /me API with token
    $me_url = $api_base_url . '/me';
    $ch = curl_init($me_url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ],
        CURLOPT_TIMEOUT => 10
    ]);
    $me_response = curl_exec($ch);
    $me_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if (!$me_response) {
        http_response_code(500);
        echo json_encode(['error' => 'User data API connection failed']);
        exit;
    }

    $me_result = json_decode($me_response, true);
    if (!is_array($me_result)) {
        http_response_code(500);
        echo json_encode(['error' => 'Invalid user data API response']);
        exit;
    }

    if (isset($me_result['error'])) {
        http_response_code($me_http_code ?: 401);
        echo json_encode(['error' => $me_result['error']]);
        exit;
    }

    // Validate required fields
    if (!isset($me_result['id'], $me_result['email'], $me_result['role'], $me_result['hotelId'], $me_result['hotel'])) {
        http_response_code(500);
        echo json_encode(['error' => 'Incomplete user data']);
        exit;
    }

    // Step 3: Store in session
    $_SESSION['user_id'] = $me_result['id'];
    $_SESSION['email'] = $me_result['email'];
    $_SESSION['role'] = $me_result['role'];
    $_SESSION['hotel_id'] = $me_result['hotelId'];
    $_SESSION['hotel_name'] = $me_result['hotel']['name'];
    $_SESSION['hotel_is_active'] = $me_result['hotel']['isActive'];
    $_SESSION['token'] = $token; // Store for future API calls

    echo json_encode(['token' => $token]); // Return same as Node.js
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
