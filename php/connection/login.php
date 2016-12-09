<?php
/* Definindo charset - necessário a partir do php 5.3 */
header('Content-type: application/json; charset=utf-8');
/* Inclui sessão */
require_once('../session.php');
require_once('../define_page.php');
require_once('../fphp/class_master/1.class_con_db.php');

/* Requisitando os dados */
if(isset($_POST['input_login'])){
	$user = $_POST['input_login'];
	$pass = $_POST['input_pass'];
}
else{
	$user = '';
	$pass = '';
}

/* Função para logar no sistema */
$sql_inst = new mysqli_instruction;
$mysqli = $sql_inst->con_mysqli();
$query = 'SELECT * FROM `7_sgc_user` WHERE user=? AND pass_user=?;';
$resp = $sql_inst->select_mysqli($query, 'ss', array($user, $pass));

/* return o login */
$sql_inst->end_con_sql();
sign_in($resp[0], $resp[0]['acess_user']);
if($resp != NULL && $resp != false) echo 'true';
else echo 'false';

?>
