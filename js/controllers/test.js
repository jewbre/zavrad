/**
 * Created by Vilim Stubičan on 10.3.2015..
 */


app.controller("testController", ["$scope", "$http", "imageUpload", function($scope, $http, $imageUpload){

    $scope.imageUploadService = angular.copy($imageUpload);

    $scope.upl = function(){
        $scope.imageUploadService.upload();
    }

    $scope.check = function(){
        console.log($scope.imageUploadService.images);
    }
}]);