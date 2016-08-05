<?php

/* 
 * author:GongZheng
 */

//require POST data "username, password"

require('./include/include.php');

$data =  json_decode(file_get_contents('php://input'),TRUE);

$email = $data['username'];
$password = $data['password'];

$loginTool = loginFunction::getIns();

$url = $loginTool->userLoginAPI($email);

$userData = $loginTool->getArray($url);

$returnData = array();

if($userData==NULL){
	$returnData['state']=FALSE;

    echo json_encode($returnData);
    exit();
}

if($loginTool->checkUser($userData,$email,$password)==FALSE){
    $returnData['state']=FALSE;
    echo json_encode($returnData);
    exit();
}

$empid= $userData['empid'];

$url = $loginTool->userInfoAPI($empid);

$userInfo = $loginTool->getArray($url);



if($userInfo['firstname']==''){
    $returnData['username'] = 'staff';   
}  else {
    $returnData['username']=$userInfo['firstname'];
}


$returnData['state']=TRUE;
$returnData['id']=$empid;
$returnData['email']=$userData['emailaddress'];
$returnData['permission']=$userData['permission'];
$returnData['photo']=$userInfo['photo'];

//$returnData['photo']=$userData['photo'];

//$loginTool->writeLoginLog($empid);


$returnJson = json_encode($returnData);

echo $returnJson;
