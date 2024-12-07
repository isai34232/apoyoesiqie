<?php

// Importa la clase Database
require 'config/database.php';

// Crea una instancia de la clase Database
$db = new Database();

// Establece la conexión a la base de datos
$con = $db->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Función para verificar las credenciales en una tabla específica
    function verifyUser($con, $table, $email) {
        $stmt = $con->prepare("SELECT * FROM $table WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verificar si el usuario es alumno
    $user = verifyUser($con, 'alumnos', $email);
    if ($user) {
        if (password_verify($password, $user['password'])) {
            // Verificar el estado de la cuenta
            if ($user['estado'] == 'activa') {
                // Inicia la sesión
                session_start();
                $_SESSION['user_id'] = $user['alumno_id'];
                $_SESSION['user_name'] = $user['alumno_nombre'];
                $_SESSION['user_lastname'] = $user['alumno_apellidos'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = 'alumno';
                header("Location: views/alumnos/index.php");
                exit();
            } elseif ($user['estado'] == 'deshabilitada') {
                // Si la cuenta está deshabilitada
                $error = "La cuenta ha expirado. Contacte con soporte.";
                header("Location: index.php?error=" . urlencode($error));
                exit();
            } elseif ($user['estado'] == 'pendiente') {
                // Si la cuenta está pendiente de pago
                header("Location: registros.php?step=final&id=" . urlencode($user['alumno_id']));
                exit();
            }
        } else {
            // Contraseña incorrecta
            $error = "Correo o contraseña incorrectos.";
            header("Location: index.php?error=" . urlencode($error));
            exit();
        }
    }

    // Verificar si el usuario es administrador
    $user = verifyUser($con, 'administradores', $email);
    if ($user) {
        if (password_verify($password, $user['password'])) {
            // Inicia la sesión
            session_start();
            $_SESSION['user_id'] = $user['admin_id'];
            $_SESSION['user_name'] = $user['admin_nombre'];
            $_SESSION['user_lastname'] = $user['admin_apellidos'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = 'administrador';
            header("Location: views/admin/index.php");
            exit();
        } else {
            $error = "Correo o contraseña incorrectos.";
            header("Location: index.php?error=" . urlencode($error));
            exit();
        }
    }
    // Si no se encontró al usuario en ninguna tabla
    $error = "El correo no está registrado en la plataforma";
    header("Location: index.php?error=" . urlencode($error));
    exit();
}
