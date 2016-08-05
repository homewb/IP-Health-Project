<?php
/* 
 * create by gongzheng
 */

class userModel{
    public $database=null;
    public $StrongLoopIp="127.0.0.1";
    public $StrongLoopPort="3001";





    //search Groups  WARNING THIS function IS RETURN  * ARRAY *
  public function getGroupID($employeeId){
      $result = file_get_contents('http://'.'localhost'.':'.'3001'.'/api/Groupemployees?filter[where][employeeid]='.$employeeId);

      $data = json_decode($result, true);


       return $data;
    }



   

     public function getGroupInfo($groupId){
      

      $data = json_decode(file_get_contents('http://'.'localhost'.':'.'3001'.'/api/Groups/findOne?filter[where][groupId]='.$groupId), true);


      
        $GroupInfo=$data['grouptittle'];
        
     


       return $data;
    }


    public function getAllGroupInfo(){
      

      $data = json_decode(file_get_contents('http://'.'localhost'.':'.'3001'.'/api/Groups'), true);


      
       return $data;
    }

    /*Find ALL Employee, whos been assigned into the group*/
    public function getAllEmployeeIdInGroup($groupid){
        $result = file_get_contents('http://'.'localhost'.':'.'3001'.'/api/Groupemployees?filter[where][groupId]='.$groupid);

        $data = json_decode($result, true);


         return $data;
      }

    
      /* Find  ALL KPI ID, witch are been assign in to the Group */
    public function getGroupPerformanceId($gourpId){
       $data = json_decode(file_get_contents('http://'.'localhost'.':'.'3001'.'/api/Groupperformanceinfos?filter[where][groupid]='.$gourpId), true);

   
      
       return $data;
    }

    /* Get the KPI infomation */
    public function getPerformanceInfo($performanceInfoId){
    
      $data = json_decode(file_get_contents('http://'.'localhost'.':'.'3001'.'/api/Performanceinfos/findOne?filter[where][performanceinfoid]='.$performanceInfoId), true);


      


       return $data;
    }
  
    /* Find an Employee's Group (ALL) - Group */
    public function getEmployeeGroup($empId){

      $data = json_decode(file_get_contents('http://'.'localhost'.':'.'3001'.'/api/Groupemployees?filter[where][empid]='.$empId), true);


      return $data;

    }


    public function getReviewData($performanceInfoId,$userEmployeeId,$forEmployeeId){
  
   
    
    $data = json_decode(file_get_contents('http://localhost:3001/api/Reviewdata/findOne?filter[where][performanceinfoid]='.$performanceInfoId.'&filter[where][empid]='.$userEmployeeId.'&filter[where][reviewforempid]='.$forEmployeeId), true);

       return $data;
    }



     public function checkReviewData($performanceInfoId,$userEmployeeId){
  
    
    $data = json_decode(file_get_contents('http://localhost:3001/api/Reviewdata/findOne?filter[where][performanceinfoid]='.$performanceInfoId.'&filter[where][empid]='.$userEmployeeId), true);

       return $data;
    }


     public function countReviewData($performanceInfoId,$EmployeeId){
//http://localhost:3001/api/Reviewdata/count?[where][performanceinfoid]=168&[where][empid]=2
    $link1='http://localhost:3001/api/Reviewdata/count';
    $content='?[where][performanceinfoid]='.$performanceInfoId.'&[where][empid]='.$EmployeeId;
    $countLink=$link1.$content;

    $data = json_decode(file_get_contents($countLink), true);

       return $data;
    }
    public function countReviewForEmployeeData($performanceInfoId,$EmployeeId,$reviewforempid){
//http://localhost:3001/api/Reviewdata/count?[where][performanceinfoid]=168&[where][empid]=2
    $link1='http://localhost:3001/api/Reviewdata/count';
    $content='?[where][performanceinfoid]='.$performanceInfoId.'&[where][empid]='.$EmployeeId.'&[where][reviewforempid]='.$reviewforempid;
    $countLink=$link1.$content;

    $data = json_decode(file_get_contents($countLink), true);

       return $data;
    }


    public function getGroupReviewDataForEmployee($performanceInfoId,$userEmployeeId,$forEmployeeId){
    $data = json_decode(file_get_contents('http://localhost:3001/api/Reviewdata/findOne?filter[where][performanceinfoid]='.$performanceInfoId.'&filter[where][empId]='.$userEmployeeId.'&filter[where][reviewforempid]='.$forEmployeeId), true);


       return $data;
    }

/*
    public function getPerformanceInfoId($empId){

      $data = json_decode(file_get_contents('http://'.'localhost'.':'.'3001'.'/api/Groupemployees?filter[where][empId]='.$empId), true);

    
      return $data;

    }
*/
    public function getAdminFeedback($performanceInfoId, $forEmployeeId) {

      return json_decode(file_get_contents('http://localhost:3001/api/Reviewdata/findOne?filter[where][performanceinfoid]='.$performanceInfoId.'&filter[where][reviewlevel]=admin&filter[where][reviewforempid]='.$forEmployeeId), true);

    }

    public function getEmployeePerformanceData($empId,$searchDate,$performanceInfoId){

      $test1="&filter[where][performancerecordtime]=";
      $test2="&filter[where][performanceinfoid]=";
      $link= 'http://'.'localhost'.':'.'3001'.'/api/Performancedata/findOne?filter[where][empId]='.$empId."&filter[where][performancerecordtime]=".$searchDate.'&filter[where][performanceinfoid]='.$performanceInfoId;
      $link2=htmlspecialchars_decode($link);

    
      $rawData = (file_get_contents( htmlspecialchars_decode($link2)));

     
      $data = json_decode(($rawData), true);

      $employeePerformanceData=$data;
     
      return $employeePerformanceData;

    }

    public function getLoginId($empid){
      $link='http://localhost:3001/api/Logins/findOne?filter[where][empid]='.$empid;
      $result=file_get_contents($link);

      $data= json_decode($result, true);
      
     
      return $data['loginid'];

    }



    /*Search the employee's performanceData (KPI Data) for the KPI*/
     public function getEmployeePerformanceDataINGroup($empId,$performanceInfoId){

      
      $link= ('http://'.'localhost'.':'.'3001'.'/api/Performancedata/findOne?filter[where][empId]='.$empId.'&filter[where][performanceinfoid]='.$performanceInfoId);


      $link2=htmlspecialchars_decode($link);

     

      $rawData = (file_get_contents( htmlspecialchars_decode($link2)));
      $data = json_decode(($rawData), true);


     


      $employeePerformanceData=$data;

      return $employeePerformanceData;

    }


    /*Find all performancedata (KPI data) belongs to the KIP*/
     public function getAllPerformanceDataByPerformanceId($performanceInfoId){

    $data = json_decode(file_get_contents('http://'.'localhost'.':'.'3001'.'/api/Performancedata?filter[where][performanceinfoid]='.$performanceInfoId), true);
    
      //StrongLoopIp
      //http://localhost:3001/api/Employees/'$empId'
      return $data;

    }


    /* If the employee's data no in database then make a empty array */
    public function setEmptyPerformanceArray($empId,$currenterformanceId){

      $today=date('Y-m-d');

      $tempArray=array(
        "empid"=>$empId,
        "performanceinfoid"=>$currenterformanceId,
        "performancerecordtime"=>$today,
        "performancedatastatu"=>"pending",
        "performancedata"=>0
        );

      $emptyPerformanceArray =$tempArray;

      return $emptyPerformanceArray;

    }





    public function setEmptyReviewArray($performanceInfoId,$userEmployeeId,$currentForEmpId){

      $today=date('Y-m-d');
      $employeeInfo = json_decode(file_get_contents('http://localhost:3001/api/Employees/'.$currentForEmpId), true);
      
      $firstname = $employeeInfo['firstname'];
      $lastname = $employeeInfo['lastname'];
      
      
      $tempArray=array(

        "empid" => $userEmployeeId,
        "performanceinfoid" => $performanceInfoId,
        "reviewrecordtime" => $today,
        "reviewdatastatu" => "pengding",
        
        "reviewdata" => 0,
        "reviewcomment" => "",
        "reviewforempid" => $currentForEmpId,
        "reviewdataid" =>0,
        "reviewLevel" => "normal",
        "firstname" => $firstname,
        "lastname" => $lastname
        );

      $emptyPerformanceArray =$tempArray;

      return $emptyPerformanceArray;

    }
     public function setEmptyReviewForEmployeeArray($performanceInfoId,$userEmployeeId,$currentForEmpId){

      $today=date('Y-m-d');
      $employeeInfo = json_decode(file_get_contents('http://localhost:3001/api/Employees/'.$userEmployeeId), true);
      
      $firstname = $employeeInfo['firstname'];
      $lastname = $employeeInfo['lastname'];
      
      
      $tempArray=array(

        "empid" => $userEmployeeId,
        "performanceinfoid" => $performanceInfoId,
        "reviewrecordtime" => $today,
        "reviewdatastatu" => "pengding",
        
        "reviewdata" => 0,
        "reviewcomment" => "",
        "reviewforempid" => $currentForEmpId,
        "reviewdataid" =>0,
        "reviewLevel" => "normal",
        "firstname" => $firstname,
        "lastname" => $lastname
        );

      $emptyPerformanceArray =$tempArray;

      return $emptyPerformanceArray;

    }
    public function getEmployeeInfo($userEmployeeId){
      
      $result=file_get_contents('http://localhost:3001/api/Employees/'.$userEmployeeId);

   

      $employeeInfo= json_decode($result, true);
      
     
      return $employeeInfo;

    }

    public function getAllEmployeeInfo(){
      
      $result=file_get_contents('http://localhost:3001/api/Employees');

   

      $employeeInfo= json_decode($result, true);
      
     
      return $employeeInfo;

    }
    public function getEmployee($employeeId){
      


      $URL='http://localhost:3001/api/Logins/findOne?filter[where][empid]='.$employeeId;
      $result=file_get_contents($URL);

   
      $logInInfo= json_decode($result, true);
      $emailAddress=$logInInfo['emailaddress'];
      
     
      return $emailAddress;

    }


      /* Insert New record Data to performanceData table */
      public function insertNewperformanceData($insertArray){

      $insertJSON = json_encode($insertArray);

      return $emptyPerformanceArray;


    }


    //assemble a url for target table
    public function assembleInsertUrl($tablename){

      $url='http://localhost:3001/api/'.$tablename;
      return $url;


    }

    public function assembleSearchUrl($tablename,$condition){

      $url='http://localhost:3001/api/'.$tablename.$condition;
     
      return $url;


    }




    //get group id after new group been created. 
    public function queryLastGroupId($groupinfoarray){
      $time=urlencode($groupinfoarray['groupcreatetime']);
      $grouptittle=urlencode($groupinfoarray['grouptittle']);

      $searchRange1 = '?filter[where][grouptittle]='.$grouptittle;
      $searchRange2 = '&filter[where][groupcreatetime]='.$time;

      //$searchRange3 = '&filter[where][grouptype]='.$groupinfoarray['grouptype'];
      $urllink='http://localhost:3001/api/Groups/findOne'.$searchRange1.$searchRange2;
      
      //$newlink=htmlentities($urllink, ENT_COMPAT,'ISO-8859-1', true);
     
      $result=file_get_contents($urllink);

     
      $data = json_decode($result, true);
    
      return $data['groupid'];
    }

    //get group id after new KPI/performanceInfo been created. 
     public function queryLastPerformanceInfoId($performanceinfoarray){

      $time=urlencode($performanceinfoarray['performancecreatetime']);
      $performancetypename=urlencode($performanceinfoarray['performancetypename']);
      $searchRange2 = '&filter[where][performancetypename]='.$performancetypename;
      $searchRange1 = '?filter[where][performancecreatetime]='.$time;
     // $searchRange3 = '&filter[where][performancedatatype]='.$performanceinfoarray['performancedatatype'];
      
      $urllink='http://localhost:3001/api/Performanceinfos/findOne'.$searchRange1.$searchRange2;
      
      $result=file_get_contents($urllink);
    
      $data = json_decode($result, true);
    // filter[where][name]=John&filter[limit]=3
      //$result=file_get_contents();
     //$data = json_decode(file_get_contents($result), true);
    
      return $data['performanceinfoid'];
   

    }


    public function queryLastEmployeeId($employeeInfoArray){


      $firstname=urlencode($employeeInfoArray['firstname']);
      $lastname=urlencode($employeeInfoArray['lastname']);
     // $birthday=urlencode($employeeInfoArray['birthday']);
      $mobile=urlencode($employeeInfoArray['mobile']);
      
      $searchRange1 = '?filter[where][firstname]='.$firstname;
      $searchRange2 = '&filter[where][lastname]='.$lastname;
      //$searchRange3 = '&filter[where][birthday]='.$birthday;
      $searchRange4 = '&filter[where][mobile]='.$mobile;
      
 
      $urllink='http://localhost:3001/api/Employees/findOne'.$searchRange1.$searchRange2.$searchRange4;
      

      
      $result=file_get_contents($urllink);

      $data = json_decode($result, true);
    
      return $data['empid'];
    }








    // for create group, create KPI/performanceinfo, register employee, 
    //register KPI/performanceinfo and employee 
    public function insertNewData($url,$insertArray){
            

       $jsonDataEncoded = json_encode($insertArray);
          
      //Initiate cURL.
   
      $ch = curl_init($url);
   
      //Tell cURL that we want to send a POST request.
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
      //Attach our encoded JSON string to the POST fields.
      curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
       
      //Set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
       
      //Execute the request
      $curl_result = curl_exec($ch);

      curl_close($ch);
      


      return $curl_result;
      

    }




    public function insertReviewData($insertArray){
            
      $url = 'http://localhost:3001/api/Reviewdata';
       
      //Initiate cURL.
      $ch = curl_init($url);


      $jsonDataEncoded = json_encode($insertArray);
       
      //Tell cURL that we want to send a POST request.
      curl_setopt($ch, CURLOPT_POST, 1);
     
     
      //Attach our encoded JSON string to the POST fields.
      curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
       
      //Set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
       
      //Execute the request
      $result = curl_exec($ch);
      //curl_close($ch);
      $resultArray=json_decode(($result),true);


      return $resultArray;


    }
    public function updateReviewData($updateArray){

      $url = 'http://localhost:3001/api/Reviewdata';
       
      //Initiate cURL.
      $ch = curl_init($url);


      $jsonDataEncoded = json_encode($updateArray);
       
      //Tell cURL that we want to send a PUT request.
      //url_setopt($ch, CURLOPT_PUT, 1);
       
      //Attach our encoded JSON string to the POST fields.
      curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
       
      //Set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
      //Execute the request
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // note the PUT here
      //curl_setopt($ch, CURLOPT_HEADER, true);

      $result = curl_exec($ch);
      //curl_close($ch);
      $resultArray=json_decode(($result),true);


      return $resultArray;

    }


    public function DELETEData($url,$updateArray){

     // $url = 'http://localhost:3001/api/Reviewdata';
       
      //Initiate cURL.
      $ch = curl_init($url);


      $jsonDataEncoded = json_encode($updateArray);
       
      //Tell cURL that we want to send a PUT request.
      //url_setopt($ch, CURLOPT_PUT, 1);
       
      //Attach our encoded JSON string to the POST fields.
      curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
       
      //Set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
      //Execute the request
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // note the PUT here
      //curl_setopt($ch, CURLOPT_HEADER, true);

      $result = curl_exec($ch);
      //curl_close($ch);
      $resultArray=json_decode(($result),true);


      return $result;

    }


    



    

     public function getALLReviewForTargetEmployee($KPIID,$reviewForEmployeeId){

        $filter1 = "?filter[where][performanceinfoid]=$KPIID";
        $filter2 = "&filter[where][reviewforempid]=$reviewForEmployeeId";
        $url = 'http://localhost:3001/api/Reviewdata'.$filter1.$filter2;
        $data = json_decode(file_get_contents($url), true);

        return $data;


     }


     public function calculateAverage($data,$DataName){


        
        $numOfReviewDataArray = count($data);

        $result = 0;

        for($i = 0; $i < $numOfReviewDataArray; $i++){

          $result = $result + $data[$i]["$DataName"];
        }

        $answer= $result / $numOfReviewDataArray;
        
        $finalAnswer= round($answer);

        return $finalAnswer;


     }



    public function getEmployeeLoginInfo($employeeId){
      $filter1 = "?filter[where][empid]=".$employeeId;
      $url = 'http://localhost:3001/api/Logins/findOne';
      $urllink=$url.$filter1;
      $data = json_decode(file_get_contents($urllink), true);

      return $data;
    }
/*
    public function getAdminLevelReviewComment($employeeId,$reviewforempid,$performanceinfoid){
      $level="admin";
      $filter1 = "?filter[where][reviewlevel]=$level";
      $filter2 = "&filter[where][performanceinfoid]=$performanceinfoid";
      $filter3 = "&filter[where][reviewforempid]=$reviewforempid";
      $filter4 = "&filter[where][empid]=$performanceinfoid";
      $url = 'http://localhost:3001/api/Reviewdata/findOne'.$filter1.$filter2.$filter3.$filter4;
      $data = json_decode(file_get_contents($url), true);

      return $data;
    }

*/




    public function searchRecordId($URL){

      $data = json_decode(file_get_contents($URL), true);


      return $data['recordid'];



    }


    public function deleteGroup($groupid){

      $POSTArray = array('groupid' => $groupid );

      

      $url = 'http://localhost:3001/api/Groups/'.$groupid;
       
      //Initiate cURL.
      $ch = curl_init($url);


      $jsonDataEncoded = json_encode($POSTArray);

    
       
      //Tell cURL that we want to send a PUT request.
      //url_setopt($ch, CURLOPT_PUT, 1);
       
      //Attach our encoded JSON string to the POST fields.
      curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
       
      //Set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
      //Execute the request
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // note the DELETE here
      //curl_setopt($ch, CURLOPT_HEADER, true);

      $result = curl_exec($ch);

      // $resultArray=json_decode(($result),true);
      //curl_close($ch);

      // return $resultArray;

      return $result;
    }

     public function updateGroupInfo($groupid,$groupInfo){

      $POSTArray = $groupInfo;
      


      $url = 'http://localhost:3001/api/Groups/'.$groupid;
      
      //Initiate cURL.
      $ch = curl_init($url);


      $jsonDataEncoded = json_encode($POSTArray);

    
       
      //Tell cURL that we want to send a PUT request.
      //url_setopt($ch, CURLOPT_PUT, 1);
       
      //Attach our encoded JSON string to the POST fields.
      curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
       
      //Set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
      //Execute the request
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // note the PUT here
      //curl_setopt($ch, CURLOPT_HEADER, true);

      $result = curl_exec($ch);

      // $resultArray=json_decode(($result),true);


      // return $resultArray;
      //curl_close($ch);
      return $result;
    }


   
     public function updateKPIinfo($KPIid,$KPIInfo){
            
      $url = 'http://localhost:3001/api/Performanceinfos';
       
      //Initiate cURL.
      $ch = curl_init($url);

      
      $jsonDataEncoded = json_encode($KPIInfo);
       
      //Tell cURL that we want to send a POST request.
     curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
       
      //Set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
      //Execute the request
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // note the PUT here
      //curl_setopt($ch, CURLOPT_HEADER, true);

  

      $result = curl_exec($ch);


      //Execute the request
      $result = curl_exec($ch);
      //curl_close($ch);
      $resultArray=json_decode(($result),true);


      return $resultArray;


    }


    public function checkDateRange($start_date, $end_date)
    {
      $today = date('Y-m-d');
      $result=0;
      // Convert to timestamp
      $start_ts = strtotime($start_date);
      $end_ts = strtotime($end_date);
      $user_ts = strtotime($today);

      // Check that user date is between start & end
       if(($user_ts >= $start_ts) && ($user_ts <= $end_ts)){

        $result=1;

       }else{
        $result=-1;
       }

       return $result;


    }



    public function updateData($url,$POSTArray){

      
      
      //Initiate cURL.
      $ch = curl_init($url);


      $jsonDataEncoded = json_encode($POSTArray);

    
       
      //Tell cURL that we want to send a PUT request.
      //url_setopt($ch, CURLOPT_PUT, 1);
       
      //Attach our encoded JSON string to the POST fields.
      curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
       
      //Set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
      //Execute the request
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // note the PUT here
      //curl_setopt($ch, CURLOPT_HEADER, true);

      $result = curl_exec($ch);

      // $resultArray=json_decode(($result),true);


      // return $resultArray;
      //curl_close($ch);
      return $result;
    }






    public function checkEmail($emailaddress)
    {

       $encodedEmail=urlencode($emailaddress);
        $url = 'http://localhost:3001/api/Logins/count?[where][emailaddress]='.$encodedEmail;
        
        $data = json_decode(file_get_contents($url), true);
        


        return $data['count'];




    }






}
