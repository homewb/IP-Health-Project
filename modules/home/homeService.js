/**
 * The notificationService is for dynamically getting the number of 
 * unfinished peer review from the backend.
 * The Scopes is for manipulating scopes in different field. 
 *
 * @author Bo Wang
 */

(function() {
	'use strict';

	angular.module('home')

	.factory('notificationService', [
		'HTTPConnect', 'appConnectionService',
		function (HTTPConnect, appConnectionService) {
		var service = {};

		service.getGroupInfo = function(userId) {
			var url = HTTPConnect.getGroupInfoByUserId;
			var params = { employeeId : userId, groupType: "review" };
			return appConnectionService.getResponseWithParams(url, params);
		}
	
		return service;
	}])

	.factory('Scopes', [
		'$rootScope', 
		function ($rootScope) {
		var memory = {};
	
		return {
			store: function(key, value) {
				$rootScope.$emit('scope.stored', key);
				memory[key] = value;
			},
			get: function(key) {
				return memory[key];
			}
		};
	}])
})();