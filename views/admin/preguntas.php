<?php
// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión y si es un administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'administrador') {
    header("Location: ../../logout.php");
    header("Location: ../../index.php");
    exit();
}

// Importa la clase Database
require '../../config/database.php';

// Crea una instancia de la clase Database
$db = new Database();
$con = $db->conectar();

// Obtener las materias para el formulario
$query_materias = "SELECT id, nombre FROM materias";
$stmt_materias = $con->prepare($query_materias);
$stmt_materias->execute();
$materias = $stmt_materias->fetchAll(PDO::FETCH_ASSOC);

// Configuración
$preguntasPorPagina = 5;
$paginaActual = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$offset = ($paginaActual - 1) * $preguntasPorPagina;

// Inicializa las variables
$totalPreguntas = 0;
$totalPaginas = 1;

// Verifica si se ha seleccionado una materia
$preguntas = [];
if (isset($_GET['materia_id'])) {
    $materia_id = intval($_GET['materia_id']);

    // Obtiene el total de preguntas para calcular el número total de páginas
    $totalPreguntasSql = "SELECT COUNT(*) as total FROM preguntas WHERE materia_id = :materia_id";
    $totalPreguntasStmt = $con->prepare($totalPreguntasSql);
    $totalPreguntasStmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
    $totalPreguntasStmt->execute();
    $totalPreguntas = $totalPreguntasStmt->fetchColumn();
    $totalPaginas = ceil($totalPreguntas / $preguntasPorPagina);

    // Consulta para obtener las preguntas asociadas a la materia
    $sql = "SELECT * FROM preguntas WHERE materia_id = :materia_id LIMIT :offset, :preguntasPorPagina";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
    // Para PDO, se deben usar valores enteros directos para LIMIT y OFFSET
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':preguntasPorPagina', $preguntasPorPagina, PDO::PARAM_INT);
    $stmt->execute();
    $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas</title>
      <!-- Externas -->
      <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
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
    <div class="container">
    <header class="header">
        <div class="logo">
            <a href="index.php">
                <img src="../../src/img/IPN.png" alt="Logo de la marca"/>
            </a>
            <span class="title">Instituto Politécnico Nacional</span> <!-- Añadido el título -->
        </div>
        <nav>
            <div class="menu-toggle" onclick="toggleMenu()">Menú</div>
            <ul class="nav-links" id="nav-links">
                <li><a href="preguntas.php">Editar preguntas</a></li>
                <li><a href="material.php">Material de apoyo</a></li>
            </ul>
        </nav>
        <div class="btn-wrapper">
            <a class="btn" href="perfil.php"><button>👨🏻</button></a>
            <a class="btn" href="../../logout.php"><button>Salir</button></a>
        </div>
    </header>
      <!-- Seccion Principal -->
      <main class="content no-margin">
        <div class="contenedor">
        <h2 class="test-general__titulo">Selecciona una materia</h2>
        <!-- Formulario materias -->
        <form class="test-general__formulario" method="GET" action="preguntas.php" id="materias-form">
          <div class="radio-tile-group">
            <!-- Matematicas -->
            <div class="input-container">
              <input id="materia-1" type="radio" name="materia_id"  value="1" <?php echo (isset($_GET['materia_id']) && $_GET['materia_id'] == 1) ? 'checked' : ''; ?>>
              <div class="radio-tile">
                <ion-icon name="calculator"></ion-icon>
                <label for="materia-1">CALCULO DIFERENCIAL E INTEGRAL</label>
              </div>
            </div>

            <!-- Comunicación -->
            <div class="input-container">
              <input id="materia-2" type="radio" name="materia_id"  value="2" <?php echo (isset($_GET['materia_id']) && $_GET['materia_id'] == 2) ? 'checked' : ''; ?>>
              <div class="radio-tile">
                <ion-icon src="../../src/img/ico/atom.svg"></ion-icon>
                <label for="materia-2">ELECTRICIDAD Y MAGNETISMO</label>
              </div>
            </div>

           
           
          </div>
        </form>
        <!-- preguntas -->
        <div class="table">
          <div clasS="options">
            <span>Mostrando <?php echo min($preguntasPorPagina, $totalPreguntas - $offset); ?> de <?php echo $totalPreguntas; ?></span>
          </div>
          <div clasS="header">
            <div class="row">
              <div><p>Pregunta</p></div>
              <div><p>Eliminar</p></div>
              <div><p>Editar</p></div>
            </div>
          </div>
          <!-- Cuerpo de la tabla -->
          <?php if (!empty($preguntas)): ?>
          <div class="body">
              <?php foreach ($preguntas as $pregunta): ?>
                  <div class="row">
                      <div class="row__pregunta">
                          <?php echo ($pregunta['pregunta']); ?>
                      </div>
                      <div class="icono__tabla">
                        <a href="eliminar_pregunta.php?id=<?php echo $pregunta['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta pregunta?');">
                          <ion-icon name="trash-outline"></ion-icon>
                        </a>
                      </div>
                      <div class="icono__tabla">
                      <a href="editar_pregunta.php?id=<?php echo $pregunta['id']; ?>">
                          <ion-icon name="pencil-outline"></ion-icon>
                      </a>
                      </div>
                  </div>
              <?php endforeach; ?>
            </div>
              <?php elseif (isset($_GET['materia_id'])): ?>
                  <p>No hay preguntas para esta materia.</p>
              <?php else: ?>
                  <p>No se ha seleccionado una materia. Por favor, selecciona una materia para ver las preguntas.</p>
              <?php endif; ?>

            <!-- Final de la tabla -->
            <div class="footer">
              <div class="row">
                <div></div>
                <div class="agregar">
                  <?php if (isset($_GET['materia_id']) && !empty($_GET['materia_id'])): ?>
                      <a href="nueva_pregunta.php?materia_id=<?php echo $_GET['materia_id']; ?>">
                          <ion-icon name="add-circle-outline"></ion-icon>
                      </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <!-- Opciones de la tabla -->
              <div class="options">
                <span>Mostrando <?php echo min($preguntasPorPagina, $totalPreguntas - $offset); ?> de <?php echo $totalPreguntas; ?></span>
                <div>
                  <?php if ($paginaActual > 1): ?>
                    <a href="?pagina=<?php echo $paginaActual - 1; ?>&materia_id=<?php echo $materia_id; ?>"><i class="fas fa-caret-left"></i></a>
                  <?php endif; ?>
                  
                  <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <a href="?pagina=<?php echo $i; ?>&materia_id=<?php echo $materia_id; ?>" <?php if ($i == $paginaActual) echo 'class="page-active"'; ?>>
                      <?php echo $i; ?>
                    </a>
                  <?php endfor; ?>
                  
                  <?php if ($paginaActual < $totalPaginas): ?>
                    <a href="?pagina=<?php echo $paginaActual + 1; ?>&materia_id=<?php echo $materia_id; ?>">Siguiente »</a>
                  <?php endif; ?>
                </div>
                <span>Página <?php echo $paginaActual; ?> de <?php echo $totalPaginas; ?></span>
              </div>
              <br>
              <br>
          </div> <!-- cierre tabla -->
          <button class="boton--zoom" id="toggleButton"><span id="zoom" class=" material-symbols-outlined"> zoom_in_map </span></button>
        </div>
      </main>
    </div>
    <!-- internos -->
    <script src="../../src/js/comprimir_expandir.js"></script>
    <script src="../../src/js/radiob.js"></script>
    <!-- Iconos -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../../src/js/menu.js"></script>
</body>
</html>