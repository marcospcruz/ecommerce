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
		return $this->runSql($SQL);

	}	
	public function delete($itemTemp){
		$SQL='delete FROM carrinho_temp where idCompraTemp='.$itemTemp->__get('idCompraTemp');	
		return $this->runSql($SQL);
	}

	private function runSql($SQL){
		$retVal=mysql_query($SQL);
		if(!$retVal)
			die('Falha compraTempDao!');
		return $retVal;
	}

	public function readLastCompraTemp($itemEstoque){
		$SQL.='select max(idCompraTemp) from carrinho_temp where idEstoqueProduto='.$itemEstoque->__get('idEstoqueProduto');
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
			$compraTemp=new CompraTempTO();
			$index=sizeOf($dataArray);
			$compraTemp->__set('idCompraTemp',$result[0]);
			$dataArray[$index]=$compraTemp;		
		}
		return $dataArray;
	}
}
?>
