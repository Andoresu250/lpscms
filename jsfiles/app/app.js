'use strict';
angular.module('lps', [])
console.log('angular module init');
angular.element(function() {
    angular.bootstrap(document, ['lps']);
    console.log('web page binded with angular model')
});