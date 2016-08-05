/**
 *
 * @author Bo Wang
 */

'use strict';

describe('login test', function () {
	var location, state, rootScope, controller, scope, ctrl, loginService, md5, _myService_;

	beforeEach(module('ui.router', 'angular-md5', 'login'));

	beforeEach(module(function($provide) {
    
        // Fake loginService Implementation returning a promise
	    $provide.value('loginService', {
	        login: function(username, password) {
	            return {
	                then: function(callback) {
	                	if (username === '111' &&
	                		password === '698d51a19d8a121ce581499d7b701668') {
	                		return callback({'state': true });
	                	}
	                	else {
	                		return callback({'state': false });
	                	}
	                }
	            };
	        },
	        clearCredentials: function() {
	        	return null;
	        },
	        check: function (name) {
	        	return null;
	        },
	        forget: function () {
	        	return null;
	        },
	        setCredentials: function (response) {
	        	return null;
	        }
	    });
      
        return null;
    }));

	beforeEach(inject(function ($injector) {
		    loginService = $injector.get('loginService');
		    rootScope = $injector.get('$rootScope');
		    scope = {};
		    controller = $injector.get('$controller');
		    state = $injector.get('$state');
		    spyOn(state, 'go');
		    ctrl = controller('loginController', {
		    	'$scope': scope, 
		    	'$rootScope': rootScope,
		    	'loginService': loginService,
		    	'$state': state
		    });
	}));

	describe('the user', function() {

		it('should be valid ... (username: 111, password: 111)', function() {
			scope.user = {};
			scope.user.username = '111';
			scope.user.password = '111';
			
			scope.login();
			expect(scope.invalid).toBeFalsy();
		});

		it('should not be valid ... (username: abcd, password: 1234)', function() {
			scope.user = {};
			scope.user.username = 'abcd';
			scope.user.password = '1234';
			
			scope.login();
			expect(scope.invalid).toBeTruthy();
		});

	});
});