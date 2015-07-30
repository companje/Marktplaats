app.controller('Home', function($scope, $http) {
  console.log('Home');
  $scope.items = [];

  $scope.populateCategory = function (category) {
    $http.get('/api/marktplaats.php?category='+category.id)
    .success(function(data) {
      $scope.items.push(data);
      console.info($scope.items);
    });
  }


  $http.get('/api/findCategories.php')
  .success(function (data) {
    console.info(data);
    data.forEach(function (category) {
      $scope.populateCategory(category);
    });
  });
  
  //var terms = $scope.terms = JSON.parse(localStorage.getItem("terms")) || [];

  //console.log('Home',terms);

  /*$scope.add = function(term) {
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
  }*/

});

