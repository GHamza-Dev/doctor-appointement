<?php

class Schedule extends BaseModel{

    public function __construct(){
        parent::__construct('schedule','ScheduleId');
    }

    public function selectAvSchedule($date){

        $this->db->prepareQuery(
        "SELECT * FROM schedule 
        WHERE schedule.scheduleId 
        NOT IN (select scheduleId from appoientement where date = ?)");

        $this->db->execute([$date]);
        return $this->db->getResult();
    }

}