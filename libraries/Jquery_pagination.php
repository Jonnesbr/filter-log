<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Pagination Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Pagination
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/pagination.html
 */
class Jquery_pagination{

	private $base_url			= ''; 
	private $total_rows  		= ''; 
	private $per_page	 		= 10; 
	private $num_links			=  5; 
	private $cur_page	 		=  0; 
	private $first_link   		= '&lsaquo; Primeiro';
	private $next_link			= '&gt;';
	private $prev_link			= '&lt;';
	private $last_link			= '&Uacute;ltimo &rsaquo;';
	private $uri_segment		= 3;
	private $full_tag_open		= '';
	private $full_tag_close		= '';
	private $first_tag_open		= '';
	private $first_tag_close	= '&nbsp;';
	private $last_tag_open		= '&nbsp;';
	private $last_tag_close		= '';
	private $cur_tag_open		= '&nbsp;<b>';
	private $cur_tag_close		= '</b>';
	private $next_tag_open		= '&nbsp;';
	private $next_tag_close		= '&nbsp;';
	private $prev_tag_open		= '&nbsp;';
	private $prev_tag_close		= '';
	private $num_tag_open		= '&nbsp;';
	private $num_tag_close		= '';
	private $js_rebind 			= '';
	private $method_pagination  = 'AjaxPage';
	private $uri_segment_pagination = 2;
	
	// Added By Tohin
	private $div                = '';
	private $postVar             = '';

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	parâmetros de inicialização
	 */
	public function CI_Pagination($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);		
		}
		
		log_message('debug', "Pagination Class Initialized");
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Initializar as Preferências
	 *
	 * @access	public
	 * @param	array	parâmetros de initialização
	 * @return	void
	 */
	public function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}		
		}
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Gera os links de paginação
	 *
	 * @access	public
	 * @return	string
	 */	
	public function create_links()
	{
		// Se o total de itens ou o número de itens por página é zero então ná há necessidade de continuar.
		if ($this->total_rows == 0 OR $this->per_page == 0)
		{
		   return '';
		}

		// Calcular o numero total de páginas
		$num_pages = ceil($this->total_rows / $this->per_page);

		// Só vai aparecer somente uma única página? Hum... Então não há mais nada pra fazer aqui.
		if ($num_pages == 1)
		{
			return '';
		}

		// Determinar o número de página atual.		
		$CI =& get_instance();	
		
		/**
		 * Verifica antes se o método é o método de paginação
		 * Caso não seja é sinal de que a página corrente é = 0 ou seja é a Página inicial; 
		*/
		if ($CI->uri->segment($this->uri_segment_pagination) == $this->method_pagination) {
			if ($CI->uri->segment($this->uri_segment) != 0)
			{
				$this->cur_page = $CI->uri->segment($this->uri_segment);
				
				// Alimenta o atributo que armazena a página atual!
				$this->cur_page = (int) $this->cur_page;
			}
		}

		$this->num_links = (int)$this->num_links;
		
		if ($this->num_links < 1)
		{
			show_error('O número de links precisa ser um número positivo.');
		}
				
		if ( ! is_numeric($this->cur_page))
		{
			$this->cur_page = 0;
		}
		
		// O número da página está além do intervado do resultado?
		// Se sim mostramos a última página
		if ($this->cur_page > $this->total_rows)
		{
			$this->cur_page = ($num_pages - 1) * $this->per_page;
		}
		
		$uri_page_number = $this->cur_page;
		$this->cur_page = floor(($this->cur_page/$this->per_page) + 1);

		// Calcular os números de início e fim. Esse método determina
		// aos links de navegação qual número iniciar e qual número finalizar
		$start = (($this->cur_page - $this->num_links) > 0) ? $this->cur_page - ($this->num_links - 1) : 1;
		$end   = (($this->cur_page + $this->num_links) < $num_pages) ? $this->cur_page + $this->num_links : $num_pages;

		// Adicionar uma barra para a URL base caso seja necessário
		$this->base_url = rtrim($this->base_url, '/') .'/';

  		// E aqui vamos nós...
		$output = '';

		// Renderizar o "Primeiro" link
		if  ($this->cur_page > $this->num_links)
		{
			$output .= $this->first_tag_open 
					. $this->getAJAXlink( '' , $this->first_link)
					. $this->first_tag_close; 
		}

		// Renderizar o link "anterior" link
		if  ($this->cur_page != 1)
		{
			$i = $uri_page_number - $this->per_page;
			if ($i == 0) $i = '';
			$output .= $this->prev_tag_open 
					. $this->getAJAXlink( $i, $this->prev_link)
					. $this->prev_tag_close;
		}

		// Escrever os links de números de página
		for ($loop = $start -1; $loop <= $end; $loop++)
		{
			$i = ($loop * $this->per_page) - $this->per_page;
					
			if ($i >= 0)
			{
				if ($this->cur_page == $loop)
				{
					$output .= $this->cur_tag_open.$loop.$this->cur_tag_close; // Página atual
				}
				else
				{
					$n = ($i == 0) ? '' : $i;
					$output .= $this->num_tag_open
						. $this->getAJAXlink( $n, $loop )
						. $this->num_tag_close;
				}
			}
		}

		// renderizar o link de "próximo"
		if ($this->cur_page < $num_pages)
		{
			$output .= $this->next_tag_open 
				. $this->getAJAXlink( $this->cur_page * $this->per_page , $this->next_link )
				. $this->next_tag_close;
		}

		// Renderizar o "Último" link
		if (($this->cur_page + $this->num_links) < $num_pages)
		{
			$i = (($num_pages * $this->per_page) - $this->per_page);
			$output .= $this->last_tag_open . $this->getAJAXlink( $i, $this->last_link ) . $this->last_tag_close;
		}

		// Apagar barras duplas.  Nota: Algumas vezes podemos finalizar com barras duplas
		// no penúltimo link então iremos apagar essas barras duplas.
		$output = preg_replace("#([^:])//+#", "\\1/", $output);

		// Adicionando o wrapper HTML se ele existir
		$output = $this->full_tag_open.$output.$this->full_tag_close;
		
		return $output;		
	}

	private function getAJAXlink( $count, $text) {
		
		// Para proteção CSRF para links via POST
		$CI =& get_instance();
		if ($CI->config->item('csrf_protection') && $CI->config->item('csrf_ajax_protection')){
			$token_name = $CI->config->item('csrf_token_name');
			$token = $CI->session->userdata($token_name);
			$csrfProtection = "/$token";
		}else{
			$csrfProtection = '';
		}
		
		return "<a href=\"#\" 
					onclick=\"$.post('". $this->base_url . $count . $csrfProtection ."', {'t' : 't'}, function(data){
					$('". $this->div . "').html(data);}); " . $this->js_rebind .";return false;\">"
				. $text .'</a>';
	}
	
}