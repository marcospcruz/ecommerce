'use strict';

/* App Module */

var ecommerceApp=angular.module('ecommerceApp',['ngSanitize','ngRoute','ecommerceControllers']);

ecommerceApp.config(['$routeProvider',
	function($routeProvider){
		$routeProvider.
			when('/loja',{templateUrl: 'vitrine.html',controller:	'vitrineController'}).
			when('/loja/:idTipoProduto',{templateUrl:'vitrine.html',controller:'vitrineController'}).
			when('/loja/:action/:idProduto/:origemRequest',{templateUrl:'vitrine.html',controller:'atualizaCarrinhoController'}).
			when('/loja/add/:idProduto/:origemRequest',{templateUrl:'vitrine.html',controller:'adicionaItemController'}).
			when('/checkout',{templateUrl:'checkout.html',controller:'checkoutController'}).
			otherwise({redirectTo:'/loja'});
	}
]);



ecommerceApp.factory('svc',function(){
	var msg="original...";
	var objeto=[];
	return {
			addElementAttribute:function(attrib,value){
				objeto={attrib:value};
			},
			dellElementAttribute:function(attrib){
				delete objeto.attrib;			
			},
			getElementAttribValue:function(attrib){
				return objeto.attrib;	
			},
			getElement:function(){
				return objeto;			
			},
			getArray:function(){
				return array;			
			},
			setMessage:function(x){
				msg=x;
			},	
			getMessage:function(x){

				return msg;	
			},
			calculaFrete:calcula

		};
	
});


