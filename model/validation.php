<?php
function validName($text){
    return ctype_alpha($text);
}
function validAge($num){
    return is_numeric($num);
}
function validPhone($num){
    return is_numeric($num)&&strlen($num);
}
function validEmail($text){
    $valid = strpos($text,'@');
    $valid2 = strpos($text,'.com');
    return $valid&&$valid2;
}