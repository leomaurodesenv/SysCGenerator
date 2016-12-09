<?php

class FPHP_page_table extends FPHP_master{
	/* Variaveis do formulario */
	private $table_content;
	private $table_head;
	private $table_data;
	private $table_css;
	
	/* Construtor */
	public function __construct($def=null){
		$data = array(
			'class_div'=>'table-responsive',
			'class_table'=>'table table-bordered table-striped table-hover'
		);
		
		parent::define_data($this->table_content, $data, $def);
		$this->table_head = null;
		$this->table_data = array();
	}
	
	/* Funcao para teste (dump) */
	public function dump($a='content'){
		if($a == 'content') var_dump($this->table_content);
		else if($a == 'head') var_dump($this->table_head);
		else if($a == 'data') var_dump($this->table_data);
	}
	
	/* Define o header da tabela */
	public function define_table_head($def=null){
		if(parent::exist_var($def)) $this->table_head = $def;
		else $this->table_head = null;
	}
	
	/* Define todos os td's */
	public function define_table_data($def=null){
		unset($this->table_data);
		if(parent::exist_var($def)){
			foreach($def as $k1 => $v1){
				foreach($v1 as $k2 => $v2){
					$this->table_data[$k1][$k2] = (parent::exist_var($v2)) ? $v2 : 'Vazio';
				}
			}
		}
		else{
			$def_null = array(0=>array());
			foreach($this->table_head as $k1){
				array_push($def_null[0], 'Vazio');
			}
			$this->table_data = $def_null;
			//echo '$error[\'define_table_data\']';
		}
	}
	
	/* Adiciona linha a linha de td's */
	public function add_table_data($def=null){
		if(parent::exist_var($def)){
			$new_line = $def;
			array_push($this->table_data, $new_line);
		}
		else echo '$error[\'add_table_data\']';
	}

	/* Gera uma tabela rapidamente */
	public function generate_fast_table(){
		echo $this->get_fast_table();
	}
	
	/* Gera uma tabela rapidamente */
	public function get_fast_table(){
		$out = '<div class="'.$this->table_content['class_div'].'"><table class="'.$this->table_content['class_table'].'">';
		$out .= $this->generate_table_head();
		$out .= $this->generate_table_data();
		$out .= '</table></div>';
		return $out;
	}
	
	/* Gera uma tr para o create-grid */
	public function generate_fast_tr($id='grid_elements'){
		$out = '<table class="hidden" id="'.$id.'">';
		$out .= $this->generate_table_data();
		$out .= '</table>';
		echo $out;
	}
	
	/* Retorna apenas o head da tabela */
	private function generate_table_head(){
		if(parent::exist_var($this->table_head)){
			$out = '<thead><tr>';
			foreach($this->table_head as $key => $value){
				$out .= '<th>'.$value.'</th>';
			}
			$out .= '</tr></thead>';
			return $out;
		}
	}
	
	/* Retorna apenas o data da tabela */
	private function generate_table_data(){
		$out = '<tbody>';
		foreach($this->table_data as $k1 => $v1){
			$out .= '<tr>';
			foreach($v1 as $k2 => $v2){
				if(parent::exist_var($this->table_css[$k2])) $out .= '<td class="'.$this->table_css[$k2].'">'.$v2.'</td>';
				else $out .= '<td>'.$v2.'</td>';
			}
			$out .= '</tr>';
		}
		$out .= '</tbody>';
		return $out;
	}
	
	/* Adiciona uma classe apenas as colunas do $def */
	public function class_partial_td($def=null){
		$this->table_css = (parent::exist_var($def)) ? $def : array();
	}
	
};

/* Testando a classe FPHP_page_table 

$table = new FPHP_page_table();
$table->define_table_head(array('#','Header','Header','Header','Header'));

$data_table = array(
	array('1,001','Lorem','ipsum','dolor','sit'),
	array('1,002','amet','consectetur','adipiscing','elit'),
	array('1,003','Integer','nec','odio','Praesent'),
	array('1,004','dapibus','diam','Sed','nisi')
);
$table->define_table_data($data_table);

//$table->add_table_data(array('1,001','Lorem','ipsum','dolor','sit'));
//$table->add_table_data(array('1,002','amet','consectetur','adipiscing','elit'));
//$table->add_table_data(array('1,003','Integer','nec','odio','Praesent'));
//$table->add_table_data(array('1,003','libero','Sed','cursus','ante'));
//$table->add_table_data(array('1,004','dapibus','diam','Sed','nisi'));

$table->generate_fast_table();

*/
?>