var APP = APP || {};

APP.Login = (function($){

    function init(){

        bindEvents();

    }

    function bindEvents(){
        $('#form_login').on('click','.link-esqueci-senha', function(e){
            e.preventDefault();
            recuperarSenha($(this));
        });

        $('#div_ativacao').on('click', '.submit-nova-senha', function(event){
            event.preventDefault();
            recadastrarSenha($(this));
        });
    }


    function recuperarSenha(element){
        return $.ajax({
            type:'POST',
            url: element.attr('href'),
            async:false,
            cache:false,
            data:{'email':$('#email').val()},
            dataType:'json',
            error:function(xhr, status,error){
                window.location = base_url+"Admin/Login";
                alert('Erro ' + error);
            },
            success:function(response){
                $('#retorno_login').html(response.mensagem).removeClass('alert alert-danger alert-success');
                if (response.sucesso){
                    $('#retorno_login').addClass('alert alert-success');
                } else {
                    $('#retorno_login').addClass('alert alert-danger');
                }
                $('#retorno_login_mensagem').hide();
            }
        });
    }

    function recadastrarSenha(element){
        return $.ajax({
            type:'POST',
            url: element.data('url'),
            async:false,
            cache:false,
            data: {'hash':$('#hash').val(),'senha':$('#senha').val(),'senha_confirmacao':$('#senha_confirmacao').val()},
            dataType:'json',
            error:function(xhr, status, error){
                alert('Erro' + error);
            },
            success:function(response){
                $('#retorno_ativacao').removeClass('alert alert-danger alert-success');
                if(response.sucesso){
                    $('#retorno_ativacao').html(response.mensagem).addClass('alert alert-success');
                }else{
                    $('#retorno_ativacao').html(response.mensagem).addClass('alert alert-danger');
                }
            }
        });
    }

    return {init:init};

})(jQuery);

