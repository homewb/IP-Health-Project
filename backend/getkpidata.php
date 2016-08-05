<?php
require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"); 


/* GET EMPLOYEE GROUPS THE EMPLOYEE ID ARE REQUIRED

$requireDate = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST)){
    return 'error';
    exit;
}

$groupid=requireDate['groupid'];
*/




//$KPIID="1";

$userModel = new userModel();



//$KPIDataArray=[];
//$groudIdArray=$userModel->getGroupID($employeeId);

$searchKPIDataArray=$userModel->getReviewPerformanceKPIData($KPIID);


/*
$key = 'performanceinfoid';
$KPIDataArray = array_column($Data, $key);
$numOfKPIDataArray = count($KPIDataArray);



for($i = 0; $i < $numOfKPIDataArray; $i++){
	$currentKPIId=$KPIIdArray[$i];

	*/

	/*find ALL group TIITL And Group INFOMATION*/
 /*   $TempPerformanceinfosArray=$userModel->getPerformanceInfo($currentKPIId);
    array_push($KPIInfoArray, $TempPerformanceinfosArray);
    
}
*/
$FinalKPIDataArray = array(
	"statu" => "true",
	"data"	=> $searchKPIDataArray,
 );
$FinalKPIDATAJSON=json_encode($FinalKPIDataArray); 


echo $FinalKPIDATAJSON;

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



