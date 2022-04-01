<?php

class HomeController extends Controller{

    public function index(){
        $this->data['message'] = 'Bad request';
        $this->data['alert'] = 'Bad request';
        $this->data['err'] = true;
        $this->response($this->data);
    }
    
    public function test(){
        $this->response($this->request());
    }
}