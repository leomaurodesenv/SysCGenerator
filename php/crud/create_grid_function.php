<?php

require_once('../class_loader.php');

$master = new FPHP_master();
$table = $_POST['table'];
$data = $_POST['json_create_grid'];
if($master->exist_var($table) && $master->exist_var($data)){
	foreach($data as $k1 => $v1){
		$types = '';
		$desc_log = '';
		unset($params, $columns, $query);
		foreach($v1 as $k2 => $v2){
			$params[] = $v2['value'];
			$types .= 's';
			$columns[] = $v2['field'];
			$desc_log .= $v2['field'].'=('.$v2['value'].'), ';
		}
		$query['query'] = $master->make_insert($table, $columns); 
		$query['types'] = $types; 
		$query['params'] = $params;
		$resp = $master->execute_generic_sql($query);
		
		if($resp == 0){
			echo 'Query: '.$master->last_error();
			exit(0);
		}
	}
	echo 'true';
}
else echo 'error[\'create_fuction\']';

?>