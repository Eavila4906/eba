//Cerrar sesion
function logout() {
    swal({
        title: "¡Cerrar Sesión!",
        text: "¿Estas seguro en cerrar sesión?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si",
        cancelButtonText: "cancelar",
        closeOnConfirm: false,
        closeOnCancel: true,
    }, function(isConfirm) {
        if (isConfirm) {
            window.location.href = BASE_URL+"logout";
        }
    });
}

//show Data user
window.addEventListener('load', function() {
	showDataUser();
}, false);

function showDataUser() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'profile/getDataUser/';
	request.open("POST", ajaxUrl, true);
	request.send();

    divLoading.style.display = "flex";
    request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);
			if (objData.status) {
                /* show photo profile */
                if (document.querySelector('#photo-profile')) {
                    document.querySelector('#photo-profile').src = objData.data.url_photo;
                }
                if (document.querySelector('#photo-profile-nav')) {
                    document.querySelector('#photo-profile-nav').src = objData.data.url_photo;
                }
                /* show data profile */
                if (document.querySelector('#DNI')) {
                    document.querySelector('#DNI').innerHTML = objData.data.DNI;
                }
                if (document.querySelector('#nombres')) {
                    document.querySelector('#nombres').innerHTML = objData.data.nombres;
                }
                if (document.querySelector('#apellidos')) {
                    document.querySelector('#apellidos').innerHTML = objData.data.apellidoP+" "+objData.data.apellidoM;
                }
                if (document.querySelector('#sexo')) {
                    if (objData.data.sexo == 'M') {
                        document.querySelector('#sexo').innerHTML = "Masculino";
                    } else {
                        document.querySelector('#sexo').innerHTML = "Femenino";
                    }   
                }
                if (document.querySelector('#fechaNacimiento')) {
                    var fecha =new Date(objData.data.fechaNaci);
                    var formato = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    document.querySelector('#fechaNacimiento').innerHTML = fecha.toLocaleDateString("es-ES", formato);
                }
                if (document.querySelector('#email')) {
                    document.querySelector('#email').innerHTML = objData.data.email;
                }
                if (document.querySelector('#telefono')) {
                    document.querySelector('#telefono').innerHTML = objData.data.telefono;
                }
                /* show data profile update*/
                if (document.querySelector('#InputDNI')) {
                    document.querySelector('#InputDNI').value = objData.data.DNI;
                }
                if (document.querySelector('#InputNombres')) {
                    document.querySelector('#InputNombres').value = objData.data.nombres;
                }
                if (document.querySelector('#InputApellidoP')) {
                    document.querySelector('#InputApellidoP').value = objData.data.apellidoP;
                }
                if (document.querySelector('#InputApellidoM')) {
                    document.querySelector('#InputApellidoM').value = objData.data.apellidoM;
                }
                if (document.querySelector('#sexo')) {
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
                }
                if (document.querySelector('#InputFechaNaci')) {
                    document.querySelector('#InputFechaNaci').value = objData.data.fechaNaci;
                }
                if (document.querySelector('#InputEmail')) {
                    document.querySelector('#InputEmail').value = objData.data.email;
                }
                if (document.querySelector('#InputTelefono')) {
                    document.querySelector('#InputTelefono').value = objData.data.telefono;
                }
			}
		}
        divLoading.style.display = "none";
        return false;
    }
}