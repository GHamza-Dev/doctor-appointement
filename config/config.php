<?php

   // ROOT Directory
   define('ROOT', getcwd());
   // Application path
   define('APPLICATION_PATH', ROOT.DS.'app');
   // Controllers path
   define('CONTROLLERS', ROOT.DS.'app'.DS.'controllers');
   // Controllers path
   define('MODELS', ROOT.DS.'app'.DS.'models');
   // Config path
   define('CONFIG_PATH', ROOT.DS.'config');
   // core path
   define('CORE_PATH', ROOT.DS.'core');
   // Public path
   define('PUBLIC_PATH', ROOT.DS.'public');

   // Sub directories
   define('VIEWS', APPLICATION_PATH.DS.'views');
   
   // Uploads path
   define('UPLOADS',ROOT.DS.'uploads');   

   // Database params
   define('DB_NAME','doc-appoientment');
   define('DB_USER','root');
   define('DB_HOST','localhost');
   define('DB_PASSWD','');

   // URL ROOT
   define('URLROOT', 'http://localhost/doc');

   // Images url
   define('IMAGES', URLROOT.'/public/images');

   
   