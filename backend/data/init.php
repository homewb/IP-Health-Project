<?php

error_reporting(0);

/* 
 * create by gongzheng
 */
define('ROOT',str_replace('data/init.php','',str_replace('\\','/',__FILE__)));
require (ROOT.'data/config.php');
require (ROOT.'data/conf.php');
require (ROOT.'data/mysql.php');

function __autoload($class) {
    require(ROOT . 'model/' . $class . '.php');
}
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
session_start();
//$a = mysql::getIns();
//$a->connect();
//$a->select_db();
//$b=$a->getOne('select count(*) from users');
//print_r($b);
