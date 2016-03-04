<?php
//require_once("../domain/produtoTO.php");
class CartMap {

	private $keys;
	private $values;
		
	public function put($produto,$quantidade){

		$indice=$this->hasProduto($produto);

		if($indice < 0){
			
			$this->keys[sizeof($this->keys)]=$produto;

			$this->values[sizeof($this->values)]=$quantidade;

		}else{

			$this->values[$indice]=$this->values[$indice]+1;

		}

	}
	/**
	  *
	  **/	
	public function totalItens(){
		$this->initArrays();
		
		$qtTotal=0; 	
		
		for($i=0;$i < sizeof($this->values); $i++){
			$qtTotal+=$this->values[$i];
		}				
		
		return $qtTotal;
	}
	/**
	  *
	  **/	
	public function size(){
		$this->initArrays(); 	

		return sizeof($this->values);
	}
	/**
	  *
	  **/	
	public function hasProduto($produto){

		for($i = 0;$i < sizeof($this->keys);$i++){

			$p=$this->keys[$i];

			if($p->__get("idProduto")==$produto->__get("idProduto")){

				return $i;
			} 

		}
		
		return -1;
				
	}

	/**
	  *
	  **/
	private function initArrays(){

		if(!isset($this->keys)) {

			$this->keys=array();

		}	
		if(!isset($this->values)) {

			$this->values=array();
		
		}
	}
}
?>
