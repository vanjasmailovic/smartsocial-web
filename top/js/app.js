'use strict';

/* App Module */

var clubMembers = angular.module('smartsocial', [
    'ngRoute', 
    'ss_top'
]);

clubMembers.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
                when('/top', {
                    templateUrl: 'partials/top.html',
                    controller: 'SSTop'
                }).
                otherwise({
                    redirectTo: '/top'
                });
    }]);
