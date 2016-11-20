var APP = APP || {};

APP.Base = (function($){

    function init(){

        bindEvents();

    }

    function bindEvents(){

        $("select#estado").change(function(){
            carregaCidades($(this));
        });

        $('.btn-redirect').click(function(){
            executarLink($(this).data('url'));
        });

        $('.select-all').click(function(){
            selectDeselectAll(this);
        });

        $('#contentPaginacao').on('click', '.btn-status', function(){
            sweetStatusModal($(this));
        });

        $('#contentPaginacao').on('click', '.btn-delete', function(){
            sweetDeleteModal($(this));
        });
    }

    /**
     * Alterar status do registro com modal sweetAlert2 v4.0.6
     * @param element - deve conter: url (método), id do item e url index (para onde deve ser redirecionado após alteração).
     */
    function sweetStatusModal(element) {

        var url = base_url + element.data('url');
        var id = element.data('id');
        var status = (element.data('status')) ? element.data('status') : '';

        swal({
            title: 'Você tem certeza?',
            text: "Tem certeza que deseja alterar o status desse registro?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true,
            showLoaderOnConfirm: true,
            allowOutsideClick: false
        }).then(function(isConfirm) {
            if (isConfirm === true) {
                $.post(
                    base_url + element.data('url'),
                    {
                        id: id,
                        status: status
                    }
                )
                    .done(function (resposta) {
                        resposta = JSON.parse(resposta);
                        if (resposta === 1) {
                            swal('Alterado!', 'O status do registro foi alterado com sucesso.', 'success');

                            $(document).on('click', '.swal2-confirm', function() {
                                window.location = base_url + element.data('index');
                            });
                        } else {
                            swal('Erro!', 'Não foi possível alterar o status do registro, tente novamente ou contate o administrador do sistema.', 'error');
                        }
                    })
                    .error(function() {
                        swal("Oops!", "Não foi possível conectar ao servidor, tente novamente!", "error");
                    });
            }
        }, function(dismiss) {
            // dismiss can be 'cancel', 'overlay', 'close', 'timer'
            if (dismiss === 'cancel') {
                swal('Cancelado!', 'Operação cancelada.', 'error');
            }
        });
    }

    /**
     * Excluir registro com modal sweetAlert2 v4.0.6
     * @param element - deve conter: url (método), id do item e url index (para onde deve ser redirecionado após exclusão).
     */
    function sweetDeleteModal(element) {

        var url = base_url + element.data('url');
        var id = element.data('id');

        swal({
            title: 'Você tem certeza?',
            text: "Tem certeza que deseja excluir esse registro?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: true,
            showLoaderOnConfirm: true,
            allowOutsideClick: false
        }).then(function(isConfirm) {
            if (isConfirm === true) {
                $.post(
                    base_url + element.data('url'),
                    {id: element.data('id')}
                )
                    .done(function (resposta) {
                        resposta = JSON.parse(resposta);
                        if (resposta.success === true) {
                            swal(resposta.title, resposta.message, resposta.type);

                            $(document).on('click', '.swal2-confirm', function() {
                                window.location = base_url + element.data('index');
                            });
                        } else {
                            swal(resposta.title, resposta.message, resposta.type);
                        }
                    })
                    .error(function() {
                        swal("Oops!", "Não foi possível conectar ao servidor, tente novamente!", "error");
                    });
            }
        }, function(dismiss) {
            // dismiss can be 'cancel', 'overlay', 'close', 'timer'
            if (dismiss === 'cancel') {
                swal('Cancelado!', 'Operação cancelada.', 'error');
            }
        });
    }

    function carregaCidades(element){
        var estado = element.val();
        $.post(
            base_url+'Busca/cidadeSelectAjax/',
            {estado: estado},
            function(resposta){
                resposta = jQuery.trim(resposta);
                if (resposta.length > 0){
                    $('select[name=cidade]').html(resposta);
                }else{
                    $('select[name=cidade]').html('');
                }
            }
        );
    }

    function executarLink(url){
        window.location = url;
    }

    function selectDeselectAll(element){
        if(element.checked) {
            $('.checkbox-check').each(function() {
                this.checked = true;
            });
        } else {
            $('.checkbox-check').each(function() {
                this.checked = false;
            });
        }
    }

    return {init:init};

})(jQuery);

