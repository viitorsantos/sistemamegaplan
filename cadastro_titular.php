<?php   
    include "include/conexao.php";
    include "include/config.php";
	include "include/funcoes.php";
    include "include/verifica_usuario.php";
	

   if(isset($_POST["btnacao"])){
        $nome               =   fncTrataDados($_POST["nome"]);
        $cpf                =   fncTrataDados($_POST["cpf"]);
		$data_nasc		    =   fncTrataDados($_POST["data_nasc"]);
		$sexo               =   fncTrataDados($_POST["sexo"]);
		$profissao          =   fncTrataDados($_POST["profissao"]);
	    $estado_civil       =   fncTrataDados($_POST["estado_civil"]);
		$rg                 =   fncTrataDados($_POST["rg"]);
		$data_exp           =   fncTrataDados($_POST["data_exp"]);
		$orgao   			=   fncTrataDados($_POST["orgao"]);
        $email              =   fncTrataDados($_POST["email"]);
        $cep                =   fncTrataDados($_POST["cep"]);
        $endereco           =   fncTrataDados($_POST["endereco"]);
        $numero             =   fncTrataDados($_POST["numero"]);
        $bairro             =   fncTrataDados($_POST["bairro"]);
        $cidade             =   fncTrataDados($_POST["cidade"]);
		$estado             =   fncTrataDados($_POST["estado"]);
        $complemento        =   fncTrataDados($_POST["complemento"]);
		$celular			=   fncTrataDados($_POST["celular"]);
		$telefone 			=   fncTrataDados($_POST["telefone"]);
		$data_adesao        =   fncTrataDados($_POST["data_adesao"]);
		$status 			=   fncTrataDados($_POST["status"]);
		$mensalidade	    =   fncTrataDados($_POST["mensalidade"]);
		$data_exclusao	    =   fncTrataDados($_POST["data_exclusao"]);
		$motivo			    =   fncTrataDados($_POST["motivo"]);
		
		$id_titular			=   fncTrataDados($_POST["id_titular"]);
		
		
		$retirar = array(".", "-", "/", "(", ")");
		$cpf       = str_replace($retirar, "", $cpf);
		$rg        = str_replace($retirar, "", $rg);
		$cep       = str_replace($retirar, "", $cep);
		$celular   = str_replace($retirar, "", $celular);
		$telefone  = str_replace($retirar, "", $telefone);
		
		
		
		if(strlen(trim($nome)) == 0){
            $erro .="O campo Nome deve ser preenchido.<br>";
        }
		if(strlen(trim($cpf)) == 0){
            $erro .="O campo CPF deve ser preenchido.<br>";
        }
		if(strlen(trim($data_nasc)) == 0){
            $erro .="O campo Data de Nascimento deve ser preenchido.<br>";
        }
		if(strlen(trim($sexo)) == 0){
            $erro .="O campo Sexo deve ser preenchido.<br>";
        }
		if(strlen(trim($estado_civil)) == 0){
            $erro .="O campo Estado Civil deve ser preenchido.<br>";
        }
		if(strlen(trim($cep)) == 0){
            $erro .="O campo CEP deve ser preenchido.<br>";
        }
		if(strlen(trim($endereco)) == 0){
            $erro .="O campo Endereço deve ser preenchido.<br>";
        }
		if(strlen(trim($numero)) == 0){
            $erro .="O campo Numero deve ser preenchido.<br>";
        }
		if(strlen(trim($bairro)) == 0){
            $erro .="O campo Bairro deve ser preenchido.<br>";
        }
		if(strlen(trim($cidade)) == 0){
            $erro .="O campo Cidade deve ser preenchido.<br>";
        }
		if(strlen(trim($estado)) == 0){
            $erro .="O campo Estado deve ser preenchido.<br>";
        }
		if(strlen(trim($celular)) == 0){
            $erro .="O campo Celular deve ser preenchido.<br>";
        }
		if(strlen(trim($data_adesao)) == 0){
            $erro .="O campo Data de Adesão deve ser preenchido.<br>";
        }
		if(strlen(trim($status)) == 0){
            $erro .="O campo Status deve ser preenchido.<br>";
        }
		if(strlen(trim($mensalidade)) == 0){
            $erro .="O campo Mensalidade deve ser preenchido.<br>";
        }
		
		if($id_titular == 0 and strlen(trim($cpf))>0){
            //verifica se já esta cadastrado.
            $sql_verifica = "SELECT cpf FROM tbl_titular WHERE cpf = '$cpf'";
            $res_verifica = mysqli_query($con, $sql_verifica);
            if(mysqli_num_rows($res_verifica)>0){
                $erro .= "CPF já cadastrado.";
            }
        }
		
		if(ValidaData($data_nasc) == 0){
			 $erro .="Data de Nascimento Inválida.<br>";
		}
		if(strlen(trim($data_exp)) != 0){
			if(ValidaData($data_exp) == 0){
				$erro .="Data de Expedição Inválida.<br>";
			}
        }
		if(ValidaData($data_adesao) == 0){
			 $erro .="Data de Adesão Inválida.<br>";
		}
		if(strlen(trim($data_exclusao)) != 0){
			if(ValidaData($data_exclusao) == 0){
				$erro .="Data de Exclusão Inválida.<br>";
			}
        }
		
		if(empty($erro)){
            if($id_titular == 0){
                $sql = "INSERT INTO tbl_titular (nome, 
												 cpf,
												 data_nascimento, 
												 sexo, 
												 estado_civil,
												 rg, 
												 data_expedicao,
												 orgao,
												 cep,
												 endereco,
												 numero,
												 bairro,
												 cidade,
												 estado,
												 complemento,
												 email,
												 telefone,
												 celular,
												 profissao,
												 data_adesao,
												 status,
												 mensalidade,
												 data_exclusao,
												 motivo)  
										 VALUES ('$nome', 
												 '$cpf',
												 '".fnc_formata_data($_POST["data_nasc"])."',
												 '$sexo',
												 '$estado_civil', 
												 '$rg',
												 '".fnc_formata_data($_POST["data_exp"])."',
												 '$orgao', 
												 '$cep',
												 '$endereco',
												 '$numero',
												 '$bairro',
												 '$cidade',
												 '$estado',
												 '$complemento',
												 '$email',
												 '$telefone', 
												 '$celular', 
												 '$profissao',
												 '".fnc_formata_data($_POST["data_adesao"])."',
												 '$status',
												 '$mensalidade',
												 '".fnc_formata_data($_POST["data_exclusao]"])."',
												 '$motivo')";
            }else{
                $sql = "UPDATE tbl_titular SET nome = '$nome', 
											   cpf = '$cpf', 
											   data_nascimento = '".fnc_formata_data($_POST["data_nasc"])."',
											   sexo = '$sexo',
											   estado_civil = '$estado_civil',
											   rg = '$rg',
											   data_expedicao =  '".fnc_formata_data($_POST["data_exp"])."',
											   orgao = '$orgao',
											   cep = '$cep',
											   endereco = '$endereco',
											   numero = '$numero',
											   bairro = '$bairro', 
											   cidade = '$cidade',
											   estado = '$estado',
											   complemento = '$complemento',
											   email = '$email', 
											   telefone = '$telefone',
											   celular = '$celular',
											   profissao = '$profissao',
											   data_adesao = '".fnc_formata_data($_POST["data_adesao"])."',
											   status = '$status',
											   mensalidade = '$mensalidade',
											   data_exclusao = '".fnc_formata_data($_POST["data_exclusao"])."',
											   motivo = '$motivo' WHERE id_titular = $id_titular";
            }
			$res = mysqli_query($con, $sql);
			//echo $sql;
			if(strlen(trim(pg_last_error($con))) == 0 and empty($erro)){
                $ok .= "Cadastro Realizado com Sucesso.";
            }
		}	
   }
   
   if(isset($_GET['id_titular'])){
		$id_titular = $_GET['id_titular'];
		$sql_lista = "SELECT *FROM tbl_titular WHERE id_titular = '$id_titular'";
		$res_lista = mysqli_query($con, $sql_lista);
		$linha = mysqli_fetch_assoc($res_lista);
		$nome            = $linha['nome'];
		$cpf             = $linha['cpf'];
	    $data_nasc       = fnc_data_formatada($linha['data_nascimento']);
		$sexo            = $linha['sexo'];
		$estado_civil    = $linha['estado_civil'];
		$rg              = $linha['rg'];
		$data_exp        = fnc_data_formatada($linha['data_expedicao']);
		$orgao           = $linha['orgao'];
		$cep             = $linha['cep'];
		$endereco        = $linha['endereco'];
		$numero          = $linha['numero'];
		$bairro          = $linha['bairro'];
		$cidade          = $linha['cidade'];
		$estado          = $linha['estado'];
		$complemento     = $linha['complemento'];
		$email           = $linha['email'];
		$telefone        = $linha['telefone'];
		$celular         = $linha['celular'];
		$profissao       = $linha['profissao'];
		$data_adesao     = fnc_data_formatada($linha['data_adesao']);
		$status          = $linha['status'];
		$mensalidade     = $linha['mensalidade'];
		$data_exclusao   = fnc_data_formatada($linha['data_exclusao']);
		$motivo          = $linha['motivo'];
	}
	
	if($data_exp == '00/00/0000'){
		$data_exp = "";
	}
	if($data_exclusao == '00/00/0000'){
		$data_exclusao = "";
	}
	
	if($status == 'I'){
		$sql_dep = "UPDATE tbl_dependentes SET status = 'I' WHERE id_titular = '$id_titular'";
		$res_dep = mysqli_query($con, $sql_dep);
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
			$('#excluir').hide();
			$("#cpf").mask("000.000.000-00");
			$("#data_nasc").mask("00/00/0000");
			$("#rg").mask("00.000.000-A");
			$("#data_exp").mask("00/00/0000");
			$("#cep").mask("00.000-000");
			$("#celular").mask("(99) 99999-9999");
			$("#telefone").mask("(99) 9999-9999");
			$("#data_adesao").mask("00/00/0000");
			$("#data_exclusao").mask("00/00/0000");
			
			$('#cep').blur(function(){
                var cep = $('#cep').val();
                $.ajax({
                    url: 'consulta_cep.php',
                    type: 'POST',
                    data: {btnacao:true, cep:cep},                  
                    dataType: 'json',
                    success: function(data){
                            $('#endereco').val(data.endereco);
                            $('#bairro').val(data.bairro);
                            $('#cidade').val(data.cidade);
                            $('#estado').val(data.estado);  
							
							//$('#element option[value="no"]').attr("selected", "selected");
                    }
                });
                return false;
            })
			
			$('#status').change(function(){
				var status = $('#status').val();
				if(status == "A"){
					$('#excluir').hide();
				}else{
					$('#excluir').show();
				}
			})
			
			var status = $('#status').val();
			if(status == "A"){
					$('#excluir').hide();
				}else{
					$('#excluir').show();
				}
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
                            <div class=" col-md-10 titulo_tela" >Cadastro titular</div>
                            <div class="col-md-2 link_tela">
                                <a href="cadastro_titular.php" class="btn btn-info btn-sm"><i class="fa fa-list-alt"></i>Limpar</a>        
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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nome*</label>
                                            <input type="text" name="nome" value="<?php echo $nome ?>" maxlength="50" class="form-control" placeholder="Nome">
                                        </div>
                                    </div>
									<div class="col-md-2">
                                        <div class="form-group">
											<label>CPF*</label>
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
                                           <label>Profissão</label>
                                           <input type="text" name="profissao" value="<?php echo $profissao?>" maxlength="50" class="form-control" placeholder="Profissão">
                                       </div>
                                    </div>
                                </div>
								
                                <div class='row'>
									<div class="col-md-2">
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
                                            <label>RG</label>
                                            <input type="text" name="rg"  value="<?php echo $rg?>" id="rg" maxlength="12" class="form-control" id="RG" placeholder="RG">
                                        </div>
                                    </div>
									<div class="col-md-2">
                                        <div class="form-group">
                                            <label>Data de Expedição</label>
                                            <input type="text" name="data_exp" value="<?php echo $data_exp ?>" class="form-control"  id="data_exp" placeholder="Data de Expedição">
                                        </div>
                                    </div>
									<div class="col-md-2">
                                        <div class="form-group">
                                            <label>Orgão</label>
                                            <input type="text" name="orgao" value="<?php echo $orgao?>" maxlength="20" class="form-control" placeholder="Orgão">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="form-group">
                                            <label>E-mail</label>
                                            <input type="email" name="email" value="<?php echo $email ?>" class="form-control" maxlength="50"  placeholder="E-Mail">
                                       </div>
                                    </div>
								</div>

                                <div class="row">									
									<div class="col-md-2">
										<div class="form-group">
											<label>CEP*</label>
											<input type="text" name="cep" id="cep" value="<?php echo $cep ?>" class="form-control" >
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Endereço*</label>
											<input type="text" name="endereco" id="endereco" value="<?php echo $endereco ?>" maxlength="50" class="form-control" >
										</div>
									</div>	
									<div class="col-md-1">
										<div class="form-group">
											<label>Número*</label>
											<input type="text" name="numero" value="<?php echo $numero ?>" maxlength="5" class="form-control">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>Bairro*</label>
											<input type="text" name="bairro" id="bairro" value="<?php echo $bairro ?>" maxlength="60" class="form-control">
										</div>
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label>Cidade*</label>
											<input type="text" name="cidade" id="cidade" value="<?php echo $cidade ?>" maxlength="30" class="form-control">
										</div>
									</div>
									<div class="col-md-1">
										<div class="form-group">
											<label>Estado*</label>
											<input type="text" name="estado" id="estado" value="<?php echo $estado ?>" class="form-control">
										</div>
									</div>									
								</div>
								
								<div class="row">
								   <div class="col-md-3">
									   <div class="form-group">
										  <label>Complemento</label>
										  <input type="text" name="complemento" value="<?php echo $complemento ?>" maxlength="40" class="form-control">
									   </div>
									</div>
									<div class="col-md-2">
                                        <div class="form-group">
                                            <label>Celular*</label>
                                            <input type="text" name="celular" id="celular" value="<?php echo $celular ?>" class="form-control">
                                        </div>
                                    </div>	
									<div class="col-md-2">
                                        <div class="form-group">
                                            <label>Telefone</label>
                                            <input type="text" name="telefone" id="telefone" value="<?php echo $telefone ?>" class="form-control">
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
								 <div class="col-md-offset-5 col-md-2">
									   <div class="form-group">
										  <label>Mensalidade*</label>
										  <input type="text" name="mensalidade" value="<?php echo $mensalidade ?>" maxlength="10" class="form-control">
									   </div>
									</div>
								</div>
								
								<div class="row" id="excluir">
									<div class="col-md-offset-3 col-md-2">
										<div class="form-group">
                                           <label>Data de Exclusão</label>
                                           <input type="text" name="data_exclusao" value="<?php echo $data_exclusao ?>" class="form-control"  id="data_exclusao" placeholder="Data de Exclusão">
										</div>
									</div>
									<div class="col-md-3">
                                        <div class="form-group">
                                           <label>Motivo</label><br>
                                             <textarea rows="3" cols="45" name="motivo"><?=$motivo?></textarea>
                                        </div>
                                    </div>
								</div>

                                <div class="row">
                                    <div class="col-md-12 botao">
                                        <input class="btn btn-info" type="submit" name="btnacao" value="Gravar">
										<input type="hidden" name="id_titular" value="<?=$id_titular?>">
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
