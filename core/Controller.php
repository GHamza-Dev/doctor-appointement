<?php

  class Controller{

    protected $model = null;
    protected $res = [ 
      'err' => false,
      'alert' => '',
      'message' => '',
      'code' => 200,
      'data' => []
    ];

    function __construct($model = null){
      if ($model) {
        $this->setModelInstance($model);
      }
    }

    public function __set($name, $value){
      $this->$name = $value;
    }
    public function __get($name){
      return $this->$name;
    }

    public function setModelInstance($model){
      if(file_exists(APPLICATION_PATH.DS.'models'.DS.ucwords($model).'.php')){
        require_once APPLICATION_PATH.DS.'models'.DS.ucwords($model).'.php';
        $this->model = new $model();
      }else die("Err : model '$model' does not exist <br><a href='".URLROOT."'>Go back</a>");
    }

    public function getModelInstance($model){
      if(file_exists(APPLICATION_PATH.DS.'models'.DS.ucwords($model).'.php')){
        require_once APPLICATION_PATH.DS.'models'.DS.ucwords($model).'.php';
        return new $model();
      }else die("Err : model '$model' does not exist <br><a href='".URLROOT."'>Go back</a>");
    }

    public function view($viewName,$data = []){
      if(file_exists(APPLICATION_PATH.DS.'views'.DS.$viewName.'.php')) 
      require_once APPLICATION_PATH.DS.'views'.DS.$viewName.'.php';
      else die("Err : view '$viewName' does not exist <br><a href='".URLROOT."'>Go back</a>");
    }

    public function response(){
      header('Access-Control-Allow-Origin: *');
      header("Content-Type: application/json; charset=UTF-8");
      header("Access-Control-Allow-Methods: GET,POST");
      header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorizaion');
      http_response_code($this->res['code']);
      echo json_encode($this->res);
      exit;
    }

    public function request($method = 'POST'){
      if($_SERVER['REQUEST_METHOD'] != strtoupper($method)) return false;

      $data = json_decode(file_get_contents('php://input'));
      $data = filter($data);     
      $req = new stdClass();

      foreach ($data as $key => $value) {
        $req->$key = $value;
      }

      return $req;
    }

    public function redirect($path){
      if (!empty($path)) {
        header('location:'.$path);
      }
    }
    
  }
