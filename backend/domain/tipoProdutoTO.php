<?php
require_once("abstractClass.php");
class TipoProdutoTO extends AbstractClass
{
  private $idTipoProduto;
  private $descricao;
  private $produtos;
  private $categoriaProduto;

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
