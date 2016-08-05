/*
 * Created by Bo Wang
 */

(function() {
	'use strict';

	angular.module('dashboard')

	.directive('toDoList', [function () {
		return {
			templateUrl: './templates/widgets/dash/toDoList.html',
			transclude: true,
			restrict: 'E',
			scope: {},
			controller: function($scope, $element, $attrs) {
	
			},
			link: function postLink(scope, iElement, iAttrs) {
	
			}
		};
	}])

	.directive('whatIsNew', [function () {
		return {
			templateUrl: './templates/widgets/dash/whatsnew.html',
			transclude: true,
			restrict: 'E',
			scope: {},
			controller: function($scope, $element, $attrs) {
	
			},
			link: function postLink(scope, iElement, iAttrs) {
	
			}
		};
	}])

	.directive('myCalendar', [function () {
		return {
			templateUrl: './templates/widgets/dash/calendar.html',
			transclude: true,
			restrict: 'E',
			scope: {},
			controller: 'myCalendarController',
			link: function postLink(scope, iElement, iAttrs) {
	
			}
		};
	}])

	.directive('myMessage', [function () {
		return {
			templateUrl: './templates/widgets/dash/message.html',
			transclude: true,
			restrict: 'E',
			scope: {},
			controller: function($scope, $element, $attrs) {
	
			},
			link: function postLink(scope, iElement, iAttrs) {
	
			}
		};
	}])

	.directive('areaChart', [function () {
		return {
			templateUrl: './templates/widgets/dash/areaChart.html',
			transclude: true,
			restrict: 'E',
			scope: {},
			controller: function($scope, $element, $attrs, $timeout) {
				$scope.labels = ["January", "February", "March", 
								"April", "May", "June", "July"];
				$scope.series = ['Series A', 'Series B', 'Series C', 'Series D'];
				$scope.data = [
					[65, 55, 80, 81, 56, 55, 40],
					[28, 86, 40, 19, 28, 55, 90],
					[40, 48, 27, 27, 86, 40, 19],
					[55, 19, 86, 48, 59, 27, 65]
					];
				$scope.onClick = function (points, evt) {
					console.log(points, evt);
				};

				$timeout(function () {
					$scope.data = [
					[28, 48, 40, 19, 86, 27, 90],
					[65, 59, 80, 81, 56, 55, 40],
					[28, 86, 40, 19, 28, 55, 90],
					[40, 48, 27, 27, 86, 40, 19]
					];
				}, 3000);
			},
			link: function postLink(scope, iElement, iAttrs) {
	
			}
		};
	}])

	.directive('myAnnouncement', [function () {
		return {
			templateUrl: './templates/widgets/dash/announcement.html',
			transclude: true,
			restrict: 'E',
			scope: {},
			controller: function($scope, $element, $attrs) {
	
			},
			link: function postLink(scope, iElement, iAttrs) {
	
			}
		};
	}])
})();