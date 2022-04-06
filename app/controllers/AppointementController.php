<?php

class AppointementController extends Controller{
    
    public function __construct(){
        parent::__construct('Appointement');    
    }

    // Create Appointement
    public function create(){
        $aptmt = $this->request();
        if(!isset($aptmt->uid) || !isset($aptmt->scid) || !isset($aptmt->date)){
            $this->res['err'] = true;
            $this->res['message'] = 'Failed';
            $this->res['alert'] = 'Uncompatible number of fields';
            $this->response();
        }

        $res = $this->model->insertAppointement($aptmt->uid,$aptmt->scid,$aptmt->date);
        
        if ($res) {
            $this->res['message'] = 'success';
            $this->res['alert'] = 'You have successfully booked an appointement';
        }

        $this->response();
    }

    // Get user appointements 
    public function getUserAppts(){
        $user = $this->request();
        if(!isset($user->uid)){
            $this->res['err'] = true;
            $this->res['message'] = 'Failed';
            $this->res['alert'] = 'Uncompatible number of fields';
            $this->response();
        }

        $res = $this->model->selectUserAppt($user->uid);
        $this->res['data'] = $res;
        $this->res['message'] = 'success';
        $this->response();
    }
}