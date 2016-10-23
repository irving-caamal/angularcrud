(function () {
    var movie = {};
    var app = angular.module('controller', []);
    app.controller('personCtrl', function ($scope, $state, personSrv) {
        function getAll() {
            $scope.datas = personSrv.query();
        };
        getAll();
        $scope.add = function () {
            movie = {};
            $state.go('form');
        };
        $scope.edit = function (data) {
            movie = data;
            $state.go('form');
        };
        $scope.remove = function (id){
            var r = confirm("Seguro que desea eliminar: ? ");
            if (r === true) {
                personSrv.delete({id: id}, function () {
                    getAll();
                    alert('Eliminado correctamente');
                });
            } else {
                getAll();
            }
        };
    });
    app.controller('formCtrl', function ($scope, $state, personSrv) {
        $scope.post = movie;
        $scope.back = function () {
            $state.go('movie');
        };
        $scope.save = function () {
            if ($scope.post.id === undefined) {
                personSrv.save($scope.post, function () {
                    //$scope.post = '';
                    
                    alert('Guardado Correctamente');
                    //$state.go('movie');
                });
            } else {
                personSrv.update($scope.post, function () {
                    alert('Actualizado Correctamente');
                });
            }
        };
    });
})();