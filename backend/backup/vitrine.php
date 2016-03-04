	<div style='position:relative;'>
		Ordenar por:
		<select ng-model='ordem'>
			<option value='fabricante'>Fabricante</option>			
			<option value='tipo_produto'>Tipo Produto</option> 
			<option value='valor_final_produto'>Preço</option>
	
		</select> - 
		Procurar na Vitrine: <input type='text' ng-model='query'>
	</div>
	<div class="vitrine" ng-init="eventos.loadVitrine();">
		<!--produto-->
		<div class="column" ng-repeat="item in myData|filter:query|orderBy:ordem">
			<img class="mostruario" src="{{item.caminho_foto}}" alt="" />
			
			<div ng-show="item.porcentagem_desconto > 0">
				<span ng-bind-html="item.promo_tag"/>			
			</div>
			<div class="rodape_produto">
				<div class="fabricante_label">
			   		<h4>{{item.tipo_produto}} - {{item.fabricante}}<span></span></h4>
	  	 		</div>
				<div class="valor_produto">
					<span ng-bind-html="item.valor_produto"></span>			
				</div>
				<div class="buy">			
					
					 <a href="#" ng-click="eventos.addCart(item)">COMPRAR</a>
					
			 	</div>
				<div class="clearfix"></div>			
			</div>
			
		</div>
		
		<!--/produto-->
	
	
	</div>


<!-----

<ul>
			<li>
				produto
				<ul>
					<li>{{item.caminho_foto}}</li>
					<li>{{item.porcentagem_desconto}}</li>
					<li>{{item.promo_tag}}</li>
					<li>{{item.tipo_produto}} - {{item.fabricante}}</li>
					<li>{{item.valor_produto}}</li>
					<li>{{item.idProduto}}</li>
				</ul>
			</li>
		</ul>
		==>Example:<br>
		
		<span ng-bind-html="item.valor_produto"></span>
------------>
