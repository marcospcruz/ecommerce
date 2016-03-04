<?php
//session_start();
include("cartManager.php");

$break="<br>";
echo $break.$break.$break.$break;
$cartManager=new CartManager();
echo $break."Total de Itens no Carrinho: ".$cartManager->getTotalItens()."<br>";
while($cartManager->hasItem()){
	
	$item=$cartManager->getItem();
	$produto=$item[0];
	
	echo $break."idProduto: ".$produto->__get("idProduto").$break.$break;

	$i++;
}
echo $break."fim do while";
?>
