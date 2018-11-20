<?php 
	$cep	= $_POST['cep'];

	$reg	= simplexml_load_file("http://cep.republicavirtual.com.br/web_cep.php?formato=xml&cep=" . $cep);
	
	$dados['endereco']	  = (string) $reg->tipo_logradouro . " ". $reg->logradouro;
	$dados['bairro']  = (string) $reg->bairro;
	$dados['cidade']  = (string) $reg->cidade;
	$dados['estado']  = (string) $reg->uf;

	//echo "teste $cep";
	
	echo json_encode($dados);
 ?>