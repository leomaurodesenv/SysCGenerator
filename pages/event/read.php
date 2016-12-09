<?php 
/* Incluir */
require_once('../../php/class_loader.php');
require_once('../../php/page_content/top.php'); 

/* Verifica loggin */
if(!login(1)) header('Location: ../../index.php');
$page = new FPHP_page_construct();

?>

<div class="body container">

	<div class="row">

		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Eventos &nbsp; <i class="fa fa-angle-right"></i> &nbsp; Ver</h3>
				</div>
				<div class="panel-body">

<?php

$list = new FPHP_page_list();
$inner = array(
	array('type'=>'INNER JOIN', 'table'=>'7_sgc_user u', 'on'=>'e.id_user = u.id'),
	array('type'=>'INNER JOIN', 'table'=>'7_sgc_layout l', 'on'=>'e.layout_certificate = l.val_layout')
);
$where = array(
	array('column'=>'e.id_user', 'operator'=>'='),
	array('column'=>'e.active', 'operator'=>'=', 'condition'=>'AND'),
	array('column'=>'e.id', 'operator'=>'=', 'condition'=>'AND')
);
$list_query = $page->make_select('e.*, l.option_layout', '7_sgc_event e', $inner, $where);
$types_query = 'sss';
$params_query[] = $_SESSION['user']['id']; $params_query[] = '1';
$params_query[] = $page->return_get('id', '0');

$list->define_list_sql(array('query'=>$list_query, 'types'=>$types_query, 'params'=>$params_query, 'id'=>'id', 'generic_name'=>'event'));
$list->execute_list_sql();
$return_list = array('name', 'event_certificate' ,'owner_certificate', 'place_certificate', 'date_certificate', 'workload_certificate', 'option_layout', 'programming_certificate', 'date');
$header_list = array('Sigla', 'Evento', 'Responsável', 'Local', 'Data', 'Carga Horária', 'Layout', 'Programação', 'Data de Inclusão');
$d = $list->return_read($return_list, $header_list, array('date'));


$btn_g = new FPHP_page_btn_group(array('id'=>$page->return_get('id', '-1')));
$btn_g->add_group(array(array('text'=>'<i class="fa fa-angle-double-left"></i> &nbsp; Voltar', 'href'=>'./list.php', 'type'=>'primary')));
$btn = array('read'=>true,'update'=>true,'delete'=>true,'create'=>true);
$btn_g->add_group(false, 'read', $btn);
$my_content = $btn_g->get_fast_group(2);


$table = new FPHP_page_table(array('class_table'=>'table table-bordered table-striped'));
$table->class_partial_td(array('col-md-3'));
$table->define_table_head(array('Campo', 'Valor'));
$table->define_table_data($d);
$my_content .= $table->get_fast_table();


$alert = new FPHP_page_alert();
$alert->add_alerts(array('type'=>'warning', 'text'=>'Evento acessado nao existe.', 'id'=>'warning_read', 'link'=>array('url'=>'./list.php', 'text'=> 'Retorne para a listagem dos eventos.'), 'strong'=>'Error!', 'display'=>'block'));
$error_acesso = $alert->get_alerts();


/* Valida as informações e apresenta o conteudo */
$page->valid_content_page($d, $my_content, $error_acesso);

?>
				
				</div>
			</div>
		</div> <!-- /infos-verify -->
		
	</div>

</div> <!-- /container -->

<?php require_once('../../php/page_content/bottom.php'); ?>