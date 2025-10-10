<?php
include 'config.php';
try {
    $pdo = get_db_connection();
    echo "DB Connected!";
    print_r(send_message('q', 'q'));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
