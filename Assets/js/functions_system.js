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

function ftnSeeNotifications(id_notification, tipo, fecha, leida, mes, descripcion) {
    var id_notification = id_notification;
    var tipo = tipo;
    var fecha = fecha;
    var leida = leida;
    var mes = mes;
    var descripcion = descripcion;
    if (leida == 0) {
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = BASE_URL+'my/markRead';
        var data = 'id_notification=' + id_notification;
        request.open("POST", ajaxUrl, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(data);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    setTimeout(notifications, 10);
                } else {
                    swal("ERROR!", objData.msg, "error");
                }
            }
        }
    }
    if (tipo == "Pago" || tipo == "Pago Inicial" || tipo == "Pago Final") {
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = BASE_URL+'my/infoNotificaionsPayment';
        var data = 'date=' + fecha;
        request.open("POST", ajaxUrl, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(data);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    //info payment
                    document.querySelector('#periodo').innerHTML = objData.data.periodo;
                    document.querySelector('#fechapago').innerHTML = objData.data.fecha_pago;
                    document.querySelector('#cantidad').innerHTML = "$"+objData.data.valor;
                    //info payment next
                    if (tipo == "Pago Final") {
                        document.querySelector('#periodo-pp').innerHTML = "--------------------------------------";
                        document.querySelector('#fecha-pp').innerHTML = "--------------------------------------";
                        document.querySelector('#cantidad-pp').innerHTML = "--------------------------------------";
                    } else {
                        document.querySelector('#periodo-pp').innerHTML = objData.data.periodo;
                        document.querySelector('#fecha-pp').innerHTML = objData.data.fecha_pp;
                        document.querySelector('#cantidad-pp').innerHTML = "$"+objData.data.valor;
                    }
                    //info of payments
                    document.querySelector('#meses-pagados').innerHTML = objData.data.meses_pagados;
                    document.querySelector('#meses-por-pagar').innerHTML = objData.data.meses_por_pagar;
                    document.querySelector('#meses-contables').innerHTML = objData.data.meses_contables;
                } else {
                    swal("ERROR!", objData.msg, "error");
                }
            }
        }
        document.querySelector('#title').innerHTML = tipo;
        document.querySelector('#Mes').innerHTML = mes;
        document.querySelector('#Notifications-paymets').classList.remove('notBlock');
        document.querySelector('#Notifications-payment-reminder').classList.add('notBlock');
        document.querySelector('#Notifications-late-payment').classList.add('notBlock');
        document.querySelector('#modal-header').classList.remove('bg-warning');
        document.querySelector('#modal-header').classList.remove('text-dark');
        document.querySelector('#modal-header').classList.remove('bg-danger');
    } else if (tipo == "Recordatorio de pago") {
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = BASE_URL+'my/infoNotificationPaymentReminder';
        var data = 'date=' + fecha;
        request.open("POST", ajaxUrl, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(data);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    document.querySelector('#periodo-pp-rp').innerHTML = objData.data.periodo;
                    document.querySelector('#fecha-pp-rp').innerHTML = objData.data.fecha_pp;
                    document.querySelector('#cantidad-pp-rp').innerHTML = "$"+objData.data.valor;
                } else {
                    swal("ERROR!", objData.msg, "error");
                }
            }
        }
        document.querySelector('#Notifications-payment-reminder').classList.remove('notBlock');
        document.querySelector('#Notifications-paymets').classList.add('notBlock');
        document.querySelector('#Notifications-late-payment').classList.add('notBlock');
        document.querySelector('#modal-header').classList.remove('bg-danger');
        document.querySelector('#modal-header').classList.add('bg-warning');
        document.querySelector('#modal-header').classList.add('text-dark');
        document.querySelector('#title').innerHTML = tipo;
        document.querySelector('#Mes').innerHTML = mes;
        document.querySelector('#descripcion').innerHTML = descripcion;
    } else {
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = BASE_URL+'my/infoNotificationPaymentReminder';
        var data = 'date=' + fecha;
        request.open("POST", ajaxUrl, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(data);
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    document.querySelector('#periodo-pp-pa').innerHTML = objData.data.periodo;
                    document.querySelector('#fecha-pp-pa').innerHTML = objData.data.fecha_pp;
                    document.querySelector('#cantidad-pp-pa').innerHTML = "$"+objData.data.valor;
                } else {
                    swal("ERROR!", objData.msg, "error");
                }
            }
        }
        document.querySelector('#Notifications-late-payment').classList.remove('notBlock');
        document.querySelector('#Notifications-paymets').classList.add('notBlock');
        document.querySelector('#Notifications-payment-reminder').classList.add('notBlock');
        document.querySelector('#modal-header').classList.remove('bg-warning');
        document.querySelector('#modal-header').classList.remove('text-dark');
        document.querySelector('#modal-header').classList.add('bg-danger');
        document.querySelector('#title').innerHTML = tipo;
        document.querySelector('#Mes').innerHTML = mes;
        document.querySelector('#descripcion-pa').innerHTML = descripcion;
    }
    $('#ModalNotificacions').modal('show');
}

//notifications
function notifications() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = BASE_URL+'my/notifications';
    request.open("POST", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                //Count Notifications
                var count = 0;
                var notifications = objData.data;
                notifications.forEach(function(notifications) {
                    if(notifications.leida == 0) {
                        count++;
                    } 
                }); 
                if (count > 0) {
                    document.querySelector('#countNotifications').classList.remove('notBlock');
                    document.querySelector('#countNotifications').innerHTML = count;
                    document.querySelector('#title-notifications').innerHTML = `<span>Tienes (${count}) notificaciones sin leer.</spam>`;
                } else {
                    document.querySelector('#countNotifications').classList.add('notBlock');
                    document.querySelector('#title-notifications').innerHTML = `<span>No tienes notificaciones para mostrar.</spam>`;
                }
                //Notifications
                var html = document.querySelector('#Notifications');
                html.innerHTML = '';
                for (var item of notifications) {
                    var tipo = "'"+item.tipo+"'";
                    var fecha = "'"+item.fecha+"'";
                    var mes = "'"+item.Mes+"'";
                    var descripcion = new String("'"+item.descripcion+"'");
                    if (item.tipo == "Pago" || item.tipo == "Pago Inicial" || item.tipo == "Pago Final") {
                        if (item.leida == 0) {
                            html.innerHTML += `
                                <li class="not-read">
                                    <a class="app-notification__item" href="javascript:;" 
                                        onclick="ftnSeeNotifications(${item.id_notifications}, ${tipo}, ${fecha}, ${item.leida}, ${mes})"
                                        title="Leer">
                                        <span class="app-notification__icon">
                                            <span class="fa-stack fa-lg">
                                                <i class="fa fa-circle fa-stack-2x text-success"></i>
                                                <i class="fas fa-dollar-sign fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </span>
                                        <div>
                                            <p class="app-notification__message">${item.tipo} - ${item.Mes}</p>
                                            <p class="app-notification__meta">${item.fecha}</p>
                                        </div>  
                                    </a>
                                </li>
                            `;
                        } else {
                            html.innerHTML += `
                            <li>
                                <a class="app-notification__item" href="javascript:;" 
                                    onclick="ftnSeeNotifications(${item.id_notifications}, ${tipo}, ${fecha}, ${item.leida}, ${mes})"
                                    title="Ver">
                                    <span class="app-notification__icon">
                                        <span class="fa-stack fa-lg">
                                            <i class="fa fa-circle fa-stack-2x text-success"></i>
                                            <i class="fas fa-dollar-sign fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </span>
                                    <div>
                                        <p class="app-notification__message">${item.tipo} - ${item.Mes}</p>
                                        <p class="app-notification__meta">${item.fecha}</p>
                                    </div>  
                                </a>
                            </li>
                        `;
                        }
                        
                    } else if (item.tipo == "Recordatorio de pago"){
                        if (item.leida == 0) {
                            html.innerHTML += `
                                <li class="not-read">
                                    <a class="app-notification__item" href="javascript:;"
                                        onclick="ftnSeeNotifications(${item.id_notifications}, ${tipo}, ${fecha}, ${item.leida}, ${mes}, ${descripcion})"
                                        title="Leer">
                                        <span class="app-notification__icon">
                                            <span class="fa-stack fa-lg">
                                                <i class="fa fa-circle fa-stack-2x text-warning"></i>
                                                <i class="fas fa-clock fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </span>
                                        <div>
                                            <p class="app-notification__message">${item.tipo}</p>
                                            <p class="app-notification__meta">${item.fecha}</p>
                                        </div>  
                                    </a>
                                </li>
                            `;
                        } else {
                            html.innerHTML += `
                                <li>
                                    <a class="app-notification__item" href="javascript:;"
                                        onclick="ftnSeeNotifications(${item.id_notifications}, ${tipo}, ${fecha}, ${item.leida}, ${mes}, ${descripcion})"
                                        title="Ver">
                                        <span class="app-notification__icon">
                                            <span class="fa-stack fa-lg">
                                                <i class="fa fa-circle fa-stack-2x text-warning"></i>
                                                <i class="fas fa-calendar-alt fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </span>
                                        <div>
                                            <p class="app-notification__message">${item.tipo}</p>
                                            <p class="app-notification__meta">${item.fecha}</p>
                                        </div>  
                                    </a>
                                </li>
                            `;
                        }  
                    }  else {
                        if (item.leida == 0) {
                            html.innerHTML += `
                                <li class="not-read">
                                    <a class="app-notification__item" href="javascript:;"
                                        onclick="ftnSeeNotifications(${item.id_notifications}, ${tipo}, ${fecha}, ${item.leida}, ${mes}, ${descripcion})"
                                        title="Leer">
                                        <span class="app-notification__icon">
                                            <span class="fa-stack fa-lg">
                                                <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                                <i class="fas fa-hand-holding-usd fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </span>
                                        <div>
                                            <p class="app-notification__message">${item.tipo}</p>
                                            <p class="app-notification__meta">${item.fecha}</p>
                                        </div>  
                                    </a>
                                </li>
                            `;
                        } else {
                            html.innerHTML += `
                                <li>
                                    <a class="app-notification__item" href="javascript:;"
                                        onclick="ftnSeeNotifications(${item.id_notifications}, ${tipo}, ${fecha}, ${item.leida}, ${mes}, ${descripcion})"
                                        title="Ver">
                                        <span class="app-notification__icon">
                                            <span class="fa-stack fa-lg">
                                                <i class="fa fa-circle fa-stack-2x text-danger"></i>
                                                <i class="fas fa-hand-holding-usd fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </span>
                                        <div>
                                            <p class="app-notification__message">${item.tipo}</p>
                                            <p class="app-notification__meta">${item.fecha}</p>
                                        </div>  
                                    </a>
                                </li>
                            `;
                        }
                    }
                }
            } else {
                swal("ERROR!", objData.msg, "error"); 
            }
        }
        return false;
    }
}

$(document).ready(function(){
    notifications();
});
setInterval(notifications, 30000);


/*
var datetime = null;
function notificationsLoading() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = BASE_URL+'my/notificationsLoading';
    var data = 'date='+datetime;
    request.open("POST", ajaxUrl, true);
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    request.send(data);

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            datetime = objData.data.fecha;

            if (datetime == null) {
                 
            } else {
                $.ajax({
                    async: true,
                    type: "POST",
                    url: BASE_URL+'my/notifications',
                    data: "",
                    dataType: "html",
                    success: function(data) {
                        var objData1 = eval("("+data+")");
                        if (objData1.status) {
                            //Count Notifications
                            var count = 0;
                            var notifications = objData1.data;
                            notifications.forEach(function(notifications) {
                                if(notifications.leida == 0) {
                                    count++;
                                }
                                
                            }); 
                            if (count > 0) {
                                document.querySelector('#countNotifications').innerHTML = count;
                                document.querySelector('#title-notifications').innerHTML = `<span>Tienes (${count}) notificaciones sin leer.</spam>`;
                            } else {
                                document.querySelector('#title-notifications').innerHTML = `<span>No tienes notificaciones para mostrar.</spam>`;
                            }
                        }
                    }
                });
                
                
            }
            
        }
        //setTimeout(notificationsLoading, 1000);
        return false;
    }
}




function cargar() {
    $.ajax({
        async: true,
        type: "POST",
        url: BASE_URL+'my/notificationsLoading',
        data: "&date="+datetime,
        dataType: "html",
        success: function(data) {
            var objData1 = eval("("+data+")");
            datetime = objData1.data.fecha;

            if (datetime == null) {
                 
            } else {
                $.ajax({
                    async: true,
                    type: "POST",
                    url: BASE_URL+'my/notifications',
                    data: "",
                    dataType: "html",
                    success: function(data) {
                        var objData2 = eval("("+data+")");
                        if (objData2.status) {
                            //Count Notifications
                            var count = 0;
                            var notifications = objData2.data;
                            notifications.forEach(function(notifications) {
                                if(notifications.leida == 0) {
                                    count++;
                                }
                                
                            }); 
                            if (count > 0) {
                                document.querySelector('#countNotifications').innerHTML = count;
                                document.querySelector('#title-notifications').innerHTML = `<span>Tienes (${count}) notificaciones sin leer.</spam>`;
                            } else {
                                document.querySelector('#title-notifications').innerHTML = `<span>No tienes notificaciones para mostrar.</spam>`;
                            }
                        }
                    }
                });  
            }
            setTimeout('cargar()', 1000);
        }
    });
}

$(document).ready(function(){
    cargar();
});
*/