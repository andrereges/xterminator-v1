function mensagemAlerta(tipo, messagem, timeout = true) {
	let alerta = $('#alerta');
	limpaAlerta();

	switch (tipo) {
		case 'primary':
			alerta.addClass('alert-primary');
			break;
		case 'success':
			alerta.addClass('alert-success');
			break;
		case 'warning':
			alerta.addClass('alert-warning');
			break;
		case 'error':
			alerta.addClass('alert-danger');
			break;
		default:
			console.log('Erro no tipo de alerta.');
	}

	alerta
		.html(messagem)
		.show();

	if (timeout) {
		setTimeout(() => limpaAlerta(), TIMEOUT_ALERTA);
	}	
}

function limpaAlerta() {
	$('#alerta')
		.removeClass(['alert-primary', 'alert-success', 'alert-warning', 'alert-danger'])
		.hide();
}

function mostraConsole(texto) {
	$('#frame').contents().find("div").html(texto);
}