/**
 * Created by Vilim Stubičan on 10.3.2015..
 */

app.controller("loginController", function($scope, $http, $timeout){
    $scope.data = {
       email : {
           value : ""
       },
       password : {
           value : ""
       },
       error : {
           value : "",
           hasError : false
       }
    };

    $scope.login = function(){
        $http({
            url : "/login/login",
            method : "JSON",
            data : {
                data : $scope.data
            },
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                if(data.data.valid) {
                    window.location.href = "/";
                } else {
                    $scope.data = data.data.data.data;

                }
            } else {
                console.log("something went wrong, fix");
            }
        })
    }


});