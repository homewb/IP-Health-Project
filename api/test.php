<?php

require('./include/include.php');

$update = updateProfile::getIns();

//$url='http://localhost:3000/api/Userlogs';
//
//$data = array();
//
//$data['\"email\"']='\"woshinibaba@126.com\"';
//$data['\"passsword\"']='\"good\"';  
//
//$res = $update->postData($url,$data);
//
//
//
//var_dump($res);

//$url  = "http://localhost:3000/api/Userlogs";  

$url ='http://localhost:3000/api/Userinfos/update?[where][userId]=100';
$data = array();

//$data['email']='woshinibaba@126.com';
//$data['password']='good';
//$data['permission']='A';
$data['firstname']='woshinibaba3';
$data['lastname']='baba2';


$d = json_encode($data);   
//echo $d;
//return;

$res =$update->http_post_data($url, $d); 

print_r($res);