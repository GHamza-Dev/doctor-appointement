<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: 'GET,POST,OPTIONS'");
header('Access-Control-Allow-Headers: *');
// Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With,Content-Type, Accept

define('DS', DIRECTORY_SEPARATOR);
require_once './config/config.php';
require_once ROOT.'/helpers/filter.php';
require_once ROOT.'/helpers/session.php';

require_once './dump.php';

spl_autoload_register(function($className){
  try {
    if(file_exists(CORE_PATH.DS.$className.'.php'))
    require_once CORE_PATH.DS.$className.'.php';
  } catch (Exception $e) {
    die($e->getMessage());
  }
});


new Router();
