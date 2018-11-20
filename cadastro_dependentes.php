<?php   
    include "include/conexao.php";
    include "include/config.php";
	include "include/funcoes.php";
    include "include/verifica_usuario.php";
	
	
	 if(isset($_GET['id_titular'])){
		$id_titular = $_GET['id_titular'];
		$sql_titular = "SELECT nome FROM tbl_titular WHERE id_titular = '$id_titular'";
		$res_titular = mysqli_query($con, $sql_titular);
		$linha = mysqli_fetch_assoc($res_titular);
		$nome_titular            = $linha['nome'];
	}
	
	if(isset($_GET['id_dependente'])){
		$id_dependente = $_GET['id_dependente'];
		$sql_lista = "SELECT *FROM tbl_dependentes WHERE id_dependente = '$id_dependente'";
		$res_lista = mysqli_query($con, $sql_lista);
		$linha = mysqli_fetch_assoc($res_lista);
		$nome            = $linha['nome'];
		$id_titular      = $linha['id_titular'];
		$cpf             = $linha['cpf'];
	    $data_nasc       = fnc_data_formatada($linha['data_nascimento']);
		$data_adesao     = fnc_data_formatada($linha['data_adesao']);
		$sexo            = $linha['sexo'];
		$estado_civil    = $linha['estado_civil'];
		$parentesco      = $linha['parentesco'];
		$status          = $linha['status'];
	}
	
	if(isset($_GET['excluir'])){
		$id_dependente = $_GET['excluir'];
		$id_titular    = $_GET['id_titular'];
		$sql_excluir = "UPDATE tbl_dependentes SET status = 'I'  WHERE id_dependente = $id_dependente AND id_titular = $id_titular";
		//echo $sql_excluir;
		$res_excluir = mysqli_query($con, $sql_excluir);
			if(strlen(trim(mysqli_error($con))) == 0 and empty($erro)){
				$ok .= "Dependente excluído com sucesso.<br>";
			}else{
				$erro .= "Erro, consulte o administrador do sistema.<br>";
			}
	}

   if(isset($_POST["btnacao"])){
        $nome               =   fncTrataDados($_POST["nome"]);
        $cpf                =   fncTrataDados($_POST["cpf"]);
		$data_nasc		    =   fncTrataDados($_POST["data_nasc"]);
		$data_adesao	    =   fncTrataDados($_POST["data_adesao"]);
		$sexo               =   fncTrataDados($_POST["sexo"]);
		$parentesco         =   fncTrataDados($_POST["parentesco"]);
	    $estado_civil       =   fncTrataDados($_POST["estado_civil"]);
		$status             =   fncTrataDados($_POST["status"]);
		$id_dependete		=   fncTrataDados($_POST["id_dependente"]);
		
		
		$retirar = array(".", "-", "/", "(", ")");
		$cpf       = str_replace($retirar, "", $cpf);
		
		
		if(strlen(trim($nome)) == 0){
            $erro .="O campo Nome deve ser preenchido.<br>";
        }
		if(strlen(trim($data_nasc)) == 0){
            $erro .="O campo Data de Nascimento deve ser preenchido.<br>";
        }
		if(strlen(trim($sexo)) == 0){
            $erro .="O campo Sexo deve ser preenchido.<br>";
        }
		if(strlen(trim($parentesco)) == 0){
            $erro .="O campo Parentesco deve ser preenchido.<br>";
        }
		if(strlen(trim($estado_civil)) == 0){
            $erro .="O campo Estado Civil deve ser preenchido.<br>";
        }
		if(strlen(trim($data_adesao)) == 0){
            $erro .="O campo Data de Adesão deve ser preenchido.<br>";
        }
		if(strlen(trim($status)) == 0){
            $erro .="O campo Status deve ser preenchido.<br>";
        }
		
		
		if($id_dependente == 0 and strlen(trim($cpf))>0){
            //verifica se já esta cadastrado.
            $sql_verifica = "SELECT cpf FROM tbl_dependentes WHERE cpf = '$cpf'";
            $res_verifica = mysqli_query($con, $sql_verifica);
            if(mysqli_num_rows($res_verifica)>0){
                $erro .= "CPF já cadastrado.";
            }
        }
		
		if(ValidaData($data_nasc) == 0){
			 $erro .="Data de Nascimento Inválida.<br>";
		}
		if(ValidaData($data_adesao) == 0){
			 $erro .="Data de Adesão Inválida.<br>";
		}
		
		if(empty($erro)){
            if($id_dependente == 0){
                $sql = "INSERT INTO tbl_dependentes (nome, 
													cpf,
													data_nascimento, 
													parentesco,
													sexo, 
													estado_civil,
													data_adesao,
													status,
												    id_titular)  
										 VALUES ('$nome', 
												 '$cpf',
												 '".fnc_formata_data($_POST["data_nasc"])."',
												 '$parentesco',
												 '$sexo',
												 '$estado_civil',
												  '".fnc_formata_data($_POST["data_adesao"])."',
												 '$status',
												 '$id_titular')";
            }else{
                $sql = "UPDATE tbl_dependentes SET nome = '$nome', 
											   cpf = '$cpf', 
											   data_nascimento = '".fnc_formata_data($_POST["data_nasc"])."',
											   parentesco = '$parentesco',
											   sexo = '$sexo',
											   estado_civil = '$estado_civil',
											   data_adesao = '".fnc_formata_data($_POST["data_adesao"])."',
											   status = '$status'
											   WHERE id_dependente = $id_dependente";
            }
			$res = mysqli_query($con, $sql);
			//echo $sql;
			if(strlen(trim(pg_last_error($con))) == 0 and empty($erro)){
                $ok .= "Cadastro Realizado com Sucesso.";
				$nome = "";
				$cpf = "";
				$data_nasc = "";
				$data_adesao = "";
				$parentesco = "";
				$sexo = "";
				$estado_civil = "";
				$status = "";
            }
		}	
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
		
		<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/jquery.mask.min.js"></script>	
		
		

<script type="text/javascript">      
       $(document).ready(function(){
			$("#cpf").mask("000.000.000-00");
			$("#data_nasc").mask("00/00/0000");
			$("#data_adesao").mask("00/00/0000");
        });   

		function confirma(){
			  var press = confirm("Tem certeza que deseja excluir este Dependente ?");
				if(press){
					return true;
				}else{
					return false;
				}
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
                    <div class="col-md-10 corpo">
                        <div class="page-header">                            
                            <div class=" col-md-10 titulo_tela" >Cadastro Dependentes</div>                         
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
								<label>Titular: </label>
								<?=$nome_titular?>
							</div>
						</div>
						<br>
                            <form method="POST">
                                <div class='row'>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nome*</label>
                                            <input type="text" name="nome" value="<?php echo $nome ?>" maxlength="50" class="form-control" placeholder="Nome">
                                        </div>
                                    </div>
									<div class="col-md-2">
                                        <div class="form-group">
											<label>CPF</label>
                                            <input type="text" name="cpf" id="cpf" value="<?php echo $cpf?>"  class="form-control" placeholder="CPF">
                                        </div>
                                    </div>
									<div class="col-md-2">
                                        <div class="form-group">
                                            <label>Data de Nascimento*</label>
                                            <input type="text" name="data_nasc" value="<?php echo $data_nasc ?>" class="form-control"  id="data_nasc" placeholder="Data de Nascimento">
                                        </div>
                                    </div>
								    <div class="col-md-2">
                                        <div class="form-group">
                                           <label>Sexo*</label><br>
                                             <select name="sexo" class="form-control">
                                                <option value="">Sexo</option>
                                                <option value="F" <?php if($sexo == "F"){echo " selected ";}?> >Feminino</option>
                                                <option value="M" <?php if($sexo == "M"){echo " selected ";}?> >Masculino</option>
										    </select>
                                        </div>
                                    </div>
									<div class="col-md-2">
                                        <div class="form-group">
                                           <label>Parentesco*</label><br>
                                             <select name="parentesco" class="form-control">
                                                <option value="">Parentesco</option>
												<option value="A" <?php if($parentesco == "A"){echo " selected ";}?> >Avô(ó)</option>
                                                <option value="C" <?php if($parentesco == "C"){echo " selected ";}?> >Cônjuge</option>
												<option value="F" <?php if($parentesco == "F"){echo " selected ";}?> >Filho(a)</option>
												<option value="T" <?php if($parentesco == "T"){echo " selected ";}?> >Tio/Tia</option>
												<option value="O" <?php if($parentesco == "O"){echo " selected ";}?> >Outros</option>
										    </select>
                                        </div>
                                    </div>
                                </div>
								
                                <div class='row'>
									<div class="col-md-offset-2 col-md-2">
                                       <div class="form-group">
											<label>Estado Cívil*</label><br>
                                             <select name="estado_civil" class="form-control">
                                                <option value="">Estado Cívil</option>
                                                <option value="C" <?php if($estado_civil == "C"){echo " selected ";}?> >Casado(a)/U. Estável</option>
												<option value="D" <?php if($estado_civil == "D"){echo " selected ";}?> >Divorciado(a)</option>
                                                <option value="S" <?php if($estado_civil == "S"){echo " selected ";}?> >Solteiro(a)</option>
										    </select>
                                       </div>
                                    </div>
									<div class="col-md-2">
                                        <div class="form-group">
                                            <label>Data de Adesão*</label>
                                            <input type="text" name="data_adesao" value="<?php echo $data_adesao ?>" class="form-control"  id="data_adesao" placeholder="Data de Adesão">
                                        </div>
                                    </div>
									<div class="col-md-3">
                                        <div class="form-group">
                                           <label>Status*</label><br>
                                              <select name="status" class="form-control" id="status">
                                                  <option value="">Status</option>
                                                      <option value="A" <?php if($status == "A"){echo " selected ";}?> >Ativo</option>
                                                      <option value="I" <?php if($status == "I"){echo " selected " ;}?>>Inativo</option>
                                              </select>
                                        </div>
                                    </div>
								</div>
								

                                <div class="row">
                                    <div class="col-md-12 botao">
                                        <input class="btn btn-info" type="submit" name="btnacao" value="Gravar">
										<input type="hidden" name="id_dependente" value="<?=$id_dependente?>">
                                    </div>
                                </div>
                            </form>
							<br>
							<div class="">
								<div class="table-responsive">
									<table class="table table-striped">  
										<thead>
											<tr>
												<th>Nome</th>
												<th>CPF</th>
												<th>status</th>
												<th colspan="2">Ações</th>
											</tr>
										</thead>
										<tbody>
											 <?php
												$sql_dependente = "SELECT id_dependente, nome, cpf, status FROM tbl_dependentes WHERE id_titular = $id_titular ORDER BY nome";
												//echo $sql_dependente;
												$res_dependente = mysqli_query($con, $sql_dependente);
												for($i=0; $i<mysqli_num_rows($res_dependente); $i++){
													$linha = mysqli_fetch_assoc($res_dependente);
													$id_dependente = $linha['id_dependente'];
													$nome          = $linha['nome'];
													$cpf           = $linha['cpf'];
													$status        = $linha['status'];
													
													if($status == 'A'){
														$status_dep = "Ativo";
													}else{
														$status_dep = "Inativo";
													}
													echo "<tr>";
														echo "<td class='col-md-2'>$nome</td>";
														echo "<td class='col-md-2'>$cpf</td>";
														echo "<td class='col-md-2'>$status_dep</td>";														
														echo "<td class='col-md-1'><a href='./cadastro_dependentes.php?id_dependente=$id_dependente&id_titular=$id_titular' class='btn btn-primary btn-sm'>Editar</a></td>";
														echo "<td class='col-md-1'><a href='./cadastro_dependentes.php?excluir=$id_dependente&id_titular=$id_titular' onclick='return confirma()' class='btn btn-danger btn-sm'>Excluir</a></td>";
													echo "</tr>";
												}
											 ?>
										</tbody>
									</table>
								</div>
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
            <script src="js/bootstrap.min.js"></script>
        </div>
    </body>
</html>
