/*
 * Created by chengchengding on 21/05/15.
 */
(function() {
    'user strict';

    angular.module('hrManager')
        .factory('hrService', 
                 [ '$http', 'HTTPConnect', 'appConnectionService',
                  function ($http, HTTPConnect, appConnectionService) {
                      var service = {};
                      service.updateProfile = function(userInfo) {
                          var url = HTTPConnect.hrUpdateProfile;
                          return appConnectionService.getResponseWithParams(url, userInfo);
                      };
                      service.createProfile = function(userInfo) {
                          var url = HTTPConnect.hrCreateProfile;
                          return appConnectionService.getResponseWithParams(url, userInfo);
                      };
                      service.deleteProfile = function(userInfo) {
                          var url = HTTPConnect.hrDeleteProfile;
                          return appConnectionService.getResponseWithParams(url, userInfo);
                      };

                      return service;
                  }])
})();
