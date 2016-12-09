<?php

class FPHP_page_report extends FPHP_master{
	/* Variaveis do formulario */
	private $reports;
	
	/* Construtor */
	public function __construct($def=null){
		$this->reports = array();
	}
	
	/* Funcao para adicionar reports */
	public function add_report($def=null){
		if(!parent::exist_var($def)){
			echo '$error[\'add_report\']';
			return;
		}
		elseif(parent::exist_var($def['id']) && parent::search_in_array($this->reports, 'id', $def['id'])){
			echo '$error[\'add_report.id_exists\']';
			return;
		}
		
		$data = array(
			'id'=>null, 
			'id_child'=>null, 
			'id_parent'=>null, 
			'sql'=>array('query'=>null, 'types'=>'', 'params'=>array()), 
			'head'=>array(), 
			'data'=>array(), 
			'date_change'=>false,
			'partition'=>false
		);
		parent::define_data($new_report, $data, $def);
		array_push($this->reports, $new_report);

	}
	
	/* Funcao para dumps de testes */
	public function dump($a='reports'){
		if($a=='reports') var_dump($this->reports);
	}
	
	/* Apresenta o relatorio e limpa */
	public function generate_report($unset=true){
		foreach($this->reports as $k1 => $v1){
			if(!parent::exist_var($v1['id_parent']))
				echo $this->construct_report($v1);
		}
		if($unset){
			unset($this->reports);
			$this->reports = array();
		}
	}
	
	/* Controi toda as estruturar do relatorio */
	private function construct_report($v1=null, $parent=null){
		
		if(!parent::exist_var($v1))
			return;
		
		if(parent::exist_var($parent)){
			if(parent::exist_var($v1['sql']['where']))
				$v1['sql']['where'][] = array('column'=>$v1['id_parent'], 'operator'=>'=', 'condition'=>'AND');
			else
				$v1['sql']['where'][] = array('column'=>$v1['id_parent'], 'operator'=>'=');

			$v1['sql']['types'] = (parent::exist_var($v1['sql']['types'])) ? $v1['sql']['types'].'s' : 's';
			$v1['sql']['params'][] = (string) $parent;
		}
		
		$inner = (parent::exist_var($v1['sql']['inner'])) ? $v1['sql']['inner'] : null;
		$where = (parent::exist_var($v1['sql']['where'])) ? $v1['sql']['where'] : null;
		$sql['query'] = parent::make_select($v1['sql']['select'], $v1['sql']['table'], $inner, $where);
		$sql['types'] = (parent::exist_var($v1['sql']['types'])) ? $v1['sql']['types'] : '';
		$sql['params'] = (parent::exist_var($v1['sql']['params'])) ? $v1['sql']['params'] : [];
		$sql['order_by'] = (parent::exist_var($v1['sql']['order_by'])) ? $v1['sql']['order_by'] : null;
		$sql['order_by_type'] = (parent::exist_var($v1['sql']['order_by_type'])) ? $v1['sql']['order_by_type'] : null;
		$sql['pagination'] = (parent::exist_var($v1['sql']['pagination'])) ? $v1['sql']['pagination'] : null;
		$sql['limit'] = (parent::exist_var($v1['sql']['limit'])) ? $v1['sql']['limit'] : null;
		
		$query_data = parent::execute_select_sql($sql);
		$query_cont = count($query_data);

		$arr_table = $this->construct_read_table($v1['data'], $query_data);
		$return = '';
		
		if(!parent::exist_var($v1['id_child'])){
			$return .= $this->construct_table($v1['head'], $arr_table);
		}
		else{
			foreach($arr_table as $k2 => $v2){
				$return .= $this->construct_table($v1['head'], array($v2));
				
				if(parent::exist_var($v1['id_child'])){
					foreach($this->reports as $k3 => $v3){
						if($v1['id_child'] == $v3['id']){
							$return .= $this->construct_report($v3, $query_data[$k2][$v1['id']]);
						}
					}
				}
				if($v1['partition']) $return .= '<br>';
				
			}
		}
		
		return $return;
	}
	
	/* Controi os elementos das tabelas */
	private function construct_read_table($elements=null, $query=null){
		if(!parent::exist_var($elements) || !parent::exist_var($query)){
			return array();
		}
		$retun = array();
		foreach($query as $k1 => $v1){
			$aux = array();
			foreach($elements as $k2 => $v2){
				if(isset($v1[$v2]))
					$aux[] = $v1[$v2];
				else{
					$aux[] = 'Vazio';
				}
			}
			$retun[] = $aux;
		}
		return $retun;
	}
	
	/* Generate Table */
	private function construct_table($head=null, $data=null){
		if(!parent::exist_var($head) || !parent::exist_var($data)){
			return '';
		}
		
		$table = new FPHP_page_table(array('class_div'=>'table-responsive no-margin', 'class_table'=>'table table-bordered table-striped table-report'));
		$table->define_table_head($head);
		$table->define_table_data($data);
		return $table->get_fast_table();
	}
	
};

/* Testando a classe FPHP_inputs */
/*
$report = new FPHP_page_report();

$p_sql['inner'] = array(array('type'=>'INNER JOIN', 'table'=>'orgao_apreensao o', 'on'=>'p.fk_id_orgao_ap = o.id_orgao_ap'));
$p_sql['where'] = array(
	array('column'=>'p.active_processo', 'operator'=>'='),
	array('column'=>'p.id_processo', 'operator'=>'<', 'condition'=>'AND')
);
$p_sql['select'] = 'p.*, o.*';
$p_sql['table'] = 'processo p';
$p_sql['types'] = 'ss'; $p_sql['params'] = array('1', '10');

$p_report = array(
	'id'=>'id_processo', 
	'id_child'=>'id_caixa', 
	'sql'=>$p_sql, 
	'head'=>array('Processo', 'Documento Origem', 'Orgao Apreensor', 'Data de Entrada'), 
	'data'=>array('desc_processo', 'doc_origem_processo', 'nome_orgao_ap', 'sys_data'), 
	'date_change'=>array('sys_data')
);

$c_sql['inner'] = array(array('type'=>'INNER JOIN', 'table'=>'estoque_setor st', 'on'=>'c.fk_id_estoque_set = st.id_estoque_set'));
$c_sql['select'] = 'c.*, st.desc_estoque_set';
$c_sql['table'] = 'processo_caixa c';

$c_report = array(
	'id'=>'id_caixa', 
	'id_parent'=>'c.fk_id_processo', 
	'sql'=>$c_sql, 
	'head'=>array('Numero', 'Setor'), 
	'data'=>array('sequencia_caixa', 'desc_estoque_set'), 
	'date_change'=>array('sys_data')
);

$report->add_report($p_report);
$report->add_report($c_report);

$report->generate_report();


//*/

?>