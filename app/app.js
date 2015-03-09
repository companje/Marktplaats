'use strict';

var app = angular.module('app', ['ngRoute']);

app.config(['$routeProvider', function ($routeProvider) {

  $routeProvider.when('/', {templateUrl:'app/views/Home.html', controller:'Home'});
  $routeProvider.when('/results/:term', {templateUrl:'app/views/Results.html',controller:'Results'});

}]);
