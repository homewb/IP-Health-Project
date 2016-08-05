/**
 * Created By Bo Wang, 
 * Contributed by chengchengding
 */

(function() {
	'use strict';

	angular.module('administration')

	.controller('adminController', ['$scope', function ($scope) {
		
	}])

	.controller('adminTableController', [
		'$scope', '$modal', 'adminPerformanceService', '$timeout',
		function ($scope, $modal, adminPerformanceService, $timeout) {
		$scope.statuses = [
			{value: 'approved', text: 'Approve'},
			{value: 'rejected', text: 'Reject'}
		];
		$scope.displayModel = "all";

		$scope.isEditable = function(status) {
            return angular.equals(status, 'pending');
		};

		$scope.isRejected = function(status) {
            return angular.equals(status, 'rejected');
		};

		$scope.updateStatus = function(data) {
			//console.log('in controller(Column1):');
			//console.log(data);
		};

		$scope.load = function(groupId) {
			$scope.isLoading = true;
			adminPerformanceService.loadTable(groupId)
				.then(function(response) {
					$scope.myTableTitle = response.titles;
					$scope.myTableData = response.data;
				},
				function(response) {
					//console.log(response);
				});

			$timeout(function() {
				$scope.isLoading = false;
			}, 2000);
		}

		var upload = function() {
			//console.log('uploading...');
			//console.log($scope.myTableData);
		}

		$scope.openSubmitModal = function() {
			var modalInstance = $modal.open({
				templateUrl: './templates/dialogs/adminTableSubmitModal.html',
				backdrop: 'static',
				controller: function($scope, $modalInstance) {
					$scope.ok = function() {
						upload();
						$modalInstance.close();
					}

					$scope.close = function() {
						$modalInstance.dismiss('cancel');
					}
				}
			})
		}

		$scope.showAll = function() {
			$scope.displayModel = "all";
		}

		$scope.showPending = function() {
			$scope.displayModel = "pending";
		}

		$scope.showHistory = function() {
			$scope.displayModel = "history";
		}
	}])

	.controller('adminIndiviReviewController', [
        '$scope', '$stateParams', '$state', 'adminReviewService', 
        'reviewTableService', '$cookieStore',
        function ($scope, $stateParams, $state, adminReviewService, 
            reviewTableService, $cookieStore) {
        var user = $cookieStore.get('globals');  // get current login user
        var userId = $stateParams.id;    // load uesr_id
        var groupId = $stateParams.gid;  // load group_id
        var kpiId = $stateParams.kid;    // load kip_id

        $scope.myReview = {};
        adminReviewService.getIndividualDetail(userId, groupId)
            .then(function(response) {

                $scope.fullName = response.fullName;

                for (var i = 0; i < response.data.length; i++) {
                    if (parseInt(kpiId) === response.data[i].performanceinfoid) {
                        $scope.kpiName = 
                            response.data[i].performancetypename;
                        $scope.kpiAvgScore = 
                            response.data[i].averageData;
                        $scope.myReview.title = 
                            response.data[i].performancetypename;
                        $scope.myReview.description = 
                            response.data[i].performancedescription;
                    }
                }
                getdata(groupId, kpiId, userId);
            },
            function(response) {
                //console.log(response);
            })

        //console.log($stateParams);

        var getdata = function(groupId, kpi, userId){        
            adminReviewService.getIndividualKpi(userId, groupId, kpi)
                .then(function(response){
                    //console.log(response);
                    $scope.myReview.rows = response.data;
                    $scope.myReview.feedback = response.feedback;

                },
                function(response){
                    //console.log(response);
                });
        }

        $scope.submit = function() {
            var myFeedback = {  // assemble JSON data
                empid: user.id,
                performanceinfoid: kpiId,
                reviewforempid: userId,
                reviewcomment: $scope.myReview.feedback.reviewcomment,
                reviewstatus: $scope.myReview.feedback.reviewdatastatu,
                reviewlevel: "admin",
                feedback: $scope.myReview.feedback
            }

            //console.log(myFeedback);

            adminReviewService.submitFeedback(myFeedback)
                .then(function(response) {
                    //console.log(response);
                },
                function(response) {
                    //console.log(response);
                });
        }
        
    }])

/**
 * Contributed by chengchengding
 */
	.controller("dualListCtrl",function($scope){
        var lastIndex = 13;
        $scope.list = [];

        var updateList = function() {
            for (var i = $scope.list.length; i <= lastIndex; i++) {
                $scope.list.push({
                    'id': '_' + (i+1),
                    'text': 'Somebody ' + (i+1) + ' - Department of IT'
                });
            }
        };

        $scope.reset = function() {
            $scope.model = [];
        };

        $scope.add = function() {
            lastIndex++;
            updateList();
        };

        $scope.settings = {
            bootstrap2: true,
            filterClear: 'Show all!',
            filterPlaceHolder: 'Filter!',
            moveSelectedLabel: 'Move selected only',
            moveAllLabel: 'Move all!',
            removeSelectedLabel: 'Remove selected only',
            removeAllLabel: 'Remove all!',
            moveOnSelect: false,
            preserveSelection: 'moved',
            selectedListLabel: 'Selected Staff',
            nonSelectedListLabel: 'All Staff',
            postfix: '_helperz',
            selectMinHeight: 130,
            filter: true,
            filterNonSelected: '1',
            filterSelected: '4',
            infoAll: 'Showing all {0}!',
            infoFiltered: '<span class="label label-warning">Filtered</span> {0} from {1}!',
            infoEmpty: 'Empty dcc!',
            filterValues: false
        };

        updateList();
    })

    .controller('ModalDemoCtrl', function ($scope, $modal, $log) {
        $scope.items = ['item1', 'item2', 'item3'];

        $scope.open = function (size) {

            var modalInstance = $modal.open({
                templateUrl: 'myModalContent.html',
                controller: 'ModalInstanceCtrl',
                size: size,
                resolve: {
                    items: function () {
                        return $scope.items;
                    }
                }
            });

            modalInstance.result.then(function (selectedItem) {
                $scope.selected = selectedItem;
            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };
    })

    .controller('DatepickerDemoCtrl', function ($scope) {
        $scope.today = function() {
            $scope.dt1 = new Date();
            $scope.dt2= new Date();
        };
        $scope.today();

        $scope.clear = function () {
            $scope.dt1 = null;
            $scope.dt2 = null;
        };

        // Disable weekend selection
        //$scope.disabled = function(date, mode) {
        //    return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
        //};

        $scope.toggleMin = function() {
            $scope.minDate = $scope.minDate ? null : new Date();
        };
        $scope.toggleMin();

        $scope.open = function($event,opened) {
            $event.preventDefault();
            $event.stopPropagation();

            $scope[opened] = true;
        };

        $scope.dateOptions = {
            formatYear: 'yy',
            startingDay: 1
        };

        $scope.formats = ['dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
        $scope.format = $scope.formats[0];

        var tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        var afterTomorrow = new Date();
        afterTomorrow.setDate(tomorrow.getDate() + 2);
        $scope.events =
            [
                {
                    date: tomorrow,
                    status: 'full'
                },
                {
                    date: afterTomorrow,
                    status: 'partially'
                }
            ];

        $scope.getDayClass = function(date, mode) {
            if (mode === 'day') {
                var dayToCheck = new Date(date).setHours(0,0,0,0);

                for (var i=0;i<$scope.events.length;i++){
                    var currentDay = new Date($scope.events[i].date).setHours(0,0,0,0);

                    if (dayToCheck === currentDay) {
                        return $scope.events[i].status;
                    }
                }
            }
            return '';
        };
    })

	.controller('ModalInstanceCtrl', function ($scope, $modalInstance, items) {

	    $scope.items = items;
	    $scope.selected = {
	        item: $scope.items[0]
	    };

	    $scope.ok = function () {
	        $modalInstance.close($scope.selected.item);
	    };

	    $scope.cancel = function () {
	        $modalInstance.dismiss('cancel');
	    };
	    $scope.delete = function () {
	        $modalInstance.dismiss('cancel');
	    };

	})

})();
