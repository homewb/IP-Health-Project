<?php
require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"); 


/* GET review
*/


$requireData = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST)){
    return 'error';
    exit;
}


$today = date('Y-m-d');


//$insertArray = $requireData;
// $requireData = array(
//  	"reviewdatastatu" => "accept",
//     "reviewdata" => 12,
//     "reviewcomment" => "LOL",
//     "performanceinfoid" => 12,
//     "reviewlevel"=> "admin",
//     "reviewrecordtime"=>$today,
//     "reviewforempid"=> 12,
//     "empid"=>2
  
// );


$userModel = new userModel();

// $numOfinsertArray = count($insertArray);
// $count=0;


$insertReviewArray = array(
 	"reviewdatastatu" => "accept",
    "reviewdata" => 0,
    "reviewcomment" => $requireData['reviewcomment'],
    "performanceinfoid" => $requireData['performanceinfoid'],
    "reviewlevel"=> $requireData['reviewlevel'],
    "reviewrecordtime"=>$today,
    "reviewforempid"=> $requireData['reviewforempid'],
    "empid"=>$requireData['empid']
  //  "reviewdataid": 0
);

$result = $userModel->insertReviewData($insertReviewArray);

// for ($i=0; $i < $numOfinsertArray; $i++) { 
	
	
// 	if($insertArray[$i]['reviewdataid']==0){
// 		unset($insertArray[$i]['reviewdataid']);
// 		unset($insertArray[$i]['firstname']);
// 		unset($insertArray[$i]['lastname']);
// 		unset($insertArray[$i]['fullname']);
// 		$result = $userModel->insertReviewData($insertArray[$i]);

// 	}
// 	else{
// 		//unset($insertArray[$i]['reviewdataid']);
// 		unset($insertArray[$i]['firstname']);
// 		unset($insertArray[$i]['lastname']);
// 		unset($insertArray[$i]['fullname']);
// 		$result = $userModel->updateReviewData($insertArray[$i]);
// 	}

	
// }

$successArray = array('state' => "TURE" );
$failArray = array('state' => "FALSE" );
$successJSON=json_encode($successArray);
$failJSON=json_encode($failArray);

if($result==TRUE){
    echo $successJSON;
}else{
    echo $failJSON;
}

// if ($count==$numOfinsertArray && $numOfinsertArray>0) {
// 	$FinalKPIJSON=json_encode($FinalKPIArray1); 
// }else{
// 	$FinalKPIJSON=json_encode($FinalKPIArray2); 
// }





//$FinalKPIJSON=json_encode($FinalKPIArray); 


//echo $FinalKPIJSON;


