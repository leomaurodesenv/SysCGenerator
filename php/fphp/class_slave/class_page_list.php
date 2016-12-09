<?php

class FPHP_page_list extends FPHP_master{
	/* Variaveis do formulario */
	private $list_head;
	private $list_sql = null;
	private $list_data = null;
	
	/* CRUD (Create, Read, Update, Delete) */
	/* Construtor */
	public function __construct($def=null){
		$data = array(
			'create'=>false,
			'read'=>true,
			'update'=>false,
			'delete'=>false
		);
		
		parent::define_data($this->list_head, $data, $def);
	}
	
	/* Funcao para teste (dump) */
	public function dump($a='head'){
		if($a == 'head') var_dump($this->list_head);
		else if($a == 'sql') var_dump($this->list_sql);
		else if($a == 'data') var_dump($this->list_data);
	}
	
	/* Define o sql da lista */
	public function define_list_sql($def=null){
		$data = array(
			'generic_name'=>false,
			'id'=>null,
			'query'=>null,
			'types'=>'',
			'params'=>array(),
			'order_by'=>null,
			'order_by_type'=>'ASC',
			'limit'=>30,
			'pagination'=>1
		);
		
		if(parent::exist_var($def["pagination"]))
			$def["pagination"] = ($def["pagination"]>1) ? $def["pagination"] : 1;
		parent::define_data($this->list_sql, $data, $def);
	}
	
	/* Executa os query */
	public function execute_list_sql(){
		$query = $this->list_sql;
		$this->list_data = parent::execute_select_sql($query);
		$query['limit'] = null;
		$query['pagination'] = null;
		$max_pag = parent::execute_select_sql($query);
		$this->list_sql['max_pag'] = count($max_pag);
	}
	
	/* Retorna todo conteúdo da pesquisa */
	public function return_list_sql($def=null, $def_pre=true, $date_change=false){
		$return = array();
		
		$list_data = $this->list_data;
		if(parent::exist_var($list_data) && count($list_data)>=1){
			foreach($list_data as $k1 => $v1){
				$aux = array();
				if($def_pre){
					$pre = $this->make_list_head($v1[$this->list_sql['id']]);
					foreach($pre as $k2 => $v2){
						array_unshift($aux, $v2);
					}
				}
				foreach($def as $k2 => $v2){
					if(array_key_exists($v2, $list_data[$k1])){
						if(parent::exist_var($date_change) && in_array($v2,$date_change))
							array_push($aux, date('d/m/Y h:i:s', strtotime($list_data[$k1][$v2])));
						else
							array_push($aux, $list_data[$k1][$v2]);
					}
						
				}
				array_push($return, $aux);
			}
		}
		return $return;
		
	}
	
	/* Retorna a tabela do conteúdo do read */
	public function return_read($def=null, $def_title=null, $date_change=false){
		$return = array();
		$values = $this->return_list_sql($def, false, $date_change);
		$read = (parent::exist_var($values))? $values[0] : null;
		if(parent::exist_var($read)){
			foreach($read as $k1 => $v1){
				$aux = array();
				if(parent::exist_var($def_title)) array_push($aux, $def_title[$k1], nl2br($v1));
				//if(parent::exist_var($def_title)) array_push($aux, $def_title[$k1], $v1);
				else array_push($aux, $v1);
				array_push($return, $aux);
			}
		}
		return $return;
	}
	
	/* Retorna o conteúdo do update */
	public function return_update($def=null, $date_change=false){
		$values = $this->return_list_sql($def, false, $date_change);
		if(count($values)==1 && parent::exist_var($values[0])){
			$return = array();
			foreach($values[0] as $k1 => $v1){
				$return[$def[$k1]] = $v1;
			}
			return $return;
		}
		else
			return false;
	}
	
	/* Inseri os botoes laterais do crud */
	private function make_list_head($id=null){
		$aux = array();
		
		foreach($this->list_head as $k1 => $v1){
			if(parent::exist_var($v1)){
				if($k1 != 'create'){
					$icon_name = 'eye';
					$icon_title = 'Ver';
					if($k1 == 'update'){
						$icon_name = 'pencil';
						$icon_title = 'Editar';
					}
					elseif($k1 == 'delete'){
						$icon_name = 'trash';
						$icon_title = 'Excluir';
					}
					$aux[] = '<a href="./'.$k1.'.php?id='.$id.'" data-toggle="tooltip" data-placement="top" title="'.$icon_title.'" ><i class="fa fa-'.$icon_name.'"></i></a>';
				}
			}
		}
		return $aux;
	}
	
	/* Adiciona um th a cada botao lateral */
	public function add_button_list($def=null, $comp='#'){
		$return = $def;
		foreach($this->list_head as $k1 => $v1){
			if(parent::exist_var($v1)){
				if($k1 != 'create'){
					array_unshift($return, $comp);
				}
			}
		}
		return $return;
	}
	
	/* Retorna um botao adicionar */
	public function add_button_new($tooltip = false){
		$return = '';
		if(parent::exist_var($this->list_head['create'])){
			$t = '';
			if($tooltip) $t = 'data-toggle="tooltip" data-placement="top" title="Adicionar"';
			$return = '<a href="./create.php" class="btn btn-primary fphp-nav-add" '.$t.'>Adicionar</a>';
		}
		echo $return;
	}
	
	/* Retorna um botão do adicionar grid */
	public function add_grid_button_new($tooltip = false){
		$return = '';
		if(parent::exist_var($this->list_head['create'])){
			$t = '';
			if($tooltip) $t = 'data-toggle="tooltip" data-placement="top" title="Adicionar Grid"';
			$return = '<a href="./create.php" class="btn btn-primary fphp-nav-add" '.$t.'>Adicionar Grid</a>';
		}
		echo $return;
	}
	
	/* Adiciona a paginacao e seu conteúdo */
	public function add_nav_pagination($info=true, $grid=false){
		$max_pag = ceil(($this->list_sql['max_pag'])/$this->list_sql["limit"]);
		$first_pag = (($this->list_sql["pagination"]-4) >= 1) ? ($this->list_sql["pagination"]-4) : 1;
		$last_pag = (9+$first_pag);
		$last_pag = ($last_pag >= $max_pag) ? $max_pag : $last_pag;
		$first_pag = ((($last_pag-$first_pag) <= 9) && ($last_pag==$max_pag)) ? $max_pag-9 : $first_pag ;
		$first_pag = ($first_pag >= 1) ? $first_pag : 1;
		
		$link = './list.php';
		$link_pag = './list.php?page=';
		
		$out = '<nav class="fphp-nav-search"><ul class="pagination fphp-nav-info"><li><a href=\''.$link.'\' aria-label="Previous" data-toggle="tooltip" data-placement="top" title="Primeira Pagina" ><span aria-hidden="true">&laquo;</span></a></li>';
		for($i=$first_pag; $i<=$last_pag; $i++){
			if($this->list_sql["pagination"] == $i) $out .= '<li class="active"><a href=\''.$link_pag.$i.'\'>'.$i.' <span class="sr-only">(current)</span></a></li>';
			else $out .= '<li><a href=\''.$link_pag.$i.'\'>'.$i.'</a></li>';
		}
		$out .= '<li><a href=\''.$link_pag.$max_pag.'\' aria-label="Next" data-toggle="tooltip" data-placement="top" title="Ultima Pagina" ><span aria-hidden="true">&raquo;</span></a></li></ul>';
		
		if($info) $out .= '<ul class="pagination fphp-nav-info"><li class="disabled"><span style="cursor:text;">Paginas '.$max_pag.'</span></li><li class="disabled"><span style="cursor:text;">Registros '.$this->list_sql['max_pag'].'</span></li></ul>';
		if(parent::exist_var($this->list_head['create'])){
			$out .= '<ul class="pagination fphp-nav-info"><li><a href="./create.php">Adicionar</a></li>';
			if($grid) $out .= '<li><a href="./create-grid.php">Adicionar Grid</a></li>';
			$out .= '</ul>';
		}
		
		$out .= '</nav>';
		echo $out;
	}
	
	/* Converte \n para <br/> */
	private function nl2br2($string) { 
		$string = str_replace(array("\r\n", "\r", "\n"), "<br/>", $string);
		return $string;
	}
	
};

/* Testando a classe FPHP_page_list 

$list = new FPHP_page_list();

$list_query = 
'SELECT p.id_processo, p.desc_processo, p.doc_origem_processo, o.nome_orgao_ap, p.sys_data, s.nome_status
FROM processo p 
INNER JOIN orgao_apreensao o
ON p.fk_id_orgao_ap = o.id_orgao_ap
INNER JOIN processo_status s
ON p.fk_id_status = s.id_status';
$list->define_list_sql(array('generic_name'=>'processo', 'query'=>$list_query, 'id'=>'id_processo', 'limit_fs'=>0, 'limit_lt'=>30));

$list->execute_list_sql();

$return_list = array('desc_processo', 'doc_origem_processo', 'nome_orgao_ap', 'sys_data', 'nome_status');
$r = $list->return_list_sql($return_list);

//*/
?>