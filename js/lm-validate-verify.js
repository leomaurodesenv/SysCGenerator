$(document).ready(function(){
	/* Faz a requisição do Verify */
	$('form').validate({
		rules:{
			input_code:{
				required:true,
				number: true
			},
			input_verify:{
				required:true,
				minlength:12
			}
		},
		messages:{
			input_code:{
				number: 'Apenas números.'
			},
			input_verify:{
				minlength:$.validator.format("O código deve ter {0} caracteres.")
			}
		},
		submitHandler: function(form){
			load_in();
			$.post("./php/veirfy.php", {input_code:$('#input_code').val(), input_verify:$('#input_verify').val()}, function(resp){
				load_out();
				if(resp!='false') $('#validate-data').html(resp);
				else{$('#verify-error').slideDown(); $('#validate-data').html('');}
			});
			return false;
			
		}
	});
	
});