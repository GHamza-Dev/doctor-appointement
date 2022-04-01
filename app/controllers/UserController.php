<?php


class UserController extends Controller{
    
    public function __construct(){
        parent::__construct('user');
    }

    public function index(){
        $this->res['err'] = true;
        $this->res['alert'] = "Bad request!";
        $this->res['code'] = 404;
        $this->response();
    }

    public function uuid(){
        $uniqid = uniqid();

        if ($this->model->idExist($uniqid)) 
        $uniqid = $this->uuid();   

        return $uniqid;
    }

    public function register(){
        $user = $this->request();

        if (!isset($user->fname) || !isset($user->lname) || !isset($user->phone)) {
            $this->res['err'] = true;
            $this->res['message'] = 'failed';
            $this->res['alert'] = 'Uncompatible number of fields';
            $this->response();
        }
        
        $uniqid = $this->uuid();

        $res = $this->model->register($uniqid,$user->fname,$user->lname,$user->phone);
        
        if ($res) {
            $this->res['message'] = 'success';
            $this->res['alert'] = 'Registred successfully';
        }
        $this->response();
    }

    private function generateToken(){
        return md5(time().uniqid());
    }

    public function updateToken($id){
        $newToken = $this->generateToken();
        $experation = time() + 60;
        return $this->model->updateToken($id,$newToken,$experation);
    }

    public function valideToken($token = 0){
        return $this->model->tokenIsValide($token);
    }

    public function login(){
        $user = $this->request();
        if (!isset($user->id)) {
            $this->res['err'] = true;
            $this->res['message'] = 'failed';
            $this->res['alert'] = 'Uncompatible number of fields';
            $this->response();
        }
        $this->res['data'] = $this->model->getUser($user->id);
        $this->response();
    }

    public function test(){
        var_dump('It Works');
    }

} 