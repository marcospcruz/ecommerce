<?php
class Utilitario{
	public function calculaValorFinal($valorUnitario,$porcentagemDesconto){
		$valorFinal=$valorUnitario-(($valorUnitario*$porcentagemDesconto)/100);
		return $valorFinal;
	}

	public function autoLoadObject($obj){
		$obj=serialize($obj);
		return unserialize($obj);	
	}
	public function getCurrentTime(){
		date_default_timezone_set('America/Sao_Paulo');	
		$date = date('Y-m-d H:i:s');
		return $date;
	}
}
?>
