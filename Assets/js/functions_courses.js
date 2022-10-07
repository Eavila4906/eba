$(document).ready(function () {
	if (document.querySelector('#module-courses')) {
		document.querySelector('#module-courses').classList.add('is-expanded');
		if (document.querySelector('#icon-courses')) {
            document.querySelector('#icon-courses').classList.replace('fa-circle-o', 'fa-circle');
            document.querySelector('#icon-courses').classList.add('text-primary');
        }
	}
});

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
			{ "data": "Acciones" }
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});

    var formCourse = document.querySelector("#formCourse");
	formCourse.onsubmit = function (e) {
		e.preventDefault();
		var id_course = document.querySelector('#id_course').value;
		var InputCourse = document.querySelector('#InputCourse').value;
		var InputCategory = document.querySelector('#InputCategory').value;
		var InputDateStart = document.querySelector('#InputDateStart').value;
		var InputDateFinal = document.querySelector('#InputDateFinal').value;
		var InputValueCourse = document.querySelector('#InputValueCourse').value;
		var InputDescription = document.querySelector('#InputDescription').value;
		var InputStatus = document.querySelector('#InputStatus').value;

		if (InputCourse == '' || InputCategory == '' || InputDateStart == ''
			|| InputDateFinal == '' || InputValueCourse == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
        /*
		if (!campos.InputCourse || !campos.InputDescription) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}
		*/
		divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'courses/setCourse';
		var formData = new FormData(formCourse);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					$('#ModalFormCourse').modal('hide');
					formCourse.reset();
					swal("¡Curso!", objData.msg, "success");
					DataTableCourses.ajax.reload();
				} else {
					swal("¡Atención!", objData.msg, "warning");
				}
			} else {
				swal("ERROR!", "Error", "error");
			}
			divLoading.style.display = "none";
            return false;
		}
	}
});

function openModalCourse() {
	document.querySelector('#id_course').value = "";
	document.querySelector('#title-modal-course').innerHTML = "Nuevo Curso";
	document.querySelector('#modal-header-course').classList.replace("header-update", "header-register");
	document.querySelector('#btn-action-form').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn').innerHTML = "Guardar";
	document.querySelector('#formCourse').reset();
	//show list category
	$(document).ready(function () {
		var categoryList = document.querySelector('.category-register');
		function loadCategoryList() {
			$.ajax({
				type: 'GET',
				url: 'courses/getCategoryList',
				success: function (data) {
					var objData = JSON.parse(data);
					var selectedDisable = '<option class="form-control none-block" selected disabled> Seleccionar categoría</option>';
					objData.forEach(objData => {
						selectedDisable += `
							<option value="${objData.id_course_category}">${objData.category}</option>`;
					});
					categoryList.innerHTML = selectedDisable;
				}
			});
		}
		loadCategoryList();
	});
	//
	//cleanResiduoVali();
	$('#ModalFormCourse').modal('show');
}

function FctBtnUpdateCourse(id_course) {
	document.querySelector('#title-modal-course').innerHTML = "Actualizar categoría";
	document.querySelector('#modal-header-course').classList.replace("header-register","header-update");
	document.querySelector('#btn-action-form').classList.replace("btn-success", "btn-info");
	document.querySelector('#text-btn').innerHTML = "Actualizar";

	/*cleanResiduoVali();
	campos.InputCourse = true; 
	campos.InputDescription = true;*/

	var id_course = id_course;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'courses/getCourse/' + id_course;
	request.open("GET", ajaxUrl, true);
	request.send();
	
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector('#id_course').value = objData.data.id_course;
				document.querySelector('#InputCourse').value = objData.data.name;
				document.querySelector('#InputDateStart').value = objData.data.date_start;
				document.querySelector('#InputDateFinal').value = objData.data.date_final;
				document.querySelector('#InputValueCourse').value = objData.data.value;
				//show list category
				$(document).ready(function () {
					var categoryList = document.querySelector('.category-update');
					var se = `<option class="none-block" value="${ objData.data.id_course_category}">${objData.data.category}</option>`;
					function loadCategoryList() {
						$.ajax({
							type: 'GET',
							url: 'courses/getCategoryList',
							success: function (data) {
								var objData = JSON.parse(data);

								var selectedDisable = se;

								objData.forEach(objData => {
									selectedDisable += `
										<option value="${objData.id_course_category}">${objData.category}</option>
									`;
								});

								categoryList.innerHTML = selectedDisable;
							}
						});
					}

					loadCategoryList();
				});
				//

				document.querySelector('#InputDescription').value = objData.data.description;

				if (objData.data.status == 1) {
					var optionSlected = '<option class="none-block" value="1">Activo</option>';
				} else {
					var optionSlected = '<option class="none-block" value="2">Inactivo</option>';
				}

				var SelectHTML = `${optionSlected}
									<option value="1">Activo</option>
									<option value="2">Inactivo</option>
								`;

				document.querySelector('#InputStatus').innerHTML = SelectHTML;

			} else {
				swal("ERROR!", objData.msg, "error");
			}
		}
	}
	$('#ModalFormCourse').modal('show');
}

function FctBtnDeleteCourse(id_course) {
	var id_course = id_course;
	swal({
		title: "¡Eliminar curso!",
		text: "¿Estas seguro que deceas eliminar este curso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Eliminar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'courses/DeleteCourse/';
			var data = 'id_course=' + id_course;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Curso!", objData.msg, "success");
						DataTableCourses.ajax.reload();
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
			}
		}
	});
}