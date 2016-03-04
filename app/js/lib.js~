var urlCartAction='http://localhost/xtreme/site2/loja/cart/updateCart.php';
var addCartFunction=function($scope,$http,$routeParams,$location){

	var data=JSON.stringify({idProduto:$routeParams.idProduto,action:'add'});
	console.log(data);

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
		console.log('erro:'+JSON.stringify(response));
	});
};



var loadVitrine=function($scope,$http,$routeParams){

	$http({
		method: 'POST',
		url:	url+"/vitrineAction.php",
		data:	JSON.stringify({idTipoProduto:$routeParams.idTipoProduto}),
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }	
	}).then(function(response){
		$scope.myData=response.data[1];
		$scope.totalItensCarrinho=response.data[0].totalItensCarrinho;
		console.log('Loading vitrine...');

	},function(response){console.log('erro'+JSON.stringify(response));});
}
