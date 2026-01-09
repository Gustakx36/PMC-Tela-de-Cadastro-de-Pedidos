<?php
require __DIR__ . '/../../../app/validacao/validacao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card mt-5 shadow">
                <div class="card-body">
                    <h4 class="text-center mb-4">Login</h4>

                        <div class="mb-3">
                            <label class="form-label">login</label>
                            <input type="text" id="login" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Senha</label>
                            <input type="password" id="senha" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100" id="logar">
                            Entrar
                        </button>
                        <button class="btn btn-success w-100 mt-3" id="criar_login">
                            Criar Login
                        </button>

                    <div id="msg" class="mt-3 text-center"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="index.js"></script>
</body>
</html>