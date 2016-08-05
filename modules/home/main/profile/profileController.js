/*
 * Created by Bo Wang
 */

(function() {
	'ues strict';

	angular.module('profile')

	.constant('UpdateStatus', {
		failed: '0',
		success: '1',
		alert: '2'
	})

	.controller('profileController', 
		['$scope', '$cookieStore', 'profileService', 'GoogleService', '$timeout',
		'UpdateStatus', '$filter', '$state',
		function($scope, $cookieStore, profileService, GoogleService, $timeout, 
			UpdateStatus, $filter, $state){

		$scope.address = {};

		$scope.showAddress = false;
		$scope.drop = function() {
			$scope.showAddress = !$scope.showAddress;
		}

		$scope.submitted = false;
		$scope.interacted = function(field) {
			return $scope.submitted || field.$dirty;
		}

		var showMessage = function(index) {
			$scope.submitted = true;
			var alerts = [
				{ type: 'danger', msg: 'Update failed.' },
				{ type: 'success', msg: 'Profile has been updated.' },
				{ type: 'alert', msg: 'Unable to load profile.' }
			];

			$scope.alert = alerts[index];
			$scope.showMsg = true;

			$timeout(function() {

				$scope.showMsg = false;
				$scope.submitted = false;
			}, 10000);
		}
		var user = $cookieStore.get('globals');

		profileService.getProfile(user.id)
			.then(function(response) {
				var userInfo = {
						firstname: response.firstname,
						lastname: response.lastname,
						position: response.position,
						email: user.email,
						department: response.department,
						dob: response.birthday,
						address: response.address,
						mobile: response.phone1,
						phone: response.phone2,
						photo: user.photo
					};
				$scope.userInfo = userInfo;
				$scope.currentAddress = userInfo.address;

				// Convert date format from string to date object
				$scope.userInfo.birth = new Date(userInfo.dob);
			},
			function(response) {

			})

		$scope.refreshAddresses = function(address) {
			GoogleService.geogode(address, function(response) {
				$scope.addresses = response.data.results
			});
		};

		$scope.submit = function() {
			var address = {};

			if (!!$scope.address.selected) {
				address = $scope.address.selected.formatted_address; 
			}
			else {
				address = $scope.currentAddress;
			}

			var newUserInfo = {
				id: user.id,
				firstname: $scope.userInfo.firstname,
				lastname: $scope.userInfo.lastname,
				birthday: $scope.userInfo.birth,
				address: address,
				mobile: $scope.userInfo.mobile,
				phone: $scope.userInfo.phone
			}

			// Convert date format from date object to string
			newUserInfo.dob = $filter('date')(newUserInfo.dob, "yyyy-MM-dd");
			
			profileService.updateProfile(newUserInfo)
				.then(function(response) {
					showMessage(UpdateStatus.success);
				},
				function(response) {
					showMessage(UpdateStatus.failed);
				});
		}

		$scope.confirm = function() {
			$state.go('home.dashboard');
		}
	}])
})();