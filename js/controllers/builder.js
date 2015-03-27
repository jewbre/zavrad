/**
 * Created by Vilim Stubičan on 14.3.2015..
 */

app.controller("builderController", function($scope, $http, $timeout, $compile){
    $scope.models = {};
    $scope.count = 1;
    $scope.designName = "";
    $scope.designId = "";

    /**
     * Retrieve components from database.
     */
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
    };
    $scope.getComponents();

    /**
     * Appends new component to the grid of the builder. Attaches listeners to the same object and provides it its functionality.
     * @param elem
     */
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

    /**
     * Handles drag event. Invoked at the stop of the drag. Updates $scope value of the component and checks for collisions.
     * @param name
     */
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

    /**
     * Check collisions for all objects on the grid.
     */
    $scope.checkCollisions = function() {
        // Remove current collision results
        $(".collision").removeClass("collision");

        for(k1 in $scope.models) {
            var main = $scope.models[k1];
            var x1 = parseInt(main.position.x);
            var x2 = x1 + parseInt(main.width);
            var y1 = parseInt(main.position.y);
            var y2 = y1 + parseInt(main.height);
            // Check for boundaries.
            if(y1 < 0 || x1<0 || x2 > 12 || x1 > 12) {
                $("#"+main.objName).addClass("collision");
            }

            // Check for collissions between components.
            for(k in $scope.models){
                if(k == k1) continue;
                var tmp = $scope.models[k];
                var x3 = parseInt(tmp.position.x);
                var x4 = x3 + parseInt(tmp.width);
                var y3 = parseInt(tmp.position.y);
                var y4 = y3 + parseInt(tmp.height);

                // Mathematical check ups. If x1 if left border of the first component and x2 = x1 + component.width and x3 and x4
                // same values of the second component, then check horizontal collision it is either required that x1 left of the
                // second component and x2 inside of the same, or that x1 is inside or on the left border of the second component.
                // Same case is worth for vertical check up.
                var hCheck = (x1 < x3 && x2 > x3) || (x1 >= x3 && x1 < x4);
                var vCheck = y1 < y3 && y2 > y3 || y1 >= y3 && y1 < y4;

                // If both collisions happened, then the two components are crossing one over another.
                if(hCheck && vCheck){
                    $("#"+main.objName).addClass("collision");
                    $("#"+tmp.objName).addClass("collision");
                }

            }
        }
    };

    /**
     * Slider function. Slides components list in provided direction.
     * @param direction "left"|"right"
     */
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
    };

    /**
     * Remove component element from the grid. Recheck collisions after removal.
     * @param elemName
     */
    $scope.delete = function(elemName) {
        $("#"+elemName).remove();
        var newArray = {};
        for(k in $scope.models) {
            if(k == elemName) continue;
            newArray[k] = $scope.models[k];
        }
        $scope.models = newArray;
        $scope.checkCollisions();
    };

    $scope.reset = function(){
        if(confirm("Are you sure?")) {
            $scope.emptyGrid();
        }
    };


    $scope.emptyGrid = function(){
        for(key in $scope.models) {
            $("#"+$scope.models[key].objName).remove();
        }
        $scope.models = {};
        $scope.count = 1;
        $scope.designName = "";
        $scope.designId = "";
    }

    $scope.save = function (){
        console.log($scope.models);
        if($scope.designName == "") {
            alert("Enter valid design name");
            $("#design-name").addClass("errorBorder");
            return;
        } else {
            $("#design-name").removeClass("errorBorder");
        }
        if($(".collision").length > 0) {
            alert("You have collisions. Resolve them before saving.");
            return;
        }

        var url = "/admin/design/save";
        if($scope.designId != "") {
            url = "/admin/design/update";
        }
        $http({
            url: url,
            method: "JSON",
            data : {
                id : $scope.designId,
                name : $scope.designName,
                data : $scope.models
            },
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            $scope.getDesigns();
        })
    }

    $scope.getDesigns = function(){
        $http({
            url: "/admin/design/all",
            method: "JSON",
            headers: {
                'Content-Type': "x www form urlencoded"
            }
        }).success(function(data){
            if(data.success){
                $scope.designs = data.data;
            } else {
                console.log("something went wrong, fix this");
            }
        })
    };
    $scope.getDesigns();

    $scope.deleteDesign = function(elem){
      if(confirm("Are you sure?")){
          $http({
              url: "/admin/design/delete",
              method: "JSON",
              data : {
                  id : elem.id
              },
              headers: {
                  'Content-Type': "x www form urlencoded"
              }
          }).success(function(data){
              $scope.getDesigns();
          })
      }
    };
    $scope.load = function(elem) {
        $scope.emptyGrid();
        $scope.designId = angular.copy(elem.id);
        $scope.designName = angular.copy(elem.name);
        var data = angular.copy(elem.data);
        for(key in data) {
            var el = angular.copy(data[key]);
            $scope.addLoadedElem(el);
            var c = parseInt(key.substr(key.indexOf("-")+1));
            if(c > $scope.count) $scope.count = c+1;
        }

    };

    $scope.addLoadedElem = function(el){
        var obj = '<div class="grid-element grid-rows-'
            + el.height +
            ' grid-cols-'
            + el.width +
            '" id="'
            + el.objName +
            '"><div class="ruler"></div>' +
            '<div class="delete-model" ng-click="delete(\''+ el.objName +'\')">' +
            '<i class="fa fa-trash fa-lg"></i>' +
            '</div>'+el.name+'</div>';
        $("div[data-id='theGrid']").append($compile(obj)($scope));
        $scope.models[el.objName] = el;

        var newObj = $("#"+el.objName);
        newObj.css("top",""+(50+el.position.y*50)+"px");
        newObj.css("left",""+(250+el.position.x*50)+"px");

        newObj.draggable({
            scroll: true,
            grid: [ 50, 50 ],
            containment: "parent",
            start: function() {
                $(".collision").removeClass("collision");
            },
            stop: function() {
                $scope.handleDrag(el.objName);
            }
        });

        newObj.css("opacity","1");
    }

});