/**
 * Created by Bo Wang
 */
(function() {
    'use strict';

    angular.module('peerReview')
        .factory('myReviewService', [
            'HTTPConnect', 'appConnectionService',
            function (HTTPConnect, appConnectionService) {
                var service = {};

                service.getGroupInfo = function(userId) {
                    var url = HTTPConnect.getGroupInfoByUserId;
                    var params = { employeeId : userId, groupType: "ALL" };
                    return appConnectionService.getResponseWithParams(url, params);
                }

                service.loadTable = function(groupId, userId) {
                    var url = HTTPConnect.retriveMyReviewData;
                    var params = {
                        groupid : groupId,
                        empid :userId
                    };
                    return appConnectionService.getResponseWithParams(url, params);
                }

                return service;
            }])
})();
