<?php
require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');  


/* GET review
*/
$today = date('Y-m-d');
$now = date("Y-m-d H:i:s");  


$requireData = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST)){
    return 'error';
    exit;
}



$userModel = new userModel();

$groupid=$requireData['groupid'];

//$groupid=14;


$res =$userModel->deleteGroup($groupid); 

if($res==TRUE){
    echo 'TRUE';
}else{
    echo 'FALSE';
}










































?>