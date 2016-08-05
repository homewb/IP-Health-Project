<?php

/* 
 * create by gongzheng
 */
require('./data/init.php');
require('./data/PHPMailer/class.phpmailer.php');

$email = $_POST['email'];

$userModel = new userModel();

if(!$userModel->searchUser($email,'')){
    echo 'user not exists';
    exit;
}

$rand = rand(1000000, 9999999);

if(!$userModel->resetPwd($username, $rand)){
    echo 'reset failed';
    exit;
}


$mailer = new PHPMailer();

$cont = <<<EMAIL
    Dear User,
        Your password has been changed, your temporary password is $rand.
        
    Best Regards;
        IPHealth       
EMAIL;
//basic Mailer config
$mailer->CharSet = 'utf-8';
$mailer->ContentType = 'text/html'; 
$mailer->Encoding = 'base64';
//send mail
$mailer->From = '';//e-mail address
$mailer->FromName = 'IPHealth';
$mailer->Subject = 'Password Reset';
$mailer->Body = $cont;
//set SMTP
$mailer->IsSMTP(); 
$mailer->Host = 'smtp.google.com';
$mailer->SMTPAuth = true;
$mailer->Username = '';//e-mail without @xxx.com
$mailer->Password = '';//e-mail login password
$mailer->AddAddress($email,'User');

if($mailer->Send()) {
    echo 'send mail successfully';
} else{
    echo 'Error';
}