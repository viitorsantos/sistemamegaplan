<?php   
    include "include/conexao.php";
    include "include/config.php";
    include "include/verifica_usuario.php";

   if(isset($_POST["btnacao"])){
        $nome   = $_POST['nome'];
        $cpf    = $_POST['cpf'];

        if(strlen(trim($nome)) == 0 and strlen(trim($cpf)) == 0){
            $erro .= "Os campos Nome ou CPF devem ser preenchidos. <br>";
        }
		
        if(strlen(trim($erro)) == 0){
            $sql = "SELECT id_titular, nome, cpf, celular, status FROM tbl_titular
                    WHERE nome LIKE '%$nome%' AND cpf LIKE '%$cpf%'";
			$res = mysqli_query($con, $sql);
			if(mysqli_num_rows($res)>0){
                echo "<div class='table-responsive'>
                        <table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th class='col-md-1' align='center'></th>
                                    <th class='col-md-3'>Nome</th>
                                    <th class='col-md-2'>CPF</th>
                                    <th class='col-md-2'>Celular</th>
                                    <th class='col-md-2'>Status</th>
                                   
                                </tr>
                            </thead>
                            <body";
                for($i=0; $i<mysqli_num_rows($res); $i++){
					$linha = mysqli_fetch_assoc($res);
					$id_titular = $linha['id_titular'];
					$nome       = $linha['nome'];
					$cpf        = $linha['cpf'];
					$status     = $linha['status'];
					$celular    = $linha['celular'];
												
					
                    echo "<tr>";
                        echo "<td class='col-md-1'>".($i+1)."</td>";
                        echo "<td class='col-md-3'>$nome</td>";
                        echo "<td class='col-md-2'>$cpf</td>";
                        echo "<td class='col-md-2'>$celular</td>";
						if($status == "A"){
							$condicao = "Ativo";
						}else{
							$condicao = "Inativo";
						}
                        echo "<td class='col-md-2'>$condicao</td>";
                        echo "<td class='col-md-1' align='center'><a href='./cadastro_titular.php?id_titular=$id_titular' title='Editar'>Editar</a></td>";
						echo "<td class='col-md-1' align='center'><a href='./cadastro_dependentes.php?id_titular=$id_titular' title='Cadastrar Dependente'>Dependentes</a></td>";
                    echo "</tr>";
                }
                echo "</body>";
                echo "</table>";
                echo "</div>";
            }else{
				echo "<div class='alert alert-danger'>Nenhum Registro Encontrado</div>"; 
			}
		}else{
            echo "<div class='alert alert-danger'>$erro</div>";
        }
	exit;
        
    }


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
		
		  <script type="text/javascript">
            function fnc_pesquisa(){
                var nome   = $("#nome").val();
                var cpf    = $("#cpf").val();
      
             
                $.ajax({
                    url: 'busca_associado.php',
                    data: {btnacao : true, nome: nome, cpf: cpf},
                    type: 'POST',
                    context: jQuery('#resultado'),
                    //dataType: 'json',
                    success: function(data){
                        this.html(data);
                    }
                }); 
                

            };

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
                            <div class=" col-md-10 titulo_tela" >Pesquisa de Associado</div>
                            <div class="col-md-2 link_tela">
                                <a href="cadastro_titular.php" class="btn btn-info btn-sm"><i class="fa fa-list-alt"></i>Novo Titular</a>        
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
                            <form method="POST">
                                 <div class='row'>
                                    <div class="col-md-8">                                        
                                        <div class="form-group">
                                            <label>Nome do Associado</label>
                                            <input type="text" name="nome" id="nome" maxlength="30" class="form-control" value="<?=$nome?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                         <div class="form-group">
                                            <label>CPF</label>
                                            <input type="text" name="cpf" maxlength="11" id="cpf" onkeypress='return SomenteNumero(event)' value="<?=$cpf ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>   						
                            </form> 
							<div class="row">
									<div class="col-md-12">
										<div class="form-group" style="text-align: center">
											 <input type="submit" name="btnacao" onclick="fnc_pesquisa()" value="Buscar" class="btn btn-info">
										</div>
									</div>
							</div>	
                          
                            <div id="resultado"></div>
                            <br>
                            <?php if($qtd > 0 ){?>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1" align="center">#</th>
                                            <th class="col-md-5">nome</th>
                                            <th class="col-md-2">CPF</th>
                                            <th class="col-md-1"> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($resultado as $linha) {                                            
                                            echo "<tr>";
                                                echo "<td>$i</td>";
                                                echo "<td>$linha[nome]</td>";
                                                echo "<td>$linha[cpf]</td>";
                                                echo "<td><a href='cliente_cadastrar.php?id_titular=$linha[id_titular]'><i class='fa fa-pencil-square-o'></i></a></td>"; 											
                                            echo "</tr>";
                                            $i++;
                                        }
                                        ?>      	
                                    </tbody>
                                </table>
                            </div>
                            <?php }
                            echo "$conteudo";
                            ?>
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
