<?php
session_start();

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
