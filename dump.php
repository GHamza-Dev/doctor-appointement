<?php


function dump($var = false){
    echo '<pre>';
    if(!$var) echo 'It works';
    if(is_string($var)) echo $var.'<br>';
    if(is_array($var)) print_r($var);
}