<?php
session_start();

// Importa la clase Database
require '../../config/database.php';

// Crea una instancia de la clase Database
$db = new Database();
$con = $db->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['password_a'];
    $new_password = $_POST['password_n'];
    $confirm_password = $_POST['password_c'];
    $student_id = $_SESSION['user_id']; // Asumiendo que el ID del estudiante está almacenado en la sesión

    // Verificar que todos los campos estén llenos
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['error'] = "Por favor, complete todos los campos.";
        header("Location: perfil.php");
        exit();
    }

    // Verificar que la nueva contraseña y la confirmación coincidan
    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = "La nueva contraseña y la confirmación no coinciden.";
        header("Location: perfil.php");
        exit();
    }

    // Verificar la contraseña actual
    $query = "SELECT password FROM administradores WHERE admin_id = :id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':id', $student_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($current_password, $user['password'])) {
        $_SESSION['error'] = "La contraseña actual es incorrecta.";
        header("Location: perfil.php");
        exit();
    }

    // Actualizar la contraseña
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $query = "UPDATE administradores SET password = :password WHERE admin_id = :id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':id', $student_id);
    $result = $stmt->execute();

    if ($result) {
        $_SESSION['success'] = "Contraseña actualizada exitosamente.";
    } else {
        $_SESSION['error'] = "Error al actualizar la contraseña. Por favor, inténtelo de nuevo.";
    }

    header("Location: perfil.php");
    exit();
} else {
    // Si se accede directamente sin datos POST
    header("Location: ../../logout.php");
    header("Location: ../../index.php");
    exit();
}
