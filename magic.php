<?php

// -------------------------------------
define('DS', DIRECTORY_SEPARATOR);
require_once './dump.php';
require_once './config/config.php';


// -------------------------------------


$opt = getopt('c:mm::');

function writeController($file,$className){
    $content = "<?php\n\nclass $className extends Controller{\n\n}";
    fprintf($file,$content);
}

function writeModel($file,$className){
    $content= "<?php\n\nclass $className extends BaseModel{\n\n";
    $content.= "    public function __construct(\$tableName = 'null',\$primaryKey = 'null'){\n";
    $content.="        parent::__construct(\$tableName,\$primaryKey);\n    }\n\n}";
    fprintf($file,$content);
}

if (isset($opt['c']) && !empty($opt['c'])) {

    $controllerName = ucfirst($opt['c']);
    $controllerName.='Controller';

    $fileName = $controllerName.'.php';

    if ($f = fopen(CONTROLLERS.DS.$fileName,"w")) {
        writeController($f,$controllerName);
        printf(">> Controller created successfully at: [%s]",APPLICATION_PATH.DS.$fileName);
    }

}else{
    print("Please enter the controller name:\n");
    print("Example: -c <<controller>>");
}

if (isset($opt['m'])) {

    $modelName = ucfirst($opt['c']);
    $fileName = $modelName.'.php';

    if ($f = fopen(MODELS.DS.$fileName,"w")) {
        writeModel($f,$modelName);
        printf("\n>> Model created successfully at: [%s]",APPLICATION_PATH.DS.$fileName);
    }

}