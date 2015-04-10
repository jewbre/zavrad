/**
 * Created by Vilim Stubičan on 7.4.2015..
 */

app.controller("categoryListing", function($scope, $http){
    $scope.editing = false;

    $scope.data = {
        name : "",
        status : 100
    };

    $scope.getStatusCodes = function(){
        $http({
            url : "/admin/status/regular",
            method : "JSON",
            data : $scope.data,
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.statuses = data.data;
            } else {
                console.log("something went wrong, fix");
            }
        });
    };
    $scope.getStatusCodes();

    $scope.all = function(){
        $http({
            url : "/admin/category/all",
            method : "JSON",
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.categories = data.data;
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
            url : "/admin/category/save",
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

    $scope.edit = function(category){
        $scope.editing = true;
        $scope.data = {
            id : category.id,
            name : category.name,
            status : category.status
        }
    };

    $scope.update = function(){
        $http({
            url : "/admin/category/update",
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

    $scope.delete = function(category){
        if(confirm("Are you sure?")) {
            $http({
                url : "/admin/category/delete",
                method : "JSON",
                data : category,
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function(data){
                $scope.all();
            });
        }
    };

    $scope.statusDescription = function(statusId) {
        for(k in $scope.statuses) {
            if($scope.statuses[k].id == statusId) return $scope.statuses[k].name;
        }
        return "undefined";
    };


    $scope.resetData = function(){
        $scope.data = {
            name : "",
            status : 100
        };
    };


});