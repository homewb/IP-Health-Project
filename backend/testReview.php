<?php

$userEmployeeId=1;
$forEmployeeId=2;
$performanceInfoId=1;

$arrayName = array('name' =>"line" ,'echo'=>33 );

$name = "name";

echo $arrayName["$name"];

/*

$link1 = ('http://localhost:3000/api/Reviewdata?filter={"where":{ "empid":1, "performanceinfoid": 1,"reviewforempid" : 1}}');
$link2 = ('http://localhost:3000/api/Reviewdata?filter={"where":{ "empid":'.$userEmployeeId.', "performanceinfoid": '.$performanceInfoId.',"reviewforempid" : '.$forEmployeeId.'}}');

 $link3 = ('http://localhost:3000/api/Reviewdata?filter[where][empid]='.$userEmployeeId.'?filter[where][performanceinfoid]='.$performanceInfoId);
$new = file_get_contents($link3);
$data = json_decode(file_get_contents($link3), true);






echo $link1;
echo "\n\n\n\n";
echo $link2;
echo "\n\n\n\n";
echo "\n\n\n\n";
echo $new;
var_dump($data);

*/

/*
$ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$link2);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

 
    $output=curl_exec($ch);
 
    curl_close($ch);
    var_dump($output);
*/
?>