<?php
	
	include "include/conexao.php";
	include "include/config.php";
	
	if(isset($_POST['btnacao'])){
		$login_digitado = $_POST['login'];
		$senha          = $_POST['senha'];
		
		if(strlen(trim($login_digitado)) == 0){
			$erro .= "Digite o login<br>";
		}
		if(strlen(trim($senha)) == 0){
			$erro .= "Digite a senha";
		}
		
		$sql = "SELECT id_usuario, nome, login, senha, ativo FROM tbl_usuario WHERE login = '$login_digitado' AND ativo = 1";
		$res = mysqli_query($con, $sql);
		$linha = mysqli_fetch_assoc($res);
		
		if(mysqli_num_rows($res) == 1){
			$login = $linha['login'];
			$hash  = $linha['senha'];
			$id_usuario = $linha['id_usuario'];
			$nome = $linha['nome'];

			if(($login_digitado == $login) && (password_verify($senha, $hash))){
				session_start();
				$_SESSION['id_usuario'] = $id_usuario;
				$_SESSION['nome'] = $nome;
				header("Location: home.php");
			}else{
				$erro .= "Login ou Senha inválidos<br>";
			}
		}else{
			$erro .= "Este login não existe";
		}
	}
		
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <script src="js/jquery-1.11.3.min.js"></script>
  </head>

  <body>

    <div class="container">
      <form class="form-signin" method="POST" action="">
        <h2 class="form-signin-heading text-center">Autenticação</h2>
		<?php if(strlen(trim($erro))>0){?>
             <div class="alert alert-danger" role="alert"><?php echo $erro ?></div>
         <?php } ?>
        <label for="" class="sr-only">Usuário</label>
        <input type="text" name="login" class="form-control" placeholder="Login" required autofocus>
		<br>
        <label for="" class="sr-only">Senha</label>
        <input type="password" name="senha" class="form-control" placeholder="Senha" required>
       
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnacao">Entrar</button>
      </form>
    </div> 

  </body>
</html>
