<?php

class FPHP_page_alert extends FPHP_master{
	/* Variaveis do formulario */
	private $alert;
	
	/* Construtor */
	public function __construct($def=null){
		$this->alert = array();
	}
	
	/* Funcao para definir todos os alerts */
	public function define_alerts($def=null){
		if(parent::exist_var($def)) $this->alert = $def;
		else $this->alert = array();
	}
	
	/* Funcao para adicionar um alert */
	public function add_alerts($def=null){
		if(parent::exist_var($def)){
			$mini_data = array('type'=>'info', 'id'=>null, 'text'=>'text', 'link'=>null, 'strong'=>null, 'display'=>'none');
			parent::define_data($new_line, $mini_data, $def);
			if(parent::exist_var($new_line['id'])) array_push($this->alert, $new_line);
		}
		else echo '$error[\'add_alerts\']';
	}
	
	public function dump($a='alert'){
		if($a=='alert') var_dump($this->alert);
	}
	
	/* Implementador da query de busca */
	public function generate_alerts(){
		echo $this->get_alerts();
	}
	
	/* Implementador da query de busca */
	public function get_alerts(){
		$out = '';
		if(parent::exist_var($this->alert)){
			foreach($this->alert as $k1 => $v1){
				$out .= '<div class="alert alert-'.$v1['type'].'" id="'.$v1['id'].'" role="alert" style="display:'.$v1['display'].';"><button type="button" class="close" data-hide="'.$v1['id'].'" aria-hidden="true">&times;</button><span>';
				if(parent::exist_var($v1['strong'])) $out .= '<strong>'.$v1['strong'].'</strong> ';
				$out .= $v1['text'];
				if(parent::exist_var($v1['link']))
					$out .= '<br/><a href="'.$v1['link']['url'].'" class="alert-link">'.$v1['link']['text'].'</a>';
				$out.= '</span></div>';
			}
			return $out;
		}
		else return '$error[\'generate_alerts\']';
		$this->alert = array();
	}
	
};

/* Testando a classe FPHP_inputs */
/*
$alert = new FPHP_page_alert();

$alert->add_alerts(array('type'=>'success', 'text'=>'Processo excluido.', 'id'=>'success_delete', 'link'=>array('url'=>'./list.php', 'text'=> 'Retorne para a listagem dos processos.'), 'strong'=>'Sucesso!', 'display'=>'block'));
$alert->add_alerts(array('type'=>'danger', 'text'=>'Ocorreu algum problema..!', 'id'=>'danger_delete', 'display'=>'block'));

//$alert->dump();
$alert->generate_alerts();
*/

?>