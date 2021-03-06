<?php
	require_once("cartManager.php");
	require_once("../dao/compraTempDAO.php");
	require_once("../dao/produtoDAO.php");
	require_once("../dao/fabricanteDAO.php");
	require_once("../dao/tipoProdutoDAO.php");
	require_once("../dao/itemEstoqueDAO.php");
	require_once("../domain/categoriaProdutoTO.php");
	require_once("../domain/tipoProdutoTO.php");
	require_once("../domain/produtoTO.php");
	require_once("../domain/itemEstoqueTO.php");
	require_once("../domain/fabricanteTO.php");
	require_once("../domain/abstractClass.php");
	require_once("../domain/compraTempTO.php");
	require_once("../util/utilitario.php");


	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	
	if(isset($request)){
		$action=$request->action;
		$idProduto=$request->idProduto;
	}else{
		$action=$_POST['action'];
		$idProduto=$_POST['idProduto'];

	}


	////////////////////////////////
	
	//$obj=$_POST;
	//die("REQUEST: ".$obj['idProduto']);
	//if(isset($_GET['addIdProduto'])){ 
	if($action=='add'){
		//$idProduto=$_GET['addIdProduto'];
		$produto=carregaProduto($idProduto);
		$itemEstoque=$produto->__get('itemEstoque');
		if($itemEstoque->__get('quantidade')>0){
			deduzEstoque($itemEstoque,-1);
			$retorno=addProduto($produto);	
		}else
			$retorno='Quantidade excedida no estoque!';
	
	}if($action=='del'){ 

		$retorno=delProduto($idProduto);

	}
	//teste
	
	
	
	//echo $idProduto;
	//echo serialize($produto);
	echo $retorno;

	function carregaProduto($idProduto){
		$produtoDao=new ProdutoDAO();
		$produto=$produtoDao->read($idProduto);
		return $produto;
	}
	function deduzEstoque($itemEstoque,$quantidade){
		$itemEstoqueDAO=new ItemEstoqueDAO();

		//dedução estoque produto		
		$quantidade=$itemEstoque->__get('quantidade')+$quantidade;
		$itemEstoque->__set('quantidade',$quantidade);
		$itemEstoqueDAO->update($itemEstoque);
		
		//fim dedução	
	}
	function addProduto($produto){
		$cartManager=new CartManager();	
		if(!isset($produto))
			die(":x");
		adicionaEstoqueTemp($produto->__get('itemEstoque'),$cartManager->getSessionId());
		$cartManager->addProduct($produto);
		return $cartManager->getTotalItens();
	}
	function adicionaEstoqueTemp($itemEstoque,$sessionId){

		$tempCartDao=new CompraTempDAO();
		$itemTemp=new CompraTempTO();		
		$utilitario=new Utilitario();
		$itemTemp->__set('itemEstoque',$itemEstoque);
		$itemTemp->__set('sessionId',$sessionId);
		$itemTemp->__set('dataHoraCompra',$utilitario->getCurrentTime());
		$tempCartDao->insere($itemTemp);

	}
	function removeEstoqueTemp($itemEstoque,$sessionId){
		$tempCartDao=new CompraTempDAO();
		$itemTemp=$tempCartDao->readLastCompraTemp($itemEstoque);		
		$utilitario=new Utilitario();
		$tempCartDao->delete($itemTemp);

	}
	function delProduto($idProduto){

		$produto=carregaProduto($idProduto);
		//$produto->__set("idProduto",$idProduto);
		deduzEstoque($produto->__get('itemEstoque'),1);
		$cartManager=new CartManager();
		$cartManager->delProduct($produto);
		removeEstoqueTemp($produto->__get('itemEstoque'),$cartManager->getSessionId());
		return $cartManager->getTotalItens();
	}
?>
