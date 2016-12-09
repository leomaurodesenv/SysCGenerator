$(function(){

	/* Renomeia todos os inputs e grids existentes */
	var count_grid = 1;
	var $form = $('#fphp_form_create_grid');
	$form.find("table tbody tr").each(function(i){
		var name_grid = 'grid_'+count_grid;
		$(this).attr('id', name_grid);
		rename_inputs_grid($(this), false);
		count_grid++;
	});
	
	/* Função de deletar a linha grid */
	$('[href="#delete_grid"]').bind('click', function(){
		delete_grid($(this));
	});
	
	/* Função de inclusão de novos grids */
	$('#new_grid').on('click', function(){
		var count_trs = $("#fphp_form_create_grid table tbody tr").size();
		if(count_trs < 10){
			var tr_data = $('#grid_elements tr').html();
			var name_grid = 'grid_'+count_grid;
			$('#fphp_form_create_grid table tbody').append('<tr id="'+name_grid+'">'+tr_data+'</tr>')
			$('#'+name_grid+' [href="#delete_grid"]').bind('click', function(){
				delete_grid($(this));
			});
			rename_inputs_grid($('#'+name_grid), true);
			count_grid++;
		}
		else{
			alert_master('#info_create_grid', '<strong>Error!</strong> Não é possível inserir mais de 10 registros por vez.');
		}
	});
	
	/* Validação do formulário */
	var json_rules_create_grid = json_rules_form($form.find(':input[type!="submit"]'));
	$form.validate({
		rules: json_rules_create_grid,
		submitHandler: function(form){
			var json_create_grid = {};
			var table = $form.attr('name');
			var url_function = get_master_url()+'/php/crud/create_grid_function.php';
			var $form_trs = $("#fphp_form_create_grid table tbody tr");
			var count_trs = $form_trs.size();
			if(count_trs){
				$form_trs.each(function(i){
					json_create_grid[i] = json_field_value($(this).find(':input'), true);
				});
				/* console.log(json_create_grid); */
				$.post(url_function, {table:table, json_create_grid:json_create_grid}, function(resp){
					if(resp == 'true') alert_master('#success_create_grid', false);
					else alert_master('#danger_create_grid', '<strong>Inclusão nao realizada!</strong> Dados inconsistentes.<br/>Entre em contato com o técnico.<br/>'+resp);
				});
			}
			else{
				alert_master('#danger_create_grid', '<strong>Error!</strong> Não há nenhum registro para ser incluído.');
			}
			return false;
		}
	});
	
});


function delete_grid($this){
	$this.closest('tr').remove();
}

function rename_inputs_grid($this, validate){
	var name_grid = $this.attr('id');
	$this.find(':input').each(function(j){
		var name_input = name_grid+'_input_'+(j+1);
		$(this).attr('name', name_input);
		$(this).attr('id', name_input);
		/* Adiciona validação */
		if(validate){
			var valid_rules = $(this).data('validate');
			if(valid_json_rules(valid_rules)){
				var json_r = json_rules_input($(this));
				$(this).rules("add", json_r);
			}
		}
	});
}
