<?php

require_once('../class_loader.php');

$master = new FPHP_master();
$table = $_POST['table'];
$data = $_POST['json_create'];
if($master->exist_var($table) && $master->exist_var($data)){
	$types = '';
	$desc_log = '';
	foreach($data as $k1 => $v1){
		$params[] = $v1['value'];
		$types .= 's';
		$columns[] = $v1['field'];
		$desc_log .= $v1['field'].'=('.$v1['value'].'), ';
	}
	$query['query'] = $master->make_insert($table, $columns); 
	$query['types'] = $types;
	$query['params'] = $params;
	$resp = $master->execute_generic_sql($query);
	
	if($resp > 0) echo 'true';
	else echo 'Query: '.$master->last_error();
}
else echo 'error[\'create_fuction\']';

?>