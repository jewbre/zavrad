/**
 * Created by Vilim Stubičan on 15.5.2015..
 */


app.service("cartService",["$rootScope", "$http",function($rootScope, $http){
    var CartService = {
        cart: "",
        init: function () {
            var self = this;
            $http({
                url: "/api/cart/get",
                method: "JSON",
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function (data) {
                if (data.success) {
                    self.cart = data.data;
                }
            });
        },
        add: function (product, amount) {
            var self = this;
            $http({
                url: "/api/cart/add",
                method: "JSON",
                data: {
                    product: product,
                    amount: amount
                },
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function (data) {
                if (data.success) {
                    self.cart = data.data;
                }
            });
        },
        remove: function (product, amount) {
            var self = this;
            $http({
                url: "/api/cart/remove",
                method: "JSON",
                data: {
                    product: product,
                    amount: amount
                },
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function (data) {
                if (data.success) {
                    self.cart = data.data;
                }
            });
        }
    }
    return CartService;
}]);
