/*
 * Created by Bo Wang
 */

 (function() {
 	'use strict';

 	angular.module('profile')
 	.factory('profileService', 
 		['$cookieStore', '$http', 'HTTPConnect', 'appConnectionService',
 		function ($cookieStore, $http, HTTPConnect, appConnectionService) {
 		var service = {};

 		service.getProfile = function(currentUserId) {
 			var url = HTTPConnect.getProfile;
 			var params = {id: currentUserId};
 			return appConnectionService.getResponseWithParams(url, params);
 		};

 		service.updateProfile = function(userInfo) {
 			var url = HTTPConnect.updateProfile;
 			return appConnectionService.getResponseWithParams(url, userInfo);
 		};
 	
 		return service;
 	}])

	.factory('GoogleService', 
		['$http', 
		function ($http) {

		var service = {};

		service.geogode = function(address, callback) {
			var params = {address: address, sensor: false};
			return $http.get(
				'http://maps.googleapis.com/maps/api/geocode/json',
				{params: params}
			).then(function(response) {
				callback(response);
			});
		}		
	
		return service;
	}])
 })();