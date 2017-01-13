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
					<h3 class="panel-title">Participantes &nbsp; <i class="fa fa-angle-right"></i> &nbsp; Adicionar</h3>
				</div>
				<div class="panel-body">
<?php

$btn_g = new FPHP_page_btn_group();
$btn_g->add_group(array(array('text'=>'<i class="fa fa-angle-double-left"></i> &nbsp; Voltar', 'href'=>'./list.php', 'type'=>'primary')));
$btn_g->generate_fast_group(2);

$alert = new FPHP_page_alert();
$alert->add_alerts(array('type'=>'success', 'text'=>'Participante adicionado.', 'id'=>'success_create', 'link'=>array('url'=>'./list.php', 'text'=> 'Retorne para a listagem dos participantes.'), 'strong'=>'Sucesso!'));
$alert->add_alerts(array('type'=>'danger', 'text'=>'Ocorreu algum problema..!', 'id'=>'danger_create'));
$alert->generate_alerts();

$form = new FPHP_page_forms(array('action'=>'#', 'method'=>'get', 'name'=>'7_sgc_participants', 'id'=>'fphp_form_create', 'button'=>'Adicionar'));
$form->add_input(array('type'=>'select', 'id'=>'input_1', 'name'=>'input_1', 'label'=>'Evento', 'data_diff'=>'SELECT * FROM `7_sgc_event` WHERE `active`=\'1\' AND `id_user`=\''.$_SESSION['user']['id'].'\'', 'data_diff_info'=>array('id', 'name'), 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'id_event')));
$form->add_input(array('type'=>'text', 'id'=>'input_2', 'name'=>'input_2', 'label'=>'Nome Completo', 'placeholder'=>'Nome Completo', 'maxlength'=>100, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'name_partp')));
$form->add_input(array('type'=>'text', 'id'=>'input_3', 'name'=>'input_3', 'label'=>'E-mail', 'placeholder'=>'E-mail', 'maxlength'=>200, 'data'=>array('validate'=>json_encode(['email'=>true]), 'field'=>'email_partp')));
$form->add_input(array('type'=>'text', 'id'=>'input_4', 'name'=>'input_4', 'label'=>'CPF', 'placeholder'=>'CPF', 'maxlength'=>20, 'data'=>array('field'=>'cpf_partp')));
$form->add_input(array('type'=>'select', 'id'=>'input_5', 'name'=>'input_5', 'label'=>'Qualidade', 'data_diff'=>'SELECT * FROM `7_sgc_standard`', 'data_diff_info'=>array('val_stand', 'option_stand'), 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'standard_partp')));
$form->add_input(array('type'=>'text', 'id'=>'input_7', 'name'=>'input_7', 'label'=>'Extra', 'label_2'=>'Texto "extra" para o certificado deste','placeholder'=>'Extra', 'maxlength'=>200, 'data'=>array('field'=>'extra_partp')));
$form->add_input(array('type'=>'hidden', 'id'=>'input_6', 'name'=>'input_6', 'label'=>'Data de Inclusão', 'value'=>'@cur_date_time', 'label_2'=>'Data de Inclusão - Valor Automático', 'disabled'=>'disabled', 'maxlength'=>20, 'data'=>array('validate'=>json_encode(['required'=>true]), 'field'=>'date_partp')));
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