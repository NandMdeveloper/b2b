$(function() 
{
	// ocultamos todos los campos
	$('ul li').hide();

	// mostramos sólo el primero
	$("ul li:first").show();

	// creamos una expresión regular para validar el email
	var verificarEmail = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	
	// validar el email
	$('#txtEmail').keyup(function() {
		var campo = $(this);
		var email = campo.val();

		if (!verificarEmail.test(email)) {
			agregarError(campo);
		}
		else {
			quitarError(campo);
		}
	});

	// validar password
	$('#txtPassword').keyup(function() {
		var campo = $(this);
		var caracteres = campo.val().length;

		if (caracteres < 8) {
			agregarError(campo);
		}
		else {
			quitarError(campo);
		}
	});
})

function agregarError (campo) {
	campo.addClass("error");
}

function quitarError (campo) {
	campo.removeClass("error");

	// buscamos el elemento li padre del campo
	campo.parent().parent().next().show()
}