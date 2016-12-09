$(function(){
	
	var $form = $('#fphp_form_update');
	var $inputs = $form.find(':input[type!="submit"]');
	var json_rules_update = json_rules_form($inputs);
	$form.validate({
		rules: json_rules_update,
		submitHandler: function(form){
			var table = $form.data('table');
			var id = $form.data('id');
			var id_column = $form.data('id_column');
			var url_function = get_master_url()+'/php/crud/update_function.php';
			var json_update = json_field_value($inputs, false);
			$.post(url_function, {id_column:id_column, id:id, table:table, json_update:json_update}, function(resp){
				if(resp == 'true') alert_master('#success_update', false);
				else alert_master('#danger_update', '<strong>Atualização não realizada!</strong> Dados inconsistentes.<br/>Entre em contato com o técnico.<br/>'+resp);
			});
			return false;
		}
	});

});

