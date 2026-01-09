<?php
require __DIR__ . '/../database/database.php';

$data = $_GET;

$db = Database::connect();

header('Content-Type: application/json; charset=utf-8');

try {
    $select = $db->prepare("
        SELECT 
            1
        FROM 
            usuarios 
        WHERE 
            login = :login
    ");
    $select->execute([
        ':login' => $data['login']
    ]);
    $result = $select->fetch(PDO::FETCH_ASSOC);

    if($result === false) {
        $db->beginTransaction();

        $token = bin2hex(random_bytes(32));

        $insert = $db->prepare("
            INSERT INTO usuarios
            (
                login,
                senha,
                token
            )
            VALUES
            (
                :login,
                :senha,
                :token
            )
        ");

        $insert->execute([
            ':login' => $data['login'],
            ':senha' => $data['senha'],
            ':token' => $token
        ]);

        setcookie('token', $token, [
            'expires' => time() + 86400,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
        $db->commit(); 
    }
} catch (Exception $e) {
    $db->rollBack();
    echo json_encode([
        'success'   => false,
        'msg'       => 'Erro ao Criar Usuário!',
        'erro'      => $e
    ]);
    exit;
}

echo json_encode([
    'success'   => $result === false,
    'msg'       => 'Usuário Já Existe!'
]);
exit;