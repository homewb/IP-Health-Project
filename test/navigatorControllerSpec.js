/**
 *
 * @author Bo Wang
 */

'use strict';

describe('nav bar test', function () {
	var state, rootScope, controller, scope, ctrl, $cookieStore;

	beforeEach(module('navigator'));

	beforeEach(module(function($provide) {
    
        // Fake loginService Implementation returning a promise
	    $provide.value('Scopes', {
	        store: function (scope) {
	        	return null;
	        }
	    });

	    $provide.value('notificationService', {
	        getGroupInfo: function (userId) {
	        	return {
	        		then: function(callback) {
	        			var data = [
	        				{'incomplete': 1},
	        				{'incomplete': 2}
	        			];
	        			return callback({'data': data});
	        		}
	        	};
	        }
	    });
      
        return null;
    }));

	beforeEach(inject(function ($injector) {
		    
		    $cookieStore = {};
		    $cookieStore.get = function(String) {
		    	return {'permission': 'A', 'id': 1};
		    }
		    rootScope = $injector.get('$rootScope');
		    scope = rootScope.$new();
		    controller = $injector.get('$controller');
		    ctrl = controller('navController', {
		    	'$scope': scope, 
		    	'$rootScope': rootScope,
		    	'$cookieStore': $cookieStore
		    });
	}));

	describe('the nav bar', function() {

		it('should include administrator tab ...', function() {

			expect(scope.isAdministrator()).toBeTruthy();
		});

		it('should show number 3 as the notification ...', function() {

			expect(scope.totalReviewNotice).toBe(3);
		});

	});
});