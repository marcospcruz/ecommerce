function updateCart(){
	var action=$('#action').val();
	var item_inicio=$('#idProduto_de').val();
	var item=$('#idProduto_fim').val();
	
	if(item=='')
		item=item_inicio;

	var qt=$('#quantidade').val();
	
	var status='nok';
	//console.log('Enviando : idProduto='+data.idProduto+' ação: '+data.action);
	
	for(var id=item_inicio;id<=item;id++){

		var data={'idProduto':id,'action':action};
		console.log('Enviando : idProduto='+data.idProduto+' ação: '+data.action);
		
		for(var i=0;i<qt;i++){	


			$.post('http://localhost/ecommerce/backend/cart/updateCart.php',
				data,
				function(data, status){
					status='ok';	
					//console.log(JSON.stringify(data));		
				}
				
			);

		}

		if(status='ok')
			console.log('Carrinho atualizado com sucesso para o item'+data.idProduto+'!');
		else
		 	console.log('Falha ao atualizar carrinho para o item'+data.idProduto+'!');
	
	}

	if(status='ok')
		alert('Carrinho atualizado com sucesso!');
	else
	 	alert('Falha ao atualizar carrinho!');
	

}
