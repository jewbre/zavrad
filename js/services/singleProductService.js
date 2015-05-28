/**
 * Created by Vilim Stubičan on 28.5.2015..
 */

app.service("singleProductService",["$rootScope","$http", function($rootScope, $http){
    var SingleProductService = {
        product : {},
        getProduct : function(id){
            var self = this;
            $http({
                url: "/admin/products/get",
                method: "JSON",
                data : {
                    product_id : id
                },
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function(data){
                if(data.success && data.data) {
                    self.product = data.data;
                    $rootScope.$broadcast("product_loaded");
                } else {
                    console.log("something went wrong, fix this");
                }
            });
        },
        getPrice : function(){
            return this.product.price;
        },
        getImages : function(){
            return this.product.images;
        },
        getRemainingAmount : function(){
            return this.product.amount;
        },
        getName :  function(){
            return this.product.name;
        },
        getDescription : function(){
            return this.product.description;
        },
        getExcerpt : function(){
            return this.product.excerpt;
        }
    };
    return SingleProductService;
}]);