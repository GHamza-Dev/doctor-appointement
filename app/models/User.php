<?php


class User extends BaseModel{

    public function __construct(){
        parent::__construct('user','userId');
    }

    public function register($userId,$fname,$lname,$phone){ 
        $params = [
            'userId' => $userId,
            'firstName' => $fname,
            'lastName' => $lname,
            'phone' => $phone
        ];
        return $this->db->insert($this->table,$params);
    }

    public function idExist($id){
        $table = $this->table;
        $this->db->prepareQuery("SELECT $this->pk FROM $table WHERE $this->pk = ?");
        $this->db->execute([$id]);
        return $this->db->numRows() > 0;
    }

    public function getUser($id){
        $table = $this->table;
        $this->db->prepareQuery("SELECT * FROM $table WHERE $this->pk = ?");
        $this->db->execute([$id]);
        return $this->db->getRow();
    }

    public function updateToken($id,$token,$experation){
        $this->db->prepareQuery("UPDATE $this->table SET `token` = ?,`experation` = ? WHERE $this->pk = ?");
        return $this->db->execute([$token,$experation,$id]);
    }
    
    public function tokenIsValide($token){
        $current = time();
        $this->db->prepareQuery("SELECT `token`,`experation` FROM $this->table WHERE `token` = ? AND `experation` > $current");
        $this->db->execute([$token]);
        return $this->db->getRow();
    }
}