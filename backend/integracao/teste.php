<?php
include_once("servicologisticaservices.php");
require_once('../dao/integradorlogisticaDAO.php');
require_once('../domain/integradorLogisticaTO.php');
$servicoLogistica=new ServicoLogisticaServices();
$BR='<br>';
echo 'testando logistica'.$BR.$BR;

echo json_decode($servicoLogistica->calculaFreteEntrega('12211310','12231090','1','1','16','5','15','0','s','200','n'));


?>
