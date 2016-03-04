<?php
require_once("abstractClass.php");

class ProdutoTO extends AbstractClass{
  private $idProduto;
  private $nomeArquivoFoto;
  private $nomeProduto;
  private $fabricante;
  private $tipoProduto;
  private $itemEstoque;

  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }

  public function __set($property, $value) {
    if (property_exists($this, $property)) {
      $this->$property = $value;
    }
    return $this;
  }

}
?>
