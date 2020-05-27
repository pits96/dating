<?php
function validName($text){
    return ctype_alpha($text);
}
function validAge($num){
    return is_numeric($num);
}
function validPhone($num){
    return is_numeric($num)&&sizeof($num)>4;
}