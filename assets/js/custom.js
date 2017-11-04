$(function($){

	$("#cpf").mask("999.999.999-99");

	$(".form_validation").submit(function( event ) {
	 	if ($('#cpf').val() == '') {
	 		alert("Por favor preencha o CPF.");
	 		var error = true;
	 	} else if ($('#name').val() == '') {
	 		alert("Por favor preencha o nome.");
	 		var error = true;
	 	} else if ($('#dt_nasc').val() == '') {
	 		alert("Por favor preencha a data de nascimento.");
	 		var error = true;
	 	}
	 	if (error) {
	 		event.preventDefault();
	 	}
	});

});