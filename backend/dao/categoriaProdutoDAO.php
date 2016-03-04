<?php
//require("db/conexao.php");
require("db/conexao.php"); 
//require_once("dao/tipoProdutoDAO.php");


class CategoriaProdutoDAO
{
	private $SQL_SELECT="select cp.idcategoriaproduto,cp.descricao from categoriaproduto cp";

	public function readAll(){
		$query=mysql_query($this->SQL_SELECT);
		$dataArray=array();
		while($result=mysql_fetch_array($query)){
			$index=sizeOf($dataArray);			
			$categoriaProduto=new CategoriaProdutoTO();
			$categoriaProduto->__set("idcategoriaproduto",$result[0]);
			$categoriaProduto->__set("descricao",$result[1]);
			$tipoProdutoDAO=new TipoProdutoDAO();
			$categoriaProduto->__set('tiposProdutos',$tipoProdutoDAO->readByCategoria($result[0]));
			//die(serialize($categoriaProduto));
			$dataArray[$index]=$categoriaProduto;
		}
		return $dataArray;
	}
}
?>
