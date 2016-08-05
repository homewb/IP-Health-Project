/*
 * Created by Bo Wang
 */

(function() {
	'use strict';

	angular.module('profile')

	.directive('nameCharactersValidator', [function () {
		var NAME_FORMAT = /^[a-zA-Z]+$/;

		return {
			restrict: 'A',
			require: 'ngModel',
			link: function (scope, Element, Attrs, ngModel) {
				ngModel.$parsers.push(function(value) {
					var status = true;
					
					status = status && NAME_FORMAT.test(value);
					ngModel.$setValidity('name-characters', status);
					return value;
				});
			}
		};
	}])

	.directive('phoneNumberValidator', [function () {
		// var PHONE_NUMBER_FORMAT = /\d{2}-\d{4}-\d{4}/;
		var PHONE_NUMBER_FORMAT = /\d{10}/;

		return {
			restrict: 'A',
			require: 'ngModel',
			link: function (scope, iElement, iAttrs, ngModel) {
				ngModel.$parsers.push(function(value) {
					var status = true;
					
					status = status && PHONE_NUMBER_FORMAT.test(value);
					ngModel.$setValidity('phone-numbers', status);
					return value;
				});				
			}
		};
	}])
})();