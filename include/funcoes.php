<?php

function fncTrataDados($dados){
	return $dados;
}

function jf_anti_injection($sql) {
    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|*|--|\)/"),"",$sql);
    $sql = trim($sql);
    $sql = strip_tags($sql);
    $sql = addslashes($sql);
    return $sql;
}

function fnc_maiusculas($str) {
	return strtr(strtoupper($str),"áàãâäéèëêíìïîóòöõôúùüûç","ÁÀÃÂÄÉÈËÊÍÌÏÎÓÒÖÕÔÚÙÜÛÇ");
}

function fnc_minusculas($str) {
	return strtr(strtolower($str),"ÁÀÃÂÄÉÈËÊÍÌÏÎÓÒÖÕÔÚÙÜÛÇ", "aaaaaeeeeiiiiooooouuuuc");
}


function fnc_formata_data($data){
	$data2 = substr($data, 6, 4) . "-" . substr($data, 3, 2) . "-" . substr($data, 0, 2);	
	return $data2;
}

function fnc_data_formatada($data){
	$dia = substr($data, 8 , 2);
	$mes = substr($data, 5 , 2); 
    $ano = substr($data, 0 , 4); 
	return "$dia/$mes/$ano";
}

function ValidaData($data){
	$data_hoje = date('Y-m-d');
	$data_hoje = strtotime($data_hoje);
	
	$data_digitada = fnc_formata_data($data);
	$data_digitada = strtotime($data_digitada);
	
	$erro = 1;
	
	if($data_digitada > $data_hoje){
		$erro = 0;
	}
	
	$data = explode("/","$data"); // fatia a string $data em pedados, usando / como referência

	$d = $data[0];
	$m = $data[1];
	$y = $data[2];

	// verifica se a data é válida!
	// 1 = true (válida)
	// 0 = false (inválida)
	$res = checkdate($m,$d,$y);
	if($erro == 0){
		$res = 0;
	}
	
	if ($res == 1){
	   return 1;
	} else {
	   return 0;
	}
}

function ValidaData2($data){
	$data = explode("/","$data"); // fatia a string $data em pedados, usando / como referência

	$d = $data[0];
	$m = $data[1];
	$y = $data[2];
	
	// verifica se a data é válida!
	// 1 = true (válida)
	// 0 = false (inválida)
	$res = checkdate($m,$d,$y);
	if ($res == 1){
	   return 1;
	   
	} else {
	   return 0;
	}
}

?>