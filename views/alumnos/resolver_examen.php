<?php
// Inicia la sesión
session_start();
require '../../config/database.php';

// Crea una instancia de la clase Database
$db = new Database();
$con = $db->conectar();

// Verifica si el usuario ha iniciado sesión y si es un alumno
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'alumno') {
    header("Location: ../../logout.php");
    header("Location: ../../index.php");
    exit();
}

if (isset($_POST['materia_id'])) {
  $materia_id = $_POST['materia_id'];
}  elseif (isset($_SESSION['materia_id'])) {
    $materia_id = $_SESSION['materia_id'];
    unset($_SESSION['materia_id']); // Eliminar la variable de sesión después de usarla
} else {
  header("Location: examenMateria.php");
  $_SESSION['error'] = 'Escoge una materia';
  exit();
}


// Obtener el nombre de la materia
$query_materia = "SELECT nombre, icono FROM materias WHERE id = :materia_id";
$stmt_materia = $con->prepare($query_materia);
$stmt_materia->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
$stmt_materia->execute();
$materia = $stmt_materia->fetch(PDO::FETCH_ASSOC);

if(isset( $_SESSION['preguntas_recibidas'])){
    $preguntas = $_SESSION['preguntas_recibidas'];
    unset($_SESSION['preguntas_recibidas']); // Eliminar la variable de sesión después de usarla
} else {
// Obtener el total de preguntas para la materia seleccionada
$query_total_preguntas = "SELECT COUNT(*) as total FROM preguntas WHERE materia_id = :materia_id";
$stmt_total_preguntas = $con->prepare($query_total_preguntas);
$stmt_total_preguntas->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
$stmt_total_preguntas->execute();
$total_preguntas = $stmt_total_preguntas->fetch(PDO::FETCH_ASSOC)['total'];

// Definir cuántas preguntas mostrar
$preguntas_a_mostrar = 10;

// Comprobar si hay suficientes preguntas
if ($total_preguntas < $preguntas_a_mostrar) {
    $preguntas_a_mostrar = $total_preguntas;
}

// Obtener preguntas aleatorias de la materia seleccionada
$query = "SELECT * FROM preguntas WHERE materia_id = :materia_id ORDER BY RAND() LIMIT :preguntas_a_mostrar";
$stmt = $con->prepare($query);
$stmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
$stmt->bindParam(':preguntas_a_mostrar', $preguntas_a_mostrar, PDO::PARAM_INT);
$stmt->execute();
$preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Guardar el número de preguntas seleccionadas
$numero_preguntas_seleccionadas = count($preguntas);

// Si deseas guardarlo en la sesión
$_SESSION['preguntas'] = $preguntas;
$_SESSION['numero_preguntas_seleccionadas'] = $numero_preguntas_seleccionadas;
}
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
    <link rel="stylesheet" href="../../src/css/siderN.css">


    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

</head>
<body>

    <header class="header">
        <div class="logo">
            <img src="../../src/img/IPN.png" alt="Logo de la marca">
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
        <?php
        // Verificar si hay preguntas
        if (empty($preguntas)) {
          ?>
        <h2>No hay preguntas disponibles para esta materia.</h2>
        <?php 
        } else {?>
        <div class="titulo_ico">
            <h2>Examen de 
                <?php echo htmlspecialchars($materia['nombre'], ENT_QUOTES, 'UTF-8'); ?>
            </h2>
            <div class="titulo_ico__icono"><?php echo $materia['icono']?></div>
        </div>
        <?php if (isset($no_preguntas) && $no_preguntas): ?>
            <p>No hay preguntas registradas para esta materia.</p>
        <?php else: ?>
       
        <form method="POST" action="evaluar_examen.php" id="miFormulario">
            <?php foreach ($preguntas as $index => $pregunta) { ?>
            <div>
                <div class="question" >
                
                <?php 
                $contenido = $pregunta['pregunta'];
                if (preg_match('/<p>(.*?)<\/p>/', $contenido, $coincidencias)) {
                    $primer_bloque = $coincidencias[1];
                    echo  ($index + 1) . ". ". $primer_bloque;
                }

                $contenido_modificado = preg_replace('/<p>.*?<\/p>/', '', $contenido, 1);
                
                echo $contenido_modificado; ?>


                       <?php 
                        if ($pregunta['imagen'] != null) {?>
                            <img src="<?php echo $pregunta['imagen']?>" alt="" width="100%">
                        <?php 
                        }
                        ?>
                    <!-- opcion a -->
                    <?php if ($pregunta['opcion_a'] && preg_match('/\.(jpg|jpeg|png|gif)$/i', $pregunta['opcion_a'])): ?>
                        <label>
                            <input class="radiob" type="radio" id="opcion_<?php echo $pregunta['id']; ?>_A" name="respuesta_<?php echo $pregunta['id']; ?>" value="1" > 
                            <img src="<?php echo $pregunta['opcion_a']; ?>" alt="Opción A" style="max-width: 100%; height: auto;">
                        </label>
                    <?php else: ?>
                        <label>
                            <input class="radiob" type="radio" id="opcion_<?php echo $pregunta['id']; ?>_A" name="respuesta_<?php echo $pregunta['id']; ?>" value="1" > 
                            <?php echo $pregunta['opcion_a']; ?>
                        </label>
                    <?php endif; ?>
                    <!-- opcion b -->
                    <?php if ($pregunta['opcion_b'] && preg_match('/\.(jpg|jpeg|png|gif)$/i', $pregunta['opcion_b'])): ?>
                      <label>
                          <input class="radiob" type="radio" id="opcion_<?php echo $pregunta['id']; ?>_B" name="respuesta_<?php echo $pregunta['id']; ?>" value="2" > 
                          <img src="<?php echo $pregunta['opcion_b']; ?>" alt="Opción A" style="max-width: 100%; height: auto;">
                      </label>
                  <?php else: ?>
                      <label>
                          <input class="radiob" type="radio" id="opcion_<?php echo $pregunta['id']; ?>_B" name="respuesta_<?php echo $pregunta['id']; ?>" value="2" > 
                          <?php echo $pregunta['opcion_b']; ?>
                      </label>
                  <?php endif; ?>
                  <!-- opcion c -->
                  <?php if ($pregunta['opcion_c'] && preg_match('/\.(jpg|jpeg|png|gif)$/i', $pregunta['opcion_c'])): ?>
                      <label>
                          <input class="radiob" type="radio" id="opcion_<?php echo $pregunta['id']; ?>_C" name="respuesta_<?php echo $pregunta['id']; ?>" value="3" > 
                          <img src="<?php echo $pregunta['opcion_c']; ?>" alt="Opción A" style="max-width: 100%; height: auto;">
                      </label>
                  <?php else: ?>
                      <label>
                          <input class="radiob" type="radio" id="opcion_<?php echo $pregunta['id']; ?>_C" name="respuesta_<?php echo $pregunta['id']; ?>" value="3" > 
                          <?php echo $pregunta['opcion_c']; ?>
                      </label>
                  <?php endif; ?>
                  <!-- opcion d -->
                  <?php if ($pregunta['opcion_d'] && preg_match('/\.(jpg|jpeg|png|gif)$/i', $pregunta['opcion_d'])): ?>
                      <label>
                          <input class="radiob" type="radio" id="opcion_<?php echo $pregunta['id']; ?>_D" name="respuesta_<?php echo $pregunta['id']; ?>" value="4" > 
                          <img src="<?php echo $pregunta['opcion_d']; ?>" alt="Opción A" style="max-width: 100%; height: auto;">
                      </label>
                  <?php else: ?>
                      <label>
                          <input class="radiob" type="radio" id="opcion_<?php echo $pregunta['id']; ?>_D" name="respuesta_<?php echo $pregunta['id']; ?>" value="4" > 
                          <?php echo $pregunta['opcion_d']; ?>
                      </label>
                  <?php endif; ?>
                </div>
            </div>
            <?php } ?>
            <input type="hidden" name="materia_id" value="<?php echo $materia_id; ?>">
            <div class="boton">
                <input type="submit" value="Enviar" class="botonPrincipal">
            </div>
        </form>
        <?php endif; } ?>
        <br>
        <br>
        </div>
    </main>
    <!-- internos -->
    <script src="../../src/js/comprimir_expandir.js"></script>
    <script src="../../src/js/radio.js"></script>

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