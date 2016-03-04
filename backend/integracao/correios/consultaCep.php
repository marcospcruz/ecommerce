<?php
include('../../lib/phpQuery/phpQuery/phpQuery.php');

$cep = $_GET['cep'];

if(strlen($cep)==8){
	$URL_CORREIOS='http://m.correios.com.br/movel/buscaCepConfirma.do';
	$html = simple_curl($URL_CORREIOS,array(
	'cepEntrada'=>$cep,
	'tipoCep'=>'',
	'cepTemp'=>'',
	'metodo'=>'buscarCep'
	));

	phpQuery::newDocumentHTML($html, $charset = 'utf-8');

	$dados = array(
		'logradouro'=> trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
		'bairro'=> trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
		'cidade/uf'=> trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()),
		'cep'=> trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
	);

	echo json_encode($dados);
}else
	echo json_encode(array('erro'=>"CEP inválido!"));
function simple_curl($url,$post=array(),$get=array()){
	$url = explode('?',$url,2);
	if(count($url)===2){	
		$temp_get = array();
		parse_str($url[1],$temp_get);
		$get = array_merge($get,$temp_get);
	}

	$ch = curl_init($url[0]."?".http_build_query($get));
	
	curl_setopt ($ch, CURLOPT_POST, 1);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	return curl_exec ($ch);
}

?>
