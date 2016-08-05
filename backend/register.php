<?php
require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"); 


/* GET review
*/
$today = date('Y-m-d');
$now = date("Y-m-d H:i:s");  

// $newUserDammy=array(
// 	"emailaddress"=>"new@iphealth.com",
// 	"password"=>"21232f297a57a5a743894a0e4a801fc3",
//     "firstname"=> "Alex",
//     "lastname"=> "Lim",
//     "birthday"=> "1988-11-11",
//     "address"=> "dsaf",
//     "phone"=> "063663836",
//     "mobile"=> "13908750000",
//     "department"=> "f8382fh73",
//     "jobtittle"=> "hf728923",
//     "position"=> "E"
  
// 	);



// $dummyJson=json_encode($newUserDammy);


 
//-----------------------------------


$requireData = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST)){
    return 'error';
    exit;
}

$userModel = new userModel();

//$requireData =json_decode($dummyJson,true);

$emailaddress=$requireData['emailaddress'];




$check_flag=0;



$employeeinsertCheck=0;
if(!is_null($requireData)){
	$check_flag++;

	$checkEmailFlag=$userModel->checkEmail($emailaddress);

	
	if ($checkEmailFlag==0) {

		$check_flag++;

	}else{
		$check_flag++;
	}


}


if ($check_flag==1) {
	$FinaArray = array(
		"state" => "false",
		"error" =>"info missing"
	);
	$FinaJSON=json_encode($FinaArray);
	echo $FinaJSON;

}if ($checkEmailFlag!=0) {
	


		$FinaArray = array(
		"state" => "false",
		"error" =>"Email Been Used"
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
	    "photo"=>"img/default.png"
  	);


	
	
	$employeeUrl=$userModel->assembleInsertUrl("Employees");

	$res1=$userModel->insertNewData($employeeUrl,$employeeInfoArray);
	
	if($res1==TRUE){
		$employeeinsertCheck++;
		$newEmpId=$userModel->queryLastEmployeeId($employeeInfoArray);


				$loginInfoArray=array(
					"photo"=> "img/default.png",
				    "emailaddress"=> $emailaddress,
				    "permission"=> "E",
				    "password"=> $requireData['password'],
				    "empid"=> $newEmpId
					);


		$loginUrl=$userModel->assembleInsertUrl("Logins");

		$res2=$userModel->insertNewData($loginUrl,$loginInfoArray);
		if ($res2==TRUE) {

			$employeeinsertCheck++;
		
		}else{
			$userModel->DELETEData($employeeUrl,$employeeInfoArray);


			$FinaArray = array(
			"state" => "false",
			"error" =>"insert to Login Fail!"
			);
			$FinaJSON=json_encode($FinaArray);
			echo $FinaJSON;

		}
				
				 
	}else{
			

			$FinaArray = array(
			"state" => "false",
			"error" =>"Register Employee Error!"
			);
			$FinaJSON=json_encode($FinaArray);
			echo $FinaJSON;
		}
}

	   










?>