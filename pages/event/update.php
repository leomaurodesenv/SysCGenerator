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
					<h3 class="panel-title">Eventos &nbsp; <i class="fa fa-angle-right"></i> &nbsp; Editar</h3>
				</div>
				<div class="panel-body">
<?php

$alert = new FPHP_page_alert();
$alert->add_alerts(array('type'=>'success', 'text'=>'Evento atualizado.', 'id'=>'success_update', 'link'=>array('url'=>'./list.php', 'text'=> 'Retorne para a listagem dos eventos..'), 'strong'=>'Sucesso!'));
$alert->add_alerts(array('type'=>'danger', 'text'=>'Ocorreu algum problema..!', 'id'=>'danger_update'));
$alert->generate_alerts();

$id_update = $page->return_get('id', '-1');
$list = new FPHP_page_list();
$inner = array(array('type'=>'INNER JOIN', 'table'=>'7_sgc_user u', 'on'=>'e.id_user = u.id'));
$where = array(
	array('column'=>'e.id_user', 'operator'=>'='),
	array('column'=>'e.active', 'operator'=>'=', 'condition'=>'AND'),
	array('column'=>'e.id', 'operator'=>'=', 'condition'=>'AND')
);
$list_query = $page->make_select('e.*', '7_sgc_event e', $inner, $where);
$types_query = 'sss';
$params_query[] = $_SESSION['user']['id']; $params_query[] = '1';
$params_query[] = $id_update;
$list->define_list_sql(array('query'=>$list_query, 'types'=>$types_query, 'params'=>$params_query, 'id'=>'id', 'generic_name'=>'event'));
$list->execute_list_sql();
$return_list = array('name', 'event_certificate', 'owner_certificate', 'place_certificate', 'date_certificate', 'workload_certificate', 'layout_certificate', 'programming_certificate');
$return = $list->return_update($return_list, array('date'));


$form = new FPHP_page_forms(array('action'=>'#', 'method'=>'get', 'name'=>'fphp_form_update', 'id'=>'fphp_form_update', 'button'=>'Editar', 'data'=>array('id_column'=>'id', 'id'=>$id_update, 'table'=>'7_sgc_event')));
$form->add_input(array('type'=>'text', 'id'=>'input_1', 'name'=>'input_1', 'value'=>$return['name'], 'label'=>'Nome (Siglas)', 'placeholder'=>'Nome', 'label_2'=>'Exemplo: EEC XII (2016)', 'maxlength'=>49, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'name')));
$form->add_input(array('type'=>'text', 'id'=>'input_2', 'name'=>'input_2', 'value'=>$return['event_certificate'], 'label'=>'Nome por Extenso', 'placeholder'=>'Nome Completo', 'label_2'=>'Exemplo: Evento de Exemplo da Computação', 'maxlength'=>199, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'event_certificate')));
$form->add_input(array('type'=>'text', 'id'=>'input_3', 'name'=>'input_3', 'value'=>$return['owner_certificate'], 'label'=>'Realização', 'placeholder'=>'Realização', 'label_2'=>'Exemplo: Programa de Educação Tutorial (PET) da Fronteira', 'maxlength'=>199, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'owner_certificate')));
$form->add_input(array('type'=>'text', 'id'=>'input_4', 'name'=>'input_4', 'value'=>$return['place_certificate'], 'label'=>'Local', 'placeholder'=>'Local', 'label_2'=>'Exemplo: Universidade Federal de Mato Grosso do Sul (UFMS) - Campus de Ponta Porã', 'maxlength'=>199, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'place_certificate')));
$form->add_input(array('type'=>'text', 'id'=>'input_5', 'name'=>'input_5', 'value'=>$return['date_certificate'], 'label'=>'Data', 'placeholder'=>'Data', 'label_2'=>'Exemplo: de 30 a 31 de Fevereiro de 2000', 'maxlength'=>199, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'date_certificate')));
$form->add_input(array('type'=>'text', 'id'=>'input_9', 'name'=>'input_9', 'value'=>$return['workload_certificate'], 'label'=>'Carga Horária', 'placeholder'=>'Carga Horária', 'label_2'=>'Exemplo: 12', 'maxlength'=>199, 'data'=>array('validate'=>json_encode(['number'=>true]), 'field'=>'workload_certificate')));
$form->add_input(array('type'=>'select', 'id'=>'input_6', 'name'=>'input_6', 'value'=>$return['layout_certificate'], 'label'=>'Selecione Layout', 'data_diff'=>'SELECT * FROM `7_sgc_layout`', 'data_diff_info'=>array('val_layout', 'option_layout'), 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'layout_certificate')));
$form->add_input(array('type'=>'textarea', 'id'=>'input_10', 'name'=>'input_10', 'value'=>$return['programming_certificate'], 'label'=>'Programação', 'label_2'=>'Permitido utilizar tags HTML', 'maxlength'=>6000, 'data'=>array('field'=>'programming_certificate')));
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


$alert->add_alerts(array('type'=>'warning', 'text'=>'Evento acessado não existe.', 'id'=>'success_update', 'link'=>array('url'=>'./list.php', 'text'=> 'Retorne para a listagem dos eventos.'), 'strong'=>'Error!', 'display'=>'block'));
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