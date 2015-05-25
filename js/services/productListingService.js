/**
 * Created by Vilim Stubičan on 25.5.2015..
 */

app.service("productListingService", ["$rootScope", "$http",
    function($rootScope, $http){
        var productListingService = {
            paginator : {
                page : 1,
                next : function(){
                    this.page++;
                },
                prev : function(){
                    this.page--;
                    if(this.page == 0)
                        this.page = 1;
                }
            },
            per_page : 15,
            load_in_progress : false,
            products : [],
            fetch : function(){
                var self = this;
                if(this.load_in_progress) return;
                this.load_in_progress = true;
                $http({
                    url : "/admin/products/all",
                    method: "JSON",
                    data : {
                        allData : true,
                        page : this.paginator.page,
                        per_page : this.per_page
                    },
                    headers: {
                        'Content-Type': "x www form urlencoded"
                    }
                }).success(function(data){
                    if(data.success) {
                        self.products = data.data;
                        $rootScope.$broadcast("products_updated");
                    }
                    self.load_in_progress = false;
                });
            }
        };
        return productListingService;
    }]);