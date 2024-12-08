// Verificar si existe el parámetro 'status' en la URL
const urlParams = new URLSearchParams(window.location.search);
const status = urlParams.get('status');
const message = urlParams.get('message'); // Obtener el mensaje de la URL

if (status === 'success') {
    Swal.fire({
        title: 'Éxito',
        text: 'Correo de restablecimiento de contraseña enviado. Checa la bandeja de tu correo.',
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
} else if (status === 'error') {
    Swal.fire({
        title: 'Error',
        text: message ? decodeURIComponent(message) : 'Ocurrió un error inesperado.',
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
}
