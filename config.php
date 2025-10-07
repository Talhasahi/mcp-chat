<?php
// config.php

// Hardcoded fallbacks (for if .env missing)
$env_defaults = [
    'DATABASE_URL' => 'postgresql://postgres:postgres@localhost:5432/chatdb?schema=public',
    'JWT_SECRET' => 'mysecretstring12345'
];

// Load .env if exists (simple parser)
$env = $env_defaults;
if (file_exists('.env')) {
    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Skip comments
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $env[trim($name)] = trim($value, '"\''); // Strip quotes
        }
    }
} else {
    // Warn once (dev only)
    error_log('No .env file found—using hardcoded defaults. Create .env for security.');
}

// Base URL detection (for PHP app)
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$is_local = (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false);
$app_base_url = $is_local ? 'http://localhost/mcp-chat/' : 'http://qualityfriend.solutions/';

// API Base URL (for Node.js backend)
$api_base_url = $is_local ? 'http://localhost:3000' : 'http://qualityfriend.solutions/api'; // Adjust live URL if Node.js deploys differently

// DB Connection (parse DATABASE_URL) - unchanged, for future use
function get_db_connection()
{
    global $env;
    $url = parse_url($env['DATABASE_URL']);
    $dsn = "pgsql:host={$url['host']};port={$url['port']};dbname=" . substr($url['path'], 1);
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false // For security
    ];
    try {
        $pdo = new PDO($dsn, $url['user'], $url['pass'], $options);
        return $pdo;
    } catch (PDOException $e) {
        error_log('DB Connection failed: ' . $e->getMessage());
        throw new Exception('Database connection error');
    }
}

// Simple JWT Decoder (to extract payload for session)
function decode_jwt($token)
{
    global $env;
    $secret = $env['JWT_SECRET'];
    list($header, $payload, $signature) = explode('.', $token);
    $expected = base64url_encode(hash_hmac('sha256', $header . '.' . $payload, $secret, true));
    if (!hash_equals($expected, $signature)) {
        throw new Exception('Invalid token');
    }
    return json_decode(base64url_decode($payload), true);
}

function base64url_decode($data)
{
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

// Session helpers - unchanged
function start_session()
{
    if (session_status() === PHP_SESSION_NONE) {
        ini_set('session.cookie_httponly', 1); // Security
        session_start();
        if (isset($_POST['email']) || isset($_POST['password'])) {
            session_regenerate_id(true); // Anti-session fixation
        }
    }
}

function is_logged_in()
{
    start_session();
    return isset($_SESSION['user_id']);
}

function require_login($redirect = 'index.php')
{
    if (!is_logged_in()) {
        // Clear any partial session
        session_destroy();
        header("Location: $redirect?error=unauthorized");
        exit;
    }
}
function require_author($redirect = 'my_prompt.php')
{
    require_login(); // Ensure logged in first
    start_session();
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'author') {
        // Clear any partial session if needed
        header("Location: $redirect?error=unauthorized");
        exit;
    }
}

function logout()
{
    start_session();
    $_SESSION = []; // Clear all
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
    header('Location: index.php');
    exit;
}


// ---------------------------------------------------
function get_user_preferences()
{
    // $api_base_url must be defined earlier in this file (you already have it)
    global $api_base_url;

    // Token is stored in the session after login
    $token = $_SESSION['token'] ?? '';
    if (!$token) {
        return ['error' => 'No authentication token – please log in again.'];
    }

    $url = rtrim($api_base_url, '/') . '/settings/preferences';

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
        ],
        CURLOPT_TIMEOUT => 10,
    ]);

    $raw = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Basic connection problem
    if ($raw === false) {
        return ['error' => 'Failed to contact the API.'];
    }

    $data = json_decode($raw, true);

    // If JSON failed or API returned a non-200 with an error field
    if (!is_array($data) || $code !== 200) {
        $msg = $data['error'] ?? 'Unknown API error';
        return ['error' => $msg];
    }

    // Success – return the whole payload (you can pick only the parts you need later)
    return $data;
}

function get_mcp_servers()
{
    global $api_base_url;
    $token = $_SESSION['token'] ?? '';

    if (!$token) {
        return ['error' => 'No authentication token – please log in again.'];
    }

    $url = rtrim($api_base_url, '/') . '/mcp/servers';

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
        ],
        CURLOPT_TIMEOUT => 10,
    ]);

    $raw = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Basic connection problem
    if ($raw === false) {
        return ['error' => 'Failed to contact the API.'];
    }

    $data = json_decode($raw, true);

    // If JSON failed or API returned a non-200 with an error field
    if (!is_array($data) || $code !== 200) {
        $msg = $data['error'] ?? 'Unknown API error';
        return ['error' => $msg];
    }

    // Success – return the whole payload (array of servers)
    return $data;
}

// Simple PUT /settings/preferences
function put_user_preferences($data)
{
    global $api_base_url;
    $token = $_SESSION['token'] ?? '';

    if (!$token) {
        return ['error' => 'No authentication token - please log in again.'];
    }

    $url = rtrim($api_base_url, '/') . '/settings/preferences';
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ],
        CURLOPT_TIMEOUT => 10
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false) {
        return ['error' => 'Failed to connect to API.'];
    }

    $result = json_decode($response, true);
    if (!is_array($result) || $http_code !== 200) {
        return ['error' => $result['error'] ?? 'Failed to save preferences'];
    }

    return $result;
}

// Helper for authenticated API calls
// Helper for authenticated API calls
function call_authenticated_api($endpoint, $data, $method = 'POST')
{
    global $api_base_url;
    $url = $api_base_url . $endpoint;
    $ch = curl_init($url);
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . ($_SESSION['token'] ?? '') // Bearer token from session
    ];
    $opts = [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => $headers
    ];
    if ($method === 'POST') {
        $opts[CURLOPT_POST] = true;
        $opts[CURLOPT_POSTFIELDS] = json_encode($data);
    } elseif ($method === 'GET') {
        // For GET, add query params if $data is array (but here $data=null, so no change)
        if (is_array($data) && !empty($data)) {
            $query = http_build_query($data);
            $url .= '?' . $query;
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    } elseif ($method === 'PATCH') {
        $opts[CURLOPT_CUSTOMREQUEST] = 'PATCH';
        $opts[CURLOPT_POSTFIELDS] = json_encode($data);
    }
    curl_setopt_array($ch, $opts);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['response' => $response, 'code' => $http_code];
}

function fetch_categories()
{
    $endpoint = '/prompt-categories';

    $result = call_authenticated_api($endpoint, null, 'GET');
    $response = $result['response'];
    $http_code = $result['code'];

    if (!$response || $http_code !== 200) {
        // On error, set empty array (handle in UI)
        return [];
    }

    $categories = json_decode($response, true);
    return is_array($categories) ? $categories : [];
}
