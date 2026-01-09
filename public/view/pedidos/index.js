$(function () {
    modal = new bootstrap.Modal(document.getElementById('modalProdutos'));

    function buscarPedidos() {
        $.get('/pedidos', function (data) {
            if(data.result.length <= 0) {
                return $('#msg').html(`
                    <div onclick="$("#msg").html("")" class="alert alert-warning">Nenhum Pedido Encontrado</div>
                `);
            }
            $('#card_principal').show();
            $('#tabelaPedidos').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                info: false,
                autoWidth: false,
                data: data.result,
                rowId: 'id',
                ordering: true,
                orderable: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json',
                    searchPlaceholder: 'Pedido ID ou Endereço'
                },
                columns: [
                    { data: 'id', title: 'Pedido ID' },
                    { data: 'endereco', orderable: false, title: 'Endereço' },
                    { data: 'data', searchable: false, title: 'Data' },
                    { 
                        data: 'id',
                        title: 'Produtos',
                        searchable: false, 
                        orderable: false,
                        render: produto_id => `<button class="btn btn-primary btn-sm" id="produtos" value="${produto_id}">Produtos</button>`
                    },
                ]
            });
            $('#tabelaPedidos tbody').on('click', '#produtos', function () {
                produtos($(this).attr('value'));
            });
        });
    }

    function produtos(pedido_id){
        $('#divTabelaProdutos').html(`
            <table class="table table-striped table-hover" id="tabelaProdutos">
            </table>
        `)
        $.get('/pedido_produtos', {pedido_id}, function (data) {
            $('#pedido__id').html(pedido_id);
            $('#tabelaProdutos').DataTable({
                paging: false,
                lengthChange: false,
                searching: true,
                info: false,
                autoWidth: false,
                data: data.result,
                rowId: 'produto_nome',
                ordering: false,
                orderable: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json',
                    searchPlaceholder: 'Nome do Produto'
                },
                columns: [
                    { data: 'produto_nome', title: 'Nome do Produto' },
                    { data: 'quantidade', searchable: false, title: 'Quantidade' },
                    { 
                        data: 'valor',
                        title: 'Valor',
                        searchable: false,
                        render: v => 'R$ ' + parseFloat(v).toFixed(2)
                    },
                ]
            });
            $('#total').text(`Total: R$ ${data.result.map((item) => parseFloat(item.valor)).reduce((acumulador, total) => acumulador + total, 0).toFixed(2)}`)
        });
        modal.show();
    }

    $('#logout').on('click', function () {
        $.get(`/deslogar`, function (resp) {
            console.log(resp)
            if(resp.success){
                window.location.href = '/view/login';
            }
        })
    });

    $('.tipo_busca').on('change', function () {
        const tipo_busca = parseInt($(this).val());
        $('#tabelaPedidos_filter input').attr('placeholder', $(this).attr('texto'))
        $('#tabelaPedidos_filter input').off('keyup').on('keyup', function() {
            $('#tabelaPedidos').DataTable()
                .column(tipo_busca)
                .search(this.value)
                .draw();
        });
    })

    $('#novo_pedido').on('click', () => {
        window.location.href = '/view/criar_pedido';
    });

    buscarPedidos();
});