/* Starts starts accounting */
/* Starts validacion de formulario starts accounting */
const inputs = document.querySelectorAll('#formStartsAccounting input');
const expresiones = {
	cuota: /^\d.{1,7}$/,
}

const campos = {
	InputValor: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "InputValor":
			validarCamposForm(expresiones.cuota, e.target, 'labelValor', 'InputValor', 'leyenda-Valor');
		break;
	}
}

const validarCamposForm = (expresion, input, label, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		document.getElementById(`${label}`).classList.remove('text-danger');
		campos[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		document.getElementById(`${label}`).classList.add('text-danger');
		campos[id_input] = false;
	}
}

inputs.forEach((input) => {
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});

function cleanResiduoVali() {
	var ocuLeyenda = document.querySelectorAll('.labelForm');	
	ocuLeyenda.forEach.call(ocuLeyenda, c => {
		c.classList.remove('text-danger');
	});
	var ocuLeyenda = document.querySelectorAll('.inputForm');	
	ocuLeyenda.forEach.call(ocuLeyenda, c => {
		c.classList.remove('invalid');
	});
	var ocuLeyenda = document.querySelectorAll('.leyenda');	
	ocuLeyenda.forEach.call(ocuLeyenda, c => {
		c.classList.add('none-block');
	});
}
/* Finish validacion de formulario starts accounting */
//Cargar los datos del la base de datos al la tabla iniciar contabilidad
var DataTableStartsAccounting;
var DataTableAccounting;
document.addEventListener('DOMContentLoaded', function () {

	DataTableStartsAccounting = $('#DataTableIC').DataTable({ /*ID de la tabla*/
		"aProcessing": true,
		"aServerside": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax": {
			"url": BASE_URL + "accounting/getAllStudents",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "id_student" },
			{ "data": "DNI" },
			{ "data": "estudiante" },
			{ "data": "Acciones" },
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});

	//Cargar los datos del la base de datos al la tabla detener contabilidad

	DataTableAccounting = $('#DataTableCI').DataTable({ /*ID de la tabla*/
		"aProcessing": true,
		"aServerside": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax": {
			"url": BASE_URL + "accounting/getAllAccounting",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "id_accounting" },
			{ "data": "estudiante" },
			{ "data": "Fecha_inicio-final" },
			{ "data": "Ultimo_pago" },
			{ "data": "Proximo_pago" },
			{ "data": "cuota" },
			{ "data": "V_cuota" },
			{ "data": "Acciones" },
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});



	//Starts accounting 
	var formStartsAccounting = document.querySelector("#formStartsAccounting");
	formStartsAccounting.onsubmit = function (e) {
		e.preventDefault();
		var id_student = document.querySelector('#id_student').value;
		var InputCuota = document.querySelector('#InputCuota').value;
		var InputValor = document.querySelector('#InputValor').value;
		var InputFechaFC = document.querySelector('#InputFechaFC').value;

		if (id_student == '' || InputCuota == '' || InputValor == '' || InputFechaFC == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!campos.InputValor) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}

		divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'accounting/setAccounting';
		var formData = new FormData(formStartsAccounting);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					$('#ModalFormStartsAccounting').modal('hide');
					formStartsAccounting.reset();
					DataTableStartsAccounting.ajax.reload();
					DataTableAccounting.ajax.reload();
				} else {
					swal("¡Atención!", objData.msg, "warning");
				}
			}
			divLoading.style.display = "none";
            return false;
		}
	}

});

//Function form starts accounting
function FctBtnStartsAccounting(id_student) {
	var id_student = id_student;
	document.querySelector('#id_student').value = id_student;
	document.querySelector("#formStartsAccounting").reset();
	cleanResiduoVali();
	$('#ModalFormStartsAccounting').modal('show');
} 

/* Finish starts accounting */

/* Starts stopt accounting */

function FctBtnStopAccounting(id_student, periodo) {
	var id_student = id_student;
	var periodo = periodo;
	swal({
		title: "¡Detener Contabilidad!",
		text: "¿Estas seguro que deceas detener la contabilidad?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Detener",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			swal.close();
			divLoading.style.display = "flex";
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'accounting/stopAccounting/';
			var data = 'id_student=' + id_student + '&' + 'periodo=' + periodo;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Contabilidad!", objData.msg, "success");
						DataTableStartsAccounting.ajax.reload();
						DataTableAccounting.ajax.reload();
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
				divLoading.style.display = "none";
            	return false;
			}
		}
	});
} 

function FctBtnPauseAccounting(id_student, periodo) {
	var id_student = id_student;
	var periodo = periodo;
	swal({
		title: "¡Pausar Contabilidad!",
		text: "¿Deceas pausar temporalmente la contabilidad?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Pausar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			swal.close();
			divLoading.style.display = "flex";
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'accounting/PauseAccounting/';
			var data = 'id_student=' + id_student + '&' + 'periodo=' + periodo;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Contabilidad!", objData.msg, "success");
						DataTableAccounting.ajax.reload();
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
				divLoading.style.display = "none";
            	return false;
			}
		}
	});
}

function FctBtnPlayAccounting(id_student, periodo) {
	var id_student = id_student;
	var periodo = periodo;

	divLoading.style.display = "flex";
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'accounting/PlayAccounting/';
	var data = 'id_student=' + id_student + '&' + 'periodo=' + periodo;
	request.open("POST", ajaxUrl, true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send(data);

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				swal("¡Contabilidad!", objData.msg, "success");
				DataTableAccounting.ajax.reload();
			} else {
				swal("ERROR!", objData.msg, "error");
			}
		}
		divLoading.style.display = "none";
    	return false;
	}
}
/* Finish stopt accounting */