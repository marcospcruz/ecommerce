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

	public function tirarAcentos($string){
		    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
		}
}
?>
