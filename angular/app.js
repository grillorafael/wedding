angular.module('wedding', [])
    .controller('AppCtrl', ['$scope', '$http', function($scope, $http) {
        $scope.reveal = function() {
            scrollReveal.init();
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

        $scope.submit = function() {
            $http({
                url: 'https://api:key-0qsp-amfc75mfw-u0ggm-grp0b4jmis1@api.mailgun.net/v3/rgrillo.com/messages',
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                data: $.param({
                    from: "Rafael Grillo <grillorafael@gmail.com>",
                    to: $scope.rsvp.email,
                    subject: "Confirmação de " + $scope.rsvp.name,
                    text: "O convidado " + $scope.rsvp.name + " confirmou a presença de " + $scope.rsvp.guests + " convidados."
                })
            });
        };

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
