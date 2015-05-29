/**
 * Created by Vilim Stubičan on 29.5.2015..
 */


app.controller("basicCartCtrl", ["$scope", "cartService",
    function($scope, cartService){
        cartService.init();

        $scope.getCartItems = function(){
            return cartService.cart.items;
        }

        $scope.getTotal = function(){
            var items = $scope.getCartItems();

            if(angular.isUndefined(items)) return;
            var total = 0;
            var currency = "";
            items.forEach(function(el, index, array){
                total += el.product.price.price * el.amount;
                currency = el.product.price.currency.single;
            })

            return total + " " + currency;
        };

        $scope.addItem = function(item){
            cartService.add(item.product.id, 1);
        };

        $scope.removeItem = function(item){
            cartService.remove(item.product.id, 1);
        };

        $scope.removeItems = function(item){
            cartService.remove(item.product.id, item.amount);
        };
}]);