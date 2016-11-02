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
 * Language Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Language
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/language.html
 */
class MY_Lang extends CI_Lang {

	
	/**
	 * Constructor
	 *
	 * @access	public
	 */
	function __construct()
	{
		log_message('debug', "MY_Language Class Initialized");
		parent::__construct();
	}

	// --------------------------------------------------------------------

	
	/**
	 * Fetch a single line of text from the language array
	 *
	 * @access	public
	 * @param	string	$line	the language line
	 * @return	string
	 */
	function line($line = '', $parametros = array())
	{
		$value = ($line == '' OR ! isset($this->language[$line])) ? FALSE : $this->language[$line];

		if($parametros){
			$value = vsprintf($value, $parametros);
		}
		// Because killer robots like unicorns!
		if ($value === FALSE)
		{
			log_message('error', 'Could not find the language line "'.$line.'"');
		}
		
		return $value;
	}

}
// END Language Class

/* End of file Lang.php */
/* Location: ./system/core/Lang.php */
