<?php


function authi($method){
    require_once CONTROLLERS.'/UserController.php';
    $allowedMethods = ['login','register'];
    $user = new UserController();
    $token = 0;
    
    if (isset(apache_request_headers()['Authorization'])) {
        $token = explode(' ',apache_request_headers()['Authorization'])[1];
    }
    
    if (!$user->valideToken($token) && !in_array($method,$allowedMethods)) {
        $res = [
            'code' => 401,
            'message' => 'failed',
            'alert' => 'Unauthorized user'
        ];
        $user->res = $res; 
        $user->response();
    }

}
