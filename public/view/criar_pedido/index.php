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
        .selected {
            background: #007bff !important;
            color: #fff !important;
        }
        .check{
            display: none;
            color: green;
        }
        .option:hover {
            background: #007bff75;
            color: #fff;
            cursor: pointer;
        }
        .h-200 {
            min-height: 150px;
        }
        .option{
            border: var(--bs-border-width) solid var(--bs-border-color);
            padding: 5px;
            border-radius: 6px;
        }
        #table {
            width: 100%;
        }
        #criarPedido {
            display: none;
        }
        .bold {
            font: bold;
        }
    </style>
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Criar Novo Pedido <button class="btn btn-primary btn-sm" id="pedidos">Visualizar Pedidos</button></h3>
        <button class="btn btn-danger btn-sm" id="logout">Sair</button>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Produto(s)</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <select id="produto" class="form-select">
                            <option value="" selected>Selecione um Produto</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <input type="number" id="qtd" class="form-control" placeholder="Quantidade">
                    </div>
                    <div class="col-md-12 mt-3">
                        <input type="text" step="0.01" id="valor" class="form-control" placeholder="Valor" disabled>
                    </div>
                </div>    

                <div class="col-md-6 d-flex overflow-auto h-200">
                    <div id="fornecedor" class="w-100 overflow-auto form-control">
                        <div style="display: flex; width: 100%; justify-content: center;">
                            SELECIONE UM PRODUTO
                        </div>
                    </div>
                </div>

                <div class="col-md-12 d-flex justify-content-center mt-4 mb-4">
                    <div class="col-md-3 d-grid">
                        <button class="btn btn-success" id="adicionarProduto" disabled>Adicionar Produto</button>
                    </div>
                </div>

                <div class="col-md-12 d-flex justify-content-start mt-1 mb-1">
                    <p class="fw-bold" id=total>Total: R$ 0.00</p>
                </div>

                <div class="col-md-12 d-flex overflow-auto">
                    <div class="overflow-auto" id="table">
                        <table id="tabelaProdutos" class="table table-bordered table-hover">
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
        <h5 class="mb-3">Endereco</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" id="cep" class="form-control" placeholder="CEP">
                </div>
                <div class="col-md-8">
                    <input type="text" id="rua" class="form-control" placeholder="Rua">
                </div>

                <div></div>

                <div class="col-md-3">
                    <input type="text" id="bairro" class="form-control" placeholder="Bairro">
                </div>
                <div class="col-md-3">
                    <input type="text" id="cidade" class="form-control" placeholder="Cidade">
                </div>
                <div class="col-md-3">
                    <input type="text" id="estado" class="form-control" placeholder="Estado">
                </div>
                <div class="col-md-3">
                    <input type="number" id="numero" class="form-control" placeholder="Número">
                </div>
            </div>
        </div>
    </div>

    <div id="msg" class="mt-4 mb-4"></div>

    <div class="col-md-12 d-flex justify-content-center mt-4 mb-4">
        <div class="col-md-5 d-grid">
            <button class="btn btn-primary" id="criarPedido">Criar Pedido</button>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="index.js"></script>

</body>
</html>