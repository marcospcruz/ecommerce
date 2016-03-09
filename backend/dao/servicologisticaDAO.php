<?php
//include_once("../domain/servicoLogisticaTO.php");
class ServicoLogisticaDAO{
	private $SQL_SELECT="select * from servicologistica";

	public function readServicosIntegrador($idIntegradorLogistica){
		$SQL=$this->SQL_SELECT." where idIntegradorLogistica=".$idIntegradorLogistica." and ativo=true";
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
			$servicoLogistica=new ServicoLogisticaTO();
			$servicoLogistica->__set("idServicoLogistica",$result[0]);
			$servicoLogistica->__set("descricaoServico",$result[1]);		
			$servicoLogistica->__set("codigoServico",$result[2]);		
			$dataArray[$index]=$servicoLogistica;		
		}
		return $dataArray;
	}
}
?>
