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
