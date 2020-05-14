<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
session_start();
//Require the autoload file
require_once ("vendor/autoload.php");
//instantiate the f3 Base class
$f3 = Base::instance();
//$f3->route('GET /test',function(){
//
//    $view = new Template();
//    echo $view->render('views/test.php');
//});
//Default route

$f3->route('GET /',function(){

    $view = new Template();
    echo $view->render('views/home.html');
});
$f3->route('GET|POST /signup',function($f3){
    $view = new Template();
    echo $view->render('views/personalinfo.html');
    if($_SERVER['REQUEST_METHOD']=='POST'){
    $_SESSION['fname']=$_POST['fname'];
    $_SESSION['lname']=$_POST['lname'];
    $_SESSION['age']=$_POST['age'];
    if($_POST['gender']=='male'){
        $_SESSION['gender']="Male";
    }
    else if($_POST['gender']=='female'){
        $_SESSION['gender']="Female";
    }
    $_SESSION['phonenum']=$_POST['phonenum'];
    $f3->reroute('profile');
    }
});
$f3->route('GET|POST /profile',function($f3){

    $f3->set('states',array("Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware"
    ,"Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota"
    ,"Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio",
    "Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsins","Wyoming"));
    $view = new Template();
    echo $view->render('views/profile.html');
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $_SESSION['email']=$_POST['email'];
        $_SESSION['state']=$_POST['state'];
        if($_POST['seek']=='male'){
            $_SESSION['seeking']="Male";
        }
        else if($_POST['seek']=='female'){
            $_SESSION['seeking']="Female";
        }
        $_SESSION['bio']=$_POST['bio'];
        $f3->reroute('interests');
    }
});
$f3->route('GET|POST /interests',function($f3){
    //I cut the arrays into 4 arrays for formatting purposes
    $f3->set('indoor1',array("tv","puzzles","movies","reading"));
    $f3->set('indoor2',array("cooking","playing cards","board games","video games"));
    $f3->set('outdoor1',array("hiking","climbing","swimming","collecting"));
    $f3->set('outdoor2',array("walking","biking"));
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $_SESSION['interests']=array();
        //loops through the arrays and checks if it's set, if it is
        // then it pushes the item into the session array.
        foreach ($f3->get('indoor1') as $value) {
            if (isset($_POST["$value"])) {
                array_push($_SESSION['interests'], "$value");
            }
        }
        foreach ($f3->get('indoor2') as $value) {
            if (isset($_POST["$value"])) {
                array_push($_SESSION['interests'], "$value");
            }
        }
        foreach ($f3->get('outdoor1') as $value) {
            if (isset($_POST["$value"])) {
                array_push($_SESSION['interests'], "$value");
            }
        }
        foreach ($f3->get('outdoor2') as $value) {
            if (isset($_POST["$value"])) {
                array_push($_SESSION['interests'], "$value");
            }
        }
        $stringinterest="";
        foreach ($_SESSION['interests'] as $interest){
            $stringinterest.=$interest." ";
        }
        $_SESSION['interestsString']=$stringinterest;
        $f3->reroute('summary');
    }
    $view = new Template();
    echo $view->render('views/interests.html');
});
$f3->route('GET /summary',function(){

    $view = new Template();
    echo $view->render('views/summary.html');
//    session_destroy();
});
$f3->run();
