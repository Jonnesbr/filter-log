var APP = APP || {};

APP.Widgets = (function($){

	"use strict";

	function init(){

        if($('.data-inicial, .data-final').length){
    		$('.data-inicial, .data-final').datetimepicker({
    			timepicker:false,
    			lang:'pt',
    			format:'d/m/Y'
    		});
        }

        if($('.data-hora-inicial, .data-hora-final').length){
            $('.data-hora-inicial, .data-hora-final').datetimepicker({
                timepicker:true,
                lang:'pt-BR',
                format:'d/m/Y H:i',
                maxDate: 0
            });
        }
        
        applyMask(); 
        applyMoneyMask();
		bindEvents();
	}

	function bindEvents() {}


	/**
     * Método que encapsula apresentação de Modal Nativo
     * Twitter Bootstrap
     *
     * @param  {object}   element  - Objeto que representa o Elemento Pai da Estrutura do Modal
     * @param  {object}   options  - Objeto com parametros de configuração - disponivel em http://getbootstrap.com/javascript/#modals
     * @param  {Function} callback - Função de callback
     * @return {boolean}
     */


    function showModal(element, options, callback){

        if(options.content) {
            $(element)
                .find('.modal-content')
                .html(options.content);
        }

        $(element).modal(options);

        if(typeof callback === 'function'){
            callback();
        }

        return false;
    }

    /**
     * Encapsula o método de
     * @param  {object}   element  - Objeto que representa o Elemento Pai da Estrutura do Modal
     * @return {boolean}
     */
    function hideModal(element){
        $(element).modal('hide');
        return false;
    }

    function applyMask() {

        /*
        var masks = ['(00) 00000-0000', '(00) 0000-00009'];

        $('.mask-celular').mask(masks[1], {
            onKeyPress: function(val, e, field, options) {
                field.mask(val.length > 14 ? masks[0] : masks[1], options) ;
            }
        });*/

        var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };

        $('.mask-celular').mask(SPMaskBehavior, spOptions);

        $('.mask-fone').mask("(99) 9999-9999");
        $('.mask-cep').mask("99.999-999");
        $('.mask-cpf').mask("999.999.999-99");
        $('.mask-cnpj').mask("99.999.999/9999-99");
        //$('.mask-celular').mask("(00) 0000-0000").focusout(function(){
         //   applyMaskPhone($(this));
        //}).trigger('focusout');
        //$('.input_numeric4').mask("?9999");
        //$('.input_numeric3').mask("?999");
        //$('.input_numeric11').mask("?99999999999");
        //$('.input_teste').mask('99.99');
        //$(".input_decimal2").maskMoney({allowZero:true, allowNegative:false, defaultZero:false, thousands:'', decimal:'.', precision:2});
        //$(".input_decimal1").maskMoney({allowZero:true, allowNegative:false, defaultZero:false, thousands:'', decimal:'.', precision:1});
        $('.mask-hora').mask("99:99");
        $('.mask-date').mask("99/99/9999");
    }


	function applyMoneyMask() {
		$(".mask-money").maskMoney({
            allowZero:true,
            allowNegative:false,
            defaultZero:false,
            thousands:'',
            decimal:',',
            precision:2
        });
	}


	return{
		init:init,
		showModal:showModal,
		applyMoneyMask:applyMoneyMask,
        applyMask:applyMask
	};

})(jQuery);
