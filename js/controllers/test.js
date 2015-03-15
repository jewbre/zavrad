/**
 * Created by Vilim Stubičan on 10.3.2015..
 */

app.controller("testController", function($scope, $http, $timeout){
    $(".draggable").draggable({
        scroll: true,
        grid: [ 50, 50 ],
        containment: "parent",
        stop: function() {
            console.log($(this).css("top") + ", " + $(this).css("left"));
        }
    });
    console.log("unutra sam");
});