<?php

class FPHP_page_breadcrumb extends FPHP_master{
	/* Variaveis do formulario */
	private $bc_data;
	private $bc_active;
	
	/* Construtor */
	public function __construct(){
		$this->bc_data = array();
		$this->bc_active = null;
	}
	
	/* Funcao para teste (dump) */
	public function dump(){
		var_dump($this->bc_data);
		echo '<br/>';
		var_dump($this->bc_active);
		echo '<br/>';
	}
	
	/* Define active do breadcrumb */
	public function define_bc_active($def=null){
		$act = (int)$def;
		if(is_numeric($def)) $this->bc_active = $act;
		else echo '$error[\'define_bc_active\']';
	}
	
	/* Define todos os li's */
	public function define_bc_data($def=null){
		if(parent::exist_var($def)){
			unset($this->bc_data);
			$this->bc_data = $def;
		}
		else echo '$error[\'define_bc_data\']';
	}
	
	/* Adiciona linha as linhas do breadcrumb */
	public function add_bc_data($def=null){
		$data = array('href'=>null, 'text'=>'None');
		parent::define_data($new_bc, $data, $def);
		$new_bc['text'] = parent::convert_text($new_bc['text']);
		array_push($this->bc_data, $new_bc);
	}

	/* Imprime todo breadcrumb */
	public function generate_fast_bc($act=false){
		$out = '<ul class="breadcrumb">';
		$out .= $this->generate_li_bc($act);
		$out .= '</ul>';
		echo $out;
	}
	
	/* Gera os elementos do breadcrumb */
	private function generate_li_bc($def){
		$out = '';
		if($def || !is_numeric($this->bc_active)) $act = count($this->bc_data)-1;
		else $act = $this->bc_active;
		foreach($this->bc_data as $k1 => $v1){
			if($act == $k1) $out .= '<li class="active">';
			else $out .= '<li>';
			if(parent::exist_var($v1['href'])) $out .= '<a href="'.$v1['href'].'">'.$v1['text'].'</a>';
			else $out .= $v1['text'];
			$out .= '</li>';
		}
		return $out;
	}
};

/* Testando a classe  

$bc = new FPHP_page_breadcrumb();
$bc->define_bc_active(0);
//$bc->add_bc_data(array('href'=>'#', 'text'=> 'Home'));
//$bc->add_bc_data(array('href'=>'#', 'text'=> 'Estoque'));
//$bc->add_bc_data(array('href'=>'#', 'text'=> 'Caixa'));
$bc_data = array(
	array('href'=>'#', 'text'=> 'Home'),
	array('href'=>'#', 'text'=> 'Estoque'),
	array('href'=>'#', 'text'=> 'Caixa')
);
$bc->define_bc_data($bc_data);

$bc->generate_fast_bc();
*/

?>