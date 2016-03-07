<?php
	include('integracao/servicologisticaservices.php');
	include('dao/integradorlogisticaDAO.php');
	include('domain/integradorLogisticaTO.php');
	include('domain/servicoLogisticaTO.php');
	include('domain/produtoTO.php');
	include('domain/pacoteFreteTO.php');
	include('domain/itemEstoqueTO.php');
	include('cart/cartManager.php');
	include('util/utilitario.php');

/**

dimensao caixa: comprimento x largura x altura
**/
	//echo ' <head><meta http-equiv="refresh" content="2"></head> ';	
	$comprimentoCaixa=100;
	$larguraCaixa=100;
	$alturaCaixa=100;
	
	$pacoteFinal=array();
	
	$cep_DST=$_GET['CEP_DESTINO'];

	$cartManager=new CartManager();
	$servicoLogistica=new ServicoLogisticaServices();
	$utilitario=new Utilitario();	
	$totalItens=$cartManager->getTotalItens();
	//echo $totalItens;
	//die();
	$formatoPacote='1';	//formato pacote 1 para caixa / pacote e 2 para rolo/prisma.
	$entregaSomenteParaRemetenteInformado='s';
	$confirmacaoEntrega='s';
	$valorDeclarado=0;

	$itens=$cartManager->getItens();

	$qtUnidades= $cartManager->getQtUnits();

	$parametros=null;
	$empacotador=new Empacotador();
	//empacotando os itens.
	while($cartManager->hasItem()){	

		$itemCompra=$cartManager->getItem();
		$empacotador->empacota($itemCompra);
	}
	$totalPacotes=$empacotador->getTotalPacotes();
	echo "Total de Pacotes: ".$totalPacotes.'<br>';
	$contador=1;
	foreach($empacotador->__get('pacotes') as $pacote){
		echo "<li>Pacote ".$contador++.':<ul>';
		$peso=$pacote->__get('pesoPacote');	
		echo "<li>Peso pacote:".$peso.'</li>';
		$comprimento=$pacote->__get('comprimentoPreenchido');	
		echo "<li>Comprimento pacote:".$comprimento.'</li>';
		$largura=$pacote->__get('larguraPreenchida');	
		echo "<li>Largura pacote:".$largura.'</li>';
		$altura=$pacote->__get('alturaPreenchida');
		echo "<li>altura pacote:".$altura.'</li></ul>';	


		$servicoLogistica->calculaFreteEntrega('12200000',$cep_DST,$peso,$formatoPacote,$comprimento,$altura,$largura,($comprimento*$altura*$largura),$entregaSomenteParaRemetenteInformado,$valorDeclarado,$confirmacaoEntrega);
	}
	

	

//echo $parametros[0];
//calculaFreteEntrega($cepOrigem,$cepDestino,$pesoPacote,$formatoPacote,$comprimentoPacote,$alturaPacote,$larguraPacote,$diametroPacote,$entregaSomenteParaRemetenteInformado,$valorDeclarado,$confirmacaoEntrega)

//	foreach($parametros as $valor){
		//echo $valor."<br><br><br><br>";
//	}

	//$json=$servicoLogistica->calculaFreteEntrega('12231090',$cep_DST,$parametros[0],$parametros[1],$parametros[2],$parametros[3],$parametros[4],$parametros[5],'n',$parametros[6],'n');
	echo $json;
/**
  *
  **/
class Empacotador{

	/*private $altura;
	private $comprimento;
	private $largura;*/
	const ALTURA_CAIXA=100;
	const COMPRIMENTO_CAIXA=100;
	const LARGURA_CAIXA=100;
	const MATRIX_BASE=4;
	
	private $pacotes;
	private $indicePacote;

	function __construct(){
		$this->pacotes=array();
		//$this->pacote=array();


	}
	public function getTotalPacotes(){
		return sizeof($this->pacotes);
	}
	private function imprime($string){
		$br="<br>";		
		echo $br.$string.$br;
	}
	private function createPacoteFrete(){
		
		//$dimensao=array();
		$ultimoIndicePacote=sizeof($this->pacotes);

		//die();
		$pacoteFrete=new PacoteFreteTO();	
		$dimensao[0]=self::ALTURA_CAIXA;
		$dimensao[1]=self::COMPRIMENTO_CAIXA;
		$dimensao[2]=self::LARGURA_CAIXA;
		$pacoteFrete->__set('dimensaoPacote',$dimensao);
		$pacoteFrete->__set('dimensaoEspacoVazio',$dimensao);		
		$this->pacotes[$ultimoIndicePacote]=$pacoteFrete;
		$this->indicePacote=$ultimoIndicePacote;
		//return $pacoteFrete;
	}

	function getPacoteFrete($dimensaoItem){
		$indice=0;
		//echo 'passo 1';
		foreach($this->pacotes as $pacote){
			//die('x: '.serialize($pacote));
			//echo 'passo 2<br>';
			if($pacote->haEspacoPacote($dimensaoItem)){
				//return $pacote;
				//echo 'passo 3<br>';								
				$this->indicePacote=$indice;
				return;			
			}

			$indice++;
		}
					
		$this->createPacoteFrete();	
	}	
	/**
	  *
	  **/
	function empacota($itemCompra){
		$produto=$itemCompra[0];
		$quantidade=$itemCompra[1];
		$itemEstoque=$produto->__get('itemEstoque');
		
		$dimensaoItem[0]=$itemEstoque->__get("altura");
		$dimensaoItem[1]=$itemEstoque->__get("comprimento");
		$dimensaoItem[2]=$itemEstoque->__get("largura");
		
		$pesoItem=$itemEstoque->__get("peso");

		$indicePacote=0;
		$item=1;

		while($item<=$quantidade){
			
			$this->getPacoteFrete($dimensaoItem);	
			$indicePacote=$this->indicePacote;

			$this->pacotes[$indicePacote]->addItem($dimensaoItem,$pesoItem);
			//echo 'Pacote'.($indicePacote+1).'-item'.$item.'<br>';
			
			$item++;
		}

	}


	

	public function __get($property){
		if(property_exists($this,$property)){
			return $this->$property;
		}
	}

}

?>

