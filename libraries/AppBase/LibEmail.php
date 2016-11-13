<?php

class LibEmail
{
	private $CI = null;
	/*Email do remente*/
	private $remetenteEmail = null;
	/* Nome do remente */
	private $remetenteNome  = null;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->library('email');
	}

	/**
	 * envia um e-mail.
	 * @param  String $argEmailDestinatario
	 * @param  String $argAssunto
	 * @param  String $argMensagem
	 * @return [type]
	 */
	public function enviar($argEmailDestinatario, $argAssunto, $argMensagem)
	{
		$this->CI->email->from($this->remetenteEmail, $this->remetenteNome);
		$this->CI->email->to($argEmailDestinatario);
		$this->CI->email->subject($argAssunto);
		$this->CI->email->message($argMensagem);
		$this->CI->email->send();
	}

	/**
	 * seta informações (nome e e-mail) de um determinado remetente.
	 * @param String $argNome
	 * @param String $argEmail
	 */
	public function setInfoRemetente($argNome, $argEmail)
	{
		$this->remetenteNome  = $argNome;
		$this->remetenteEmail = $argEmail;
	}

	/**
	 * retorno informações setadas referente ao remetente.
	 * @return Array
	 */
	public function getInfoRemetente()
	{
		$arrInfo['nome']  = $this->remetenteNome;
		$arrInfo['email'] = $this->remetenteEmail;
		return $arrInfo;
	}

}