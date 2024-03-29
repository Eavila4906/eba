$(document).ready(function () {
	if (document.querySelector('#module-users')) {
		document.querySelector('#module-users').classList.add('is-expanded');
		if (document.querySelector('#icon-users')) {
            document.querySelector('#icon-users').classList.replace('fa-circle-o', 'fa-circle');
            document.querySelector('#icon-users').classList.add('text-primary');
        }
	}
});

/* Starts validacion de formulario add users */
const inputs = document.querySelectorAll('#formUsers input');
const expresiones = {
	cedula: /^\d{9,10}$/,
	nombres: /^[a-zA-ZÀ-ÿ\s]{1,45}$/,
	apellido: /^[a-zA-ZÀ-ÿ\s]{1,35}$/,
	email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{7,10}$/
}

const campos = {
	InputCedulaPasaporte: false,
	InputNombres: false,
	InputApellidoP: false,
	InputApellidoM: false,
	InputEmail: false,
	InputTelefono: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "InputCedulaPasaporte":
			validarCamposForm(expresiones.cedula, e.target, 'labelCedula', 'InputCedulaPasaporte', 'leyenda-cedula');
		break;
		case "InputNombres":
			validarCamposForm(expresiones.nombres, e.target, 'labelNombres', 'InputNombres', 'leyenda-nombres');
		break;
		case "InputApellidoP":
			validarCamposForm(expresiones.apellido, e.target, 'labelApellidoP', 'InputApellidoP', 'leyenda-apellidoP');
		break;
		case "InputApellidoM":
			validarCamposForm(expresiones.apellido, e.target, 'labelApellidoM', 'InputApellidoM', 'leyenda-apellidoM');
		break;
		case "InputEmail":
			validarCamposForm(expresiones.email, e.target, 'labelEmail', 'InputEmail', 'leyenda-email');
		break;
		case "InputTelefono":
			validarCamposForm(expresiones.telefono, e.target, 'labelTelefono', 'InputTelefono', 'leyenda-telefono');
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

/* Finish validacion de formulario add users */

//Cargar elementos del data table
$(document).ready(function () {
	$('#DataTableUsuarios').DataTable();
});

//Cargar los datos del la base de datos al la tabla
var DataTableUsuarios;
document.addEventListener('DOMContentLoaded', function () {

	DataTableUsuarios = $('#DataTableUsuarios').DataTable({ /*ID de la tabla*/
		"aProcessing": true,
		"aServerside": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax": {
			"url": BASE_URL + "users/getUsers",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "id_usuario" },
			{ "data": "DNI" },
			{ "data": "nombres" },
			{ "data": "username" },
			{ "data": "nombreRol" },
			{ "data": "estado" },
			{ "data": "Acciones" },
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});

	//add user
	var formUsers = document.querySelector("#formUsers");
	formUsers.onsubmit = function (e) {
		e.preventDefault();
		var id_usuario = document.querySelector('#id_usuario').value;
		var InputCedula = document.querySelector('#InputCedulaPasaporte').value;
		var InputNombres = document.querySelector('#InputNombres').value;
		var InputApellidoP = document.querySelector('#InputApellidoP').value;
		var InputApellidoM = document.querySelector('#InputApellidoM').value;
		var InputEmail = document.querySelector('#InputEmail').value;
		var InputTelefono = document.querySelector('#InputTelefono').value;
		var InputfechaNaci = document.querySelector('#InputfechaNaci').value;
		var InputSexo = document.querySelector('#InputSexo').value;
		var InputTipoRol = document.querySelector('#InputTipoRol').value;
		var InputEstado = document.querySelector('#InputEstado').value;

		if (InputCedula == '' || InputNombres == '' || InputApellidoP == '' || InputApellidoM == '' || InputEmail == '' || InputTelefono == '' || InputfechaNaci == '' || InputSexo == '' || InputTipoRol == '' || InputEstado == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!campos.InputCedulaPasaporte || !campos.InputNombres || !campos.InputApellidoP || !campos.InputApellidoM || !campos.InputEmail || !campos.InputTelefono) {
			swal("¡Atención!", "Verifica los campos en rojo!", "warning");
			return false;
		}
		divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'users/setUsers';
		var formData = new FormData(formUsers);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					$('#ModalFormUsers').modal('hide');
					formUsers.reset();
					swal("¡Usuario!", objData.msg, "success");
					DataTableUsuarios.ajax.reload();
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

//Abrir formulario de registro
function openModal() {
	document.querySelector('#id_usuario').value = "";
	document.querySelector('#title-modal-user').innerHTML = "Nuevo Usuario";
	document.querySelector('#modal-header-user').classList.replace("header-update", "header-register");
	document.querySelector('#cajaPassword').classList.replace("pass-update", "pass-register");
	document.querySelector('#InputTipoRol').classList.replace("rol-update", "rol-register");
	document.querySelector('#btn-action-form').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn').innerHTML = "Guardar";
	document.getElementById("formUsers").reset();
	$('#ModalFormUsers').modal('show');
	cleanResiduoVali();
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

//Cargar lista de tipo de rol
$(document).ready(function () {
	var listaTipoRol = document.querySelector('.rol-register');
	function loadListTypeRol() {
		$.ajax({
			type: 'POST',
			url: 'users/getListTypeRoles',
			success: function (data) {
				var objData = JSON.parse(data);
				var selectedDisable = '<option class="form-control none-block" selected disabled> Tipo rol </option>';
				objData.forEach(objData => {
					selectedDisable += `<option value="${objData.id_rol}">${objData.nombreRol}</option>`;
				});
				listaTipoRol.innerHTML = selectedDisable;
			}
		});
	}
	loadListTypeRol();
});

/*Acciones de los botones data table*/
//Extraer datos del usuario en el modal
function FctBtnVerInfoUser(id_user) {
	var id_user = id_user;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'users/getVerInfoUser/' + id_user;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);

			//foto
			var foto = `<img  src="Assets/images/image-profiles/${objData.photo}" width="150" height="200">`;
			document.querySelector('#getFoto').innerHTML = foto;
			document.querySelector('#title').innerHTML = objData.nombresApellidos;
			document.querySelector('#getUsername').innerHTML = objData.username;
			document.querySelector('#getCedula-Pasaporte').innerHTML = objData.ced;
			document.querySelector('#getNombres').innerHTML = objData.nombresApellidos;


			document.querySelector('#getEmail').innerHTML = objData.email;
			document.querySelector('#getTelefono').innerHTML = objData.telefono;
			document.querySelector('#getFechaNaci').innerHTML = objData.fechaNaci;

			if (objData.sexo == 'M') {
				var sexo = 'Masculino';
			} else {
				var sexo = 'Femenino';
			}
			document.querySelector('#getSexo').innerHTML = sexo;

			document.querySelector('#getTipoRol').innerHTML = objData.nombreRol;

			if (objData.estado == 1) {
				var estado = '<spam class="badge badge-success">Activo</spam>';
			} else {
				var estado = '<spam class="badge badge-danger">Inactivo</spam>';
			}
			document.querySelector('#getEstado').innerHTML = estado;
		}
	}
	$('#ModalInfoUser').modal('show');
}

//Accion editar
function FctBtnEditarUser(id_user) {
	document.querySelector('#title-modal-user').innerHTML = "Actualizar usuario";
	document.querySelector('#modal-header-user').classList.replace("header-register", "header-update");
	document.querySelector('#btn-action-form').classList.replace("btn-success", "btn-info");
	document.querySelector('#cajaPassword').classList.replace("pass-register", "pass-update");
	document.querySelector('#InputTipoRol').classList.replace("rol-register", "rol-update");
	document.querySelector('#text-btn').innerHTML = "Actualizar";
	cleanResiduoVali();

	campos.InputCedulaPasaporte = true; 
	campos.InputNombres = true; 
	campos.InputApellidoP = true; 
	campos.InputApellidoM = true; 
	campos.InputEmail = true; 
	campos.InputTelefono = true;

	var id_usuario = id_user;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'users/getDataUser/' + id_usuario;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector('#id_usuario').value = objData.data.id_usuario;
				document.querySelector('#InputCedulaPasaporte').value = objData.data.ced;
				document.querySelector('#InputNombres').value = objData.data.nombres;
				document.querySelector('#InputApellidoP').value = objData.data.apellidoP;
				document.querySelector('#InputApellidoM').value = objData.data.apellidoM;
				document.querySelector('#InputEmail').value = objData.data.email;
				document.querySelector('#InputTelefono').value = objData.data.telefono;
				document.querySelector('#InputfechaNaci').value = objData.data.fechaNaci;

				//Selected sexo
				if (objData.data.sexo == 'M') {
					var optionSlected = '<option class="none-block" value="M">Masculino</option>';
				} else {
					var optionSlected = '<option class="none-block" value="F">Femenino</option>';
				}

				var SelectHTML = `${optionSlected}
											<option value="M">Masculino</option>
											<option value="F">Femenino</option>
										`;

				document.querySelector('#InputSexo').innerHTML = SelectHTML;

				//Selected tipo rol
				$(document).ready(function () {
					var listaTipoRol = document.querySelector('.rol-update');
					var se = `<option class="none-block" value="${objData.data.id_rol}">${objData.data.nombreRol}</option>`;
					function loadListTypeRol() {
						$.ajax({
							type: 'POST',
							url: 'users/getListTypeRoles',
							success: function (data) {
								var objData = JSON.parse(data);

								var selectedDisable = se;

								objData.forEach(objData => {
									selectedDisable += `
																<option value="${objData.id_rol}">${objData.nombreRol}</option>
																`;
								});

								listaTipoRol.innerHTML = selectedDisable;
							}
						});
					}

					loadListTypeRol();
				});



				//document.querySelector('#InputTipoRol').innerHTML = SelectHTML;

				//Selected estado
				if (objData.data.estado == 1) {
					var optionSlected = '<option class="none-block" value="1">Activo</option>';
				} else {
					var optionSlected = '<option class="none-block" value="2">Inactivo</option>';
				}

				var SelectHTML = `${optionSlected}
											<option value="1">Activo</option>
											<option value="2">Inactivo</option>
										`;

				document.querySelector('#InputEstado').innerHTML = SelectHTML;

				//document.querySelector('#InputPassword').value = objData.data.password;

			} else {
				swal("ERROR!", objData.msg, "error");
			}
		}
	}

	$('#ModalFormUsers').modal('show');
}

//Accion eliminar
function FctBtnEliminarUser(id_user) {
	var id_usuario = id_user;
	swal({
		title: "¡Eliminar Usuario!",
		text: "¿Estas seguro que deceas eliminar el Usuario?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Eliminar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'users/DeleteUser/';
			var data = 'id_usuario=' + id_usuario;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Usuario!", objData.msg, "success");
						DataTableUsuarios.ajax.reload();
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
			}
		}
	});
}

//mostrar password
$(document).ready(function () {
	$('#mostrar_contrasena').click(function () {
		if ($('#mostrar_contrasena').is(':checked')) {
			$('#InputPassword').attr('type', 'text');
		} else {
			$('#InputPassword').attr('type', 'password');
		}
	});
});
