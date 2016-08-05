<?php

/* Created by Krupa -
   This php file provides all the functionality required by the 
   adminPeerReview.php.  
*/
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

class adminPeerReviewFunc{

	protected static $ins=null;		//declaring a class variable and initializing to null
    
    public static function getIns(){	//function to create a new instance of itself - like a constructor
        if(self::$ins==null){			//check if the class variable is null i.e. if an instance has not been created
            self::$ins = new self();	//create an instance of self
        }
        return self::$ins;				//return the object
    }
    
    final protected function __construct() {	//Constructor
        
    }

    public function retrieveEmpids($groupid)
    {
    	$filter= "?filter[where][groupid]=$groupid&filter[fields][empid]=true";	//filter to obtain empids for the group
    	$url = 'http://localhost:3001/api/Groupemployees'.$filter;	// creating api url with filters - using the Groupemployees table
    	return $url;
    }

    public function retrieveKpiids($groupid)
    {
    	$filter= "?filter[where][groupid]=$groupid&filter[fields][performanceinfoid]=true"; //filter to obtain kpi ids for the group
    	$url = 'http://localhost:3001/api/Groupperformanceinfos'.$filter; // creating api url with filters - using Groupperformanceinfos table
    	return $url;
    }

    public function retrieveKpiRatings($kpiid,$empid)
    {
    	$filter="?filter[where][performanceinfoid]=$kpiid&filter[where][reviewforempid]=$empid&filter[where][reviewLevel]=normal"; //filter to obtain kpi ratings for employee
    	$url='http://localhost:3001/api/Reviewdata'.$filter; // creating api url with filters - using ReviewData table
    	return $url;
    }

    public function retrieveManagerFeedback($kpiid,$empid)
    {
    	$filter="?filter[where][performanceinfoid]=$kpiid&filter[where][reviewforempid]=$empid&filter[where][reviewLevel]=admin"; //filter to obtain manager feedback
    	$url='http://localhost:3001/api/Reviewdata'.$filter; // creating api url with filters - using ReviewData table
    	return $url;
    }

    public function retrieveKpiName($kpiid)
    {
    	$filter="?filter[where][performanceinfoid]=$kpiid&filter[fields][performancetypename]=true"; //filter to obtain kpi names 
    	$url='http://localhost:3001/api/Performanceinfos/findOne'.$filter; // creating api url with filters - using Performanceinfos table
    	return $url;
    }

    public function retrieveKpiDescrip($kpiid)
    {
        $filter="?filter[where][performanceinfoid]=$kpiid&filter[fields][performancedescription]=true"; //filter to obtain kpi description 
        $url='http://localhost:3001/api/Performanceinfos/findOne'.$filter; // creating api url with filters - using Performanceinfos table
        return $url;
    }

    public function calculateKpiAverage($kpiRatingData)	//calculate the average of all ratings for an employee for one kpi
    {
    	$sum = 0; $total = 0;	// initialise variables to store the sum of all ratings and the total number of members who rated
    	foreach($kpiRatingData as $value)	// for every rating 
    	{
    		$sum = $sum + $value['reviewdata'];	// add the rating to the sum
    		$total = $total + 1;	//increase total by 1
    	}
    	$avg = 0; // initialise variable to store the average of all ratings
    	if($total != 0)	// if total is not 0 (to avoid divide by zero error)
    	{
    		$avg = $sum/$total;	// average is calculated by dividing the sum of all ratings by the total number of people who rated the employee
    	}
        $finalresult = round($avg);	
    	return $finalresult;
    }
}

