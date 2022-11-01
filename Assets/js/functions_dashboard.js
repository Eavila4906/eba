$(document).ready(function () {
	if (document.querySelector('#module-dashboard')) {
		document.querySelector('#module-dashboard').classList.add('is-expanded');
		if (document.querySelector('#dashboard')) {
			$("#dashboard").attr("data-toggle", "treeview");
		}
	}
});
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

function loadCountAccounting() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = BASE_URL+'dashboard/getCountAccounting';
    
    request.open("POST", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            document.querySelector('#CountAccounting').innerHTML = objData.data.countAccounting;
        } else {
            document.querySelector('#CountAccounting').innerHTML = "ERROR!";
        }
        return false;
    }
}

setTimeout(loadCoutUsers, 1000);
//setTimeout(loadCountCourses, 1000);
setTimeout(loadCountStudens, 1000);
setTimeout(loadCountTeachers, 1000);
setTimeout(loadCountAccounting, 1000);
/*setInterval(loadCoutUsers, 2000);
setInterval(loadCountCourses, 2000);
setInterval(loadCountStudens, 2000);
setInterval(loadCountTeachers, 2000);*/

