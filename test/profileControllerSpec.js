/**
 *
 * @author Bo Wang
 */

'use strict';

describe('profile test', function () {
	var scope, cookieStore, profileService, GoogleService, $timeout, 
			UpdateStatus, $filter, $state, controller, ctrl;

	beforeEach(module('ui.router', 'profile'));

	beforeEach(module(function($provide) {

		// Fake loginService Implementation returning a promise
		$provide.value('profileService', {
            getProfile: function (userId) {
                return {
                	then: function (callback) {
                		var response = {
                			empid: 2, 
                			firstname: "Tim", 
                			lastname: "Cook", 
                			birthday: "1960-09-10T00:00:00.000Z", 
                			address: "172_La_Trobe_Street_,Melbourne,Vict…", 
                			department: "CEO of Apple Inc", 
                			jobtittle: "Board", 
                			position: null, 
                			photo: "img/cook_hero.png", 
                			phone2: "0396000000"
                		}
                		return callback(response);
                	}
                };
            },

            updateProfile: function (user) {
            	return {
            		then: function (callback) {
            			return callback({'state': true});
            		}
            	}
            }
        });
	}));

	beforeEach(inject(function($injector) {
		cookieStore = {};
        cookieStore.get = function(String) {
            return {'id': 1};
        }
        scope = {};
        profileService = $injector.get('profileService');
        controller = $injector.get('$controller');
        ctrl = controller('profileController', {
        	'$scope': scope,
        	'$cookieStore': cookieStore,
        	'profileService': profileService
        });

	}));

	describe('in the profile page, ', function() {
		it('the firstname should be Tim', function() {
			expect(scope.userInfo.firstname).toBe('Tim');
		});
		it('the lastname should be Cook', function() {
			expect(scope.userInfo.lastname).toBe('Cook');
		});
		it('the address should be 172_La_Trobe_Street_,Melbourne,Vict…', function() {
			expect(scope.userInfo.address).toBe('172_La_Trobe_Street_,Melbourne,Vict…');
		});
		it('the department should be CEO of Apple Inc', function() {
			expect(scope.userInfo.department).toBe('CEO of Apple Inc');
		});
		it('the phone should be 0396000000', function() {
			expect(scope.userInfo.phone).toBe('0396000000');
		});
	})
});