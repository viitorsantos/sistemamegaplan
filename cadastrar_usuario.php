<?php
    include "include/conexao.php";
    include "include/config.php";
    include "include/verifica_usuario.php";

	if(isset($_POST["btnacao"])){
	   $id_usuario = $_POST['id_usuario'];
       $nome       = $_POST['nome'];
	   $email      = $_POST['email'];
	   $login      = $_POST['login'];
	   $senha      = $_POST['senha'];
	   
        if(strlen(trim($nome)) == 0){
            $erro .= "O campo nome deve ser preenchido. <br>";
        }
        if(strlen(trim($login)) == 0){
            $erro .= "O campo login deve ser preenchido. <br>";
        }
		
		$sql_login = "SELECT login, corretora_id from tbl_usuario WHERE login = '$login'";
		$res_login = mysqli_query($con, $sql_login);
		if(mysqli_num_rows($res_login) == 1){
			$erro .= "Este login já existe<br>";
		}
		
		if(strlen(trim($senha)) == 0){
            $erro .= "O campo senha deve ser preenchido. <br>";
        }else{
			$options = [
			  'cost' => 11,
			  'salt' => SECURITY_HASH,
			];

			$hash = password_hash("$senha", PASSWORD_DEFAULT, $options);
		}
		
		
        if(empty($erro)){ //se erro estiver vazio
            if($id_usuario == 0){
                $sql = "INSERT INTO tbl_usuario (nome, email, login, senha)  
                VALUES ('$nome', '$email', '$login', '$hash')";
            }
			$res = mysqli_query($con, $sql);
            if(strlen(trim(mysqli_error($con))) == 0 and empty($erro)){
                $ok .= "Cadastro Realizado com Sucesso.";
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
        <link href="../css/dashboard.css" rel="stylesheet">
        <link href="../css/style_admin.css" rel="stylesheet">
		
		
    </head>
	
    <body>
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                   <?php include "../include/cabecalho.php" ?>
                    <div class="col-md-2">
                        <?php include "../include/menu_admin.php" ?>
                    </div>
                    <div class="col-md-10 corpo" >
                        <div class="page-header">
                            <div class="col-md-10 titulo_tela" >Usuário</div>
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
										<div class="col-md-offset-2 col-md-4">
											<label>Nome Completo</label>
											<input type="text" maxlength="50" class="form-control" name="nome" value="<?=$nome?>" placeholder="Nome Completo">	
										</div>
										<div class="col-md-4">
											<label>Email</label>
											<input type="email" maxlength="50" class="form-control" name="email" value="<?=$email?>" placeholder="Email">	
										</div>
									</div>
									<div class="row">
										<div class="col-md-offset-2 col-md-4">
											<label>Login</label>
											<input type="text" maxlength="20" class="form-control" name="login" value="<?=$login?>" placeholder="Login">	
										</div>
										<div class="col-md-4">
											<label>Senha</label>
											<input type="password" maxlength="20" class="form-control" name="senha" value="<?=$senha?>" placeholder="Senha">	
										</div>
									</div>
                                    
									<br>
									<div class="row">
										<div class="col-md-12 botao">
											<input class="btn btn-info" type="submit" name="btnacao" value="Gravar">
											<input type="hidden" name="id_usuario" value="<?php echo $id_usuario ?>">
											
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
            <script src="../js/bootstrap.min.js"></script>
        </div>
    </body>
</html>