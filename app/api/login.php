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
        AND 
            senha = :senha
    ");
    $select->execute([
        ':login' => $data['login'],
        ':senha' => $data['senha']
    ]);
    $result = $select->fetch(PDO::FETCH_ASSOC);

    $selectLogin = $db->prepare("
        SELECT 
            1
        FROM 
            usuarios 
        WHERE 
            login = :login
    ");
    $selectLogin->execute([
        ':login' => $data['login']
    ]);
    $resultLogin = $selectLogin->fetch(PDO::FETCH_ASSOC);

    if($result !== false) {
        $db->beginTransaction();

        $token = bin2hex(random_bytes(32));
    
        $update = $db->prepare("
            UPDATE
                usuarios
            SET 
                token = :token
            WHERE 
                login = :login
        ");
    
        $update->execute([
            ':login' => $data['login'],
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
    if($resultLogin === false){
        echo json_encode([
            'success'   => $result !== false,
            'msg'       => 'Usuário Não Existe!'
        ]);
        exit;
    }

    
} catch (Exception $e) {
    $db->rollBack();
    echo json_encode([
        'success'   => false,
        'msg'       => 'Erro ao Efetuar Login!'
    ]);
    exit;
}

echo json_encode([
    'success'   => $result !== false,
    'msg'       => 'Senha Incorreta!'
]);
exit;