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

$groupId=$requireData['groupId'];
//$groupType=$requireData['groupType'];


//$employeeId="4";

$userModel = new userModel();

//$groupId=1;

$employeeInfoArray=[];


$employeeGroupArray=$userModel->getAllEmployeeIdInGroup($groupId);

//var_dump($employeeGroupArray);

$key = 'empid';
$employeeIdArray = array_column($employeeGroupArray, $key);
$numOfEmployeeIdArray = count($employeeIdArray);


for($i = 0; $i < $numOfEmployeeIdArray; $i++){
	$currentEmployee=$employeeIdArray[$i];
	/*find ALL group TIITL And Group INFOMATION*/
    $TempEmployeeInfoArray=$userModel->getEmployeeInfo($currentEmployee);
    
   	array_push($employeeInfoArray, $TempEmployeeInfoArray);
    
   
    
}

$FinalGroupInfoArray = array(
	"state" => "true",
	"data"	=> $employeeInfoArray
 );
$FinalGroupInfoJSON=json_encode($FinalGroupInfoArray); 


echo $FinalGroupInfoJSON;

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
		"empid" : "1",
		"fname" : "Go",
		"lname": "true",
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



