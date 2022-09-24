

function openModalCurses() {
	document.querySelector('#id_curses').value = "";
	document.querySelector('#title-modal-curses').innerHTML = "Nuevo Curso";
	document.querySelector('#modal-header-curses').classList.replace("header-update", "header-register");
	document.querySelector('#btn-action-form').classList.replace("btn-info", "btn-success");
	document.querySelector('#text-btn').innerHTML = "Guardar";
	document.querySelector('#formCurses').reset();
	//cleanResiduoVali();
	$('#ModalFormCurses').modal('show');
}