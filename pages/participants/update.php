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
					<h3 class="panel-title">Participantes &nbsp; <i class="fa fa-angle-right"></i> &nbsp; Editar</h3>
				</div>
				<div class="panel-body">
<?php

$alert = new FPHP_page_alert();
$alert->add_alerts(array('type'=>'success', 'text'=>'Participante atualizado.', 'id'=>'success_update', 'link'=>array('url'=>'./list.php', 'text'=> 'Retorne para a listagem dos participantes.'), 'strong'=>'Sucesso!'));
$alert->add_alerts(array('type'=>'danger', 'text'=>'Ocorreu algum problema..!', 'id'=>'danger_update'));
$alert->generate_alerts();

$id_update = $page->return_get('id', '-1');
$list = new FPHP_page_list();
$inner = array(
	array('type'=>'INNER JOIN', 'table'=>'7_sgc_event e', 'on'=>'e.id = p.id_event'),
	array('type'=>'INNER JOIN', 'table'=>'7_sgc_standard s', 'on'=>'s.val_stand = p.standard_partp')
);
$where = array(
	array('column'=>'e.id_user', 'operator'=>'='),
	array('column'=>'e.active', 'operator'=>'=', 'condition'=>'AND'),
	array('column'=>'p.active', 'operator'=>'=', 'condition'=>'AND'),
	array('column'=>'p.id_partp', 'operator'=>'=', 'condition'=>'AND')
);
$list_query = $page->make_select('p.*, s.option_stand', '7_sgc_participants p', $inner, $where);
$types_query = 'ssss';
$params_query = array($_SESSION['user']['id'], '1', '1', $id_update);


$list->define_list_sql(array('query'=>$list_query, 'types'=>$types_query, 'params'=>$params_query, 'id'=>'id_partp', 'generic_name'=>'7_sgc_participants'));
$list->execute_list_sql();
$return_list = array('id_event', 'name_partp', 'cpf_partp', 'email_partp', 'option_stand', 'extra_partp');
$return = $list->return_update($return_list, array('date'));


$form = new FPHP_page_forms(array('action'=>'#', 'method'=>'get', 'name'=>'fphp_form_update', 'id'=>'fphp_form_update', 'button'=>'Editar', 'data'=>array('id_column'=>'id_partp', 'id'=>$id_update, 'table'=>'7_sgc_participants')));
$form->add_input(array('type'=>'select', 'id'=>'input_1', 'name'=>'input_1', 'value'=>$return['id_event'], 'label'=>'Evento', 'data_diff'=>'SELECT * FROM `7_sgc_event`', 'data_diff_info'=>array('id', 'name'), 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'id_event')));
$form->add_input(array('type'=>'text', 'id'=>'input_2', 'name'=>'input_2', 'value'=>$return['name_partp'], 'label'=>'Nome Completo', 'placeholder'=>'Nome Completo', 'maxlength'=>100, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'name_partp')));
$form->add_input(array('type'=>'text', 'id'=>'input_3', 'name'=>'input_3', 'value'=>$return['email_partp'], 'label'=>'E-mail', 'placeholder'=>'E-mail', 'maxlength'=>200, 'data'=>array('validate'=>json_encode(['email'=>true]), 'field'=>'email_partp')));
$form->add_input(array('type'=>'text', 'id'=>'input_4', 'name'=>'input_4', 'value'=>$return['cpf_partp'], 'label'=>'CPF', 'placeholder'=>'CPF', 'maxlength'=>20, 'data'=>array('field'=>'cpf_partp')));
$form->add_input(array('type'=>'select', 'id'=>'input_5', 'name'=>'input_5', 'value'=>$return['option_stand'], 'label'=>'Qualidade', 'data_diff'=>'SELECT * FROM `7_sgc_standard`', 'data_diff_info'=>array('val_stand', 'option_stand'), 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'standard_partp')));
$form->add_input(array('type'=>'text', 'id'=>'input_7', 'name'=>'input_7', 'value'=>$return['extra_partp'], 'label'=>'Extra', 'placeholder'=>'Extra', 'maxlength'=>200, 'data'=>array('field'=>'extra_partp')));
$create_content = $form->get_fast_table();

$btn = new FPHP_page_btn_group();
$btn->add_group(false, 'edit');
$create_content = $form->get_fast_table(true, $btn->get_fast_group());

$table = new FPHP_page_table();
$table->class_partial_td(array('col-md-3'));
$table->define_table_data($create_content);
$my_content = $form->open_form_table();
$my_content .= $table->get_fast_table();
$my_content .= $form->close_form_table();


$alert->add_alerts(array('type'=>'warning', 'text'=>'Participante acessado não existe.', 'id'=>'success_update', 'link'=>array('url'=>'./list.php', 'text'=> 'Retorne para a listagem dos participantes.'), 'strong'=>'Error!', 'display'=>'block'));
$error_acesso = $alert->get_alerts();

/* Valida as informações e apresenta o conteudo */
$page->valid_content_page($return, $my_content, $error_acesso);


?>
				
				</div>
			</div>
		</div> <!-- /infos-verify -->
		
	</div>

</div> <!-- /container -->

<?php require_once('../../php/page_content/bottom.php'); ?>