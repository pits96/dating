<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
session_start();
//Require the autoload file
require_once ("vendor/autoload.php");
require("model/validation.php");
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
    $valid=true;
    if($_SERVER['REQUEST_METHOD']=='GET') {
        $view = new Template();
        echo $view->render('views/personalinfo.html');
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(empty($_POST['fname'])||!validName($_POST['fname'])){
            $f3->set('errorname','Invalid first name.');
            $valid=false;
        }
        else{
            $_SESSION['fname'] = $_POST['fname'];
        }
        if(empty($_POST['lname'])||!validName($_POST['lname'])){
            $f3->set('errorLname',"Invalid last name.");
            $valid=false;
        }
        else{
            $_SESSION['lname'] = $_POST['lname'];
        }

        if(empty($_POST['age'])||!validAge($_POST['age'])){
            $f3->set('errorAge',"Please enter a valid age.");
            $valid=false;
        }
        else {
            $_SESSION['age'] = $_POST['age'];
        }
    if($_POST['gender']=='male'){
        $_SESSION['gender']="Male";
    }
    else if($_POST['gender']=='female'){
        $_SESSION['gender']="Female";
    }
    if(empty($_POST['phonenum'])||!validPhone($_POST['phonenum'])){
        $f3->set('errorPhone',"Phone number must be numbers and must be greater than 4 digits.");
        $valid=false;
    }
    $_SESSION['phonenum']=$_POST['phonenum'];
        $view = new Template();
        echo $view->render('views/personalinfo.html');
    if($valid) {
        $f3->reroute('profile');
    }
    }
});
$f3->route('GET|POST /profile',function($f3){
    if($_SERVER['REQUEST_METHOD']=='GET') {
        $f3->set('states', array("Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware"
        , "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota"
        , "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio",
            "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsins", "Wyoming"));
        $view = new Template();
        echo $view->render('views/profile.html');
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $valid=true;
        if(empty($_POST['email'])||!validEmail($_POST['email'])){
            $f3->set('errorEmail',"Email must contain '@' and '.com'");
            $valid=false;
        }
        else {
            $_SESSION['email'] = $_POST['email'];
        }
        $_SESSION['state']=$_POST['state'];
        if($_POST['seek']=='male'){
            $_SESSION['seeking']="Male";
        }
        else if($_POST['seek']=='female'){
            $_SESSION['seeking']="Female";
        }
        $_SESSION['bio']=$_POST['bio'];
        $view = new Template();
        echo $view->render('views/profile.html');
        if($valid) {
            $f3->reroute('interests');
        }
    }
});
$f3->route('GET|POST /interests',function($f3){
    //I cut the arrays into 4 arrays for formatting purposes
    $f3->set('indoor1',array("tv","puzzles","movies","reading"));
    $f3->set('indoor2',array("cooking","playing cards","board games","video games"));
    $f3->set('outdoor1',array("hiking","climbing","swimming","collecting"));
    $f3->set('outdoor2',array("walking","biking"));
    $f3->set('indoor',array("tv","puzzles","movies","reading","cooking","playing cards","board games","video games"));
    $f3->set('outdoor',array("hiking","climbing","swimming","collecting","walking","biking"));
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $valid = true;
        if(!validInterest($_POST['indoor'],$f3->get('indoor'))){
            $f3->set('errorInInterest',"No spoofing please :)");
            $valid=false;
        }
        else {
            $_SESSION['indoor'] = array();
            foreach ($_POST['indoor'] as $indoor) {
                array_push($_SESSION['indoor'], $indoor . ", ");
            }
        }
        if(!validInterest($_POST['outdoor'],$f3->get('outdoor'))){
            $f3->set('errorOutInterest',"No spoofing please :)");
            $valid=false;
        }
        else {
            $_SESSION['outdoor'] = array();
            foreach ($_POST['outdoor'] as $outdoor) {
                array_push($_SESSION['outdoor'], $outdoor . ", ");
            }
        }
        if($valid) {
            $f3->reroute('summary');
        }
    }
    $view = new Template();
    echo $view->render('views/interests.html');
});
$f3->route('GET /summary',function(){

    $view = new Template();
    echo $view->render('views/summary.html');
    session_destroy();
});
$f3->run();
