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
    exit();
}

// Obtén el ID del usuario desde la sesión
$id_alumno = $_SESSION['user_id'];

// Consulta los resultados por materia
try {
    // Consulta para obtener los resultados y los detalles de las materias
    $query = "
        SELECT r.id_materia , m.nombre AS materia_nombre, m.icono AS materia_icono, r.resultado
        FROM resultados r
        JOIN materias m ON r.id_materia = m.id
        WHERE r.id_alumno = :alumno_id
    ";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':alumno_id', $id_alumno, PDO::PARAM_INT);
    $stmt->execute();

    // Obtener los resultados
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Agrupar resultados por materia
    $data = [];
    foreach ($results as $result) {
        $id_materia = $result['id_materia'];
        $nombre_materia = $result['materia_nombre'];
        $icono_materia = $result['materia_icono'];
        $resultado = $result['resultado'];

        if (!isset($data[$id_materia])) {
            $data[$id_materia] = [
                'nombre' => $nombre_materia,
                'icono' => $icono_materia,
                'resultado' => 0
            ];
        }
        $data[$id_materia]['resultado'] += $resultado;
    }

    // Codificar los datos como JSON
    $jsonData = json_encode($data);

} catch (Exception $e) {
    $jsonData = json_encode(['error' => $e->getMessage()]);
}

$sql = "
    SELECT m.nombre, AVG(r.resultado) as promedio
    FROM resultados r
    JOIN materias m ON r.id_materia = m.id
    GROUP BY r.id_materia
    ORDER BY promedio ASC
    LIMIT 3
";


// Prepara y ejecuta la consulta
$stmt = $con->prepare($sql);
$stmt->execute();

// Obtén los resultados
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es" class="a">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas</title>
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Graficar  -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
          <h2 class="estadisticas__titulo">Resultados de examenes por materia </h2>
          <canvas id="resultsChart" width="400" height="200"></canvas>
          <div class="iconoText">
            <h3>Materias a reforzar</h3> 
            <ion-icon src="../../src/img/ico/biceps.svg"></ion-icon>
          </div>
          <ol class="no-margin">
            <?php foreach ($resultados as $resultado) { ?>
              <li><?php     echo $resultado['nombre']  ; ?></li>
            <?php }?>
          </ol>
          <br>
        </div>
      </main>
    </div>
    <!-- internos -->
    <script src="../../src/js/comprimir_expandir.js"></script>
    <!-- Iconos -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    // Datos en formato JSON de PHP
    const results = <?php echo $jsonData; ?>;

    // Depurar el contenido de results
    console.log('Datos de resultados:', results);

    // Extraer etiquetas, datos y nombres de iconos
    const labels = Object.keys(results);
    const data = labels.map(id => results[id].resultado);
    const icons = labels.map(id => results[id].icono);

    // Depurar etiquetas y datos
    console.log('Etiquetas (IDs):', labels);
    console.log('Datos:', data);
    console.log('Iconos:', icons);

    const ctx = document.getElementById('resultsChart').getContext('2d');
  
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels.map(id => `${results[id].nombre}`), // Mostrar el nombre de la materia
            datasets: [{
                label: 'Resultados por Materia',
                data: data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 192, 0.2)',
                    'rgba(253, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)', 
                    'rgba(201, 203, 207, 0.2)'  
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 192, 1)',
                    'rgba(253, 159, 64, 1)',
                    'rgba(255, 205, 86, 1)', 
                    'rgba(201, 203, 207, 1)'  
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
              y: {
                beginAtZero: true,
                min: 0,   // Establece el mínimo del eje Y
                max: 100  // Establece el máximo del eje Y
              }
            }
        }
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