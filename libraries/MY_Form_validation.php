<?php

class MY_Form_validation extends CI_Form_validation 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function valid_text($argText){
		return (bool) preg_match("/^[[:alnum:]\s\-#$%&()*;,.:!?\/@\[\]_{}|,+=¹²³ªÁáÀàÂâÃãÇçÉéÈèÊêÍíÌìîÎñÑºÓóÒòÔôõÕÚúÙùÛûüÜ]*$/", $argText);
	}

	public function valid_text_personalizacao($argText){

		if (is_numeric($argText))
			return false;

		if (preg_match("/[[:alnum:]\sÁáÀàÂâÃãÇçÉéÈèÊêÍíÌìîÎñÑÓóÒòÔôõÕÚúÙùÛûüÜ]*/", $argText, $matches)) {
			if (strcmp($argText, $matches[0]) != 0){
				return false;
			}
		}
		return true;
	}

	public function is_decimal($argValor)
	{
		$argValor = str_replace(',', '.', str_replace('.', '', $argValor));
		if (isset($argValor) && !$this->decimal($argValor))
			return false;
		return true;
	}

    public function valid_data($argData, $argSeparador=''){
		if (!$argSeparador){
			$argSeparador = '/';
		}

		if ($argSeparador == '/') {
			if (preg_match("/^([0-3])?([0-9]{1})\\".$argSeparador."([0-1])?([0-9]{1})\\".$argSeparador."([1-2]{1})([0-9]{3})$/", $argData)){
				$argData = explode($argSeparador,$argData);
				if ($argData[0] > 0 && $argData[0] < 32 && $argData[1] > 0 && $argData[1] < 13 && $argData[2] > 1900 && $argData[2] < 2100)
					return true;
			}
		}
		
		if ($argSeparador == '-') {
			if (preg_match("/^([1-2]{1})([0-9]{3})\\".$argSeparador."([0-1])?([0-9]{1})\\".$argSeparador."([0-3])?([0-9]{1})$/", $argData)){
				$argData = explode($argSeparador,$argData);
				if ($argData[0] > 1900 && $argData[0] < 2100 && $argData[1] > 0 && $argData[1] < 13 && $argData[2] > 0 && $argData[2] < 32)
					return true;
			}
		}
    	return false;
	}

	public function getErrorsArray()
	{
		return $this->_error_array;
	}

    public function addError($field, $message)
    {
        $this->_error_array[$field] = $message;
    }

	/**
	 * Valida url
	 * @param string $url
	 * @return boolean
	 */
	function is_url($url)
	{
		$filter_url_path = filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED);
		$filter_url_query_string = filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED);
		
		return ($filter_url_path || $filter_url_query_string);
	}

    public function is_unique($str, $field)
    {
        if (substr_count($field, '.')==3)
        {
            list($table,$field,$id_field,$id_val) = explode('.', $field);
            $query = $this->CI->db->limit(1)->where($field,$str)->where($id_field.' != ',$id_val)->get($table);
        } else {
            list($table, $field)=explode('.', $field);
            $query = $this->CI->db->limit(1)->get_where($table, array($field => $str));
        }

        return $query->num_rows() === 0;
    }

    function valid_cpf($cpf)
    {
        $CI =& get_instance();

        $cpf = preg_replace('/[^0-9]/','',$cpf);

        if(strlen($cpf) != 11 || preg_match('/^([0-9])\1+$/', $cpf))
        {
            return false;
        }

        // 9 primeiros digitos do cpf
        $digit = substr($cpf, 0, 9);

        // calculo dos 2 digitos verificadores
        for($j=10; $j <= 11; $j++)
        {
            $sum = 0;
            for($i=0; $i< $j-1; $i++)
            {
                $sum += ($j-$i) * ((int) $digit[$i]);
            }

            $summod11 = $sum % 11;
            $digit[$j-1] = $summod11 < 2 ? 0 : 11 - $summod11;
        }

        return $digit[9] == ((int)$cpf[9]) && $digit[10] == ((int)$cpf[10]);
    }

    /**
     * Valida telefone com ou sem m?scara, com ou sem o d?gito 9.
     * @param string $argNumero
     * @return bool
     */
    function valid_telefone($argNumero){
        return (bool) preg_match('/^(\(?[1-9]{2}\s?\)?)\s?([9]{1})?([0-9]{4})-?([0-9]{4})$/', $argNumero);
    }

    /**
     * Valida CEP com ou sem m?scara.
     * @param string $argCep
     * @return bool
     */
    function valid_cep($argCep){
        return (bool) preg_match('/^([0-9]{2})\.?([0-9]{3})-?([0-9]{3})$/', $argCep);
    }

    public function is_full_name($argNome){
        return (bool) preg_match('/^[A-Za-z0-9çÇáéíóúýÁÉÍÓÚÝàèìòùÀÈÌÒÙãõñäëïöüÿÄËÏÖÜÃÕÑâêîôûÂÊÎÔÛ&]+( [A-Za-z0-9çÇáéíóúýÁÉÍÓÚÝàèìòùÀÈÌÒÙãõñäëïöüÿÄËÏÖÜÃÕÑâêîôûÂÊÎÔÛ&.-]+)+$/', $argNome);
    }

    /**
     * Validacao da senha:
     * M?nimo 6 caracteres;
     * M?ximo 20 caracteres;
     * @param unknown $argSenha
     * @return boolean
     */
    public function valid_senha($argSenha){
        return (bool) preg_match('/^.{6,20}$/', $argSenha);
    }

}