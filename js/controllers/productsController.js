/**
 * Created by Vilim Stubičan on 10.4.2015..
 */

app.controller("productsController", ["$scope", "$http", "imageUpload", function($scope, $http, $imageUpload){
    $scope.imageUploadService = angular.copy($imageUpload);
    $scope.imageUploadService.init();

    $scope.images = [];
    $scope.page = 1;
    $scope.loading = false;

    $scope.data = {
        name : {
            value : "",
            error : "",
            hasError : false
        },
        code : {
            value : "",
            error : "",
            hasError : false
        },
        description : {
            value : "",
            error : "",
            hasError : false
        },
        excerpt : {
            value : "",
            error : "",
            hasError : false
        },
        categories : [],
        images : [],
        price : {
            value : "",
            currency : {},
            error : "",
            hasError : false
        }
    };

    $scope.resetData = function(){
        $scope.data = {
            name : {
                value : "",
                error : "",
                hasError : false
            },
            code : {
                value : "",
                error : "",
                hasError : false
            },
            description : {
                value : "",
                error : "",
                hasError : false
            },
            excerpt : {
                value : "",
                error : "",
                hasError : false
            },
            categories : [],
            images : [],
            price : {
                value : "",
                currency : {},
                error : "",
                hasError : false
            }
        }
    };
    $scope.resetData();


    $scope.$on("imageUploaded", function(){
        $scope.page = 1;
        $scope.images = [];
        $scope.data.images = $scope.data.images.concat($scope.imageUploadService.images);
        $scope.imageUploadService.images = [];
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

    $scope.isSelected = function(image) {
        for(i=0;i<$scope.data.images.length;i++) {
            if($scope.data.images[i].id == image.id) return true;
        }
        return false;
    }

    $scope.toggleSelect = function(image) {
        var $newArray = [];
        var deleted = false;
        for(i=0;i<$scope.data.images.length;i++) {
            if($scope.data.images[i].id == image.id) {
                deleted = true;
                continue;
            }
            $newArray.push($scope.data.images[i]);
        }
        if(deleted) {
            $scope.data.images = $newArray;
            return;
        }
        $scope.data.images.push(image);
    };



    // Categories

    $scope.getCategories = function(){
        $http({
            url : "/admin/category/all",
            method : "JSON",
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.categories = data.data;
            } else {
                console.log("something went wrong, fix");
            }
        });
    };
    $scope.getCategories();

    $scope.$watch("data.categories",function(newValue, oldValue){
        console.log($scope.data);
    });

    // Currencies
    $scope.getCurrencies = function(){
        $http({
            url : "/admin/currency/all",
            method : "JSON",
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.currencies = data.data;
            } else {
                console.log("something went wrong, fix");
            }
        });
    };
    $scope.getCurrencies();

    // Functionality
    $scope.save = function(){
        if($scope.saving) return;
        $scope.saving = true;
        $http({
            url : "/admin/products/save",
            method: "JSON",
            data: $scope.data,
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.resetData();
                $scope.getProducts();
                $scope.editing = false;
            } else {
                $scope.data.name = data.error.name;
                $scope.data.price = data.error.price;
                $scope.data.code = data.error.code;
                $scope.data.description = data.error.description;
                $scope.data.excerpt = data.error.excerpt;
            }
            $scope.saving = false;
        });
    };

    $scope.delete = function(product){
        $http({
            url : "/admin/products/delete",
            method: "JSON",
            data : {
                product_id : product.id
            },
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            $scope.getProducts();
        });
    };

    $scope.getProducts = function(){
        $http({
            url : "/admin/products/all",
            method: "JSON",
            data : {
                allData : true
            },
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.products = data.data;
            }
        });
    };
    $scope.getProducts();

    $scope.update = function(){
        if($scope.saving) return;
        $scope.saving = true;
        $http({
            url : "/admin/products/update",
            method: "JSON",
            data: $scope.data,
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.resetData();
                $scope.getProducts();
            } else {
                $scope.data.name = data.error.name;
                $scope.data.price = data.error.price;
                $scope.data.code = data.error.code;
                $scope.data.description = data.error.description;
                $scope.data.excerpt = data.error.excerpt;
            }
            $scope.saving = false;
        });
    }

    $scope.edit = function(product){
        $scope.editing = true;
        $cats = [];
        for(k in product.categories) {
            $cats.push(product.categories[k].id);
        }
        $scope.data = {
            id : product.id,
            name : {
                value : product.name,
                error : "",
                hasError : false
            },
            code : {
                value : product.code,
                error : "",
                hasError : false
            },
            description : {
                value : product.description,
                error : "",
                hasError : false
            },
            excerpt : {
                value : product.excerpt,
                error : "",
                hasError : false
            },
            categories : $cats,
            images : product.images,
            price : {
                value : product.price.price,
                currency : product.price.currency.id,
                error : "",
                hasError : false
            }
        }
    }

    $scope.cancel = function(){
        $scope.editing = false;
        $scope.resetData();
    }
}]);