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

    public function selectUserAppt($userId){
        $t = $this->table;

        $this->db->prepareQuery(
            "SELECT * FROM user 
            JOIN $t ON user.userId = $t.userId 
            JOIN schedule ON $t.scheduleId  = schedule.scheduleId
            WHERE $t.userId = ?
        ");

        $this->db->execute([$userId]);
        return $this->db->getResult();
    }

    public function delete($id){
        return $this->db->delete($this->table,$this->pk,$id);
    }


}