<?php
require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"); 


/* 
GET review
*/
$today = date('Y-m-d');
$now = date("Y-m-d H:i:s");  

$newUserDammy=array(
	"emailaddress"=>"new@iphealth1.com",
	"password"=>"21232f297a57a5a743894a0e4a801fc3",
    "firstname"=> "Alex123",
    "lastname"=> "Lim",
    "birthday"=> "1988-11-11",
    "address"=> "dsaf",
    "phone"=> "063663836",
    "mobile"=> "13908750000",
    "department"=> "f8382fh73",
    "jobtittle"=> "hf728923",
    "position"=> "E",
    "photo"=> "img/default.png",			   
	"permission"=> "E",
	"empid"=> 2
  
	);


$dummyJson=json_encode($newUserDammy);


 
//-----------------------------------


$requireData = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST)){
    return 'error';
    exit;
}

$userModel = new userModel();

$requireData =json_decode($dummyJson,true);



$check_flag=0;



$employeeinsertCheck=0;
if(!is_null($requireData)){
	$check_flag++;

}
if ($check_flag!=1) {
	$FinaArray = array(
		"state" => "false",
		"error" =>"info missing"
	);
	$FinaJSON=json_encode($FinaArray);
	echo $FinaJSON;

}
else{

	$employeeInfoArray = array(
		"empid"=>$requireData['empid']
  	);

	
	$employeeUrl=$userModel->assembleInsertUrl("Employees");
	$submitEmployeeUrl=$employeeUrl.'/'.$requireData['empid'];


	$res1=$userModel->DELETEData($submitEmployeeUrl,$employeeInfoArray);
	
	if ($res1==TRUE) {
			echo "TRUE";
		
	}else{
		echo "FALSE";
	}

}

	   










?>