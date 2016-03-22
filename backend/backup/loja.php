<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
//require_once("domain/tipoProdutoTO.php");
require("domain/tipoProdutoTO.php");
require("domain/fabricanteTO.php");
require("dao/categoriaProdutoDAO.php");
include("util/utilitario.php");
require_once("domain/categoriaProdutoTO.php");
/**imports para produtoDAO.php **/
include_once("domain/produtoTO.php"); 
include("domain/itemEstoqueTO.php");
include("dao/fabricanteDAO.php"); 
//include("domain/tipoProdutoTO.php");
include("dao/tipoProdutoDAO.php");
include("dao/produtoDAO.php");
/**end of imports**/

$categoriaProdutoDAO=new CategoriaProdutoDAO();

$categoriasProdutos=$categoriaProdutoDAO->readAll();

$tipoProdutoDao=new TipoProdutoDAO();
$tiposProdutos=$tipoProdutoDao->readAll();
//die('aqui');
$produtoDao=new ProdutoDAO();
$util=new Utilitario();

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" ng-app="loja-app" ng-controller="loja-app-Cntrl" ng-init="total_itens_carrinho=0">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title>x-tremesuplementos.com</title>
		<link href="css/my_style.css" rel='stylesheet' type='text/css' />
		<script src="js/jquery/jquery-1.12.0.js"></script>
		<script src="js/functions.js"></script>
		<script src="js/angular.script.js"></script>

		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-sanitize.js"></script>
		<script type="text/javascript">
			var app=angular.module('loja-app',["ngSanitize"]);

			app.controller('loja-app-Cntrl',function ($scope,$http){
				

				$scope.eventos={};
				$scope.eventos.loadVitrine=function(){
					$http.get("action/vitrineAction.php").then(function(response){
						//console.log(JSON.stringify(response.data));
						$scope.myData=response.data[1];
						$scope.totalItensCarrinho=response.data[0].totalItensCarrinho;

					});
				};
				$scope.eventos.addCart=function(produto){
						//app.controller.$inject=["http"];
						var data=JSON.stringify({item:produto,action:'add'});
						//console.log(data);
						$http({
								method: 'POST',
								url:	urlCartAction,
								data:	data,
								headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
						}).then(function(response){
							//console.log('success:'+JSON.stringify(response.data));
							//$scope.totalItensCarrinho=response.data;
							$scope.eventos.loadVitrine();
 							},function(response){console.log('erro:'+JSON.stringify(response));
						
						});
					};
			});

		</script>
	</head>
	<body>

		<div class="geral">
			<!--HEADER-->
			<?php include('header.php');?>	
			<!--fim HEADER-->
			<!--conteudo-->
			<div class="content">
			   <?php include('menuhorizontal.php');?>
			   <?php
				 
				if(isset($_GET['nav']))
					$page=$_GET['nav'].".php";
				else
					$page="vitrine.php";
				
				include($page);
			   
			   ?>
			</div>
			<!--fim conteudo-->
			
			<!-- FOOTER -->
			<?php include('footer.php');?>
			<!-- fim FOOTER -->

		</div>
		<?php //include('modal_addItem.php');?>



	</body>
</html>

