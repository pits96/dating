<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

//Require the autoload file
require_once ("vendor/autoload.php");
session_start();
//instantiate the f3 Base class
$f3 = Base::instance();
//$f3->route('GET /test',function(){
//
//    $view = new Template();
//    echo $view->render('views/test.php');
//});
//Default route
$GLOBALS['validation'] = new validation();
$GLOBALS['Controller'] = new controller($f3,$GLOBALS['validation']);
$f3->route('GET /',function(){

    $GLOBALS['Controller']->home();
});
$f3->route('GET|POST /signup',function($f3){
    $GLOBALS['Controller']->signup();
});
$f3->route('GET|POST /profile',function($f3){
    $GLOBALS['Controller']->profile();
});
$f3->route('GET|POST /interests',function($f3){
    $GLOBALS['Controller']->interests();
});
$f3->route('GET /summary',function(){
    $GLOBALS['Controller']->summary();
});
$f3->run();
