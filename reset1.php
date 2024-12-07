<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rumbo a la Meta - Iniciar sesión</title>
        <link rel="stylesheet" href="src/css/RestablcerPassword.css">
        <link rel="stylesheet" href="src/css/normalize.css">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    </head>
    <body class="Contenido_RecuperacionPassword">
        <div class="Recueperacion">
            <h1>Rumbo a la Meta</h1>
            <br>
            <h2>Restablcer contraseña</h2>
            <p>Introduce tu Nueva contraseña </p>
            <form action="reset.php" method="POST" >
                 <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                 <input type="hidden" name="userType" value="<?php echo $_GET['userType']; ?>">


                <input type="password" name="newPassword" id="newPassword" placeholder="🔑 contraseña" >
        
                    <div class="botonesR">
                        <button type="button" class="b1" onclick="home()">Volver</button>
                        <button type="submit" class="b2">Enviar</button>
                    </div>
                </form>
                    
                   
        </div>
    <script src="src/js/funciones.js"></script>
  <script src="src/js/RestablecerContra.js"></script>
    <script src="src/js/modernizr.js"></script>
    </body>
    </html>