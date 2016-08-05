<?php
require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"); 


/* GET review

$requireDate = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST)){
    return 'error';
    exit;
}

$employeeId=requireDate['employeeId'];

$groupid=requireDate['groupid'];
$KPIID=requireDate['KPIID'];

*/







$groupid="1";
$KPIID="1";

$today=date('Y-m-d');

$insertJSON="";
 
$insertArray = array(
        "performancerecordtime" => $today,
        "performancedatastatu" => "pending",
        "performancedata" => "38",
        "performancecomment" => null,
        "performanceinfoid" => $KPIID,
        "empid" => 1
        );


$PUTArray = array(
		"performancedataid" => 514,
        "performancerecordtime" => $today,
        "performancedatastatu" => "pending",
        "performancedata" => 38,
        "performancecomment" => null,
        "performanceinfoid" => $KPIID,
        "empid" => 1
        );

$employeeInGroupDataArray=[];




$userModel = new userModel();

/*
//API Url
//$url = 'http://localhost:3000/api/performancedata';
 
//Initiate cURL.
//$ch = curl_init($url);


//$jsonDataEncoded = json_encode($insertArray);
 
//Tell cURL that we want to send a POST request.
//curl_setopt($ch, CURLOPT_POST, 1);
 
//Attach our encoded JSON string to the POST fields.
//curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
//Set the content type to application/json
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
 
//Execute the request
//$result = curl_exec($ch);

//echo $result;
*/



/* PUT */

/*
$url = 'http://localhost:3000/api/performancedata';
 
//Initiate cURL.
$ch = curl_init($url);


$jsonDataEncoded = json_encode($PUTArray);
 
//Tell cURL that we want to send a PUT request.
//url_setopt($ch, CURLOPT_PUT, 1);
 
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
 
//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
//Execute the request
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // note the PUT here
curl_setopt($ch, CURLOPT_HEADER, true);

$result = curl_exec($ch);


echo $result;

*/





/*
$employeeInGroupArray=$userModel->getAllEmployeeIdInGroup($groupid);

$key = 'empid';

$empIdArray = array_column($employeeInGroupArray, $key);
$numOfempIdArray = count($empIdArray);


for($i = 0; $i < $numOfempIdArray; $i++){
	$currentEmpId=$empIdArray[$i];
    $TempKPIINFOArray=$userModel->getEmployeePerformanceDataINGroup($currentEmpId);
    
    if(is_null($TempKPIINFOArray)){
    	$TempKPIINFOArray=$userModel->setEmptyPerformanceArray($currentEmpId,$KPIID);
    	 array_push($employeeInGroupDataArray, $TempKPIINFOArray);
    }else{
    	 array_push($employeeInGroupDataArray, $TempKPIINFOArray);
    }
   
    
}
*/
/*
$FinalKPIDataArray = array(
	"statu" => "true",
	"groupid"=> $groupid,
	"KPIID"=>$KPIID,
	"data"	=> $employeeInGroupDataArray
 );
$FinalKPIDataJSON=json_encode($FinalKPIDataArray); 


echo $FinalKPIDataJSON;
*/
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



