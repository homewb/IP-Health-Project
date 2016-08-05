<?php

/* 
 * author:GongZheng
 */

class loginFunction{

    protected static $ins=null;
    
    public static function getIns(){
        if(self::$ins==null){
            self::$ins = new self();
        }
        return self::$ins;
    }
    
    final protected function __construct() {
        
    }
    
    /*
     * not only login infomation is required but also user firstname
     * the dashboard should show the user firstname
     */
    
    public function userLoginAPI($v){       
        $filter = "?filter[where][emailaddress]=$v";
        $url = 'http://localhost:3000/api/Logins/findOne'.$filter;
        return $url;
    }
    public function userInfoAPI($id){
        $filter ="?filter[where][userid]=$id";
        $url = 'http://localhost:3000/api/Userinfos/findOne'.$filter;
        return $url;
    }
    
    /*
     * login function have validation processes on user validity and 
     * information format so the getArray() and checkUser() are needed
     */
    
    public function getArray($url){
        $jsonObject=@file_get_contents($url);
        $array = json_decode($jsonObject,TRUE);
        if(is_array($array)){
            return $array;
        }else{
            return NULL; 
        }   
    }
    
    public function checkUser($array,$email,$password){
       if($email==$array['emailaddress']&&$password==$array['password']){
           return TRUE; 
       }else{
           return FALSE;
       }
    }
    
}