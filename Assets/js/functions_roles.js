//Cargar los datos del la base de datos al la tabla
var DataTableRoles;
document.addEventListener('DOMContentLoaded', function () {

	DataTableRoles = $('#DataTableRoles').DataTable({ /*ID de la tabla*/
		"aProcessing": true,
		"aServerside": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax": {
			"url": BASE_URL + "roles/getRoles",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "id_rol" },
			{ "data": "nombreRol" },
			{ "data": "descripRol" },
			{ "data": "estadoRol" },
			{ "data": "Acciones" },
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});

	//Registrar
	var formRoles = document.querySelector("#formRoles");
	formRoles.onsubmit = function (e) {
		e.preventDefault();
		var intId_rol = document.querySelector('#id_rol').value;
		var strNombreRol = document.querySelector('#TextNombreRol').value;
		var strDescripcion = document.querySelector('#TextDescripcionRol').value;
		var listaEstadoRol = document.querySelector('#ListaEstadoRol').value;

		if (strNombreRol == '' || strDescripcion == '' || listaEstadoRol == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}

		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'roles/setRoles';
		var formData = new FormData(formRoles);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					$('#ModalFormRoles').modal('hide');
					formRoles.reset();
					swal("¡Rol de usuario!", objData.msg, "success");
					DataTableRoles.ajax.reload();
				} else {
					swal("¡Atención!", objData.msg, "warning");
				}
			} else {
				swal("ERROR!", "Error", "error");
			}
		}
	}
});

$(document).ready(function () {
	$('#DataTableRoles').DataTable();
});


function openModal() {
	document.querySelector('#id_rol').value = "";
	document.querySelector('#title-modal').innerHTML = "Nuevo Rol";
	document.querySelector('.modal-header').classList.replace("header-update", "header-register");
	document.querySelector('#btn-action-form').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn').innerHTML = "Guardar";
	document.querySelector('#formRoles').reset();
	$('#ModalFormRoles').modal('show');
}

/*Acciones de los botones data table*/
//Accion permisos
function FctBtnPermisosRol(id_rol) {
	var id_rol = id_rol;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'Permisos/getPermisos/' + id_rol;
	request.open("GET", ajaxUrl, true);
	request.send();
	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			//var objData = JSON.parse(request.responseText);
			document.querySelector('#ContentAjax').innerHTML = request.responseText;
			$('#ModalPermisosRoles').modal('show');
			document.querySelector('#formPermisos').addEventListener('submit', fctSavePermisosRol, false);
		}
	}
}

function fctSavePermisosRol(evnet) {
	evnet.preventDefault();
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'Permisos/setPermisos';
	var formPermisos = document.querySelector('#formPermisos');
	var formData = new FormData(formPermisos);
	request.open("POST", ajaxUrl, true);
	request.send(formData);

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				swal("¡Permisos de rol!", objData.msg, "success");
			} else {
				swal("¡Error!", objData.msg, "error");
			}
		} else {
			swal("ERROR!", "Error", "error");
		}
	}

}

//Accion editar
function FctBtnEditarRol(id_rol) {
	document.querySelector('#title-modal').innerHTML = "Actualizar Rol";
	document.querySelector('.modal-header').classList.replace("header-register", "header-update");
	document.querySelector('#btn-action-form').classList.replace("btn-success", "btn-info");
	document.querySelector('#text-btn').innerHTML = "Actualizar";

	var id_rol = id_rol;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'roles/getRol/' + id_rol;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector('#id_rol').value = objData.data.id_rol;
				document.querySelector('#TextNombreRol').value = objData.data.nombreRol;
				document.querySelector('#TextDescripcionRol').value = objData.data.descripRol;

				if (objData.data.estadoRol == 1) {
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
	$('#ModalFormRoles').modal('show');
}

//Accion eliminar
function FctBtnEliminarRol(id_rol) {
	var id_rol = id_rol;
	swal({
		title: "¡Eliminar Rol!",
		text: "¿Estas seguro que deceas eliminar el rol?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Eliminar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'roles/DeleteRol/';
			var data = 'id_rol=' + id_rol;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Rol!", objData.msg, "success");
						DataTableRoles.ajax.reload();
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
			}
		}
	});
}
