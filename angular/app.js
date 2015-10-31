angular.module('wedding', [])
    .controller('AppCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.mailSent = false;
        $scope.rsvp = {};

        $scope.reveal = function() {
            try {
                scrollReveal.init();
            }
            catch(e) {

            }
        };

        $scope.slidesRefresh = function() {
            setTimeout(function() {
                $('#slides').superslides({
                    play: 5000,
                    animation_speed: 2000,
                    animation: 'fade',
                    pagination: false
                });
            }, 200);
        };

        $scope.submit = function(rsvp) {
            if(rsvp && rsvp.name && rsvp.guests) {
                $http.post('http://rgrillo.com/process.php', rsvp).success(function() {
                    $scope.mailSent = true;
                }).error(function() {
                    alert('Não foi possível enviar o formulário');
                });
            }
            else {
                alert('Não foi possível enviar o formulário');
            }
        };

        $http.get('data/slides.json').
        success(function(data) {
            $scope.slides = data;

            $scope.slidesRefresh();
            $scope.reveal();
        }).
        error(function(data) {});

        $http.get('data/vips.json').
        success(function(data) {
            $scope.vips = data;
            $scope.reveal();
        }).
        error(function(data) {});

        $http.get('data/gallery.json').
        success(function(data) {
            $scope.gallery = data;
            $scope.reveal();
        }).
        error(function(data) {});
    }]);
