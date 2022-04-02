<?php

class Appointement extends BaseModel{

    public function __construct(){
        parent::__construct('appoientement','aptId');
    }

    public function insertAppointement($userId,$scheduleId,$date){
        $params = [
            'userId' => $userId,
            'scheduleId' => $scheduleId,
            'date' => $date
        ];
        return $this->db->insert($this->table,$params);
    }


}