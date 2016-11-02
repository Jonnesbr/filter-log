<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Charset Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/string_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Array To UTF8
 *
 * Converte os valores dos elementos de um array chave=>valor para utf8:
 *
 * @access	public
 * @param	array
 * @return	array
 */
if ( ! function_exists('array_to_utf8'))
{
	function array_to_utf8($array)
	{
		if (!is_array($array)){
			return false;
		}
		foreach ($array as $chave=>$valor){
			if (is_array($valor)){
				$array[$chave] = array_to_utf8($valor);
			} else {
				$array[$chave] = utf8_encode($valor);
			}
		}
		return $array;
	}
	
	/**
	 * Trata os dados postados via ajax
	 * @param unknown $value
	 */
	function ajaxPostFix(&$value){
		$value = utf8_decode($value);
	}
}



/* End of file string_helper.php */
/* Location: ./application/helpers/charset_helper.php */