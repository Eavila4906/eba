var expresiones = {
	password: /^.{8,16}$/,
	email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{7,10}$/
}

var camposFUP = {
	InputNewPass: false,
	InputConfirmPass: false
}

var camposFUDU = {
	InputEmail: false,
	InputTelefono: false
}
/* Starts Validacion del formulario de cambiar password */
var inputsUpdatePassword = document.querySelectorAll('#FormUpdatePassword input');

const validarFormularioUP = (e) => {
	switch (e.target.name) {
		case "InputNewPass":
			validarCamposFormUP(expresiones.password, e.target, 'labelNewPass', 'InputNewPass', 'leyenda-new-pass');
            validarConfirmPass();
		break;
		case "InputConfirmPass":
			validarConfirmPass();
		break;
	}
}

const validarCamposFormUP = (expresion, input, label, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		document.getElementById(`${label}`).classList.remove('text-danger');
		camposFUP[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		document.getElementById(`${label}`).classList.add('text-danger');
		camposFUP[id_input] = false;
	}
}

const validarConfirmPass = () => {
	var inputPassword1 = document.getElementById('InputNewPass');
	var inputPassword2 = document.getElementById('InputConfirmPass');

	if(inputPassword1.value !== inputPassword2.value){
		document.getElementById(`InputConfirmPass`).classList.add('invalid');
		document.getElementById(`leyenda-confi-pass`).classList.remove('none-block');
		document.getElementById('labelConfirmPass').classList.add('text-danger');
		camposFUP['InputConfirmPass'] = false;
	} else {
		document.getElementById(`InputConfirmPass`).classList.remove('invalid');
		document.getElementById(`leyenda-confi-pass`).classList.add('none-block');
		document.getElementById('labelConfirmPass').classList.remove('text-danger');
		camposFUP['InputConfirmPass'] = true;
	}
}

inputsUpdatePassword.forEach((input) => {
	input.addEventListener('keyup', validarFormularioUP);
	input.addEventListener('blur', validarFormularioUP);
});

/* Finish Validacion del formulario de cambiar password */

/* Starts Validacion del formulario de update data user */
var inputsUpdateDataUser = document.querySelectorAll('#FormUpdateDataUser input');

const validarFormularioUDU = (e) => {
	switch (e.target.name) {
		case "InputEmail":
			validarCamposFormUDU(expresiones.email, e.target, 'labelEmail', 'InputEmail', 'leyenda-email');
		break;
		case "InputTelefono":
			validarCamposFormUDU(expresiones.telefono, e.target, 'labelTelefono', 'InputTelefono', 'leyenda-telefono');
		break;
	}
}

const validarCamposFormUDU = (expresion, input, label, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		document.getElementById(`${label}`).classList.remove('text-danger');
		camposFUDU[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		document.getElementById(`${label}`).classList.add('text-danger');
		camposFUDU[id_input] = false;
	}
}

inputsUpdateDataUser.forEach((input) => {
	input.addEventListener('keyup', validarFormularioUDU);
	input.addEventListener('blur', validarFormularioUDU);
});

/* Finish Validacion del formulario de update data user */


//Update profile
function editPhotoProfile(id_session) {
    var id_session = id_session;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'profile/getPhotoProfile/' + id_session;
	request.open("GET", ajaxUrl, true);
	request.send();

	divLoading.style.display = "flex";
    request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
                document.querySelector('#photo_actual').value = objData.data.photo;
                document.querySelector("#photo_remove").value = 0;
                document.querySelector('.delPhotoProfile').classList.remove("notBlock");
                document.querySelector('.prevPhotoProfile div').innerHTML = "<img id='img' src="+objData.data.url_photo+">";
            } else {
				swal("ERROR!", objData.msg, "error");
			}
		}
		divLoading.style.display = "none";
        return false;
    }
    $('#ModalSubirFoto').modal('show');
    document.querySelector('#form_alert').innerHTML = "";
}

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
                    document.querySelector('.delPhotoProfile').classList.add("notBlock");
                    image.value="";
                    return false;
                }else{  
                    contactAlert.innerHTML='';
                    if(document.querySelector('#img')){
                        document.querySelector('#img').remove();
                    }
                    document.querySelector('.delPhotoProfile').classList.remove("notBlock");
                    var objeto_url = nav.createObjectURL(this.files[0]);
                    document.querySelector('.prevPhotoProfile div').innerHTML = "<img id='img' src="+objeto_url+">";
                }
            }else{
                alert("No selecciono ninguna imagen");
                if(document.querySelector('#img')){
                    document.querySelector('#img').remove();
                }
            }
        }
    }

    if(document.querySelector(".delPhotoProfile")){
        var delPhoto = document.querySelector(".delPhotoProfile");
	    delPhoto.onclick = function(e) {
            document.querySelector("#photo_remove").value= 1;
	        removePhoto();
	    }
    }

    //add profile photo
    var formActualizarFoto = document.querySelector("#formActualizarFoto");
	formActualizarFoto.onsubmit = function (e) {
		e.preventDefault();
        //divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'profile/setProfilePhoto';
		var formData = new FormData(formActualizarFoto);
		request.open("POST", ajaxUrl, true);
		request.send(formData);
		
		divLoading.style.display = "flex";
		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
                    $('#ModalSubirFoto').modal('hide');
					formActualizarFoto.reset();
                    showDataUser();
				} else {
					swal("¡Atención!", objData.msg, "warning");
				}
			}
            divLoading.style.display = "none";
            return false;
		}
	}

    //update data user
    var FormUpdateDataUser = document.querySelector("#FormUpdateDataUser");
	FormUpdateDataUser.onsubmit = function (e) {
		e.preventDefault();
		var InputDNI = document.querySelector('#InputDNI').value;
		var InputNombres = document.querySelector('#InputNombres').value;
		var InputApellidoP = document.querySelector('#InputApellidoP').value;
        var InputTelefono = document.querySelector('#InputTelefono').value;
        var InputEmail = document.querySelector('#InputEmail').value;
		camposFUDU.InputEmail = true;
		camposFUDU.InputTelefono = true;

		if (InputDNI == '' || InputNombres == '' || InputApellidoP == '' || InputTelefono == '' || InputEmail == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
		if (!camposFUDU.InputEmail || !camposFUDU.InputTelefono) {
            swal("¡Atención!", "Verifica el campo en rojo.", "warning");
			return false;
        }
        
        divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'profile/updateDataUser';
		var formData = new FormData(FormUpdateDataUser);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					swal("¡Datos!", objData.msg, "success");
                    showDataUser();
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

    //update password
    var FormUpdatePassword = document.querySelector("#FormUpdatePassword");
	FormUpdatePassword.onsubmit = function (e) {
		e.preventDefault();
		var InputCurrentPass = document.querySelector('#InputCurrentPass').value;
		var InputNewPass = document.querySelector('#InputNewPass').value;
		var InputConfirmPass = document.querySelector('#InputConfirmPass').value;

		if (InputCurrentPass == '' || InputNewPass == '' || InputConfirmPass == '') {
			swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
			return false;
		}
        if (!camposFUP.InputNewPass || !camposFUP.InputConfirmPass) {
			console.log('funciona');
            swal("¡Atención!", "Verifica el campo en rojo.", "warning");
			return false;
        }
        divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'profile/updatePassword';
		var formData = new FormData(FormUpdatePassword);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					swal("¡Hecho!", objData.msg, "success");
                    FormUpdatePassword.reset();
                    showDataUser();
				} else {
					var msg = '<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>¡Atención!</strong>'+objData.msg+'</div>'; 
                    document.querySelector('#notificationPass').innerHTML = msg;
                    document.querySelector('#InputCurrentPass').value="";
                    window.setTimeout(() =>{
                        $('.alert').fadeTo(1500, 0).slideDown(1000, function(){
                            $(this).remove();
                        });
                    }, 5000);
				}
			}
            divLoading.style.display = "none";
            return false;
		}
	}
}, false);

function removePhoto(){
    document.querySelector('#image').value ="";
    document.querySelector('.delPhotoProfile').classList.add("notBlock");
    if(document.querySelector('#img')){
        document.querySelector('#img').remove();
    }
}

