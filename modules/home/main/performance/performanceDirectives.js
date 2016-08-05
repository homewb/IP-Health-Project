/*
 * Created by Bo Wang
 */

(function() {
	'use strict';

	angular.module('performance')

	.directive('kpiPercentage', [function () {
		return {
			templateUrl: './templates/widgets/kpi/percentage.html',
			replace: true,
			restrict: 'E',
			scope: {},
			controller: function($scope, $element, $attrs) {
	
			},
			link: function postLink(scope, iElement, iAttrs) {
	
			}
		};
	}])

	.directive('kpiGraph', [function () {
		return {
			templateUrl: './templates/widgets/kpi/graph.html',
			transclude: true,
			restrict: 'E',
			scope: {},
			controller: function($scope, $element, $attrs, $timeout) {
				$scope.labels = ["January", "February", "March", 
								"April", "May", "June", "July"];
				$scope.series = ['Series A', 'Series B'];
				$scope.data = [
					[65, 59, 80, 70, 56, 55, 40],
					[28, 48, 20, 19, 20, 27, 20]
					];
				$scope.onClick = function (points, evt) {
					console.log(points);

					console.log(evt);
				};

				$timeout(function () {
					$scope.data = [
					[28, 48, 40, 19, 86, 27, 90],
					[65, 59, 80, 81, 56, 55, 40]
					];
				}, 3000);
	
			},
			link: function postLink(scope, iElement, iAttrs) {
	
			}
		};
	}])

	.directive('perfermanceTable', [
		'$filter', 'logtableService', 'perfermanceTableService', '$modal',
		function ($filter, logtableService, perfermanceTableService, $modal) {
		return {
			templateUrl: './templates/widgets/kpi/logtable.html',
			transclude: true,
			restrict: 'E',
			scope: {},
			controller: 'logtableController',
			link: function postLink(scope, iElement, iAttrs) {

				// assuming user ID is 2, but this is not going to be used
				// in retreving group titles
				var userId = '2';

				perfermanceTableService.loadGroupTitles(userId)
					.then(function(response) {
						if (response.state) {
							scope.myGroups = response.results;
							scope.load(scope.myGroups[0].id);
						}
					},
					function(response) {
						console.log(response);
					});
			}
		};
	}])
})();