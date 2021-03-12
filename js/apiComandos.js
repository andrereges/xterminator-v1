$(document).ready(function(){
	
	getComandos();

	function getComandos() {
		$.ajax({
			url: "http://localhost:8000/api/v1/getComandos",  
			cache: false,
			method: 'POST',
			headers: {
				"Accept": "application/json",
				"Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMmNkMDdkZTVhYjg4M2Y5M2U0YTkzMDgzOWEwMTBlNDgzM2ViNzFkMjQ5N2JkZmU1NDg4NGY2OTBiZjcxMTljMzM5ODdlOTFlZTNjMzdkNzgiLCJpYXQiOjE1NzQzNDcxMTIsIm5iZiI6MTU3NDM0NzExMiwiZXhwIjoxNjA1OTY5NTEyLCJzdWIiOiI0Iiwic2NvcGVzIjpbXX0.jQnuNocu2nBNk29-Gc-nuR1FykB1fVKBU1haeAKT4zvsG3vUkybgCU6bTFow4DtU0aEworDets-6PoC3ih1UtUc962XsIAN_LJySO_452WFtJiQ66Y8sUSYVDAgagnfbf41m7YSwhxVI5RqKT72TmtbqQR_d_tqyCT2MDPH2ofEgY-YZ-8y66Y_gyIY0BTS8XPWMhpIYupW7r8cY1SuOdCDsx2hvbkUXeozUVNinQ5aRrQb1Wj6VcjHpy3yGIRuqnfzrMxBS6IY16ec8regMAGvzSP8zn6BewoSFag_0bagJml5p2x_PyVwXiRz2FqT9j5HsR2LzkneMeyFlku8I0XayfD6AGk6Y_8lgBEQtEmfpEEBGQM5X8iUTRk4huZGtRDmX0_PuX2zFnCQa9GADcNtzPN4JXYoQWaXugjlQMXg4O8UCwU7oNJ2GnyGQXI5Csi8xe2Ya1JXfK7XonVTZESUUPB9pw63TmeoD-qOa8DOEVGgpvP38uEbSv8jH6qyz4iVMpQJuEzbR0cT145iDNB9bGYmKHEcGg2Oj-RrCk_V_5sxcbrEhfqxrB2ROHkhzjvQU4PH08SzHPMYa3s-BRbD132siqg9M_jqnSJ_CnrYIZPgDkrsB061FD66hyKOMYzKGbLkzjmsv_GnFP91TATrXhNHarQ9-yKLxgkmdksQ"
			},
			data: {},
			dataType: 'text',
			success: function(data) {
				data = JSON.parse(data);
				elementos = '';
				$.each(data, (index, elemento) => elementos += `<p>${elemento}</p>`);
				$('#comandos').html(elementos);
			},
			error: function(xhr, status, error) {
				$('#mensagem').html(error);
			},
			complete: function() {
				$('#mensagem').html('');
			}
	  	});
	}
});
