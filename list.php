<?php 
/* Incluir */
require_once('./php/class_loader.php');
require_once('./php/page_content/top.php'); 

/* Função para carregar certificados */
$sql_inst = new mysqli_instruction;
$mysqli = $sql_inst->con_mysqli();
$query = 'SELECT `event_certificate`,`id` FROM `7_sgc_event` WHERE `active`=1 ORDER BY id ASC;';
$resp = $sql_inst->select_mysqli($query);

/* Cria lista de cert */
$list_li = '<ul class="list-group">';
if($resp != false && !is_null($resp))
	foreach($resp as $key => $value) $list_li .= '<li class="list-group-item"><span class="false-link to_students" data-id="'.$value['id'].'">'.$value['event_certificate'].'</span></li>';
$list_li .= '</ul>';

/* Encerra sql */
$sql_inst->end_con_sql();
?>

<div class="body container">

	<div class="row">

		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Listagem de Eventos</h3>
				</div>
				<div class="panel-body">
				
					<p>Esta seção apresenta todos os eventos que utilizaram este sistema.</p>
					<p>Ao clicar no evento uma lista de todos os participantes aparecerá.</p>
					
					<hr/>
					
					<div class="row">
						<div class="col-lg-6">
							<p class="false-title">Lista de Eventos</p>
							<?php echo $list_li; ?><br/>
						</div>
						<div class="col-lg-6" id="students-data"></div>
					</div>
					
				</div>
			</div>
		</div> <!-- /infos-verify -->
		
	</div>

</div> <!-- /container -->

<script type="text/javascript" src="<?php echo def_path_online; ?>/js/lm-validate-list.js"></script>

<?php require_once('./php/page_content/bottom.php'); ?>