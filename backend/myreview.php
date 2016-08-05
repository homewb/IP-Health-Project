<?php

/* Created by Krupa -
   This php file takes groupid and empid as input and returns a json for myreview page.  
*/

require('adminPeerReviewFunc.php'); // files required and accessed by this php script
require('loginFunctions.php');
require('./data/init.php');
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$data =  json_decode(file_get_contents('php://input'),TRUE); // decoding json data sent from angularjs and storing in an array

$groupid = $data['groupid']; //get the group id from the array of decoded json data
$empid = $data['empid']; // get the employee id from the array of decoded json data

$reviewFuncInstance = adminPeerReviewFunc::getIns(); // create an instance of class adminPeerReviewView

$getUrlInstance =  loginFunction::getIns(); // creating instance of loginFunction class (to access getArray function which decodes the json retrived by hitting strongloop url)

$getKpiidUrl = $reviewFuncInstance->retrieveKpiids($groupid);	//Call retriveKpiids function to get the list of kpi ids for the employee
$kpiIdData = $getUrlInstance->getArray($getKpiidUrl);	// hit the api and store the received json 

if($kpiIdData == NULL) //check if api response was blank
{
	$finalDataArray['state'] = FALSE; // set the json data state to false
	echo json_encode($finalDataArray);
	exit(); //leave the program , do nothing else
}
$finalDataArray = [];
$kpiData = [];
for ($j=0;$j<count($kpiIdData);$j++) //for each kpi get ratings
	{
		$tempData = array();
		$tempData['kpi_id'] = $kpiIdData[$j]['performanceinfoid'];	//store the kpi id

		$getKpiNameUrl = $reviewFuncInstance->retrieveKpiName($tempData['kpi_id']); //get kpi name
		$kpiName = $getUrlInstance->getArray($getKpiNameUrl);
		$tempData['kpi_name'] = $kpiName['performancetypename'];

		$getKpiDescUrl = $reviewFuncInstance->retrieveKpiDescrip($tempData['kpi_id']); //get kpi description
		$kpiDescrip = $getUrlInstance->getArray($getKpiDescUrl);
		$tempData['kpi_description'] = $kpiDescrip['performancedescription'];

		$getKpiRatingUrl = $reviewFuncInstance->retrieveKpiRatings($tempData['kpi_id'],$empid); //call retrieveKpiRatings function to get the list of kpiratings
		$kpiRatingData = $getUrlInstance->getArray($getKpiRatingUrl); // hit the api and store the received json
		$tempData['avgValue'] = $reviewFuncInstance->calculateKpiAverage($kpiRatingData); //store the kpi average rating

		$getMngrFeedbackUrl = $reviewFuncInstance->retrieveManagerFeedback($tempData['kpi_id'],$empid); // get manager feedback
		$feedbackData = $getUrlInstance->getArray($getMngrFeedbackUrl);
		if($feedbackData == NULL)
		{
			$tempData['feedback'] = "No Feedback from Manager.";
			$tempData['review_From_Id'] = -1;
			$tempData['review_Date'] = "Not Available";
		}
		else
		{
			$tempData['feedback'] = $feedbackData[0]['reviewcomment'];	
			$tempData['review_From_Id'] = $feedbackData[0]['empid'];
			$tempData['review_Date'] = $feedbackData[0]['reviewrecordtime'];
		}


		
		array_push($kpiData,$tempData);	// push the array object to the array list
		unset($tempData); // unset temporary data array
	}

$finalDataArray['state'] = "TRUE";	// set the state of json data to true
$finalDataArray['data'] = $kpiData; // set the data to the json data
$returnJson = json_encode($finalDataArray);	// encode the array into json format
echo $returnJson; //return json