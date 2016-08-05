/*
 * Created by chengchengding on 21/05/15.
 */
angular.module('hrManager')
    .controller('hrmanagerController',['$scope','adminReviewService','$filter','$http','hrService','$state',function($scope, adminReviewService,$filter,$http,hrService,$state){
        $scope.rowCollection=[];
        adminReviewService.getAllemployeeinfo().then(function(response){
            console.log(response.Data)
            $scope.rowCollection=response.Data;
            //                        $scope.displayedCollection = [].concat(response.Data);
            $scope.displayedCollection = [
                {firstName: 'Laurent', lastName: 'Renard', birthDate: new Date('1987-05-21'), balance: 102, email: 'whatever@gmail.com'},
                {firstName: 'Blandine', lastName: 'Faivre', birthDate: new Date('1987-04-25'), balance: -2323.22, email: 'oufblandou@gmail.com'},
                {firstName: 'Francoise', lastName: 'Frere', birthDate: new Date('1955-08-27'), balance: 42343, email: 'raymondef@gmail.com'}
            ];
        })

        //        $scope.$watchCollection ('rowCollection',function (newVal, oldVal) {
        //            $scope.displayedCollection = [].concat($scope.rowCollection)
        //        });

        $scope.itemsByPage=15;

        $scope.setCurrentRow= function(row){
            $scope.currentRow=row;  
            $scope.isEdit=true;
        }


        //        var package = {
        //            "emailaddress":"",
        //            "password":"",
        //            "firstname": "",
        //            "lastname": "",
        //            "birthday": "",
        //            "address": "",
        //            "phone": "",
        //            "mobile": "",
        //            "department": "",
        //            "jobtittle": "",
        //            "position": "",
        //            "photo": "",			   
        //            "permission": "",
        //            "empid": -1
        //        }

        $scope.saveProfile =function(){
            $scope.currentRow['emailaddress']=$scope.currentRow.email;
            $scope.currentRow['permission']=$scope.currentRow.permission;
            if($scope.currentRow.password != null){  
                $scope.currentRow['password']=$scope.currentRow.password;
            }
            console.log($scope.currentRow);
            if($scope.isEdit==true){
                hrService.updateProfile($scope.currentRow)
            }else{
                hrService.createProfile($scope.currentRow)
            }
        }
        $scope.deleteProfile =function(){
            console.log("deleting empid:"+$scope.currentRow.empid);
            hrService.deleteProfile({"empid":$scope.currentRow.empid})
            $state.reload();
        }
        $scope.createProfile =function(){
            $scope.currentRow=null
            $scope.isEdit=false;
        }
    }])
