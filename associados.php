<?php   
		
    include "include/conexao.php";
    include "include/config.php";
	include "include/funcoes.php";
    include "include/verifica_usuario.php";
	
		if(isset($_POST['todos'])){
			$check = 't';
		}else{
			$check = 'f';
		}
		
		$status_form = $_POST['status'];
		$inicio = fnc_formata_data($_POST['inicio']);
		$fim    = fnc_formata_data($_POST['fim']);
		
		
		if(strlen(trim($inicio))>0 and strlen(trim($fim))>0){
				$periodo =  "<b>Período:</b> ".fnc_data_formatada($inicio). " - " .fnc_data_formatada($fim)." <br>";
		}
		if($check == 't'){
				$periodo =  "<b>Período:</b> Todos <br>";
		}
		
		$query = "SELECT id_titular, nome, cpf, status, data_adesao, data_exclusao FROM tbl_titular";
		
		if($check == 't' && $status_form == ''){
			$sql_consulta = $query;
	
		}elseif($check == 't' && $status_form == 'A'){
			$sql_consulta = $query. " WHERE status = 'A' ORDER BY nome";
			
		}elseif($check == 't' && $status_form == 'I'){
			$sql_consulta = $query. " WHERE status = 'I' ORDER BY nome";
			
		}elseif($check == 'f' && $status_form == ''){
			$sql_consulta = $query." WHERE data_adesao BETWEEN ('$inicio') AND ('$fim') ORDER BY data_adesao";
			
		}elseif($check == 'f' && $status_form == 'A'){
			$sql_consulta = $query." WHERE data_adesao BETWEEN ('$inicio') AND ('$fim') AND status = 'A' ORDER BY data_adesao";
			
		}elseif($check == 'f' && $status_form == 'I'){
			$sql_consulta = $query." WHERE data_exclusao BETWEEN ('$inicio') AND ('$fim') AND status = 'I' ORDER BY data_exclusao";
		}
		
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
    
	
</style>

<body>
	<div id="interface">
		<header>
			<div id="logo">
				<img src="<?php echo LOGO ?>" id="logo">
			</div>
			<div id="cabecalho">				
				<div class="nome_relatorio">Relatório Associados</div>
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
			<table id="table">
				<?php
				  
					$res_consulta = mysqli_query($con, $sql_consulta);
					
					if(mysqli_num_rows($res_consulta)>0){
					echo "<div class='table-responsive'>
							<table id='table'>
								<thead>
									<tr>
										<th class='col-md-2'>Nome</th>
										<th class='col-md-2'>Associado</th>
										<th class='col-md-2'>CPF</th>
										<th class='col-md-2'>Data de Adesão</th>
										<th class='col-md-2'>Status </th>
										<th class='col-md-2'>Data de Exclusão </th>
									</tr>
								</thead>
								<body>";
					for($i=0; $i<mysqli_num_rows($res_consulta); $i++){
						$linha = mysqli_fetch_assoc($res_consulta);
						$id_titular    = $linha['id_titular'];
						$nome          = $linha['nome'];
						$cpf           = $linha['cpf'];
						$data_adesao   = fnc_data_formatada($linha['data_adesao']);
						$status        = $linha['status'];
						$data_exclusao = fnc_data_formatada($linha['data_exclusao']);
				   
						
						
						if($data_exclusao == '00/00/0000'){
							$data_exclusao = "";
						}
						
						
						echo "<tr id='titular'>";
							echo "<td class='col-md-2'>$nome</td>";
							echo "<td class='col-md-2'>Titular</td>";
							echo "<td class='col-md-2'>$cpf</td>";
							echo "<td class='col-md-2'>$data_adesao</td>";
							if($status == 'A'){
								$status = "Ativo";
							}else{
								$status = "Inativo";
							}
							echo "<td class='col-md-2'>$status</td>";
							echo "<td class='col-md-2'>$data_exclusao</td>";
							
								
							if($status_form == ''){
								$sql_dependente = "SELECT nome, cpf, data_adesao, cadastro, status FROM tbl_dependentes WHERE id_titular = $id_titular";
							}elseif($status_form == 'A'){
								$sql_dependente = "SELECT nome, cpf, data_adesao, cadastro, status FROM tbl_dependentes WHERE id_titular = $id_titular";
							}elseif($status_form == 'I'){
								$sql_dependente = "SELECT nome, cpf, data_adesao, cadastro, status FROM tbl_dependentes WHERE id_titular = $id_titular
								AND status = 'I'";
							}
							
							//echo $sql_dependente;
							$res_dependente = mysqli_query($con, $sql_dependente);
							for($j=0; $j<mysqli_num_rows($res_dependente); $j++){
				   
								$linha2 = mysqli_fetch_assoc($res_dependente);
								$nome_dependente = $linha2['nome'];
								$cpf             = $linha2['cpf'];
								$status          = $linha2['status'];
								$data_adesao     = fnc_data_formatada(substr($linha2['data_adesao'], 0, 10));
								$cadastro        = fnc_data_formatada(substr($linha2['cadastro'], 0, 10));
								
								if($status == 'A'){
									$status_dep = "Ativo";
								}else{
									$status_dep = "Inativo";
								}
								
								if($status_dep == 'Ativo'){
									$cadastro = '';
								}
								
								echo "<tr>";
									echo "<td class='col-md-2'>$nome_dependente </td>";
									echo "<td class='col-md-2'>Dependente</td>";
									echo "<td class='col-md-2'>$cpf</td>";
									echo "<td class='col-md-2'>$data_adesao</td>";
									echo "<td class='col-md-2'>$status_dep</td>";
									echo "<td class='col-md-2'>$cadastro</td>";
								echo "</tr>";
							
						}	

							echo "</tr>";
							
							
					}
					
					echo "</body>";
					echo "</table>";
					echo "</div>";
				} 
				?>
			</table>
		</section>			
	</div>
</body>
</html>