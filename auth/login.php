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
    $_SESSION['token'] = $token;

    $prefs = get_user_preferences();
    if (!isset($prefs['error'])) {
        $_SESSION['enabledProviders'] = $prefs['userPrefs']['enabledProviders'] ?? [];
    }
    $servers = get_mcp_servers();
    if (!isset($servers['error'])) {
        $_SESSION['mcp_servers'] = $servers;
    }
    $xml_server_id = null;
    $brevo_server_id = null;
    $energy_server_id = null;

    foreach ($servers as $server) {
        if ($server['name'] === 'xml-mcp') {
            $xml_server_id = $server['id'];
        } elseif ($server['name'] === 'brevo-mcp') {
            $brevo_server_id = $server['id'];
        } elseif ($server['name'] === 'energy-mcp') {
            $energy_server_id = $server['id'];
        }
    }

    // Store extracted IDs in session
    $_SESSION['xml_server_id'] = $xml_server_id;
    $_SESSION['brevo_server_id'] = $brevo_server_id;
    $_SESSION['energy_server_id'] = $energy_server_id;

    // After extracting and storing the server IDs in the if (!isset($servers['error'])) block, add this:

    if ($xml_server_id) {
        $xml_url = rtrim($api_base_url, '/') . '/mcp/servers/' . $xml_server_id . '/tools';
        $ch = curl_init($xml_url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
            ],
            CURLOPT_TIMEOUT => 10,
        ]);
        $xml_raw = curl_exec($ch);
        $xml_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $xml_mcp_tools = json_decode($xml_raw, true);
        if (is_array($xml_mcp_tools) && $xml_code === 200) {
            $_SESSION['xml_mcp_tools'] = $xml_mcp_tools;
        }
    }

    if ($brevo_server_id) {
        $brevo_url = rtrim($api_base_url, '/') . '/mcp/servers/' . $brevo_server_id . '/tools';
        $ch = curl_init($brevo_url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
            ],
            CURLOPT_TIMEOUT => 10,
        ]);
        $brevo_raw = curl_exec($ch);
        $brevo_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $brevo_mcp_tools = json_decode($brevo_raw, true);
        if (is_array($brevo_mcp_tools) && $brevo_code === 200) {
            $_SESSION['brevo_mcp_tools'] = $brevo_mcp_tools;
        }
    }

    if ($energy_server_id) {
        $energy_url = rtrim($api_base_url, '/') . '/mcp/servers/' . $energy_server_id . '/tools';
        $ch = curl_init($energy_url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
            ],
            CURLOPT_TIMEOUT => 10,
        ]);
        $energy_raw = curl_exec($ch);
        $energy_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $energy_mcp_tools = json_decode($energy_raw, true);
        if (is_array($energy_mcp_tools) && $energy_code === 200) {
            $_SESSION['energy_mcp_tools'] = $energy_mcp_tools;
        }
    }

    echo json_encode(['token' => $token]); // Return same as Node.js
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}
