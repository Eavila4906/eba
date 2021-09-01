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
            { "data": "periodo" },
            { "data": "cantidad" },
            { "data": "valor_unitario" },
            { "data": "total_pagar" },
            { "data": "total_pago" },
            { "data": "estado" },
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