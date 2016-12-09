<?php

class FPHP_page_forms extends FPHP_master{
	/* Variaveis do formulario */
	private $form;
	private $inputs;
	private $style;
	
	/* Construtor */
	public function __construct($def=null){
		$data = array(
			'action'=>'',
			'method'=>'get', 
			'name'=>'fphp_form_name', 
			'id'=>'fphp_form_id', 
			'button'=>'Enviar', 
			'autocomplete'=>'on', 
			'title'=>null,
			'data'=>null
		);
		
		parent::define_data($this->form, $data, $def);
		$this->inputs = array();
		$this->define_style();
	}
	
	/* Funcao para teste (dump) */
	public function dump($a='form'){
		if($a == 'form') var_dump($this->form);
		elseif($a == 'inputs') var_dump($this->inputs);
		elseif($a == 'style') var_dump($this->style);
	}
	
	/* Define o style do formulario */
	public function define_style($def=null){
		$data = array(
			'input'=>'form-control fphp_input_class',
			'select'=>'form-control fphp_input_class',
			'input_label'=>'fphp_input_label_class', 
			'form'=>'fphp_form_class', 
			'form_title'=>'page-header fphp_form_heading', 
			'form_button'=>'btn btn-primary fphp_form_button'
		);
		
		parent::define_data($this->style, $data, $def);
	}
	
	/*min, max*/
	/*type: button, checkbox, color, date, datetime, datetime-local, email, file, hidden, image, month, number, password, radio, range, reset, search, submit, tel, text, time, url, week*/
	public function add_input($def=null){
		$data = array(
			'type'=>null, 
			'data_diff'=>null, 
			'data_diff_info'=>null, 
			'id'=>null, 
			'name'=>null, 
			'value'=>null, 
			'add_class'=>null, 
			'label'=>null, 
			'label_2'=>'', 
			'disabled'=>'', 
			'placeholder'=>null, 
			'maxlength'=>255, 
			'data'=>null, 
			'break'=>true
		);
		
		parent::define_data($new_input, $data, $def);
		if($new_input['type'] != null && $new_input['id'] != null){
			array_push($this->inputs, $new_input);
		}
		else echo '$error[\'add_input\']';
	}
	
	/* Funcao para imprimir um formulario rapido */
	public function generate_fast_form($stoping=true){
		echo $this->get_fast_form($stoping);
	}
	
	/* Funcao para gerar um formulario rapido */
	public function get_fast_form($stoping=true, $btn_form=null){
		if(count($this->inputs) != 0 || !$stoping){
			$out = $this->open_form_table();
			if(parent::exist_var($this->form['title'])) $out .= '<h3 class="'.$this->style['form_title'].'">'.$this->form['title'].'</h3>';
			$out .= $this->generate_inputs(true);
			if(parent::exist_var($btn_form)) $out .= $btn_form;
			else $out .= $this->get_button_table();
			
			$out .= $this->close_form_table();
			return $out;
		}
		else echo '$error[\'generate_fast_form\']';
	}
	
	/* Funcao para gerar os inputs com label&break */
	private function generate_inputs($label=false){
		$out = '';
		foreach($this->inputs as $key => $val){
			if(($label == true || $label != null) && $val['label'] != null){
				$out .= '<label for="'.$val['name'].'" class="'.$this->style['input_label'].'">'.$val['label'].'</label>';
			}
			$out .= $this->generate_input($val);
			if($val['break'] == true) $out .= '<br/>';
		}
		return $out;
	}
	
	/* Funcao para gerar apenas os inputs rapido */
	private function generate_input($val=null){
		$out = '';
		if(parent::exist_var($val)){
			$data = parent::make_data_values($val['data']);
			if($val['type'] == 'select'){
				$selected_code = $val['value'];
				$out = '<select id="'.$val['id'].'" name="'.$val['name'].'" class="'.$this->style['select'].' '.$val['add_class'].'" '.$data.' '.$val['disabled'].'>';
				$resp = $this->make_select_diff($val['data_diff']);

				foreach ($resp as $k1 => $v1){
					$value_selec = $v1[$val['data_diff_info'][0]];
					if($selected_code == $value_selec) $selected = 'selected="selected"';
					else $selected = '';
					$out .= '<option value="'.$value_selec.'" '.$selected.'>'.$v1[$val['data_diff_info'][1]].'</option>';
				}
				$out .= '</select>';
			}
			elseif($val['type'] == 'radio'){
				$resp = $this->make_select_diff($val['data_diff']);
				$v_1 = current($resp);
				$k_1 = key($resp);
				$out .= '<label class="radio-inline"><input type="radio" id="'.$val['id'].'" name="'.$val['name'].'" class="'.$val['add_class'].'" value="'.$v_1[$val['data_diff_info'][0]].'" checked />'.$v_1[$val['data_diff_info'][1]].'</label>';
				unset($resp[$k_1]);
				foreach ($resp as $k1 => $v1){
					$out .= '<label class="radio-inline"><input type="radio" id="'.$val['id'].'" name="'.$val['name'].'" class="'.$val['add_class'].'" value="'.$v1[$val['data_diff_info'][0]].'" />'.$v1[$val['data_diff_info'][1]].'</label>';
				}
			}
			elseif($val['type'] == 'textarea'){
				$out = '<i>'.$val['label_2'].'</i><textarea id="'.$val['id'].'" name="'.$val['name'].'" class="'.$this->style['input'].' '.$val['add_class'].'" rows="6" maxlength="'.$val['maxlength'].'" '.$data.' '.$val['disabled'].'>'.$val['value'].'</textarea>';
			}
			elseif($val['type'] == 'p'){
				$out = '<span><i>Valor Fixo: '.$val['value'].'</i></span>';
			}
			elseif($val['type'] == 'none'){
				$out = '<div id="'.$val['id'].'" style="display:none;">'.$val['value'].'</div>';
			}
			else $out = '<i>'.$val['label_2'].'</i><input type="'.$val['type'].'" id="'.$val['id'].'" name="'.$val['name'].'" value="'.$val['value'].'" class="'.$this->style['input'].' '.$val['add_class'].'" maxlength="'.$val['maxlength'].'" '.$data.' '.$val['disabled'].' placeholder="'.$val['placeholder'].'" />';
		}
		return $out;
	}
	
	/* Funcao gerar conteúdo do select&radio&check */
	private function make_select_diff($val=null){
		if(!is_array($val)){
			$resp = parent::execute_select_sql($val);
			return $resp;
		}
		return $val;
	}
	
	/* Funcao para gerar array para tabelas */
	public function get_fast_table($label=true, $btn_form=null){
		$out = array();
		$i=0;
		foreach($this->inputs as $key => $val){
			if(($label == true || $label != null) && $val['label'] != null){
				$out[$i][0] = '<label for="'.$val['name'].'" class="'.$this->style['input_label'].'">'.$val['label'].'</label>';
			} else $out[$i][0] = '';
			$out[$i][1] = $this->generate_input($val);
			$i++;
		}
		$out[$i][0] = null;
		if(parent::exist_var($btn_form)) $out[$i][1] = $btn_form;
		else $out[$i][1] = $this->get_button_table();
		
		return $out;
	}

	/* Funcao para gerar array para data grid tabelas */
	public function get_fast_grid_table_data($count=1){		
		$btn = new FPHP_page_btn_group();
		$btn->add_group(array(array('text'=>'<i class="fa fa-trash"></i>', 'type'=>'primary', 'href'=>'#delete_grid')));
		$out[] = $btn->get_fast_group();
		
		foreach($this->inputs as $key => $val){
			$out[] = $this->generate_input($val);
		}
		$return = array();
		$i=0;
		do{
			$return[] = $out;
			$i++;
		}
		while($i<$count);
		
		return $return;
	}
	
	/* Funcao para gerar array para head grid tabelas */
	public function get_fast_grid_table_head(){
		$out = array('Excluir');
		foreach($this->inputs as $key => $val){
			$out[] = $val['label'];
		}
		return $out;
	}
	
	
	/* Abrir formulario */
	public function open_form_table(){
		$data = parent::make_data_values($this->form['data']);
		return '<form action="'.$this->form['action'].'" method="'.$this->form['method'].'" name="'.$this->form['name'].'" id="'.$this->form['id'].'" class="'.$this->style['form'].'" '.$data.' autocomplete="'.$this->form['autocomplete'].'">';
	}
	
	/* Fechar formulario */
	public function close_form_table(){
		return '</form>';
	}

	/* Gerar botão de submit */
	public function get_button_table(){
		$btn = new FPHP_page_btn_group();
		$btn->add_group(array(array('text'=>$this->form['button'], 'type'=>'primary', 'btn'=>true)));
		return $btn->get_fast_group();
	}
};

/* Testando a classe FPHP_inputs 
$form = new FPHP_page_forms(array('action'=>'', 'method'=>'get', 'name'=>'fphp_form_search', 'id'=>'fphp_form_search', 'button'=>'Pesquisar'));
//$form->dump('form');

$form->add_input(array('type'=>'text', 'id'=>'desc_processo', 'name'=>'desc_processo', 'label'=>'Processo', 'placeholder'=>'Processo', 'break'=>false));
$form->add_input(array('type'=>'text', 'id'=>'doc_origem_processo', 'name'=>'doc_origem_processo', 'label'=>'Documento Origem', 'placeholder'=>'Documento Origem'));

//$form->dump('inputs');

$form->generate_fast_form();
//$form->get_fast_form();
//*/

?>