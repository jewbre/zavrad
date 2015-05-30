/**
 * Created by Vilim Stubičan on 10.3.2015..
 */

app.controller("loginController", function($scope, $http){
    /**
     * Form model.
     * @type {{email: {value: string}, password: {value: string}, error: {value: string, hasError: boolean}}}
     */
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

    /**
     * Perform login functionality. If there is some error, display message and disregard login.
     */
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
                    window.location.href = data.data.redirect;
                } else {
                    $scope.data = data.data.data.data;

                }
            } else {
                console.log("something went wrong, fix");
            }
        })
    }


});