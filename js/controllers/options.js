/**
 * Created by Vilim Stubičan on 28.5.2015..
 */


app.controller("optionsController", ["$scope", "$http", "imagesService",
    function($scope, $http, imagesService){
        $scope.options = {};
        $scope.saving = true;
        $scope.menuItems = {
            items : [],
            error : ""
        };
        $scope.slider = {
            images : [],
            period : 500
        };

        $scope.images = imagesService.images;

        imagesService.init();

        $scope.getMoreImages = function(){
            imagesService.fetch();
        }

        $scope.$on("images_loaded", function(){
            $scope.images = imagesService.images;
        });

        $scope.getPages = function(){
            $http({
                url: "/admin/pages/get",
                method: "JSON",
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function(data){
                if(data.success) {
                    $scope.pages = data.data;
                } else {
                    console.log("something went wrong, fix this");
                }
            })
        };
        $scope.getPages();


        $scope.getOptions = function() {
            $http({
                url: "/options/get",
                method: "JSON",
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function (data) {
                if (data.success && data.data) {
                    $scope.options = data.data;
                    if($scope.options.menuItems) {
                        $scope.menuItems = $scope.options.menuItems.value;
                    }
                    if($scope.options.slider) {
                        $scope.slider = $scope.options.slider.value;
                    }
                }
                $scope.saving = false;
            })
        };
        $scope.getOptions();

        $scope.save = function() {
            if($scope.saving) return;
            $scope.saving = true;
            $http({
                url: "/options/save",
                method: "JSON",
                data : $scope.options,
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function (data) {
                $scope.saving = false;
            })
        };


        // Menu bars

        /**
         * Add new menu item to the form model.
         */
        $scope.menuItemAdd = function(){
            var arrayLength = $scope.menuItems.items.length;
            var index = 0;
            if(arrayLength > 0) {
                index = parseInt($scope.menuItems.items[arrayLength-1].id) + 1;
            }
            $scope.menuItems.items.push(
                {"id" : index, "value":"New menu item", url : "/", "error":""}
            );
            console.log($scope.menuItems);
        };

        /**
         * Remove menu item from the form model.
         * @param elem
         */
        $scope.menuItemRemove = function(elemId) {
            var newArray = [];
            for(k in $scope.menuItems.items) {
                if($scope.menuItems.items[k].id == elemId) {
                    continue;
                }
                newArray.push($scope.menuItems.items[k]);
            }
            $scope.menuItems.items = newArray;
        };

        $scope.saveMenu = function(){
            if($scope.saving) return;
            $scope.saving = true;
            $http({
                url: "/options/saveMenu",
                method: "JSON",
                data : $scope.menuItems,
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function (data) {
                $scope.saving = false;
            })
        };


        /* Slider options */
        $scope.addSliderImage = function(url){
            $scope.slider.images.push({url:url});
        };

        $scope.removeSliderImage = function(index){
            var newArray = [];
            for(var k in $scope.slider.images){
                if(k == index) continue;
                newArray.push($scope.slider.images[k]);
            }
            $scope.slider.images = newArray;
        };

        $scope.moveSliderImageUp = function(index){
            if(index == 0) return;
            var tmp = $scope.slider.images[index-1].url;
            $scope.slider.images[index-1].url = $scope.slider.images[index].url;
            $scope.slider.images[index].url = tmp;
        };

        $scope.moveSliderImageDown = function(index){
            if(index == $scope.slider.images.length - 1 ) return;
            var tmp = $scope.slider.images[index+1].url;
            $scope.slider.images[index+1].url = $scope.slider.images[index].url;
            $scope.slider.images[index].url = tmp;
        };

        $scope.saveSlider = function(){
            if($scope.saving) return;
            $scope.saving = true;
            $http({
                url: "/options/saveSlider",
                method: "JSON",
                data : $scope.slider,
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function (data) {
                $scope.saving = false;
            })
        }
}]);