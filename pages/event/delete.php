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
					<h3 class="panel-title">Eventos &nbsp; <i class="fa fa-angle-right"></i> &nbsp; Excluir</h3>
				</div>
				<div class="panel-body">

<?php

$alert = new FPHP_page_alert();
$alert->add_alerts(array('type'=>'success', 'text'=>'Evento excluido.', 'id'=>'success_delete', 'link'=>array('url'=>'./list.php', 'text'=> 'Retorne para a listagem dos eventos.'), 'strong'=>'Sucesso!'));
$alert->add_alerts(array('type'=>'danger', 'text'=>'Ocorreu algum problema..!', 'id'=>'danger_delete'));
$alert->generate_alerts();

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

$list->define_list_sql(array('query'=>$list_query, 'types'=>$types_query, 'params'=>$params_query, 'id'=>'id', 'generic_name'=>'e'));
$list->execute_list_sql();
$return_list = array('name', 'event_certificate' ,'owner_certificate', 'place_certificate', 'date_certificate', 'workload_certificate', 'option_layout', 'programming_certificate', 'date');
$header_list = array('Sigla', 'Evento', 'Responsável', 'Local', 'Data', 'Carga Horária', 'Layout', 'Programação', 'Data de Inclusão');
$d = $list->return_read($return_list, $header_list, array('date'));

$btn_g = new FPHP_page_btn_group();
$btn_g->add_group(array(array('text'=>'<i class="fa fa-angle-double-left"></i> &nbsp; Voltar', 'href'=>'./list.php', 'type'=>'primary')));
$my_content = $btn_g->get_fast_group(2);

$table = new FPHP_page_table(array('class_table'=>'table table-bordered table-striped'));
$table->class_partial_td(array('col-md-3'));
$table->define_table_head(array('Campo', 'Valor'));
$table->define_table_data($d);
$my_content .= $table->get_fast_table();


$id = $page->return_get('id', false);
$btn_g = new FPHP_page_btn_group(null, 'groups_delete', array(array('style'=>'display:none;')));
$btn_g->add_group(array(
	array('text'=>'Confirmar Exclusao', 'href'=>'#', 'type'=>'danger', 'id'=>'fphp_delete_confirm', 'data'=>
		array('id'=>$id, 'id_column'=>'id', 'table'=>'7_sgc_event', 'in_table'=>1, 'in_table_column'=>'active')
	), 
	array('text'=>'Cancelar', 'href'=>'./list.php', 'id'=>'fphp_delete_cancel')
));
$btn_g->add_group(array(array('text'=>'Excluir', 'href'=>'#', 'id'=>'fphp_delete_btn')));
$my_content .= $btn_g->get_fast_group();


$alert = new FPHP_page_alert();
$alert->add_alerts(array('type'=>'warning', 'text'=>'Evento acessado nao existe.', 'id'=>'success_update', 'link'=>array('url'=>'./list.php', 'text'=> 'Retorne para a listagem dos evento.'), 'strong'=>'Error!', 'display'=>'block'));
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