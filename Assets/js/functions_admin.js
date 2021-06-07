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