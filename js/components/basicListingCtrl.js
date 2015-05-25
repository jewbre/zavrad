/**
 * Created by Vilim Stubičan on 25.5.2015..
 */

app.controller("basicListingCtrl", ["$scope", "$http", "productListingService",
    function($scope, $http, $productListingService){

        $scope.products = $productListingService.products;

        $scope.getProducts = function(){
            $productListingService.fetch();
        };
        $scope.getProducts();

        $scope.nextPage = function(){
            $productListingService.paginator.next();
            $productListingService.fetch();
        };

        $scope.previousPage = function(){
            $productListingService.paginator.prev();
            $productListingService.fetch();
        };

        $scope.$on("products_updated", function(){
            $scope.products = $productListingService.products;
        })
    }]);