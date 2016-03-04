var urlCartAction='../backend/cart/updateCart.php';
var addCartFunction=function($scope,$http,$routeParams,$location){
	console.log('- adicionando item no carrinho.');
	var data=JSON.stringify({idProduto:$routeParams.idProduto,action:'add'});
	$http({
		method: 'POST',
		url:	urlCartAction,
		data:	data,
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
	}).then(function(response){
		console.log(JSON.stringify(response.data));
		document.getElementById('cart_qt').innerHTML=response.data;
		//alert(document.getElementById('cart_qt').innerHTML);
		$location.path('#/loja');

	},function(response){
		console.log('erro em addCartFunction:'+JSON.stringify(response));
	});
};



var loadVitrine=function($scope,$http,$routeParams){
	console.log('loadVitrine:'+url+"/vitrineAction.php");
	$http({
		method: 'POST',
		url:	url+"/vitrineAction.php",
		data:	JSON.stringify({idTipoProduto:$routeParams.idTipoProduto}),
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }	
	}).then(function(response){
		$scope.myData=response.data[1];
		$scope.totalItensCarrinho=response.data[0].totalItensCarrinho;

	},function(response){console.log('erro em loadVitrine:'+JSON.stringify(response));});
}

var checkoutViewController=function($scope,$http){

	$http.get('http://localhost/xtreme/site2/loja/cart/checkoutBuilder.php').then(function(response){
		$scope.cart=response.data[0].cart;
		$scope.cartValorTotal=response.data[1].totalCompra;
		document.getElementById('cart_qt').innerHTML=response.data[2].totalItensCarrinho;		
		//console.log(JSON.stringify(response.data[response.data.length-1].totalCompra));
	},function(response){console.log('erro:'+JSON.stringify(response));});
};
