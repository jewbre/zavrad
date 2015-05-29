/**
 * Created by Vilim Stubičan on 28.5.2015..
 */


app.controller("singleModernCtrl",["$scope", "singleProductService", "cartService",
    function($scope, singleProductService, cartService){

        cartService.init();

        $scope.currentImage = 0;
        $scope.nextImage = function(){
            $scope.currentImage = ($scope.currentImage + 1) % singleProductService.getImages().length;
        };

        $scope.previousImage = function(){
            $scope.currentImage = ($scope.currentImage - 1) % singleProductService.getImages().length;
            if($scope.currentImage < 0) $scope.currentImage = singleProductService.getImages().length -1;

        };

        $scope.$watch("pId", function(){
            console.log($scope.pId);
            if(!angular.isUndefined($scope.pId)){
                singleProductService.getProduct($scope.pId);
            }
        });

        $scope.getName = function(){
            return singleProductService.getName();
        };

        $scope.getImages = function(){
            return singleProductService.getImages();
        };

        $scope.getPrice = function(){
            return singleProductService.getPrice();
        };

        $scope.getExcerpt = function(){
            return singleProductService.getExcerpt();
        };

        $scope.getDescription = function(){
            return singleProductService.getDescription();
        };

        $scope.showImage = function(id){
            return $scope.currentImage == id;
        };

        $scope.hideImage = function(id){
            return !$scope.showImage(id);
        };

        $scope.addToCart = function(){
            if(!parseInt($scope.cartAmount) || $scope.cartAmount < 1) return;
            cartService.add(singleProductService.product.id, $scope.cartAmount);
        }


    }]);