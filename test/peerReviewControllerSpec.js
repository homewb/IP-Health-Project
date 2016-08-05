/**
 *
 * @author Bo Wang
 */

'use strict';

describe('peerReview test', function () {
    var controller, scope, $cookieStore, reviewTableService, Scopes, ctrl;
    
    beforeEach(module('peerReview'));

    beforeEach(module(function($provide) {
    
        // Fake loginService Implementation returning a promise
        $provide.value('Scopes', {
            store: function (scope) {
                return null;
            }
        });

        $provide.value('reviewTableService', {
            getGroupInfo: function (userId) {
                return {
                    then: function(callback) {
                        var data = [
                            {
                                'groupid': '5',
                                'incomplete': 2
                            },
                            {
                                'groupid': '1',
                                'incomplete': 1
                            }
                        ];
                        return callback({'state': true, 'data': data});
                    }
                };
            },
            loadKpiIds: function (groupId) {
                return {
                    then: function(callback) {
                        var data = [
                            {
                                'performanceinfoid': 1
                            },
                            {
                                'performanceinfoid': 5
                            },
                            {
                                'performanceinfoid': 3
                            }
                        ];
                        return callback({'data': data});
                    }
                }
            },
            loadTable: function (groupId, kpi, userId) {
                return {
                    then: function(callback) {
                        var data = [
                            {
                                'firstname': 'Jonathan'
                            },
                            {
                                'firstname': 'Tim'
                            }
                        ];
                        return callback({'state': true, 'data': data});
                    }
                }
            }
        });
      
        return null;
    }));

    beforeEach(inject(function ($injector) {
        $cookieStore = {};
        $cookieStore.get = function(String) {
            return {'id': 1};
        }
        reviewTableService = $injector.get('reviewTableService');
        controller = $injector.get('$controller'); 
        scope = {};
        scope.myGroups = {};
        ctrl = controller('peerReviewController', {
                '$scope': scope, 
                '$cookieStore': $cookieStore,
                'reviewTableService': reviewTableService
            }); 

    }));

    describe('the peer review page', function () {

        it('should have two groups', function () {
            
        	expect(scope.myGroups.length).toBe(2);
        });

    });

    describe('in the peer review page, ', function () {

        it('the group should have two members', function () {
            
            expect(scope.myReview.rows.length).toBe(2);
        });

    });

    describe('in the first group, ', function () {

        it('there should be two members', function () {
            
            expect(scope.myReview.rows.length).toBe(2);
        });

        it('the firstname of the first person should be Jonathan', function () {
            expect(scope.myReview.rows[0].firstname).toBe('Jonathan');
        });

        it('the firstname of the second person should be Tim', function () {
            expect(scope.myReview.rows[1].firstname).toBe('Tim');
        });

    });
    
});
