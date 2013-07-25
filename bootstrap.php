<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

// Ensure libraries are on PHP include path
define('BASE_PATH', realpath(dirname(__FILE__)));
set_include_path(implode(PATH_SEPARATOR, array(
    BASE_PATH . '/src',
    BASE_PATH . '/test',
    get_include_path(),
)));
 
// Initilaize class autoloader
function autoload($className) {
    require($className . '.php');
}
spl_autoload_register('autoload');
