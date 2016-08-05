/*
 * Created by Bo Wang
 */

(function() {
	'use strict';

	angular.module('administration')

	.filter('display', function() {
		return function(rows, displayModel) {
			var filtered = [];
			if (angular.equals(displayModel, 'all')) {
				angular.forEach(rows, function(row) {
					filtered.push(row);
				});
			}
			else if (angular.equals(displayModel, 'pending')) {
				angular.forEach(rows, function(row) {
					var isPending = false;
					angular.forEach(row.columns, function(column) {
						if (angular.equals(column.status, 'pending')) {
							isPending = true;
						}
					});

					if (isPending) {
						filtered.push(row);
					}
				})
			}
			else {
				angular.forEach(rows, function(row) {
					var isHistory = false;
					angular.forEach(row.columns, function(column) {
						if (!angular.equals(column.status, 'pending')) {
							isHistory = true;
						}
						else {
							isHistory = false;
						}
					})

					if (isHistory) {
						filtered.push(row);
					}
				})
			}

			return filtered;
		}
	})
})();