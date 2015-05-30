/**
 * Created by Vilim Stubičan on 30.5.2015..
 */


app.controller("shippingMethodController", ["$scope", "$http", function($scope, $http){
    $scope.page = 1;
    $scope.loading = false;

    $scope.data = {
        name : {
            value : "",
            error : "",
            hasError : false
        },
        status : {
            value : 100,
            error : "",
            hasError : false
        }
    };

    $scope.resetData = function(){
        $scope.data = {
            name : {
                value : "",
                error : "",
                hasError : false
            },
            status : {
                value : 100,
                error : "",
                hasError : false
            }
        }
    };
    $scope.resetData();


    // Status

    $scope.getStatusCodes = function(){
        $http({
            url : "/admin/status/regular",
            method : "JSON",
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

    // Functionality
    $scope.save = function(){
        if($scope.saving) return;
        $scope.saving = true;
        $http({
            url : "/admin/shipping-method/save",
            method: "JSON",
            data: $scope.data,
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.resetData();
                $scope.getShippingMethods();
                $scope.editing = false;
            } else {
                $scope.data.name = data.error.name;
                $scope.data.status = data.error.price;
            }
            $scope.saving = false;
        });
    };

    $scope.getShippingMethods = function(){
        $http({
            url : "/admin/shipping-method/all",
            method: "JSON",
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.shippingMethods = data.data;
            }
        });
    };
    $scope.getShippingMethods();

    $scope.update = function(){
        if($scope.saving) return;
        $scope.saving = true;
        $http({
            url : "/admin/shipping-method/update",
            method: "JSON",
            data: $scope.data,
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.resetData();
                $scope.getShippingMethods();
                $scope.editing = false;
            } else {
                $scope.data.name = data.error.name;
                $scope.data.status = data.error.status;
            }
            $scope.saving = false;
        });
    };

    $scope.edit = function(shippingMethod){
        $scope.editing = true;
        $scope.data = {
            id : shippingMethod.id,
            name : {
                value : shippingMethod.name,
                error : "",
                hasError : false
            },
            status : {
                value : shippingMethod.status.id,
                error : "",
                hasError : false
            }
        }
    }

    $scope.delete = function(shippingMethod){
        if($scope.saving) return;
        if(!confirm("Are you sure?")) return;
        $scope.saving = true;
        $http({
            url : "/admin/shipping-method/delete",
            method: "JSON",
            data: {
                id : shippingMethod.id
            },
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
                $scope.resetData();
                $scope.getShippingMethods();
            $scope.saving = false;
        });
    }

    $scope.cancel = function(){
        $scope.editing = false;
        $scope.resetData();
    }
}]);