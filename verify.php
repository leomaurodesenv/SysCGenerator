<?php 
/* Incluir */
require_once('./php/class_loader.php');
require_once('./php/page_content/top.php'); 

/* Função para carregar certificados */
$sql_inst = new MYSQLI_instruction;
$mysqli = $sql_inst->con_mysqli();
$query = 'SELECT `event_certificate` FROM `7_sgc_event` WHERE `active`=1  ORDER BY id DESC LIMIT 9;';
$resp = $sql_inst->select_mysqli($query);

/* Cria lista de cert */
$list_li = '<ul class="list-group">';
if($resp != false && !is_null($resp))
	foreach($resp as $key => $value) $list_li .= '<li class="list-group-item">'.$value['event_certificate'].'</li>';
$list_li .= '<li class="list-group-item"><a href="./list.php">Clique aqui para ver a lista completa</a></li>';
$list_li .= '</ul>';

/* Encerra sql */
$sql_inst->end_con_sql();

?>

<div class="body container">

	<div class="row">

		<div class="col-lg-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Autenticação de Certificados</h3>
				</div>
				<div class="panel-body">
				
					<p>Bem vindo ao sistema de validação de certificados!</p>
					<p>Nesta página é possível verificar a autenticidade de certificados gerados por este sistema.</p>
					
					<p><span class="false-link" role="button" data-toggle="collapse" href="#list-certificate" aria-expanded="false" aria-controls="list-certificate" data-target="#list-certificate">Clique aqui para ver os últimos eventos.</span></p>
					<div id="list-certificate" class="collapse"><?php echo $list_li; ?></div>
					
					<hr/>
					
					<div class="row">
						<div class="col-lg-4">
						<form method="post" action="#">
						
							<p><label for="input_code" class="control-label">Numero de Controle</label>
							<input type="text" class="form-control" maxlength="10" id="input_code" name="input_code" placeholder="Número de Controle" autofocus/></p>
							
							<p><label for="input_verify" class="control-label">Autenticação</label>
							<input type="text" class="form-control" maxlength="32" id="input_verify" name="input_verify" placeholder="Autenticação" /></p>
							
							<p><button type="submit" class="btn btn-default" id="submit">Entrar</button></p>
						
							<div class="alert alert-danger fade in" id="verify-error" style="display:none;" role="alert">
								<button type="button" class="close" data-hide="verify-error" aria-hidden="true">&times;</button>
								<strong>Error!</strong> Autenticação inválida.
							</div> <!-- /alert error -->
							
						</form>
						</div>
						
						<div class="col-lg-8" id="validate-data">
							
						</div>
					
					</div>
					
				</div>
			</div>
		</div> <!-- /infos-verify -->
		
	</div>

</div> <!-- /container -->

<script type="text/javascript" src="<?php echo def_path_online; ?>/js/lm-validate-verify.js"></script>

<?php require_once('./php/page_content/bottom.php'); ?>