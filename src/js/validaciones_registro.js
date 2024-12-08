//funcion para ir al login
const home = () => window.location.href = 'index.php'; 

const check = () => swal('Genial','Tus datos cumplen con las validaciones puedes continuar con el pago','success');


document.getElementById('btnSiguiente1').addEventListener('click', function(event) {
    event.preventDefault();
    
    
    var nombre = document.getElementById('nombreR').value.trim();
    var apellido = document.getElementById('apellidR').value.trim();
    var correo = document.getElementById('correo').value.trim();
    var password1 = document.getElementById('password').value.trim();
    var password2 = document.getElementById('password2').value.trim();

    localStorage.setItem('lastName', apellido);
    localStorage.setItem('correo', correo);

    
    // Validaciones
    if (nombre === "") {
        swal('Te falto llenar un campo','Por favor ingresa tu nombre.','error');
        return;
    }
    
    if (apellido === "") {
        swal('Te falto llenar un campo','Por favor ingresa tu apellido.','error');
        return;
    }
    
    if (correo === "") {
        swal('Te falto llenar un campo','Por favor ingresa tu correo.','error');
        return;
    }
    
    if (!validateEmail(correo)) {
        swal('Te falto llenar un campo','Por favor ingresa tu correo.','error');
        document.getElementById('correo').value = '';
        return;
    }
    
    if (password1 === "") {
        swal("Por favor, ingresa una contraseña.");
        return;
    }
    
    if (password2 === "") {
        swal("Por favor, confirma tu contraseña.");
        return;
    }
    
    if (password1 !== password2) {
        swal('Error', 'Tus contraseñas son diferentes, te recomiendo que corrijas', 'error');
    
        // Limpia los campos de contraseña
        document.getElementById('password').value = '';
        document.getElementById('password2').value = '';
    
        return;
    }

    // Mostrar los valores en el Paso 2
    document.getElementById('displayNombre').textContent = nombre;
    document.getElementById('displayApellido').textContent = apellido;
    document.getElementById('displayCorreo').textContent = correo


});

// Función para validar el formato del correo electrónico
function validateEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Función para validar la contraseña
function validarPassword(password) {
    const tamanioPasword = password.length >= 6;
    const mayusculas = /[A-Z]/.test(password);
    const minusculas = /[a-z]/.test(password);
    const numeros = /[0-9]/.test(password);
  

    if (!tamanioPasword) {
        swal('ERROR','La contraseña debe tener al menos 5 caracteres te recomendamos que regreses y corrijas','error');
        return false;
    }
    if (!mayusculas) {
        swal('ERROR','La contraseña debe tener al menos una letra mayúscula te recomendamos que regreses y corrijas','error');
        return false;
    }
    if (!minusculas) {
        swal('ERROR','La contraseña debe tener al menos una letra minuscula te recomendamos que regreses y corrijas','error');
        return false;
    }
    if (!numeros) {
        swal('ERROR','La contraseña debe tener al menos un numero te recomendamos que regreses y corrijas','error');
        return false;
    }
   
    return true;
}





