<?php

$debug = is_local() ? true : false; 
$debug = false; 
define( 'LC_DEBUG', $debug );

/****************************************** Set Debug Enviroment ******************************************/
if(LC_DEBUG){
	ini_set('display_errors', 1); 
	ini_set('display_startup_errors', 1); 
	error_reporting(E_ALL);	
}