<?php
/* Inicia sessуo */
header('Content-Type: text/html; charset=utf-8');
session_start();

/* Funчуo para logar no sistema */
function sign_in($user_data, $acess){
	$_SESSION['user'] = $user_data;
	$_SESSION['acess'] = $acess;
	$_SESSION['log'] = true;
}

/* Funчуo para deslogar */
function sign_out(){
	$_SESSION['acess'] = 0;
	$_SESSION['log'] = false;
	session_unset();
}

/* Verifica se estс logado */
function login($acces = 0){
	if(acess_login()){
		if($acces == $_SESSION['acess']) return true;
		else return false;
	}
}

/* Acessos do administrador */
function acess_login(){
	if(!isset($_SESSION['log']) || $_SESSION['log'] == false) return false;
	return true;
}

?>