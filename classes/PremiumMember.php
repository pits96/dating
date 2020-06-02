<?php
class PremiumMember extends Member
{
    private $_inDoorInterests;
    private $_outDoorInterests;
    function setIndoorInterests($array){
        $this->_inDoorInterests=$array;
    }
    function getIndoorInterests(){
        return $this->_inDoorInterests;
    }
    function setoutDoorInterests($array){
        $this->_outDoorInterests=$array;
    }
    function getoutDoorInterests(){
        return $this->_outDoorInterests;
    }
}