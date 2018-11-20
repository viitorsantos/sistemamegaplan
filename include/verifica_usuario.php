<?php
	
	session_start();
	if($_SESSION['id_usuario'] <= 0){
		header("Location: index.php");
	}
?>