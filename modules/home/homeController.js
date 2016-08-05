/*
 * Created by Bo Wang, by using ngIdle Api.
 */

(function() {
	'use strict';

	angular.module('home')

	.controller('homeController', 
		['$scope', 'Idle', 'Keepalive', 'ngDialog', 'notificationService', '$cookieStore',
		function ($scope, Idle, Keepalive, ngDialog, notificationService, $cookieStore) {

		Idle.watch();

		var closeAllDialogs = function() {
			ngDialog.closeAll();
		}

		$scope.$on('IdleStart', function() {

	        ngDialog.open({
	            templateUrl: './templates/dialogs/idleWarningModal.html',
	            showClose: false,
	            controller: ['$scope', '$state', function($scope, $state) {
	            }]
	        });
	    });

	    $scope.$on('IdleEnd', function() {
    		closeAllDialogs();
    	});

	    $scope.$on('IdleTimeout', function() {

	        ngDialog.open({
	            templateUrl: './templates/dialogs/timeoutModal.html',
	            showClose: false,
	            controller: ['$scope', '$state', 'loginService', '$timeout', 
	            	function($scope, $state, loginService, $timeout) {
	            	
	            	
	            	loginService.clearCredentials();
					$state.go('login');

					$timeout(function() {
						closeAllDialogs();
					}, 2000);

	            }]            
	        });
	    });
		
	}])

	.config(['IdleProvider', 'KeepaliveProvider', 'CustIdleTime',
		function(IdleProvider, KeepaliveProvider, CustIdleTime) {
		    IdleProvider.idle(CustIdleTime.idle);
		    IdleProvider.timeout(CustIdleTime.timeout);
		    KeepaliveProvider.interval(CustIdleTime.interval);
    }]);
})();