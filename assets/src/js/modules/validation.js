var APP = APP || {};

APP.Validation = (function(){

    function init(){}


    function isEmpty($input){

        if(!$input.val()){

            return true;
        }

        return false;
    }


    function isNaturalNumber(value){

        if(value < 0 || typeof value === 'undefined' || ''){

            return false;
        }

        return true;
    }

    function validateRange(initial, final){

        if (initial >= final || isNaN(initial) || isNaN(final)){

            return false;
        }

        return true;

    }

    function isAlphaNumeric(value) {

        var re = /[a-zA-Z0-9 ]/g;

        return re.test(value);

    }

    function isLetter(value){

        var re = /[a-zA-Z ]/g;

        return re.test(value);

    }

    function isNumeric(value) {

        var re = /[0-9]/g;

        return re.test(value);
    }

    return{
        init:init,
        isEmpty:isEmpty,
        isNaturalNumber:isNaturalNumber,
        validateRange:validateRange,
        isAlphaNumeric:isAlphaNumeric,
        isLetter:isLetter,
        isNumeric:isNumeric
    };


})();