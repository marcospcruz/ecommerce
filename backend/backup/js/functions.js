/****************************************************LEGADO*********************************************************************/
var formFrete='<label class="form_frete"><span>Digite o CEP para cálculo do frete:</span><input type="text" maxlength="5" size="3" id="cep_prefixo" onkeypress="return justNumber(event);" onkeyup="autoTab(this,cep_sufixo)">-<input type="text" maxlength="3" size="1" id="cep_sufixo" name="cep_sufixo" onkeypress="return justNumber(event);"><button onclick="calculaFrete(cep_prefixo.value,cep_sufixo.value);">Calcular</button></label>';
var urlCartAction="cart/updateCart.php";
function addToCart(idProduto){
	
	console.log('teste');
	$.ajax({
		url: urlCartAction,
		type: "GET",
		data:{
		   addIdProduto: idProduto		
		},
		success:function(e){

			$("#cart_qt").text(e);
			atualizaPagina();	
			reloadCartGrid();
		}	
	});

	
}

function atualizaPagina(){
	alert('teste');
}

function removeUmItem(idProduto){
	$.ajax({
		url: urlCartAction,
		type: "GET",
		data:{
		   delIdProduto: idProduto		
		},
		success:function(e){

			$("#cart_qt").text(e);	
			reloadCartGrid();
		}	
	});
	
}

function reloadCartGrid(){
	$("#cart_grid").find('tr:not(:first)').remove();
	loadCart("cart_grid");
}

function loadCart(tableId){

	var url="cart/checkoutBuilder.php";

	$.ajax({
		url: url,
		type: "POST",
		dataType: "json",
		success: function(json){
			
			//console.log(JSON.stringify(json));
			//console.log(json.length);
			//$('#cart_grid').html('marcos');
			drawTable(json,tableId);
		}		
	});
}


function drawTable(json,tableId){

	//console.log(tableId);
	//console.log(JSON.stringify(json));
	
	for(var i=0;i<json.length-1;i++){
		drawRow(i,json[i],tableId);				
	}

	if(json.length>1){

		drawRowFooter(null,tableId,4,formFrete);

	}

	var valor=numeroParaMoeda(json[json.length-1]['totalCompra']);
	drawRowFooter(valor,tableId,4,"Total:");
		

}

function calculaFrete(prefixo,sufixo){
	cep=prefixo+sufixo;
	$.ajax({

	});
	
}

function autoTab(from,to){
	if(from.getAttribute("maxLength")==from.value.length)
	   to.focus();
}

function drawRowFooter(value,tableId,colSpan,text){
	//alert(JSON.stringify(json)); 
	if(value==null)
		value="";
	var row=$("<tr />");
	var id="#"+tableId;
	$(id).append(row);
	row.append(createTdColSpan(value,text,colSpan));

}

function drawRow(posicaoLinha,rowJson,tableId){
	var id="#"+tableId;
	var tagRow="<tr ";

	if((posicaoLinha%2)!=0) 
		tagRow+="id='oddRow'/>";
	else
		tagRow+="/>";

	var row=$(tagRow);	
	$(id).append(row);
	row.append(createTd(rowJson['produto']));
	row.append(createTd(rowJson['quantidade']));
	row.append(createTd(numeroParaMoeda(rowJson['valorUnitario'])));
	row.append(createTd(rowJson['desconto']));
	row.append(createTd(numeroParaMoeda(rowJson['valorTotal'])));
}

function createTd(tdValue){
	var td=$("<td>"+tdValue+"</td>");
	return td;
}

function createTdColSpan(value,title,colSpan){
	var td=$("<td class='cart_grid_footer' colspan='"+colSpan+"'>"+title+"</td><td class='cart_grid_footer'><span class='total_value'>"+value+"</span></td>");
	return td;
}

function numeroParaMoeda(n, c, d, t){
    c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
    return "R$ "+s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function justNumber(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}
/***********************ANGULARJS********************************/

var addToCart=function(produto){
		//app.controller.$inject=["http"];
		var data=JSON.stringify({item:produto,action:'add'});
		console.log(data);
		$http({
				method: 'POST',
				url:	urlCartAction,
				data:	data,
				headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
		}).then(function(response){
			console.log('success:'+JSON.stringify(response.data));
		},function(response){console.log('erro:');
		
		});
	};

/*service*/
angular.module('services',[])
	.factory('myService',function(){

	});
