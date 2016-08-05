/*
 * Created by Bo Wang
 */

 (function() {
 	'use strict';

	angular.module('header')

	.controller('headerController', 
		['$scope', '$rootScope', 'loginService', '$state', 
		function ($scope, $rootScope, loginService, $state) {

			$scope.username = $rootScope.globals.username;

			$scope.myProfile = function() {

				$state.go('home.profile');
			}

			
			$scope.logout = function() {
				
				loginService.clearCredentials();

				$state.go('login');
			}
		
	}]);
})();



 