<?php

class FPHP_page_btn_group extends FPHP_master{
	/* Variaveis do formulario */
	private $data_href;
	private $style;
	private $group;
	private $id;
	
	/* Construtor */
	public function __construct($data=null, $id=null, $styles=array()){
		$sty_minidata = array(
			'class'=>null,
			'style'=>''
		);
		$this->style = array();
		foreach($styles as $k1 => $v1){
			parent::define_data($this->style[$k1], $sty_minidata, $v1);
		}
		if(parent::exist_var($data)) $this->data_href = $data;
		else $this->data_href = array();
		$this->id = $id;
		$this->group = array();
	}
	
	/* Funcao para teste (dump) */
	public function dump($a='group'){
		if($a == 'data') var_dump($this->data_href);
		elseif($a == 'group') var_dump($this->group);
	}
	
	/* Funcao para gerar os grupos de botoes do create-grid */
	public function group_create_grid(){
		$data = array(array('text'=>'Novo', 'href'=>'#new_grid', 'id'=>'new_grid'));
		$this->add_group($data);
		$this->generate_fast_group();
		$data = array(
			array('text'=>'Adicionar', 'type'=>'primary', 'btn'=>true), 
			array('text'=>'Cancelar', 'href'=>'./list.php')
		);
		$this->add_group($data);
		$this->generate_fast_group();
	}
	
	/* Adiciona um grupo de botoes */
	public function add_group($add=null, $def='', $compare=array()){
		if($def == 'read'){
			$data = array();
			if(parent::exist_var($compare['create']) && $compare['create']) 
				$data[] = array('text'=>'Adicionar', 'href'=>'./create.php', 'data_href'=>null, 'type'=>'default', 'id'=>null, 'data'=>null, 'btn'=>false);
			if(parent::exist_var($compare['update']) && $compare['update']) 
				$data[] = array('text'=>'Editar', 'href'=>'./update.php', 'data_href'=>array('id'), 'type'=>'default', 'id'=>null, 'data'=>null, 'btn'=>false);
			if(parent::exist_var($compare['delete']) && $compare['delete']) 
				$data[] = array('text'=>'Excluir', 'href'=>'./delete.php', 'data_href'=>array('id'), 'type'=>'default', 'id'=>null, 'data'=>null, 'btn'=>false);
			
			array_push($this->group, $data);
		}
		elseif($def == 'search'){
			$data = array(
				array('text'=>'Pesquisar', 'type'=>'primary', 'btn'=>true), 
				array('text'=>'Limpar Pesquisa', 'href'=>parent::clean_link_page(), 'data_href'=>null, 'type'=>'default', 'id'=>null, 'data'=>null, 'btn'=>false)
			);
			array_push($this->group, $data);
		}
		elseif($def == 'edit'){
			$data = array(
				array('text'=>'Confirmar Edicao', 'type'=>'primary', 'btn'=>true), 
				array('text'=>'Cancelar', 'href'=>'./list.php', 'data_href'=>null, 'type'=>'default', 'id'=>null, 'data'=>null, 'btn'=>false)
			);
			array_push($this->group, $data);
		}
		elseif(parent::exist_var($add)){
			$new = array();
			$mini_data = array('text'=>'text', 'href'=>null, 'data_href'=>null, 'type'=>'default', 'id'=>null, 'data'=>null, 'btn'=>false);
			foreach($add as $k1 => $v1){
				parent::define_data($new[$k1], $mini_data, $add[$k1]);
			}
			array_push($this->group, $new);
		}
		else echo '$error[\'add_group\']';
	}
	
	public function get_fast_group($count=0){
		$out = '';
		foreach($this->group as $k1 => $v1) $out.= $this->create_group($v1, $k1);
		$out.= $this->breakline_group($count);
		
		$this->group = array();
		return $out;
	}
	
	/* Funcao gera todos os grupos */
	public function generate_fast_group($count=0){
		echo $this->get_fast_group($count);
	}
	
	/* Funcao gera cada grupo de botoes */
	private function create_group($group, $j){
		if(parent::exist_var($this->id)) $id_group = $this->id.'_'.$j;
		else $id_group = '';

		$class_group = ''; $style_group = '';
		if(parent::exist_var($this->style[$j])){
			if(parent::exist_var($this->style[$j]['class'])) $class_group = ' '.$this->style[$j]['class'];
			$style_group = $this->style[$j]['style'];
		}
		$out = '<div class="btn-group '.$class_group.'" id="'.$id_group.'" style="'.$style_group.'" >';
		
		foreach($group as $k1 => $v1){
			if($v1['btn']) $out .= $this->create_normal_btn($v1);
			else $out .= $this->create_link_btn($v1);
		}
		$out .= '</div>';
		return $out;
	}
	
	/* Funcao de criar o link */
	private function create_link_btn($data){
		$id_link = '';
		if(parent::exist_var($data['id'])) $id_link = 'id="'.$data['id'].'"';
		$data_link = $this->create_data_link($data['data_href']);
		$data_add = parent::make_data_values($data['data']);
		$return = '<a href="'.$data['href'].$data_link.'" '.$id_link.' class="btn btn-'.$data['type'].'" '.$data_add.' >'.$data['text'].'</a>';
		return $return;
	}
	
	/* Funcao de criar o link */
	private function create_normal_btn($data){
		return '<input type="submit" class="btn btn-'.$data['type'].'" value="'.$data['text'].'" />';
	}
	
	/* Funcao inseri o data de cada link */
	private function create_data_link($data_href){
		if(parent::exist_var($data_href)){
			$out = '?';
			foreach($data_href as $k1 => $v1){
				if(array_key_exists($v1, $this->data_href))
					$out .= $v1.'='.$this->data_href[$v1].'&';
			}
			$out = rtrim($out, '&');
			return $out;
		}
		return '';
	}
	
	/* Inseri break lines ao final dos grupos */
	public function breakline_group($count){
		$return = '';
		for($i=0; $i<$count; $i++){
			$return .=  '<br/>';
		}
		return $return;
	}
	
};

/* Testando a classe FPHP_page_btn_group 

$btn_g = new FPHP_page_btn_group(array('id'=>'1'));
$btn_g->add_group(array(array('text'=>'Relatorio Processo', 'href'=>'#', 'data_href'=>array('id'), 'class'=>'primary')));
$btn_g->add_group(false, 'read');
//$btn_g->dump();
$btn_g->generate_fast_group();
$btn_g->breakline_group(2);

//*/

?>