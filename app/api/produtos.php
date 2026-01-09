<?php
require __DIR__ . '/../database/database.php';

$db = Database::connect();

header('Content-Type: application/json; charset=utf-8');

$select = $db->query("
    SELECT 
        *
    FROM 
        produtos
");
$result = $select->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'success'   => $result !== false,
    'result'    => $result
]);
exit;