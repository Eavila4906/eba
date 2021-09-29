//Expreciones para validar formularios
const expresiones = {
	titulo: /^[a-zA-ZÀ-ÿ¿?¡!.,:;\s]{1,60}$/,
	descripcionCorta: /^[a-zA-ZÀ-ÿ0-9¡!%""$#.,:;()\s]{1,100}$/,
	descripcionLarga: /^[a-zA-ZÀ-ÿ0-9¡!%""$#.,:;()\s]{1,65535}$/,
	codigoFont: /^[a-zA-Z0-9]{1,4}$/,
	nombreFont: /^[a-zA-Z0-9\_\-]{4,45}$/,
	ubicacion: /^[a-zA-ZÀ-ÿ0-9\_\-\s]{1,75}$/,
	longitud: /^[a-zA-Z0-9''""°.:;\_\-]{1,25}$/,
	latitud: /^[a-zA-Z0-9''""°.:;\_\-]{1,25}$/,
	telefono: /^[0-9+\-\s]{7,35}$/,
	email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	nombreRedSocial: /^[a-zA-Z0-9]{1,15}$/,
	url: /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
}
//Limpiar residuo validacion
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
/* Start home */

/* Starts validacion de formulario add Contents home galery */
const inputsFHG = document.querySelectorAll('#formHomeGalery input');
const textareaFHG = document.querySelectorAll('#formHomeGalery textarea');

const camposFHG = {
	InputTitulo: false,
	InputDescripcion: false
}

const validarFormularioFHG = (e) => {
	switch (e.target.name) {
		case "InputTitulo":
			validarCamposFHG(expresiones.titulo, e.target, 'labelTituloHG', 'InputTitulo', 'leyenda-titulo-hg');
		break;
		case "InputDescripcion":
			validarCamposFHG(expresiones.descripcionCorta, e.target, 'labelDescripcionHG', 'InputDescripcion', 'leyenda-descripcion-hg');
		break;
	}
}

const validarCamposFHG = (expresion, input, label, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		document.getElementById(`${label}`).classList.remove('text-danger');
		camposFHG[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		document.getElementById(`${label}`).classList.add('text-danger');
		camposFHG[id_input] = false;
	}
}

inputsFHG.forEach((input) => {
	input.addEventListener('keyup', validarFormularioFHG);
	input.addEventListener('blur', validarFormularioFHG);
});
textareaFHG.forEach((textarea) => {
	textarea.addEventListener('keyup', validarFormularioFHG);
	textarea.addEventListener('blur', validarFormularioFHG);
});
/* Finish validacion de formulario add Contents home galery */

document.addEventListener('DOMContentLoaded', function(){
    if(document.querySelector("#image")){
        var image = document.querySelector("#image");
        image.onchange = function(e) {
            var uploadFoto = document.querySelector("#image").value;
            var fileimg = document.querySelector("#image").files;
            var nav = window.URL || window.webkitURL;
            var contactAlert = document.querySelector('#form_alert');
            if(uploadFoto !=''){
                var type = fileimg[0].type;
                var name = fileimg[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido!<br>Formatos validos: JPEG, JPG, PNG</p>';
                    if(document.querySelector('#img')){
                        document.querySelector('#img').remove();
                    }
                    document.querySelector('.delPhoto').classList.add("notBlock");
                    image.value="";
                    return false;
                }else{  
                    contactAlert.innerHTML='';
                    if(document.querySelector('#img')){
                        document.querySelector('#img').remove();
                    }
                    document.querySelector('.delPhoto').classList.remove("notBlock");
                    var objeto_url = nav.createObjectURL(this.files[0]);
                    document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objeto_url+">";
                    document.querySelector('#name_photo').innerHTML = `<p class="col-md-3"><b>Archivo:</b> ${name}</p>`;
                }
            }else{
                alert("No selecciono ninguna imagen");
                if(document.querySelector('#img')){
                    document.querySelector('#img').remove();
                }
            }
        }
    }

    if(document.querySelector(".delPhoto")){
        var delPhoto = document.querySelector(".delPhoto");
	    delPhoto.onclick = function(e) {
            document.querySelector("#image_remove").value= 1;
	        removePhoto();
	    }
    }

    //add content to home gallery
    var formHomeGalery = document.querySelector("#formHomeGalery");
	formHomeGalery.onsubmit = function (e) {
		e.preventDefault();
		var InputTitulo = document.querySelector('#InputTitulo').value;
		var InputDescripcion = document.querySelector('#InputDescripcion').value;
		var InputEstado = document.querySelector('#InputEstado').value;
        var InputImage = document.querySelector('#image').value;

		if (InputTitulo == '' || InputDescripcion == '' || InputEstado == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!camposFHG.InputTitulo || !camposFHG.InputDescripcion) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}

        divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'publicsite/setContentGaleryHome';
		var formData = new FormData(formHomeGalery);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
                    $('#ModalFormHomeGalery').modal('hide');
					formHomeGalery.reset();
					swal("¡Contenido!", objData.msg, "success");
                    $("#home").load(" #home");
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

function removePhoto(){
    document.querySelector('#image').value ="";
    document.querySelector('#name_photo').innerHTML = "";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if(document.querySelector('#img')){
        document.querySelector('#img').remove();
    }
}

function FctBtnEditarConteHome(id_cont) {
    document.querySelector('#title-modal').innerHTML = "Actualizar contenido - Galeria de inicio";
	document.querySelector('.modal-header').classList.replace("header-register", "header-update");
	document.querySelector('#btn-action-form').classList.replace("btn-success", "btn-info");
	document.querySelector('#text-btn').innerHTML = "Actualizar";
	cleanResiduoVali();
	camposFHG.InputTitulo = true;
	camposFHG.InputDescripcion = true;

    var id_cont = id_cont;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'publicsite/getContents/' + id_cont;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector('#id_cont').value = objData.data.id_cont;
                document.querySelector('#image_actual').value = objData.data.image;
                document.querySelector("#image_remove").value = 0;
				document.querySelector('#InputTitulo').value = objData.data.titulo;
				document.querySelector('#InputDescripcion').value = objData.data.descripcion;
                document.querySelector('.delPhoto').classList.remove("notBlock");
                document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objData.data.url_image+">";
                //document.querySelector('#name_photo').innerHTML = `<p class="col-md-3"><b>Archivo:</b> ${objData.data.image}</p>`;
				
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

			} else {
				swal("ERROR!", objData.msg, "error");
			}
		}
    }
    $('#ModalFormHomeGalery').modal('show');
}

function FctBtnEliminarConteHome(id_cont, img) {
    var id_cont = id_cont;
    var img = img;
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
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'publicsite/deleteContents/';
			var data = 'id_cont=' + id_cont + '&' + 'img=' + img;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Contenido!", objData.msg, "success");
						$("#home").load(" #home");
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
			}
		}
	});
}

function OpenModalAddContentsHomeGalery() {
	document.querySelector('#id_cont').value = "";
	document.querySelector('#title-modal').innerHTML = "Nuevo contenido - Galeria de inicio";
	document.querySelector('.modal-header').classList.replace("header-update", "header-register");
	document.querySelector('#btn-action-form').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn').innerHTML = "Guardar";
	document.querySelector('#formHomeGalery').reset();
	cleanResiduoVali();
	$('#ModalFormHomeGalery').modal('show');
    removePhoto();
    document.querySelector('#name_photo').innerHTML = "";
    document.querySelector('#form_alert').innerHTML = "";
}
/* Finish home */

/* Start icons */
/* Starts validacion de formulario add icons */
const inputsFIC = document.querySelectorAll('#formIcons input');

const camposFIC = {
	InputCodigo: false,
	InputNombre: false
}

const validarFormularioFIC = (e) => {
	switch (e.target.name) {
		case "InputCodigo":
			validarCamposFIC(expresiones.codigoFont, e.target, 'labelCodigo', 'InputCodigo', 'leyenda-codigo');
		break;
		case "InputNombre":
			validarCamposFIC(expresiones.nombreFont, e.target, 'labelNombreIC', 'InputNombre', 'leyenda-nombreic');
		break;
	}
}

const validarCamposFIC = (expresion, input, label, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		document.getElementById(`${label}`).classList.remove('text-danger');
		camposFIC[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		document.getElementById(`${label}`).classList.add('text-danger');
		camposFIC[id_input] = false;
	}
}

inputsFIC.forEach((input) => {
	input.addEventListener('keyup', validarFormularioFIC);
	input.addEventListener('blur', validarFormularioFIC);
});
/* Finish validacion de formulario add icons */

document.addEventListener('DOMContentLoaded', function(){
	//add icons
	var formIcons = document.querySelector("#formIcons");
	formIcons.onsubmit = function (e) {
		e.preventDefault();
		var InputCodigo = document.querySelector('#InputCodigo').value;
		var InputNombre = document.querySelector('#InputNombre').value;

		if (InputCodigo == '' || InputNombre == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!camposFIC.InputCodigo || !camposFIC.InputNombre) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}

		divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'publicsite/setIcon';
		var formData = new FormData(formIcons);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					$('#ModalFormIcons').modal('hide');
					formIcons.reset();
					swal("¡Icono!", objData.msg, "success");
					setTimeout(getIconsAbout, 2000);
					setTimeout(getIconsSocialMedia, 2000);
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

window.addEventListener('load', function() {
	getIconsAbout();
	getIconsSocialMedia();
}, false);

function getIconsAbout(){
	if(document.querySelector('#InputIconoAbout')){
		var ajaxUrl = BASE_URL + 'publicsite/getAllIconsAbout';
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		request.open("GET",ajaxUrl,true);
		request.send();
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				var SelectHTML = `<option selected disabled class="none-block">Selecciona un icono</option>
								${request.responseText}
							`;
				document.querySelector('#InputIconoAbout').innerHTML = SelectHTML;
				//$('#InputIcono').selectpicker('render');
			}
		}
	}
}

function getIconsSocialMedia() {
	if(document.querySelector('#InputIconoRS')){
		var ajaxUrl = BASE_URL + 'publicsite/getAllIconsSocialMedia';
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		request.open("GET",ajaxUrl,true);
		request.send();
		request.onreadystatechange = function(){
			if(request.readyState == 4 && request.status == 200){
				var SelectHTML = `<option selected disabled class="none-block">Selecciona un icono</option>
								${request.responseText}
							`;
				document.querySelector('#InputIconoRS').innerHTML = SelectHTML;
				//$('#InputIcono').selectpicker('render');
			}
		}
	}	
}

function OpenModalAddIcons() {
	document.querySelector('#formIcons').reset();
	cleanResiduoVali();
	$('#ModalFormIcons').modal('show');
}
/* Finish icons */

/* Start about */
/* Starts validacion de formulario add Contents about */
const inputsFAB = document.querySelectorAll('#formAbout input');
const textareaFAB = document.querySelectorAll('#formAbout textarea');

const camposFAB = {
	InputTituloAbout: false,
	InputDescripcionAbout: false
}

const validarFormularioFAB = (e) => {
	switch (e.target.name) {
		case "InputTituloAbout":
			validarCamposFAB(expresiones.titulo, e.target, 'labelTituloAB', 'InputTituloAbout', 'leyenda-titulo-ab');
		break;
		case "InputDescripcionAbout":
			validarCamposFAB(expresiones.descripcionLarga, e.target, 'labelDescripcionAB', 'InputDescripcionAbout', 'leyenda-descripcion-ab');
		break;
	}
}

const validarCamposFAB = (expresion, input, label, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		document.getElementById(`${label}`).classList.remove('text-danger');
		camposFAB[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		document.getElementById(`${label}`).classList.add('text-danger');
		camposFAB[id_input] = false;
	}
}

inputsFAB.forEach((input) => {
	input.addEventListener('keyup', validarFormularioFAB);
	input.addEventListener('blur', validarFormularioFAB);
});
textareaFAB.forEach((textarea) => {
	textarea.addEventListener('keyup', validarFormularioFAB);
	textarea.addEventListener('blur', validarFormularioFAB);
});
/* Finish validacion de formulario add Contents about */
document.addEventListener('DOMContentLoaded', function(){
    //add content to about
    var formAbout = document.querySelector("#formAbout");
	formAbout.onsubmit = function (e) {
		e.preventDefault();
		var InputTituloAbout = document.querySelector('#InputTituloAbout').value;
		var InputDescripcionAbout = document.querySelector('#InputDescripcionAbout').value;
		var InputEstadoAbout = document.querySelector('#InputEstadoAbout').value;
        var InputIcono= document.querySelector('#InputIconoAbout').value;

		if (InputTituloAbout == '' || InputDescripcionAbout == '' || InputEstadoAbout == '' || InputIcono == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!camposFAB.InputTituloAbout || !camposFAB.InputDescripcionAbout) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}

        divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'publicsite/setContentAbout';
		var formData = new FormData(formAbout);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
                    $('#ModalFormAbout').modal('hide');
					formAbout.reset();
					swal("¡Contenido!", objData.msg, "success");
                    $("#about").load(" #about");
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

function FctBtnEditarConteAbout(id_contAbout) {
    document.querySelector('#title-modal-about').innerHTML = "Actualizar contenido - Acerca de";
	document.querySelector('.modal-about').classList.replace("header-register", "header-update");
	document.querySelector('#btn-action-form-about').classList.replace("btn-success", "btn-info");
	document.querySelector('#text-btn-about').innerHTML = "Actualizar";
	cleanResiduoVali();
	camposFAB.InputTituloAbout = true;
	camposFAB.InputDescripcionAbout = true;

    var id_contAbout = id_contAbout;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'publicsite/getContentsAbout/' + id_contAbout;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector('#id_contAbout').value = objData.data.id_cont;
				document.querySelector('#InputTituloAbout').value = objData.data.titulo;
				document.querySelector('#InputDescripcionAbout').value = objData.data.descripcion;
				document.querySelector('#InputIconoAbout').value = objData.data.icon;
				//$('#InputIcono').selectpicker('render');

                if (objData.data.estado == 1) {
					var optionSlected = '<option class="none-block" value="1">Activo</option>';
				} else {
					var optionSlected = '<option class="none-block" value="2">Inactivo</option>';
				}

				var SelectHTML = `${optionSlected}
									<option value="1">Activo</option>
									<option value="2">Inactivo</option>
								`;

				document.querySelector('#InputEstadoAbout').innerHTML = SelectHTML;

			} else {
				swal("ERROR!", objData.msg, "error");
			}
		}
    }
    $('#ModalFormAbout').modal('show');
}

function FctBtnEliminarConteAbout(id_contAbout) {
    var id_contAbout = id_contAbout;
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
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'publicsite/deleteContentsAbout/';
			var data = 'id_contAbout=' + id_contAbout;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Contenido!", objData.msg, "success");
						$("#about").load(" #about");
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
			}
		}
	});
}

function OpenModalAddContentsAbout() {
	document.querySelector('#id_contAbout').value = "";
	document.querySelector('#title-modal-about').innerHTML = "Nuevo contenido - Acerca de";
	document.querySelector('.modal-about').classList.replace("header-update", "header-register");
	document.querySelector('#btn-action-form-about').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn-about').innerHTML = "Guardar";
	document.querySelector('#formAbout').reset();
	cleanResiduoVali();
	$('#ModalFormAbout').modal('show');
}

//Leer Mas y Leer Menos
function leerMas(id, t1, t2) {
	$(document).ready(() => {
		$(t1).hide();
		$(t2).show('slow');
	});
}

function leerMenos(id, t1, t2) {
	$(document).ready(() => {
		$(t2).hide('slow');
		$(t1).show('slow');
	});
}

/* Finish about */

/* Footer */

/* Start Headquarter */
/* Starts validacion de formulario add Contents headquarter */
const inputsFHQ = document.querySelectorAll('#formHeadquarter input');

const camposFHQ = {
	InputUbicacion: false,
	InputLongitud: false,
	InputLatitud: false
}

const validarFormularioFHQ = (e) => {
	switch (e.target.name) {
		case "InputUbicacion":
			validarCamposFHQ(expresiones.ubicacion, e.target, 'labelUbicación', 'InputUbicacion', 'leyenda-ubicación');
		break;
		case "InputLongitud":
			validarCamposFHQ(expresiones.longitud, e.target, 'labelLongitud', 'InputLongitud', 'leyenda-longitud');
		break;
		case "InputLatitud":
			validarCamposFHQ(expresiones.latitud, e.target, 'labelLatitud', 'InputLatitud', 'leyenda-latitud');
		break;
	}
}

const validarCamposFHQ = (expresion, input, label, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		document.getElementById(`${label}`).classList.remove('text-danger');
		camposFHQ[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		document.getElementById(`${label}`).classList.add('text-danger');
		camposFHQ[id_input] = false;
	}
}

inputsFHQ.forEach((input) => {
	input.addEventListener('keyup', validarFormularioFHQ);
	input.addEventListener('blur', validarFormularioFHQ);
});
/* Finish validacion de formulario add Contents headquarter */
document.addEventListener('DOMContentLoaded', function(){
    //add content to about
    var formHeadquarter = document.querySelector("#formHeadquarter");
	formHeadquarter.onsubmit = function (e) {
		e.preventDefault();
		var InputUbicacion = document.querySelector('#InputUbicacion').value;
		var InputLongitud = document.querySelector('#InputLongitud').value;
		var InputLatitud = document.querySelector('#InputLatitud').value;
		var InputEstadoH = document.querySelector('#InputEstadoH').value;

		if (InputUbicacion == '' || InputLongitud == '' || InputLatitud == '' || InputEstadoH == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!camposFHQ.InputUbicacion || !camposFHQ.InputLongitud || !camposFHQ.InputLatitud) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}

        divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'publicsite/setHeadquarter';
		var formData = new FormData(formHeadquarter);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
                    $('#ModalFormHeadquarter').modal('hide');
					formHeadquarter.reset();
					swal("¡Sede!", objData.msg, "success");
                    $("#headquarter").load(" #headquarter");
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

function FctBtnEditarHeadquarter(id_Headquarter) {
    document.querySelector('#title-modal-Headquarter').innerHTML = "Actualizar sede";
	document.querySelector('.modal-Headquarter').classList.replace("header-register", "header-update");
	document.querySelector('#btn-action-form-Headquarter').classList.replace("btn-success", "btn-info");
	document.querySelector('#text-btn-Headquarter').innerHTML = "Actualizar";
	cleanResiduoVali();
	camposFHQ.InputUbicacion = true;
	camposFHQ.InputLongitud = true;
	camposFHQ.InputLatitud = true;

    var id_Headquarter = id_Headquarter;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'publicsite/getHeadquarter/' + id_Headquarter;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector('#id_headquarter').value = objData.data.id_headquarter;
				document.querySelector('#InputUbicacion').value = objData.data.ubicacion;
				document.querySelector('#InputLongitud').value = objData.data.longitud;
				document.querySelector('#InputLatitud').value = objData.data.latitud;
				//$('#InputIcono').selectpicker('render');

                if (objData.data.estado == 1) {
					var optionSlected = '<option class="none-block" value="1">Activo</option>';
				} else {
					var optionSlected = '<option class="none-block" value="2">Inactivo</option>';
				}

				var SelectHTML = `${optionSlected}
									<option value="1">Activo</option>
									<option value="2">Inactivo</option>
								`;

				document.querySelector('#InputEstadoH').innerHTML = SelectHTML;

			} else {
				swal("ERROR!", objData.msg, "error");
			}
		}
    }
    $('#ModalFormHeadquarter').modal('show');
}

function FctBtnEliminarHeadquarter(id_headquarter) {
    var id_headquarter = id_headquarter;
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
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'publicsite/deleteHeadquarter/';
			var data = 'id_headquarter=' + id_headquarter;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Sede!", objData.msg, "success");
						$("#headquarter").load(" #headquarter");
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
			}
		}
	});
}

function OpenModalAddHeadquarter() {
	document.querySelector('#id_headquarter').value = "";
	document.querySelector('#title-modal').innerHTML = "Nuevo contenido - Galeria de inicio";
	document.querySelector('.modal-Headquarter').classList.replace("header-update", "header-register");
	document.querySelector('#btn-action-form-Headquarter').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn-Headquarter').innerHTML = "Guardar";
	document.querySelector('#formHeadquarter').reset();
	cleanResiduoVali();
	$('#ModalFormHeadquarter').modal('show');
}
/* Finish Headquarter */

/* Starts contacts */
/* Starts validacion de formulario add contacts */
const inputsFCT = document.querySelectorAll('#formContacts input');

const camposFCT = {
	InputTelefono: false,
	InputEmail: false
}

const validarFormularioFCT = (e) => {
	switch (e.target.name) {
		case "InputTelefono":
			validarCamposFCT(expresiones.telefono, e.target, 'labelTelefono', 'InputTelefono', 'leyenda-telefono');
		break;
		case "InputEmail":
			validarCamposFCT(expresiones.email, e.target, 'labelEmail', 'InputEmail', 'leyenda-email');
		break;
	}
}

const validarCamposFCT = (expresion, input, label, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		document.getElementById(`${label}`).classList.remove('text-danger');
		camposFCT[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		document.getElementById(`${label}`).classList.add('text-danger');
		camposFCT[id_input] = false;
	}
}

inputsFCT.forEach((input) => {
	input.addEventListener('keyup', validarFormularioFCT);
	input.addEventListener('blur', validarFormularioFCT);
});
/* Finish validacion de formulario add contacts */

document.addEventListener('DOMContentLoaded', function(){
    //add content to about
    var formContacts = document.querySelector("#formContacts");
	formContacts.onsubmit = function (e) {
		e.preventDefault();
		var InputTelefono = document.querySelector('#InputTelefono').value;
		var InputEmail = document.querySelector('#InputEmail').value;
		var InputEstadoC = document.querySelector('#InputEstadoC').value;

		if (InputTelefono == '' || InputEmail == '' || InputEstadoC == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!camposFCT.InputTelefono || !camposFCT.InputEmail) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}

        divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'publicsite/setContacts';
		var formData = new FormData(formContacts);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
                    $('#ModalFormContacts').modal('hide');
					formContacts.reset();
					swal("¡Contacto!", objData.msg, "success");
                    $("#contacts").load(" #contacts");
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

function FctBtnEditarContacts(id_Contacts) {
    document.querySelector('#title-modal-Contacts').innerHTML = "Actualizar contacto";
	document.querySelector('.modal-Contacts').classList.replace("header-register", "header-update");
	document.querySelector('#btn-action-form-Contacts').classList.replace("btn-success", "btn-info");
	document.querySelector('#text-btn-Contacts').innerHTML = "Actualizar";
	cleanResiduoVali();
	camposFCT.InputTelefono = true;
	camposFCT.InputEmail = true;

    var id_Contacts = id_Contacts;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'publicsite/getContacts/' + id_Contacts;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector('#id_contacts').value = objData.data.id_contacts;
				document.querySelector('#InputTelefono').value = objData.data.telefono;
				document.querySelector('#InputEmail').value = objData.data.email;
				//$('#InputIcono').selectpicker('render');

                if (objData.data.estado == 1) {
					var optionSlected = '<option class="none-block" value="1">Activo</option>';
				} else {
					var optionSlected = '<option class="none-block" value="2">Inactivo</option>';
				}

				var SelectHTML = `${optionSlected}
									<option value="1">Activo</option>
									<option value="2">Inactivo</option>
								`;

				document.querySelector('#InputEstadoC').innerHTML = SelectHTML;

			} else {
				swal("ERROR!", objData.msg, "error");
			}
		}
    }
    $('#ModalFormContacts').modal('show');
}

function FctBtnEliminarContacts(id_contacts) {
    var id_contacts = id_contacts;
	swal({
		title: "¡Eliminar contacto!",
		text: "¿Estas seguro que deceas eliminar este contacto?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Eliminar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'publicsite/deleteContacts/';
			var data = 'id_contacts=' + id_contacts;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Contacto!", objData.msg, "success");
						$("#contacts").load(" #contacts");
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
			}
		}
	});
}

function OpenModalAddContacts() {
	document.querySelector('#id_contacts').value = "";
	document.querySelector('#title-modal-Contacts').innerHTML = "Nuevo contacto";
	document.querySelector('.modal-Contacts').classList.replace("header-update", "header-register");
	document.querySelector('#btn-action-form-Contacts').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn-Contacts').innerHTML = "Guardar";
	document.querySelector('#formContacts').reset();
	cleanResiduoVali();
	$('#ModalFormContacts').modal('show');
}

/* Finish contacts */

/* Starts social media */
/* Starts validacion de formulario add social media */
const inputsFSM = document.querySelectorAll('#formSocialMedia input');

const camposFSM = {
	InputNombreRS: false,
	InputLinkRS: false
}

const validarFormularioFSM = (e) => {
	switch (e.target.name) {
		case "InputNombreRS":
			validarCamposFSM(expresiones.nombreRedSocial, e.target, 'labelNombre', 'InputNombreRS', 'leyenda-nombre');
		break;
		case "InputLinkRS":
			validarCamposFSM(expresiones.url, e.target, 'labelLink', 'InputLinkRS', 'leyenda-link');
		break;
	}
}

const validarCamposFSM = (expresion, input, label, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		document.getElementById(`${label}`).classList.remove('text-danger');
		camposFSM[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		document.getElementById(`${label}`).classList.add('text-danger');
		camposFSM[id_input] = false;
	}
}

inputsFSM.forEach((input) => {
	input.addEventListener('keyup', validarFormularioFSM);
	input.addEventListener('blur', validarFormularioFSM);
});
/* Finish validacion de formulario add social media */
document.addEventListener('DOMContentLoaded', function(){
    //add content to about
    var formSocialMedia = document.querySelector("#formSocialMedia");
	formSocialMedia.onsubmit = function (e) {
		e.preventDefault();
		var InputNombreRS = document.querySelector('#InputNombreRS').value;
		var InputLinkRS = document.querySelector('#InputLinkRS').value;

		if (InputNombreRS == '' || InputLinkRS == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!camposFSM.InputNombreRS || !camposFSM.InputLinkRS) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}

        divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'publicsite/setSocialMedia';
		var formData = new FormData(formSocialMedia);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
                    $('#ModalFormSocialMedia').modal('hide');
					formSocialMedia.reset();
					swal("¡Red social!", objData.msg, "success");
                    $("#social_media").load(" #social_media");
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

function FctBtnEditarSocialMedia(id_socialMedia) {
    document.querySelector('#title-modal-SocialMedia').innerHTML = "Actualizar red social";
	document.querySelector('.modal-SocialMedia').classList.replace("header-register", "header-update");
	document.querySelector('#btn-action-form-SocialMedia').classList.replace("btn-success", "btn-info");
	document.querySelector('#text-btn-SocialMedia').innerHTML = "Actualizar";
	cleanResiduoVali();
	camposFSM.InputNombreRS = true;
	camposFSM.InputLinkRS = true;

    var id_socialMedia = id_socialMedia;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'publicsite/getSocialMedia/' + id_socialMedia;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
				document.querySelector('#id_socialMedia').value = objData.data.id_socialMedia;
				document.querySelector('#InputNombreRS').value = objData.data.nombre;
				document.querySelector('#InputLinkRS').value = objData.data.link;
				document.querySelector('#InputIconoRS').value = objData.data.icono;
				//$('#InputIcono').selectpicker('render');

                if (objData.data.estado == 1) {
					var optionSlected = '<option class="none-block" value="1">Activo</option>';
				} else {
					var optionSlected = '<option class="none-block" value="2">Inactivo</option>';
				}

				var SelectHTML = `${optionSlected}
									<option value="1">Activo</option>
									<option value="2">Inactivo</option>
								`;

				document.querySelector('#InputEstadoRS').innerHTML = SelectHTML;

			} else {
				swal("ERROR!", objData.msg, "error");
			}
		}
    }
    $('#ModalFormSocialMedia').modal('show');
}

function FctBtnEliminarSocialMedia(id_socialMedia) {
    var id_socialMedia = id_socialMedia;
	swal({
		title: "¡Eliminar red social!",
		text: "¿Estas seguro que deceas eliminar esta red social de tu sitio?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Eliminar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'publicsite/deleteSocialMedia/';
			var data = 'id_socialMedia=' + id_socialMedia;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Red social!", objData.msg, "success");
						$("#social_media").load(" #social_media");
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
			}
		}
	});
}

function OpenModalAddSocialMedia() {
	document.querySelector('#id_socialMedia').value = "";
	document.querySelector('#title-modal-SocialMedia').innerHTML = "Nueva red social";
	document.querySelector('.modal-SocialMedia').classList.replace("header-update", "header-register");
	document.querySelector('#btn-action-form-SocialMedia').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn-SocialMedia').innerHTML = "Guardar";
	document.querySelector('#formSocialMedia').reset();
	cleanResiduoVali();
	$('#ModalFormSocialMedia').modal('show');
}
/* Finish social media */

/* Start teacher */
document.addEventListener('DOMContentLoaded', function(){
    //add content to about
    var formSocialMedia = document.querySelector("#formSocialMedia");
	formSocialMedia.onsubmit = function (e) {
		e.preventDefault();
		var InputNombreRS = document.querySelector('#InputNombreRS').value;
		var InputLinkRS = document.querySelector('#InputLinkRS').value;

		if (InputNombreRS == '' || InputLinkRS == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!camposFSM.InputNombreRS || !camposFSM.InputLinkRS) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}

        divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'publicsite/setSocialMedia';
		var formData = new FormData(formSocialMedia);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
                    $('#ModalFormSocialMedia').modal('hide');
					formSocialMedia.reset();
					swal("¡Red social!", objData.msg, "success");
                    $("#social_media").load(" #social_media");
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

function FctBtnOnOrOffTeacher(id_teacher, option) {
	var title = "";
	if (option == 1) {
		title = "¡Agregar a portada!";
	} else {
		title = "¡Quitar de la portada!";
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
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'publicsite/setTeacherContent/';
			var data = 'id_teacher=' + id_teacher + "&option=" +option;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Docente!", objData.msg, "success");
						$('#ModalFormTeachers').modal('hide');
						$("#teacher").load(" #teacher");
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
			}
		}
	});
}

function OpenModalAddContentsTeachers() {
	DataTableSeePayment = $('#DataTableTeachers').DataTable({ /*ID de la tabla*/
        "aProcessing": true,
        "aServerside": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
        },
        "ajax": {
            "url": BASE_URL + "publicsite/getAllTeachersSelect/",/* Ruta a la funcion getRoles que esta en el controlador roles.php*/
            "dataSrc": ""
        },
        "columns": [/* Campos de la base de datos*/
            { "data": "id_teacher" },
            { "data": "DNI" },
			{ "data": "nombres" },
            { "data": "Accion" },
        ],
        "bAutoWidth": false,
        "responsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10, /*Mostrará los primero 10 registros*/
        "order": [[0, "desc"]] /*Ordenar de forma Desendente*/
    });
	$('#ModalFormTeachers').modal('show');
}
/* Finish teacher */

/* Start hide and show contents */
	function fctHide(contents, btnHide, btnShow, space, btnAdd, title) {
		$(document).ready(() => {
			$(btnHide).hide('slow');
			$(space).hide('slow');
			$(btnAdd).hide('slow');
			$(contents).hide('slow');
			document.querySelector(title).classList.replace("text-secondary", "text-primary");
			$(btnShow).show('slow');
		});
	}

	function fctShow(contents, btnHide, btnShow, space, btnAdd, title) {
		$(document).ready(() => {
			$(btnHide).show('slow');
			$(space).show('slow');
			$(btnAdd).show('slow');
			$(contents).show('slow');
			document.querySelector(title).classList.replace("text-primary", "text-secondary");
			$(btnShow).hide('slow');
		});
	}
/* Finish hide and show contents */