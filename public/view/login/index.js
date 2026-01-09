$(function () {
    $('#logar').on('click', () => {
        $('#login').val()
    
        $.ajax({
            url: '/login',
            method: 'GET',
            data: { login: $('#login').val(), senha: $('#senha').val() },
            success: function(response) {
                if(response.success) return window.location.href = '/view/pedidos';
                if(!response.success) $('#msg').html(`
                    <div class="alert alert-danger" onclick="$('#msg').html('')">${response.msg}</div>
                `);
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
    $('#criar_login').on('click', () => {
        if($('#login').val() == '' || $('#senha').val() == '') return $('#msg').html(`
            <div class="alert alert-danger" onclick="$('#msg').html('')">Preencha Todos os Campos</div>
        `);
    
        $.ajax({
            url: '/criar_login',
            method: 'GET',
            data: { login: $('#login').val(), senha: $('#senha').val() },
            success: function(response) {
                if(response.success) return window.location.href = '/view/pedidos';
                if(!response.success) $('#msg').html(`
                    <div class="alert alert-danger" onclick="$('#msg').html('')">${response.msg}</div>
                `);
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
});
