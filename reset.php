<?php
require 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = isset($_POST['token']) ? htmlspecialchars($_POST['token']) : '';
    $userType = isset($_POST['userType']) ? htmlspecialchars($_POST['userType']) : '';
    $newPassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : '';

    if (empty($token) || empty($userType) || empty($newPassword)) {
        echo "Por favor, completa todos los campos.";
        exit();
    }

    // Crear instancia de la clase Database
    $db = new Database();
    $con = $db->conectar();

    // Determinar la tabla según el tipo de usuario
    $table = ($userType === 'alumno') ? 'alumnos' : 'administradores';

    // Verificar el token
    $sql = "SELECT * FROM $table WHERE reset_token = :token";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Actualizar la contraseña
        $hashed_password = password_hash($newPassword, PASSWORD_BCRYPT);
        $sql = "UPDATE $table SET password = :password, reset_token = NULL WHERE reset_token = :token";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        echo 
        
        "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
        
            <title>Restablecimiento de Contraseña</title>
            
            <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'>
        </head>
        <body>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>
        <script>Swal.fire({
                    title: 'Genial',
                    text: 'Contraseña actualizada',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php'; // Redirigir a la página principal
                });
                </script>
         </body>
        </html>
        ";
    } else {
        echo "<script>alert('Token inválido o expirado.');</script>";
    }
}
?>
