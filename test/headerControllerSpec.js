/**
 *
 * @author Bo Wang
 */

'use strict';

describe('header test', function () {
	var location, state, rootScope, controller, scope, ctrl, loginService;

	beforeEach(module('ui.router', 'header'));

	beforeEach(inject(function ($injector) {
		    
		    loginService = {};
		    loginService.clearCredentials = function () {
		    	// do nothing ...
		    }
		    rootScope = $injector.get('$rootScope');
		    rootScope.globals = {};
		    rootScope.globals.username = 'Tim';
		    scope = rootScope.$new();
		    controller = $injector.get('$controller');
		    state = $injector.get('$state');
		    ctrl = controller('headerController', {
		    	'$scope': scope, 
		    	'$rootScope': rootScope,
		    	'loginService': loginService,
		    	'$state': state
		    });
	}));

	describe('the user', function() {

		it('should be called Tim ...', function() {
			expect(ctrl).toBeDefined();
			expect(scope.username).toBe('Tim');
		});

	});
});