/*
 * Created by chengchengding on 21/05/15.
 */
angular.module('findStaff')
    .controller('findStaffController',['$scope', 'adminReviewService',function($scope,adminReviewService){

            adminReviewService.getAllemployeeinfo(
            ).then(function(response){
                    $scope.response = response;
                    var data = response.Data;                
                    //console.log(data);
                    //length = response.Data.length;
                    $scope.employees=[];
                    for (var i=0; i<data.length; i++){
                        $scope.employees.push(
                            {
                                "name":data[i].firstname+" "+data[i].lastname,
                                "position":data[i].jobtittle,
                                "department":data[i].department,
                                "empId":data[i].empid
                            }
                        )
                    }
                    //console.log($scope.employees)
                },
                function(response){
                    //console.log(response);
                })
    }])
    .controller('findStaffDetailController',['$scope', 'adminReviewService','$stateParams',function($scope,adminReviewService,$stateParams){
        
        $scope.whichId = $stateParams.id;
        //console.log($scope.whichId);
        adminReviewService.getAllemployeeinfo().then(function(response){
            $scope.employees = response.Data;
            if ($stateParams.id > 0) {
              $scope.prevstaff =  $stateParams.id - 1;
            } else {
              $scope.prevstaff = $scope.employees.length - 1;
            }

            if ($stateParams.id < $scope.employees.length - 1) {
              $scope.nextstaff = parseInt($stateParams.id) + 1;
            } else {
             $scope.nextstaff = 0;             
            }
        },
        function(response){
            //console.log(response);
        })


    }])

