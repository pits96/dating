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

    $valid=true;
    if($_SERVER['REQUEST_METHOD']=='GET') {
        $view = new Template();
        echo $view->render('views/personalinfo.html');
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if($_POST['premium']=='premium'){
            $prem = new PremiumMember();
        }
        else{
            $mem = new Member();
        }
        if(empty($_POST['fname'])||!$GLOBALS['validation']->validName($_POST['fname'])){
            $f3->set('errorname','Invalid first name.');
            $valid=false;
        }
        else{
            if(isset($prem)) {
                $prem->setFname($_POST['fname']);
            }
            else{
                $mem->setFname($_POST['fname']);
            }
        }
        if(empty($_POST['lname'])||!$GLOBALS['validation']->validName($_POST['lname'])){
            $f3->set('errorLname',"Invalid last name.");
            $valid=false;
        }
        else{
            if(isset($prem)) {
                $prem->setLname($_POST['lname']);
            }
            else{
                $mem->setLname($_POST['lname']);
            }
        }

        if(empty($_POST['age'])||!$GLOBALS['validation']->validAge($_POST['age'])){
            $f3->set('errorAge',"Please enter a valid age.");
            $valid=false;
        }
        else {
            if(isset($prem)) {
                $prem->setAge($_POST['age']);
            }
            else{
                $mem->setAge($_POST['age']);
            }
        }
    if($_POST['gender']=='male'){
        if(isset($prem)) {
            $prem->setGender('Male');
        }
        else{
            $mem->setGender('Male');
        }
    }
    else if($_POST['gender']=='female'){
        if(isset($prem)) {
            $prem->setGender($_POST['Female']);
        }
        else{
            $mem->setGender($_POST['Female']);
        }
    }
    if(empty($_POST['phonenum'])||!$GLOBALS['validation']->validPhone($_POST['phonenum'])){
        $f3->set('errorPhone',"Phone number must be numbers and must be greater than 4 digits.");
        $valid=false;
    }
    else {
        if(isset($prem)) {
            $prem->setPhone($_POST['phonenum']);
        }
        else{
            $mem->setPhone($_POST['phonenum']);
        }
    }
        if(isset($prem)) {
            $_SESSION['premium']=$prem;
        }
        else{
            $_SESSION['member']=$mem;
        }
        $view = new Template();
        echo $view->render('views/personalinfo.html');
    if($valid) {
        $f3->reroute('profile');
    }
    }
});
$f3->route('GET|POST /profile',function($f3){
    if($_SERVER['REQUEST_METHOD']=='GET') {
        if(isset($_SESSION['premium'])){
            var_dump($_SESSION['premium']);
        }
        else{
            var_dump($_SESSION['member']);
        }
        $f3->set('states', array("Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware"
        , "Florida", "Georgia", "Hawaii", "Idaho", "Illinois", "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland", "Massachusetts", "Michigan", "Minnesota"
        , "Mississippi", "Missouri", "Montana", "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York", "North Carolina", "North Dakota", "Ohio",
            "Oklahoma", "Oregon", "Pennsylvania", "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah", "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsins", "Wyoming"));
        $view = new Template();
        echo $view->render('views/profile.html');
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $valid=true;
        if(empty($_POST['email'])||!$GLOBALS['validation']->validEmail($_POST['email'])){
            $f3->set('errorEmail',"Email must contain '@' and '.com'");
            $valid=false;
        }
        else {
            if(isset($_SESSION['premium'])){
                $_SESSION['premium']->setEmail($_POST['email']);
            }
            else{
                $_SESSION['member']->setEmail($_POST['email']);
            }
        }
        if(isset($_SESSION['premium'])){
            $_SESSION['premium']->setState($_POST['state']);
        }
        else{
            $_SESSION['member']->setState($_POST['state']);
        }
        if($_POST['seek']=='male'){
            if(isset($_SESSION['premium'])){
                $_SESSION['premium']->setSeeking('Male');
            }
            else{
                $_SESSION['member']->setSeeking('Male');
            }
        }
        else if($_POST['seek']=='female'){
            if(isset($_SESSION['premium'])){
                $_SESSION['premium']->setSeeking('Female');
            }
            else{
                $_SESSION['member']->setSeeking('Female');
            }
        }
        if(isset($_SESSION['premium'])){
            $_SESSION['premium']->setBio($_POST['bio']);
        }
        else{
            $_SESSION['member']->setBio($_POST['bio']);
            }
        $view = new Template();
        echo $view->render('views/profile.html');
        if($valid&&isset($_SESSION['premium'])) {
            $f3->reroute('interests');
        }
        else if($valid){
            $f3->reroute('summary');
        }
    }
});
$f3->route('GET|POST /interests',function($f3){
    var_dump($_SESSION['premium']);
    //I cut the arrays into 4 arrays for formatting purposes
    $f3->set('indoor1',array("tv","puzzles","movies","reading"));
    $f3->set('indoor2',array("cooking","playing cards","board games","video games"));
    $f3->set('outdoor1',array("hiking","climbing","swimming","collecting"));
    $f3->set('outdoor2',array("walking","biking"));
    $f3->set('indoor',array("tv","puzzles","movies","reading","cooking","playing cards","board games","video games"));
    $f3->set('outdoor',array("hiking","climbing","swimming","collecting","walking","biking"));
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $valid = true;
        if(!$GLOBALS['validation']->validInterest($_POST['indoor'],$f3->get('indoor'))){
            $f3->set('errorInInterest',"No spoofing please :)");
            $valid=false;
        }
        else {
            if(!isset($_POST['indoor'])) {
                $_SESSION['premium']->setIndoorInterests("");
            }
            else{
                foreach ($_POST['indoor'] as $indoor) {
                    $_SESSION['premium']->setIndoorInterests($_SESSION['premium']->getIndoorInterests().$indoor.", ");

                }
            }
        }
        if(!$GLOBALS['validation']->validInterest($_POST['outdoor'],$f3->get('outdoor'))){
            $f3->set('errorOutInterest',"No spoofing please :)");
            $valid=false;
        }
        else {
            if(empty($_POST['outdoor'])) {
                $_SESSION['premium']->setOutdoorInterests("");

            }
            else{
                foreach ($_POST['outdoor'] as $outdoor) {
                    $_SESSION['premium']->setOutdoorInterests($_SESSION['premium']->getOutdoorInterests().$outdoor.", ");
                }
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
    var_dump($_SESSION['premium']);
    $view = new Template();
    echo $view->render('views/summary.html');
    session_destroy();
});
$f3->run();
