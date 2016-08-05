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

$info="all";
//{require:all}
//$employeeId="4";

$userModel = new userModel();



$employeeInfoArray=array(
	"state" => "TURE"
	);

$allEmployeeArray=[];

if($info=="all"){

	$employeeInfo=$userModel->getAllEmployeeInfo();

	$numbersOfEmployeeInfo=count($employeeInfo);

	for ($i=0; $i <$numbersOfEmployeeInfo ; $i++) { 
		
		$currentEmployeeId=$employeeInfo[$i]['empid'];

		
		$employeeLogininfoarray=$userModel->getEmployeeLoginInfo($currentEmployeeId);
		$currentEmployeeEmail=$employeeLogininfoarray['emailaddress'];
		$currentPermission=$employeeLogininfoarray['permission'];
		$employeeInfo[$i]['email']=$currentEmployeeEmail;
		$employeeInfo[$i]['permission']=$currentPermission;

	}




	$employeeInfoArray['Data']=$employeeInfo;
	$returnJSON=json_encode($employeeInfoArray);

}else{
	$employeeInfoArray['state']="FALSE";
	$returnJSON=json_encode($employeeInfoArray);
}
echo $returnJSON;





