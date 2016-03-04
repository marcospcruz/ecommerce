var urlCartAction='../backend/cart/updateCart.php';

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



var loadVitrine=function($scope,$http,$routeParams){
	console.log('loadVitrine:'+url+"/vitrineAction.php");
	$http({
		method: 'POST',
		url:	url+"action/vitrineAction.php",
		data:	JSON.stringify({idTipoProduto:$routeParams.idTipoProduto}),
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }	
	}).then(function(response){
		$scope.myData=response.data[1];
		$scope.totalItensCarrinho=response.data[0].totalItensCarrinho;

	},function(response){console.log('erro em loadVitrine:'+JSON.stringify(response));});
}

var checkoutViewController=function($scope,$http){

	$http.get(url+'/cart/checkoutBuilder.php').then(function(response){
		$scope.cart=response.data[0].cart;
		$scope.cartValorTotal=response.data[1].totalCompra;
		document.getElementById('cart_qt').innerHTML=response.data[2].totalItensCarrinho;		
		console.log(JSON.stringify(response.data[0].cart));
		
	},function(response){console.log('erro:'+JSON.stringify(response));});

};
