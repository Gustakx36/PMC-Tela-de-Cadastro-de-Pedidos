<?php
require __DIR__ . '/../database/database.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (isset($_COOKIE['token'])) {
    $db = Database::connect();
    $stmt = $db->prepare("
        SELECT 1
        FROM usuarios
        WHERE token = :token
    ");
    $stmt->execute([':token' => $_COOKIE['token']]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    switch ($path) {
        case '/view/pedidos/':
            if($result === false) {
                header('Location: /view/login');
            }
            break;
        case '/view/criar_pedido/':
            if($result === false) {
                header('Location: /view/login');
            }
            break;
            
        default:
            if($result !== false) {
                header('Location: /view/pedidos');
            }
    }
}else {
    switch ($path) {
        case '/view/login/':
            break;
            
        default:
            header('Location: /view/login');
    }
}