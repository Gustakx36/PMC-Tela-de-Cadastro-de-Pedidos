$(function () {
    var produtos;
    var produtosSelecionados = [];

    function adicionarProduto(produto) {
        if(!$.fn.dataTable.isDataTable('#tabelaProdutos')){
            $('#tabelaProdutos').DataTable({
                paging: false,
                lengthChange: false,
                searching: false,
                info: false,
                autoWidth: false,
                data: [],
                rowId: 'produto_id',
                ordering: false,
                orderable: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json'
                },
                columns: [
                    { data: 'produto_nome', title: 'Produto' },
                    { data: 'qtd', title: 'Quantidade' },
                    { 
                        data: 'valor',
                        title: 'Valor',
                        render: valor => 'R$ ' + valor.toFixed(2)
                    },
                    { data: 'fornecedores', title: 'Fornecedor(es)' },
                    { 
                        data: 'produto_id',
                        title: 'Ações',
                        render: produto_id => `
                            <button class="btn btn-danger btn-sm" id="produtos" value="${produto_id}">Deletar</button>
                            <button class="btn btn-secondary btn-sm bold" id="rmv" value="${produto_id}">-</button>
                            <button class="btn btn-primary btn-sm bold" id="add" value="${produto_id}">+</button>
                        `
                    },
                ]
            });
            $('#tabelaProdutos tbody').on('click', '#produtos', function () {
                deletarProduto(parseInt($(this).attr('value')), this);
                atualizaValorTotal();
            });
            $('#tabelaProdutos tbody').on('click', '#rmv', function () {
                removerUmProduto(parseInt($(this).attr('value')), this);
                atualizaValorTotal();
            });
            $('#tabelaProdutos tbody').on('click', '#add', function () {
                adicionarUmProduto(parseInt($(this).attr('value')), this);
                atualizaValorTotal();
            });
        }
        $(`option[value="${produto.produto_id}"]`).attr('disabled', true)

        const table = $('#tabelaProdutos').DataTable();
        if(table.row('#' + produto.produto_nome).length > 0) return;

        produtosSelecionados.push(produto);
        table.row.add(produto).draw(false);
        $('#cep').trigger('keyup');
    }

    function adicionarUmProduto(produto_id) {
        const table = $('#tabelaProdutos').DataTable();
        const produto = produtosSelecionados[produtosSelecionados.findIndex(p => p.produto_id === produto_id)];

        produto.qtd = produto.qtd + 1;
        produto.valor = produto.qtd * produto.produto_valor;

        table.row('#' + produto_id).data(produto).draw(false);
    }

    function removerUmProduto(produto_id) {
        const table = $('#tabelaProdutos').DataTable();
        const produto = produtosSelecionados[produtosSelecionados.findIndex(p => p.produto_id === produto_id)];

        if(produto.qtd == 1) return deletarProduto(produto_id);

        produto.qtd = produto.qtd - 1;
        produto.valor = produto.qtd * produto.produto_valor;

        table.row('#' + produto_id).data(produto).draw(false);
    }

    function deletarProduto(produto_id){
        const table = $('#tabelaProdutos').DataTable();   
        table.row('#' + produto_id).remove().draw(false);

        const index = produtosSelecionados.findIndex(p => p.produto_id === produto_id);
        if(produtosSelecionados.length == 1){
            $('#table').html(`
                <table id="tabelaProdutos" class="table table-bordered table-hover">
                </table>
            `);
        }

        const produto = produtosSelecionados[index];
        $(`option[value="${produto.produto_id}"]`).attr('disabled', false)

        if (index > -1) {
            produtosSelecionados.splice(index, 1);
        }
    }

    function carregarProdutos() {
        $.get('/produtos', function (data) {
            data.result.forEach(produto => {
                $('#produto').append(`<option value="${produto.id}">${produto.nome}</option>`);
            });
            produtos = data.result;
        });
    }

    function carregarFornecedores(produto_id) {
        $.get('/fornecedores', {produto_id}, function (data) {
            $('#fornecedor').html("");
            data.result.forEach(foenecedor => {
                $('#fornecedor').append(`
                    <div 
                        class="option d-flex justify-content-between" 
                        value="${foenecedor.id}">
                        ${foenecedor.nome}
                        <div class="check"><i class="fa-solid fa-check"></i></div>
                    </div>`);
            });
        });
    }

    function validaAdicionarProduto(){
        var valido = true;
        $('#produto, #qtd')
        .each(function (e, item) {
            if($(item).val().length <= 0) valido = false;
        });
        const fornecedores = [];
        $('.option').each((i, item) => {
            const selecionado = $($(item).children()).css('display') != 'none'
            if(selecionado)fornecedores.push($(item).attr('value'))
        });
        if(fornecedores.length <= 0) valido = false;
        if(parseInt($('#qtd').val()) <= 0) valido = false;
        return valido;
    }

    function validaCriarPedido(){
        var valido = true;
        $('#cep, #rua, #bairro, #cidade, #estado, #numero')
        .each(function (e, item) {
            if($(item).val().length <= 0) valido = false;
        });
        if(produtosSelecionados.length <= 0) valido = false;
        return valido;
    }

    function atualizaValorTotal(){
        $('#total').text(`Total: R$ ${produtosSelecionados.map((item) => parseFloat(item.valor)).reduce((acumulador, total) => acumulador + total, 0).toFixed(2)}`)
    }

    $('#adicionarProduto').on('click', function () {
        if(!validaAdicionarProduto()) return;
        var fornecedores = [];
        $('.option').each((i, item) => {
            const selecionado = $($(item).children()).css('display') != 'none'
            if(selecionado)fornecedores.push($(item).attr('value'))
        });

        const index = produtos.findIndex(p => p.id === parseInt($('#produto option:selected').val()));
        const valor = produtos[index].valor;

        produto = {
            qtd: parseInt($('#qtd').val()),
            valor: parseFloat(valor) * parseInt($('#qtd').val()),
            fornecedores: fornecedores.join(','),
            produto_id: parseInt($('#produto').val()),
            produto_nome: $('#produto option:selected').text(),
            produto_valor: parseFloat(valor)
        }
        adicionarProduto(produto);
        $('#fornecedor').html(`
            <div style="display: flex; width: 100%; justify-content: center;">
                SELECIONE UM PRODUTO
            </div>
        `);
        $('#qtd').val("");
        $('#valor').val("");
        $('#produto').val("");
        $('#adicionarProduto').attr('disabled', true);
        atualizaValorTotal();
    });

    $('#criarPedido').on('click', function () {
        if(!validaCriarPedido()) return; 
        $.post('/criar_pedido', {
            produtos: produtosSelecionados,
            cep: $('#cep').val(),
            rua: $('#rua').val(),
            bairro: $('#bairro').val(),
            cidade: $('#cidade').val(),
            estado: $('#estado').val(),
            numero: $('#numero').val()
        }, function (resp) {
            if (resp.success) {
                $('#table').html(`
                    <table id="tabelaProdutos" class="table table-bordered table-hover">
                    </table>
                `);
                $('#msg').html(`
                    <div class="alert alert-success" onclick="$('#msg').html('')">Pedido criado</div>
                `);

                $('#fornecedor').html(`
                    <div style="display: flex; width: 100%; justify-content: center;">
                        SELECIONE UM PRODUTO
                    </div>
                `);
                $('#qtd').val("");
                $('#valor').val("");
                $('#cep').val("");
                $('#rua').val("");
                $('#bairro').val("");
                $('#cidade').val("");
                $('#estado').val("");
                $('#numero').val("");
                $('#produto').val("");
                $('#cep').trigger('keyup');
                $('option').attr('disabled', false);
            } else {
                $('#msg').html(`
                    <div onclick="$("#msg").html("")" class="alert alert-danger">Erro</div>
                `);
            }
            $('.alert').on('click', () => {
                $('#msg').html('')
            })
        });
    });

    $('#fornecedor').on('click', 'div.option', (e) => {
        const selected = $($(e.target).children()[0]).css('display') == 'none';
        if(selected) return $($(e.target).children()[0]).show();
        $($(e.target).children()[0]).hide();
    })

    $('#produto').on('change', (e) => {
        if(!parseInt($(e.target).val())) {
            $('#fornecedor').html(`
                <div style="display: flex; width: 100%; justify-content: center;">
                    SELECIONE UM PRODUTO
                </div>
            `);
            $('#valor').val("")
            return;
        }
        const valorProdutoSelecionado = parseFloat(produtos.filter(
            (produto) => produto.id == parseInt($(e.target).val()))[0].valor);
        $('#valor').val(`R$ ${parseFloat(valorProdutoSelecionado).toFixed(2)}`);
        carregarFornecedores(parseInt($(e.target).val()));
    });

    $('#cep').on('keyup', (e) => {
        if($(e.target).val().length == 8){
            $.get(`https://viacep.com.br/ws/${$(e.target).val()}/json/`, {},
            function (resp) {
                if(resp.erro) return console.log('Erro');
                $('#rua').val(resp.logradouro).trigger('keyup');
                $('#bairro').val(resp.bairro).trigger('keyup');
                $('#cidade').val(resp.localidade).trigger('keyup');
                $('#estado').val(resp.estado).trigger('keyup');
            });
        }
    });

    $('#cep, #rua, #bairro, #cidade, #estado, #numero')
    .on('keyup', function (e) {
        if(validaCriarPedido()) return $('#criarPedido').show();
        $('#criarPedido').hide();
    });

    $('#produto, #qtd, #fornecedor')
    .on('click change keyup', function (e) {
        $('#adicionarProduto').attr('disabled', !validaAdicionarProduto()); 
    });

    $('#qtd').on('keyup change', function (e) {
        if(parseInt($('#qtd').val()) <= 0) $('#qtd').val("");
    });

    $('#pedidos').on('click', () => {
        window.location.href = '/view/pedidos';
    });

    $('#logout').on('click', function () {
        $.get(`/deslogar`, function (resp) {
            console.log(resp)
            if(resp.success){
                window.location.href = '/view/login';
            }
        })
    });

    carregarProdutos();
    usuarioPossuiPedidos();
});