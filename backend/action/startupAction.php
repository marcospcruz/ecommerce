<?php
//require_once("domain/tipoProdutoTO.php");
include("../cart/cartManager.php");
require("../domain/tipoProdutoTO.php");
require("../domain/fabricanteTO.php");
require("../dao/categoriaProdutoDAO.php");
include("../util/utilitario.php");

/**imports para produtoDAO.php **/
include_once("../domain/produtoTO.php"); 
include("../domain/itemEstoqueTO.php");
include("../dao/fabricanteDAO.php"); 
//include("domain/tipoProdutoTO.php");
include("../dao/tipoProdutoDAO.php");
include("../dao/produtoDAO.php");
require_once("../domain/categoriaProdutoTO.php");
/**end of imports**/




$cartManager=new CartManager();

$key='descricao';
$json=array();
$json[sizeof($json)]=array('totalItensCarrinho'=>$cartManager->getTotalItens());
$categoriaProdutoDAO=new CategoriaProdutoDAO();


$categoriasProdutos=$categoriaProdutoDAO->readAll();
$categoriasProdutosArray=array();


foreach($categoriasProdutos as $categoriaProduto){

	$tiposProdutos=$categoriaProduto->__get('tiposProdutos');

	$tpArray=array();
	foreach($tiposProdutos as $tipoProduto){
		$tpArray[sizeof($tpArray)]=array(
			$key=>$tipoProduto->__get($key),
			'idTipoProduto'=>$tipoProduto->__get('idTipoProduto')
		);

	}
	if(sizeof($tiposProdutos))
		$categoriasProdutosArray[sizeof($categoriasProdutosArray)]=array(
			$key=>$categoriaProduto->__get($key),
			'tipos_produtos'=>$tpArray
		);

}

$json[sizeof($json)]=array('categoriasProdutos'=>$categoriasProdutosArray);

$tipoProdutoDao=new TipoProdutoDAO();
$tiposProdutos=$tipoProdutoDao->readAll();
//die('aqui');
$produtoDao=new ProdutoDAO();
$util=new Utilitario();

$json[sizeof($json)]=array('anoAtual'=>date('Y'));

echo json_encode($json);

?>

