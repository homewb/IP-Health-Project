/*
 * Created by Bo Wang
 */

(function() {
	'use strict';

	angular.module('performance')

	.factory('logtableService', ['$filter', function ($filter) {

		var service = {};

		service.getAutoNumber = function() {

			// Currently, this function is only for local test, by
			// generating a random number between 1 to 30. However,
			// in the further work, this function should be replaced
			// by more reasonable one, which is able to get the number
			// from remote database.

			return Math.floor((Math.random() * 30) + 1);
		}

		service.getNewDate = function(data) {

			// This function is only for local test and the latest date
			// shouled be provided by remote database in the further work.

			// var date = new Date(data[data.length - 1].date);

			// Get current date
			var date = new Date();
			date.setDate(date.getDate() + 1);
			return $filter('date')(date, "yyyy-MM-dd");
		}
	
		return service;
	}])

	.factory('perfermanceTableService', [
		'HTTPConnect', 'appConnectionService',
		function (HTTPConnect, appConnectionService) {
		var service = {};

		service.loadGroupTitles = function(id) {
			var url = HTTPConnect.getEmployeePerformanceGroup;
			return appConnectionService.getResponseFromJsonData(url);
		}
		
		service.loadTable = function(groupId) {
			var url = HTTPConnect.getEmployeePerformanceDetails;
			return appConnectionService.getResponseFromJsonData(url);
		}
	
		return service;
	}])
})();