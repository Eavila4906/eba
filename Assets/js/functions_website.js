//Formulario de login
function OpenLoginForm(){
    document.querySelector('#formLogin').reset();
    $('#ModalLoginForm').modal('show');
}

document.addEventListener('DOMContentLoaded', function(){
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
                        swal("¡ERROR!", "Proceso fallido.", "error");
                    }
                    return false;
                }
            }
        }
    }
}, false);

//Formulario de solicitar registro
function OpenSolicitarRegistroForm(){
    document.querySelector('#formSolicitarRegistro').reset();
    $('#ModalFormSolicitarRegistro').modal('show');
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
            } else {
               
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