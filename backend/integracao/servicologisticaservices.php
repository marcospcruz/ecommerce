<?php 
//include_once("../dao/integradorlogisticaDAO.php");


//Limites de dimensões de embalagens:
//PACOTE E CAIXA
//Especificações 	Mínimo 	Máximo	
//Comprimento (C) 	16 cm 	105 cm	
//Largura (L)		11 cm 	105 cm	
//Altura (A) 	2 cm 	105 cm	
//Soma (C+L+A) 	29 cm 	200 cm	
//
//A soma resultante do comprimento + largura + altura não deve superar 200 cm.
class ServicoLogisticaServices{

	private $parametros;
	private $integradorLogisticaDAO;
	private $formatoRetornoConsulta;
	private $attr;

	
	function __construct(){
		$this->parametros=array();
		$this->integradorLogisticaDAO=new IntegradorLogisticaDAO();
		$this->formatoRetornoConsulta='xml';
		$this->attr="servicosEntrega";
	}

	public function calculaFreteEntrega($cepOrigem,$cepDestino,$pesoPacote,$formatoPacote,$comprimentoPacote,$alturaPacote,$larguraPacote,$diametroPacote,$entregaSomenteParaRemetenteInformado,$valorDeclarado,$confirmacaoEntrega){

		/*echo "origem: ".$cepOrigem."<br>destino: ".$cepDestino."<br>peso pacote: ".$pesoPacote."<br>formato pacote: ".$formatoPacote."<br>comprimento pacote: ".$comprimentoPacote."<br>altura pacote: ".$alturaPacote."<br>largura pacote: ".$larguraPacote."<br>diametro pacote: ".$diametroPacote."<br>entrega somente para remetente? ".$entregaSomenteParaRemetenteInformado."<br>valor declarado: ".$valorDeclarado."<br>enviar confirmacao entrega? ".$confirmacaoEntrega;
		die();*/

		$retorno=array();
		$integradores=$this->integradorLogisticaDAO->read();

		foreach($integradores as $integrador){

			$dadosServico=$this->calculaValorServico($cepOrigem,$cepDestino,$pesoPacote,$formatoPacote,$comprimentoPacote,$alturaPacote,$larguraPacote,$diametroPacote,$entregaSomenteParaRemetenteInformado,$valorDeclarado,$confirmacaoEntrega,$integrador);

			foreach($dadosServico->cServico as $linhas) {
				if($linhas->Erro == 0) {
					$descricaoServico=$this->extraiDescricaoServico($linhas->Codigo,$integrador->__get($this->attr));
					//echo "Código:".$linhas->Codigo.'</br>';
					//echo "Serviço:".$descricaoServico.'</br>';
					//echo "Valor:".$linhas->Valor .'</br>';
					//echo "Prazo Entrega:".$linhas->PrazoEntrega.' Dias </br>';
					
					$retorno[sizeof($retorno)]=array('codigoServico'=>$linhas->Codigo);
					$retorno[sizeof($retorno)]=array('descricaoServico'=>$descricaoServico);	
					$retorno[sizeof($retorno)]=array('valorServico'=>$linhas->Valor);
					$retorno[sizeof($retorno)]=array('prazoEntregaDias'=>$linhas->PrazoEntrega);

				}else {
					echo $linhas->MsgErro."<br>";
				}
				//echo '<hr>';
			}		

	

		}
		
		return json_encode($retorno);

	}	
	
	private function calculaValorServico($cepOrigem,$cepDestino,$pesoPacote,$formatoPacote,$comprimentoPacote,$alturaPacote,$larguraPacote,$diametroPacote,$entregaSomenteParaRemetenteInformado,$valorDeclarado,$confirmacaoEntrega,$integrador){
		// Código e senha da empresa, se você tiver contrato com os correios, se não tiver deixe vazio.
		$parametros['nCdEmpresa'] = '';
		$parametros['sDsSenha'] = '';
		// CEP de origem e destino. Esse parametro precisa ser numérico, sem "-" (hífen) espaços ou algo diferente de um número.
		$parametros['sCepOrigem'] = $cepOrigem;
		$parametros['sCepDestino'] = $cepDestino;

		// O peso do produto deverá ser enviado em quilogramas, leve em consideração que isso deverá incluir o peso da embalagem.
		$parametros['nVlPeso'] = $pesoPacote;

		// O formato tem apenas duas opções: 1 para caixa / pacote e 2 para rolo/prisma.
		$parametros['nCdFormato'] = $formatoPacote;

		// O comprimento, altura, largura e diametro deverá ser informado em centímetros e somente números
		$parametros['nVlComprimento'] = $comprimentoPacote;
		$parametros['nVlAltura'] = $alturaPacote;
		$parametros['nVlLargura'] = $larguraPacote;
		$parametros['nVlDiametro'] = $diametroPacote;

		// Aqui você informa se quer que a encomenda deve ser entregue somente para uma determinada pessoa após confirmação por RG. Use "s" e "n".
		$parametros['sCdMaoPropria'] = $entregaSomenteParaRemetenteInformado;

		// O valor declarado serve para o caso de sua encomenda extraviar, então você poderá recuperar o valor dela. Vale lembrar que o valor da encomenda interfere no valor do frete. Se não quiser declarar pode passar 0 (zero).
		$parametros['nVlValorDeclarado'] = $valorDeclarado;


		// Se você quer ser avisado sobre a entrega da encomenda. Para não avisar use "n", para avisar use "s".
		$parametros['sCdAvisoRecebimento'] = $confirmacaoEntrega;

		// Formato no qual a consulta será retornada, podendo ser: Popup é mostra uma janela pop-up - URL é envia os dados via post para a URL informada - XML é Retorna a resposta em XML
		$parametros['StrRetorno'] = $this->formatoRetornoConsulta;

		// Código do Serviço, pode ser apenas um ou mais. Para mais de um apenas separe por virgula.
		////////////////////////////////////////////////
		// Código dos Serviços dos Correios
		// 41106 PAC
		// 40010 SEDEX
		// 40045 SEDEX a Cobrar
		// 40215 SEDEX 10
		////////////////////////////////////////////////
		$parametros['nCdServico'] = $this->extraiServicos($integrador->__get($this->attr));

		$parametros = http_build_query($parametros);

		$url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
		$curl = curl_init($url.'?'.$parametros);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$dadosRetorno = curl_exec($curl);
		return simplexml_load_string($dadosRetorno);


	
	}

	private function extraiServicos($servicos){
		$codServicosString='';
		$cont=0;
		for($i=0;$i<sizeof($servicos);$i++){
			$servico=$servicos[$i];
			$codServicosString=$codServicosString.$servico->__get("codigoServico");
			
			if($i!=(sizeof($servicos)-1))
				$codServicosString=$codServicosString.',';				


		}

		return $codServicosString;
	}

	private function extraiDescricaoServico($codigoServico,$servicos){
		foreach($servicos as $servico){
			if($servico->__get("codigoServico")==$codigoServico){
				return $servico->__get("descricaoServico");
			}
		}

		return null;

	}
	
}

?>
