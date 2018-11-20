<?php
    include "include/conexao.php";
    include "include/config.php";
    include "include/verifica_usuario.php";

	if(isset($_POST['btnacao'])){
		session_start();
		$_SESSION['id_usuario']; 
		$id_usuario = $_SESSION['id_usuario'];
		
		$senha_atual = $_POST['senha_atual'];
		$nova_senha  = $_POST['nova_senha'];
		$confirma    = $_POST['confirma'];
		
		if(strlen(trim($senha_atual)) == 0){
			$erro .= "O campo senha atual deve ser preenchido.<br>";
		}
		$sql_confere = "SELECT senha FROM tbl_usuario WHERE id_usuario = $id_usuario  AND ativo = 1";
		$res_confere = mysqli_query($con, $sql_confere);
		$linha = mysqli_fetch_assoc($res_confere);
		$hash = $linha['senha'];
		if(!password_verify($senha_atual, $hash)){
			$erro .= "Senha atual está incorreta.<br>";
		}
		if(strlen(trim($nova_senha)) == 0){
			$erro .= "O campo nova senha deve ser preenchido.<br>";
		}
		if(strlen(trim($confirma)) == 0){
			$erro .= "O campo confirma senha deve ser preenchido.<br>";
		}
		if($nova_senha != $confirma){
			$erro .= "nova senha e confirma estão diferentes.<br>";
		}
		
		if(empty($erro)){
			$options = [
				'cost' => 11,
				'salt' => SECURITY_HASH,
				];
			$hash = password_hash("$nova_senha", PASSWORD_DEFAULT, $options);
			$sql = "UPDATE tbl_usuario SET senha = '$hash' 
			WHERE id_usuario = $id_usuario AND ativo = 1";
			$res = mysqli_query($con, $sql);
			if(strlen(trim(mysqli_error($con))) == 0 and empty($erro)){
                $ok .= "Senha Alterada com Sucesso.";
            }else{
				$erro .= "Erro, consulte o administrador do sistema.<br>";
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
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
        <link href="css/style_admin.css" rel="stylesheet">
		
		
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
                            <div class="col-md-10 titulo_tela" >Alterar Senha</div>
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
                                <form method="POST" action="">
									<div class="row">
										<div class="col-md-offset-4 col-md-4">
											<label>Senha Atual*</label>
											<input type="password" maxlength="20" name="senha_atual" value="<?=$senha_atual?>" class="form-control" placeholder="Senha Atual">
										</div>
									</div>
									<div class="row">
										<div class="col-md-offset-4 col-md-4">
											<label>Nova Senha*</label>
											<input type="password" maxlength="20" name="nova_senha" value="<?=$nova_senha?>" class="form-control" placeholder="Nova Senha">
										</div>
									</div>
									<div class="row">
										<div class="col-md-offset-4 col-md-4">
											<label>Confirma Nova Senha*</label>
											<input type="password" maxlength="20" name="confirma" value="<?=$confirma?>" class="form-control" placeholder="Confirma">
										</div>
									</div>
									<br>
                                    <div class="row">
										<div class="col-md-12 botao">
											<input class="btn btn-info" type="submit" name="btnacao" value="Gravar">
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
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
        </div>
    </body>
</html>