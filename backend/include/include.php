<?php

/* 
 * author:GongZheng
 */
define('ROOT',str_replace('include/include.php','',str_replace('\\','/',__FILE__)));

require(ROOT.'include/loginFunctions.php');
require(ROOT.'include/updateProfile.php');
require(ROOT.'include/adminPeerReviewFunc.php');

/*
 * protecting against sql injection attacks
 */

function addslash($arr) {
    foreach($arr as $k=>$v) {
        if(is_array($v)) {
            $arr[$k] = addslash($v);
        } else if(is_string($v)) {
            $arr[$k] = addslashes($v);
        }
    }

    return $arr;
}
if(!get_magic_quotes_gpc()) {
    $_GET = addslash($_GET);
    $_POST = addslash($_POST);
    $_COOKIE = addslash($_COOKIE);
}



//header("Content-Type: application/json");
//header('Access-Control-Allow-Headers: X-Requested-With');
/*
 * for cross-domain access,header should be change
 */

header('Access-Control-Allow-Origin: *');