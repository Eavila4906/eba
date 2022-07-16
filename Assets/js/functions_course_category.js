var DataTableCategory;
document.addEventListener('DOMContentLoaded', function () {

	DataTableCategory = $('#DataTableCategory').DataTable({ /*ID de la tabla*/
		"aProcessing": true,
		"aServerside": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax": {
			"url": BASE_URL + "course_category/getAllCategory",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "id_course_category" },
			{ "data": "category" },
			{ "data": "description" },
			{ "data": "status" },
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});

    var formCategory = document.querySelector("#formCategory");
	formCategory.onsubmit = function (e) {
		e.preventDefault();
		var id_category = document.querySelector('#id_category').value;
		var InputCategory = document.querySelector('#InputCategory').value;
		var InputDescription = document.querySelector('#InputDescription').value;
		var InputStatus = document.querySelector('#InputStatus').value;

		if (InputCategory == '' || InputDescription == '' || InputDescription == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
        
		/*if (!campos.TextNombreRol || !campos.TextDescripcionRol) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}*/

		divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'course_category/setCategory';
		var formData = new FormData(formCategory);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					$('#ModalFormCategory').modal('hide');
					formCategory.reset();
					swal("¡Rol de usuario!", objData.msg, "success");
					DataTableCategory.ajax.reload();
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

function openModalCategory() {
	document.querySelector('#id_category').value = "";
	document.querySelector('#title-modal-category').innerHTML = "Nuevo Categoria";
	document.querySelector('#modal-header-category').classList.replace("header-update", "header-register");
	document.querySelector('#btn-action-form').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn').innerHTML = "Guardar";
	document.querySelector('#formCategory').reset();
	cleanResiduoVali();
	$('#ModalFormCategory').modal('show');
}

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

function FctBtnUpdateCategory(id_category) {
	document.querySelector('#title-modal-category').innerHTML = "Actualizar categoría";
	document.querySelector('#modal-header-category').classList.replace("header-register", "header-update");
	document.querySelector('#btn-action-form').classList.replace("btn-success", "btn-info");
	document.querySelector('#text-btn').innerHTML = "Actualizar";

	cleanResiduoVali();
	campos.InputCategory = true; 
	campos.InputDescription = true;

	var id_category = id_category;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'corse_category/getCategory/' + id_category;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector('#id_category').value = objData.data.id_corse_category;
				document.querySelector('#InputCategory').value = objData.data.category;
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

				document.querySelector('#ListaEstadoRol').innerHTML = SelectHTML;

			} else {
				swal("ERROR!", objData.msg, "error");
			}
		}
	}
	$('#ModalFormCategory').modal('show');
}

function FctBtnDeleteCategory(id_category) {
	var id_category = id_category;
	swal({
		title: "¡Eliminar categoría!",
		text: "¿Estas seguro que deceas eliminar esta categoría?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Eliminar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'course_category/DeleteCategory/';
			var data = 'id_category=' + id_category;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Categoría!", objData.msg, "success");
						DataTableCategory.ajax.reload();
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
			}
		}
	});
}


