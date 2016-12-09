<?php

require_once('../class_loader.php');

$master = new FPHP_master();
$id_column = $_POST['id_column'];
$table = $_POST['table'];
$data = $_POST['json_update'];
if($master->exist_var($data)){
	$types = '';
	$desc_log = '';
	foreach($data as $k1 => $v1){
		$columns[] = $v1['field'];
		$params[] = $v1['value'];
		$types .= 's';
		$desc_log .= $v1['field'].'=('.$v1['value'].'), ';
	}
	$where = array(array('column'=>$id_column,'operator'=>'='));
	$sql_update = $master->make_update($table, $columns, $where);
	$params[] = $_POST['id'];
	$types .= 's';
	$query['query'] = $sql_update;
	$query['types'] = $types;
	$query['params'] = $params;
	
	$resp = $master->execute_generic_sql($query);

	if($resp >= 0) echo 'true';
	else echo 'Query: '.$master->last_error();
}
else echo 'error[\'update_fuction\']';

?>