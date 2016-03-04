<div class="menu_vertical_esquerda">
	<ul>
	<?php 
	for($i=0;$i<sizeof($categoriasProdutos);$i++){		
		$categoriaProduto=$categoriasProdutos[$i];

	?>
		<h4><?=$categoriaProduto->__get('descricao')?></h4>
	<?php
		$tiposProdutos=$categoriaProduto->__get('tiposProdutos');
		for($tp=0;$tp<sizeof($tiposProdutos);$tp++){
			$tipoProduto=$tiposProdutos[$tp];
	?>
		<li><a href="?tipoProduto=<?=$tipoProduto->__get('idTipoProduto')?>"><?=$tipoProduto->__get('descricao')?></a></li>
		<?php } ?>
	<?php } ?>


	</ul>
</div>
