<?php
	include("cart/cartManager.php");
	//include("util/cartMap.php");
	$cartManager=new CartManager();
?>
<div class="menu_container" >
	<nav>
		<ul class="menu">
			<li><a href="#">Home</a></li>
			<li><a href="#">Produtos</a>
				<ul>
					<li><a href="acessorios.html">Acessórios</a></li>
					<li><a href="suplementos.html">Suplementos</a></li>								
				</ul>
			</li>
			<li><a href="#">Extras</a></li>
			<li><a href="?nav=checkout" ><img src="images/cart.png"><sup>(<span id="cart_qt">{{totalItensCarrinho}}</span>)</sup></a></li>						
		</ul>
	</nav>

</div>

