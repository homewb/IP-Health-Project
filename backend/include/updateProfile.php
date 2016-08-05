<?php

/* 
 * author:GongZheng
 */

class updateProfile{
    
    protected static $ins=null;
    
    public static function getIns(){
        if(self::$ins==null){
            self::$ins = new self();
        }
        return self::$ins;
    }
    
    final protected function __construct() {
        
    }
    
//using curl to post data to API
    
   public function httpPostData($url, $data) {  
  
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_POST, 1);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
            'Content-Type: application/json',  
            'Content-Length: ' . strlen($data))  
        ); 
        $curl_result=curl_exec($ch);
        curl_close($ch);
        return $curl_result;

    }  
        
    
    
}
