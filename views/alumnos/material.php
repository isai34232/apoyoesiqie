<?php
session_start();
require '../../config/database.php';

$db = new Database();
$con = $db->conectar();

// Verifica si el usuario ha iniciado sesión y si es un alumnp
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'alumno') {
    header("Location: ../../logout.php");
    header("Location: ../../index.php");
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

    <title>Materiales de Apoyo</title>
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
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />

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
                <li><a href="material.php">Referencias</a></li>
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
              <label class="centrar-texto" for="materia_id">Seleccionar materia</label>
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
                          <div><p>Titulo</p></div>
                          <div><p>Tipo</p></div>
                          <div><p>Ver más</p></div>
                      </div>
                  </div>
                  
                  <!-- Cuerpo de la tabla -->
                  <?php if (!empty($materiales)): ?>
                  <div class="body">
                      <?php foreach ($materiales as $material): ?>
                          <div class="row">
                              <div class="row__material">
                                  <p><?php echo htmlspecialchars($material['nombre']); ?></p>
                              </div>
                              <div class="row__material">
                                <?php if ($material['tipo_material'] === 'Video'): ?>
                                    <ion-icon class="tipo" src="../../src/img/ico/video.svg"></ion-icon>
                                <?php elseif($material['tipo_material'] === 'Texto'): ?>
                                    <ion-icon class="tipo" src="../../src/img/ico/text.svg"></ion-icon>
                                <?php elseif($material['tipo_material'] === 'Documento'): ?>
                                    <ion-icon class="tipo" src="../../src/img/ico/pdf.svg"></ion-icon>
                                <?php elseif($material['tipo_material'] === 'Página web'): ?>
                                    <ion-icon class="tipo" src="../../src/img/ico/web.svg"></ion-icon>
                                <?php endif; ?>
                                </div>   
                              <div class="icono__tabla">
                                <a href="#" class="ver-mas" data-id="<?php echo $material['id']; ?>">
                                    <ion-icon name="eye-outline"></ion-icon>
                                </a>
                            </div>
                          </div>
                      <?php endforeach; ?>
                  </div>
                  <?php else: ?>
                      <p>No hay materiales de apoyo disponibles para los filtros seleccionados.</p>
                  <?php endif; ?>

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
    <br>
    <br>
    </div>
    </main>
</div>
    <script src="../../src/js/comprimir_expandir.js"></script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
    // Selecciona todos los botones de "ver más"
    const botonesVerMas = document.querySelectorAll('.ver-mas');

    botonesVerMas.forEach(boton => {
        boton.addEventListener('click', function() {
            const materialId = this.getAttribute('data-id');
            
            // Hacer una solicitud AJAX para obtener el contenido del material
            fetch(`obtener_contenido_material.php?id=${materialId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let widthValue = '50%';

                        // Verifica si el ancho de la pantalla es menor a 768px
                        if (window.innerWidth < 768) {
                            widthValue = '100%';
                        }

                        let contentHtml;
                        if (data.tipo_material === 'Página web' || data.tipo_material === 'Documento') {
                            contentHtml = `<iframe src="${data.contenido}" style="width:100%; height: 500px; border:none;"></iframe>`;
                        } else {
                            contentHtml = data.contenido;
                        }

                        Swal.fire({
                            title: data.nombre,
                            html: contentHtml,
                            width: widthValue, 
                            confirmButtonText: 'Cerrar',
                            showClass: {
                                popup: 'animate__animated animate__fadeInUp animate__faster'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutDown animate__faster'
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'No se pudo cargar el contenido del material.',
                            icon: 'error',
                            confirmButtonText: 'Cerrar'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error al obtener el contenido:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error al intentar cargar el contenido.',
                        icon: 'error',
                        confirmButtonText: 'Cerrar'
                    });
                });
        });
    });
</script>


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
