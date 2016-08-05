/**
 * Created by chengchengding on 15/05/15.
 */


angular.module('peerReview')

    .controller('myReviewController', [
        '$scope', '$cookieStore', 'myReviewService', '$modal',
        function($scope, $cookieStore, myReviewService, $modal){
            var user = $cookieStore.get('globals');
            var currentKpi = 0;  // count the number of finished kpi peer review
            $scope.hasReview = false
            myReviewService.getGroupInfo(user.id)
                .then(function(response) {
                    console.log(response);
                    if (response.state) {
                        $scope.myGroups = response.data;
                        $scope.myGroups[0].active = true;
                        var groupId = $scope.myGroups[0].groupid;
                        load(groupId, user.id);
                    }
                },
                function(response) {
                    //console.log(response);
                });

            $scope.reload = function(groupId) {
                currentKpi = 0;
                load(groupId,user.id);
            }

            var load = function(groupId, empId) {
                //console.log("groupid: "+groupId + " empid: "+ empId)
                var table = [];
                myReviewService.loadTable(groupId,empId)
                    .then(function(response) {
                        table = response.data;
                        //console.log(table)
                        $scope.kpis = table
                        //console.log($scope.kpis[0]['avgValue'] > 0)
                            $scope.hasReview = $scope.kpis[0]['avgValue'] > 0
                    },
                    function(response) {
                        //console.log(response);
                    });

            }


        }])