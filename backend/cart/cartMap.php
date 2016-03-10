<?php
include("../domain/produtoTO.php");
class CartMap {

	private $keys;
	private $values;
	private $indice;
	/**
	  *
	  **/	
	public function getKeys(){
		return $this->keys;	
	}
	/**
	  *
	  **/	
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
	public function remove($produto){
		//var_dump($this->keys);
	
		$indice=$this->hasProduto($produto);

		if($indice >= 0){
			$this->values[$indice]-=1;
			$this->reorganizeMap();
		}
	}
	

	/**
	  *
	  **/	
	private function reorganizeMap(){
		
		$keysTemp=$this->keys;
		$valuesTemp=$this->values;
		$this->values=array();
		$this->keys=array();
		for($i=0;$i<sizeof($keysTemp);$i++){
			if($valuesTemp[$i] > 0){
				//unset($this->values[$i]);
				//unset($this->keys[$i]);
				$this->values[sizeof($this->values)]=$valuesTemp[$i];
				$this->keys[sizeof($this->keys)]=$keysTemp[$i];
			}		
		}

		
	}

	/**
	  *
	  **/	
	public function totalItens(){
		$this->initArrays();
		
		$qtTotal=0; 	

		for($i=0;$i < sizeof($this->values); $i++){
			//echo "<br><br><br>".$this->values[$i]."<br>";
			$qtTotal+=$this->values[$i];
		}				
		//die("totalItens");
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
	public function next(){

		$indice=$this->indice;

		$value=array($this->keys[$indice],$this->values[$indice]);

		$this->indice+=1;

		
		return $value;
	}	
	/**
	  *
	  **/
	public function hasNext(){

		if($this->indice < sizeOf($this->keys)){
			
			return true;
		}

		return false;
	}
	/**
	  *
	  **/	
	public function resetIndice(){

		$this->indice=0; 	

		//die("reset");
	}
	/**
	  *
	  **/
	private function initArrays(){
		//$this->indice=0;

		if(!isset($this->keys)) {

			$this->keys=array();

		}	
		if(!isset($this->values)) {

			$this->values=array();
		
		}
	}
	/**
	  *
	  **/
	public function getValorTotalItens(){
		$i=0;
		$valorTotal=0;
		while($i<sizeof($this->keys)){
			$produto=$this->keys[$i];
			$itemEstoque=$produto->__get('itemEstoque');
			$valorItem=$itemEstoque->getValorFinal();				
			$quantidade=$this->values[$i];
			$valorTotal+=$quantidade*$valorItem;
			$i++;
		}
		return $valorTotal;		
	}

}
?>
