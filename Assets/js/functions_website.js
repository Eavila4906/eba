//Formulario de login
function OpenLoginForm(){
    document.querySelector('#formLogin').reset();
    $('#ModalLoginForm').modal('show');
}

document.addEventListener('DOMContentLoaded', function(){
    //login
    if (document.querySelector('#formLogin')) {
        let formLogin = document.querySelector('#formLogin');
        formLogin.onsubmit = function(e){
            e.preventDefault();
            let strUsernameEmail = document.querySelector('#InputUsername-email').value;
            let strPassword = document.querySelector('#InputPassword').value;

            if (strUsernameEmail == "" || strPassword == "") {
                var msg = '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Atención!</strong> Todos los campos son obligatorios.</div>'; 
                document.querySelector('#notificationLogin').innerHTML = msg;
                window.setTimeout(() =>{
                    $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                        $(this).remove();
                    });
                }, 5000);
                return false;
            } else {
                divLoading.style.display = "flex";
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = BASE_URL+'login/LoginUser';
                var formData =new FormData(formLogin);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                
                request.onreadystatechange = function() {
                    if (request.readyState != 4) return;
                    if (request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            if (objData.rol == "Super Administrador") {
                                window.location = BASE_URL+'dashboard';
                            } else {
                                window.location = BASE_URL+'my';
                            }
                        } else {
                            var msg = '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Atención!</strong> '+objData.msg+'.</div>'; 
                            document.querySelector('#notificationLogin').innerHTML = msg;
                            window.setTimeout(() =>{
                                $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                                    $(this).remove();
                                });
                            }, 5000);
                            document.querySelector('#InputPassword').value="";
                        }
                    } else {
                        var msg = '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Error!</strong> Login Filed.</div>'; 
                        document.querySelector('#notificationLogin').innerHTML = msg;
                        window.setTimeout(() =>{
                            $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                                $(this).remove();
                            });
                        }, 5000);
                    }
                    divLoading.style.display = "none";
                    return false;
                }
            }
        }
    }

    //contacto email
    if (document.querySelector('#contact-form')) {
        let formContact = document.querySelector('#contact-form');
        formContact.onsubmit = function(e) {
            e.preventDefault();
            var InputFullNameC = document.querySelector('#InputFullNameC').value;
            var InputEmailC = document.querySelector('#InputEmailC').value;
            var InputTelefonoC = document.querySelector('#InputTelefonoC').value;
            var InputMessageC = document.querySelector('#InputMessageC').value;

            if (InputFullNameC == "" || InputEmailC == "" || InputTelefonoC == "" || InputMessageC == "") {
                var msg = '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Atención!</strong> Todos los campos son obligatorios.</div>'; 
                document.querySelector('#AlertContactForm').innerHTML = msg;
                window.setTimeout(() =>{
                    $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                        $(this).remove();
                    });
                }, 5000);
                return false;
            }

            if (!campos.InputEmailC || !campos.InputTelefonoC) {
                var msg = '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Atención!</strong> Verifica los campos con su advertencia.</div>'; 
                document.querySelector('#AlertContactForm').innerHTML = msg;
                window.setTimeout(() =>{
                    $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                        $(this).remove();
                    });
                }, 5000);
                return false;
            }
            divLoading.style.display = "flex";
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = BASE_URL + 'site/sendEmailInformation';
            var formData = new FormData(formContact);
            request.open("POST", ajaxUrl, true);
            request.send(formData);

            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        var msg = `<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>¡Hecho!</strong> ${objData.msg}
                        </div>`; 
                        document.querySelector('#AlertContactForm').innerHTML = msg;
                        window.setTimeout(() =>{
                            $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                                $(this).remove();
                            });
                        }, 5000);
                        formContact.reset();
                    } else {
                        var msg = `<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>¡Error!</strong> ${objData.msg}
                        </div>`; 
                        document.querySelector('#AlertContactForm').innerHTML = msg;
                        window.setTimeout(() =>{
                            $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                                $(this).remove();
                            });
                        }, 5000);
                    }
                } else {
                    var msg = `<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>¡Error!</strong> Por favor intentalo mas tarde.
                        </div>`; 
                        document.querySelector('#AlertContactForm').innerHTML = msg;
                        window.setTimeout(() =>{
                            $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                                $(this).remove();
                            });
                        }, 5000);
                }
                divLoading.style.display = "none";
                return false;
		    }

        }
    }   
}, false);

//Formulario de solicitar registro
function OpenSolicitarRegistroForm(){
    document.querySelector('#formSolicitarRegistro').reset();
    cleanResiduoVali();
    $('#ModalFormSolicitarRegistro').modal('show');
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

document.addEventListener('DOMContentLoaded', function(){
    if (document.querySelector('#formSolicitarRegistro')) {
        var formSolicitarRegistro = document.querySelector('#formSolicitarRegistro');
        formSolicitarRegistro.onsubmit = function(e){
            e.preventDefault();
            var InputCedula = document.querySelector('#InputCedulaPasaporte').value;
            var InputNombres = document.querySelector('#InputNombres').value;
            var InputApellidoP = document.querySelector('#InputApellidoP').value;
            var InputApellidoM = document.querySelector('#InputApellidoM').value;
            var InputEmail = document.querySelector('#InputEmail').value;
            var InputTelefono = document.querySelector('#InputTelefono').value;
            var InputfechaNaci = document.querySelector('#InputfechaNaci').value;
            var InputSexo = document.querySelector('#InputSexo').value;

            if (InputCedula == '' || InputNombres == '' || InputApellidoP == '' || InputApellidoM == '' || InputEmail == '' || InputTelefono == '' || InputfechaNaci == '' || InputSexo == '') {
                var msg = '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Atención!</strong> Todos los campos son obligatorios.</div>'; 
                document.querySelector('#notificationSolicitarRegistro').innerHTML = msg;
                window.setTimeout(() =>{
                    $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                        $(this).remove();
                    });
                }, 5000);
                return false;
            }
            if (!camposRE.InputCedulaPasaporte || !camposRE.InputNombres || !camposRE.InputApellidoP || !camposRE.InputApellidoM || !camposRE.InputEmail || !camposRE.InputTelefono) {
                var msg = '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Atención!</strong> Verifica los campos en rojo.</div>'; 
                document.querySelector('#notificationSolicitarRegistro').innerHTML = msg;
                window.setTimeout(() =>{
                    $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                        $(this).remove();
                    });
                }, 5000);
                return false;
            }

            divLoading.style.display = "flex";
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = BASE_URL + 'login/requestRegistration';
            var formSoliRegistro = new FormData(formSolicitarRegistro);
            request.open("POST", ajaxUrl, true);
            request.send(formSoliRegistro);

            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        formSolicitarRegistro.reset();
                        var msg = `<div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert">&times;
                                    </button><strong>¡Hecho!</strong> ${objData.msg}.
                                </div>`; 
                        document.querySelector('#notificationSolicitarRegistro').innerHTML = msg;
                        window.setTimeout(() =>{
                            $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                                $(this).remove();
                                $('#ModalFormSolicitarRegistro').modal('hide');
                            });
                        }, 9000);
                        return false;
                    } else {
                        var msg = `<div class="alert alert-warning alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert">&times;
                                    </button><strong>¡Atención!</strong> ${objData.msg}.
                                </div>`; 
                        document.querySelector('#notificationSolicitarRegistro').innerHTML = msg;
                        window.setTimeout(() =>{
                            $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                                $(this).remove();
                            });
                        }, 5000);
                        return false;
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
}, false);

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

//Formulario de email 
const inputs = document.querySelectorAll('#contact-form input');
const expresiones = {
	email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{7,10}$/
}

const campos = {
	InputEmailC: false,
	InputTelefonoC: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "InputEmailC":
			validarCamposForm(expresiones.email, e.target, 'InputEmailC', 'leyenda-emailC');
		break;
		case "InputTelefonoC":
			validarCamposForm(expresiones.telefono, e.target, 'InputTelefonoC', 'leyenda-telefonoC');
		break;
	}
}

const validarCamposForm = (expresion, input, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		campos[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		campos[id_input] = false;
	}
}

inputs.forEach((input) => {
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});

/* Starts validacion de formulario registro */
const inputsRE = document.querySelectorAll('#formSolicitarRegistro input');
const expresionesRE = {
	cedula: /^\d{9,10}$/,
	nombres: /^[a-zA-ZÀ-ÿ\s]{1,45}$/,
	apellido: /^[a-zA-ZÀ-ÿ\s]{1,35}$/,
	email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{7,10}$/
}

const camposRE = {
	InputCedulaPasaporte: false,
	InputNombres: false,
	InputApellidoP: false,
	InputApellidoM: false,
	InputEmail: false,
	InputTelefono: false
}

const validarFormularioRE = (e) => {
	switch (e.target.name) {
		case "InputCedulaPasaporte":
			validarCamposFormRE(expresionesRE.cedula, e.target, 'labelCedula', 'InputCedulaPasaporte', 'leyenda-cedula');
		break;
		case "InputNombres":
			validarCamposFormRE(expresionesRE.nombres, e.target, 'labelNombres', 'InputNombres', 'leyenda-nombres');
		break;
		case "InputApellidoP":
			validarCamposFormRE(expresionesRE.apellido, e.target, 'labelApellidoP', 'InputApellidoP', 'leyenda-apellidoP');
		break;
		case "InputApellidoM":
			validarCamposFormRE(expresionesRE.apellido, e.target, 'labelApellidoM', 'InputApellidoM', 'leyenda-apellidoM');
		break;
		case "InputEmail":
			validarCamposFormRE(expresionesRE.email, e.target, 'labelEmail', 'InputEmail', 'leyenda-email');
		break;
		case "InputTelefono":
			validarCamposFormRE(expresionesRE.telefono, e.target, 'labelTelefono', 'InputTelefono', 'leyenda-telefono');
		break;
	}
}

const validarCamposFormRE = (expresion, input, label, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		document.getElementById(`${label}`).classList.remove('text-danger');
		camposRE[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		document.getElementById(`${label}`).classList.add('text-danger');
		camposRE[id_input] = false;
	}
}

inputsRE.forEach((input) => {
	input.addEventListener('keyup', validarFormularioRE);
	input.addEventListener('blur', validarFormularioRE);
});

/* Finish validacion de formulario registro */



