<?php

/* 
 * create by gongzheng
 */

require('./data/init.php');
//$email = trim($_SESSION['username']);
//$firstname = trim($_POST['firstname']);
//$lastname = trim($_POST['lastname']);
//$birth = trim($_POST['birth']);
//$street = trim($_POST['street']);
//$city = trim($_POST['city']);
//$state = trim($_POST['state']);
//$post = trim($_POST['post']);
//$phone1 = trim($_POST['phone1']);
//$phone2 = trim($_POST['phone2']);

$userDetail = array();

if(!isset($_POST)){
    return 'error';
    exit;
}

foreach ($_POST as $key => $value) {
    $userDetail=json_decode($key,true);
}
$email = trim($userDetail['username']);

$num = strripos($email, '@');
$mailHead = substr($email,0,$num);
$mailEnd = str_replace('_', '.', substr($email,$num));
$mailHead.=$mailEnd;

$firstname = trim($userDetail['firstname']);
$lastname = trim($userDetail['lastname']);
$birth = trim($userDetail['dob']);
$street = trim($userDetail['street']);
$city = trim($userDetail['city']);
$state = trim($userDetail['state']);
$post = trim($userDetail['post']);
$phone1 = trim($userDetail['mobile']);
$phone2 = trim($userDetail['phone']);

$userInfo = new userInfo();

if($userInfo->update($mailHead, $firstname, $lastname, $birth, $street, $city, $state, $post, $phone1, $phone2)){
    echo 'true';
}else{
    echo 'false';
}