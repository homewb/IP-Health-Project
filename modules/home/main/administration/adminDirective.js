/*
 * Created by Bo Wang
 */

(function() {
	'use strict';

	angular.module('administration')

	.directive('adminTeachingTable', [
		'adminPerformanceService', 
		function (adminPerformanceService) {

		return {
			templateUrl: './templates/widgets/admin/admintable.html',
			transclude: true,
			restrict: 'E',
			scope: {},
			controller: 'adminTableController',
			link: function postLink(scope, iElement, iAttrs) {

				// assuming user ID is 2, but this is not going to be used
				// in retreving group titles
				var userId = '1';

				adminPerformanceService.loadGroupTitles(userId)
					.then(function(response) {
						if (response.state) {
							scope.myGroups = response.results;
							scope.myGroups[0].active = true;
							scope.load(scope.myGroups[0].id);
						}
					},
					function(response) {
						//console.log(response);
					});
			}
		};
	}])
})();