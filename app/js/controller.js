'use strict';

/* Controllers */

var url="../backend/";

var ecommerceControllers=angular.module('ecommerceControllers',[]);

ecommerceControllers.controller('ecommerceLayoutCntrl',['$scope','$http',function($scope,$http){
	
	$http.get(url+"action/startupAction.php").then(function(response){
		console.log('ecommerceLayoutCNtrl: '+JSON.stringify(response));
		$scope.totalItensCarrinho=response.data[0].totalItensCarrinho;
		$scope.myData=response.data[1].categoriasProdutos;		
		$scope.anoAtual=response.data[2].anoAtual;		
		//console.log(JSON.stringify($scope.totalItensCarrinho));
	},function(response){console.log('Erro em ecommerceLayoutCntrl:'+JSON.stringify(response));});

	
}]);

ecommerceControllers.controller('vitrineController',['$scope','$http','$routeParams',loadVitrine]);

ecommerceControllers.controller('atualizaCarrinhoController',['$scope','$http','$routeParams','$location',updateCartFunction]);

ecommerceControllers.controller('checkoutController',['$scope','$http',checkoutViewController]);

