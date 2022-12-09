$(document).ready(function () {
	if (document.querySelector('#module-backup')) {
		document.querySelector('#module-backup').classList.add('is-expanded');
		if (document.querySelector('#backup')) {
			$("#backup").attr("data-toggle", "treeview");
		}
	}
});

var DataTableBackup;
document.addEventListener('DOMContentLoaded', function () {

	DataTableBackup = $('#DataTableBackup').DataTable({ /*ID de la tabla*/
		"aProcessing": true,
		"aServerside": true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json" /*Idioma de visualizacion*/
		},
		"ajax": {
			"url": BASE_URL + "backup/getAllBackup",
			"dataSrc": ""
		},
		"columns": [/* Campos de la base de datos*/
			{ "data": "id_backup_format" },
			{ "data": "create_by_format" },
			{ "data": "nombreRol" },
			{ "data": "creation_date" },
			{ "data": "Acciones" }
		],
		"responsieve": "true",
		"bDestroy": true,
		"iDisplayLength": 10, /*Mostrará los primero 10 registros*/
		"order": [[0, "desc"]] /*Ordenar de forma Desendente*/
	});
});

function FctBackup() {
	var backup = "backup";
	swal({
		title: "¡Backup!",
		text: "¿Estas seguro que deceas hacer un respaldo de la base de datos?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Descargar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'backup/backupExecute';
			request.open("POST", ajaxUrl, true);
			data = 'backup=' + backup;
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Backup!", objData.msg, "success");
						DataTableBackup.ajax.reload();
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
			}
		}
	});
}

function FctBtnInfoBackup(id_backup) {
	var id_backup = id_backup;
	var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	var ajaxUrl = BASE_URL + 'backup/getBackup/' + id_backup;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) {
			var objData = JSON.parse(request.responseText);

			var status1 = objData.data.status;
			var removaldata = objData.data.removal_date;
			if (status1 == 1 && removaldata == '0000-00-00 00:00:00') {
				document.querySelector('#tr-file').classList.remove('notBlock');
				document.querySelector('#tr-getEliminatedBy').classList.add('notBlock');
				document.querySelector('#tr-getRemovalDate').classList.add('notBlock');

				document.querySelector('#getTitleBackup').innerHTML = objData.data.nameFile_format;
				document.querySelector('#getIdBackup').innerHTML = objData.data.id_backup;
				document.querySelector('#getNameFile').innerHTML = objData.data.nameFile_format;
				document.querySelector('#getCreateBy').innerHTML = objData.data.create_by;
				document.querySelector('#getCreationDate').innerHTML = objData.data.creation_date;
				document.querySelector('#file').innerHTML = objData.data.file;
			} else {
				document.querySelector('#tr-file').classList.add('notBlock');
				document.querySelector('#tr-getEliminatedBy').classList.remove('notBlock');
				document.querySelector('#tr-getRemovalDate').classList.remove('notBlock');

				document.querySelector('#getTitleBackup').innerHTML = objData.data.nameFile_format;
				document.querySelector('#getIdBackup').innerHTML = objData.data.id_backup;
				document.querySelector('#getNameFile').innerHTML = objData.data.nameFile_format;
				document.querySelector('#getCreateBy').innerHTML = objData.data.create_by;
				document.querySelector('#getCreationDate').innerHTML = objData.data.creation_date;
				document.querySelector('#getEliminatedBy').innerHTML = objData.data.eliminated_by;
				document.querySelector('#getRemovalDate').innerHTML = objData.data.removal_date;
			}

			if (objData.data.status == 1) {
				var status = '<spam class="badge badge-success">Activo</spam>';
			} else {
				var status = '<spam class="badge badge-danger">Inactivo</spam>';
			}
			document.querySelector('#getStatus').innerHTML = status;
		}
	}
	$('#ModalInfoBackup').modal('show');
}

function FctBtnDeleteBackup(id_backup, file) {
	var id_backup = id_backup;
	var file = file;
	swal({
		title: "¡Eliminar registro!",
		text: "¿Estas seguro que deceas eliminar este registro?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Eliminar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			divLoading.style.display = "flex";
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'backup/backupDelete/';
			var data = 'id_backup=' + id_backup + '&file=' + file;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Backup!", objData.msg, "success");
						DataTableBackup.ajax.reload();
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
				divLoading.style.display = "none";
            	return false;
			}
		}
	});
}

function downloadBackup(file) {
	var id_backup = id_backup;
	var file = file;
	swal({
		title: "¡Descargar!",
		text: "¿Estas seguro que deceas descargar este archivo?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, confirmar",
		cancelButtonText: "No, cancelar",
		closeOnConfirm: false,
		closeOnCancel: true,
	}, function (isConfirm) {
		if (isConfirm) {
			divLoading.style.display = "flex";
			var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			var ajaxUrl = BASE_URL + 'backup/downloadBackup/';
			var data = 'file=' + file;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(data);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) {
					var objData = JSON.parse(request.responseText);
					if (objData.status) {
						swal("¡Descarga!", objData.msg, "success");
						DataTableBackup.ajax.reload();
					} else {
						swal("ERROR!", objData.msg, "error");
					}
				}
				divLoading.style.display = "none";
            	return false;
			}
		}
	});
}