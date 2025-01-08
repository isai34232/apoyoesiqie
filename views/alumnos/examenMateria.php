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
    <link rel="stylesheet" href="../../src/css/siderN.css">
    <link rel="stylesheet" href="../../src/css/ialumno.css"> 
    <link rel="stylesheet" href="../../src/css/normalize.css">
    <link rel="stylesheet" href="../../src/css/test.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
   

    <header class="header">
        <div class="logo">
            <a href="index.php">
                <img src="../../src/img/IPN.png" alt="Logo de la marca"/>
            </a>
            <span class="title">Sistema de apoyo en matemáticas y física para estudiantes</span> <!-- Añadido el título -->
        </div>
        <nav>
            <div class="menu-toggle" onclick="toggleMenu()">Menú</div>
            <ul class="nav-links" id="nav-links">
                <li><a href="examenMateria.php">Examen por materias</a></li>
                <li><a href="estadisticas.php">Estadísticas</a></li>
                <li><a href="material.php">Material</a></li>
            </ul>
        </nav>
        <div class="btn-wrapper">
            <a class="btn" href="perfil.php"><button>👨🏻</button></a>
            <a class="btn" href="../../logout.php"><button>Salir</button></a>
        </div>
    </header>

      <main class="content no-margin">
        <div class="contenedor">
        <h2 class="test-general__titulo">Seleccionar materia</h2>
        <p class="test-general__instrucciones">
            Por favor, selecciona una de las materias disponibles a continuación para iniciar tu examen. Haz clic en el icono de la materia que deseas seleccionar y luego presiona el botón "Enviar" para comenzar.
        </p>

        <form class="test-general__formulario" method="POST" action="resolver_examen.php" id="materias-form">
        <div class="radio-tile-group">
            <?php while($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="input-container">
                    <input id="materia-<?php echo $row['id']; ?>" type="radio" name="materia_id" value="<?php echo $row['id']; ?>" <?php echo (isset($_GET['materia_id']) && $_GET['materia_id'] == $row['id']) ? 'checked' : ''; ?>>
                    <div class="radio-tile">
                        <?php $_SESSION['icono'] = $row['icono'];
                        echo $row['icono']; ?>
                        <label for="materia-<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></label>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="boton">
            <input type="submit" value="Enviar" class="botonPrincipal">
        </div>
        <br>
        <br>
    </form>
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
    <script src="../../src/js/menu.js"></script>
</body>
</html>