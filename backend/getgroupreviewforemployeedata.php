<?php
error_reporting(0);

require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");  


/* GET EMPLOYEE GROUPS THE EMPLOYEE ID ARE REQUIRED
*/


$requireData = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST)){
    return 'error';
    
	// $errorMessageArray = array("state" => "true" );
 //    $error_JSON=json_encode($errorMessageArray);

 //    echo $error_JSON;
    exit;
}



$groupId=$requireData['groupId'];
$performanceInfoId=$requireData['performanceInfoId'];
$reviewForEmployeeId=$requireData['reviewForEmployeeId'];

// echo "$groupId";
// echo "$performanceInfoId";
// echo "$userEmployeeId";

// $groupId=6;
// $performanceInfoId=14;
// $reviewForEmployeeId=1;




$userModel = new userModel();





$employeeInGroupDataArray=[];

$employeeInGroupArray=$userModel->getAllEmployeeIdInGroup($groupId);
//var_dump($employeeInGroupArray);
$key = 'empid';

$empIdArray = array_column($employeeInGroupArray, $key);






$numOfempIdArray = count($empIdArray);



for($i = 0; $i < $numOfempIdArray; $i++){
	$groupEmpId=$empIdArray[$i];
	
	/*find ALL group TIITL And Group INFOMATION*/
	/*
	'http://localhost:3000/api/Reviewdata/findOne?filter[where][performanceinfoid]='.$performanceInfoId.
	'&filter[where][empId]='.$userEmployeeId.'&filter[where][reviewforempid]='.$forEmployeeId
*/
    $TempReviewDataArray=$userModel->getReviewData($performanceInfoId,$groupEmpId,$reviewForEmployeeId);
   

  // var_dump($TempReviewDataArray);
    if(is_null($TempReviewDataArray)){

    	$TempReviewDataArray=$userModel->setEmptyReviewForEmployeeArray($performanceInfoId,$groupEmpId,$reviewForEmployeeId);
    	
    	array_push($employeeInGroupDataArray, $TempReviewDataArray);


    }else{
    	//echo "$groupEmpId\n\n\n\n";
    	$employeeInfo=$userModel->getEmployeeInfo($groupEmpId);
    	
    	$firstname = $employeeInfo['firstname'];
      	$lastname = $employeeInfo['lastname'];
      	$fullName=$firstname.' '.$lastname;
    	// $userName = array(
    	// "firstname" => $firstname,
     //    "lastname" => $lastname
     //    );

//      	echo $TempReviewDataArray['empid'];
      	

      	$TempReviewDataArray['fullname']=$fullName;
		$TempReviewDataArray['firstname']=$firstname;
		$TempReviewDataArray['lastname']=$lastname;
		//array_push($TempReviewDataArray,$TempReviewDataArray['firstname']=$firstname);

		//	var_dump($TempReviewDataArray);
       //  array_push($TempReviewDataArray, $userName);
    	 array_push($employeeInGroupDataArray, $TempReviewDataArray);
    	
    }
   
    
}

$FinalKPIDataArray = array(
	"state" => "true",
	"groupId"=> $groupId,
	"performanceInfoId"=>$performanceInfoId,
	"reviewForEmployeeId"=> $reviewForEmployeeId,
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



