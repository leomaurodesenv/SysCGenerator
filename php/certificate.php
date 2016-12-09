<?php
/* Inclui sessão */
require_once('./define_page.php');
require_once('./fphp/class_master/1.class_con_db.php');
require_once('./fphp/class_master/4.class_coded.php');
require_once("./mpdf60/mpdf.php");

/* Verificando o aluno */
if(isset($_GET['id'])) $id = $_GET['id'];
else header('Location: ../index.php');
	
/* Função para logar no sistema */
$sql_inst = new mysqli_instruction;
$mysqli = $sql_inst->con_mysqli();
$query = '
SELECT p.id_partp as \'id\', p.name_partp as \'student\', p.standard_partp as \'participation\', p.extra_partp as \'extra\', e.owner_certificate as \'owner-certificate\', e.event_certificate as \'event-certificate\', e.place_certificate as \'place\', e.date_certificate as \'date\', e.workload_certificate as \'workload\', e.layout_certificate as \'layout\', e.id as \'event_id\'
FROM 7_sgc_participants as p 
INNER JOIN 7_sgc_event as e
ON p.id_event = e.id
WHERE p.id_partp = ? AND p.active = 1 AND e.active=1;';
$resp = $sql_inst->select_mysqli($query, 's', array($id));
/* Verifica se exite o participante */
if($resp[0] == null || $resp[0] == false) header('Location: ../index.php');
$data_bd = $resp[0];

/* Encerra sql */
$sql_inst->end_con_sql();

/* Carregando o layout */
$path_layout = './layouts/'.$data_bd['layout'].'/';
$file_xml = simplexml_load_file($path_layout.'construct.xml');

$mpdf = new mPDF($file_xml->encode, array(297,210), 0, '', 0, 0, 0, 0, 0, 0);
$mpdf->SetDisplayMode('fullpage');

/* Carregando conteudo */
$stylesheet = file_get_contents($path_layout.$file_xml->stylecss);
$html = file_get_contents($path_layout.$file_xml->text);

/* Gerando código de autenticação */
$coded = new FPHP_coded();
$code_id = $coded->intcod($data_bd['id'], 7);
$code_event_id = $coded->intcod($data_bd['event_id'], 5);
$code_verify = $code_id.$code_event_id;

/* Substituindo o conteudo */
$in_replace = array('@owner-certificate','@student','@event-certificate','@participation', '@extra', '@workload','@place','@date','@code','@verify');
if(!is_null($data_bd['extra']) && $data_bd['extra'] != false && $data_bd['extra'] != '') $extra = $data_bd['extra'].'. ';
else $extra = '';
$code = str_pad($data_bd['id'], 10, "0", STR_PAD_LEFT);
$workload = (!isset($data_bd['workload']) && is_null($data_bd['workload'])) ? '' : ' com carga horária de <b>'.$data_bd['workload'].' horas</b>';
$out_replace = array($data_bd['owner-certificate'],$data_bd['student'],$data_bd['event-certificate'],$data_bd['participation'],$extra,$workload,$data_bd['place'],$data_bd['date'],$code,$code_verify);
$html_show = str_replace($in_replace, $out_replace, $html);

/* Finalizando o PDF */
//$mpdf->SetWatermarkImage($path_layout.$file_xml->watermark->image, $file_xml->watermark->opacity, array($file_xml->watermark->width, $file_xml->watermark->height));
//$mpdf->showWatermarkImage = false;

$mpdf->WriteHTML($stylesheet, 1);
$mpdf->WriteHTML($html_show);

$output_name = ucwords(strtolower($data_bd['student'])).'.pdf';
$mpdf->Output($output_name,'I');

exit;

?>
