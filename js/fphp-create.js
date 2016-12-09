$(function(){
	
	var $form = $('#fphp_form_create');
	var $inputs = $form.find(':input[type!="submit"]');
	var json_rules_create = json_rules_form($inputs);
	/* console.debug('Validando..');
	console.debug(json_rules_create); */
	$form.validate({
		rules: json_rules_create,
		submitHandler: function(form){
			var table = $form.attr('name');
			var url_function = get_master_url()+'/php/crud/create_function.php';
			var json_create = json_field_value($inputs, true);
			/* console.debug('Enviando Create..');
			console.debug(table);
			console.debug(json_create);
			console.debug(url_function); */
			$.post(url_function, {table:table, json_create:json_create}, function(resp){
				if(resp == 'true') alert_master('#success_create', false);
				else alert_master('#danger_create', '<strong>Inclusão nao realizada!</strong> Dados inconsistentes.<br/>Entre em contato com o técnico.<br/>'+resp);
			});

			return false;
		}
	});
	
});

