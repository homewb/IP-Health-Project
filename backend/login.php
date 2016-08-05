<?php
/* 
 * create by gongzheng
 */


require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");  
$userData = array();

$data = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST)){
    return 'error';
    exit;
}


$email = $data['username'];
$password = $data['password'];

/*
foreach ($_POST as $key => $value) {
    $userData=json_decode($key,true);
}
  
$email = $userData['username'];
$password = $userData['password'];
*/



$num = strripos($email, '@');
$mailHead = substr($email,0,$num);
$mailEnd = str_replace('_', '.', substr($email,$num));
$mailHead.=$mailEnd;

// Md5 is unnecessary in web app
// $password = md5($password);

$userModel = new userModel();

$user = $userModel->searchUser($mailHead, $password);

if($user){
    $username = $userModel->getInfo($mailHead);
    $user['state']= TRUE;
    $user['username'] = $username;
    $user['email']= $mailHead;
    $_SESSION['email'] = $email;
    echo json_encode($user);   
}else{   
    $user['state']=FALSE;
    echo json_encode($user);
}
