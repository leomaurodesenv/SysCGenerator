<?php

require_once('../class_loader.php');

$master = new FPHP_master();
$data = $_POST['delete_data'];
/*var_dump($data);*/

if($master->exist_var($data)){
	$type = ''; $params = array();
	$where = array(array('column'=>$data['id_column'],'operator'=>'='));
	if($data['in_table'] == '0'){
		$sql_delete = $master->make_delete($data['table'], $where);
		$type_log = 'DELETE'; $desc_log = 'Permanent: ';
		
		$last_select['types'] = 's'; $last_select['params'] = array($data['id']);
		$last_select['query'] = $master->make_select('*', $data['table'], false, $where);
		$last = $master->execute_select_sql($last_select);
		foreach($last[0] as $k1 => $v1){$desc_log .= $k1.'=('.$v1.'), ';}
		$desc_log = rtrim($desc_log, ', ');
	}
	else{
		$sql_delete = $master->make_update($data['table'], array($data['in_table_column']), $where);
		$type .= 's'; $params[] = '0';
		$type_log = 'DELETE-UPDATE'; $desc_log = $data['in_table_column'].'=(0)';
	}
	$type .= 's'; $params[] = $data['id'];
	$query['query'] = $sql_delete;
	$query['types'] = $type;
	$query['params'] = $params;
	
	$resp = $master->execute_generic_sql($query);
	if($resp > 0) echo 'true';
	else echo 'Query: '.$master->last_error();
}
else echo 'error[\'delete_fuction\']';

?>