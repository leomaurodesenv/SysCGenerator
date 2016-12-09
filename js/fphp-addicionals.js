$(function(){
	/* Adiciona o tooltip */
	$('[data-toggle="tooltip"]').tooltip();
	
	/* Adiciona o efeito do sidebar/active */
	var active_element = $('.nav-sidebar').find('li.active').parent('.collapse');
	active_element.removeClass('collapse').addClass('collapse in');
	change_caret(active_element);
	$('.nav-sidebar').find('.subnivel').on({
		'show.bs.collapse':function(){change_caret($(this));}, 
		'hide.bs.collapse':function(){change_caret($(this));}
	});

	/* Editando o evento de fechar dos alerts */
	$("[data-hide]").on("click", function(){
        $(this).closest("#"+$(this).attr("data-hide")).hide('slow');
    });
	
});

function change_caret($this){
	var href = $this.attr('id');
	var it = $('a[href="#'+href+'"]').find('.fa');
	if(it.hasClass('fa-caret-up')) it.removeClass('fa-caret-up').addClass('fa-caret-down');
	else it.removeClass('fa-caret-down').addClass('fa-caret-up');
}

function get_current_url(get_elements){
	if(get_elements){
		return window.location.href;
	}
	else{
		var pathname = window.location.pathname;
		var url = window.location.origin;
		return url+pathname;
	}
}

/*
function get_master_url(code){
	if(code == 2) return (window.config_ini.path_online + window.config_ini.path_pages);
	else return (window.config_ini.path_online);
}
*/

function redirect_url(url){
	if(url != false) window.location.href = url;
}

function alert_master(element, msg){
	if(msg) $(element).find('span').html(msg);
	$(element).hide().show('slow');
}

function confirm_master(msg){
	var resp = confirm(msg);
	return resp;
}

function exist_var(my_var){
	if(!$.isEmptyObject(my_var) && my_var != false)
		return true;
	else
		return false;
}

/* --------------------------------------------------------- */
/* Modificar funcao */
function exist_file(url){

	var client = new XMLHttpRequest();
	client.open("GET", url, false);
	client.send();
	return (client.status != 404 && client.status != 0);
	
}
/* --------------------------------------------------------- */

function json_rules_form($inputs){
	var json_r = {};
	$inputs.each(function(){
		var name_input = $(this).attr('name');
		var valid_rules = $(this).data('validate');
		/* console.log(valid_rules); */
		if(valid_json_rules(valid_rules)){
			json_r[name_input] = json_rules_input($(this));
		}
	});
	return json_r;
}

function json_rules_input($this){
	var valid_rules = $this.data('validate');
	return $.extend(true, {}, valid_rules);
}

function valid_json_rules(valid_input){
	/*return (!$.isNumeric(valid_input));*/
	return (typeof valid_input == 'object');
}

function json_field_value($inputs, clear){
	var json_r = [];
	$inputs.each(function(){
		var value = $(this).val();
		var field = $(this).data('field');
		var item = {};
		item['field'] = field;
		item['value'] = value;
		json_r.push(item);
		if(clear) $(this).not('[disabled]').val('');
	});
	return json_r;
}