<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('NOME_SISTEMA', 'Filter-Log');
define('DATA_VAZIA', '0000-00-00');
define('STATUS_INATIVO', 0);
define('STATUS_ATIVO', 1);
define('EMAIL_CADASTRO', 'jpaulo.bcc@gmail.com');
define('EMAIL_CADASTRO_NOME', 'FilterLog - CADASTRO');
define('EMAIL_RECUPERACAO', 'jpaulo.bcc@gmail.com');
define('EMAIL_RECUPERACAO_NOME', 'FilterLog - RECUPERAÇÃO');
define('PERFIL_ADMINISTRADOR', '1');

//Parametros para captura de eventos com erro
define('INTERVALO_MINIMO', 5.40);
define('INTERVALO_MAXIMO', 6.10);

//Parametros para identificação por cor
define('SINAL_VERDE', 4);
define('SINAL_AMARELO_MIN', 5);
define('SINAL_AMARELO_MAX', 9);
define('SINAL_VERMELHO', 10);

//Extensões de arquivos permitidos para upload
define('FILES_EXTENSION', 'doc|jpeg|jpg|pdf|bitmap|png|xls|docx|xlsx|ppt|pptx');

/* End of file constants.php */
/* Location: ./application/config/constants.php */