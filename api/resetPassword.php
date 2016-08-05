<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require('./data/init.php');

$dcode = array();
$dcode = explode('.', base64_decode($_GET['p']));

$email = trim($dcode[0]);
$code = trim($dcode[1]);


$userModel = new userModel();

$password = $userModel->getResetInfo($email);

$checkCode = md5($email.'+'.$password);

if($checkCode==$code){
   include(''); 
}else{
   include('');
}
