/**
 * Created by Vilim Stubičan on 7.3.2015..
 */


app.controller("registrationController", function($scope, $http, $timeout){
    /**
     * Form model.
     * @type {{email: {value: string, error: string, hasError: boolean}, password: {value: string, error: string, hasError: boolean}, passwordRepeat: {value: string, error: string, hasError: boolean}}}
     */
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
        passwordRepeat : {
            value : "",
            error : "",
            hasError : false
        }
    };

    /**
     * On change of the value, remove errors.
     */
    $scope.$watch("data.email.value", function(newValue, oldValue){
        $scope.data.email.error = "";
        $scope.data.email.hasError = false;
    });

    $scope.$watch("data.password.value", function(newValue, oldValue){
        $scope.data.password.error = "";
        $scope.data.password.hasError = false;
    });

    $scope.$watch("data.passwordRepeat.value", function(newValue, oldValue){
        $scope.data.passwordRepeat.error = "";
        $scope.data.passwordRepeat.hasError = false;
    });

    /**
     * Perform registration. If there are some errors, disregard registration and display them.
     */
    $scope.register = function(){
        $http({
            url: "/registration/register",
            method: "JSON",
            data: {
                data : $scope.data
            },
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                if(data.data.valid) {
                    $scope.successMessage = data.data.successMessage;
                    $timeout(function(){
                        window.location.href = "/";
                    },5000);
                }
                $scope.data = data.data.data;
            } else {
                console.log("something went wrong, fix this");
            }
        })
    }
});