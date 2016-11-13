<?php

/**
 * Formatador de dados
 */
class LibInfraFormatador {
	public $campos_data = array();
	public $campos_valor = array();
	public $campos_valor_db = array();
	public $campos_cep = array();
	public $campos_cpfcnpj = array();
	public $campos_telefone = array();
	public $campos_url  = array();

	public function formatarPadraoBanco($argData){
		$argData = explode('/',$argData);
		$argData = new DateTime("$argData[2]-$argData[1]-$argData[0]");
		return $argData->format('Y-m-d');
	}

	public function formatarPadraoBancoHora($argData){
		$data_hora = explode(' ', $argData);
		$data = $this->formatarPadraoBanco($data_hora[0]);
		$hora = $data_hora[1];
		$argData = new DateTime("{$data} {$hora}");
		return $argData->format('Y-m-d H:i');
	}

	public function formatarPadraoInterface(&$argResultSet, $argFormatoData = 'd/m/Y', $argFormatoHora = 'H:i:s'){
		foreach ($argResultSet as $chave=>$item){
			foreach ($this->campos_data as $campo){
				if (array_key_exists($campo, $item)){
					$data = $item[$campo];
					if (!$data || $data == DATA_VAZIA) return;
					$argDataRetorno = new DateTime("$data");

					$argResultSet[$chave][$campo] = $argDataRetorno->format($argFormatoData);
					if (count(explode(' ', $data))>1)
						$argResultSet[$chave][$campo] = $argDataRetorno->format("{$argFormatoData} {$argFormatoHora}");
				}
			}
		}
	}

	public function formatarDataPadraoInterface($argData){
		if (!$argData || $argData == DATA_VAZIA) return;
		$argDataRetorno = new DateTime("$argData");
		return $argDataRetorno->format('d/m/Y');
	}

	/**
	 * Recebe o valor no formato do BD e formata no valor de moeda Real
	 * @param float $argValor
	 * @return string
	 */
	public function formatarMoeda($argValor){
		return 'R$ ' . number_format($argValor, 2, ',', '.');
	}

	/**
	 * @param float $argValor
	 * @return string
	 */
	public function formatarDecimalInterface($argValor){
		return number_format($argValor, 2, ',', '.');
	}

	/**
	 * @param float $argValor
	 * @return string
	 */
	public function formatarDecimalForm($argValor){
		return number_format($argValor, 2, ',', '');
	}

	/**
	 * @param float $argValor
	 * @return string
	 */
	public function formatarDecimalBanco($argValor){
		return number_format(str_replace(',','.',str_replace('.','',$argValor)), 2, '.','');
	}

	/**
	 * Recebe um cpf ou cnpj sem máscara e retorna formatado com a máscara
	 * @param string $argValor
	 * @return string
	 */
	function formatarCpfCnpj($argValor){
		$output = preg_replace("[' '-./ t]", '', $argValor);
		$size = (strlen($output) -2);
		if ($size != 9 && $size != 12) return $argValor;
		$mask = ($size == 9) ? '###.###.###-##' : '##.###.###/####-##';
		$index = -1;
		for ($i=0; $i < strlen($mask); $i++):
			if ($mask[$i]=='#') $mask[$i] = $output[++$index];
		endfor;
		return $mask;
	}

	/**
	 * Recebe um cep sem máscara e retorna formatado com a máscara
	 * @param string $argValor
	 * @return string
	 */
	function formatarCep($argValor){
		$output = preg_replace("[' '-./ t]", '', $argValor);
		$size = (strlen($output));
		if ($size != 8) return $argValor;
		$mask = '##.###-###';
		$index = -1;
		for ($i=0; $i < strlen($mask); $i++):
			if ($mask[$i]=='#') $mask[$i] = $output[++$index];
		endfor;
		return $mask;
	}

	/**
	 * Recebe um telefone ou celualr sem máscara e retorna formatado com a máscara
	 * @param string $argValor
	 * @return string
	 */
	function formatarTelefone($argValor){
		$output = preg_replace("[()' '-./ t]", '', $argValor);
		$size = (strlen($output));
		if ($size != 10 && $size != 11) return $argValor;
		$mask = ($size == 10) ? '(##)####-####' : '(##)#####-####';
		$index = -1;
		for ($i=0; $i < strlen($mask); $i++):
			if ($mask[$i]=='#') $mask[$i] = $output[++$index];
		endfor;
		return $mask;
	}

	/**
	 * Recebe um resultSet por referência e formata os campos de acordo com os atributos setados nesta classe
	 * @param array $argResultSet
	 */
	public function formatarDados(&$argResultSet){
		foreach ($argResultSet as $chave=>$item){
			foreach ($this->campos_valor as $campo){
				if (array_key_exists($campo, $item)){
					$argResultSet[$chave][$campo] = $this->formatarDecimalInterface($item[$campo]);
				}
			}
			foreach ($this->campos_valor_db as $campo){
				if (array_key_exists($campo, $item)){
					$argResultSet[$chave][$campo] = $this->formatarDecimalBanco($item[$campo]);
				}
			}
			foreach ($this->campos_data as $campo){
				if (array_key_exists($campo, $item)){
					$argResultSet[$chave][$campo] = $this->formatarDataPadraoInterface($item[$campo]);
				}
			}
			foreach ($this->campos_cpfcnpj as $campo){
				if (array_key_exists($campo, $item)){
					$argResultSet[$chave][$campo] = $this->formatarCpfCnpj($item[$campo]);
				}
			}
			foreach ($this->campos_telefone as $campo){
				if (array_key_exists($campo, $item)){
					$argResultSet[$chave][$campo] = $this->formatarTelefone($item[$campo]);
				}
			}
			foreach ($this->campos_cep as $campo){
				if (array_key_exists($campo, $item)){
					$argResultSet[$chave][$campo] = $this->formatarCep($item[$campo]);
				}
			}
			foreach ($this->campos_url as $campo){
				if (array_key_exists($campo, $item)){
					$argResultSet[$chave][$campo] = $this->adicionaHttp($item[$campo]);
				}
			}
		}
	}

	public function retiraCaracteresEspeciais($argstring) {
		$limpa = array("(", ")", "-", ".", ",", "/", " ", "'", "\"", "´", "`", "+", "_");
		return str_replace($limpa, "", $argstring);
	}

	public function retiraHttp($argURL)
	{
		$pattern = "¢^(http://)|(https://)+¢";
		$replacement = "";
		return $url = preg_replace($pattern, $replacement, $argURL);
	}

	public function adicionaHttp($argURL)
	{
		return 'http://'.$argURL;
	}

	public function formatar($argValor,$argTipo = '')
	{
		switch ($argTipo){
			case 'db_data':
				return $this->formatarPadraoBanco($argValor);
			case 'db_data_fim':
				return $this->formatarPadraoBanco($argValor) . HORA_FIM ;
			case 'data':
				return $this->formatarPadraoInterface($argValor);
			case 'data_fim':
				return $this->formatarPadraoInterface($argValor) . HORA_FIM ;
			case 'limpo':
				return $this->retiraCaracteresEspeciais($argValor);
			case 'cpfcnpj':
				return $this->formatarCpfCnpj($argValor);
			default:
				return $argValor;
		}
	}
}