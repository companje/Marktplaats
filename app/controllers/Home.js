app.controller('Home', function($scope, $http) {
  console.log('Home');
  
  var terms = $scope.terms = JSON.parse(localStorage.getItem("terms"));

  console.log('Home',terms);

  $scope.add = function(term) {
    console.log(term);

    if (terms.indexOf(term)==-1) {
      terms.push(term);
      localStorage.setItem("terms",JSON.stringify(terms));
    }
  }

  $scope.confirmRemove = function(term) {
    if (window.confirm('remove "' + term + '"?')) {
      $scope.remove(term);
    }
  }

  $scope.remove = function(term) {
    var index = terms.indexOf(term);
    if (index!=-1) terms.splice(index,1);
    localStorage.setItem("terms",JSON.stringify(terms));
  }

});

