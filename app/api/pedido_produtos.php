<?php
require __DIR__ . '/../database/database.php';

$data = $_GET;

$db = Database::connect();

header('Content-Type: application/json; charset=utf-8');

$select = $db->prepare(<<<SQL
    SELECT 
        prod.nome AS produto_nome,
        pp.qtd AS quantidade,
        pp.valor
    FROM 
        pedidos p
    INNER JOIN pedido_produtos pp ON p.id = pp.pedido_id
    INNER JOIN produtos prod ON prod.id = pp.produto_id
    WHERE
        usuario_id = (SELECT id FROM usuarios WHERE token = :token)
    AND
        p.id = :pedido_id
SQL);
$select->execute([
    ':token'        => $_COOKIE['token'],
    ':pedido_id'    => $data['pedido_id']
]);
$result = $select->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'success'   => $result !== false,
    'result'    => $result
]);
exit;