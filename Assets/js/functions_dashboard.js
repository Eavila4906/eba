function loadCoutUsers() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = BASE_URL+'dashboard/getCountUsers';
    
    request.open("POST", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            document.querySelector('#CountUsers').innerHTML = objData.data.countUsers;
        } else {
            document.querySelector('#CountUsers').innerHTML = "ERROR!";
        }
        return false;
    }
}

function loadCountCourses() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = BASE_URL+'dashboard/getCountCourses';
    
    request.open("POST", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            document.querySelector('#CountCourses').innerHTML = objData.data.countCourses;
        } else {
            document.querySelector('#CountCourses').innerHTML = "ERROR!";
        }
        return false;
    }
}

function loadCountStudens() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = BASE_URL+'dashboard/getCountStudens';
    
    request.open("POST", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            document.querySelector('#CountStudens').innerHTML = objData.data.countStudens;
        } else {
            document.querySelector('#CountStudens').innerHTML = "ERROR!";
        }
        return false;
    }
}

function loadCountTeachers() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = BASE_URL+'dashboard/getCountTeachers';
    
    request.open("POST", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            document.querySelector('#CountTeachers').innerHTML = objData.data.countTeachers;
        } else {
            document.querySelector('#CountTeachers').innerHTML = "ERROR!";
        }
        return false;
    }
}

/*$(document).ready(function () {
	$('#ModalNotificacion').modal('show');
});*/

setInterval(loadCoutUsers, 2000);
setInterval(loadCountCourses, 2000);
setInterval(loadCountStudens, 2000);
setInterval(loadCountTeachers, 2000);

