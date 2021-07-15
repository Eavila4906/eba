document.addEventListener('DOMContentLoaded', function(){
    if (document.querySelector('#formLoginAdmin')) {
        let formLoginAdmin = document.querySelector('#formLoginAdmin');
        formLoginAdmin.onsubmit = function(e){
            e.preventDefault();
            let strUsernameEmail = document.querySelector('#textUsername-email').value;
            let strPassword = document.querySelector('#textPassword').value;

            if (strUsernameEmail == "" || strPassword == "") {
                swal("¡Atención!", "Todos los campos son obligatorios.", "warning");
                return false;
            } else {
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = BASE_URL+'admin/LogearSuperAdmin';
                var formData =new FormData(formLoginAdmin);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                
                request.onreadystatechange = function() {
                    if (request.readyState != 4) return;
                    if (request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            window.location = BASE_URL+'dashboard';
                        } else {
                            swal("¡Atención!", objData.msg, "warning");
                            document.querySelector('#textPassword').value="";
                        }
                    } else {
                        swal("¡ERROR!", "Proceso fallido.", "error");
                    }
                    return false;
                }
            }
        }
    }
}, false);