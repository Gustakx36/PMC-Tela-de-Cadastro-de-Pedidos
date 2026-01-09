<?php
require __DIR__ . '/../database/database.php';

$db = Database::connect();

header('Content-Type: application/json; charset=utf-8');

$select = $db->prepare(<<<SQL
    SELECT 
        p.id,
        CONCAT(p.rua, ", ", p.numero, " - ", p.bairro, "\n", p.cep, " ", p.cidade, "/", p.estado) AS endereco,
        DATE_FORMAT(p.created_at, '%d/%m/%Y %H:%i:%s') AS data
    FROM 
        pedidos p
    WHERE
        usuario_id = (SELECT id FROM usuarios WHERE token = :token)
SQL);
$select->execute([
    ':token' => $_COOKIE['token']
]);
$result = $select->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'success'   => $result !== false,
    'result'    => $result
]);
exit;