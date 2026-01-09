<?php
require __DIR__ . '/../database/database.php';

if (!isset($_COOKIE['token'])) {
    echo json_encode([
        'success' => true
    ]);
    exit;
}

$db = Database::connect();

header('Content-Type: application/json; charset=utf-8');

try {
    $db->beginTransaction();

    $update = $db->prepare("
        UPDATE
            usuarios
        SET 
            token = :token
        WHERE 
            token = :token
    ");

    $update->execute([
        ':token' => $_COOKIE['token']
    ]);

    setcookie('token', '', time() - 3600, '/');

    $db->commit();
} catch (Exception $e) {
    $db->rollBack();
    echo json_encode([
        'success'   => false
    ]);
    exit;
}

echo json_encode([
    'success' => true
]);
exit;