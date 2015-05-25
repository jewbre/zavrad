/**
 * Created by Vilim Stubičan on 4.5.2015..
 */


app.service("storageService",["$http", function($http){
    var StorageService = {
        products : [],
        currentProduct : 0,
        currentCard : 0,
        cards : [],
        card : {
            code : "",
            amount : 0
        },
        loading : false,
        saving : false,
        error : "",

        init : function(){

            this.getProducts();
        },
        getProducts : function(){
            var sSelf = this;
            $http({
                url: "/admin/products/all",
                method: "JSON",
                data: {
                },
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function(data){
                if(data.success) {
                    sSelf.products = data.data;
                } else {
                    console.log("something went wrong, fix this");
                }
            })
        },
        productCards : function(id) {
            var sSelf = this;
            this.inouts = [];
            $http({
                url: "/admin/storage/cards",
                method: "JSON",
                data: {
                    product : this.currentProduct
                },
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function(data){
                if(data.success) {
                    sSelf.cards = data.data;
                } else {
                    console.log("something went wrong, fix this");
                }
            })
        },
        save : function(){
            this.error = "";
            if(parseInt(this.card.amount) <= 0) {
                this.error += "Please enter valid amount. ";
            }
            if(parseInt(this.currentProduct) <= 0) {
                this.error += "Please select a product.";
            }

            if(this.error != "") return;

            var sSelf = this;
            $http({
                url: "/admin/storage/new",
                method: "JSON",
                data: {
                    product : this.currentProduct,
                    card : this.card
                },
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function(data){
                if(data.success) {
                    sSelf.cards = data.data;
                } else {
                    console.log("something went wrong, fix this");
                }
            });

        },
        cardDetails : function(id) {
            this.currentCard = id;
            var sSelf = this;

            $http({
                url: "/admin/storage/inouts",
                method: "JSON",
                data: {
                    id : id
                },
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function(data){
                if(data.success) {
                    sSelf.inouts = data.data;
                } else {
                    console.log("something went wrong, fix this");
                }
            });
        }
    };

    return StorageService;
}]);

app.controller("storageController",["$scope","storageService", function($scope,$storageService){
    $scope.service = angular.copy($storageService);
    $scope.service.init();

    $scope.total = function(id) {
        var totalSum = 0;
        for(var k in $scope.service.inouts) {
            var inout = $scope.service.inouts[k];
            switch(inout.type.name) {
                case 'in':
                    totalSum += inout.amount * inout.price.price;
            }

            if(k == id) break;
        }
        return totalSum;
    }
}]);