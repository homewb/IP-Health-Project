<?php
require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"); 


/* GET review
*/
$today = date('Y-m-d');
$now = date("Y-m-d H:i:s");  

// $groupinfoDummy=array(
// 	'grouptittle' => "New_group", 
// 	'groupstartdate' => "2014-12-30", 
// 	'groupenddate' => "2015-05-30", 
// 	'grouptype'=> "review",
// 	'groupcreatetime'=>$now
// 	);


// $performancedummyarray=[];

// $performanceInfoDummy1=array(


//     "performancedatatype"=> "review",

//     "performancecreatetime"=> "$now",
//     "performancedescription"=> "this is a test dummy",
//     "performancetypename"=> "dummy11113434"
//     );

// $performanceInfoDummy2=array(


//     "performancedatatype"=> "review",

//     "performancecreatetime"=> "$now",
//     "performancedescription"=> "this is a test dummy",
//     "performancetypename"=> "dummy2222234"
//     );
// $performanceInfoDummy3=array(


//     "performancedatatype"=> "review",

//     "performancecreatetime"=> "$now",
//     "performancedescription"=> "this is a test dummy",
//     "performancetypename"=> "dummy3323433"
//     );


// array_push($performancedummyarray, $performanceInfoDummy1);
// array_push($performancedummyarray, $performanceInfoDummy2);
// array_push($performancedummyarray, $performanceInfoDummy3);





// $employeeIDDummayArray=[];
// $employeeIDDummayData1=array('empid' => 1 );
// $employeeIDDummayData2=array('empid' => 2 );
// $employeeIDDummayData3=array('empid' => 3 );

// array_push($employeeIDDummayArray, $employeeIDDummayData1);
// array_push($employeeIDDummayArray, $employeeIDDummayData2);
// array_push($employeeIDDummayArray, $employeeIDDummayData3);


// $createGroupDummyData = array(
// 	'state' => 'TRUE', 
// 	'groupinfoData' =>$groupinfoDummy,
// 	'employeeData' => $employeeIDDummayArray,
// 	'KPIData'=>$performancedummyarray
// 	);

$dummyJson=json_encode($createGroupDummyData);


 
//-----------------------------------


$requireData = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST)){
    return 'error';
    exit;
}

$userModel = new userModel();

// $requireData =json_decode($dummyJson,true);




$groupinsertArray = $requireData['groupinfoData'];
$employeeInsertArray = $requireData['employeeData'];
$performanceInfoArray = $requireData['KPIData'];


//var_dump($performanceInfoArray);
$check_flag=0;
$kpiregisterCount=0;
$employeeinsertCheck=0;
if(!is_null($groupinsertArray)){
	$check_flag++;

}
if(!is_null($employeeInsertArray)){
	$check_flag++;

}
if(!is_null($performanceInfoArray)){
	$check_flag++;
}



if ($check_flag<3) {
	$FinaArray = array(
		"state" => "false",
		"error" =>"info missing"
	);
	$FinaJSON=json_encode($FinaArray);
	echo $FinaJSON;

}else{



	$url=$userModel->assembleInsertUrl("Groups");
	
	$newgroupArray = array(
			'grouptittle' => $groupinsertArray['grouptittle'], 
			'groupstartdate' => $groupinsertArray['groupstartdate'], 
			'groupenddate' => $groupinsertArray['groupenddate'], 
			'grouptype'=> $groupinsertArray['grouptype'],
			'groupcreatetime' => $now );


	$groupResult = $userModel->insertNewData($url,$newgroupArray); 
	//$res1=FALSE;



	if($groupResult == TRUE){

		//echo "echo $result";

		$groupid = $userModel->queryLastGroupId($newgroupArray);
		//echo "$groupid";




		// $key = 'empid';
		// $employeeIdArray = array_column($employeeInsertArray, $key);






		$numOfiemployeeIdArray = count($employeeInsertArray);
		$count=0;
		//var_dump($insertArray);

		for ($i=0; $i < $numOfiemployeeIdArray; $i++) { 
			//var_dump($insertArray[$i]);

			$employeegrouUrl=$userModel->assembleInsertUrl("Groupemployees");
			$currentEmployeeId=$employeeInsertArray[$i];

			$tempGroupEmployeeArray = array(
				'groupid' => $groupid,
				'empid' => $currentEmployeeId);

			$groupEmployeeResult=$userModel->insertNewData($employeegrouUrl,$tempGroupEmployeeArray);

			if($groupEmployeeResult==TRUE){
				
				$employeeinsertCheck++;
				
				 
			}else{

				$FinaArray = array(
				"state" => "false",
				"error" =>"Register Employee to Group Error!"
				);
				$FinaJSON=json_encode($FinaArray);
				echo $FinaJSON;
			}
		}

	   
	}else{
		$FinaArray = array(
		"state" => "false",
		"error" =>"group Create Fail!"
		);
		$FinaJSON=json_encode($FinaArray);
		echo $FinaJSON;


	}

	




}	








//insert performance
				
	$numOfPerformanceArray = count($performanceInfoArray);
				//$count=0;


	//echo "\n\n\n----------KPI--------\n\n\n";

	for ($j=0; $j <$numOfPerformanceArray ; $j++) { 
					
	$KPIurl=$userModel->assembleInsertUrl("Performanceinfos");

	$tempPerformanceArray=array(
	 "performancedatatype"=> $performanceInfoArray[$j]['performancedatatype'],

	 "performancecreatetime"=> $now,
	 "performancedescription"=> $performanceInfoArray[$j]['performancedescription'],
    "performancetypename"=> $performanceInfoArray[$j]['performancetypename']
	);

	
	$insertKPIresult1=$userModel->insertNewData($KPIurl,$tempPerformanceArray);

	if($insertKPIresult1==TRUE){
		$kpiregisterCount++;


	}else{

		$FinaArray = array(
		"state" => "false",
		"error" =>"Create performanceinfo Error!"
		);
		$FinaJSON=json_encode($FinaArray);
		echo $FinaJSON;

	}
}

$groupkpiregisterCount=0;
if($kpiregisterCount ==$numOfPerformanceArray){
//search KPI ID
	for ($j=0; $j <$numOfPerformanceArray ; $j++) { 
						
		$KPIurl=$userModel->assembleInsertUrl("Performanceinfos");

		$tempPerformanceArray=array(
		 "performancedatatype"=> $performanceInfoArray[$j]['performancedatatype'],

		 "performancecreatetime"=> $now,
		 "performancedescription"=> $performanceInfoArray[$j]['performancedescription'],
	    "performancetypename"=> $performanceInfoArray[$j]['performancetypename']
		);

		
		$KPIId=$userModel->queryLastPerformanceInfoId($tempPerformanceArray);
		
		$tempRegisterArray = array(
			'groupid' =>$groupid ,
			'performanceinfoid'=>$KPIId
		 );

		$registerKPIurl=$userModel->assembleInsertUrl("Groupperformanceinfos");
		$resultReg=$userModel->insertNewData($registerKPIurl,$tempRegisterArray);



		if($resultReg==TRUE){
			$groupkpiregisterCount++;
			

		}else{

			$FinaArray = array(
			"state" => "false",
			"error" =>"Create performanceinfo Error!"
			);
			$FinaJSON=json_encode($FinaArray);
			echo $FinaJSON;

		}
	}



}

if($groupkpiregisterCount==$numOfPerformanceArray && $employeeinsertCheck==$numOfiemployeeIdArray&& $groupResult == TRUE){

	$FinaArray = array(
			"state" => "TRUE",
			
			);
			$FinaJSON=json_encode($FinaArray);
			echo $FinaJSON;
}

// for ($k=0; $k < ; $k++) { 
	
// }


// $FinalKPIArray1 = array(
// 		"state" => "TRUE"
// 	);

// $FinalKPIArray2 = array(
// 		"state" => "false"
// 	);

// if ($count==$numOfinsertArray && $numOfinsertArray>0) {
// 	$FinalKPIJSON=json_encode($FinalKPIArray1); 
// }else{
// 	$FinalKPIJSON=json_encode($FinalKPIArray2); 
// }


//$FinalKPIJSON=json_encode($FinalKPIArray); 


//echo $FinalKPIJSON;
?>