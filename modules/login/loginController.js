/*
 * created by Bo Wang
 * Controllers for login
 */

 (function() {
 	'use strict';

	angular.module('login')

	.controller('loginController', 
		['$scope', '$rootScope', 'loginService', '$state', 'md5', 
		function($scope, $rootScope, loginService, $state, md5){

			$scope.submitted = false;
			$scope.invalid = false;
			
			loginService.clearCredentials();

			if (!!loginService.check('username') && 
				!!loginService.check('password')) {
				$scope.user = {
					username: loginService.check('username'),
					password: loginService.check('password'),
					encrypted: true,
					remember: true,
					unchanged: false
				}
			};

			var preservedPassword = loginService.check('password');

			$scope.login = function() {

				if (($scope.user.password !== '' && 
					!$scope.user.encrypted) ||
					$scope.user.password !== preservedPassword) {
					$scope.user.password = 
						md5.createHash($scope.user.password);
				}

				loginService.login($scope.user.username, 
					$scope.user.password)
					.then(function(response) {
						if (response.state) {
							if ($scope.user.remember === true) {
								loginService.remember($scope.user.username, 
									$scope.user.password);
							}
							else {
								loginService.forget();
							}

							loginService.setCredentials(response);

							$scope.invalid = false;
							$scope.submitted = false;

							$state.go('home.dashboard');
						}
						else {
							$scope.user.username = '';
							$scope.user.password = '';
							$scope.user.remember = false;
							$scope.submitted = true;
							$scope.invalid = true;
						}
					},
					function(response) {

					});		
			}

			///////////////////////////////////
			// Test reset passwrod function //
			//////////////////////////////////

			$scope.reset = function() {
				loginService.setCredentials(
					'guest', 'guest');
			}
	}])

	.controller('resetController', 
		['$scope', 'loginService', '$state',
		function ($scope, loginService, $state) {

		$scope.reset = function() {

			loginService.clearCredentials();

			$state.go('login');
		}
		
	}])

	.controller('sendingController', 
		['$scope', 'sendingService', '$timeout', '$state',
		function ($scope, sendingService, $timeout, $state) {

		$scope.message = '';

		$scope.submit = function() {

			//
			//////////////////////
			// Only for testing //
			//////////////////////
			//
			$scope.message = 'success';

			$timeout(function() {

				$state.go('login');
			}, 2000);

			// sendingController.sendEmail($scope.email, function(response) {
			// 	if (response.state === 'success') {

			// 	}
			// 	else {

			// 	}
			// })
		}

		
		
	}])
	
 })();
