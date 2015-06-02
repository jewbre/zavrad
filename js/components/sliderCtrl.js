/**
 * Created by Vilim Stubičan on 25.5.2015..
 */

app.controller("sliderCtrl", ["$scope","$timeout",
    function($scope, $timeout){
        $scope.current = 0;
        $scope.size = 1;
        $scope.sliderActive = false;
        $scope.period = 5000;

        $
        $scope.slideNext = function(){
            $scope.current = (++$scope.current) % $scope.size;
        };

        $scope.slidePrev = function(){
            var prev = $scope.current-1;
            if(prev < 0) prev = $scope.size-1;
            $scope.current = prev;
        };

        $scope.rollSliderFront = function(){
            $scope.slideNext();
            $scope.$apply();
            $timeout(function(){
                $scope.rollSliderFront();
            }, $scope.period);
        };

        $scope.rollSliderBack = function(){
            $scope.slidePrev();
            $timeout(function(){
                $scope.rollSliderBack();
            },$scope.period);
        };

        $scope.startSlider = function(){
            if(!$scope.sliderActive) {
                $scope.sliderActive = true;
                $timeout(function(){
                    $scope.rollSliderFront();
                },$scope.period);
            }
        };

        $scope.amIActive = function(id){
            return id == $scope.current;
        };

        $scope.amINext = function(id){
            return id == ($scope.current+1)%$scope.size;
        };

        $scope.amIPrev = function(id){
            return id == ($scope.current+$scope.size-1)%$scope.size;
        };

        $scope.$watch("size", function(){
            $scope.startSlider();
        });
}]);