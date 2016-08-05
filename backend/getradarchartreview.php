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
    exit;
}



$groupId=$requireData['groupId'];
//$performanceInfoId=$requireData['performanceInfoId'];
$reviewForEmployeeId=$requireData['reviewForEmployeeId'];
$groupType = $requireData['groupType'];



// $groupId=1;

// $reviewForEmployeeId=1;




$userModel = new userModel();



$KPIaverageDataArray=[];
$dataName = "";


$performanceInfoArray=$userModel->getGroupPerformanceId($groupId);

$key = 'performanceinfoid';

$performanceInfoIdArray = array_column($performanceInfoArray, $key);

$numOfPerformanceInfoIdArray = count($performanceInfoIdArray);

$employeeInfo=$userModel->getEmployeeInfo($reviewForEmployeeId);

$firstname = $employeeInfo['firstname'];
$lastname = $employeeInfo['lastname'];
$fullName=$firstname.' '.$lastname;


for($i = 0; $i < $numOfPerformanceInfoIdArray; $i++){
	$currentPerformanceInfoId=$performanceInfoIdArray[$i];
	/*find ALL group TIITL And Group INFOMATION*/
	

    $TempReviewDataArray=$userModel->getALLReviewForTargetEmployee($currentPerformanceInfoId,$reviewForEmployeeId);
    
	
   	//var_dump($TempReviewDataArray);


    if(is_null($TempReviewDataArray)){

    	$averageDataArray=$userModel->getPerformanceInfo($currentPerformanceInfoId);

    	$averageDataArray['averageData']=0;

    	array_push($KPIaverageDataArray, $averageDataArray);


    }else{

		$averageDataArray=$userModel->getPerformanceInfo($currentPerformanceInfoId);
		

		$dataName = "reviewdata";
		$average=$userModel->calculateAverage($TempReviewDataArray,$dataName);


		$averageDataArray['averageData']=$average;

    	array_push($KPIaverageDataArray, $averageDataArray);


    }
   
    
}



$FinalKPIDataArray = array(
	"state" => "true",
	"groupId"=> $groupId,
	"fullName"=>$fullName,
	"data"	=> $KPIaverageDataArray
 );


$FinalKPIDataJSON=json_encode($FinalKPIDataArray); 


echo $FinalKPIDataJSON;






