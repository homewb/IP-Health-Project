<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//require('./data/init.php');

//$email =  'gzcisco720@gmail.com';
//$password = 'gongzheng';
//
//
//$pwd = md5($password);
//$userModel = new userModel();
//
//$pwd = md5($password);
//
//$username = $userModel->getName($email);
$mail = 'gzcisco720@gmail_com.cn';

$num = strripos($mail, '@');
$mailHead = substr($mail,0,$num);
$a = str_replace('_', '.', substr($mail,$num));
$mailHead.=$a;
echo $mailHead;

//echo '</br>';
//if(isset($user)){
//    $user['state']=FALSE;
//    var_dump($user);
//}else{
//    $username = $userModel->getName($email);
//    $user['state']= TRUE;
//    $user['user'] = $username;
//    $user['email']= $email;
//    $_SESSION['user'] = $username;
//    $_SESSION['email'] = $email;
//    echo json_encode($user);
//}