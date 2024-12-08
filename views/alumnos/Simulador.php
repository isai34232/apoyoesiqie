<?php
// Inicia la sesión
session_start();
require '../../config/database.php';

// Crea una instancia de la clase Database
$db = new Database();
$con = $db->conectar();

// Verifica si el usuario ha iniciado sesión y si es un alumnp
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'alumno') {
    header("Location: ../../logout.php");
    header("Location: ../../index.php");
    exit();
  }

// Obtener las materias
$query = "SELECT * FROM materias";
$result = $con->query($query);
?>
<!DOCTYPE html>
<html lang="es" class="a">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen por materia</title>
      <!-- Externas -->
    <link rel="preload" href="https://db.onlinewebfonts.com/c/240a7cb10b49b02c94ceddc459d385a9?family=Gagalin-Regular" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" crossorigin="anonymous" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/january-threed" rel="stylesheet">
    <!-- Linking Google Font Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
                

    <!-- internas -->
    <link rel="stylesheet" href="../../src/css/siderbar.css">
    <link rel="stylesheet" href="../../src/css/ialumno.css"> 
    <link rel="stylesheet" href="../../src/css/normalize.css">
    <link rel="stylesheet" href="../../src/css/test.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
    <aside class="sidebar">
        <a class="sidebar-header" href="index.php">
              <img src="../../src/img/logo.png" alt="logo" />
              <h2 class="logo__nombre">Rumbo a la meta</h2>
        </a>
        <ul class="sidebar-links">
        <li class="entrada">
          <h4>
            <span>General</span>
          </h4>
         </li>
          <li>
            <a class="entrada--active" href="simulador.php"><span class="material-symbols-outlined"> contract_edit </span>Simulador de examen</a>
          </li>
          <li>
            <a href="examenMateria.php"><span class="material-symbols-outlined"> list </span>Examen por materias</a>
          </li>
          <li>
            <a href="material.php"><span class="material-symbols-outlined"> attach_file </span>Material de apoyo</a>    
          </li>
          <li>
            <a href="gruposAlumno.php"><span class="material-symbols-outlined"> group </span>Grupos</a>
          </li>
          <li class="entrada">
          <h4>
            <span>Estadisticas</span>
            
          </h4>
        </li>
          <li>
            <a href="estadisticas.php"><span class="material-symbols-outlined"> monitoring </span>Aciertos</a>
          </li>
        </ul>
        <div class="sidebar-profile">
            <a  href="perfil.php"><span class="material-symbols-outlined"> account_circle </span>Perfil</a>
            <a  href="../../logout.php"><span class="material-symbols-outlined"> logout </span>Logout</a>
        </div>
   
      </aside>
      <main class="content no-margin">
        <div class="contenedor">
        <h2 class="test-general__titulo">Instrucciones para el examen de simulación</h2>
        <p class="test-general__instrucciones">
          Bienvenido al examen de simulación. Por favor, sigue estas instrucciones para completar el examen correctamente:
        </p>
        <ul>
            <li><strong>Duración:</strong> El examen tiene una duración de <strong>60 minutos</strong>. Asegúrate de administrar tu tiempo de manera efectiva.</li>
            <li><strong>Formato:</strong> El examen consta de <strong>20 preguntas</strong> de opción múltiple. Selecciona la respuesta correcta para cada pregunta.</li>
            <li><strong>Acceso:</strong> Utiliza los botones de navegación para moverte entre materias.</li>
            <li><strong>Respuestas:</strong> Marca la opción que consideres correcta.</li>
            <li><strong>Temporizador:</strong> El temporizador en la parte superior de la pantalla mostrará el tiempo restante. El examen se enviará automáticamente cuando el tiempo se agote.</li>
            <li><strong>Calificación:</strong> Al finalizar el examen, recibirás una calificación y una revisión de tus respuestas. Puedes ver los resultados en la página de resultados.</li>
            <li><strong>Asistencia:</strong> Si necesitas ayuda durante el examen, contacta a <strong>soporte@ejemplo.com</strong>.</li>
        </ul>
        <p>¡Buena suerte! :)</p> 
        <a class="botonPrincipal" href="resolver_simulador.php">Realizar examen</a>
        <br>
        <br>
            <button class="boton--zoom" id="toggleButton"><span id="zoom" class=" material-symbols-outlined"> zoom_in_map </span></button>
        </div>
      </main>
    </div>
    <!-- internos -->
    <script src="../../src/js/comprimir_expandir.js"></script>
    <!-- Iconos -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (isset($_SESSION['error'])): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "<?php echo $_SESSION['error']; ?>"
                });
                <?php unset($_SESSION['error']); // Eliminar el mensaje después de mostrarlo ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: "<?php echo $_SESSION['success']; ?>"
                });
                <?php unset($_SESSION['success']); // Eliminar el mensaje después de mostrarlo ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>