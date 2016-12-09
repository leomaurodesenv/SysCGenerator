<?php

class FPHP_page_construct extends FPHP_master{
	/* Variaveis do formulario */
	private $data;
	private $data_search;
	
	/* Construtor */
	public function __construct($def=null){
		$this->data = array();
		if($this->exist_search()){			
			$hash = $_GET['search'];
			$crypt = new CRYPT_instruction('search');
			$decp = $crypt->decrypt($hash);
			
			$this->data_search = json_decode($decp, true);
		}
		else $this->data_search = array();
	}
	
	/* Funcao para requerir uma página */
	public function require_page($page=null){
		if(parent::exist_var($page)){
			$loader = new FPHP_loader(array('php'));
			$loader->load_file($page);
		}
		else echo '$error[\'exist_var(def_loc_head)\']';
	}
	
	/* Funcao de testes */
	public function dump($a='search'){
		if($a=='search') var_dump($this->data_search);
	}
	
	/* Buscando valor do search da pagina */
	public function search_value($field=null, $false=null){
		if($this->exist_search() && parent::exist_var($field)){
			foreach($this->data_search as $k1 => $v1){
				if($v1['field'] == $field) return $v1['value'];
			}
		}
		return $false;
	}
	
	/* Apenas verificando se existe o search */
	public function exist_search(){
		return parent::exist_var($_GET['search']);
	}
	
	/* Implementador da query de busca */
	public function construct_search($query, &$types, &$params, $first_where=true){
		if($this->exist_search()){
			$where = array();
			foreach($this->data_search as $k1 => $v1){
				$types .= 's';
				$val_par = $v1['value'];
				if($v1['operator'] == 'LIKE') $val_par = '%'.$v1['value'].'%';
				$params[] = $val_par;
				$where[] = ['condition'=>'AND', 'column'=>$v1['field'], 'operator'=>$v1['operator']];
			}
			$query .= parent::construct_where($where, $first_where);
		}
		return $query;
	}
	
	/* Retorna valores do get */
	public function return_get($get='page', $not_found=false){
		return (isset($_GET[$get])) ? $_GET[$get] : $not_found;
	}
	
};

?>