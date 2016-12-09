$(document).ready(function(){
	/* Faz a requisição do login */
	$('form').validate({
		rules: {
			input_login: 'required',
			input_pass: 'required'
		},
		submitHandler: function(form){
			$.post("./php/connection/login.php", {input_login:$('#input_login').val(), input_pass:$('#input_pass').val()}, function(resp){
				if(resp=='true') $(window.document.location).attr('href', './index.php');
				else{
					$('#input_pass').val('').focus();
					$('#login-error').slideDown();
				}
			});
			return false;
		}
	});
	
});