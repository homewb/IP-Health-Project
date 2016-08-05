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

// $newUserDammy=array(
// 	"emailaddress"=>"new@iphealth1.com",
// 	"password"=>"21232f297a57a5a743894a0e4a801fc3",
//     "firstname"=> "Alex123",
//     "lastname"=> "Lim",
//     "birthday"=> "1988-11-11",
//     "address"=> "dsaf",
//     "phone"=> "063663836",
//     "mobile"=> "13908750000",
//     "department"=> "f8382fh73",
//     "jobtittle"=> "hf728923",
//     "position"=> "E",
//     "photo"=> "img/default.png",			   
// 	"permission"=> "A",
// 	"empid"=> 14
  
// 	);


// $dummyJson=json_encode($newUserDammy);


 
//-----------------------------------


$requireData = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST)){
    return 'error';
    exit;
}

$userModel = new userModel();

// $requireData =json_decode($dummyJson,true);



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
		"firstname"=> $requireData['firstname'],
	    "lastname"=> $requireData['lastname'],
	    "birthday"=> $requireData['birthday'],
	    "address"=> $requireData['address'],
	    "phone"=> $requireData['phone'],
	    "mobile"=> $requireData['mobile'],
	    "department"=> $requireData['department'],
	    "jobtittle"=> $requireData['jobtittle'],
	    "position"=> $requireData['position'],
	    "photo"=>$requireData['photo']
  	);


	
	
	$employeeUrl=$userModel->assembleInsertUrl("Employees");
	$submitEmployeeUrl=$employeeUrl.'/'.$requireData['empid'];


	$res1=$userModel->updateData($submitEmployeeUrl,$employeeInfoArray);
	
	if ($res1==TRUE) {



		$loginInfoArray=array(
					
				    "emailaddress"=> $requireData['emailaddress'],
				    "permission"=> $requireData['password'],
				    "password"=> $requireData['permission'],
				    "photo"=> $requireData['photo']
				    
					);


		$loginId=$userModel->getLoginId($requireData['empid']);

		$url=$userModel->assembleInsertUrl("Logins");
		$submitUrl=$url.'/'.$loginId;
		
		$res2=$userModel->updateData($submitUrl,$loginInfoArray);
		if ($res2==TRUE) {
			echo "TRUE";
		}else{
			echo "FALSE";
		}




	}else{
		echo "FALSE";
	}

}

	   










?>