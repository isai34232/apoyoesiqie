<?php
// Importa la clase Database
require 'config/database.php';

// Crea una instancia de la clase Database
$db = new Database();
$con = $db->conectar();

// Obtén los datos del formulario
$password_actual = $_POST['password_a'];
$password_nueva = $_POST['password_n'];
$password_confirmacion = $_POST['password_c'];

// Verifica que la contraseña nueva y la confirmación coincidan
if ($password_nueva !== $password_confirmacion) {
    echo "Las nuevas contraseñas no coinciden.";
    exit;
}

// ID del usuario (este valor debería ser recuperado de la sesión del usuario)
$user_id = 1; // Suponiendo que el ID del usuario es 1, este valor debe ser dinámico

// Consulta para obtener la contraseña actual del usuario desde la base de datos
$sql = "SELECT password FROM alumnos WHERE alumno_id = :user_id";
$stmt = $con->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado && password_verify($password_actual, $resultado['password'])) {
    // Encriptar la nueva contraseña
    $password_nueva_hashed = password_hash($password_nueva, PASSWORD_BCRYPT);

    // Actualizar la contraseña en la base de datos
    $sql_update = "UPDATE alumnos SET password = :password_nueva WHERE alumno_id = :user_id";
    $stmt_update = $con->prepare($sql_update);
    $stmt_update->bindParam(':password_nueva', $password_nueva_hashed);
    $stmt_update->bindParam(':user_id', $user_id);

    if ($stmt_update->execute()) {
        echo "Contraseña actualizada correctamente.";
    } else {
        echo "Error al actualizar la contraseña.";
    }
} else {
    echo "La contraseña actual no es correcta.";
}
