<?php
/*require_once("domain/produtoTO.php"); 
require_once("domain/itemEstoqueTO.php");
require_once("dao/fabricanteDAO.php"); 
require_once("domain/tipoProdutoTO.php");
require_once("dao/tipoProdutoDAO.php");  */
require("db/conexao.php"); 
//include("fabricanteDAO.php"); 
//include("tipoProdutoDAO.php"); 
class ProdutoDAO{
	
	private $JOIN_TIPO_PRODUTO="inner join tipoproduto tp on tp.idTipoProduto=p.idTipoProduto ";
	private $SQL_SELECT="select 	
				p.idProduto,
				p.nomeProduto,
				p.nomeArquivoFoto,
				p.idfabricante,
				tp.idtipoproduto,
				tp.descricao,
				ep.idEstoqueProduto,
				ep.idProduto,
				ep.quantidade,
				ep.valorUnitario,
				ep.porcentagemDesconto,
				p.quantidadeVendidos,
				ep.comprimento,
				ep.altura,
				ep.largura,
				ep.diametro,
				ep.peso				   
				from produto p 
				inner join tipoproduto tp on tp.idtipoproduto=p.idtipoproduto 
				inner join estoqueProduto ep on ep.idProduto=p.idProduto";
	private $ORDER_BY=" order by p.quantidadeVendidos desc,porcentagemdesconto desc";
	
	/**
	  *
	  **/
	public function readProdutos(){
		$SQL=$this->SQL_SELECT." where ep.quantidade>0 ".$this->ORDER_BY;
		
		$query=mysql_query($SQL);
		$dataArray=array();
  	        $dataArray=$this->retrieveObjects($query);	
		return $dataArray;
	}

	/**
	  *
	  **/
	public function readProdutosByTipo($idTipoProduto){
		$SQL=$this->SQL_SELECT." where p.idtipoproduto=".$idTipoProduto." and ep.quantidade>0 ".$this->ORDER_BY;
		//die($SQL);
		$query=mysql_query($SQL);
  	        $dataArray=$this->retrieveObjects($query);	
		return $dataArray;
		//die($SQL);
	}
	
	public function read($idProduto){
		$SQL=$this->SQL_SELECT." where p.idProduto=".$idProduto;
		$query=mysql_query($SQL);
		$dataArray=array();
  	        $dataArray=$this->retrieveObjects($query);
		return $dataArray[0];	
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

			$itemEstoque->__set("idEstoqueProduto",$result[6]);
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
