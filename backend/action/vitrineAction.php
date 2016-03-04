<?php 
	include("../cart/cartManager.php");
	include("../util/utilitario.php");	
	include("../dao/produtoDAO.php");
	include("../dao/fabricanteDAO.php");
	include("../dao/tipoProdutoDAO.php");  
	//include("../domain/produtoTO.php");  
	include("../domain/fabricanteTO.php");  
	include("../domain/tipoProdutoTO.php");  
	include("../domain/categoriaProdutoTO.php");  
	include("../domain/itemEstoqueTO.php");  
	
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);

		
	
	$cartManager=new CartManager();
	$produtoDao=new ProdutoDAO();
	$util=new Utilitario();
	$array_json=array();
	$estoque=array();

	$array_json[sizeof($array_json)]=array('totalItensCarrinho'=>$cartManager->getTotalItens());

	//if(sizeof($_GET)>0)
	//		$idTipoProduto=$_GET['tipoProduto'];
	if(isset($request->idTipoProduto))
		$idTipoProduto=$request->idTipoProduto;
	
	/**********************************************************/

	if(!isset($idTipoProduto)){
			
		$produtos=$produtoDao->readProdutos();

	}else{
		$produtos=$produtoDao->readProdutosByTipo($idTipoProduto);
	}

	foreach($produtos as $produto){
		$fabricante=$produto->__get("fabricante");
		$tipoProduto=$produto->__get("tipoProduto");
		$categoriaProduto=$tipoProduto->__get("categoriaProduto");
		$photo_path="images/Produtos/".strtoupper($categoriaProduto->__get("descricao"))."/".strtolower($tipoProduto->__get	("descricao"))."/";
		$itemEstoque=$produto->__get("itemEstoque");
		$porcentagem_desconto=$itemEstoque->__get("porcentagemDesconto");
		$linhaValorProduto="";

		$valorDecimal=$util->calculaValorFinal($itemEstoque->__get("valorUnitario"),$porcentagem_desconto);

		if($porcentagem_desconto>0){
			$promo_tag='<img src="images/promocao.jpg" class="promocao_pic">';
			
			//die($valorDecimal);
			$linhaValorProduto="<span class='valor_promocional'>De R$ ".number_format($itemEstoque->__get	("valorUnitario"),2,',','.')."<br>";
			$linhaValorProduto.="Para R$ ".number_format($valorDecimal,2,',','.')."</span>";					
		}else{
			$linhaValorProduto="<span class='valor_cheio'>R$ ".$itemEstoque->__get("valorUnitario")."</span>";
		}
		$estoque[sizeof($estoque)]=array(
			'idProduto'=>$produto->__get('idProduto'),
			'caminho_foto'=>$photo_path.$produto->__get('nomeArquivoFoto'),
			'porcentagem_desconto'=>$porcentagem_desconto,
			'tipo_produto'=>$tipoProduto->__get('descricao'),
			'fabricante'=>$fabricante->__get('nomeFabricante'),
			'valor_produto'=>$linhaValorProduto,
			'valor_final_produto'=>$valorDecimal,
			'promo_tag'=>$promo_tag
		);
		
	/**/
	}
	
	//$array_json[sizeof($array_json)]=array('estoque'=>$estoque);
	$array_json[sizeof($array_json)]=$estoque;
	echo json_encode($array_json);


?>
