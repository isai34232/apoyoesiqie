<?php
// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión y si es un alumnp
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'alumno') {
  header("Location: ../../logout.php");
  header("Location: ../../index.php");
  exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Alumno</title>
      <!-- Externas -->
    <link rel="preload" href="https://db.onlinewebfonts.com/c/240a7cb10b49b02c94ceddc459d385a9?family=Gagalin-Regular" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" crossorigin="anonymous" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/january-threed" rel="stylesheet">
    <!-- Linking Google Font Link For Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
                

    <!-- internas -->
    <link rel="stylesheet" href="../../src/css/siderN.css">
    <link rel="stylesheet" href="../../src/css/ialumno.css">
    <link rel="stylesheet" href="../../src/css/normalize.css">

</head>
<body>
<header class="header">
    <div class="logo">
        <img src="../../src/img/IPN.png" alt="Logo de la marca">
        <span class="title">Sistema de apoyo en matemáticas y física para estudiantes</span> 
    </div>
    <nav>
        <div class="menu-toggle" onclick="toggleMenu()">Menú</div>
        <ul class="nav-links" id="nav-links">
            <li><a href="examenMateria.php">Examen por materias</a></li>
            <li><a href="estadisticas.php">Estadísticas</a></li>
            <li><a href="material.php">Referencias</a></li>
        </ul>
    </nav>
    <div class="btn-wrapper">
        <a class="btn" href="perfil.php"><button>👨🏻</button></a>
        <a class="btn" href="../../logout.php"><button>Salir</button></a>
    </div>
</header>





      <main class="content">
        <div class="contenedor">
            <h2>Bienvenid@, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
            <p>Nos complace darte la bienvenida a la plataforma, donde tu éxito académico es prioridad. Aquí podrás:</p>
            <ul class="lista">
                <li class="iconoText">
                    - Realizar exámenes de simulación: Practica y prepárate con los exámenes de simulación por materias, que te ayudara a familiarizarte con el formato y contenido real de un examen. 
                </li> 
                <li class="iconoText">
                    - Consultar referencias: Accede a una amplia variedad de recursos y materiales de estudio que te ayudarán a profundizar en tus conocimientos y resolver tus dudas.
                </li>
                <li class="iconoText">
                    - Explora tu nivel por materia para saber el nivel de conocimiento en cada una. 
                </li>
            </ul>
            <p>Navega en las herramientas y recursos que hemos preparado para ti, y comienza tu experiencia hacia el éxito académico.</p>
            <br>
            <p style="text-align: center;">¡Estamos aquí para apoyarte en cada paso del camino!</p>
            <br>
            <br>
        </div>
      </main>
    </div>
    <!-- internos -->
     <script src="../../src/js/comprimir_expandir.js"></script>
     <script src="../../src/js/confeti.js"></script>
    <!-- Iconos -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
       <!-- Enlace a la biblioteca de confeti -->
       <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
       <script src="../../src/js/menu.js"></script>
</body>
</html>