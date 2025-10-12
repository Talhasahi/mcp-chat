<?php
include 'config.php';
try {
    $pdo = get_db_connection();
    echo "DB Connected!";
    print_r(force_provider_message('deepseek', 'Give an interesting Berlin fact'));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
