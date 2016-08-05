/*
 * Created by Bo Wang
 * Controller for navigation bar
 */


(function() {
	'use strict';

	angular.module('navigator')

	.constant('USER_ROLE', {
		admin: 'A',
		hrManager: 'H',
		staff: 'S'
	})

	.controller('navController', 
		['$rootScope', '$scope', '$cookieStore', 'USER_ROLE', 'Scopes', 'notificationService',
		function($rootScope, $scope, $cookieStore, USER_ROLE, Scopes, notificationService){

		Scopes.store('navigationController', $scope);

		// Identify user permission
		$rootScope.globals = $cookieStore.get('globals');
		var currentUserRole = $rootScope.globals.permission;

		$scope.totalReviewNotice = 0;

		var user = $cookieStore.get('globals');

		notificationService.getGroupInfo(user.id)
			.then(function(response) {
				var notification = [];
				angular.forEach(response.data, function(obj) {
					notification.push(obj.incomplete);

					$scope.totalReviewNotice += obj.incomplete;
				})
			},
			function(response) {
				//console.log("get group error");
			});

		$scope.isHrManager = function() {
			return currentUserRole === USER_ROLE.hrManager ||
				currentUserRole === USER_ROLE.admin;
		};

		$scope.isAdministrator = function() {
			return currentUserRole === USER_ROLE.admin;
			//return true;

		};

		$scope.updateReviewNotice = function() {
			$scope.totalReviewNotice = 0;

			var user = $cookieStore.get('globals');

			notificationService.getGroupInfo(user.id)
				.then(function(response) {
					var notification = [];
					//console.log(response);
					angular.forEach(response.data, function(obj) {
						notification.push(obj.incomplete);

						$scope.totalReviewNotice += obj.incomplete;
					})

					//console.log(notification);
				},
				function(response) {
					//console.log("get group error");
				});

		}

	}])
})();