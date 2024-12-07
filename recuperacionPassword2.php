<?php
require 'config/database.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';

    if (empty($email)) {
        // Si no se encontró al usuario en ninguna tabla
        $error = "Por favor, completa todos los campos.";
        header("Location: Recuperacion.php?error=" . urlencode($error));
        exit();
    }

    // Crear instancia de la clase Database
    $db = new Database();
    $con = $db->conectar();

    // Buscar en la tabla de alumnos
    $sql = "SELECT 'alumno' AS userType, alumno_id AS id, email FROM alumnos WHERE email = :email";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no se encontró en la tabla de alumnos, buscar en la tabla de administradores
    if (!$user) {
        $sql = "SELECT 'administrador' AS userType, admin_id AS id, email FROM administradores WHERE email = :email";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    if ($user) {
        // Obtener el tipo de usuario
        $userType = $user['userType'];
        $table = ($userType === 'alumno') ? 'alumnos' : 'administradores';

        // Crear un token único para la recuperación de contraseña
        $token = bin2hex(random_bytes(50));

        // Guardar el token en la base de datos
        $sql = "UPDATE $table SET reset_token = :token WHERE email = :email";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Enviar el correo de recuperación
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor de correo
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'rumboalameta@rumboalameta.site';
            $mail->Password   = 'Meta2024+';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Configuración del correo
            $mail->setFrom('rumboalameta@rumboalameta.site', 'Rumbo a la Meta');
            $mail->addAddress($email);

            // Adjuntar la imagen al correo y darle una etiqueta (cid)
            $mail->addEmbeddedImage('src/img/logo.png', 'logo_cid');

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Recuperacion de Password';
            $mail->Body    = "
                <html>
                <head>
                    <style>
                body {
                    font-family: Arial, sans-serif;
                    color: #333;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background: #ffffff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                .header {
                    text-align: center;
                    padding-bottom: 20px;
                }
                .header img {
                max-width: 150px;
                border-radius: 50%; /* Hace que la imagen aparezca en un círculo */
                display: block;
                margin: 0 auto;
                }
                .content {
                    text-align: center;
                }
                .content h2 {
                    color: #333;
                }
                .content p {
                    font-size: 16px;
                    line-height: 1.5;
                }
                .button {
                    display: inline-block;
                    padding: 10px 20px;
                    font-size: 16px;
                    color: #ffffff;
                    background-color: #007bff;
                    text-decoration: none;
                    border-radius: 5px;
                    margin-top: 20px;
                }
                .footer {
                    text-align: center;
                    font-size: 14px;
                    color: #666;
                    padding-top: 20px;
                }
            </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                             <img src='cid:logo_cid' alt='Logo'>
                        </div>
                        <div class='content'>
                            <h2>Restablecimiento de Contraseña</h2>
                            <p>Hola,</p>
                            <p>Para restablecer tu contraseña, por favor haz clic en el siguiente enlace:</p>
                            <a href='https://rumboalameta.site/reset1.php?token=$token&userType=$userType' class='button'>Restablecer Contraseña</a>
                        </div>
                        <div class='footer'>
                            <p>Si no solicitaste este cambio, por favor ignora este correo.</p>
                        </div>
                    </div>
                </body>
                </html>";

            $mail->send();
            header("Location: index.php?status=success");
            exit();
        } catch (Exception $e) {
            header("Location: index.php?status=error&message=El+correo+no+se+pudo+enviar");
            exit();
        }
    } else {
        header("Location: index.php?status=error&message=No+se+encontró+una+cuenta+con+ese+correo");
        exit();
    }
}
