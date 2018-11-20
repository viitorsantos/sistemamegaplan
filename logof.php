<?php
	session_start();

	$_SESSION["id_usuario"] 	= 0;

	session_destroy();

	header("Location: index.php");

?>