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
        $url = 'http://localhost:3001/api/Logins/findOne'.$filter;
        return $url;
    }
    public function userInfoAPI($empid){
       // $filter ="?filter[where][userid]=$empid";

        //$url = 'http://localhost:3000/api/Employees/findOne'.$filter;
        $url = 'http://localhost:3001/api/Employees/'.$empid;
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

    public function writeLoginLog($empid){
        $now = date("Y-m-d H:i:s"); 
        $url = 'http://localhost:3001/api/Loginlogs';

        $ch = curl_init($url);


        $data= array('empid' => $empid,
                        'logintime'=>$now
                         );

      //$jsonDataEncoded = json_encode($insertArray);
       
      //Tell cURL that we want to send a POST request.
      curl_setopt($ch, CURLOPT_POST, 1);
       
      //Attach our encoded JSON string to the POST fields.
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       
      //Set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
       
      //Execute the request
      $curl_result = curl_exec($ch);

        curl_close($ch);
        return $curl_result;
    }

    
    public function checkUser($array,$email,$password){
       if($email==$array['emailaddress']&&$password==$array['password']){
           return TRUE; 
       }else{
           return FALSE;
       }
    }
    
}