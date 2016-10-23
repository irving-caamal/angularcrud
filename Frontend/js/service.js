(function () {
    var app = angular.module('service', []);
    app.factory('personSrv',function ($resource){
         return $resource('../Backend/movie/:id', {id: '@id'}, {
            'update': {method: 'PUT'}
        });
    });
})();