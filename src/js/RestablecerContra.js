







// Función para validar la contraseña
function validarPassword(password) {
    const tamanioPasword = password1.length >= 6;
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