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
					<h3 class="panel-title">Participantes &nbsp; <i class="fa fa-angle-right"></i> &nbsp; Ver</h3>
				</div>
				<div class="panel-body">

<?php

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
$list_query = $page->make_select('p.*, e.name, s.option_stand', '7_sgc_participants p', $inner, $where);
$types_query = 'ssss';
$params_query = array($_SESSION['user']['id'], '1', '1', $page->return_get('id', '0'));


$list->define_list_sql(array('query'=>$list_query, 'types'=>$types_query, 'params'=>$params_query, 'id'=>'id_partp', 'generic_name'=>'participants'));
$list->execute_list_sql();
$return_list = array('name', 'name_partp', 'cpf_partp', 'email_partp', 'option_stand', 'extra_partp', 'date_partp');
$header_list = array('Evento', 'Nome', 'CPF',  'E-mail', 'Qualidade', 'Extra', 'Data Inserção');
$d = $list->return_read($return_list, $header_list, array('date_partp'));


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
$alert->add_alerts(array('type'=>'warning', 'text'=>'Participante acessado nao existe.', 'id'=>'warning_read', 'link'=>array('url'=>'./list.php', 'text'=> 'Retorne para a listagem dos participantes.'), 'strong'=>'Error!', 'display'=>'block'));
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