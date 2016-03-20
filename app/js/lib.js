var urlCartAction='../backend/cart/updateCart.php';
/**
  *
  **/
var updateCartFunction=function($scope,$http,$routeParams,$location,svc,$timeout){
	console.log('- adicionando item no carrinho.');
	//console.log('routeparams:'+JSON.stringify($routeParams));
	var data=JSON.stringify({idProduto:$routeParams.idProduto,action:$routeParams.action});
	var pausaInMs=250;
	var cep_Destino=svc.getObjetoAttribValue('cep_destino');
	$scope.cep=cep_Destino;

	$http({
		method: 'POST',
		url:	urlCartAction,
		data:	data,
		headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
	}).then(function(response){
		//console.log(JSON.stringify(response.data));
		//document.getElementById('cart_qt').innerHTML=response.data;
		//console.log('cep:');
		//console.log($scope.cep);
		//console.log('recalcular frete:');

		document.getElementById("cep_prefixo").value=cep_Destino.prefixo;
		document.getElementById("cep_sufixo").value=cep_Destino.sufixo;
		
		svc.calculaFrete($scope,$http,svc);
	

		$timeout(function(){
			//alert(JSON.stringify(svc.getObjetoAttribValue('frete_carrinho')));
			//$scope.frete
			document.getElementById("frete_pkg").innerHTML=jsonToHtml(svc.getObjetoAttribValue('frete_carrinho'));
		},pausaInMs);
		$scope.method.calculaFrete=function(){
			svc.calculaFrete($scope,$http,svc);
		};

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

	
	$scope.method.calculaFrete=function(){
		svc.calculaFrete($scope,$http,svc);
	};

};
var calcula=function($scope,$http,svc){
	var valorCep=$scope.cep.prefixo+$scope.cep.sufixo;
	if(valorCep.length!=8)
		return;
	var data=JSON.stringify({cepDestino:valorCep});
	var path=url+'calculaFrete.php';
	var valorTotalCompra=0;
	console.log('calculaFrete: ajax para '+path);
	//svc.addObjetoAttribValue('cep_prefixo',$scope.cep.prefixo);
	//svc.addObjetoAttribValue('cep_sufixo',$scope.cep.sufixo);
	svc.addObjetoAttribValue('cep_destino',$scope.cep);
	$http({
		method:	'POST',
		url:	path,
		data: 	data,			
		headers:{ 'Content-Type': 'application/x-www-form-urlencoded' }
	}).then(function(response){
		
		var json=response.data[1];

		
		$scope.frete=json;
		svc.addObjetoAttribValue('frete_carrinho',json);
		//$scope.frete=svc.getObjetoAttribValue('frete_carrinho');
		var simboloMoeda=document.getElementById("vlTotalCompra").innerHTML.substring(0,2);
		console.log(simboloMoeda);
		valorTotalCompra=response.data[0].valorTotalCarrinho;

//parseFloat(document.getElementById("vlTotalCompra").innerHTML.substring(2).replace(',','.'));
		
		for(var i=0;i<json.length;i++){
			console.log(i);
			var row=json[i];
			for(var j=0;j<row.length;j++){
				var obj=row[j];
				//console.log(obj['descricaoServico']);
				valorTotalCompra+=parseFloat(obj['valorServico']);
			}

		}

		var valorTotalString=formatMilhar(valorTotalCompra.toFixed(2));

//String(valorTotalCompra.toFixed(2));

		//adicionando casas de centavos ao valor inteiro.
		//if((valorTotalCompra%1)==0){
		//	valorTotalString+='.00';
		//}
		document.getElementById("vlTotalCompra").innerHTML=simboloMoeda+valorTotalString;

	},function(response){
		
		console.log('Erro:'+JSON.stringify(response));

	});
	return valorTotalCompra;
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

function formatMilhar(int){
	var tmp = (int*100).toFixed(2)+'';
	tmp=tmp.substring(0,tmp.indexOf('.'));
        tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
        if( tmp.length > 6 )
                tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
        return tmp;

}

function jsonToHtml(json){
	var html='<span>'
	for(var i=0;i<json.length;i++){
		var obj=json[i];	
		for(var j=0;j<obj.length;j++){
			var jsonObj=obj[j];
			console.log(jsonObj);
			html+=jsonObj['descricaoServico']+' pacote '+(j+1)+'<br>';
			html+=jsonObj['valorServico']+'<br><br>';

		}
	}
	html+='<span>';
	return html;
}
