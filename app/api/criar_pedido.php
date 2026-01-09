<?php
require __DIR__ . '/../database/database.php';

$data = $_POST;

$db = Database::connect();

header('Content-Type: application/json; charset=utf-8');

try {
    $db->beginTransaction();

    $insertPedido = $db->prepare("
        INSERT INTO pedidos
        (
            cep, 
            rua, 
            bairro, 
            cidade, 
            estado, 
            numero,
            usuario_id
        )
        VALUES
        (
            :cep,
            :rua,
            :bairro,
            :cidade,
            :estado,
            :numero,
            (SELECT id FROM usuarios WHERE token = :token)
        )
    ");
    $success = $insertPedido->execute([
        ':cep'          => $data['cep'],
        ':rua'          => $data['rua'],
        ':bairro'       => $data['bairro'],
        ':cidade'       => $data['cidade'],
        ':estado'       => $data['estado'],
        ':numero'       => $data['numero'],
        ':token'        => $_COOKIE['token']
    ]);

    $pedido_id = $db->lastInsertId();

    foreach ($data['produtos'] as $produto) {
        $insert = $db->prepare("
            INSERT INTO pedido_produtos
            (
                qtd,
                valor,
                produto_id, 
                pedido_id,
                fornecedores
            )
            VALUES
            (
                :qtd,
                (SELECT valor FROM produtos WHERE id = :produto_id) * :qtd,
                :produto_id,
                :pedido_id,
                :fornecedores
            )
        ");
        $success = $insert->execute([
            ':qtd'          => $produto['qtd'],
            ':produto_id'   => $produto['produto_id'],
            ':pedido_id'    => $pedido_id,
            ':fornecedores' => $produto['fornecedores']
        ]);
    }
    $db->commit();
} catch (Exception $e) {
    $db->rollBack();
    echo json_encode([
        'success'   => false
    ]);
    exit;
}

echo json_encode([
    'success'   => $success
]);
exit;