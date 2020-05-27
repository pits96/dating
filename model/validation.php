<?php
function validName($text){
    return ctype_alpha($text);
}
function validAge($num){
    return is_numeric($num);
}