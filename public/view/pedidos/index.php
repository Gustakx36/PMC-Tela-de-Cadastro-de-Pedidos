<?php
require __DIR__ . '/../../../app/validacao/validacao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body class="bg-light">
<style>
        #table {
            width: 100%;
        }
        #tabelaPedidos_filter {
            margin-bottom: 20px;
        }
        .form-check {
            margin-left: 30px;
        }
        #card_principal {
            display: none;
        }
    </style>
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Pedidos <button class="btn btn-primary btn-sm" id="novo_pedido">Criar Pedido Novo</button></h3>
        <button class="btn btn-danger btn-sm" id="logout">Sair</button>
    </div>

    <div class="card shadow-sm" id="card_principal">
        <div class="card-body">
        <div>
        <div class="d-flex justify-content-between mb-3 flex-wrap">
            <h5>Endereco</h5>
            <div class="d-flex flex-wrap">
                <div class="form-check">
                    <input class="form-check-input tipo_busca" type="radio" name="tipo_busca" id="todos" value="" texto="Pedido ID ou Endereço" checked>
                    <label class="form-check-label" for="todos">
                        Todos
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input tipo_busca" type="radio" name="tipo_busca" id="pedido_id" texto="Pedido ID" value="0">
                    <label class="form-check-label" for="pedido_id">
                        Pedido ID
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input tipo_busca" type="radio" name="tipo_busca" id="endereco" texto="Endereço" value="1">
                    <label class="form-check-label" for="endereco">
                        Endereco
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-12 d-flex overflow-auto">
            <div class="overflow-auto" id="table">
                <table id="tabelaPedidos" class="table table-bordered table-hover">
                </table>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade" id="modalProdutos" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Produtos do Pedido <span id="pedido_id">1</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="divTabelaProdutos">
                    <table class="table table-striped table-hover" id="tabelaProdutos">
                    </table>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <p class="fw-bold" id=total></p>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="msg" class="mt-4 mb-4"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="index.js"></script>

</body>
</html>