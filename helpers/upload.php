<?php

function upload($input_name){
    $location = UPLOADS.'/';
  
    $file = $_FILES[$input_name]['name'];
    $file_tmp = $_FILES[$input_name]['tmp_name'];
  
    return move_uploaded_file($file_tmp, $location.$file);
  
}