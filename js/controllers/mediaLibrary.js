/**
 * Created by Vilim Stubičan on 9.4.2015..
 */



app.controller("mediaLibrary", ["$scope", "$http", "imageUpload", function($scope, $http, $imageUpload){

    $scope.imageUploadService = angular.copy($imageUpload);
    $scope.imageUploadService.init();

    $scope.gallery = {
        selected : {},
        images : []
    };

    $scope.images = [];
    $scope.page = 1;
    $scope.loading = false;

    $scope.$on("imageUploaded", function(){
        $scope.page = 1;
        $scope.images = [];
        $scope.getImages();
    });

    $scope.getImages = function(){
        if($scope.loading) return;
        $scope.loading = true;
        $http({
            url : "/admin/image/get",
            method: "JSON",
            data: {
                page : $scope.page
            },
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success && data.data) {
                $scope.images = $scope.images.concat(data.data);
                $scope.page++;
            }
            $scope.loading = false;
        });
    };
    $scope.getImages();


    $scope.delete = function(image) {
        if(confirm("Are you sure?")) {
            $http({
                url: "/admin/image/delete",
                method: "JSON",
                data: {
                    id: image.id
                },
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function (data) {
                if (data.success) {
                    $scope.page = 1;
                    $scope.images = [];
                    $scope.getImages();
                }
            });
        }
    }

    $scope.showGallery = function(image) {
        var index = 0;
        for(i=0; i<$scope.images.length; i++) {
            if($scope.images[i].id == image.id) {
                index = i;
                break;
            }
        }
        if($scope.images.length <= 7) {
            var minIndex = 0;
            var maxIndex = $scope.images.length;
        } else {
            if(index <= 3) {
                var minIndex = 0;
                var maxIndex = 7;
            } else if(index >= $scope.images.length - 4) {
                var minIndex = $scope.images.length -1 - 7;
                var maxIndex = $scope.images.length;
            } else {
                var minIndex = index-3;
                var maxIndex = index+4;
            }
        }
        $scope.gallery.selected = angular.copy(image);

        $newArray = [];
        for(i=minIndex; i<maxIndex; i++) {
            $newArray.push($scope.images[i]);
        }
        $scope.gallery.images = $newArray;
        $scope.gallery.index = index;

        $(".gallery").fadeIn();
    };

    $scope.next = function(){
        var index = ($scope.gallery.index + 1) % $scope.images.length;
        $scope.showGallery($scope.images[index]);
    };

    $scope.previous = function(){
        var index = ($scope.gallery.index - 1 + $scope.images.length) % $scope.images.length;
        $scope.showGallery($scope.images[index]);
    };

    $scope.isSelected = function(image) {
        return image.id == $scope.gallery.selected.id;
    };

    $scope.hideGallery = function(){
        $(".gallery").fadeOut();
    }



}]);