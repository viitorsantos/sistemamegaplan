<?php
    include "include/conexao.php";
    include "include/config.php";
    include "include/verifica_usuario.php";
	
	$sql_titular = "SELECT id_titular FROM tbl_titular WHERE status = 'A'";
	$res_titular = mysqli_query($con, $sql_titular);
	$qtd_titular = mysqli_num_rows($res_titular);
	
	$sql_titular_i = "SELECT id_titular FROM tbl_titular WHERE status = 'I'";
	$res_titular_i = mysqli_query($con, $sql_titular_i);
	$qtd_titular_i = mysqli_num_rows($res_titular_i);
	
	$sql_dependente = "SELECT id_dependente, tbl_titular.status, tbl_dependentes.status FROM tbl_dependentes
					  INNER JOIN tbl_titular ON tbl_titular.id_titular = tbl_dependentes.id_titular
					  WHERE tbl_titular.status = 'A' AND tbl_dependentes.status = 'A' ";
	$res_dependente = mysqli_query($con, $sql_dependente);
	$qtd_dependente = mysqli_num_rows($res_dependente);
	
	$sql_dependente_i = "SELECT id_dependente, tbl_titular.status, tbl_dependentes.status FROM tbl_dependentes
					  INNER JOIN tbl_titular ON tbl_titular.id_titular = tbl_dependentes.id_titular
					  WHERE tbl_titular.status = 'A' AND tbl_dependentes.status = 'I' ";
	$res_dependente_i = mysqli_query($con, $sql_dependente_i);
	$qtd_dependente_i = mysqli_num_rows($res_dependente_i);
	
	$sql_dependente_i_2 = "SELECT id_dependente, tbl_titular.status, tbl_dependentes.status FROM tbl_dependentes
					  INNER JOIN tbl_titular ON tbl_titular.id_titular = tbl_dependentes.id_titular
					  WHERE tbl_titular.status = 'I' AND tbl_dependentes.status = 'I' ";
	$res_dependente_i_2 = mysqli_query($con, $sql_dependente_i_2);
	$qtd_dependente_i_2 = mysqli_num_rows($res_dependente_i_2);
	
    $total_inativos_dependentes = $qtd_dependente_i + $qtd_dependente_i_2;
	$total = $qtd_titular + $qtd_dependente + $total_inativos_dependentes + $qtd_titular_i;

?>
<!DOCTYPE html>
<html lang="PT-BR">
    <head> 
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="UTF-8">
       
		<link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
        <link href="css/style_admin.css" rel="stylesheet">


	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
	
      function drawChart() {
	  
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Titulares Ativos',  <?php echo $qtd_titular;?>],
          ['Dependentes Ativos',   <?php echo $qtd_dependente;?>],
		  ['Titulares Inativos',  <?php echo $qtd_titular_i;?>],
          ['Dependentes Inativos',   <?php echo $total_inativos_dependentes;?>]
        ]);

        var options = {
          title: 'Associados',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
	
    </script>
    </head>
	
    <body>
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                   <?php include "include/cabecalho.php" ?>
                    <div class="col-md-2">
                        <?php include "include/menu_admin.php" ?>
                    </div>
                    <div class="col-md-10 corpo" >
						<div class="page-header">
                            <div class="col-md-10 titulo_tela" >Bem vindo <?php session_start(); echo $_SESSION['nome'];?></div>
                            <div class="col-md-2 link_tela">
                                
                            </div>
                        </div>
                        <?php if (strlen(trim($erro)) > 0): ?>
                            <div class="alert alert-danger">
                                <i class="icon-remove-sign"></i>
                                <?php echo $erro ?>
                            </div>
                        <?php endif; ?>
                        <?php if (strlen(trim($ok)) > 0): ?>
                            <div class="alert alert-success">
                                <i class="icon-ok"></i>
                                <?php echo $ok ?>
                            </div>
                        <?php endif; ?>
                        <div class="conteudo">
							<div class="row">
								<div class="col-md-4">
									<label>Total Titulares</label>
									<?=$qtd_titular + $qtd_titular_i?>
								</div>
								<div class="col-md-4">
									<label>Total Dependentes</label>
									<?=$qtd_dependente + $total_inativos_dependentes ?>
								</div>
								<div class="col-md-4">
									<label>Total Associados</label>
									<?=$total?>
								</div>
							</div>
                        </div>
						<div class="row">
							<div class="col-md-offset-2 col-md-2">
								<div id="piechart_3d" style="width: 900px; height: 500px; margin-top:-650px;"></div>
							</div>
						</div>
                    </div>
                </div>
            </div>
                <div class="row">
                    <?php include RAIZ."include/footer.php" ?>
                </div>
          
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
        </div>
    </body>
</html>