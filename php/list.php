<?php
/* Definindo charset - necessário a partir do php 5.3 */
//header('Content-type: application/json; charset=utf-8');
header('Content-Type: text/html; charset=utf-8');
ini_set('default_charset','UTF-8');

/* Inclui sessão */
require_once('./session.php');
require_once('./define_page.php');
require_once('./fphp/class_master/1.class_con_db.php');

/* Requisitando os dados */
if(isset($_POST['id'])) $id = $_POST['id'];
else $id = '';

/* Função para baixar nomes */
$sql_inst = new mysqli_instruction;
$mysqli = $sql_inst->con_mysqli();
$query = '
SELECT p.id_partp, p.name_partp
FROM 7_sgc_participants as p 
INNER JOIN 7_sgc_event as e
ON p.id_event = e.id
WHERE e.id = ? AND p.active = 1 AND e.active = 1;';

$resp = $sql_inst->select_mysqli($query, 's', array($id));
$sql_inst->end_con_sql();

echo '<p class="false-title">Lista de Participantes</p><ul class="list-group">';
if($resp){
	foreach($resp as $k1 => $v1){
		$name = ucwords(strtolower($v1['name_partp']));
		echo '<li class="list-group-item"><a href="./php/certificate.php?id='.$v1['id_partp'].'" target="_blank">'.$name.'</a></li>';
	}
}
else echo '<li class="list-group-item">Nenhum certificado cadastrado.</li>';
echo '</ul>';

?>
