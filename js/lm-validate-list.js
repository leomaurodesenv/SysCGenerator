$(document).ready(function(){
	/* Faz a requisição do Verify */
	$('.to_students').click(function(){
		load_in();
		$.post("./php/list.php", {id:$(this).data('id')}, function(resp){
			$('#students-data').html(resp);
			load_out();
		});
	});
	
});