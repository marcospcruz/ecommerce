<?php
/*require_once("domain/produtoTO.php"); 
require_once("domain/itemEstoqueTO.php");
require_once("dao/fabricanteDAO.php"); 
require_once("domain/tipoProdutoTO.php");
require_once("dao/tipoProdutoDAO.php");  */
require("db/conexao.php"); 
//include("fabricanteDAO.php"); 
//include("tipoProdutoDAO.php"); 
class ItemEstoqueDAO{
	const TABELA='estoqueProduto';

	public function update($itemEstoque){

		$SQL='update '.self::TABELA.' set quantidade='.$itemEstoque->__get('quantidade').',valorUnitario='.$itemEstoque->__get('valorUnitario').',porcentagemDesconto='.$itemEstoque->__get('porcentagemDesconto').',comprimento='.$itemEstoque->__get('comprimento').',altura='.$itemEstoque->__get('altura').',largura='.$itemEstoque->__get('largura').',peso='.$itemEstoque->__get('peso').',diametro='.$itemEstoque->__get('diametro').' where idEstoqueProduto='.$itemEstoque->__get('idEstoqueProduto');
		$retVal=mysql_query($SQL);
		if(!$retVal)
			die('Falha ao atualizar estoque!');
		return $retVal;
	}
	/**
	  *
	  **/
	private function retrieveObjects($query){
		$dataArray=array();
		while($result=mysql_fetch_array($query)){
			$index=sizeOf($dataArray);
			$fabricanteDao=new FabricanteDAO();
			$tipoProdutoDao=new TipoProdutoDAO();
			$produto=new ProdutoTO();
			$produto->__set("idProduto",$result[0]);
			$produto->__set("nomeProduto",$result[1]);	
			$produto->__set("nomeArquivoFoto",$result[2]);
			$produto->__set("fabricante",$fabricanteDao->readFabricanteProduto($result[3]));			
			$produto->__set("tipoProduto",$tipoProdutoDao->readById($result[4]));	
			$itemEstoque=new ItemEstoqueTO();
			$itemEstoque->__set("idItemEstoque",$result[6]);
			$itemEstoque->__set("quantidade",$result[8]);
			$itemEstoque->__set("valorUnitario",$result[9]);			
			$itemEstoque->__set("porcentagemDesconto",$result[10]);
			$itemEstoque->__set("quantidadeVendidos",$result[11]);
			$itemEstoque->__set("comprimento",$result[12]);
			$itemEstoque->__set("altura",$result[13]);
			$itemEstoque->__set("largura",$result[14]);
			$itemEstoque->__set("diametro",$result[15]);
			$itemEstoque->__set("peso",$result[16]);
			$produto->__set("itemEstoque",$itemEstoque);	
			$dataArray[$index]=$produto;		
		}
		return $dataArray;
	}
}
?>
