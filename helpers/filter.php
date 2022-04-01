<?php

function filter_s($val){
    $val = filter_var($val,513);
    return $val;
}

function filter($data){
    if (is_string($data)) {
        $data = filter_s($data); 
    }elseif(is_array($data) || is_object($data)){
        $data = (array) $data;
        foreach($data as $key => $val){ 
            if (is_array($val) || is_object($val)) {
                $data[$key] = filter($val);
            }else{
                $data[$key] = filter_s($val);
            }
        }
    }
    return $data;
}