<?php
//require("conexao.php");
//require_once("dao/produtoDAO.php");
//require_once("domain/categoriaProdutoTO.php");
class TipoProdutoDAO
{
	private $SQL_SELECT="select t.idtipoproduto,t.descricao,cp.idcategoriaproduto,cp.descricao from tipoproduto t inner join categoriaproduto cp on cp.idcategoriaproduto=t.idcategoriaproduto";

	public function readAll(){
		$query=mysql_query($this->SQL_SELECT);
		//$dataArray=array();
  	        $dataArray=$this->retrieveObjects($query);
		/*while($result=mysql_fetch_array($query)){
			$index=sizeOf($dataArray);
			$tipoProduto=new TipoProdutoTO();
			$tipoProduto->__set("idTipoProduto",$result[0]);
			$tipoProduto->__set("descricao",$result[1]);
		        $produtoDao=new ProdutoDAO();
			//$tipoProduto->__set("produtos",$produtoDao->readProdutosByTipo($result[0]));			
			$categoriaProduto=new CategoriaProdutoTO();
			$categoriaProduto->__set("idcategoriaproduto",$result[2]);
			$categoriaProduto->__set("descricao",$result[3]);
			$tipoProduto->__set("categoriaProduto",$categoriaProduto);
			$dataArray[$index]=$tipoProduto;
		}*/
		return $dataArray;
	}
	/**
	  *
	  **/
	public function readByID($idTipoProduto){
		$SQL=$this->SQL_SELECT." where idtipoproduto=".$idTipoProduto;
		$query=mysql_query($SQL);
   	        //$dataArray=array();
		$dataArray=$this->retrieveObjects($query);
		/*while($result=mysql_fetch_array($query)){
			$index=sizeOf($dataArray);
			$tipoProduto=new TipoProdutoTO();
			$tipoProduto->__set("idTipoProduto",$result[0]);
			$tipoProduto->__set("descricao",$result[1]);
			$produtoDao=new ProdutoDAO();
			//$tipoProduto->__set("produtos",$produtoDao->readProdutosByTipo($result[0]));			
			$categoriaProduto=new CategoriaProdutoTO();
			$categoriaProduto->__set("idcategoriaproduto",$result[2]);
			$categoriaProduto->__set("descricao",$result[3]);
			$tipoProduto->__set("categoriaProduto",$categoriaProduto);
			$dataArray[$index]=$tipoProduto;
		}*/
		return $dataArray[0];
	}

	/**
	  *
	  **/
	public function readByCategoria($idcategoriaproduto){
	      $SQL=$this->SQL_SELECT." where t.idcategoriaproduto=".$idcategoriaproduto." order by 2";
	      $query=mysql_query($SQL);
	      $dataArray=$this->retrieveObjects($query);
	      return $dataArray;	
	}

	/**
	  *
	  **/
	private function retrieveObjects($query){
		$dataArray=array();
		while($result=mysql_fetch_array($query)){
			$index=sizeOf($dataArray);
			$tipoProduto=new TipoProdutoTO();
			$tipoProduto->__set("idTipoProduto",$result[0]);
			$tipoProduto->__set("descricao",$result[1]);
			$produtoDao=new ProdutoDAO();
			//$tipoProduto->__set("produtos",$produtoDao->readProdutosByTipo($result[0]));			
			$categoriaProduto=new CategoriaProdutoTO();
			$categoriaProduto->__set("idcategoriaproduto",$result[2]);
			$categoriaProduto->__set("descricao",$result[3]);
			$tipoProduto->__set("categoriaProduto",$categoriaProduto);
			$dataArray[$index]=$tipoProduto;
		}
		return $dataArray;	
	}

}
?>
