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
});

function FctBtnPaymentRecord(accion, DNI, nombres, id_accounting, fecha_UP) {
    var accion = accion;
	var DNI = DNI;
    var id_accounting = id_accounting;
    var fecha_UP = fecha_UP;
	var nombres = nombres;
	var title = "";
	var text = "";

	if (accion == 1) {
		title = "¡Realizar pago!";
		text = "¿Deceas realizar el pago de "+nombres+"?";
	} else if (accion == 2) {
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
}