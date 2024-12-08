
//funcion para ir al login
const home = () => window.location.href = 'index.php'; 
//funcion para ir salir
const logout = () => window.location.href = '../../logout.php'; 






// Función para validar el formato del correo
function validarEmail(email) {
    const emailverificar = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailverificar.test(email)) {
        swal('Error','Por favor ingresa un correo válido','error');
        return false;
    }
    return true;
}

// Función para validar la contraseña
function validarPassword(password) {
    const tamanioPasword = password.length >= 6;
    const mayusculas = /[A-Z]/.test(password);
    const minusculas = /[a-z]/.test(password);
    const numeros = /[0-9]/.test(password);
  

    if (!tamanioPasword) {
        swal('ERROR','La contraseña debe tener al menos 6 caracteres','error');
        return false;
    }
    if (!mayusculas) {
        swal('ERROR','La contraseña debe tener al menos una letra mayúscula','error');
        return false;
    }
    if (!minusculas) {
        swal('ERROR','La contraseña debe tener al menos una letra minuscula','error');
        return false;
    }
    if (!numeros) {
        swal('ERROR','La contraseña debe tener al menos un numero','error');
        return false;
    }
   
    return true;
}

