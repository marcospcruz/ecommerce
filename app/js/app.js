'use strict';

/* App Module */

var ecommerceApp=angular.module('ecommerceApp',['ngSanitize','ngRoute','ecommerceControllers']);

ecommerceApp.config(['$routeProvider',
	function($routeProvider){
		$routeProvider.
			when('/loja',{
				templateUrl: 	'vitrine.html',
				controller:	'vitrineController'	
			}).
			when('/loja/:idTipoProduto',{
				templateUrl: 	'vitrine.html',
				controller:	'vitrineController'	
			}).
			otherwise({
				redirectTo: 	'/loja'
			});
	}
]);
