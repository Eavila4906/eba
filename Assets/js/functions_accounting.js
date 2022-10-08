$(document).ready(function () {
	if (document.querySelector('#module-accounting')) {
		document.querySelector('#module-accounting').classList.add('is-expanded');
		if (document.querySelector('#icon-contabilidad')) {
            document.querySelector('#icon-contabilidad').classList.replace('fa-circle-o', 'fa-circle');
            document.querySelector('#icon-contabilidad').classList.add('text-primary');
        }
	}
});

/* Starts starts accounting */
/* Starts validacion de formulario starts accounting */
const inputs = document.querySelectorAll('#formStartsAccounting input');
const inputs2 = document.querySelectorAll('#formTotalPurchaseAccounting input');
const expresiones = {
	cuota: /^\d.{1,7}$/,
}

const campos = {
	InputValor: false
}

const campos2 = {
	InputValorTP: false
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

const validarFormulario2 = (e) => {
	switch (e.target.name) {
		case "InputValorTP":
			validarCamposForm2(expresiones.cuota, e.target, 'labelValor-TP', 'InputValorTP', 'leyenda-Valor-TP');
		break;
	}
}

const validarCamposForm2 = (expresion, input, label, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		document.getElementById(`${label}`).classList.remove('text-danger');
		campos2[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		document.getElementById(`${label}`).classList.add('text-danger');
		campos2[id_input] = false;
	}
}

inputs2.forEach((input) => {
	input.addEventListener('keyup', validarFormulario2);
	input.addEventListener('blur', validarFormulario2);
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
var DataTableInactiveAccounting;
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

	DataTableAccounting = $('#DataTableCA').DataTable({ /*ID de la tabla*/
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
			{ "data": "DNI" },
			{ "data": "estudiante" },
			{ "data": "fechaNaci" },
			{ "data": "Fecha_inicio-final" },
			{ "data": "Ultimo_pago" },
			{ "data": "Proximo_pago" },
			{ "data": "Acciones" },
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});

	DataTableInactiveAccounting = $('#DataTableCI').DataTable({ /*ID de la tabla*/
		"aProcessing": true,
		"aServerside": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax": {
			"url": BASE_URL + "accounting/getAllInactiveAccounting",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "id_accounting" },
			{ "data": "DNI" },
			{ "data": "estudiante" },
			{ "data": "periodos" },
			{ "data": "Acciones" },
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[3, "desc"]] /*Ordenar de forma Desendente*/
	});



	//Starts accounting 
	var formStartsAccounting = document.querySelector("#formStartsAccounting");
	formStartsAccounting.onsubmit = function (e) {
		e.preventDefault();
		var id_student = document.querySelector('#id_student').value;
		var InputCuota = document.querySelector('#InputCuota').value;
		var InputValor = document.querySelector('#InputValor').value;
		var InputFechaFC = document.querySelector('#InputFechaFC').value;
		var InputDescuentoIC = document.querySelector('#InputDescuentoIC').value;

		if (id_student == '' || InputCuota == '' || InputValor == '' || InputFechaFC == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!campos.InputValor) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}
		if ($('#InputADIC').prop('checked') && InputDescuentoIC == 0) {
			swal("¡Atención!", "La opcion aplicar descuento esta activa, por lo tanto debes de aplicar un porcentaje de descuento.", "warning");
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
					swal("¡Contabilidad!", objData.msg, "success");
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

	var formTotalPurchaseAccounting = document.querySelector("#formTotalPurchaseAccounting");
	formTotalPurchaseAccounting.onsubmit = function (e) {
		e.preventDefault();
		var id_studentTP = document.querySelector('#id_student-TP').value;
		var InputValorTP = document.querySelector('#InputValorTP').value;
		var InputFechaInicio = document.querySelector('#InputFechaInicio').value;
		var InputFechaFinal = document.querySelector('#InputFechaFinal').value;

		if (id_studentTP == '' || InputValorTP == '' || InputFechaInicio == '' || InputFechaFinal == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!campos2.InputValorTP) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}
		if ($('#InputAD').prop('checked') && InputDescuentoIC == 0) {
			swal("¡Atención!", "La opcion aplicar descuento esta activa, por lo tanto debes de aplicar un porcentaje de descuento.", "warning");
			return false;
		}

		divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'accounting/setTotalPurchaseAccounting';
		var formData = new FormData(formTotalPurchaseAccounting);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					$('#ModalFormTotalPurchaseAccounting').modal('hide');
					formTotalPurchaseAccounting.reset();
					swal("¡Compra total!", objData.msg, "success");
					DataTableStartsAccounting.ajax.reload();
					DataTableInactiveAccounting.ajax.reload();
				} else {
					swal("¡Atención!", objData.msg, "warning");
				}
			}
			divLoading.style.display = "none";
            return false;
		}
	}

	var formStopAccounting = document.querySelector("#formStopAccounting");
	formStopAccounting.onsubmit = function (e) {
		e.preventDefault();
		var InputJustificacion = document.querySelector('#InputJustificacion').value;

		if (InputJustificacion == '') {
			swal("¡Atención!", "El campo es obligatorio.", "warning");
			return false;
		}

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
				var data = new FormData(formStopAccounting);
				request.open("POST", ajaxUrl, true);
				request.send(data);
	
				request.onreadystatechange = function () {
					if (request.readyState == 4 && request.status == 200) {
						var objData = JSON.parse(request.responseText);
						if (objData.status) {
							$('#ModalFormStopAccounting').modal('hide');
							swal("¡Contabilidad!", objData.msg, "success");
							DataTableStartsAccounting.ajax.reload();
							DataTableAccounting.ajax.reload();
							DataTableInactiveAccounting.ajax.reload();
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

});

//functio date
function initialDate(id) {
	var date = new Date();
	var M = date.getMonth()+1;
	var D = date.getDate();
	var Y = date.getFullYear();
	if (D < 9) {
		D = '0'+D;
	} 
	if (M < 10) {
		M = "0"+M;
	}
	document.querySelector(id).value = Y+"-"+M+"-"+D;
}

function finishDate(id) {
	var date = new Date();
	var M = date.getMonth()+2;
	var D = date.getDate();
	var Y = date.getFullYear();
	if (D < 9) {
		D = '0'+D;
	} 
	if (M < 10) {
		M = "0"+M;
	}
	document.querySelector(id).value = Y+"-"+M+"-"+D;
}

//Function form starts accounting
function FctBtnStartsAccounting(id_student) {
	var id_student = id_student;
	document.querySelector('#id_student').value = id_student;
	document.querySelector("#formStartsAccounting").reset();
	$('#campoDescuentoIC').hide();
	document.querySelector('#InputADIC').value = 0;
	cleanResiduoVali();
	setTimeout(initialDate('#InputFechaIC'), 10);
	setTimeout(finishDate('#InputFechaFC'), 10);
	$('#ModalFormStartsAccounting').modal('show');
} 

function FctBtnTotalPurchaseAccounting(id_student) {
	var id_student = id_student;
	document.querySelector('#id_student-TP').value = id_student;
	document.querySelector("#formTotalPurchaseAccounting").reset();
	$('#campoDescuento').hide();
	document.querySelector('#InputAD').value = 0;
	cleanResiduoVali();
	setTimeout(initialDate('#InputFechaInicio'), 10);
	setTimeout(finishDate('#InputFechaFinal'), 10);
	$('#ModalFormTotalPurchaseAccounting').modal('show');
} 

$(document).ready(function () {
	$('#InputAD').click(function () {
		if ($('#InputAD').is(':checked')) {
			$('#campoDescuento').show('slow');
			document.querySelector('#InputAD').value = 1;
			document.querySelector('#InputDescuento').value = 0;
		} else {
			$('#campoDescuento').hide('slow');
			document.querySelector('#InputAD').value = 0;
		}
	});
});

$(document).ready(function () {
	$('#InputADIC').click(function () {
		if ($('#InputADIC').is(':checked')) {
			$('#campoDescuentoIC').show('slow');
			document.querySelector('#InputADIC').value = 1;
			document.querySelector('#InputDescuentoIC').value = 0;
		} else {
			$('#campoDescuentoIC').hide('slow');
			document.querySelector('#InputADIC').value = 0;
		}
	});
});


function FctBtnStopAccounting(id_accounting, id_student, periodo) {
	document.querySelector('#formStopAccounting').reset();
	document.querySelector('#id_accounting-sa').value = id_accounting;
	document.querySelector('#id_student-sa').value = id_student;
	document.querySelector('#periodo-sa').value = periodo;
	$('#ModalFormStopAccounting').modal('show');
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

function FctBtnSeeDetailAccounting(id_accounting, id_student, periodo, student) {
	document.querySelector('#name-student').innerHTML = student;
	divLoading.style.display = "flex";
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'accounting/getSeeDetailsAccounting/'+id_accounting+"/"+id_student+"/"+periodo;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.descuento != "0%") {
				document.querySelector('#dp-tr-sda').classList.remove('notBlock');
				document.querySelector('#vd-tr-sda').classList.remove('notBlock');
				document.querySelector('#vtd-tr-sda').classList.remove('notBlock');
				document.querySelector('#md-tr-sda').classList.remove('notBlock');

				document.querySelector('#periodo-sda').innerHTML = objData.periodo;
				document.querySelector('#fup-sda').innerHTML = objData.fecha_UP;
				document.querySelector('#fpp-sda').innerHTML = objData.fecha_PP;
				document.querySelector('#cuota-sda').innerHTML = objData.cuota;
				//document.querySelector('#mensualidad-sda').innerHTML = objData.valor_m;
				document.querySelector('#vtp-sda').innerHTML = objData.valor_total;
				document.querySelector('#dp-sda').innerHTML = objData.descuento;
				document.querySelector('#vd-sda').innerHTML = objData.valor_descuento;
				document.querySelector('#vtd-sda').innerHTML = objData.valor_total_descuento;
				document.querySelector('#md-sda').innerHTML = objData.valor_mcd;
				document.querySelector('#descripcion-sda').innerHTML = objData.descripcion;
				document.querySelector('#estado-sda').innerHTML = objData.estado;
			} else {
				document.querySelector('#dp-tr-sda').classList.add('notBlock');
				document.querySelector('#vd-tr-sda').classList.add('notBlock');
				document.querySelector('#vtd-tr-sda').classList.add('notBlock');
				document.querySelector('#md-tr-sda').classList.add('notBlock');

				document.querySelector('#periodo-sda').innerHTML = objData.periodo;
				document.querySelector('#fup-sda').innerHTML = objData.fecha_UP;
				document.querySelector('#fpp-sda').innerHTML = objData.fecha_PP;
				document.querySelector('#cuota-sda').innerHTML = objData.cuota;
				//document.querySelector('#mensualidad-sda').innerHTML = objData.valor_m;
				document.querySelector('#vtp-sda').innerHTML = objData.valor_total;
				document.querySelector('#md-sda').innerHTML = objData.valor_mcd;
				document.querySelector('#descripcion-sda').innerHTML = objData.descripcion;
				document.querySelector('#estado-sda').innerHTML = objData.estado;
			}
			
		}
		divLoading.style.display = "none";
        return false;
	}
	$('#modalSeeDetailsAccounting').modal('show');
}

var DataTableSeeIIA;
function FctBtnSeeIIA(dni, name) {
    var dni = dni;
    var name = name;
    DataTableSeeIIA = $('#DataTableSeeIIA').DataTable({ /*ID de la tabla*/
        "aProcessing": true,
        "aServerside": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
        },
        "ajax": {
            "url": BASE_URL + "accounting/getSeeIIA/"+ dni,/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "periodo_format" },
            { "data": "fecha_UP_format" },
			{"data": "fecha_PP_format" },
            { "data": "Acciones" },
        ],
        "bAutoWidth": false,
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10, /*Mostrará los primero 10 registros*/
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
    document.querySelector('#titleName').innerHTML = name;
    $('#ModalSeeIIA').modal('show');
}

function FctBtnSeeDIIA(periodo, dni, periodo_format) {
	document.querySelector('#periodo-diia').innerHTML = periodo_format;
	divLoading.style.display = "flex";
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'accounting/getSeeDIIA/' + dni + "/" + periodo;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.obs == 0) {
				document.querySelector('#justificacion-tr-sda-diia').classList.add('notBlock');
			} else {
				document.querySelector('#justificacion-tr-sda-diia').classList.remove('notBlock');
			}
			if (objData.descuento != "0%") {
				document.querySelector('#dp-tr-sda-diia').classList.remove('notBlock');
				document.querySelector('#vd-tr-sda-diia').classList.remove('notBlock');
				document.querySelector('#vtd-tr-sda-diia').classList.remove('notBlock');
				document.querySelector('#md-tr-sda-diia').classList.remove('notBlock');

				document.querySelector('#periodo-sda-diia').innerHTML = objData.periodo;
				document.querySelector('#fup-sda-diia').innerHTML = objData.fecha_UP;
				document.querySelector('#fpp-sda-diia').innerHTML = objData.fecha_PP;
				document.querySelector('#cuota-sda-diia').innerHTML = objData.cuota;
				//document.querySelector('#mensualidad-sda-diia').innerHTML = objData.valor_m_DIIA;
				document.querySelector('#vtp-sda-diia').innerHTML = objData.valor_total;
				document.querySelector('#dp-sda-diia').innerHTML = objData.descuento;
				document.querySelector('#vd-sda-diia').innerHTML = objData.valor_descuento;
				document.querySelector('#vtd-sda-diia').innerHTML = objData.valor_total_descuento;
				document.querySelector('#md-sda-diia').innerHTML = objData.valor_mcd_DIIA;
				document.querySelector('#descripcion-sda-diia').innerHTML = objData.descripcion;
				document.querySelector('#estado-sda-diia').innerHTML = objData.estado_format;
				document.querySelector('#justificacion-sda-diia').innerHTML = objData.observacion;
			} else {
				document.querySelector('#dp-tr-sda-diia').classList.add('notBlock');
				document.querySelector('#vd-tr-sda-diia').classList.add('notBlock');
				document.querySelector('#vtd-tr-sda-diia').classList.add('notBlock');
				document.querySelector('#md-tr-sda-diia').classList.add('notBlock');

				document.querySelector('#periodo-sda-diia').innerHTML = objData.periodo;
				document.querySelector('#fup-sda-diia').innerHTML = objData.fecha_UP;
				document.querySelector('#fpp-sda-diia').innerHTML = objData.fecha_PP;
				document.querySelector('#cuota-sda-diia').innerHTML = objData.cuota;
				//document.querySelector('#mensualidad-sda-diia').innerHTML = objData.valor_m_DIIA;
				document.querySelector('#vtp-sda-diia').innerHTML = objData.valor_total;
				document.querySelector('#md-sda-diia').innerHTML = objData.valor_mcd_DIIA;
				document.querySelector('#descripcion-sda-diia').innerHTML = objData.descripcion;
				document.querySelector('#estado-sda-diia').innerHTML = objData.estado_format;
				document.querySelector('#justificacion-sda-diia').innerHTML = objData.observacion;
			}
			
		}
		divLoading.style.display = "none";
        return false;
	}
	$('#modalSeeDIIA').modal('show');
}

function FctBtnDeleteRDIIA(id_accounting) {
	swal({
		title: "¡Eliminar registro!",
		text: "¿Estas seguro que deceas eliminar este registro permanentemente?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Eliminar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'accounting/deleteAccountingInactive/';
			var data = 'id_accounting='+id_accounting;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Registro!", objData.msg, "success");
						DataTableSeeIIA.ajax.reload();
						DataTableInactiveAccounting.ajax.reload();
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
			}
		}
	});
}