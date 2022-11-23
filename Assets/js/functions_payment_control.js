$(document).ready(function () {
	if (document.querySelector('#module-payment-control')) {
		document.querySelector('#module-payment-control').classList.add('is-expanded');
		if (document.querySelector('#payment-control')) {
			$("#payment-control").attr("data-toggle", "treeview");
		}
	}
});

var DataTablePCR;
var DataTableStudent;

document.addEventListener('DOMContentLoaded', function () {

	DataTablePCR = $('#DataTablePCR').DataTable({ /*ID de la tabla*/
		"aProcessing": true,
		"aServerside": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax": {
			"url": BASE_URL + "payment_control/getAllStudents_YesControl",
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "id_payment_control" },
			{ "data": "DNI" },
			{ "data": "student" },
			{ "data": "payment_lp" },
            { "data": "payment_np" },
			{ "data": "Acciones" }
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});

	var formPaymentControl = document.querySelector("#formPaymentControl");
	formPaymentControl.onsubmit = function (e) {
		e.preventDefault();
		let InputDate_LP = document.querySelector('#InputDate_LP');
		if (InputDate_LP == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'payment_control/setPaymentControl';
		var data = new FormData(formPaymentControl);
		request.open("POST", ajaxUrl, true);
		request.send(data);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					$('#ModalFormPaymentControl').modal('hide');
					formPaymentControl.reset();
					swal("¡Hecho!", objData.msg, "success");
					DataTablePCR.ajax.reload();
					DataTableStudent.ajax.reload();
				} else {
					swal("ERROR!", objData.msg, "error");
				}
			}
			divLoading.style.display = "none";
			return false;
		}
	}
		
});

function openModalNewPaymentControl() {
	DataTableStudent = $('#DataTableStudent').DataTable({ /*ID de la tabla*/
		"aProcessing": true,
		"aServerside": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax": {
			"url": BASE_URL + "payment_control/getAllStudents_NoControl",
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "id_student" },
			{ "data": "DNI" },
			{ "data": "student" },
			{ "data": "Acciones" }
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});
	$('#ModalTableNewPaymentControl').modal('show');
}

function paymentControl(id_student, date, action) {
	document.querySelector('#id_student').value = id_student;
	document.querySelector('#action').value = action;
	document.querySelector('#InputDate_LP').value = date;
	$('#ModalFormPaymentControl').modal('show');
}
