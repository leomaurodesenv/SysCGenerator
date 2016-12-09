<?php

/* 
 * Parent Class: Pai de todas as classes
 * Responsavel pelas funcoes genericas
 */

class FPHP_master extends MYSQLI_instruction{
	
	/* Funcao para incluir os dados em uma array */
	public function define_data(&$array, $data, $def=null){
		if($this->exist_var($def)){
			foreach($data as $key => $value){
				if(isset($def[$key])) $array[$key] = $def[$key];
				else $array[$key] = $value;
			}
		}
		else{
			foreach($data as $key => $value){
				$array[$key] = $value;
			}
		}
	}
	
	public function exist_var(&$var){
		if(isset($var) && !is_null($var) && ($var || is_numeric($var))) return true;
		else return false;
	}
	
	protected function generate_get($def){
		$return = null;
		if($this->exist_var($_GET)){
			$return = '?';
			foreach($_GET as $k1 => $v1){
				if(!in_array($k1, $def))
					$return .= $k1.'='.$v1.'&';
			}
			$return = substr($return, 0, -1);
		}
		return $return;
	}
	
	public function clean_link_page(){
		$return = 'http://'.($_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
		return $return;
	}
	
	/* Cria o attr data dos :inputs */
	protected function make_data_values($val=null){
		$data = '';
		if($this->exist_var($val) && count($val) > 0){
			foreach($val as $k1 => $v1){
				$data .= 'data-'.$k1.'='.$v1.' ';
			}
		}
		return $data;
	}
	
	/* Pesquisa linhas de array a partir de uma chave e seu valor */
	public function search_in_array($array, $key, $value){
		$results = array();
		if(is_array($array)){
			if(isset($array[$key]) && $array[$key] == $value){
				$results[] = $array;
			}
			foreach($array as $subarray){
				$results = array_merge($results, $this->search_in_array($subarray, $key, $value));
			}
		}
		return $results;
	}
	
	/* -------------------------------------------------------------------------------------- */
	/* Funcao que monta as querys */
	/* -------------------------------------------------------------------------------------- */
	public function make_select($select=null, $from=null, $inner=null, $where=null, $first_where=true){
		$query = false;
		if($this->exist_var($select) && $this->exist_var($from)){
			$query = 'SELECT '.$select.' FROM '.$from;
			if($this->exist_var($inner) && is_array($inner)){
				foreach($inner as $k1 => $v1){
					$query .= ' '.$v1['type'].' '.$v1['table'].' ON '.$v1['on'];
				}
			}
			$query .= $this->construct_where($where, $first_where);
		}
		return $query;
	}
	
	public function construct_where($where=null, $first=true){
		$return = '';
		if($this->exist_var($where) && is_array($where)){
			if($first) $return .= ' WHERE';
			foreach($where as $k1 => $v1){
				$addicional = ($this->exist_var($v1['addicional'])) ? $v1['addicional'] : '?';
				if($k1 == 0 && $first) $return .= ' ';
				else $return .= ' '.$v1['condition'].' ';
				$return .= $v1['column'].' ';
				$return .= $v1['operator'].' '.$addicional;
			}
		}
		return $return;
	}
	
	public function construct_select_order($order_by=null, $order_type='ASC'){
		$return = '';
		if($this->exist_var($order_by) && $this->exist_var($order_type)){
			$return = ' ORDER BY '.$order_by.' '.$order_type;
		}
		return $return;
	}
	
	public function construct_select_limit($pagination=null, $limit=null){
		$return = '';
		if($this->exist_var($pagination)&& $this->exist_var($limit)){
			$return = ' LIMIT '.($limit*($pagination-1)).', '.$limit;
		}
		return $return;
	}

	public function construct_query_first_part($data=null, $complement=null, $together=false){
		$return = '';
		if($this->exist_var($data) && is_array($data)){
			foreach($data as $k1 => $v1){
				if($this->exist_var($complement)){
					if($together) $return .= $v1.' = '.$complement.', ';
					else $return .= $complement.', ';
				}
				else $return .= $v1.', ';
			}
			$return = rtrim($return, ', ');
		}
		return $return;
	}
	
	public function make_insert($table=null, $columns=null){
		$query = false;
		if($this->exist_var($table) && $this->exist_var($columns) && is_array($columns)){
			$query = 'INSERT INTO '.$table.' (';
			$query_columns = $this->construct_query_first_part($columns);
			$params_query = $this->construct_query_first_part($columns, '?');
			$query .= $query_columns;
			$query .= ') VALUES ('.$params_query.')';
		}
		return $query;
	}
	
	public function make_update($table=null, $columns=null, $where=null){
		$query = false;
		if($this->exist_var($table) && $this->exist_var($columns) && is_array($columns)){
			$query = 'UPDATE '.$table.' SET ';
			$query_columns = $this->construct_query_first_part($columns, '?', true);
			
			$query .= $query_columns;
			$query .= $this->construct_where($where, true);
		}
		return $query;
	}
	
	public function make_delete($table=null, $where=null){
		$query = false;
		if($this->exist_var($table)){
			$query = 'DELETE FROM '.$table;
			$query .= $this->construct_where($where, true);
		}
		return $query;
	}
	
	/* -------------------------------------------------------------------------------------- */
	/* /fim - Funcao que monta as querys */
	/* -------------------------------------------------------------------------------------- */
	
	/* Funcao para encerrar a conexao */
	public function drop_con_mysql(){
		parent::end_con_sql();
	}
	/* Funcao para executar querys de select */
	public function execute_select_sql($query=null){
		$resp = false;
		if($this->exist_var($query)){
			parent::con_mysqli();
			if(is_array($query)){
				if(isset($query['order_by'])) 
					$query['query'] .= $this->construct_select_order($query['order_by'], $query['order_by_type']);
				if(isset($query['pagination'])) 
					$query['query'] .= $this->construct_select_limit($query['pagination'], $query['limit']);
				
				$resp = parent::select_mysqli($query['query'], $query['types'], $query['params']);
			}
			else
				$resp = parent::select_mysqli($query);
			parent::end_con_sql();
			
		}
		return $resp;
	}

	/* Funcao para executar querys de insert, update, delete */
	public function execute_generic_sql($query=null){
		$resp = false;
		if($this->exist_var($query)){
			parent::con_mysqli();
			$this->change_var_global($query['params']);
			$resp = parent::generic_sql_mysqli($query['query'], $query['types'], $query['params']);
			$resp = $this->affected_rows_sql();
			parent::end_con_sql();
		}
		return $resp;
	}
	
	/* Verifica se houve mudanca via querys (ultima operacao) */
	public function affected_rows_sql(){
		return parent::affected_rows();
	}
	
	/* Percorre params e substitui as variáveis globais */
	final public function change_var_global(&$params){
		$glob_var = [
			'@cur_date_time'=>date('Y-m-d H:i:s'),
			'@cur_date'=>date('Y-m-d'),
			'@cur_time'=>date('H:i:s'),
			'@user_ip'=>$_SERVER['REMOTE_ADDR']
		];
		foreach($params as $k1 => $v1){
			if($this->exist_var($glob_var[$v1])) $params[$k1] = $glob_var[$v1];
		}
	}
	
	/* Converte texto com acento/caracteres especiais */
	public function convert_text($text){
		$r = htmlentities($text, ENT_COMPAT, 'ISO-8859-1');
		return $r;
	}
	
	/* Função responsável por validar o conteúdo da página, se não mensagem de erro */
	public function valid_content_page($cont=true, $true='', $false=''){
		if((bool) $cont) echo $true;
		else echo $false;
	}
	
	/* Funcao para verificar o tamanho em relacao ao $less e $bigger */
	public function between_int($val, $less, $bigger){
		$return = (($less <= $val) && ($val < $bigger)) ? $val: (abs($val)%$bigger);
		return $return;
	}
	
	/* Retorna o IP do Usuario */
	public function get_client_ip() {
		$current_ip = '';
		if($this->exist_var($_SERVER['HTTP_CLIENT_IP']))
			$current_ip = $_SERVER['HTTP_CLIENT_IP'];
		else if($this->exist_var($_SERVER['HTTP_X_FORWARDED_FOR']))
			$current_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if($this->exist_var($_SERVER['HTTP_X_FORWARDED']))
			$current_ip = $_SERVER['HTTP_X_FORWARDED'];
		else if($this->exist_var($_SERVER['HTTP_FORWARDED_FOR']))
			$current_ip = $_SERVER['HTTP_FORWARDED_FOR'];
		else if($this->exist_var($_SERVER['HTTP_FORWARDED']))
			$current_ip = $_SERVER['HTTP_FORWARDED'];
		else if($this->exist_var($_SERVER['REMOTE_ADDR']))
			$current_ip = $_SERVER['REMOTE_ADDR'];
		else $current_ip = 'Desconhecido';
		return $current_ip;
	}
	
	/* -------------------------------------------------------------------------------------- */
	/* Funcoes para o log */
	/* -------------------------------------------------------------------------------------- */
	
	public function register_log_event($table=false, $id=false, $type=false, $desc=''){
	
		$login = FPHP_smart_session::session()->get('login', false);
		if($this->exist_var($table) && $this->exist_var($id) && $this->exist_var($type) && $this->exist_var($login)){
			/* Buscando o nome pelo codigo (in fphp_tables) */
			$search['query'] = $this->make_select('id_table as fk_id_table', 'fphp_tables', false, array(array('column'=>'name_table', 'operator'=>'=')));
			$search['types'] = 's'; $search['params'][] = $table;
			$get = $this->execute_select_sql($search);
			/* Criando o insert do log */
			$log_columns = array('fk_id_table', 'fk_id_item_log', 'data_log', 'ip_log', 'fk_id_user_log', 'type_log', 'desc_log');
			$log['params'] = array($get[0]['fk_id_table'], $id, '@cur_date_time', $this->get_client_ip(), $login['id'], '['.$login['group_name'].'] '.$type, $desc);
			$log['types'] = str_repeat('s', count($log_columns));
			$log['query'] = $this->make_insert('fphp_log', $log_columns);
			
			return $this->execute_generic_sql($log);
		}
		else return false;
	}

	public function get_table_name_by_query($query){
		/* Identificar SELECT */
		$pattern[0] = '/(SELECT)[\s]*.*[\s]*(FROM)[\s]*/i';
		/* Identificar INSERT */
		$pattern[1] = '/((INSERT)([\s]*(LOW_PRIORITY|DELAYED|HIGH_PRIORITY))?([\s]*(IGNORE))?([\s]*INTO)?)[\s]*/i';
		/* Identificar DELETE */
		$pattern[2] = '/(DELETE)[\s]*.*[\s]*(FROM)[\s]*/i';
		/* Identificar UPDATE */
		$pattern[3] = '/((UPDATE)([\s]*(LOW_PRIORITY))?([\s]*(IGNORE))?)[\s]*/i';
		if($valid = parent::valid_type_query($query)){
			$splited = preg_split($pattern[$valid['i']], $query, 2);
			$splited = preg_split('/[\s]/', $splited[1]);
			$splited = preg_split('/,/', $splited[0]);
			$clean = trim($splited[0], ".,;/\"\'\\!@#$%&*()?");
			$table = $clean;
			
			/*print $valid['type'].': '.$table.PHP_EOL;*/
			return array('type'=>$valid['type'], 'table'=>$table);
		}
		print 'Error Query to Log:'.PHP_EOL.$query.PHP_EOL;
		return false;
	}
	
}; /* /fim - classe*/

?>