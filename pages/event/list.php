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
					<h3 class="panel-title">Eventos</h3>					
				</div>
				<div class="panel-body">
					<p>Bem-vindo <?php echo $_SESSION['user']['name_user']; ?>, da instituição <?php echo $_SESSION['user']['institution_user']; ?>.</p>
					<p>E-mail: <?php echo $_SESSION['user']['email_user']; ?> &nbsp; / &nbsp; Telefone: <?php echo $_SESSION['user']['phone_user']; ?></p>
					<p>Página destinada a administração dos certificados dos eventos.</p>
					<br/>
					
<?php

$pagination = (isset($_GET['page'])) ? $_GET['page'] : 1;
$list = new FPHP_page_list(array('read'=>true,'update'=>true,'delete'=>true,'create'=>true));

$inner = array(
	array('type'=>'INNER JOIN', 'table'=>'7_sgc_user u', 'on'=>'e.id_user = u.id'),
	array('type'=>'INNER JOIN', 'table'=>'7_sgc_layout l', 'on'=>'e.layout_certificate = l.val_layout')
);
$where = array(
	array('column'=>'e.id_user', 'operator'=>'='),
	array('column'=>'e.active', 'operator'=>'=', 'condition'=>'AND')
);
$list_query = $page->make_select('e.*, l.option_layout', '7_sgc_event e', $inner, $where);
$types_query = 'ss';
$params_query[] = $_SESSION['user']['id']; $params_query[] = '1';

$list->define_list_sql(array('query'=>$list_query, 'types'=>$types_query, 'params'=>$params_query, 'id'=>'id', 'pagination'=>$pagination, 'limit'=>def_limit_list,'generic_name'=>'event'));
$list->execute_list_sql();
$return_list = array('name', 'event_certificate' ,'owner_certificate', 'option_layout', 'date');
$header_list = array('Sigla', 'Evento', 'Responsável', 'Layout', 'Data');
$d = $list->return_list_sql($return_list, true, array('date'));
$h = $list->add_button_list($header_list);

$table = new FPHP_page_table();
$table->define_table_head($h);
$table->define_table_data($d);
$table->generate_fast_table();

$list->add_nav_pagination(false);

/*var_dump($_SESSION['user']);*/

?>
				
				</div>
			</div>
		</div> <!-- /infos-verify -->
		
	</div>

</div> <!-- /container -->

<?php require_once('../../php/page_content/bottom.php'); ?>