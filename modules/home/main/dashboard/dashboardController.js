/*
 *
 */

(function() {
	'use strict';

	angular.module('dashboard')


	.controller('dashboardController', 
		['$scope', 
		function ($scope) {

		$scope.preference = {
			showState: true,
			showCalendar: true,
			showMessages: true,
			showChart: true,
			showTodo: true,
			showAnnounce: true
		}

		$scope.state = function() {
			$scope.preference.showState = 
				!$scope.preference.showState;
		}

		$scope.calendar = function() {
			$scope.preference.showCalendar = 
				!$scope.preference.showCalendar;
		}

		$scope.messages = function() {
			$scope.preference.showMessages = 
				!$scope.preference.showMessages;
		}

		$scope.charts = function() {
			$scope.preference.showChart = 
				!$scope.preference.showChart;
		}

		$scope.todo = function() {
			$scope.preference.showTodo = 
				!$scope.preference.showTodo;
		}

		$scope.announce = function() {
			$scope.preference.showAnnounce = 
				!$scope.preference.showAnnounce;
		}
		
	}])
})();