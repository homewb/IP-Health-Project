<?php
require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"); 

$today = date('Y-m-d');
$now = date("Y-m-d H:i:s"); 

/* GET review
*/

/*






*/


// $dummyGroupinforArray = array(

//   'grouptittle'=>"currentGroup",

//   'grouptype'=> "review111",
//     'groupid'=> 11

//  );

// $dummyDeleteEmployeeArray = array(2,3,4,5

//  );

// $dummyAddEmployeeArray = array(6,7,8,9,2

//  );

// $dummyDeletKPIArray = array(228,229,230,231

//  );

// $dummyAddKPIArray = [];



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


// array_push($dummyAddKPIArray, $performanceInfoDummy1);
// array_push($dummyAddKPIArray, $performanceInfoDummy2);
// array_push($dummyAddKPIArray, $performanceInfoDummy3);




// //dummyUPDATEArray--------------
// $dummyUPDATEArray=[];
// $performanceInfoDummy1=array(

// 	"performanceinfoid" =>223,
//     "performancedatatype"=> "review22221",

//     "performancecreatetime"=> "$now",
//     "performancedescription"=> "this is a test dummy",
//     "performancetypename"=> "21122221"
//     );

// $performanceInfoDummy2=array(

// 	"performanceinfoid" =>224,
//     "performancedatatype"=> "review",

//     "performancecreatetime"=> "$now",
//     "performancedescription"=> "this is a test dummy",
//     "performancetypename"=> "2122221"
//     );
// $performanceInfoDummy3=array(

// 	"performanceinfoid" =>225,
//     "performancedatatype"=> "review",

//     "performancecreatetime"=> "$now",
//     "performancedescription"=> "this is a test dummy",
//     "performancetypename"=> "213222221"
//     );


// array_push($dummyUPDATEArray, $performanceInfoDummy1);
// array_push($dummyUPDATEArray, $performanceInfoDummy2);
// array_push($dummyUPDATEArray, $performanceInfoDummy3);





// $dummyJSONarray = array(
// 	'groupInfo'=>$dummyGroupinforArray,
// 	'deleteEmployee'=>$dummyDeleteEmployeeArray,
// 	'addEmployee'=>$dummyAddEmployeeArray,


// 	'deletKPI'=>$dummyDeletKPIArray,
// 	'addKPIArray'=>$dummyAddKPIArray,
// 	'updateKPI'=>$dummyUPDATEArray


// 	);



// $dummyJson=json_encode($dummyJSONarray);




//--------------------------------------------------------

 


$requireData = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST)){
    return 'error';
    exit;
}


$userModel = new userModel();


//dummy!!!!!!!!!!!!!!!!!!!!
//$requireData=json_decode($dummyJson, true);





$groupInfo=$requireData['groupInfo'];

$groupid=$groupInfo['groupid'];


$successFlag=0;
$kpiregisterCount=0;
$deletEmployeeArray=$requireData['deleteEmployee'];
$addEmployeeArray=$requireData['addEmployee'];


$deletKPIArray=$requireData['deletKPI'];
$addKPIArray=$requireData['addKPIArray'];
$updateKPIArray=$requireData['updateKPI'];

$numberOfdeleteEmployee=count($deletEmployeeArray);

$numberOfaddEmployeeArray=count($addEmployeeArray);
$numberOfdeletKPIArray=count($deletKPIArray);
$numberOfaddKPIArray=count($addKPIArray);
$numberOfupdateKPIArray=count($updateKPIArray);




/* Update Group information
*/




if ($groupInfo!=null) {
	$result=$userModel->updateGroupInfo($groupid,$groupInfo);
	//echo "$result";
	if ($result==false) {
		echo "Error";	
	}
}




if ($numberOfdeleteEmployee>0) {
	for ($i=0; $i <$numberOfdeleteEmployee ; $i++) { 
		$currentEmployee=$deletEmployeeArray[$i];

		$condition='/findOne?filter[where][groupid]='.$groupid.'&filter[where][empid]='.$currentEmployee;

		$URL=$userModel->assembleSearchUrl("Groupemployees",$condition);
		

		$recordid=$userModel->searchRecordId($URL);
		
		$deleteURL=$userModel->assembleInsertUrl("Groupemployees");
		$finalDeleteURL=$deleteURL.'/'.$recordid;

		$updateArray = array('recordid' => $recordid  );


		$res=$userModel->DELETEData($finalDeleteURL,$updateArray);
		if ($res==TRUE) {
			$successFlag++;
		}


	}
	
}


if ($numberOfaddEmployeeArray > 0 ) {
	for ($i=0; $i <$numberOfaddEmployeeArray ; $i++) { 
		$currentEmployee=$addEmployeeArray[$i];
		

		$employeegrouUrl=$userModel->assembleInsertUrl("Groupemployees");
		

		$tempGroupEmployeeArray = array(
			'groupid' => $groupid,
			'empid' => $currentEmployee);
		$groupEmployeeResult=$userModel->insertNewData($employeegrouUrl,$tempGroupEmployeeArray);

		
		if($groupEmployeeResult==TRUE){
				
			$successFlag++;
								 
		}
	}
}

if ($numberOfdeletKPIArray>0) {

	for ($i=0; $i <$numberOfdeletKPIArray ; $i++) { 
		$currentKPI=$deletKPIArray[$i]['performanceinfoid'];

		
		$condition='/findOne?filter[where][groupid]='.$groupid.'&filter[where][performanceinfoid]='.$currentKPI;

		$URL=$userModel->assembleSearchUrl("Groupperformanceinfos",$condition);
		
		$recordid=$userModel->searchRecordId($URL);

		$deleteURL=$userModel->assembleInsertUrl("Groupperformanceinfos");
		$finalDeleteURL=$deleteURL.'/'.$recordid;
		
		$updateArray = array(
			'recordid' => $recordid,
			'groupid' =>$groupid,
			'performanceinfoid'=>$currentKPI
		  );


		$res=$userModel->DELETEData($finalDeleteURL,$updateArray);
		if ($res==TRUE) {
			$successFlag++;
		}
	}


}




if ($numberOfaddKPIArray>0) {

	for ($j=0; $j <$numberOfaddKPIArray ; $j++) { 
		//$currentKPI=$addKPIArray[$j][''];

		$KPIurl=$userModel->assembleInsertUrl("Performanceinfos");
		
		

		$tempPerformanceArray=array(
		 "performancedatatype"=> $addKPIArray[$j]['performancedatatype'],

		 "performancecreatetime"=> $now,
		 "performancedescription"=> $addKPIArray[$j]['performancedescription'],
	    "performancetypename"=> $addKPIArray[$j]['performancetypename']
		);

		
		$insertKPIresult1=$userModel->insertNewData($KPIurl,$tempPerformanceArray);

		if($insertKPIresult1==TRUE){
			$kpiregisterCount++;
			$successFlag++;


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

$groupkpiregisterCount=0;



if($kpiregisterCount == $numberOfaddKPIArray){
//search KPI ID
	for ($j=0; $j <$numberOfaddKPIArray ; $j++) { 
						
		$KPIurl=$userModel->assembleInsertUrl("Performanceinfos");

		$tempPerformanceArray=array(
		 "performancedatatype"=> $addKPIArray[$j]['performancedatatype'],

		 "performancecreatetime"=> $now,
		 "performancedescription"=> $addKPIArray[$j]['performancedescription'],
	    "performancetypename"=> $addKPIArray[$j]['performancetypename']
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



// Update KPI infomation
if ($numberOfupdateKPIArray>0) {
	for ($i=0; $i < $numberOfupdateKPIArray; $i++) { 
		$currentKPI=$updateKPIArray[$i]['performanceinfoid'];
		$updateArray = array(
			
			'performancedatatype'=> $updateKPIArray[$i]['performancedatatype'],
			'performanceinfoid' => $currentKPI,
			'performancecreatetime'=> $now,
			'performancedescription'=> $updateKPIArray[$i]['performancedescription'],
			'performancetypename'=> $updateKPIArray[$i]['performancetypename']
			);

		
		$resUpdate=$userModel->updateKPIinfo($currentKPI,$updateArray);

		if ($resUpdate==false) {
			echo "error";
		}



	}
}

if ($successFlag>1){
	$FinaArray = array(
	"state" => "TRUE"
	
	);
	$FinaJSON=json_encode($FinaArray);
	echo $FinaJSON;


}else{
	$FinaArray = array(
	"state" => "false"

	);
	$FinaJSON=json_encode($FinaArray);
	echo $FinaJSON;


}
