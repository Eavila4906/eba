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
            { "data": "V_cuota" },
			{ "data": "Acciones" },
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});
});

function FctBtnPaymentRecord(DNI, id_accounting, fecha_UP) {
    var DNI = DNI;
    var id_accounting = id_accounting;
    var fecha_UP = fecha_UP;
    

    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'payment_record/setPaymentRecord/';
	var data = 'DNI=' + DNI + '&' + 'id_accounting=' + id_accounting + '&' + 'fecha_UP=' + fecha_UP;
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
	}
}