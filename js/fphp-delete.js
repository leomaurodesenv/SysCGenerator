$(document).ready(function(){
	
	var $groups_delete = $('#groups_delete_0');
	var $btn_delete = $('#fphp_delete_btn');
	var $btn_del_confirm = $('#fphp_delete_confirm');
	var $btn_del_cancel = $('#fphp_delete_cancel');
	
	$btn_delete.on('click', function(){
		$('#groups_delete_1').hide();
		$groups_delete.slideDown('slow');
		return false;
	});
	
	/*$btn_del_cancel.on('click', function(){
		$btn_delete.slideDown('slow');
		$groups_delete.hide();
		return false;
	});*/
	
	$btn_del_confirm.on('click', function(){
		var url_function = get_master_url()+'/php/crud/delete_function.php';
		var delete_data = {};
		delete_data['id'] = $(this).data('id');
		delete_data['id_column'] = $(this).data('id_column');
		delete_data['table'] = $(this).data('table');
		delete_data['in_table'] = $(this).data('in_table');
		delete_data['in_table_column'] = $(this).data('in_table_column');
		/*console.debug(delete_data);*/
		$.post(url_function, {delete_data:delete_data}, function(resp){
			if(resp == 'true'){
				$groups_delete.remove();
				alert_master('#success_delete', false);
			}
			else alert_master('#danger_delete', '<strong>Exclusao nao realizada!</strong> Entre em contato com o técnico.<br/>'+resp);
		});
		return false;
	});
	
});