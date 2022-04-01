<?php

class BaseModel{
    protected $db = null;
    protected $table = null;
    protected $pk = null;

    public function __construct($table,$pk){
        $this->table = $table;
        $this->pk = $pk;
        $this->db = new Database();
    }
}