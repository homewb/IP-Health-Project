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

$employeeId=$requireData['employeeid'];
$groupType=$requireData['grouptype'];


 // $employeeId="2";
 // $groupType="review";

$userModel = new userModel();



$goupInfoArray=[];
$employeeInGroupDataArray=[];
$KPIInfoArray=[];

$searchFlag=0;

$typeAll="review";

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
		
		
		$searchKPIArray=[];
		$CurrentGroupKPIArray=[];
		$currentGroupId=$goupInfoArray[$i]['groupid'];

		$searchKPIArray=$userModel->getGroupPerformanceId($currentGroupId);


		//search KPI range
		$key = 'performanceinfoid';
		$KPIIdArray = array_column($searchKPIArray, $key);
		$numOfKPIIdArray = count($KPIIdArray);


		//search Employee range
		$employeeInGroupDataArray=[];
		$employeeInGroupArray=$userModel->getAllEmployeeIdInGroup($currentGroupId);
		$key = 'empid';
		$empIdArray = array_column($employeeInGroupArray, $key);
		$numberOfEmployee=count($empIdArray);


		$goupInfoArray[$i]['member']=$empIdArray;

		//var_dump($empIdArray);

		for($k = 0; $k < $numOfKPIIdArray; $k++){
			$currentKPIId=$KPIIdArray[$k];
			/*find ALL group TIITL And Group INFOMATION*/
			$searchFlag=0;
			

			for ($j=0; $j < $numberOfEmployee; $j++) { 
				$reviewvforEmployeeId=$empIdArray[$j];
				
				

				$result=$userModel->countReviewForEmployeeData($currentKPIId,$employeeId,$reviewvforEmployeeId);


				if ($result['count']==0) {
					$searchFlag++;
		    
				}

			}
			$temparray=$userModel->getPerformanceInfo($currentKPIId);
			
			$temparray['incomplete']=$searchFlag;
			
			array_push($CurrentGroupKPIArray, $temparray);

		}
		$goupInfoArray[$i]['KPIArray']=$CurrentGroupKPIArray;
		

	   

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











