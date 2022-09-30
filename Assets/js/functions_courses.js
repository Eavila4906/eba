$(document).ready(function () {
	if (document.querySelector('#module-courses')) {
		document.querySelector('#module-courses').classList.add('is-expanded');
		if (document.querySelector('#icon-courses')) {
            document.querySelector('#icon-courses').classList.replace('fa-circle-o', 'fa-circle');
            document.querySelector('#icon-courses').classList.add('text-primary');
        }
	}
});

function openModalCurses() {
	document.querySelector('#id_curses').value = "";
	document.querySelector('#title-modal-curses').innerHTML = "Nuevo Curso";
	document.querySelector('#modal-header-curses').classList.replace("header-update", "header-register");
	document.querySelector('#btn-action-form').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn').innerHTML = "Guardar";
	document.querySelector('#formCurses').reset();
	//cleanResiduoVali();
	$('#ModalFormCurses').modal('show');
}

var DataTableCourses;
document.addEventListener('DOMContentLoaded', function () {

	DataTableCourses = $('#DataTableCourses').DataTable({ /*ID de la tabla*/
		"aProcessing": true,
		"aServerside": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax": {
			"url": BASE_URL + "courses/getAllCourses",
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "id_course" },
			{ "data": "name" },
			{ "data": "category" },
			{ "data": "description" },
			{ "data": "date_start" },
			{ "data": "date_final" },
			{ "data": "value" },
			{ "data": "status" },
			{ "data": "Acciones" },
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});

    
});