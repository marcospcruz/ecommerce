<?php
require_once("abstractClass.php");
class ItemEstoqueTO extends AbstractClass{
	private $idEstoqueProduto;
	private $produto;
	private $quantidade;
	private $valorUnitario;
	private $porcentagemDesconto;
	private $peso;
	private $diametro;
	private $largura;
	private $altura;
	private $comprimento;

	public function getValorFinal(){
		$valorUnit=$this->valorUnitario;
		$desconto=$this->porcentagemDesconto;
		return $valorUnit-(($valorUnit*$desconto)/100);	
	}

	public function __get($property) {
	    if (property_exists($this, $property)) {
	      return $this->$property;
	    }
	}

	public function __set($property, $value) {
	    if (property_exists($this, $property)) {
	      $this->$property = $value;
	    }
	    //echo "teste setter:".$this->$property;
	    return $this;
	}

}
?>
