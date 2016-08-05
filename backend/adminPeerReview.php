<?php

/* Created by Krupa -
   This php file is called by the angularjs frontend. The program will receive group id from the frontend 
   and return the average kpi ratings per kpi for every employee. This data is used for the first view of  
   the administrator peer review page. */

require('adminPeerReviewFunc.php'); // files required and accessed by this php script
require('loginFunctions.php');
require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$data =  json_decode(file_get_contents('php://input'),TRUE); // decoding json data sent from angularjs and storing in an array

$groupid = $data['groupid']; //get the group id from the array of decoded json data

$reviewFuncInstance = adminPeerReviewFunc::getIns(); // create an instance of class adminPeerReviewView

$getEmpidUrl = $reviewFuncInstance->retrieveEmpids($groupid); // call retrieveEmpids function to get the list of employee ids in the group

$getUrlInstance =  loginFunction::getIns(); // creating instance of loginFunction class (to access getArray function which decodes the json retrived by hitting strongloop url)

$empIdData = $getUrlInstance->getArray($getEmpidUrl); //hit the api and store the returned json

//$returnedData = []; //declare an array variable to store the data to be returned to angularjs
$finalDataArray=[];
if($empIdData == NULL) //check if api response was blank 
{
	$finalDataArray['state'] = FALSE; // set the json data state to false 
	echo json_encode($finalDataArray); 
	exit(); //leave the program , do nothing else
}

$getKpiidUrl = $reviewFuncInstance->retrieveKpiids($groupid);	//Call retriveKpiids function to get the list of kpi ids for the employee
$kpiIdData = $getUrlInstance->getArray($getKpiidUrl);	// hit the api and store the received json 

if($kpiIdData == NULL) //check if api response was blank
{
	$finalDataArray['state'] = FALSE; // set the json data state to false
	echo json_encode($finalDataArray);
	exit(); //leave the program , do nothing else
}
$kpiNamesArray = []; 
foreach($kpiIdData as $kpiValue) // json data for Kpi names as title of the table
{
	$getKpiNameUrl = $reviewFuncInstance->retrieveKpiName($kpiValue['performanceinfoid']);
	$kpiName = $getUrlInstance->getArray($getKpiNameUrl);
	array_push($kpiNamesArray,$kpiName);
}

$empData = [];

$userModel = new userModel();

for ($i=0;$i<count($empIdData);$i++)	//for every employee in the group, for each kpi id get the ratings and calculate the average
{
	$tempEmpData = array();
	$tempEmpData['empid'] = $empIdData[$i]['empid'];	//store the employee id
	$employeeinfoArray = $userModel->getEmployeeInfo($tempEmpData['empid']);
	$tempEmpData['empname'] = $employeeinfoArray['firstname'].' '.$employeeinfoArray['lastname'];
	$kpiData = [];
	for ($j=0;$j<count($kpiIdData);$j++) //for each kpi get ratings
	{
		$tempData = array();
		$getKpiRatingUrl = $reviewFuncInstance->retrieveKpiRatings($kpiIdData[$j]['performanceinfoid'],$empIdData[$i]['empid']); //call retrieveKpiRatings function to get the list of kpiratings
		$kpiRatingData = $getUrlInstance->getArray($getKpiRatingUrl); // hit the api and store the received json

		
		$tempData['kpi_id'] = $kpiIdData[$j]['performanceinfoid'];	//store the kpi id
		$tempData['avgValue'] = $reviewFuncInstance->calculateKpiAverage($kpiRatingData); //store the kpi average rating
		$getMngrFeedbackUrl = $reviewFuncInstance->retrieveManagerFeedback($kpiIdData[$j]['performanceinfoid'],$empIdData[$i]['empid']);
		$feedbackData = $getUrlInstance->getArray($getMngrFeedbackUrl);
		$tempData['feedback'] = $feedbackData['reviewComment'];
		
		array_push($kpiData, $tempData);	// push the array object to the array list
		unset($tempData);
	}
	
	$tempEmpData['columns'] = $kpiData;
	unset($kpiData);
	array_push($empData,$tempEmpData);
	unset($tempEmpData);
}

$finalDataArray['state'] = "TRUE";	// set the state of json data to true
$finalDataArray['titles'] = $kpiNamesArray;
$finalDataArray['data'] = $empData;
$returnJson = json_encode($finalDataArray);	// encode the array into json format
echo $returnJson; //return json






