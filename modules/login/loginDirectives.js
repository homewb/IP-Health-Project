/*
 *
 */

(function() {
	'use strict';

	angular.module('login')

	.directive('mustInput', [function () {
		var status = false;

		return {
			restrict: 'A',
			require: 'ngModel',
			link: function (scope, Element, Attrs, ngModel) {
				if (Element.value !== '') {
					status = true;
					ngModel.$setValidity('inputBlank', status);
				}
				else {
					status = false;
					ngModel.$setValidity('inputBlank', status);
				}

				ngModel.$parsers.push(function(value) {
					status = true;
					if (value === '') {
						status = false;
					}
					
					ngModel.$setValidity('inputBlank', status);
					return value;
				});
			}
		};
	}])

	.directive('passCheck', [function () {
		return {
			require: 'ngModel',
			link: function (scope, element, attrs, controllers) {
				var me = attrs.ngModel;
				var compareTo = attrs.passCheck;

				scope.$watchGroup([me, compareTo], function(value) {
					controllers.$setValidity('passmatch', value[0] === value[1]);
				})
				
			}
		};
	}])
	
})();