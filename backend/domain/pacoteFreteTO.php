<?php
class PacoteFreteTO{
	const EIXO_Y=0;
	const EIXO_X=1;
	const EIXO_Z=2;

	private $pacote;
	private $dimensaoPacote;
	private $dimensaoEspacoVazio;

	private $alturaPreenchida;
	private $comprimentoPreenchido;
	private $larguraPreenchida;
	private $pesoPacote;
	private $valorDeclarado;

	private $totalmentePreenchido;

	private $ultimaAlturaPreenchida;
	private $ultimoComprimentoPreenchido;
	private $ultimaLarguraPreenchida;

	private $x;
	private $y;
	private $z;

	function __construct(){

		$this->pacote[self::EIXO_Y]=array();		
		$this->pacote[self::EIXO_X]=array();
		$this->pacote[self::EIXO_Z]=array();	
		$this->totalmentePreenchido=false;
		$this->ultimaAlturaPreenchida=0;
		$this->alturaPreenchida=0;
		$this->ultimoComprimentoPreenchido=0;
		$this->ultimaLarguraPreenchida=0;
		$this->comprimentoPreenchido=0;
		$this->larguraPreenchida=0;
		$this->x=0;
		$this->y=0;
		$this->z=0;
		$this->valorDeclarado=0;
		//altura,comprimento,largura

		
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
	  return $this;
	}

	public function addItem($dimensaoItem,$pesoItem,$valorFinalProduto){
		$this->valorDeclarado+=$valorFinalProduto;
		$this->pesoPacote+=$pesoItem;
	
		if(!isset($this->pacote[0][0])){
			$this->larguraPreenchida+=$dimensaoItem[self::EIXO_Z];
			$this->ultimaLarguraPreenchida=$this->larguraPreenchida;

		}

		if($this->y==0){
			if($this->x==0){
				$this->dimensaoEspacoVazio[self::EIXO_X]=$this->dimensaoPacote[self::EIXO_Y];
				$this->preencheEspacoVazio(self::EIXO_Z,$dimensaoItem[self::EIXO_Z]);
			}			

			$this->dimensaoEspacoVazio[self::EIXO_Y]=$this->dimensaoPacote[self::EIXO_Y];
			$this->preencheEspacoVazio(self::EIXO_X,$dimensaoItem[self::EIXO_X]);
			$this->ultimoComprimentoPreenchido+=$dimensaoItem[self::EIXO_X];
			if($this->comprimentoPreenchido<$this->ultimoComprimentoPreenchido)
				$this->comprimentoPreenchido=$this->ultimoComprimentoPreenchido;

		}

		$this->organizaPacote($dimensaoItem);

	}
	/**
	  *
	  **/
	private function preencheEspacoVazio($indice,$valor){
		$this->dimensaoEspacoVazio[$indice]-=$valor;		
	}

	private function organizaPacote($item){
		
		$alturaPacote=$this->dimensaoPacote[self::EIXO_Y];
		$comprimentoPacote=$this->dimensaoPacote[self::EIXO_X];
		$larguraPacote=$this->dimensaoPacote[self::EIXO_Z];

		$this->pacote[$this->z][$this->x][$this->y]=$item;
		//$this->imprime('#------------------------------------->'.$this->z.','.$this->x.','.$this->y);
		$this->ultimaAlturaPreenchida+=$item[self::EIXO_Y];
		$this->preencheEspacoVazio(self::EIXO_Y,$item[self::EIXO_Y]);
		//die();

		if($this->ultimaAlturaPreenchida<=($alturaPacote-$item[self::EIXO_Y])){
			$this->y++;

			if($this->alturaPreenchida<$this->ultimaAlturaPreenchida)			
				$this->alturaPreenchida=$this->ultimaAlturaPreenchida;
		}else{
			if($this->x==0 && $this->ultimaAlturaPreenchida>=($alturaPacote-$item[self::EIXO_Y])){
				$this->alturaPreenchida=$this->ultimaAlturaPreenchida;
			}
			if($this->ultimaAlturaPreenchida>=($alturaPacote-$item[self::EIXO_Y])){
				$this->x++;
				$this->y=0;
				$this->ultimaAlturaPreenchida=0;
				
			}

			if($this->ultimoComprimentoPreenchido>=($comprimentoPacote-$item[self::EIXO_X])){
				$this->x=0;
				$this->z++;
				$this->larguraPreenchida+=$item[self::EIXO_Z];
				$this->ultimoComprimentoPreenchido=0;

			}


		}


	}
	public function relatorioPacote(){
		
		$this->imprime("=========================================");
		$this->imprime("altura:".$this->alturaPreenchida);
		$this->imprime("comprimento:".$this->comprimentoPreenchido);
		$this->imprime("largura:".$this->larguraPreenchida);

		$this->imprime("=======");
		$this->imprime("ultima altura:".$this->ultimaAlturaPreenchida);
		$this->imprime("ultimo comprimento:".$this->ultimoComprimentoPreenchido);
		$this->imprime("ultima largura:".$this->ultimaLarguraPreenchida);
		
		$this->imprime("Peso Total: ".$this->pesoPacote);
		$this->imprime("");

	
		$this->imprime("=========================================");
	}

	
	private function imprime($string){
		$br="<br>";		
		echo $br.$string.$br;
	}

	public function haEspacoPacote($dimensoesItem){
		$hashes='######################################################################';
		$alturaPacote=$this->dimensaoPacote[self::EIXO_Y];
		$comprimentoPacote=$this->dimensaoPacote[self::EIXO_X];
		$larguraPacote=$this->dimensaoPacote[self::EIXO_Z];

		$vazioX=$this->dimensaoEspacoVazio[self::EIXO_X];
		$vazioY=$this->dimensaoEspacoVazio[self::EIXO_Y];
		$vazioZ=$this->dimensaoEspacoVazio[self::EIXO_Z];
		
		/*echo '-------> largura item:'.$dimensoesItem[self::EIXO_Z].'<br>';
		echo '-------> vazio: '.$vazioZ.'<br>';
		echo '-------> largura preenchida: '.$this->larguraPreenchida.'<br><br>';

		echo '-------> Altura item:'.$dimensoesItem[self::EIXO_Y].'<br>';
		echo '-------> vazio: '.$vazioY.'<br>';
		echo '-------> altura preenchida: '.$this->alturaPreenchida.'<br><br>';

		echo '-------> comprimento item:'.$dimensoesItem[self::EIXO_X].'<br>';
		echo '-------> vazio: '.$vazioX.'<br>';
		echo '-------> comprimento preenchido: '.$this->comprimentoPreenchido.'<br><br>';*/
		if($vazioY>=$dimensoesItem[self::EIXO_Y]){
			return true;
		}elseif($vazioX>=$dimensoesItem[self::EIXO_X] && $vazioZ>=$dimensoesItem[self::EIXO_Z]){
			return true;
		}
		/*elseif($vazioZ>=$dimensoesItem[self::EIXO_Z]){
			echo "<p>liberou z</p>";
			return true;
		}*/

		return false;
		
	}

	
}
?>
