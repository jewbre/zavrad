/**
 * Created by Vilim Stubičan on 12.3.2015..
 */

app.controller("componentsController", function($scope, $http){
    $scope.editing = false;
    $scope.component = {
        id : 0,
        name : {
            value : "",
            error : ""
        },
        template : {
            value : "",
            error : ""
        },
        dimensions : {
            width : "",
            height : "",
            error : ""
        },
        description : {
            value : "",
            error : ""
        },
        hasError : false
    };

    $scope.getComponents = function(){
        $http({
            url: "/admin/components/get",
            method: "JSON",
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                $scope.components = data.data.components;
            } else {
                console.log("something went wrong, fix this");
            }
        })
    };

    $scope.save = function(){
        $http({
            url: "/admin/components/save",
            method: "JSON",
            data: {
                data : $scope.component
            },
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                if(!data.data.params.hasError) {
                    $scope.components = data.data.components;
                }
                $scope.component = data.data.params;
            } else {
                console.log("something went wrong, fix this");
            }
        })
    };

    $scope.edit = function(elem){
        elem = elem.component;
        $scope.editing = true;
        $scope.fillFromElement(elem);
        $scope.emptyComponentErrors();

        $scope.component.hasError = false;
    };

    $scope.cancel = function(){
        $scope.editing = false;
        $scope.emptyComponent();
        $scope.emptyComponentErrors();
    };

    $scope.update = function(){
        $http({
            url: "/admin/components/update",
            method: "JSON",
            data: {
                data : $scope.component
            },
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success) {
                if(!data.data.params.hasError) {
                    $scope.components = data.data.components;
                    $scope.editing = false;
                }
                $scope.component = data.data.params;
            } else {
                console.log("something went wrong, fix this");
            }
        })
    };

    $scope.delete = function(elem) {
        if(confirm("Are you sure?")) {
            $http({
                url: "/admin/components/delete",
                method: "JSON",
                data: {
                    data : elem.component
                },
                headers: {
                    'Content-Type': "x www form urlencoded"
                }
            }).success(function(data){
                if(data.success) {
                    $scope.components = data.data.components;
                } else {
                    console.log("something went wrong, fix this");
                }
            })
        }
    };

    // helper functions
    $scope.fillFromElement = function(elem) {
        $scope.component.id = elem.id;
        $scope.component.name.value = elem.name;
        $scope.component.template.value = elem.template;
        $scope.component.dimensions.width = elem.width;
        $scope.component.dimensions.height = elem.height;
        $scope.component.description.value = elem.description;
    };

    $scope.emptyComponent = function(){
        $scope.component.id = "";
        $scope.component.name.value = "";
        $scope.component.template.value = "";
        $scope.component.dimensions.width = "";
        $scope.component.dimensions.height = "";
        $scope.component.description.value = "";
    };

    $scope.emptyComponentErrors = function() {
        $scope.component.name.error = "";
        $scope.component.template.error = "";
        $scope.component.dimensions.error = "";
        $scope.component.description.error = "";

        $scope.component.hasError = false;
    };

    $scope.getComponents();
});