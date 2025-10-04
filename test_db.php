<?php
include 'config.php';
try {
    $pdo = get_db_connection();
    echo "DB Connected!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
