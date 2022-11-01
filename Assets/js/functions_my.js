$(document).ready(function () {
	if (document.querySelector('#module-personalArea')) {
		document.querySelector('#module-personalArea').classList.add('is-expanded');
		if (document.querySelector('#personalArea')) {
			$("#personalArea").attr("data-toggle", "treeview");
		}
	}
});
const expresiones = {
	nombre: /^[a-zA-ZÀ-ÿ0-9¿?¡!.,:;\s]{1,45}$/,
	descripcionCorta: /^[a-zA-ZÀ-ÿ0-9¡!%""$#.,:;()\s]{1,100}$/,
	url: /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
}

const inputs = document.querySelectorAll('#formMyNewContent input');
const textarea = document.querySelectorAll('#formMyNewContent textarea');

const campos = {
	InputNombre: false,
	InputDescripcion: false,
	InputLink: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "InputNombre":
			validarCampos(expresiones.nombre, e.target, 'labelNombre', 'InputNombre', 'leyenda-nombre');
		break;
		case "InputDescripcion":
			validarCampos(expresiones.descripcionCorta, e.target, 'labelDescripcion', 'InputDescripcion', 'leyenda-descripcion');
		break;
		case "InputLink":
			validarCampos(expresiones.url, e.target, 'labelLink', 'InputLink', 'leyenda-link');
		break;
	}
}

const validarCampos = (expresion, input, label, id_input, leyenda) => {
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

document.addEventListener('DOMContentLoaded', function(){
    //add content to about
    var formMyNewContent = document.querySelector("#formMyNewContent");
	formMyNewContent.onsubmit = function (e) {
		e.preventDefault();
		var InputNombre = document.querySelector('#InputNombre').value;
		var InputDescripcion = document.querySelector('#InputDescripcion').value;
		var InputLink = document.querySelector('#InputLink').value;
		var InputEstado = document.querySelector('#InputEstado').value;

		if (InputNombre == '' || InputLink == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!campos.InputNombre || !campos.InputDescripcion || !campos.InputLink) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}

        divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'my/setMyContent';
		var formData = new FormData(formMyNewContent);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
                    $('#ModalFormMyNewContent').modal('hide');
					formMyNewContent.reset();
					swal("¡Contenido!", objData.msg, "success");
                    $("#MyContent").load(" #MyContent");
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
}, false);


function OpenModalMyNewContent() {
	document.querySelector('#id_my_content').value = "";
	document.querySelector('#title-modal-MNC').innerHTML = "Nuevo contenido - Area personal";
	document.querySelector('.modal-MNC').classList.replace("header-update", "header-register");
	document.querySelector('#btn-action-form-MNC').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn-MNC').innerHTML = "Guardar";
	document.querySelector('#formMyNewContent').reset();
	cleanResiduoVali();
	$('#ModalFormMyNewContent').modal('show');
}

function FctBtnEditarMyContent(id_my_content) {
    document.querySelector('#title-modal-MNC').innerHTML = "Actualizar contenido - Area personal";
	document.querySelector('.modal-MNC').classList.replace("header-register", "header-update");
	document.querySelector('#btn-action-form-MNC').classList.replace("btn-success", "btn-info");
	document.querySelector('#text-btn-MNC').innerHTML = "Actualizar";
	cleanResiduoVali();
	
	campos.InputNombre = true;
	campos.InputDescripcion = true;
	campos.InputLink = true;
	
    var id_my_content = id_my_content;
	divLoading.style.display = "flex";
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'my/getMyContent/' + id_my_content;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector('#id_my_content').value = objData.data.id_my_content;
				document.querySelector('#InputNombre').value = objData.data.name_content;
				document.querySelector('#InputDescripcion').value = objData.data.description;
				document.querySelector('#InputLink').value = objData.data.link;

                if (objData.data.status == 1) {
					var optionSlected = '<option class="none-block" value="1">Activo</option>';
				} else {
					var optionSlected = '<option class="none-block" value="2">Inactivo</option>';
				}

				var SelectHTML = `${optionSlected}
									<option value="1">Activo</option>
									<option value="2">Inactivo</option>
								`;

				document.querySelector('#InputEstado').innerHTML = SelectHTML;

			} else {
				swal("ERROR!", objData.msg, "error");
			}
		}
		divLoading.style.display = "none";
        return false;
    }
    $('#ModalFormMyNewContent').modal('show');
}

function countStudent(id_my_content) {
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'my/getAllCountStudent/' + id_my_content;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			document.querySelector('#count-students').innerHTML = objData.countStudents;
		}
    }
}

function OpenModalMsc(id_my_content, my_content) {
	document.querySelector('#id-my-content').value = id_my_content;
	document.querySelector('#my-content').innerHTML = my_content;
	countStudent(id_my_content);
	$('.Asc').hide();
	$('.Dsc').hide();
	$('#ModalFormMsc').modal('show');
}

function FctBtnEliminarMNC(id_my_content) {
    var id_my_content = id_my_content;
	swal({
		title: "¡Eliminar contenido!",
		text: "¿Estas seguro que deceas eliminar este contenido?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Eliminar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			divLoading.style.display = "flex";
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'my/deleteCourse/';
			var data = 'id_my_content=' + id_my_content;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Contenido!", objData.msg, "success");
						$("#MyContent").load(" #MyContent");
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

var DataTableAsc;
function OpenAsc(DSC, ASC) {
	var id_my_content = document.querySelector('#id-my-content').value;
	DataTableAsc = $('#DataTableAsc').DataTable({ /*ID de la tabla*/
        "aProcessing": true,
        "aServerside": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
        },
        "ajax": {
            "url": BASE_URL + "my/getAllStudentNotMyContent/"+id_my_content,/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "id_student" },
            { "data": "DNI" },
			{ "data": "nombres" },
			{ "data": "telefono" },
			{ "data": "email" },
            { "data": "Accion" },
        ],
        "bAutoWidth": false,
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10, /*Mostrará los primero 10 registros*/
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
	
	$(document).ready(() => {
		$(DSC).hide();
		$(ASC).show();
	});
}
var DataTableDsc;
function OpenDsc(DSC, ASC) {
	var id_my_content = document.querySelector('#id-my-content').value;
	DataTableDsc = $('#DataTableDsc').DataTable({ /*ID de la tabla*/
        "aProcessing": true,
        "aServerside": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
        },
        "ajax": {
            "url": BASE_URL + "my/getAllStudentYesMyContent/"+id_my_content,/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "id_detail_my_content_student" },
            { "data": "DNI" },
			{ "data": "nombres" },
			{ "data": "telefono" },
			{ "data": "email" },
            { "data": "Accion" },
        ],
        "bAutoWidth": false,
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10, /*Mostrará los primero 10 registros*/
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
	$(document).ready(() => {
		$(ASC).hide();
		$(DSC).show();
	});
}

function FctBtnAddOrDeleteStudent(DNI, option) {
	var id_content = document.querySelector('#id-my-content').value;
	var title = "";
	if (option == 1) {
		title = "¡Agregar al curso!";
	} else if (option == 2) {
		title = "¡Eliminar del curso!";
	}

	swal({
		title: title,
		text: "¿Decea continuar con el proceso?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, continuar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			swal.close();
			divLoading.style.display = "flex";
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'my/setStudentCourse';
			var data = 'idContent='+ id_content +'&DNI=' + DNI + "&option=" +option;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						//swal("¡Estudiante!", objData.msg, "success");
						DataTableAsc.ajax.reload();
						DataTableDsc.ajax.reload();
						setTimeout(countStudent(id_content));
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
