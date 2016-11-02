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

