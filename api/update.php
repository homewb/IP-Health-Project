<?php

/* 
 * author:GongZheng
 */

//require POST data "id,firstname,lastname etc"

require('./include/include.php');

$data =  json_decode(file_get_contents('php://input'),TRUE);


$update = updateProfile::getIns();

$id=$data['id'];

//$id=12;




$url ='http://localhost:3001/api/Employees/update?[where][empid]='.$id;

//unset($data['userid']);

//$postData['empid']=$data['id'];

$postData["firstname"]=$data['firstname'];
$postData["lastname"]=$data['lastname'];
$postData["birthday"]=$data['birthday'];
$postData["address"]=$data['address'];
$postData["mobile"]=$data['mobile'];
$postData["phone"]=$data['phone'];



// $postData["firstname"]="New";
// $postData["lastname"]="55555";

// $postData["address"]="mytest";
// $postData["mobile"]="0373651263";
// $postData["phone"]="343242322";




$postData = json_encode($postData);


$res =$update->httpPostData($url,$postData); 

if($res==TRUE){
    echo 'TRUE';
}else{
    echo 'FALSE';
}

