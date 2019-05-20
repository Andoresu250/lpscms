'use strict';
(function (angular) {
    angular
        .module('lps')
        .controller('testCtrl', ['$scope', testCtrl]);
    
    function testCtrl($scope){
        console.log('test controller init')
        var vm = $scope;
        vm.word = 'en tu cara wordpress';
        console.log(vm.word);
    }
})(angular);
