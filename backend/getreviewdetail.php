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
$performanceInfoId=$requireData['performanceInfoId'];
$userEmployeeId=$requireData['employeeId'];

// echo "$groupId";
// echo "$performanceInfoId";
// echo "$userEmployeeId";

// $groupId=1;
// $performanceInfoId=1;
// $userEmployeeId=1;




$userModel = new userModel();





$employeeInGroupDataArray=[];

$employeeInGroupArray=$userModel->getAllEmployeeIdInGroup($groupId);

$key = 'empid';

$empIdArray = array_column($employeeInGroupArray, $key);





$numOfempIdArray = count($empIdArray);



for($i = 0; $i < $numOfempIdArray; $i++){
	$currentForEmpId=$empIdArray[$i];
	/*find ALL group TIITL And Group INFOMATION*/
	

    $TempReviewDataArray=$userModel->getReviewData($performanceInfoId,$userEmployeeId,$currentForEmpId);
    
    if(is_null($TempReviewDataArray)){

    	$TempReviewDataArray=$userModel->setEmptyReviewArray($performanceInfoId,$userEmployeeId,$currentForEmpId);
    	
    	array_push($employeeInGroupDataArray, $TempReviewDataArray);


    }else{

    	$employeeInfo=$userModel->getEmployeeInfo($currentForEmpId);

    	$firstname = $employeeInfo['firstname'];
      	$lastname = $employeeInfo['lastname'];

    	// $userName = array(
    	// "firstname" => $firstname,
     //    "lastname" => $lastname
     //    );

		$TempReviewDataArray['firstname']=$firstname;
		$TempReviewDataArray['lastname']=$lastname;
		
       //  array_push($TempReviewDataArray, $userName);
    	 array_push($employeeInGroupDataArray, $TempReviewDataArray);
    }
   
    
}

$FinalKPIDataArray = array(
	"state" => "true",
	"groupId"=> $groupId,
	"performanceInfoId"=>$performanceInfoId,
	"data"	=> $employeeInGroupDataArray
 );


$FinalKPIDataJSON=json_encode($FinalKPIDataArray); 


echo $FinalKPIDataJSON;






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



