app.controller('Results', function($scope, $http, $routeParams) {

  var term = $scope.term = $routeParams.term;

  $http.get('api/marktplaats.php?search='+term+"&since=yesterday").success(function(data) { // 'api/sanyo.json'
    $scope.items = data.items;
  });

});



// app.controller('App', ['$scope', '$http', function($scope, $http) {
//   // localStorage.removeItem("terms");
//   // console.log(localStorage.getItem("terms"))
//   // $scope.terms = localStorage.getItem("terms");
//   // $scope.terms = JSON.parse(localStorage.getItem("terms")) || [];
//   // if ($scope.terms.indexOf("test3")<0) {
//   //   $scope.terms.push("test3");
//   // }
//   // console.log(JSON.stringify($scope.terms));
//   // localStorage.setItem("terms",JSON.stringify($scope.terms));
//   // console.log($scope.searches);

//   $http.get('api/sanyo.json').success(function(data) { //'api/marktplaats.php?search=sanyo'
//     $scope.phones = data.items;
//   });

//   $scope.orderProp = 'age';
// }]);

