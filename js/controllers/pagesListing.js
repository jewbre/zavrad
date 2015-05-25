/**
 * Created by Vilim Stubičan on 24.5.2015..
 */

/**
 * Created by Vilim Stubičan on 7.4.2015..
 */

app.controller("pagesListing", function($scope, $http){
    $scope.editing = false;

    $scope.data = {
        name : "",
        url : "",
    };


    $scope.all = function(){
        $http({
            url : "/admin/pages/get",
            method : "JSON",
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.pages = data.data;
            } else {
                console.log("something went wrong, fix");
            }
        });
    };
    $scope.all();

    $scope.displayMessage = function(message) {
        alert(message);
    };

    $scope.add = function(){
        $http({
            url : "/admin/pages/save",
            method : "JSON",
            data : $scope.data,
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.displayMessage(data.data.message);
                $scope.resetData();
                $scope.all();
            } else {
                $scope.displayMessage(data.data.message);
            }
        });
    };

    $scope.edit = function(page){
        $scope.editing = true;
        $scope.data = {
            id : page.id,
            name : page.name,
            url : page.url
        }
    };

    $scope.update = function(){
        $http({
            url : "/admin/pages/update",
            method : "JSON",
            data : $scope.data,
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.displayMessage(data.data.message);
                $scope.resetData();
                $scope.all();
            } else {
                $scope.displayMessage(data.data.message);
            }
        });
    };

    $scope.cancel = function(){
        $scope.editing = false;
        $scope.resetData();
    };

    $scope.delete = function(page){
        if(confirm("Are you sure?")) {
            $http({
                url : "/admin/pages/delete",
                method : "JSON",
                data : page,
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function(data){
                $scope.all();
            });
        }
    };

    $scope.resetData = function(){
        $scope.data = {
            name : "",
            url : ""
        };
    };


});