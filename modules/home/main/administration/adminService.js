/*
 * Created by Bo Wang
   contributed by Xiao Zhang
 */

(function() {
	'use strict';

	angular.module('administration')

	.factory('adminPerformanceService', [
		'HTTPConnect', 'appConnectionService',
		function (HTTPConnect, appConnectionService) {
		var service = {};

		service.loadGroupTitles = function(id) {
			var url = HTTPConnect.getAllPerformanceGroup;
			return appConnectionService.getResponseFromJsonData(url);
		}

		service.loadTable = function(groupId) {
			//-------------------------------------------
			// Using http.GET to test with local JSON data
			//
			if (angular.equals(groupId, '3001')) {
				var url = HTTPConnect.getTeachingGroupPerformance;
				return appConnectionService.getResponseFromJsonData(url);
			}
			else if (angular.equals(groupId, '3002')) {
				var url = HTTPConnect.getResearchGroupPerformance;
				return appConnectionService.getResponseFromJsonData(url);
			}
			//-------------------------------------------
		}
		
	
		return service;
	}])

	.factory('adminReviewService', [
		'HTTPConnect', 'appConnectionService', 
		function (HTTPConnect, appConnectionService) {

		var service = {};

		service.getIndividualDetail = function(userId, groupId) {
			var url = HTTPConnect.retriveIndividualDetails;
			var params = { 
				reviewForEmployeeId : userId,
				groupId: groupId
			};
			return appConnectionService.getResponseWithParams(url, params);
		}

		service.getIndividualKpi = function(userId, groupId, kpiId) {
			var url = HTTPConnect.retriveIndividualKpi;
			var params = { 
				reviewForEmployeeId : userId,
				groupId : groupId,
				performanceInfoId : kpiId
			};
			return appConnectionService.getResponseWithParams(url, params);
		}

		service.submitFeedback = function(feedback) {
			var url = HTTPConnect.submitAdminReviewFeedback;
			return appConnectionService.getResponseWithParams(url, feedback);
		}

		service.getAllemployeeinfo = function(){
			var url = HTTPConnect.retriveAdminallstaffinfodata;
			var params ={
				require : "all"
			};
			return appConnectionService.getResponseWithParams(url, params);
		}
        service.createReviewGroup = function(data) {
            var url = HTTPConnect.createAdminReviewGroup;
            var params = data;
            return appConnectionService.getResponseWithParams(url, params);
        }

		return service;
	}])
})();