/*
 * Created by Bo Wang
 * Services for login
 */

 (function() {
 	'use strict';

	angular.module('login')

	.factory('loginService', 
		['$rootScope', '$cookieStore', 'HTTPConnect', 'appConnectionService',
		function ($rootScope, $cookieStore, HTTPConnect, appConnectionService) {
		var service = {};

		service.login = function(username, password) {
			var url = HTTPConnect.login;
			var params = {
				username: username,
				password: password
			}
			return appConnectionService.getResponseWithParams(url, params);
		};

		//
		//////////////////////////
		// Low security version //
		//////////////////////////
		//
		service.isAuthorised = function() {

			return !!$rootScope.globals.currentUser;
		}

		service.setCredentials = function(currentUser) {

			$rootScope.globals = currentUser;

			//
			//////////////////////////
			// Low security version //
			//////////////////////////
			//
			$cookieStore.put('globals', $rootScope.globals);

		}

		service.clearCredentials = function () {
            $rootScope.globals = {};
            $cookieStore.remove('globals');
        }

        /*
         * Use cookies service to automatically login 
         */
        service.remember = function(username, password) {
			$cookieStore.put('username', username);
			$cookieStore.put('password', password);
		}

		service.check = function(name) {
			
			return $cookieStore.get(name);
		}

		service.forget = function() {
			$cookieStore.remove('username');
			$cookieStore.remove('password');
		}

		return service;
	}])

	.factory('sendingService', 
 		[function () {

 		var service = {};

 		service.sendEmail = function(email) {
 			$http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
			$http.post('/email.php', {email: email})
				.success(function(response) {

					callback(response);
				})
				.error(function(response) {

					callback(response);
				});
 		}
 		
 		return service;
 	}])

 })();
