document.addEventListener("DOMContentLoaded", function() {
    // Aquí se añadirán las alertas basadas en las sesiones de PHP
    if (window.error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: window.error
        });
    }

    if (window.success) {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: window.success
        });
    }
});
