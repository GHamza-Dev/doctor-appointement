<?php

class Router{

  protected $controller = 'HomeController';
  protected $method = 'index';
  protected $params = [];

  function __construct()
  {
    
    $url = $this->getRequestedUrl();
    require CORE_PATH.'/Auth.php';

    if (isset($url[0]) && file_exists(APPLICATION_PATH . '/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
      $this->controller = ucfirst($url[0]).'Controller';
      unset($url[0]);
    }

    require_once APPLICATION_PATH . '/controllers/' . $this->controller . '.php';
    $this->controller = new $this->controller;

    if (isset($url[1]) && method_exists($this->controller, $url[1])) {
      $this->method = $url[1];
      unset($url[1]);
    }

    authi($this->method);

    $this->params = $url;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->params = [filter($_POST)]; 
    }

    call_user_func_array([$this->controller, $this->method], $this->params);
  }

  /**
   * 
   * Get the url the requested url
   * @return array 
   * 
   */

  public function getRequestedUrl()
  {
    return isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];
  }
}
