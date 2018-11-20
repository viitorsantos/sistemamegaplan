<?php   
		
    include "include/conexao.php";
    include "include/config.php";
	include "include/funcoes.php";
    include "include/verifica_usuario.php";
	
		$inicio = $_POST["inicio"];
		$fim    = $_POST["fim"];
		
		if(ValidaData2($inicio) == 0){
			 echo "Data Inicial Invalida.<br>";
			 exit;
		}
		if(ValidaData2($fim) == 0){
			 echo "Data Final Invalida.<br>";
			 exit;
		}
		
		$inicio = fnc_formata_data($_POST["inicio"]);
		$fim    = fnc_formata_data($_POST["fim"]);
		
		if(strlen(trim($inicio))>0 and strlen(trim($fim))>0){
				$periodo =  "<b>Período:</b> ".fnc_data_formatada($inicio). " - " .fnc_data_formatada($fim)." <br>";
		}
		
		$sql_total = "SELECT *from tbl_titular";
		$res_total = mysqli_query($con, $sql_total);
		$total_associados = mysqli_num_rows($res_total);
		for($i=0; $i<=mysqli_num_rows($res_total); $i++){
			$linha = mysqli_fetch_assoc($res_total);
			$mensalidade = $linha['mensalidade'];
			$total_mensalidades_todos += $mensalidade;	
		}
		
		
		$sql_inativos = "SELECT *FROM tbl_titular WHERE data_exclusao < '$inicio' AND data_exclusao != '0000-00-00'";
		//Nessa query se pega o total de associados titulares excluidos até o inicio do periodo digitado, as data 0000-00-0000 significam ativos.
		$res_inativos = mysqli_query($con, $sql_inativos);
		$total_inativos = mysqli_num_rows($res_inativos);
		for($i=0; $i<=mysqli_num_rows($res_inativos); $i++){
			$linha = mysqli_fetch_assoc($res_inativos);
			$mensalidade_inativos = $linha['mensalidade'];
			$total_mensalidades_inativos += $mensalidade_inativos;
		}
		
		$ativos = $total_associados - $total_inativos;
		$valor = $total_mensalidades_todos - $total_mensalidades_inativos;
		
	
		$sql_excluidos = "SELECT *FROM tbl_titular WHERE data_exclusao BETWEEN('$inicio') AND ('$fim')";
		$res_excluidos = mysqli_query($con, $sql_excluidos);
		$excluidos = mysqli_num_rows($res_excluidos);
		for($i=0; $i<=mysqli_num_rows($res_excluidos); $i++){
			$linha = mysqli_fetch_assoc($res_excluidos);
			$mensalidade_excluidos = $linha['mensalidade'];
			$total_mensalidades_excluidos += $mensalidade_excluidos;
		}
	
		$churn = ($excluidos/$ativos) * 100;
	    $churn_mrr = ($total_mensalidades_excluidos/$valor) * 100;
		
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
	  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	  <title></title>
</head>	

	
<style>
	
    div#interface{
    	margin: 0 auto;
    	padding: 0px;
    	width: 900px;
    }
    #logo{
    	float: left;
    	width: 150px;
    	height: 100px;
    }
	img#logo{
		width: 100px;
		height: 100px;
	}
	#cabecalho{
		float: left;
		font-family: arial, sans-serif;
		text-align: center;		
		width: 600px;
		padding-top: 30px;
	}
	.nome_relatorio{
		font-size: 25px;
	}
	#data_emissao{
		padding-top: 50px;
		float: left;
		width: 150px;
		font-size: 10px;
	}
	#clear{
		clear:both;
		height: 10px;
	}
	#table{
		width: 900px;
		border-top: 1px solid #000000;
	}
	#table th {
		text-transform: uppercase;
		font-size: 12px;
		font-family: tahoma;
		text-align: center;
		 background-color: white;
	}
	#table td {		
		font-size: 11px;
		font-family: tahoma;
		text-align: center;
		border-bottom: 1px solid #f8f8f8;
	}
	
	 #linha{
		border-top: 1px solid #000000;
	}
	#titular{
		background-color:#DCDCDC;
	}
	#resposta{
		font-size: 25px;
		margin-top: 25px;
	}
    
	
</style>

<body>
	<div id="interface">
		<header>
			<div id="logo">
				<img src="<?php echo LOGO ?>" id="logo">
			</div>
			<div id="cabecalho">				
				<div class="nome_relatorio">Churn</div>
				<div class="filtro_relatorio">
					<?php
						echo $periodo;
					?>

				</div>

			</div>
			<div id='data_emissao'>
				<div class="data"><?php echo date("d/m/Y")?></div>
				<div class="hora"><?php echo date("H:i")?></div>
			</div>
			<div id="clear"></div>
		</header>
		<section>
			<?php
				echo '<div id="resposta">';
					$churn = number_format($churn, 2, '.', '');
					$churn_mrr = number_format($churn_mrr, 2, '.', '');
					echo "Porcentagem de clientes que deixaram a associação nesse período = ".$churn."%<br>";
					echo "Porcentagem de receita que a associação perdeu nesse período = ".$churn_mrr."%";
				echo '</div>';
					
			?>
		</section>			
	</div>
</body>
</html>