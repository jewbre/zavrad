/**
 * Created by Vilim Stubičan on 28.5.2015..
 */


app.controller("optionsController", ["$scope", "$http",
    function($scope, $http){
        $scope.options = {};
        $scope.saving = true;


        $scope.getOptions = function() {
            $http({
                url: "/options/get",
                method: "JSON",
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function (data) {
                if (data.success && data.data) {
                    $scope.options = data.data;
                }
                $scope.saving = false;
            })
        };
        $scope.getOptions();

        $scope.save = function() {
            if($scope.saving) return;
            $scope.saving = true;
            $http({
                url: "/options/save",
                method: "JSON",
                data : $scope.options,
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function (data) {
                $scope.saving = false;
            })
        }
}]);