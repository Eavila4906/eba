$(document).ready(function () {
	if (document.querySelector('#module-accounting')) {
		document.querySelector('#module-accounting').classList.add('is-expanded');
        if (document.querySelector('#icon-reportes')) {
            document.querySelector('#icon-reportes').classList.replace('fa-circle-o', 'fa-circle');
            document.querySelector('#icon-reportes').classList.add('text-primary');
        }
	}
});

var DataTablePayment;
document.addEventListener('DOMContentLoaded', function () {

	DataTablePayment = $('#DataTableP').DataTable({ /*ID de la tabla*/
		"aProcessing": true,
		"aServerside": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax": {
			"url": BASE_URL + "payment/getAllPayment",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "id_payment" },
			{ "data": "DNI" },
			{ "data": "estudiante" },
			{ "data": "Acciones" },
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});
});

function FctBtnSeePayments(dni, name) {
    var dni = dni;
    var name = name;
    var DataTableSeePayment;
    DataTableSeePayment = $('#DataTableSeePayment').DataTable({ /*ID de la tabla*/
        "aProcessing": true,
        "aServerside": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
        },
        "ajax": {
            "url": BASE_URL + "payment/getSeePayment/"+ dni,/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "periodo_format" },
            { "data": "cantidad-rs" },
            { "data": "valor_unitario" },
            { "data": "total_pagar" },
            { "data": "total_pago" },
            { "data": "estado" },
            { "data": "Acciones" },
        ],
        "bAutoWidth": false,
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10, /*Mostrará los primero 10 registros*/
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
    document.querySelector('#titleName').innerHTML = name;
    $('#ModalSeePayments').modal('show');
}

function FctBtnIndividualPayments(periodo_format, periodo, dni, opcion) {
    document.querySelector('#dtsip').classList.remove('notBlock');
    document.querySelector('#per').innerHTML = periodo_format;
    DataTableSeePayment = $('#DataTableSeeIndividualPayments').DataTable({ /*ID de la tabla*/
        "aProcessing": true,
        "aServerside": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
        },
        "ajax": {
            "url": BASE_URL + "payment/getSeeIndividualPayments/"+dni+"/"+periodo+"/"+opcion,/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "id_payment" },
            { "data": "tipo_pago_format" },
            { "data": "fecha_pago_format" },
            { "data": "valor_format" },
            { "data": "estado_format" },
            { "data": "observacion_format" },
            { "data": "descripcion_format" },
        ],
        "bAutoWidth": false,
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10, /*Mostrará los primero 10 registros*/
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
}

function FctBtnCMSP() {
    document.querySelector('#dtsip').classList.add('notBlock');
}