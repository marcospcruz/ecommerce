<?php
class FabricanteDAO{

	private $SQL_SELECT="select idfabricante,nomefabricante from fabricante";

	public function readFabricanteProduto($idFabricante){
		$SQL=$this->SQL_SELECT." where idFabricante=".$idFabricante;
		$query=mysql_query($SQL);
		$data_array=array();
		while($result=mysql_fetch_array($query)){
			$index=sizeof($data_array);
			$fabricante=new FabricanteTO();
			$fabricante->__set("idFabricante",$result[0]);
			$fabricante->__set("nomeFabricante",$result[1]);
			$data_array[$index]=$fabricante;
		}
		return $data_array[0];
		
	}
}
?>
