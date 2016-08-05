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


$insertArray = $requireData['rows'];



$userModel = new userModel();

$numOfinsertArray = count($insertArray);
$count=0;
//var_dump($insertArray);

for ($i=0; $i < $numOfinsertArray; $i++) { 
	//var_dump($insertArray[$i]);
	
	if($insertArray[$i]['reviewdataid']==0){
		unset($insertArray[$i]['reviewdataid']);
		unset($insertArray[$i]['firstname']);
		unset($insertArray[$i]['lastname']);
		$insertArray[$i]['reviewlevel']="normal";
		$result = $userModel->insertReviewData($insertArray[$i]);

	}
	else{
		unset($insertArray[$i]['reviewdataid']);
		unset($insertArray[$i]['firstname']);
		unset($insertArray[$i]['lastname']);
		$insertArray[$i]['reviewlevel']="normal";
		$result = $userModel->updateReviewData($insertArray[$i]);
	}

	
	if($result==NULL){
		
		$count;
	} else{
		$count++;
	}
	
}



$FinalKPIArray1 = array(
		"state" => "true"
	);

$FinalKPIArray2 = array(
		"state" => "false"
	);

if ($count==$numOfinsertArray && $numOfinsertArray>0) {
	$FinalKPIJSON=json_encode($FinalKPIArray1); 
}else{
	$FinalKPIJSON=json_encode($FinalKPIArray2); 
}


//$FinalKPIJSON=json_encode($FinalKPIArray); 


//echo $FinalKPIJSON;


