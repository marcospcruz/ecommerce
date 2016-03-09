var urlCartAction='../backend/cart/updateCart.php';
/**
  *
  **/
var updateCartFunction=function($scope,$http,$routeParams,$location){
	console.log('- adicionando item no carrinho.');
	console.log('routeparams:'+JSON.stringify($routeParams));
	var data=JSON.stringify({idProduto:$routeParams.idProduto,action:$routeParams.action});
		console.log('data:'+JSON.stringify($routeParams));
	$http({
		method: 'POST',
		url:	urlCartAction,
		data:	data,
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
	}).then(function(response){
		console.log(JSON.stringify(response.data));
		document.getElementById('cart_qt').innerHTML=response.data;
		//alert(document.getElementById('cart_qt').innerHTML);
		

	},function(response){
		console.log('erro em addCartFunction:'+JSON.stringify(response));
	});
	if($routeParams.origemRequest=="vitrine"){
		$location.path('loja');
	}else if($routeParams.origemRequest=="cart"){
		$location.path('checkout');
	}
};

/**
  *
  **/
var loadVitrine=function($scope,$http,$routeParams){
	var path=url+"action/vitrineAction.php";
	console.log('loadVitrine:'+path);
	$http({
		method: 'POST',
		url:	path,
		data:	JSON.stringify({idTipoProduto:$routeParams.idTipoProduto}),
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }	
	}).then(function(response){
		$scope.myData=response.data[1];
		document.getElementById('cart_qt').innerHTML=response.data[0].totalItensCarrinho;
		console.log(response.data);

	},function(response){console.log('erro em loadVitrine:'+JSON.stringify(response));});
}
/**
  *
  **/
var checkoutViewController=function($scope,$http,svc){
	
	var path=url+'cart/checkoutBuilder.php';
	console.log('checkoutViewController ajax para '+path);
	$http.get(path).then(function(response){
		$scope.cart=response.data[0].cart;
		$scope.cartValorTotal=response.data[1].totalCompra;
		document.getElementById('cart_qt').innerHTML=response.data[2].totalItensCarrinho;		
		console.log(JSON.stringify(response.data[0].cart));
		
	},function(response){console.log('erro:'+JSON.stringify(response));});

	$scope.teste=function(){
		svc.calculaFrete($scope,$http);
	};

};
var calcula=function($scope,$http){
		var valorCep=$scope.cep.prefixo+$scope.cep.sufixo;
		var data=JSON.stringify({cepDestino:valorCep});
		var path=url+'calculaFrete.php';

		console.log('calculaFrete: ajax para '+path);

		$http({
			method:	'POST',
			url:	path,
			data: 	data,			
			headers:{ 'Content-Type': 'application/x-www-form-urlencoded' }
		}).then(function(response){
			
			var json=response.data;
			$scope.frete=json;
			
			var simboloMoeda=document.getElementById("vlTotalCompra").innerHTML.substring(0,2);
			console.log(simboloMoeda);
			var valorTotalCompra=parseFloat(document.getElementById("vlTotalCompra").innerHTML.substring(2).replace(',','.'));
			console.log('-->'+valorTotalCompra);
	
			for(var i=0;i<json.length;i++){
				//console.log(i);
				var row=json[i];
				for(var j=0;j<row.length;j++){
					var obj=row[j];
					//console.log(obj['descricaoServico']);
					valorTotalCompra+=parseFloat(obj['valorServico']);
				}

			}
			var valorTotalString=String(valorTotalCompra.toFixed(2));
			//adicionando casas de centavos ao valor inteiro.
			//if((valorTotalCompra%1)==0){
			//	valorTotalString+='.00';
			//}
			document.getElementById("vlTotalCompra").innerHTML=simboloMoeda+valorTotalString.replace('.',',');

		},function(response){
			
			console.log('Erro:'+JSON.stringify(response));
	
		});

		//console.log($scope.servicos);

	};


/*angular.module('myServicesFactory',[])
	.factory('myServices',function(){
	alert('x');
	var service;
	service.funcao=[];
	service.funcao.calculaFrete=calculaFrete;
	return service;
});*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function justNumber(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}

function autoTab(from,to){
	if(from.getAttribute("maxLength")==from.value.length){
		to.focus();
	}
}
