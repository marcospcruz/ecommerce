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
var checkoutViewController=function($scope,$http){
	var path=url+'cart/checkoutBuilder.php';
	console.log('checkoutViewController ajax para '+path);
	$http.get(path).then(function(response){
		$scope.cart=response.data[0].cart;
		$scope.cartValorTotal=response.data[1].totalCompra;
		document.getElementById('cart_qt').innerHTML=response.data[2].totalItensCarrinho;		
		console.log(JSON.stringify(response.data[0].cart));
		
	},function(response){console.log('erro:'+JSON.stringify(response));});

	$scope.calculaFrete=function(){
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
			console.log(JSON.stringify(response.data));
			$scope.pacotes=response.data;

		},function(response){
			
			alert('Erro:'+JSON.stringify(response));
	
		});
		

	}

};

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
