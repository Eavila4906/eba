$(document).ready(function () {
	if (document.querySelector('#module-users')) {
		document.querySelector('#module-users').classList.add('is-expanded');
		if (document.querySelector('#icon-roles')) {
            document.querySelector('#icon-roles').classList.replace('fa-circle-o', 'fa-circle');
            document.querySelector('#icon-roles').classList.add('text-primary');
        }
	}
});

/* Starts validacion de formulario add roles */
const inputs = document.querySelectorAll('#formRoles input');
const textarea = document.querySelectorAll('#formRoles textarea');

const expresiones = {
	nombreRol: /^[a-zA-ZÀ-ÿ\s]{1,20}$/,
	descripcionRol: /^[a-zA-ZÀ-ÿ0-9\s]{1,80}$/,
}

const campos = {
	TextNombreRol: false,
	TextDescripcionRol: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "TextNombreRol":
			validarCamposForm(expresiones.nombreRol, e.target, 'labelNombreRol', 'TextNombreRol', 'leyenda-nombreRol');
		break;
		case "TextDescripcionRol":
			validarCamposForm(expresiones.descripcionRol, e.target, 'labelDescripcionRol', 'TextDescripcionRol', 'leyenda-descripcionRol');
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
textarea.forEach((textarea) => {
	textarea.addEventListener('keyup', validarFormulario);
	textarea.addEventListener('blur', validarFormulario);
});
/* Finish validacion de formulario add roles */

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

	//add rol
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
		if (!campos.TextNombreRol || !campos.TextDescripcionRol) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}

		divLoading.style.display = "flex";
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
			divLoading.style.display = "none";
            return false;
		}
	}
});

$(document).ready(function () {
	$('#DataTableRoles').DataTable();
});

function openModal() {
	document.querySelector('#id_rol').value = "";
	document.querySelector('#title-modal-rol').innerHTML = "Nuevo Rol";
	document.querySelector('#modal-header-rol').classList.replace("header-update", "header-register");
	document.querySelector('#btn-action-form').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn').innerHTML = "Guardar";
	document.querySelector('#formRoles').reset();
	cleanResiduoVali();
	$('#ModalFormRoles').modal('show');
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
	
	divLoading.style.display = "flex";
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
		divLoading.style.display = "none";
        return false;
	}

}

//Accion editar
function FctBtnEditarRol(id_rol) {
	document.querySelector('#title-modal-rol').innerHTML = "Actualizar Rol";
	document.querySelector('#modal-header-rol').classList.replace("header-register", "header-update");
	document.querySelector('#btn-action-form').classList.replace("btn-success", "btn-info");
	document.querySelector('#text-btn').innerHTML = "Actualizar";

	cleanResiduoVali();
	campos.TextNombreRol = true; 
	campos.TextDescripcionRol = true;

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
