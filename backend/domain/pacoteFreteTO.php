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

	public function addItem($dimensaoItem,$pesoItem){
		//echo 'espaço vazio:'.$this->dimensaoEspacoVazio[self::EIXO_Y].'|'.$this->dimensaoEspacoVazio[self::EIXO_X].'|'.$this->dimensaoEspacoVazio[self::EIXO_Z].' ';		
		//echo $alturaItem." ".$comprimentoItem." ".$larguraItem." ".$pesoItem;
		$this->pesoPacote+=$pesoItem;
	
		if(!isset($this->pacote[0][0])){
		//if($this->x==0){
			//$this->preencheEspacoVazio(self::EIXO_X,$dimensaoItem[self::EIXO_X]);
			//$this->preencheEspacoVazio(self::EIXO_Z,$dimensaoItem[self::EIXO_Z]);
			$this->larguraPreenchida+=$dimensaoItem[self::EIXO_Z];
			$this->ultimaLarguraPreenchida=$this->larguraPreenchida;
			//$this->ultimoComprimentoPreenchido+=$dimensaoItem[self::EIXO_X];
			//$this->preencheEspacoVazio(self::EIXO_Y,$dimensaoItem[self::EIXO_Y]);

		}

		if($this->y==0){
			if($this->x==0){
				$this->dimensaoEspacoVazio[self::EIXO_X]=$this->dimensaoPacote[self::EIXO_Y];
				$this->preencheEspacoVazio(self::EIXO_Z,$dimensaoItem[self::EIXO_Z]);
				//$this->ultimaLarguraPreenchida+=$dimensaoItem[self::EIXO_Z];
			}			

			$this->dimensaoEspacoVazio[self::EIXO_Y]=$this->dimensaoPacote[self::EIXO_Y];
			$this->preencheEspacoVazio(self::EIXO_X,$dimensaoItem[self::EIXO_X]);
			$this->ultimoComprimentoPreenchido+=$dimensaoItem[self::EIXO_X];
			if($this->comprimentoPreenchido<$this->ultimoComprimentoPreenchido)
				$this->comprimentoPreenchido=$this->ultimoComprimentoPreenchido;

		}

		$this->organizaPacote($dimensaoItem);

		//$this->imprime("#------------ultimaLarguraPreenchida:".$this->larguraPreenchida." ultimoComprimentoPreenchido:".$this->ultimoComprimentoPreenchido." ultimaAlturaPreenchida:".$this->ultimaAlturaPreenchida);


		//echo 'espaço vazio:'.$this->dimensaoEspacoVazio[self::EIXO_Y].'|'.$this->dimensaoEspacoVazio[self::EIXO_X].'|'.$this->dimensaoEspacoVazio[self::EIXO_Z].' ';

	}
	/**
	  *
	  **/
	private function preencheEspacoVazio($indice,$valor){
		$this->dimensaoEspacoVazio[$indice]-=$valor;		
	}

	private function organizaPacote($item){

		//if(!isset($this->ultimoComprimentoPreenchido)){
			//$this->ultimoComprimentoPreenchido=$item[self::EIXO_X];
		//	$this->larguraPreenchida=$item[self::EIXO_Z];
		//}
		
		$alturaPacote=$this->dimensaoPacote[self::EIXO_Y];
		$comprimentoPacote=$this->dimensaoPacote[self::EIXO_X];
		$larguraPacote=$this->dimensaoPacote[self::EIXO_Z];

		$this->pacote[$this->z][$this->x][$this->y]=$item;
		$this->imprime('#------------------------------------->'.$this->z.','.$this->x.','.$this->y);
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
				//$this->dimensaoEspacoVazio[self::EIXO_Y]=$alturaPacote;
				$this->x++;
				$this->y=0;
				$this->ultimaAlturaPreenchida=0;
				
				//$this->imprime($this->ultimoComprimentoPreenchido); 

				//$this->preencheEspacoVazio(self::EIXO_X,$item[self::EIXO_X]);
				//echo '------------------->'.$this->comprimentoPreenchido;
				//$this->comprimentoPreenchido=$this->ultimoComprimentoPreenchido;

			}
			//$this->imprime($this->ultimoComprimentoPreenchido);

			if($this->ultimoComprimentoPreenchido>=($comprimentoPacote-$item[self::EIXO_X])){
				$this->x=0;
				$this->z++;
				//$this->imprime($this->ultimoComprimentoPreenchido);
				$this->larguraPreenchida+=$item[self::EIXO_Z];
				//$this->ultimaLarguraPreenchida+=$item[self::EIXO_Z];//$this->larguraPreenchida;
				//$this->preencheEspacoVazio(self::EIXO_Z,$item[self::EIXO_Z]);
				//$this->dimensaoEspacoVazio[self::EIXO_X]=$comprimentoPacote-$item[self::EIXO_X];
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
		
		//$this->imprime("x:".$this->x.' y:'.$this->y.' z:'.$this->z);

		//$this->imprime("<br>---<br>restante altura a preencher:".(self::ALTURA_CAIXA-$alturaPreenchida));
		//$this->imprime("restante comprimento a preencher:".(self::COMPRIMENTO_CAIXA-$comprimentoPreenchido));
		//$this->imprime("restante largura a preencher:".(self::LARGURA_CAIXA-$larguraPreenchida));
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
		
		if($vazioY>=$dimensoesItem[self::EIXO_Y])
			return true;
		elseif($vazioX>=$dimensoesItem[self::EIXO_X])
			return true;
		elseif($vazioZ>=$dimensoesItem[self::EIXO_Z])
			return true;

		return false;
		/*if($this->alturaPreenchida>$this->ultimaAlturaPreenchida)
			echo ($this->alturaPreenchida-$this->ultimaAlturaPreenchida).'x<br>';
		elseif($this->alturaPreenchida==$this->ultimaAlturaPreenchida){

			if($vazioY>($this->alturaPreenchida-$dimensoesItem[self::EIXO_Y]))
				echo $vazioY;
		}

		if($dimensoesItem[self::EIXO_Y]<=$vazioY){
			return true;
		}elseif($dimensoesItem[self::EIXO_X]<=$vazioX){			
			return true;
		}elseif($dimensoesItem[self::EIXO_Z]<=$vazioZ){
			return true;
		}else{
			return false;
		}*/
	}

	function teste(){
		
		
		for($z=0;$z<sizeof($this->pacote);$z++){
			//echo serialize($this->pacote[$z]).'<br>';
			for($x=0;$x<sizeof($this->pacote[$z]);$x++){
				for($y=0;$y<sizeof($this->pacote[$z][$x]);$y++){
					echo serialize($this->pacote[$z][$x][$y]).'<br>';
				//	echo $z;
				//	echo ','.$x;
				//	echo ','.$y.'<br>';
				} 
			}
		}
	}
}
?>
