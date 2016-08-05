/**
 * Created by chengchengding on 9/05/15.
 *
 * *! This controller has no longer been used. -- Bo !*
 */
angular.module('adminPeerReview')
    .controller("adminPeerReviewDetailController",function($scope){
        //rating controller
        $scope.rate = 0;
        $scope.max = 5;
        $scope.isReadonly = false;

        $scope.hoveringOver = function(value) {
            $scope.overStar = value;
            $scope.percent = 100 * (value / $scope.max);
        };


        //radar chart
        $scope.labels =["Coding Style", "Communication", "Code Efficiency", "Creativity"];
        $scope.data = [
            [4, 2, 3, 4],
            [5, 5, 5, 5]
        ];
    })