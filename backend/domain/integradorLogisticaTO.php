<?php
class IntegradorLogisticaTO{
	private $idIntegradorLogistica;
	private $nomeIntegrador;
	private $urlServicoConsulta;
	private $servicosEntrega;

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
