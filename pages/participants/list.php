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
					<h3 class="panel-title">Participantes</h3>
				</div>
				<div class="panel-body">
					<p>Página destinada a administração dos certificados dos participantes.</p>
					<br/>

<?php

$pagination = (isset($_GET['page'])) ? $_GET['page'] : 1;
$list = new FPHP_page_list(array('read'=>true,'update'=>true,'delete'=>true,'create'=>true));

$inner = array(
	array('type'=>'INNER JOIN', 'table'=>'7_sgc_event e', 'on'=>'e.id = p.id_event'),
	array('type'=>'INNER JOIN', 'table'=>'7_sgc_standard s', 'on'=>'s.val_stand = p.standard_partp')
);
$where = array(
	array('column'=>'e.id_user', 'operator'=>'='),
	array('column'=>'e.active', 'operator'=>'=', 'condition'=>'AND'),
	array('column'=>'p.active', 'operator'=>'=', 'condition'=>'AND')
);
$list_query = $page->make_select('p.*, e.name, s.option_stand', '7_sgc_participants p', $inner, $where);
$list_query .= $page->construct_select_order('p.id_partp');
$types_query = 'sss';
$params_query = array($_SESSION['user']['id'], '1', '1');

$list->define_list_sql(array('query'=>$list_query, 'types'=>$types_query, 'params'=>$params_query, 'id'=>'id_partp', 'pagination'=>$pagination, 'limit'=>def_limit_list,'generic_name'=>'participants'));
$list->execute_list_sql();
$return_list = array('name', 'name_partp', 'email_partp', 'option_stand');
$header_list = array('Evento', 'Nome', 'E-mail', 'Qualidade');
$d = $list->return_list_sql($return_list, true, array('date_partp'));
$h = $list->add_button_list($header_list);

$table = new FPHP_page_table();
$table->define_table_head($h);
$table->define_table_data($d);
$table->generate_fast_table();

$list->add_nav_pagination(false, true);

/*var_dump($_SESSION['user']);*/

?>

				</div>
			</div>
		</div> <!-- /panel -->
		
	</div>

</div> <!-- /container -->

<?php require_once('../../php/page_content/bottom.php'); ?>