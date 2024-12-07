<?php
// Importa la clase Database
require 'config/database.php';

// Crea una instancia de la clase Database
$db = new Database();

// Establece la conexión a la base de datos utilizando PDO
$con = $db->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica y obtiene datos del formulario
    $firstName = isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : '';
    $lastName = isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : '';
    $numeroEmpleado = isset($_POST['numeroEmpleado']) ? htmlspecialchars($_POST['numeroEmpleado']) : '';
    $correo = isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Verifica que todos los campos requeridos estén presentes
    if (empty($firstName) || empty($lastName) || empty($numeroEmpleado) || empty($correo) || empty($password)) {
        echo "Por favor completa todos los campos.";
        exit();
    }

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Preparar la consulta SQL con parámetros
    $sql = "INSERT INTO administradores (admin_id, admin_nombre, admin_apellidos, email, password)
            VALUES (:numeroEmpleado, :firstName, :lastName, :correo, :password)";
    $stmt = $con->prepare($sql);

    // Asignar valores a los parámetros
    $stmt->bindParam(':numeroEmpleado', $numeroEmpleado);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':password', $hashed_password);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Mostrar alerta de registro exitoso
        echo "<script>alert('Registro exitoso');</script>";
        
        // Redirigir a la página de inicio de sesión después de mostrar la alerta
        echo "<script>window.location.href = 'index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: " . $stmt->errorInfo()[2] . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumbo a la Meta - Registro</title>
    <link rel="stylesheet" href="src/css/Altas.css">

</head>
<body class="contenido_altas">

    <div class="registro">
        <h1>Alta de Administradores</h1>
       
        <form action="" method="POST" id="">
            
            <div class="form-group">
                <label for="numeroEmpleado">Numero de empleado:</label>
                <input type="text" id="numeroEmpleado" name="numeroEmpleado" class="form-control" placeholder="📳 Ingrese su NO. de empleado">
            </div>

            <div class="form-group">
                <label for="firstName">Nombre:</label>
                <input type="text" id="firstName" name="firstName" class="form-control" placeholder="🧑🏻 Ingrese su nombre">
            </div>

            <div class="form-group">
                <label for="lastName">Apellidos:</label>
                <input type="text" id="lastName" name="lastName" class="form-control" placeholder="🧑🏻Ingrese sus apellidos">
            </div>

            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" id="correo" name="correo" class="form-control" placeholder="📧 Ingrese su correo electrónico">
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="🔑Ingrese su contraseña">
            </div>

            <div class="botones">
                <button type="button" class="button" onclick="home()">Volver</button>
                <button type="submit" value="Registrar" class="button">Enviar</button>
            </div>
        
        </form>
    </div>
    <script src="src/js/validaciones_registro.js"></script>
</body>
</html>