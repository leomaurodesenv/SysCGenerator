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
					<h3 class="panel-title">Eventos &nbsp; <i class="fa fa-angle-right"></i> &nbsp; Adicionar</h3>
				</div>
				<div class="panel-body">
				<p>Todos os itens são obrigatórios.<p>
<?php

$btn_g = new FPHP_page_btn_group();
$btn_g->add_group(array(array('text'=>'<i class="fa fa-angle-double-left"></i> &nbsp; Voltar', 'href'=>'./list.php', 'type'=>'primary')));
$btn_g->generate_fast_group(2);

$alert = new FPHP_page_alert();
$alert->add_alerts(array('type'=>'success', 'text'=>'Evento adicionado.', 'id'=>'success_create', 'link'=>array('url'=>'./list.php', 'text'=> 'Retorne para a listagem dos eventos.'), 'strong'=>'Sucesso!'));
$alert->add_alerts(array('type'=>'danger', 'text'=>'Ocorreu algum problema..!', 'id'=>'danger_create'));
$alert->generate_alerts();

$form = new FPHP_page_forms(array('action'=>'#', 'method'=>'get', 'name'=>'7_sgc_event', 'id'=>'fphp_form_create', 'button'=>'Adicionar'));
$form->add_input(array('type'=>'text', 'id'=>'input_1', 'name'=>'input_1', 'label'=>'Nome (Siglas)', 'placeholder'=>'Nome', 'label_2'=>'Exemplo: EEC XII (2016)', 'maxlength'=>49, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'name')));
$form->add_input(array('type'=>'text', 'id'=>'input_2', 'name'=>'input_2', 'label'=>'Nome por Extenso', 'placeholder'=>'Nome Completo', 'label_2'=>'Exemplo: Evento de Exemplo da Computação', 'maxlength'=>199, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'event_certificate')));
$form->add_input(array('type'=>'text', 'id'=>'input_3', 'name'=>'input_3', 'label'=>'Realização', 'placeholder'=>'Realização', 'label_2'=>'Exemplo: Programa de Educação Tutorial (PET) Fronteira', 'maxlength'=>199, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'owner_certificate')));
$form->add_input(array('type'=>'text', 'id'=>'input_4', 'name'=>'input_4', 'label'=>'Local', 'placeholder'=>'Local', 'label_2'=>'Exemplo: Universidade Federal de Mato Grosso do Sul (UFMS) - Campus de Ponta Porã', 'maxlength'=>199, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'place_certificate')));
$form->add_input(array('type'=>'text', 'id'=>'input_5', 'name'=>'input_5', 'label'=>'Data', 'placeholder'=>'Data', 'label_2'=>'Exemplo: de 30 a 31 de Fevereiro de 2000', 'maxlength'=>199, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'date_certificate')));
$form->add_input(array('type'=>'text', 'id'=>'input_9', 'name'=>'input_9', 'label'=>'Carga Horária', 'placeholder'=>'Carga Horária', 'label_2'=>'Exemplo: 12', 'maxlength'=>199, 'data'=>array('validate'=>json_encode(['number'=>true]), 'field'=>'workload_certificate')));
$form->add_input(array('type'=>'select', 'id'=>'input_6', 'name'=>'input_6', 'label'=>'Selecione Layout', 'data_diff'=>'SELECT * FROM `7_sgc_layout`', 'data_diff_info'=>array('val_layout', 'option_layout'), 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'layout_certificate')));
$form->add_input(array('type'=>'hidden', 'id'=>'input_7', 'name'=>'input_7', 'label'=>'Data de Inclusão', 'value'=>'@cur_date_time', 'label_2'=>'Data de Inclusão - Valor Automático', 'disabled'=>'disabled', 'maxlength'=>20, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'date')));
$form->add_input(array('type'=>'textarea', 'id'=>'input_10', 'name'=>'input_10', 'label'=>'Programação', 'label_2'=>'Permitido utilizar tags HTML', 'maxlength'=>6000, 'data'=>array('field'=>'programming_certificate')));
$form->add_input(array('type'=>'hidden', 'id'=>'input_8', 'name'=>'input_8', 'label'=>'Responsável', 'value'=>$_SESSION['user']['id'], 'label_2'=>'Responsável: '.$_SESSION['user']['name_user'].' - Valor Automático', 'disabled'=>'disabled', 'maxlength'=>21, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'id_user')));
$create_content = $form->get_fast_table();

echo $form->open_form_table();
$table = new FPHP_page_table();
$table->class_partial_td(array('col-md-3'));
$table->define_table_data($create_content);
$table->generate_fast_table();
echo $form->close_form_table();

?>
				
				</div>
			</div>
		</div> <!-- /infos-verify -->
		
	</div>

</div> <!-- /container -->

<?php require_once('../../php/page_content/bottom.php'); ?>