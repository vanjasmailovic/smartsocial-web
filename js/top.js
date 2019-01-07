var ss = angular.module('ss_top', []);

ss.controller('SSTop', ['$scope', '$http', '$interval',
    function ($scope, $http, $interval) {
        $scope.test = "tu sam";
        $scope.users = [];
        $scope.init = function () {
            //loadData();
            var url = "./server/server.php";
            $http.get(url)
                    .success(function (data) {
                        angular.copy(data, $scope.users);
                    })
                    .error(function () {

                    }
                    );
        };
        var loadData = $interval(function () {
            console.log("*");
            var url = "./server/server.php";
            $http.get(url)
                    .success(function (data) {
                        angular.copy(data, $scope.users);
                    })
                    .error(function () {

                    }
                    );
        }, 5000);
    }]);


