var inputsFormResetPassword = document.querySelectorAll('#formRestablecerPass input');

var expresiones = {
	password: /^.{8,16}$/
}

var camposFRP = {
	InputPassword: false,
	InputConfirmPass: false
}

const validarFormularioRP = (e) => {
	switch (e.target.name) {
		case "InputPassword":
			validarCamposFormRP(expresiones.password, e.target, 'InputPassword', 'leyenda-password');
            validarConfirmPass();
		break;
		case "InputConfirmPass":
			validarConfirmPass();
		break;
	}
}

const validarCamposFormRP = (expresion, input, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		camposFRP[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		camposFRP[id_input] = false;
	}
}

const validarConfirmPass = () => {
	var inputPassword1 = document.getElementById('InputPassword');
	var inputPassword2 = document.getElementById('InputConfirmPass');

	if(inputPassword1.value !== inputPassword2.value){
		document.getElementById(`InputConfirmPass`).classList.add('invalid');
		document.getElementById(`leyenda-confi-pass`).classList.remove('none-block');
		camposFRP['InputConfirmPass'] = false;
	} else {
		document.getElementById(`InputConfirmPass`).classList.remove('invalid');
		document.getElementById(`leyenda-confi-pass`).classList.add('none-block');
		camposFRP['InputConfirmPass'] = true;
	}
}

inputsFormResetPassword.forEach((input) => {
	input.addEventListener('keyup', validarFormularioRP);
	input.addEventListener('blur', validarFormularioRP);
});

document.addEventListener('DOMContentLoaded', function(){
	var formRestablecerPass = document.querySelector("#formRestablecerPass");
	formRestablecerPass.onsubmit = function (e) {
		e.preventDefault();
		var InputPassword = document.querySelector('#InputPassword').value;
        var InputConfirmPass = document.querySelector('#InputConfirmPass').value;
		var id_usuario = document.querySelector('#id_usuario').value;

		if (InputPassword == '' || InputConfirmPass == '' || id_usuario == '') {
			swal("¡Atención!", "Los campos son obligatorio, por lo tanto no puede estar vacío.", "warning");
			return false;
		}
		if (!camposFRP.InputPassword || !camposFRP.InputConfirmPass) {
			swal("¡Atención!", "Verifica los campos en rojo.", "warning");
			return false;
		}
        
		divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'login/updatePassword';
		var formData = new FormData(formRestablecerPass);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) {
				var objData = JSON.parse(request.responseText);
				if (objData.status) {
					swal({
                        title: "",
                        text: objData.msg,
                        type: "success",
                        confirmButtonText: "Aceptar",
                        closeOnConfirm: false,
                    }, function(isConfirm) {
                        if (isConfirm) {
                            window.location = BASE_URL;
                        }
                    });
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