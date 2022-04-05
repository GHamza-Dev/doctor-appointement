<?php

class ScheduleController extends Controller{
    
    public function __construct(){
        parent::__construct('Schedule');    
    }

    public function index(){ 
        $this->res['err'] = true;
        $this->res['code'] = 404;
        $this->res['message'] = 'Bad request';
        $this->response();
    }

    public function av_schedule(){
        $date = isset($this->request()->date) ? $this->request()->date : $date = date('Y-m-d');
        $sch = $this->model->selectAvSchedule($date);
        
        $this->res['data'] = $sch;
        $this->response();
    }
}