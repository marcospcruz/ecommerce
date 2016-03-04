<?php
require_once("db/conexao.php"); 
require_once("servicologisticaDAO.php");
//require_once("../domain/integradorLogisticaTO.php");
class IntegradorLogisticaDAO{
	private $SQL_SELECT="select * from integradorlogistica";

	/**
	  *
	  **/
	public function read(){
		$SQL=$this->SQL_SELECT;
		$query=mysql_query($SQL);
		$dataArray=array();
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
			$integradorLogistica=new IntegradorLogisticaTO();
			$servicoLogisticaDAO=new ServicoLogisticaDAO();
			$integradorLogistica->__set("servicosEntrega",$servicoLogisticaDAO->readServicosIntegrador($result[0]));
			$integradorLogistica->__set("idIntegradorLogistica",$result[0]);	
			$integradorLogistica->__set("nomeIntegrador",$result[1]);
			$integradorLogistica->__set("urlServicoConsulta",$result[0]);
			$dataArray[$index]=$integradorLogistica;		
		}
		return $dataArray;
	}

}
?>
