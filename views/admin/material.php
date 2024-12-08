<?php
session_start();
require '../../config/database.php';

$db = new Database();
$con = $db->conectar();

// Verifica si el usuario ha iniciado sesión y si es un administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'administrador') {
  header("Location: ../../logout.php");
  exit();
}


// Obtener las materias
$materias = $con->query("SELECT id, nombre FROM materias")->fetchAll(PDO::FETCH_ASSOC);

// Obtener la materia seleccionada
$materia_id = isset($_GET['materia_id']) ? $_GET['materia_id'] : null;

// Obtener los temas asociados a la materia seleccionada
$temas = [];
if ($materia_id) {
    $stmtTemas = $con->prepare("SELECT id_tema, nombre FROM temas WHERE id_materia = ?");
    $stmtTemas->execute([$materia_id]);
    $temas = $stmtTemas->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener el tema seleccionado
$tema_id = isset($_GET['tema_id']) ? $_GET['tema_id'] : null;

// Paginación
$materialesPorPagina = 10; // Número de materiales por página
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $materialesPorPagina;

// Construir la consulta para obtener los materiales de apoyo filtrados
$queryMateriales = "SELECT * FROM materiales_apoyo WHERE 1";
$params = [];

if ($materia_id) {
    $queryMateriales .= " AND id_materia = ?";
    $params[] = $materia_id;
}

if ($tema_id) {
    $queryMateriales .= " AND id_tema = ?";
    $params[] = $tema_id;
}

$queryMateriales .= " LIMIT $offset, $materialesPorPagina";
$stmt = $con->prepare($queryMateriales);

// Ejecutar la consulta
$stmt->execute($params);
$materiales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener el total de materiales
$queryTotal = "SELECT COUNT(*) as total FROM materiales_apoyo WHERE 1";
$paramsTotal = [];

if ($materia_id) {
    $queryTotal .= " AND id_materia = ?";
    $paramsTotal[] = $materia_id;
}
if ($tema_id) {
    $queryTotal .= " AND id_tema = ?";
    $paramsTotal[] = $tema_id;
}

$stmtTotal = $con->prepare($queryTotal);
$stmtTotal->execute($paramsTotal);
$totalMateriales = $stmtTotal->fetchColumn();

// Calcular el total de páginas
$totalPaginas = ceil($totalMateriales / $materialesPorPagina);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ver materiales de apoyo</title>
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
    <link rel="stylesheet" href="../../src/css/referencias.css">

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

      <main class="content no-margin">
        <div class="contenedor">
          <h2 class="test-general__titulo">Materiales de apoyo</h2>
          <form action="material.php" method="GET">
              <label class="centrar-texto" for="materia_id">Seleccionar Materia</label>
              <div class="select">
                <select name="materia_id" id="materia_id" onchange="this.form.submit()">
                    <option value="">-- Selecciona una Materia --</option>
                    <?php foreach ($materias as $materia): ?>
                        <option value="<?= $materia['id'] ?>" <?= $materia_id == $materia['id'] ? 'selected' : '' ?>><?= $materia['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
              </div>
              <?php if ($materia_id): ?>
                  <label class="centrar-texto" for="tema_id">Seleccionar Tema</label>
                  <div class="select">
                    <select name="tema_id" id="tema_id" onchange="this.form.submit()">
                        <option value="">-- Selecciona un Tema --</option>
                        <?php foreach ($temas as $tema): ?>
                            <option value="<?= $tema['id_tema'] ?>" <?= $tema_id == $tema['id_tema'] ? 'selected' : '' ?>><?= $tema['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
              <?php endif; ?>
          </form>

          <!-- Mostrar mensaje si no se ha seleccionado ninguna opción -->
          <?php if (!$materia_id && !$tema_id): ?>
              <p>Por favor, selecciona una materia y un tema para ver los materiales de apoyo.</p>
          <?php else: ?>
              <div class="table">
                  <div class="options">
                      <span>Mostrando <?php echo min($materialesPorPagina, $totalMateriales - $offset); ?> de <?php echo $totalMateriales; ?></span>
                  </div>
                  <div class="header">
                      <div class="row">
                          <div><p>Nombre del Material</p></div>
                          <div><p>Eliminar</p></div>
                          <div><p>Editar</p></div>
                      </div>
                  </div>
                  
                  <!-- Cuerpo de la tabla -->
                  <?php if (!empty($materiales)): ?>
                  <div class="body">
                      <?php foreach ($materiales as $material): ?>
                          <div class="row">
                              <div class="row__material">
                                  <?php echo htmlspecialchars($material['nombre']); ?>
                              </div>
                              <div class="icono__tabla">
                                  <a href="eliminar_material.php?id=<?php echo $material['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este material?');">
                                      <ion-icon name="trash-outline"></ion-icon>
                                  </a>
                              </div>
                              <div class="icono__tabla">
                                  <a href="editar_material.php?id=<?php echo $material['id']; ?>">
                                      <ion-icon name="pencil-outline"></ion-icon>
                                  </a>
                              </div>
                          </div>
                      <?php endforeach; ?>
                  </div>
                  <?php else: ?>
                      <p>No hay materiales de apoyo disponibles para los filtros seleccionados.</p>
                  <?php endif; ?>

                  <!-- Final de la tabla -->
                  <div class="footer">
                      <div class="row">
                          <div></div>
                          <div class="agregar">
                          <?php if (isset($_GET['materia_id']) && !empty($_GET['materia_id'])): ?>
                              <a href="nuevo_material.php?materia_id=<?php echo $_GET['materia_id']; ?>">
                                  <ion-icon name="add-circle-outline"></ion-icon>
                              </a>
                          <?php endif; ?>
                          </div>

                      </div>
                  </div>

                  <!-- Opciones de la tabla -->
                  <div class="options">
                      <span>Mostrando <?php echo min($materialesPorPagina, $totalMateriales - $offset); ?> de <?php echo $totalMateriales; ?></span>
                      <div>
                          <?php if ($paginaActual > 1): ?>
                              <a href="?pagina=<?php echo $paginaActual - 1; ?>&materia_id=<?php echo $materia_id; ?>&tema_id=<?php echo $tema_id; ?>"><i class="fas fa-caret-left"></i></a>
                          <?php endif; ?>
                          
                          <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                              <a href="?pagina=<?php echo $i; ?>&materia_id=<?php echo $materia_id; ?>&tema_id=<?php echo $tema_id; ?>" <?php if ($i == $paginaActual) echo 'class="page-active"'; ?>>
                                  <?php echo $i; ?>
                              </a>
                          <?php endfor; ?>
                          
                          <?php if ($paginaActual < $totalPaginas): ?>
                              <a href="?pagina=<?php echo $paginaActual + 1; ?>&materia_id=<?php echo $materia_id; ?>&tema_id=<?php echo $tema_id; ?>">Siguiente »</a>
                          <?php endif; ?>
                      </div>
                      <span>Página <?php echo $paginaActual; ?> de <?php echo $totalPaginas; ?></span>
                  </div>
              </div> <!-- cierre tabla -->
          <?php endif; ?>
          <button class="boton--zoom" id="toggleButton"><span id="zoom" class=" material-symbols-outlined"> zoom_in_map </span></button>
    <br>
    <br>
    </div>
    </main>
</div>
    <script src="../../src/js/comprimir_expandir.js"></script>

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
