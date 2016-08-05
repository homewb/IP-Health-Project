/**
 * This file only has one controller, which is used to control the scope of 
 * employee peer review page (./templates/peerreview.html). The modal in this
 * page has now switched to AngularStrap instead of using angular-ui-bootstrap.
 * Some services in this controller are from peerReviewService 
 * (./modules/home/main/review/peerReviewService.js).
 *
 * @author Bo Wang
 */

(function() {
	'use strict';

	angular.module('peerReview')
	.controller('peerReviewController', [
		'$scope', '$cookieStore', 'reviewTableService', 'Scopes',
		function($scope, $cookieStore, reviewTableService, Scopes){

		var user = $cookieStore.get('globals');

		var init = function(userId) {
			reviewTableService.getGroupInfo(userId)
			.then(function(response) {
				if (response.state) {
					$scope.myGroups = response.data;
					$scope.myGroups[0].active = true;
					var groupId = $scope.myGroups[0].groupid;
					load(groupId, $scope.myGroups[0].incomplete);
				}
			},
			function(response) {
				//console.log(response);
			});
		}

		// reviewTableService.getGroupInfo(user.id)
		// 	.then(function(response) {
		// 		//console.log(response);
		// 		if (response.state) {
		// 			$scope.myGroups = response.data;
		// 			$scope.myGroups[0].active = true;
		// 			var groupId = $scope.myGroups[0].groupid;
		// 			load(groupId, $scope.myGroups[0].incomplete);
		// 		}
		// 	},
		// 	function(response) {
		// 		//console.log(response);
		// 	});

		$scope.reload = function(group) {
			load(group.groupid, group.incomplete);
		}

		var load = function(groupId, incomplete) {
			var kpis = [];
			$scope.submitted=false;
			reviewTableService.loadKpiIds(groupId)
				.then(function(response) {
					var currentKpi = 0;
					kpis = response.data;
					currentKpi = kpis.length - incomplete;
					if (kpis.length > currentKpi) {
						loadTable(groupId, kpis[currentKpi], user.id);
					}
					else {
						$scope.submitted=true;
					}

				},
				function(response) {
					//console.log(response);
				});
		}

		var loadTable = function(groupId, kpi, userId) {
			var myReviewData = {};
			var kpiId = kpi.performanceinfoid;
			myReviewData.title = kpi.performancetypename;
			myReviewData.description = kpi.performancedescription;
			$scope.myReview = myReviewData;

			reviewTableService.loadTable(groupId, kpiId, userId)
				.then(function(response) {
					if (response.state) {
						$scope.myReview.groupId = groupId;
						$scope.myReview.rows = response.data;
					}				
				},
				function(response) {
					//console.log(response);
				});
		}

		init(user.id);

		var submitData = {};

		$scope.submit = function(group) {
			reviewTableService.updateReview($scope.myReview)
				.then(function(response) {
					//console.log(response);
				},
				function(response) {
					//console.log(response);

					// the PHP will response false, 
					// whatever the submit has been successful or not
					Scopes.get('navigationController').updateReviewNotice();
				});

			group.incomplete--;
			load(group.groupid, group.incomplete);
		}

		//rating controller
        $scope.rate = 0;
        $scope.max = 5;
        $scope.isReadonly = false;

        $scope.hoveringOver = function(value) {
            $scope.overStar = value;
            $scope.percent = 100 * (value / $scope.max);
        };

	}])

})();

