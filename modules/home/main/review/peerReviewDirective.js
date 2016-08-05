/**
 * Created by Bo Wang
 * This directive is used for checking if user has given a valid 
 * score to each kpis. If the rating symbol (stars) had not been
 * ticked, user would not be allowed to go to next page.
 */

(function() {
	'use strict';

	angular.module('peerReview')
	.directive('ratingRequired', [function () {
		var status = false;
		return {
			restrict: 'A',
			require: 'ngModel',
			link: function (scope, Element, Attrs, ngModel) {
				if (scope.row.reviewdata == 0) {
					status = false;
					ngModel.$setValidity('validRating', status);
				}

				ngModel.$parsers.push(function(value) {
					if (value >= 1 || value <= 5) {
						status = true;
					}
					
					ngModel.$setValidity('validRating', status);
					return value;
				});
				
			}
		};
	}])
})();