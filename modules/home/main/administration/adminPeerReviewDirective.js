/*
* Created by Bo Wang
*/

(function() {
	'use strict';

	angular.module('adminPeerReview')
		.directive('graphCanvasRefresh', ['$compile', function($compile) {
			function link(scope, elem, attrs) {

				function refreshDOM() {
					//var markup = '<canvas class="chart chart-pie" id="graph" data="entityGraph.data" labels="entityGraph.labels" legend="true" colours="graphColours" ></canvas>';
					var markup = '<canvas id="bar" class="chart chart-bar" data="data" labels="labels"></canvas>';
					var el = angular.element(markup);
					compiled = $compile(el);
					elem.html('');
					elem.append(el);
					compiled(scope);
				};

				// Refresh the DOM when the attribute value is changed
				scope.$watch(attrs.graphCanvasRefresh, function(value) {
					refreshDOM();
				});

				// Clean the DOM on destroy
				scope.$on('$destroy', function() {
					elem.html('');
				});
			};

			return  {
				link: link
			};
		}])
	.directive('adminPeerReview', [
		'adminReviewTableProvider',
		function (adminReviewTableProvider) {

		return {
			templateUrl: './templates/widgets/admin/adminPeerReviewTable.html',
			transclude: true,
			restrict: 'E',
			scope: {},
			controller: 'adminPeerReviewController',
			link: function postLink(scope, iElement, iAttrs) {

			}
		};
	}])
})();