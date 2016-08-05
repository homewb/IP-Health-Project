<?php

/* 
 * create by gongzheng
 */
//require('./data/init.php');
require('./include/PHPMailer/class.phpmailer.php');
require('./include/PHPMailer/class.smtp.php');
//$email = trim($_POST['email']);
$email='215144650@qq.com';

// $userModel = new userModel();

// if(!$userModel->searchUser($email,'')){
//     echo 'user not exists';
//     exit;
// }

// $password = $userModel->getResetInfo($email);


// $x = md5($email.'+'.$password);

// $code = base64_encode($email.'.'.$x);

$mailer = new PHPMailer();

$cont = <<<EMAIL
    Dear User,<br/>
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Your password has been changed, you can click the link below to reset 
        your password.<br/>
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <a href='/resetPassword.php?p='>Reset Password</a>
        <br/>
    Best Regards;<br/>
        IPHealth       
EMAIL;

$mailer->IsSMTP(); 
$mailer->SMTPDebug=2;
$mailer->CharSet = 'UTF-8';
$mailer->ContentType = 'text/html'; 
$mailer->Encoding = 'base64';
$mailer->Host = 'smtp.163.com';
$mailer->SMTPAuth = true;
$mailer->Port = 25; 
$mailer->Username = 'iphealthproject';//e-mail without @xxx.com
$mailer->Password = 'iphealth123';//e-mail login password
$mailer->AddAddress($email);
$mailer->isHTML(true);
$mailer->From = 'iphealthproject@163.com';//e-mail address
$mailer->FromName = 'IPHealth';
$mailer->Subject = 'Password Reset';
$mailer->Body = $cont;
if($mailer->Send()) {
    echo 'send mail successfully';
} else{
    echo 'Error';
}