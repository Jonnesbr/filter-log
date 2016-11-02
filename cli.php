<?php
//Usado em cronjobs
set_time_limit(0);

ini_set('memory_limit', '256M');

if (isset($_SERVER['REMOTE_ADDR'])) die('Permission denied.');
define('CMD', 1);
unset($argv[0]); /* ...but not the first one */
$_SERVER['QUERY_STRING'] =  $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'] = '/' . implode('/', $argv) . '/';

set_time_limit(0);

/* call up the framework */
include(dirname(__FILE__).'/index.php');