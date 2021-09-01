var expresiones = {
	email: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/
}

var camposFRP = {
	InputEmailRP: false
}

/* Starts Validacion del formulario de cambiar password */
var inputsRestPassword = document.querySelectorAll('#formResetPass input');

const validarFormularioRP = (e) => {
	switch (e.target.name) {
		case "InputEmailRP":
			validarCamposFRP(expresiones.email, e.target, 'labelEmailRP', 'InputEmailRP', 'leyenda-emailRP');
		break;
	}
}

const validarCamposFRP = (expresion, input, label, id_input, leyenda) => {
	if(expresion.test(input.value)){
        document.getElementById(`${id_input}`).classList.remove('invalid');
        document.getElementById(`${leyenda}`).classList.add('none-block');
		document.getElementById(`${label}`).classList.remove('text-danger');
		camposFRP[id_input] = true;
	} else {
		document.getElementById(`${id_input}`).classList.add('invalid');
		document.getElementById(`${leyenda}`).classList.remove('none-block');
		document.getElementById(`${label}`).classList.add('text-danger');
		camposFRP[id_input] = false;
	}
}

inputsRestPassword.forEach((input) => {
	input.addEventListener('keyup', validarFormularioRP);
	input.addEventListener('blur', validarFormularioRP);
});

/* Finish Validacion del formulario de cambiar password */

document.addEventListener('DOMContentLoaded', function(){
	//add icons
	var formResetPass = document.querySelector("#formResetPass");
	formResetPass.onsubmit = function (e) {
		e.preventDefault();
		var InputEmailRP = document.querySelector('#InputEmailRP').value;

		if (InputEmailRP == '') {
			swal("¡Atención!", "El campo es obligatorio, por lo tanto no puede estar vacío.", "warning");
			return false;
		}
		if (!camposFRP.InputEmailRP) {
			swal("¡Atención!", "Verifica el campo en rojo.", "warning");
			return false;
		}
        
		divLoading.style.display = "flex";
		var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		var ajaxUrl = BASE_URL + 'login/resetPassword';
		var formData = new FormData(formResetPass);
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