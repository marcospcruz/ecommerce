<?php

include("cartManager.php");
include("../domain/categoriaProdutoTO.php");
include("../domain/itemEstoqueTO.php");
include("../domain/tipoProdutoTO.php");
include("../domain/fabricanteTO.php");
include("../util/utilitario.php");
//include("domain/produtoTO.php");
$cartManager=new CartManager();
$utilitario=new Utilitario();

$cont=0;

$cart=array();
$totalCompra=0;
while($cartManager->hasItem()){

	$item = $cartManager->getItem();
	//echo json_encode($cartManager->getItem());
	$produto=$utilitario->autoLoadObject($item[0]);

	$fabricante=$utilitario->autoLoadObject($produto->__get("fabricante"));

	$tipoProduto=$utilitario->autoLoadObject($produto->__get("tipoProduto"));
	$categoriaProduto=$utilitario->autoLoadObject($tipoProduto->__get("categoriaProduto"));
	$itemEstoque=$utilitario->autoLoadObject($produto->__get("itemEstoque"));
	$valorUnitario=$itemEstoque->__get("valorUnitario");

	$quantidade=$item[1];
	$desconto=$itemEstoque->__get("porcentagemDesconto");
	$valorTotal=$quantidade*($utilitario->calculaValorFinal($valorUnitario,$desconto));
	$totalCompra=$totalCompra+$valorTotal;



	//$quantidade='<input type="text" name="cart_qt" disabled="yes" id="cart_qt" value="'.$quantidade.'" size="5"><span class="increase_qt"><a href="#" class="update_cart" onclick="addToCart('.$produto->__get('idProduto').');">+</a></span><span class="decrease_qt"><a href="#" class="update_cart" onclick="removeUmItem('.$produto->__get('idProduto').');">-</a></span>';





	$photo_path="images/Produtos/".strtoupper($categoriaProduto->__get("descricao"))."/".strtolower($tipoProduto->__get("descricao"))."/";

	if($desconto>0)
		$desconto=$desconto.'%';						
	else
		$desconto='';
	
	$cart[$cont]=array(
		'produto'=>$tipoProduto->__get('descricao')." ".$fabricante->__get('nomeFabricante'),
		'quantidade'=>$quantidade,
		'valorUnitario'=>number_format($valorUnitario,2,'.',','),
		'desconto'=>$desconto,
		'valorTotal'=>$valorTotal
		);

	$cont++;
}
$json[sizeof($json)]=array('cart'=>$cart);
$json[sizeof($json)]=array('totalCompra'=>$totalCompra);
$json[sizeof($json)]=array('totalItensCarrinho'=>$cartManager->getTotalItens());
echo json_encode($json);




				


/*function cast($obj, $to_class) {

  if(class_exists($to_class)) {

    $obj_in = serialize($obj);


//    $obj_out = 'O:' . strlen($to_class) . ':"' . $to_class . '":' . substr($obj_in, $obj_in[2] + 7);
    $obj_out = 'O:' . strlen($to_class) . ':"' . $to_class . '":' . substr($obj_in, $obj_in[2] + 7);
echo substr($obj_in, $obj_in[2] + 7);
echo $obj_out."<br>".$to_class."<br>";
echo $obj_in."<br>".($obj_in[2])."<br>";
die(serialize($obj));
    return unserialize($obj_out);

  }

  else

    return false;

}*/
?>
