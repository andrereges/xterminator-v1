function criaMigracao() {
	mensagemAlerta('primary', 'Executando comando. Aguarde...', false);
	$.ajax({
		url: `${URL_SERVER}`,  
		cache: false,
		method: 'POST',
		data: {
			rota: "comando",
			comando: "docker exec php-fpm5.6 bash -c 'cd /var/www/html/grp3 && php bin/console doc:mi:ge'"
		},
		dataType: 'text',
		success: function(data) {
			mostraConsole(data);
			mensagemAlerta('success', 'Sucesso. Migração criada!');
		},
		error: function(xhr, status, error) {
			mensagemAlerta('error', error);
		}
	});
}

function restartDocker() {
	mensagemAlerta('primary', 'Executando comando. Aguarde...', false);
	$.ajax({
		url: `${URL_SERVER}`,  
		cache: false,
		method: 'POST',
		data: {
			rota: "comando",
			comando: "cd /var/dockers/LLIEGE-GRP/ && docker-compose up -d"
		},
		dataType: 'text',
		success: function(data) {
			mostraConsole(data);
			mensagemAlerta('success', 'Sucesso. Container reiniciado!');
		},
		error: function(xhr, status, error) {
			mensagemAlerta('error', error);
		}
	});
}

function rodaMigracao() {
	mensagemAlerta('primary', 'Executando comando. Aguarde...', false);
	$.ajax({
		url: `${URL_SERVER}`,  
		cache: false,
		method: 'POST',
		data: {
			rota: "comando",
			comando: "docker exec php-fpm5.6 bash -c 'cd /var/www/html/grp3 && php bin/console --no-interaction doc:mi:mi'"
		},
		dataType: 'text',
		success: function(data) {
			mostraConsole(data);
			mensagemAlerta('success', 'Sucesso. Migração executada!');
		},
		error: function(xhr, status, error) {
			mensagemAlerta('error', error);
		}
	});
}

function rollbackMigracao() {
	let rollbackCodigo = $('#rollbackCodigo');
	rollbackCodigo.prop('required', 'required');

	if (rollbackCodigo.val() == '') {
		mensagemAlerta('error', 'Campo código da migração é obrigatório');
		return;
	}

	mensagemAlerta('primary', 'Executando comando. Aguarde...', false);
	$.ajax({
		url: `${URL_SERVER}`,  
		cache: false,
		method: 'POST',
		data: {
			rota: "comandoComParamentro",
			comando: "docker exec php-fpm5.6 bash -c 'cd /var/www/html/grp3 && php bin/console doc:mi:exec %valorAuxiliar% --down'",
			valorAuxiliar: rollbackCodigo.val()
		},
		dataType: 'text',
		success: function(data) {
			mostraConsole(data);
			mensagemAlerta('success', 'Sucesso. A migração informada foi revertida!');
		},
		error: function(xhr, status, error) {
			mensagemAlerta('error', error);
		}
	});
}

function trocaBanco() {
	mensagemAlerta('primary', 'Executando comando. Aguarde...', false);
	$.ajax({
		url: `${URL_SERVER}`,  
		cache: false,
		method: 'POST',
		data: {
			rota: 'trocaBanco',
			comando: $('#select_banco').val()
		},
		dataType: 'text',
		success: function(data) {
			mostraConsole(data);
			mensagemAlerta('success', 'Sucesso. Trocado banco de dados!');
		},
		error: function(xhr, status, error) {
			mensagemAlerta('error', error);
		}
	});
}

function restauraBanco() {
	mensagemAlerta('primary', 'Executando comando. Aguarde...', false);
	
	$.ajax({
		url: `${URL_SERVER}`,  
		cache: false,
		method: 'POST',
		data: {
			rota: 'restauraBanco',
			comando: {
				'banco_nome': $('#banco_nome').val(),
				'arquivo_caminho': $('#arquivo_caminho').val(),
				'select_banco_restauracao': $('#select_banco_restauracao').val()
			}
		},
		dataType: 'text',
		success: function(data) {
			mostraConsole(data);
			mensagemAlerta('success', 'Sucesso. Restaurado banco de dados!');
		},
		error: function(xhr, status, error) {
			mensagemAlerta('error', error);
		}
	});
}

function push() {
	let commitMensagem = $('#commitMensagem');
	commitMensagem.prop('required', 'required');

	if (commitMensagem.val() == '') {
		mensagemAlerta('error', 'Campo commit mensagem é obrigatório');
		return;
	}

	mensagemAlerta('primary', 'Executando comando. Aguarde...', false);
	$.ajax({
		url: `${URL_SERVER}`,  
		cache: false,
		method: 'POST',
		data: {
			rota: "push",
			valorAuxiliar: commitMensagem.val()
		},
		dataType: 'text',
		success: function(data) {
			mostraConsole(data);
			mensagemAlerta('success', 'Sucesso. Push efetuado!');
		},
		error: function(xhr, status, error) {
			mensagemAlerta('error', error);
		}
	});
}

function showLog() {
	mensagemAlerta('primary', 'Executando comando. Aguarde...', false);

	$.ajax({
		url: `${URL_SERVER}`,  
		cache: false,
		method: 'POST',
		data: {
			rota: "showLog",
			options: $('#options').val(),
			showDate: $('#showDate').val()
		},
		dataType: 'text',
		success: function(data) {
			mostraConsole(data);
			mensagemAlerta('success', 'Sucesso. Logs na tela!');	
		},
		error: function(xhr, status, error) {
			mensagemAlerta('error', error);
		}
	});
}

function clearLog() {
	mensagemAlerta('primary', 'Executando comando. Aguarde...', false);

	$.ajax({
		url: `${URL_SERVER}`,  
		cache: false,
		method: 'POST',
		data: {
			rota: "clearLog"
		},
		dataType: 'text',
		success: function(data) {
			mostraConsole(data);
			mensagemAlerta('success', 'Sucesso. Log limpo!');
		},
		error: function(xhr, status, error) {
			mensagemAlerta('error', error);
		}
	});
}

function exportLog() {
	mensagemAlerta('primary', 'Executando comando. Aguarde...', false);

	$.ajax({
		url: `${URL_SERVER}`,  
		cache: false,
		method: 'POST',
		data: {
			rota: "exportLog",
			options: $('#options').val(),
			showDate: $('#showDate').val()
		},
		dataType: 'text',
		success: function(data) {
			mostraConsole(data);
			mensagemAlerta('success', 'Sucesso. Arquivo criado em /home/xterminator');
		},
		error: function(xhr, status, error) {
			mensagemAlerta('error', error);
		}
	});
}