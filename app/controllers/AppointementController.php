<?php

class AppointementController extends Controller{
    
    public function __construct(){
        parent::__construct('Appointement');    
    }

    public function createAppointement(){
        $aptmt = $this->response();

        if(!isset($aptmt->uid) || !isset($aptmt->scid) || !isset($aptmt->date)){
            $this->res['err'] = true;
            $this->res['message'] = 'Failed';
            $this->res['alert'] = 'Uncompatible number of fields';
            $this->response();
        }

        $res = $this->model->insert($aptmt->uid,$aptmt->scid,$aptmt->date);
        
        if ($res) {
            $this->res['message'] = 'success';
            $this->res['alert'] = 'You have successfully booked an appointement';
        }

        $this->response();
    }
}