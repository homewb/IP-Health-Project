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


$groupType=$requireData['groupType'];
//$groupType="review";


//$employeeId="4";

$userModel = new userModel();



$goupInfoArray=[];
$data=$userModel->getAllGroupInfo();


//var_dump($goupInfoArray);
$numOfgoupInfoArray = count($data);

for ($i=0; $i <$numOfgoupInfoArray ; $i++) { 
	if($data[$i]['grouptype'] == $groupType){

		array_push($goupInfoArray,$data[$i]);

	}


}






$FinalGroupInfoArray = array(
	"state" => "true",
	"data"	=> $goupInfoArray
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



