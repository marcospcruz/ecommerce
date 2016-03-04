var app=angular.module('loja-app',["ngSanitize"]);

app.controller('loja-app-Cntrl',function ($scope,$http){
	$http.get("action/vitrineAction.php").then(function(response){
		$scope.myData=response.data;

	});

	$scope.eventos={};
	//$scope.eventos.addCart=addToCart;
});




