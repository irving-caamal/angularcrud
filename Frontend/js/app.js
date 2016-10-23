(function () {
    var app = angular.module('app', [
        'ngResource',
        'ui.router',
        'service',
        'controller'
    ]);
    app.config(function ($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.otherwise('/movie');
        $stateProvider.state('movie', {
            url: '/movie',
            templateUrl: 'views/movie.html',
            controller: 'personCtrl'
        }).state('form', {
            url: '/form',
            templateUrl: 'views/form.html',
            controller: 'formCtrl'
        });
    });
})();

