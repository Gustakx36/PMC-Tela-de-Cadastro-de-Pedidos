<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/login':
        require '../app/api/login.php';
        break;
    case '/pedidos':
        require '../app/api/pedidos.php';
        break;
    case '/produtos':
        require '../app/api/produtos.php';
        break;
    case '/fornecedores':
        require '../app/api/fornecedores.php';
        break;
    case '/criar_pedido':
        require '../app/api/criar_pedido.php';
        break;
    case '/criar_login':
        require '../app/api/criar_login.php';
        break;
    case '/pedido_produtos':
        require '../app/api/pedido_produtos.php';
        break;
    case '/deslogar':
        require '../app/api/deslogar.php';
        break; 
    default:
        header('Location: /view/login');
        exit;
}