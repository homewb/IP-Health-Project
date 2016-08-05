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

$employeeId=$requireData['employeeId'];
$groupType=$requireData['groupType'];


 // $employeeId="2";
 // $groupType="ALL";

$userModel = new userModel();



$goupInfoArray=[];
$employeeInGroupDataArray=[];
$KPIInfoArray=[];

$searchFlag=0;

$typeAll="ALL";

$employeeGroupArray=$userModel->getEmployeeGroup($employeeId);
$key = 'groupid';
$groupIdArray = array_column($employeeGroupArray, $key);
$numOfgroupIdArray = count($groupIdArray);
//var_dump($groupIdArray);

for($i = 0; $i < $numOfgroupIdArray; $i++){
	$currentGoupId=$groupIdArray[$i];
	$searchFlag=0;
	/*find ALL group TIITL And Group INFOMATION*/
    $TempgoupInfoArray=$userModel->getGroupInfo($currentGoupId);


	//array_push($goupInfoArray, $TempgoupInfoArray);


    $resultOfDateCheck=$userModel->checkDateRange($TempgoupInfoArray['groupstartdate'],$TempgoupInfoArray['groupenddate']);
    if ($resultOfDateCheck > 0 ){

	    if ($TempgoupInfoArray['grouptype']==$groupType) {

	    	array_push($goupInfoArray, $TempgoupInfoArray);

	    }

	    
   }
   
   if($groupType==$typeAll){

	    array_push($goupInfoArray, $TempgoupInfoArray);
	}
    
}

//********************Search incompleate************************






$numbersOfGoupInfoArray=count($goupInfoArray);
	

for ($i=0; $i < $numbersOfGoupInfoArray; $i++) { 
		$searchFlag=0;
		$currentGroupId=$goupInfoArray[$i]['groupid'];
		
		$searchKPIArray=[];
		$searchKPIArray=$userModel->getGroupPerformanceId($currentGroupId);


		
		$key = 'performanceinfoid';
		$KPIIdArray = array_column($searchKPIArray, $key);
		$numOfKPIIdArray = count($KPIIdArray);

		//var_dump($KPIIdArray);

		for($k = 0; $k < $numOfKPIIdArray; $k++){
			$currentKPIId=$KPIIdArray[$k];
			/*find ALL group TIITL And Group INFOMATION*/

			
			$result=$userModel->countReviewData($currentKPIId,$employeeId);


			if ($result['count']==0) {
				$searchFlag++;
		    
			}



		}
		$goupInfoArray[$i]['incomplete']=$searchFlag;
	   // $TempgoupInfoArray['incomplete']=$searchFlag;

}
		








$FinalGroupInfoArray = array(
	"state" => "true",
	"data"	=> $goupInfoArray
 );
$FinalGroupInfoJSON=json_encode($FinalGroupInfoArray); 


echo $FinalGroupInfoJSON;

/*

JSON Format:
GROUP JSON:

{
	"state": true,
	"Data": [{
		groupid : 1,
		grouptittle : Go
	},
	{
		groupid : 2,
		grouptittle : TO

	}
	],
	
}

KPI JSON:

{
	"state": "true",
	"Data": [{
		"empid" : "1",
		"name" : "Go",
		"KPIstatu": "true",
		""
		KPIDATA:[{}]
	},
	{
		"KPIID" : 2,
		"KPItittle" : To,
		"KPIstatu" : fale,
		"KPIDATA":[{
			"Name": "zhang",
			"Rate" : 3,
			"comment" : "The Good Guy",
			"statu" : "accept"
		}]

	}
	],
	
}





*/











