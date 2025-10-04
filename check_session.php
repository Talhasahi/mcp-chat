<?php
// check_session.php
include 'config.php';
header('Content-Type: application/json');
start_session();
echo json_encode(['logged_in' => is_logged_in()]);
