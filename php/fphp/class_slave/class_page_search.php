<?php

class FPHP_page_search extends FPHP_master{
	/* Variaveis do formulario */
	private $search_data;
	
	/* Construtor */
	public function __construct(){
		$this->search_data = null;
	}
	
	/* Funcao para teste (dump) */
	public function dump(){
		var_dump($this->search_data);
	}
	
	/* Define todos todo search */
	public function define_search_data($def=null){
		$data = [
			'title'=>'Search', 
			'accordion'=>true,
			'collapse'=>true,
			'body'=>'Content'
		];
		$this->define_data($this->search_data, $data, $def);
	}

	/* Gera toda a estrutura do search panel */
	public function generate_fast_search(){
		if($this->search_data['accordion']){
			if($this->search_data['collapse']) $expanded = 'collapse';
			else $expanded = 'collapse in';
			
			$out = '<div class="accordion" id="accordion-search"><div class="panel panel-default"><div class="panel-heading"><p class="fphp-link-search link panel-title accordion-toggle" data-toggle="collapse" data-parent="#accordion-search" href="#accordion-search-content">';
			$out .= $this->search_data['title'];
			$out .= '</p></div><div id="accordion-search-content" class="accordion-body '.$expanded.'"><div class="accordion-inner"><div class="panel-body">';
			$out .= $this->search_data['body'];
			$out .= '</div></div></div></div></div>';
		}
		else{
			$out = '<div class="accordion" id="accordion-search"><div class="panel panel-default"><div class="panel-heading"><p class="fphp-link-search panel-title">';
			$out .= $this->search_data['title'];
			$out .='</p></div><div class="panel-body">';
			$out .= $this->search_data['body'];
			$out .='</div></div></div>';
		}
		echo $out;
	}
	
};

/* Testando a classe FPHP_page_table 

$search = new FPHP_page_search();
$search->define_search_data();
$search->generate_fast_search();
*/

?>