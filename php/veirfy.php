<?php
/* Definindo charset - necessário a partir do php 5.3 */
//header('Content-type: application/json; charset=utf-8');
header('Content-Type: text/html; charset=utf-8');

/* Inclui sessão */
require_once('./session.php');
require_once('./define_page.php');
require_once('./fphp/class_master/1.class_con_db.php');
require_once('./fphp/class_master/4.class_coded.php');

/* Requisitando os dados */
if(isset($_POST['input_code'])){
	$code = $_POST['input_code'];
	$verify = strtoupper($_POST['input_verify']);
}
else{echo 'false'; exit(0);}

/* Recuperando o código de autenticação */
$coded = new FPHP_coded();
$cid = substr($verify, 0, 7);
$cid_event = substr($verify, 7, 5);
$code_id = $coded->codint($cid);
$code_event_id = $coded->codint($cid_event);

/* Função para autenticar certificado */
$sql_inst = new mysqli_instruction;
$mysqli = $sql_inst->con_mysqli();
$query = '
SELECT p.id_partp, p.name_partp, p.standard_partp, e.programming_certificate, e.event_certificate , e.date_certificate, e.workload_certificate 
FROM 7_sgc_participants as p 
INNER JOIN 7_sgc_event as e
ON p.id_event = e.id
WHERE p.id_partp = ? AND p.active = 1 AND e.active = 1 AND e.id = ?
LIMIT 1;';
$resp = $sql_inst->select_mysqli($query, 'ii', array($code, $code_event_id));
$sql_inst->end_con_sql();

if($code_id == $code && !is_null($resp[0]) && $resp[0] != false){
	$data_valid = $resp[0];
	$name = ucwords(strtolower($data_valid['name_partp']));
	echo '
	<p class="false-title">Certificado Autentico</p>
	<p>Evento: '.$data_valid['event_certificate'].'</p>
	<p>Data: '.$data_valid['date_certificate'].'.</p>
	<p>Participante: '.$name.'</p>
	<p>Qualidade: '.$data_valid['standard_partp'].'</p>
	<p>Certificado: <a href="./php/certificate.php?id='.$code.'" target="_blank">Link</a></p>
	<p>Carga Hor&aacute;ria: '.$data_valid['workload_certificate'].'h</p>
	<p>Programa&ccedil;&atilde;o:</p>
	'.nl2br($data_valid['programming_certificate']);
}
else echo 'false';

/* return o login 
sign_in($resp[0], $resp[0]['acess']);
if($resp != NULL && $resp != false) echo 'true';
else echo 'false';
*/
?>
