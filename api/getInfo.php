<?php

/* 
 * create by gongzheng
 */

require('./include/include.php');

$data =  json_decode(file_get_contents('php://input'),TRUE);

$loginTool = loginFunction::getIns();

$id = $data['id'];

$url = $loginTool->userInfoAPI($id);

$userInfo = $loginTool->getArray($url);

$returnData = $userInfo;
$returnData['phone2'] = $userInfo['phone'];
$returnData['phone1'] = $userInfo['mobile'];
unset($returnData['phone']);
unset($returnData['mobile']);

echo json_encode($returnData);