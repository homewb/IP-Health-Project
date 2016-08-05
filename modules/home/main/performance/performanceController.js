/*
 * Created by Bo Wang
 */

(function() {
	'use strict';

	angular.module('performance')

	.controller('performanceController', ['$scope', function($scope){
		$scope.widgetTitle = 'My Performance';
		
	}])

	.controller('logtableController', [
		'$scope', '$filter', 'logtableService', 'perfermanceTableService', '$modal',
		function($scope, $filter, logtableService, perfermanceTableService, $modal){

		$scope.isEditable = function(status) {
			return angular.equals(status, 'rejected');
		}

		$scope.isApproved = function(status) {
			return angular.equals(status, 'approved');
		}

		$scope.isPending = function(status) {
			return angular.equals(status, 'pending');
		}

		$scope.isAuto = function(status) {
			return angular.equals(status, 'auto');
		}

		$scope.updateColumn = function(data, column) {
			console.log('in controller(Column):');
			var regex = /^[0-9]+$/;
			console.log(data);
			if (!regex.test(data)) {
				return 'Must be a number';
			}
			column.status = "pending";
			console.log('Updating current data...');
			console.log(column.status);
			console.log(column);
		}

		$scope.load = function(groupId) {
			perfermanceTableService.loadTable(groupId)
				.then(function(response) {
					if (response.state) {
						$scope.myTableTitle = response.titles;
						$scope.myTableData = response.rows;
					}
				},
				function(response) {
					console.log(response);
				});
		}

		$scope.openAddNewModal = function() {
			var modalInstance = $modal.open({
				templateUrl: './templates/dialogs/logTableAddNewModal.html',
				controller: 'logtableModalController',
				resolve: {
					titles: function() {
						return $scope.myTableTitle;
					}
				}
			});
		}
	}])

	.controller('logtableModalController', [
		'$scope', '$modalInstance', 'titles', 'logtableService',
		function ($scope, $modalInstance, titles, logtableService) {
		$scope.newData = {};
		$scope.newData.columns = new Array(titles.length-1);

		$scope.titles = titles;
		$scope.newData.date = logtableService.getNewDate();

		$scope.getNumber = function(num) {
		    return new Array(num);   
		}

		$scope.ok = function() {
			console.log($scope.newData);
		}

		$scope.close = function() {
			$modalInstance.dismiss('cancel');
		}

		
	}])
})();