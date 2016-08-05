/*
 * Created by Bo Wang
 */

(function() {
	'use strict';

	angular.module('adminPeerReview')

		.factory('adminReviewTableProvider',  [
			'HTTPConnect', 'appConnectionService',
			function (HTTPConnect, appConnectionService) {
				var service = {};

				service.getGroupInfo = function(userId) {
					var url = HTTPConnect.getGroupInfoByUserId;
					var params = { employeeId : userId };
					//console.log(appConnectionService.getResponseWithParams(url, params))
					return appConnectionService.getResponseWithParams(url, params);
				}

				service.updateReview = function(data) {
					var url = HTTPConnect.submitPeerReviewTable;
					var params = data;
					return appConnectionService.getResponseWithParams(url, params);
				}

				service.getAllReviewGroups = function() {
					var url = HTTPConnect.retriveAdminReviewGroup;
					var params = { groupType : 'review' };
					return appConnectionService.getResponseWithParams(url, params);

				}

				service.getReviewGroupData = function(groupId) {
					var url = HTTPConnect.retriveAdminReviewGroupData;
					var params = { groupid : groupId };
					return appConnectionService.getResponseWithParams(url, params);
				}

				service.updateReview = function(data) {
					var url = HTTPConnect.submitPeerReviewTable;
					var params = data;
					return appConnectionService.getResponseWithParams(url, params);
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

				//for create/edit modal
				service.createReviewGroup = function(data) {
					var url = HTTPConnect.createAdminReviewGroup;
					var params = data;
					return appConnectionService.getResponseWithParams(url, params);
				}
                service.updateReviewGroup = function(data) {
					var url = HTTPConnect.updateAdminReviewGroup;
					var params = data;
					return appConnectionService.getResponseWithParams(url, params);
				}
				service.getReviewGroup = function(data){
					var url = HTTPConnect.getAdminReviewGroup;
					var params = {"groupid":data};
					return appConnectionService.getResponseWithParams(url, params);
				}
                service.deleteReviewGroup = function(data){
					var url = HTTPConnect.deleteAdminReviewGroup;
					var params = {"groupid":data};
                    console.log(params);
					return appConnectionService.getResponseWithParams(url, params);
				}

				return service;
			}])
})();