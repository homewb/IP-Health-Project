/**
 * Created by Bo Wang
 */
(function() {
	'use strict';

	angular.module('peerReview')
	.factory('reviewTableService', [
		'HTTPConnect', 'appConnectionService',
		function (HTTPConnect, appConnectionService) {
		var service = {};

		service.getGroupInfo = function(userId) {
			var url = HTTPConnect.getGroupInfoByUserId;
			var params = { employeeId : userId, groupType: "review" };
			return appConnectionService.getResponseWithParams(url, params);
		}

		service.loadKpiIds = function(groupId) {
			var url = HTTPConnect.getKpiInfoByGroupId;
			var params = { groupid : groupId };
			return appConnectionService.getResponseWithParams(url, params);
		}

		service.loadTable = function(groupId, kpiId, userId) {
			var url = HTTPConnect.createPeerReviewTable;
			var params = { 
				groupId : groupId, 
				performanceInfoId : kpiId, 
				employeeId :userId
			};
			return appConnectionService.getResponseWithParams(url, params);
		}

		service.updateReview = function(data) {
			var url = HTTPConnect.submitPeerReviewTable;
			var params = data;
			//console.log(params);
			return appConnectionService.getResponseWithParams(url, params);
		}
	
		return service;
	}])
})();
