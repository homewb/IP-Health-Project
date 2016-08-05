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

$info=$requireData['require'];


//{require:all}
//$employeeId="4";

$userModel = new userModel();

$groupId=$requireData['groupid'];

$groupType=$requireData['type'];

//$groupId=11;
// $groupId=$requireData['groupId'];
// $performanceInfoId=$requireData['performanceInfoId'];
// $reviewForEmployeeId=$requireData['reviewForEmployeeId'];


//$groupId=5;



$groupInfoarray=$userModel->getGroupInfo($groupId);

	if ($groupInfoarray!=null) {
		# code...

	$employeeInGroupDataArray=[];

	$employeeInGroupArray=$userModel->getAllEmployeeIdInGroup($groupId);
	//var_dump($employeeInGroupArray);
	$key = 'empid';

	$empIdArray = array_column($employeeInGroupArray, $key);


	$numOfempIdArray = count($empIdArray);
	for ($i=0; $i < $numOfempIdArray; $i++) { 
		$currentId=$empIdArray[$i];
		$employeeInfoArray=$userModel->getEmployeeInfo($currentId);

		array_push($employeeInGroupDataArray, $employeeInfoArray);

	}



	$KPIArray=$userModel->getGroupPerformanceId($groupId);

	$numOfKPIarray=count($KPIArray);

	$key = 'performanceinfoid';

	$KPIIdArray = array_column($KPIArray, $key);

	$KPIinfoArray=[];

	for ($k=0; $k < $numOfKPIarray; $k++) { 
		$currentKPIId=$KPIIdArray[$k];

		$tempinfoArray=$userModel->getPerformanceInfo($currentKPIId);

		array_push($KPIinfoArray, $tempinfoArray);

	}
	//getPerformanceInfo






	$returnArray=array(
	"state" => "TURE",
	"employeeData"=>$employeeInGroupDataArray,
	"KPIData"=>$KPIinfoArray,
	"groupinfoData"=>$groupInfoarray

	);






	$returnJSON=json_encode($returnArray);
	echo $returnJSON;



}
else{


	$returnArray=array(
	"state" => "FALSE",
	"Error"=>"Group Not exist!!"
	);



	$returnJSON=json_encode($returnArray);
	echo $returnJSON;
}










