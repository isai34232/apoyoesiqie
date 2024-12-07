<?php
// Verificar si se ha pasado un ID como parámetro
if (isset($_GET['id'])) {
    $idAlumno = htmlspecialchars($_GET['id']); // Escapar para evitar XSS
} else {
    // Redirigir o mostrar un error si no hay ID
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Rumbo a la Meta</title>
            
        <link rel="stylesheet" href="src/css/styles.css">
        <link rel="stylesheet" href="src/css/normalize.css">       
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js'></script>

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
    </head>
    <body class="Contenido">
        <div class="gracias">
            <h1 class="animate__animated animate__jackInTheBox">¡Gracias por tu compra!</h1>
            <section>
            <h2>¡Tu pago ha sido completado exitosamente!</h2>
            <div class="gracias__idC">
                <div class="gracias__id">
                    <ion-icon name="alert-circle-outline"></ion-icon>
                    <p>Tu ID de alumno es: <strong><?php echo $idAlumno; ?></strong></p>
                </div>  
                <p>Por favor, guarda este ID. Es importante que lo tengas a la mano para cualquier aclaración futura.</p>
            </div>
            <p>Tu cuenta ha sido activada. Explora todas las herramientas y recursos que hemos preparado para ti, y comienza tu viaje hacia el éxito académico con confianza.</p>
            <br>
            <a style="text-decoration: none;" class="botonPrincipal" href="index.php">Volver a la página principal</a>
        </section>
        </div>
    <script src="src/js/confeti.js"></script>
    <script src="src/js/modernizr.js"></script>
     <!-- Enlace a la biblioteca de confeti -->
     <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
      <!-- Iconos -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    </body>
    </html>