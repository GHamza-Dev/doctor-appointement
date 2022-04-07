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

    // Cancel appointement
    public function cancel(){
        $appt = $this->request();
        
        if(!isset($appt->id)){
            $this->res['err'] = true;
            $this->res['message'] = 'Failed';
            $this->res['alert'] = 'Uncompatible number of fields';
            $this->response();
        }

        if ($res = $this->model->delete($appt->id)) {
            $this->res['data'] = $res;
            $this->res['message'] = 'success';
            $this->res['alert'] = 'Appointement canceled successfully';
            $this->response();
        }

        $this->res['message'] = 'failed';
        $this->res['alert'] = 'Ops something went wrong while canceling your booking!';
        $this->response();
    }
}