



document.getElementById('RecuperacionContra_form').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que el formulario se pueda envíe automáticamente

    
    const email = document.getElementById('email').value;

    // Validar correo y contraseña
    if (validarEmail(email)) {
       swal('Genial','Inicio de Sesión exitoso','success');
       this.submit();
   }
});






// Función para validar el formato del correo
function validarEmail(email) {
    const emailverificar = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailverificar.test(email)) {
        swal('Error','Por favor ingresa un correo válido','error');
        return false;
    }
    return true;
}