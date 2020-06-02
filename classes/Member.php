<?php
class Member
{
    private $_fname;
    private $_lname;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    function __construct($fname,$lname,$age,$gender)
    {
        $this->setFname($fname);
        $this->setLname($lname);
        $this->setAge($age);
        $this->setGender($gender);
    }
    public function setFname($fname){
        $this->_fname=$fname;
    }
    function getFname(){
        return $this->_fname;
    }
    public function setLname($lname){
        $this->_lname=$lname;
    }
    function getLname(){
        return $this->_lname;
    }
    public function setAge($age){
        $this->_age=$age;
    }
    function getAge(){
        return $this->_age;
    }
    public function setGender($gender){
        $this->_gender=$gender;
    }
    function getGender(){
        return $this->_gender;
    }
    public function setPhone($phone){
        $this->_phone=$phone;
    }
    function getPhone(){
        return $this->_phone;
    }
    public function setEmail($email){
        $this->_email=$email;
    }
    function getEmail(){
        return $this->_email;
    }
    public function setState($state){
        $this->_state=$state;
    }
    function getState(){
        return $this->_state;
    }
    public function setSeeking($seeking){
        $this->_seeking=$seeking;
    }
    function getSeeking(){
        return $this->_seeking;
    }
    public function setBio($bio){
        $this->_bio=$bio;
    }
    function getBio(){
        return $this->_bio;
    }
}