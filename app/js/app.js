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
	var objeto={};
	return {
			addObjetoAttribValue:function(attrib,value){
				//objeto={attrib:value};
				objeto[attrib]=value;
			},
			dellElementAttribute:function(attrib){
				delete objeto.attrib;			
			},
			getObjetoAttribValue:function(attrib){
				return objeto[attrib];	
			},
			getObjeto:function(){
				return objeto;			
			},
			setObjeto:function(x){
				objeto=x;			
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


