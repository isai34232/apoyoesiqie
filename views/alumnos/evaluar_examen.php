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


// Verificar si el número de preguntas enviadas coincide con el número de preguntas seleccionadas
$numero_preguntas_enviadas = 0;
$preguntas_enviadas = [];

foreach ($_POST as $key => $value) {
    if (strpos($key, 'respuesta_') === 0) {
        $numero_preguntas_enviadas++;
        $pregunta_id = str_replace('respuesta_', '', $key);
    }
}

$materia_id = $_POST['materia_id'];

if ($numero_preguntas_enviadas != $_SESSION['numero_preguntas_seleccionadas']) {
    $_SESSION['preguntas_recibidas']  = $_SESSION['preguntas'];
    // Si el número de preguntas enviadas no coincide con el número de preguntas seleccionadas
    $_SESSION['error'] = "Por favor, responde todas las preguntas antes de enviar el examen. :)";
    // Guardar el materia_id y las preguntas enviadas en variables de sesión
    $_SESSION['materia_id'] = $materia_id;
    
    header("Location: resolver_examen.php"); // Redirigir a una página de error o manejarlo de otra manera
    exit();
}


$correctas = 0;
$total_preguntas = 0;
$incorrectas = [];
$correctas_preguntas = [];

$respuesta_map = ['','a', 'b', 'c', 'd'];

foreach ($_POST as $key => $respuesta_alumno) {
    if (strpos($key, 'respuesta_') === 0) {
        $total_preguntas++;
        $pregunta_id = str_replace('respuesta_', '', $key);

        // Obtener la pregunta, las opciones y la respuesta correcta de la base de datos
        $query = "SELECT pregunta, respuesta_correcta, opcion_a, opcion_b, opcion_c, opcion_d FROM preguntas WHERE id = :pregunta_id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':pregunta_id', $pregunta_id, PDO::PARAM_INT);
        $stmt->execute();
        $pregunta_data = $stmt->fetch(PDO::FETCH_ASSOC);
        $respuesta_correcta = $pregunta_data['respuesta_correcta'];

        // Mapear la respuesta correcta a la letra
        $respuesta_correcta_letra = $respuesta_map[$respuesta_correcta];
        $opciones = [
            'a' => $pregunta_data['opcion_a'],
            'b' => $pregunta_data['opcion_b'],
            'c' => $pregunta_data['opcion_c'],
            'd' => $pregunta_data['opcion_d']
        ];

        if ($respuesta_correcta == $respuesta_alumno) {
            $correctas++;
            $correctas_preguntas[] = [
                'pregunta' => $pregunta_data['pregunta'],
                'opciones' => $opciones,
                'respuesta_correcta' => $respuesta_correcta_letra
            ];
        } else {
            // Almacenar la pregunta y la respuesta correcta en el arreglo de incorrectas
            $incorrectas[] = [
                'pregunta' => $pregunta_data['pregunta'],
                'respuesta_correcta' => $respuesta_correcta_letra,
                'respuesta_correcta_texto' => $opciones[$respuesta_correcta_letra]
            ];
        }
    }
}

$calificacion = ($correctas / $total_preguntas) * 100;

// Guardar el resultado en la base de datos
$id_alumno = $_SESSION['user_id']; // Suponiendo que el ID del alumno está en la sesión

// Verificar si ya existe un registro para el alumno y la materia
$checkQuery = "SELECT COUNT(*) FROM resultados WHERE id_materia = :materia_id AND id_alumno = :alumno_id";
$checkStmt = $con->prepare($checkQuery);
$checkStmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
$checkStmt->bindParam(':alumno_id', $id_alumno, PDO::PARAM_INT);
$checkStmt->execute();

$recordExists = $checkStmt->fetchColumn() > 0;

if ($recordExists) {
    // Actualizar el registro existente
    $query = "UPDATE resultados SET resultado = :resultado, fecha = NOW() WHERE id_materia = :materia_id AND id_alumno = :alumno_id";
    $stmt = $con->prepare($query);
} else {
    // Insertar un nuevo registro
    $query = "INSERT INTO resultados (id_materia, id_alumno, resultado, fecha) VALUES (:materia_id, :alumno_id, :resultado, NOW())";
    $stmt = $con->prepare($query);
}

$stmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
$stmt->bindParam(':alumno_id', $id_alumno, PDO::PARAM_INT);
$stmt->bindParam(':resultado', $calificacion, PDO::PARAM_STR);

if ($stmt->execute()) {
    $_SESSION['success'] = "Resultados guardados correctamente.";
} else {
    $_SESSION['error'] = "Error al guardar los resultados.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados del Examen</title>
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
    <link rel="stylesheet" href="../../src/css/evaluarExamen.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                <h2>Resultados del Examen</h2>
                <p>Respuestas correctas: <?php echo $correctas; ?> de <?php echo $total_preguntas; ?></p>
                <p>Calificación: <?php echo round($calificacion, 2); ?>%</p>
                <?php
                // Definir observaciones basadas en la calificación
                if ($calificacion >= 90) {
                    $observacion = "¡Excelente trabajo!";
                } elseif ($calificacion >= 80) {
                    $observacion = "Muy bien, pero hay espacio para mejorar.";
                } elseif ($calificacion >= 70) {
                    $observacion = "Buen esfuerzo, sigue practicando.";
                } elseif ($calificacion >= 60) {
                    $observacion = "Necesitas mejorar. Considera revisar los temas.";
                } else {
                    $observacion = "Insuficiente. Es importante estudiar más.";
                }
                ?>
                <p>Observación: <?php echo $observacion; ?></p>
                <?php if (!empty($correctas_preguntas)): ?>
                    <h3>Preguntas correctas</h3>
                    <?php foreach ($correctas_preguntas as $pregunta): ?>
                        <div class="pregunta-correcta pregunta">
                          <div class="pg">
                            <strong><?php echo $pregunta['pregunta'] ?></strong><br>
                            <div class="opciones">
                                <?php foreach ($pregunta['opciones'] as $key => $opcion): ?>
                                    <?php if ($key == $pregunta['respuesta_correcta']): ?>
                                        <?php if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $opcion)){ ?>
                                            <p><?php echo strtoupper($key). ': ';?></p>
                                            <img src="<?php echo $opcion; ?>" alt='<?php echo $key?>' style="max-width: 100%; height: auto;">
                                        <?php } else { ?>    
                                            <p><?php echo strtoupper($key) . ': ' .$opcion; ?></p>
                                        <?php  } ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                          </div>
                          <ion-icon class="iconoR" name="happy-outline"></ion-icon>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($incorrectas)): ?>
                    <h3>Preguntas incorrectas</h3>
                    <?php foreach ($incorrectas as $incorrecta): ?>
                        <div class="pregunta-incorrecta pregunta">
                            <div class="pg">
                              <strong><?php echo $incorrecta['pregunta']; ?></strong><br>
                              <?php
                              if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $incorrecta['respuesta_correcta_texto'])){
                                ?>
                                <span class="respuesta-correcta">Respuesta correcta:</span>
                                 <img src="<?php echo $incorrecta['respuesta_correcta_texto']; ?>" alt="Opción A" style="max-width: 100%; height: auto;">
                            <?php
                              } else {
                              ?>
                              <span class="respuesta-correcta">Respuesta correcta: <?php echo $incorrecta['respuesta_correcta_texto']; ?></span>
                              <?php  } ?>
                            </div>
                          <ion-icon class="iconoR" name="sad-outline"></ion-icon>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (isset($_SESSION['error'])): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "<?php echo $_SESSION['error']; ?>"
                });
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: "<?php echo $_SESSION['success']; ?>"
                });
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
        });
    </script>
    <!-- Enlace a la biblioteca de confeti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
</body>
</html>
