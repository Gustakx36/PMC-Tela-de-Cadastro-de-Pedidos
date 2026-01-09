<?php
require __DIR__ . '/../database/database.php';

$data = $_GET;

$db = Database::connect();

header('Content-Type: application/json; charset=utf-8');

$select = $db->prepare("
    SELECT
        f.id, f.nome
    FROM
        fornecedor_produtos f_p
    INNER JOIN produtos p ON f_p.produto_id = p.id
    INNER JOIN fornecedor f ON f_p.fornecedor_id = f.id
    WHERE
        f_p.produto_id = :produto_id;
");
$select->execute([
    ':produto_id' => $data['produto_id']
]);
$result = $select->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'success'   => $result !== false,
    'result'    => $result
]);
exit;