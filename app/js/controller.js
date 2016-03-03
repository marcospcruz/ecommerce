'use strict';

/* Controllers */
var ecommerceApp=angular.module('ecommerceApp',[]);

ecommerceApp.controller('ecommerceLayoutCntrl',function($scope,$http){
	$http.get("http://localhost/xtreme/site2/loja/action/startupAction.php").then(function(response){
		console.log(JSON.stringify(response));
		$scope.myData=response.data[1];
		$scope.totalItensCarrinho=response.data[0].totalItensCarrinho;

	},function(response){console.log('erro'+JSON.stringify(response));});

	
});
