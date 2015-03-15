/**
 * Created by Vilim Stubičan on 14.3.2015..
 */

app.controller("builderController", function($scope, $http, $timeout, $compile){
    $scope.models = [];
    $scope.count = 1;

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
                $(".wrapper").css("width",145 * $scope.components.length);
            } else {
                console.log("something went wrong, fix this");
            }
        })
    }
    $scope.getComponents();

    $scope.addNewComponent = function(elem) {
        elem = elem.component;
        var objName = "component-"+$scope.count;
        $scope.count++;
        var newModel = angular.copy(elem);
        newModel.objName = objName;
        newModel.position = { x : 0, y : 0 };
        var obj = '<div class="grid-element grid-rows-'
            + newModel.height +
            ' grid-cols-'
            + newModel.width +
            '" id="'
            + newModel.objName +
            '"><div class="ruler"></div>' +
            '<div class="delete-model" ng-click="delete(\''+ newModel.objName +'\')">' +
            '<i class="fa fa-trash fa-lg"></i>' +
            '</div>'+newModel.name+'</div>';
        $("div[data-id='theGrid']").append($compile(obj)($scope));
        $scope.models[objName] = newModel;

        var newObj = $("#"+newModel.objName);
        newObj.css("top","50px");
        newObj.css("left","250px");

        newObj.draggable({
            scroll: true,
            grid: [ 50, 50 ],
            containment: "parent",
            start: function() {
              $(".collision").removeClass("collision");
            },
            stop: function() {
                $scope.handleDrag(objName);
            }
        });

        newObj.css("opacity","1");

        $scope.checkCollisions();
    };

    $scope.handleDrag = function(name){
        $timeout(function(){
            var elem = $("#"+name);
            tmp = elem.css("top");
            var y = parseInt(tmp.substr(0,tmp.length-2))/50 - 1;
            tmp = elem.css("left");
            var x = parseInt(tmp.substr(0,tmp.length-2))/50 - 5;
            $scope.models[name].position.x = x;
            $scope.models[name].position.y = y;
            $scope.checkCollisions();
        },400);
    };

    $scope.checkCollisions = function() {
        $(".collision").removeClass("collision");
        for(k1 in $scope.models) {
            var main = $scope.models[k1];
            var x1 = parseInt(main.position.x);
            var x2 = x1 + parseInt(main.width);
            var y1 = parseInt(main.position.y);
            var y2 = y1 + parseInt(main.height);
            if(y1 < 0 || x1<0 || x2 > 12 || x1 > 12) {
                $("#"+main.objName).addClass("collision");
            }
            for(k in $scope.models){
                if(k == k1) continue;
                var tmp = $scope.models[k];
                var x3 = parseInt(tmp.position.x);
                var x4 = x3 + parseInt(tmp.width);
                var y3 = parseInt(tmp.position.y);
                var y4 = y3 + parseInt(tmp.height);
                var hCheck = (x1 < x3 && x2 > x3) || (x1 >= x3 && x1 < x4);
                var vCheck = y1 < y3 && y2 > y3 || y1 >= y3 && y1 < y4;
                if(hCheck && vCheck){
                    $("#"+main.objName).addClass("collision");
                    $("#"+tmp.objName).addClass("collision");
                }

            }
        }
    };

    $scope.listModels = function(direction) {
        var elem = $("div[data-id='wrapper']");
        var parentEl = elem.parent();
        var tmp = elem.css("margin-left");
        var margin = parseInt(tmp.substr(0, tmp.length-2));
        tmp = parentEl.css("width");
        var offset = parseInt(tmp.substr(0, tmp.length-2)) - 120;
        var totalWidth = 145*$scope.components.length;
        if(offset > totalWidth) return;
        if(direction == "left") {
            margin += offset;
            if (margin > 0) margin = 0;
        } else {
            margin -= offset;
            if( -margin + offset > totalWidth) {
                margin = -totalWidth + offset + 180;
            }
        }
        elem.css("margin-left",margin+"px");
    }

    $scope.delete = function(elemName) {
        $("#"+elemName).remove();
        var newArray = [];
        for(k in $scope.models) {
            if(k == elemName) continue;
            newArray[k] = $scope.models[k];
        }
        $scope.models = newArray;
        $scope.checkCollisions();
    }

});