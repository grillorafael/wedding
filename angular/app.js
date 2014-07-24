angular.module('wedding', [])
    .controller('AppCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.reveal = function() {
            new scrollReveal({reset: true});
        }

        $scope.slidesRefresh = function() {
            setTimeout(function() {
                $('#slides').superslides({
                    play: 5000,
                    animation_speed: 2000,
                    animation: 'fade',
                    pagination: false
                });
            }, 200);
        }

        $http.get('data/slides.json').
            success(function(data) {
                $scope.slides = data;

                $scope.slidesRefresh();
                $scope.reveal();
            }).
            error(function(data) {
            });

        $http.get('data/vips.json').
            success(function(data) {
                $scope.vips = data;
                $scope.reveal();
            }).
            error(function(data) {
            });

        $http.get('data/gallery.json').
            success(function(data) {
                $scope.gallery = data;
                $scope.reveal();
            }).
            error(function(data) {
            });
    }]);
