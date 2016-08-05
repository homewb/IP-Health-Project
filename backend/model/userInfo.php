<?php

/* 
 * create by gongzheng
 */
class userInfo{
    public $database=null;
    
    public function __construct() {
        $this->database=mysql::getIns();
    }
    
    public function update($email,$firstname,$lastname,$birth,$street,$city,$state,$post,$phone1,$phone2){
           $address = array();
	   $address[]=$street;
	   $address[]=$city;
	   $address[]=$state;
	   $address[]=$post;
	   $fullAdd = implode(',', $address);
     $dob = strtotime($birth);
       $sql="update userInfo set ";
       $sql .="firstname='$firstname',lastname='$lastname',birthday='$birth',address='$fullAdd',phone1='$phone1',phone2='$phone2' ";
       $sql .="where userId = (select id from users where email='$email')";
       return $this->database->query($sql);
    }

}
