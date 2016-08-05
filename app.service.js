/**
 * Created by Bo Wang
 */

(function() {
	'use strict';

	angular.module('appService')

	.factory('appConnectionService', [
		'$http', '$q', 
		function ($http, $q) {
			var service = {};

			service.getResponseWithParams = function(url, params) {
				var deferred = $q.defer();

				$http.post(url, params)
					.success(function(response) {
						deferred.resolve(response);
					})
					.error(function(response) {
						deferred.reject('Server Error!');
					})

				return deferred.promise;
			}

			service.getResponseWithoutParams = function(url) {
				var deferred = $q.defer();

				$http.post(url)
					.success(function(response) {
						deferred.resolve(response);
					})
					.error(function(response) {

						deferred.reject('Server Error!');
					})

				return deferred.promise;
			}

			service.getResponseFromJsonData = function(url) {
				var deferred = $q.defer();

				$http.get(url)
					.success(function(response) {
						deferred.resolve(response);
					})
					.error(function(response) {

						deferred.reject('JSON file Error!');
					})

				return deferred.promise;
			}
	
		return service;
	}])
})();