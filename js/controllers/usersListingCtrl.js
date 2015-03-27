/**
 * Created by Vilim Stubičan on 25.3.2015..
 */


app.controller("userListingCtrl", function($scope, $http) {
    $scope.editing = false;

    $scope.data = {
        email : {
            value : "",
            error : "",
            hasError : false
        },
        password : {
            value : "",
            error : "",
            hasError : false
        },
        authority : {
            value : 2,
            error : "",
            hasError : false
        }
    };

    $scope.getAuthorities = function(){
        $http({
            url : "/admin/users/authorities",
            method : "JSON",
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.authorities = data.data;
            } else {
                console.log("something went wrong, fix");
            }
        });
    };
    $scope.getAuthorities();

    $scope.getUsers = function(){
        $http({
            url : "/admin/users/get",
            method : "JSON",
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.users = data.data;
            } else {
                console.log("something went wrong, fix");
            }
        });
    };
    $scope.getUsers();

    $scope.addNewUser = function(){
        $http({
            url : "/admin/users/add",
            method : "JSON",
            data : $scope.data,
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                if(data.data.valid) {
                    $scope.getUsers();
                }
                $scope.data = data.data.params;
            } else {
                console.log("something went wrong, fix");
            }
        });
    };

    $scope.update = function(){
        $http({
            url : "/admin/users/update",
            method : "JSON",
            data : $scope.data,
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                if(data.data.valid) {
                    $scope.getUsers();
                }
                $scope.emptyData();
            } else {
                console.log("something went wrong, fix");
            }
        });
    };

    $scope.edit = function(elem) {
        $scope.editing = true;
        $scope.data = {
            id: elem.id,
            email : {
                value : elem.email,
                error : "",
                hasError : false
            },
            password : {
                value : "",
                error : "",
                hasError : false
            },
            authority : {
                value : parseInt(elem.authority),
                error : "",
                hasError : false
            }
        };
    };

    $scope.cancel = function(){
        $scope.editing = false;
        $scope.emptyData();
    };

    $scope.emptyData = function () {
        $scope.data = {
            email : {
                value : "",
                error : "",
                hasError : false
            },
            password : {
                value : "",
                error : "",
                hasError : false
            },
            authority : {
                value : 2,
                error : "",
                hasError : false
            }
        };
    };

    $scope.delete = function(elem) {
        if(!confirm("Are you sure?")) {
            return;
        }

        $http({
            url : "/admin/users/delete",
            method : "JSON",
            data : {
                id : elem.id
            },
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.getUsers();
            } else {
                console.log("something went wrong, fix");
            }
        });
    }
});