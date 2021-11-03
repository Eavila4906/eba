$(document).ready(function () {
	if (document.querySelector('#module-accounting')) {
		document.querySelector('#module-accounting').classList.add('is-expanded');
		if (document.querySelector('#icon-resgistrar-pago')) {
            document.querySelector('#icon-resgistrar-pago').classList.replace('fa-circle-o', 'fa-circle');
            document.querySelector('#icon-resgistrar-pago').classList.add('text-primary');
        }
	}
});

var DataTablePaymentRecord;
document.addEventListener('DOMContentLoaded', function () {

	DataTablePaymentRecord = $('#DataTableRP').DataTable({ /*ID de la tabla*/
		"aProcessing": true,
		"aServerside": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax": {
			"url": BASE_URL + "payment_record/getAllAccounting",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "id_accounting" },
			{ "data": "DNI" },
			{ "data": "estudiante" },
			{ "data": "Ultimo_pago" },
            { "data": "Proximo_pago" },
			{ "data": "Acciones" },
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});

	var formPayment = document.querySelector("#formPayment");
	formPayment.onsubmit = function (e) {
		e.preventDefault();
		var accion = document.querySelector('#accion').value;
		var DNI = document.querySelector('#DNI').value;
		var id_accounting = document.querySelector('#id_accounting').value;
		var fecha_UP = document.querySelector('#fecha_UP').value;
		var nombres = document.querySelector('#nombres').value;
		var InputTypePayment = document.querySelector('#InputTypePayment').value;
		var InputDescripcion = document.querySelector('#InputDescripcion').value;
		var title = "";
		var text = "";

		if (accion == 1) {
			title = "¡Realizar pago!";
			text = "¿Deceas realizar el pago mensual de "+nombres+"?";
			if (DNI == '' || id_accounting == '' || fecha_UP == '' || InputTypePayment == '') {
				swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
				return false;
			}
		} else if (accion == 2) {
			title = "¡Realizar pago (No Contable)!";
			text = "¿Deceas realizar el pago no contable de "+nombres+"?";
			if (DNI == '' || id_accounting == '' || fecha_UP == '' || InputDescripcion == '') {
				swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
				return false;
			}
		} else if (accion == 3) {
			title = "¡Realizar todos los pago!";
			text = "¿Deceas realizar todos los pagos correspondiente a la contabilidad de "+nombres+"?";
		}

		swal({
			title: title,
			text: text,
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "Si, Realizar",
			cancelButtonText: "No, Cancelar",
			closeOnConfirm: false,
			closeOnCancel: true,
		}, function (isConfirm) {
			if (isConfirm) {
				swal.close();
				divLoading.style.display = "flex";
				var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
				var ajaxUrl = BASE_URL + 'payment_record/setPaymentRecord';
				var data = new FormData(formPayment);
				request.open("POST", ajaxUrl, true);
				request.send(data);

				request.onreadystatechange = function () {
					if (request.readyState == 4 && request.status == 200) {
						var objData = JSON.parse(request.responseText);
						if (objData.status) {
							swal("¡Hecho!", objData.msg, "success");
							$('#ModalFormPayment').modal('hide');
							formPayment.reset();
							DataTablePaymentRecord.ajax.reload();
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

	var formPaymentDay = document.querySelector("#formPaymentDay");
	formPaymentDay.onsubmit = function (e) {
		e.preventDefault();
		var InputPaymentDay = document.querySelector('#InputPaymentDay').value;

		if (InputPaymentDay == '') {
			swal("¡Atención!", "El campo es obligatorio.", "warning");
			return false;
		} else if (!campos.InputPaymentDay) {
			swal("¡Atención!", "Verifica el campo en rojo.", "warning");
			return false;
		} else if (InputPaymentDay <= 0 || InputPaymentDay > 28) {
			swal("¡Atención!", "El valor ingresado esta fuera del rango de los requisitos.", "warning");
			return false;
		}

		divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'payment_record/setPaymentDay';
		var data = new FormData(formPaymentDay);
		request.open("POST", ajaxUrl, true);
		request.send(data);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					swal("¡Hecho!", objData.msg, "success");
					$('#ModalFormPaymentDay').modal('hide');
					formPaymentDay.reset();
					DataTablePaymentRecord.ajax.reload();
				} else {
					swal("ERROR!", objData.msg, "error");
				}
			}
			divLoading.style.display = "none";
			return false;
		}	
	}
});

function FctBtnPaymentRecord(accion, DNI, nombres, id_accounting, fecha_UP) {
	document.querySelector('#formPayment').reset();
	document.querySelector('#accion').value = accion;
	document.querySelector('#DNI').value = DNI;
	document.querySelector('#id_accounting').value = id_accounting;
	document.querySelector('#fecha_UP').value = fecha_UP;
	document.querySelector('#nombres').value = nombres;

	if (accion == 1) { 
		document.querySelector('#title-modal-PR').innerHTML = "Pago mensual";
		document.querySelector('#modal-header-PR').classList.replace("bg-danger", "bg-success");
		document.querySelector('#btn-action-form-PR').classList.replace("btn-danger", "btn-success");
		document.querySelector('#cap-tp').classList.remove("notBlock");
		document.querySelector('#labelDescripcion').innerHTML = 'Descripción <span class="required" id="required">*</span>';
		document.querySelector('#required').classList.add("notBlock");
	} else if (accion == 2){
		document.querySelector('#title-modal-PR').innerHTML = "Pago mensual (No contable)";
		document.querySelector('#modal-header-PR').classList.replace("bg-success", "bg-danger");
		document.querySelector('#btn-action-form-PR').classList.replace("btn-success", "btn-danger");
		document.querySelector('#cap-tp').classList.add("notBlock");
		document.querySelector('#labelDescripcion').innerHTML = 'Justificación <span class="required" id="required">*</span>';
		document.querySelector('#required').classList.remove("notBlock");
	}

	$('#ModalFormPayment').modal('show');

	/*
    

	if (accion == 1) {
		title = "¡Realizar pago!";
		text = "¿Deceas realizar el pago mensual de "+nombres+"?";
	} else if (accion == 2) {
		title = "¡Realizar todos los pago!";
		text = "¿Deceas realizar todos los pagos correspondiente a la contabilidad de "+nombres+"?";
	} else if (accion == 3) {
		title = "¡Realizar pago (No Contable)!";
		text = "¿Deceas realizar el pago no contable de "+nombres+"?";
	}

	swal({
		title: title,
		text: text,
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Realizar",
		cancelButtonText: "No, Cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			swal.close();
			divLoading.style.display = "flex";
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'payment_record/setPaymentRecord/';
			var data = 'accion=' + accion + '&' + 'DNI=' + DNI + '&' + 'id_accounting=' + id_accounting + '&' + 'fecha_UP=' + fecha_UP;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);
			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Hecho!", objData.msg, "success");
						DataTablePaymentRecord.ajax.reload();
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
				divLoading.style.display = "none";
				return false;
			}
		}
	});
	*/
}

const inputs = document.querySelectorAll('#formPaymentDay input');
const expresiones = {
	range: /^\d{1,2}$/
}

const campos = {
	InputPaymentDay: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "InputPaymentDay":
			validarCamposForm(expresiones.range, e.target, 'labelPaymentDay', 'InputPaymentDay', 'leyenda-PaymentDay');
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

function openModalPaymentDay() {
	document.querySelector('#formPaymentDay').reset();
	cleanResiduoVali();
	$('#ModalFormPaymentDay').modal('show');

	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'payment_record/getPaymentDay';
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			document.querySelector('#current-day').innerHTML = objData.day;
			document.querySelector('#InputPaymentDay').value = objData.day;
		}
	}

}