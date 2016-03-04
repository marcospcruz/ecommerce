<?php




// Código e senha da empresa, se você tiver contrato com os correios, se não tiver deixe vazio.
$parametros['nCdEmpresa'] = '';
$parametros['sDsSenha'] = '';
// CEP de origem e destino. Esse parametro precisa ser numérico, sem "-" (hífen) espaços ou algo diferente de um número.
$parametros['sCepOrigem'] = '12211310';
$parametros['sCepDestino'] = '12211310';

// O peso do produto deverá ser enviado em quilogramas, leve em consideração que isso deverá incluir o peso da embalagem.
$parametros['nVlPeso'] = '1';

// O formato tem apenas duas opções: 1 para caixa / pacote e 2 para rolo/prisma.
$parametros['nCdFormato'] = '1';

// O comprimento, altura, largura e diametro deverá ser informado em centímetros e somente números
$parametros['nVlComprimento'] = '16';
$parametros['nVlAltura'] = '5';
$parametros['nVlLargura'] = '15';
$parametros['nVlDiametro'] = '0';

// Aqui você informa se quer que a encomenda deva ser entregue somente para uma determinada pessoa após confirmação por RG. Use "s" e "n".
$parametros['sCdMaoPropria'] = 's';

// O valor declarado serve para o caso de sua encomenda extraviar, então você poderá recuperar o valor dela. Vale lembrar que o valor da encomenda interfere no valor do frete. Se não quiser declarar pode passar 0 (zero).
$parametros['nVlValorDeclarado'] = '200';


// Se você quer ser avisado sobre a entrega da encomenda. Para não avisar use "n", para avisar use "s".
$parametros['sCdAvisoRecebimento'] = 'n';

// Formato no qual a consulta será retornada, podendo ser: Popup é mostra uma janela pop-up - URL é envia os dados via post para a URL informada - XML é Retorna a resposta em XML
$parametros['StrRetorno'] = 'xml';

// Código do Serviço, pode ser apenas um ou mais. Para mais de um apenas separe por virgula.
////////////////////////////////////////////////
// Código dos Serviços dos Correios
// 41106 PAC
// 40010 SEDEX
// 40045 SEDEX a Cobrar
// 40215 SEDEX 10
////////////////////////////////////////////////
$parametros['nCdServico'] = '40010,41106,40045,40215';

$parametros = http_build_query($parametros);

$url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
$curl = curl_init($url.'?'.$parametros);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$dados = curl_exec($curl);
$dados = simplexml_load_string($dados);

//die(json_encode($dados));

foreach($dados->cServico as $linhas) {
	if($linhas->Erro == 0) {
		echo "Código:".$linhas->Codigo.'</br>';
		echo "Valor:".$linhas->Valor .'</br>';
		echo "Prazo Entrega:".$linhas->PrazoEntrega.' Dias </br>';
	}else {
		echo $linhas->MsgErro;
	}
	echo '<hr>';
}


?>


