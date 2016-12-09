<?php 
/* Incluir */
require_once('./php/class_loader.php');
require_once('./php/page_content/top.php'); 
?>

<div class="body container">

	<div class="row">
		<div class="col-lg-4"></div>
		<div class="col-lg-4">
			<form method="post" action="#">
				<fieldset>
					<legend><i class="fa fa-sign-in"></i> Login</legend>
					<div class="row">
					<div class="col-lg-2">
						<label for="input_login" class="control-label">User</label>
					</div>
					<div class="col-lg-10">
						<input type="text" class="form-control" maxlength="25" id="input_login" name="input_login" placeholder="Usuário" autofocus/>
					</div>
					</div>
						
					<div class="row">
					<div class="col-lg-2">
						<label for="input_pass" class="control-label">Pass</label>
					</div>
					<div class="col-lg-10">
						<input type="password" class="form-control" maxlength="25" id="input_pass" name="input_pass" placeholder="Senha"/>
					</div>
					</div>
					<div class="row">
					<div class="col-lg-2"></div>
					<div class="col-lg-10">
						<button type="submit" class="btn btn-default" id="submit">Entrar</button>
					</div>
					</div>

					<div class="row">
					<div class="col-lg-2"></div>
					<div class="col-lg-10">
						<div class="alert alert-danger fade in" id="login-error" style="display:none;" role="alert">
							<button type="button" class="close" data-hide="login-error" aria-hidden="true">&times;</button>
							<strong>Error!</strong> Usuário e/ou senha errado(s).
						</div> <!-- /alert error -->
					</div>
					</div>					

				</fieldset>
			</form>
		</div> <!-- /login -->
		<div class="col-lg-4"></div>
	</div>

</div> <!-- /container -->

<script src="<?php echo def_path_online; ?>/js/lm-validate-login.js"></script>

<?php require_once('./php/page_content/bottom.php'); ?>