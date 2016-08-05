<?php
require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"); 


/* GET EMPLOYEE GROUPS THE EMPLOYEE ID ARE REQUIRED


*/


$requireData = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST)){
    return 'error';
    exit;
}

$groupid=$requireData['groupid'];





//$groupid="1";

$userModel = new userModel();



$KPIInfoArray=[];
//$groudIdArray=$userModel->getGroupID($employeeId);

$searchKPIArray=$userModel->getGroupPerformanceId($groupid);
$key = 'performanceinfoid';
$KPIIdArray = array_column($searchKPIArray, $key);
$numOfgroupIdArray = count($KPIIdArray);



for($i = 0; $i < $numOfgroupIdArray; $i++){
	$currentKPIId=$KPIIdArray[$i];
	/*find ALL group TIITL And Group INFOMATION*/
    $TempPerformanceinfosArray=$userModel->getPerformanceInfo($currentKPIId);
    array_push($KPIInfoArray, $TempPerformanceinfosArray);
    
}

$FinalKPIArray = array(
	"state" => "true",
	"data"	=> $KPIInfoArray,
 );
$FinalKPIJSON=json_encode($FinalKPIArray); 


echo $FinalKPIJSON;

/*

JSON Format:
GROUP JSON:

{
	"state": true,
	"Data": [{
		groupid : 1,
		grouptittle : Go
	},
	{
		groupid : 2,
		grouptittle : TO

	}
	],
	
}

KPI JSON:

{
	"state": "true",
	"Data": [{
		"KPIID" : "1",
		"KPItittle" : "Go",
		"KPIstatu": "true",
		KPIDATA:[{}]
	},
	{
		"KPIID" : 2,
		"KPItittle" : To,
		"KPIstatu" : fale,
		"KPIDATA":[{
			"Name": "zhang",
			"Rate" : 3,
			"comment" : "The Good Guy",
			"statu" : "accept"
		}]

	}
	],
	
}





*/



