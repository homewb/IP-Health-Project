/*
 * Created by Bo Wang
 * Main module
 */
 (function() {
 	'use strict';

	angular.module('myConfig', []);
	angular.module('appService', []);
	angular.module('login', []);
	angular.module('header', []);
	angular.module('navigator', []);
	angular.module('profile', []);
	angular.module('home', []);
	angular.module('dashboard', []);
	angular.module('myCalendar', []);
	angular.module('performance', []);
	angular.module('administration', []);
	angular.module('peerReview', []);
	angular.module('adminPeerReview', []);
	angular.module('findStaff', []);
	angular.module('hrManager', []);

	var app = angular.module('myApp', [
		'myConfig',
		'appService',
        // Third party module;
		'ngCookies',
		'ui.router',
		'angular-md5',
		'chart.js',
		'xeditable',
		'smart-table',
		'ngDialog',
		'ngIdle',
		'ui.utils',
		'ui.select',
		'ui.calendar',
		'ngSanitize',
		'ngMessages',
		'ngAnimate',
		'frapontillo.bootstrap-duallistbox',
		'googlechart',
		'ui.bootstrap',
		'mgcrea.ngStrap',
		'dcbClearInput',
        
        // app module;
		'login',  
		'home',
		'header',
		'navigator',
		'profile',
		'dashboard',
		'myCalendar',
		'performance',
		'administration',
		'peerReview',
		'adminPeerReview',
		'findStaff',
		'hrManager'
	]);

	app.config(['$stateProvider', '$urlRouterProvider', 
		function ($stateProvider, $urlRouterProvider) {

		$urlRouterProvider.otherwise('login');

		$stateProvider
			.state('login', {
				url: '/login',
				controller: 'loginController',
				templateUrl: './templates/login.html'

			})

			.state('reset', {
				url: '/reset',
				controller: 'resetController',
				templateUrl: './templates/reset.html'
			})

			.state('sendemail', {
				url: '/sendemail',
				controller: 'sendingController',
				templateUrl: './templates/sendemail.html'
			})

			.state('home', {
				url: '/home',
				views: {
					'': {
						controller: 'homeController',
						templateUrl: './templates/home.html'
					},
					'header@home': {
						controller: 'headerController',
						templateUrl: './templates/header.html'
					},
					'footer@home': {
						templateUrl: './templates/footer.html'
					},
					'navigator@home': {
						controller: 'navController as nav',
						templateUrl: './templates/navigator.html'
					},
					'main@home': {
						
					}
				}
			})

			.state('home.dashboard', {
				url: '/dashboard',
				views: {
					'main@home': {
						controller: 'dashboardController as dash',
						templateUrl: './templates/dashboard.html'
					}
				}
			})

			.state('home.reports', {
				url: '/reports',
				views: {
					'main@home': {
						templateUrl: './templates/reports.html'
					}
				}
			})

			.state('home.timetracker', {
				url: '/tracker/timetracker',
				views: {
					'main@home': {
						templateUrl: './templates/timetracker.html'
					}
				}
			})

            .state('home.performancetracker', {
				url: '/tracker/performancetracker',
				views: {
					'main@home': {
						controller: 'performanceController',
						templateUrl: './templates/performancetracker.html'
					}
				}
			})

			.state('home.findstaff', {
				url: '/findstaff',
				views: {
					'main@home': {
						templateUrl: './templates/findstaff.html',
						controller:'findStaffController'
					}
				}
			})
			.state('home.findstaff.detail', {
				url: '/:id',
				views: {
					'main@home': {
						templateUrl: './templates/findstaffdetail.html',
						controller:'findStaffDetailController'
					}
				}
			})
            .state('home.application', {
				url: '/application',
				views: {
					'main@home': {
						templateUrl: './templates/application.html'
					}
				}
			})

	        .state('home.myreviews', {
				url: '/myreviews',
				views: {
					'main@home': {
						templateUrl: './templates/myreviews.html',
						controller:'myReviewController'
					}
				}
			})

	        .state('home.peerreview', {
				url: '/peerreview',
				views: {
					'main@home': {
						templateUrl: './templates/peerreview.html',
                        controller:'peerReviewController'
					}
				}
			})

			.state('home.profile', {
				url: '/profile',
				views: {
					'main@home': {
						controller: 'profileController',
						templateUrl: './templates/profile.html'
					}
				}
			})

        .state('home.hrmanager', {
				url: '/hrmanager',
				views: {
					'main@home': {
						controller: 'hrmanagerController',
						templateUrl: './templates/hrmanager.html'
					}
				}
			})
			.state('home.administration', {
				url: '/administration',
				views: {
					'main@home': {
						controller: 'adminController',
						templateUrl: './templates/administration.html'
					}
				}
			})

			.state('home.peerreviewadmin', {
				url: '/peerreviewadmin',
				views: {
					'main@home': {
						controller:'adminPeerReviewController',
						templateUrl: './templates/peerreviewadmin.html'
					}
				}
			})

			.state('home.peerreviewadmin.detail', {
				url: '/:id&:gid&:kid',
				views: {
					'main@home': {
						controller: 'adminIndiviReviewController',
						templateUrl: './templates/peerreviewadmindetail.html'
					}
				}
			})

			.state('home.error', {
				url: '/error',
				views: {
					'main@home': {
						templateUrl: './templates/error.html'
					}
				}
			})

			.state('home.error1', {
				url: '/error1',
				views: {
					'main@home': {
						templateUrl: './templates/error1.html'
					}
				}
			})
	}])

	.run(['$rootScope', '$cookieStore', '$state', 'editableOptions',  
		function ($rootScope, $cookieStore, $state, editableOptions) {
			editableOptions.theme = 'bs3';

			$rootScope.globals = $cookieStore.get('globals') || {};

			$rootScope.$on('$stateChangeStart', function (event, toState, toParams, 
              fromState, fromParams){

				if (!$rootScope.globals) {
					event.preventDefault();
					$state.go('login');
				}
			})		
	}])

})();

