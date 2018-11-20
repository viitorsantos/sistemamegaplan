<?php   
    include "include/conexao.php";
    include "include/config.php";
    include "include/verifica_usuario.php";

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
		
		<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery.mask.min.js"></script>	
		
		<script type="text/javascript">
            $(function(){
			  $("#inicio").mask("99/99/9999");
			  $("#fim").mask("99/99/9999");
			  
				$('#todos').click(function(){
					if($('#todos').is(':checked')){
						$('#inicio, #fim').prop("disabled", true);
					}else{
						$('#inicio, #fim').prop("disabled", false);
					}
				});
			});
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
                    <div class="col-md-10 corpo">
                        <div class="page-header">                            
                            <div class=" col-md-10 titulo_tela" >Relatório Associados</div>
                         
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
                            <form method="POST" action="associados.php" target="_blank">
								<div class="row">
								  <div class="col-md-offset-4 col-md-2">
									<div class="form-group">
									  <label>Todos</label>
									  <input type="checkbox" id="todos" name="todos">
									</div>
								  </div>
								</div>
								
								<div class="row">
								  <div class="col-md-offset-4 col-md-2">
									<div class="form-group">
									  <label>Ínicio</label>
									  <input type="text" class="form-control" name='inicio' id="inicio" value="<?=$inicio?>" required>
									</div>
								  </div>
								  <div class="col-md-2">
									<div class="form-group">
									  <label>Fim</label>
									  <input type="text" class="form-control" name='fim' id="fim" value="<?=$fim?>" required>
									</div>
								  </div>
								</div>
								
								<div class="row">
								  <div class="col-md-offset-4 col-md-4">
									<div class="form-group">
									  <label>Status</label>
									  <select name="status" id="status"  class="form-control">
										 <option value="">Status</option>
										 <option value="A">Ativo</option>
										 <option value="I">Inativo</option>
									  </select>
									</div>
								  </div>
								</div>
								<div class="row">
								<div class="col-md-12">
									<div class="form-group" style="text-align: center">
										 <input type="submit" name="btnacao" value="Buscar" class="btn btn-info">
									</div>
								</div>
							</div>	
                            </form> 
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
            <script src="js/bootstrap.min.js"></script>
        </div>
    </body>
</html>
