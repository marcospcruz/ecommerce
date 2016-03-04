<?php
require("db/conexao.php"); 
require_once("../domain/itemEstoqueTO.php");
class CompraTempDAO{
	public function insere($itemTemp){

		$itemEstoque=$itemTemp->__get('itemEstoque');
		$SQL='insert into carrinho_temp(idEstoqueProduto,session_Id,dataHoraCompra) values(';
		$SQL.=$itemEstoque->__get('idEstoqueProduto').',';
		$SQL.="'".$itemTemp->__get('sessionId')."',";
		$SQL.="'".$itemTemp->__get('dataHoraCompra')."')";
		$retVal=mysql_query($SQL);
		if(!$retVal)
			die('Falha compraTempDao!');
		return $retVal;

	}	
}
?>
