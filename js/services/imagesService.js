/**
 * Created by Vilim Stubičan on 25.5.2015..
 */

app.service("imagesService", ["$rootScope", "$http",
    function($rootScope, $http){
        var ImagesService = {
            images : [],
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
            init : function(){
                this.fetch();
            },
            fetch : function(){
                var self = this;
                $http({
                    url: "/admin/image/get",
                    method: "JSON",
                    data : {
                        page : this.paginator.page
                    },
                    headers: {
                        'Content-Type': "x www form urlencoded"
                    }
                }).success(function(data){
                    if(data.success && data.data) {
                        self.images = data.data;
                        self.paginator.next();
                        $rootScope.$broadcast("images_loaded");
                    } else {
                        console.log("something went wrong, fix this");
                    }
                });
            }
        };
        return ImagesService;
    }]);