'use strict';

/* Controllers */

var url="http://localhost/xtreme/site2/loja/action";

var ecommerceControllers=angular.module('ecommerceControllers',[]);

ecommerceControllers.controller('ecommerceLayoutCntrl',['$scope','$http',function($scope,$http){
	$http.get(url+"/startupAction.php").then(function(response){

		$scope.totalItensCarrinho=response.data[0].totalItensCarrinho;
		$scope.myData=response.data[1].categoriasProdutos;		
		$scope.anoAtual=response.data[2].anoAtual;		
		//console.log(JSON.stringify($scope.totalItensCarrinho));
	},function(response){console.log('erro'+JSON.stringify(response));});

	
}]);

ecommerceControllers.controller('vitrineController',['$scope','$http','$routeParams',loadVitrine]);

ecommerceControllers.controller('adicionaItemController',['$scope','$http','$routeParams','$location',addCartFunction]);


