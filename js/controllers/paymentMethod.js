/**
 * Created by Vilim Stubičan on 30.5.2015..
 */


/**
 * Created by Vilim Stubičan on 30.5.2015..
 */


app.controller("paymentMethodController", ["$scope", "$http", function($scope, $http){
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
            url : "/admin/payment-method/save",
            method: "JSON",
            data: $scope.data,
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.resetData();
                $scope.getPaymentMethods();
                $scope.editing = false;
            } else {
                $scope.data.name = data.error.name;
                $scope.data.status = data.error.price;
            }
            $scope.saving = false;
        });
    };

    $scope.getPaymentMethods = function(){
        $http({
            url : "/admin/payment-method/all",
            method: "JSON",
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.paymentMethods = data.data;
            }
        });
    };
    $scope.getPaymentMethods();

    $scope.update = function(){
        if($scope.saving) return;
        $scope.saving = true;
        $http({
            url : "/admin/payment-method/update",
            method: "JSON",
            data: $scope.data,
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.resetData();
                $scope.getPaymentMethods();
                $scope.editing = false;
            } else {
                $scope.data.name = data.error.name;
                $scope.data.status = data.error.status;
            }
            $scope.saving = false;
        });
    };

    $scope.edit = function(paymentMethod){
        $scope.editing = true;
        $scope.data = {
            id : paymentMethod.id,
            name : {
                value : paymentMethod.name,
                error : "",
                hasError : false
            },
            status : {
                value : paymentMethod.status.id,
                error : "",
                hasError : false
            }
        }
    }

    $scope.delete = function(paymentMethod){
        if($scope.saving) return;
        if(!confirm("Are you sure?")) return;
        $scope.saving = true;
        $http({
            url : "/admin/payment-method/delete",
            method: "JSON",
            data: {
                id : paymentMethod.id
            },
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            $scope.resetData();
            $scope.getPaymentMethods();
            $scope.saving = false;
        });
    }

    $scope.cancel = function(){
        $scope.editing = false;
        $scope.resetData();
    }
}]);