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

// Obtener las materias para el dropdown
$query = "SELECT * FROM materias";
$result = $con->query($query);

// Obtener el ID de la materia seleccionada si está presente
$materia_id_seleccionada = isset($_GET['materia_id']) ? $_GET['materia_id'] : '';

// Obtener los temas asociados a la materia seleccionada
$temas = [];
if ($materia_id_seleccionada) {
    $stmtTemas = $con->prepare("SELECT id_tema, nombre FROM temas WHERE id_materia = ?");
    $stmtTemas->execute([$materia_id_seleccionada]);
    $temas = $stmtTemas->fetchAll(PDO::FETCH_ASSOC);
}
$tiposMaterial = ['Video', 'Página web', 'Documento', 'Texto'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Pregunta</title>
    
    <!-- Externas -->
    <link rel="preload" href="https://db.onlinewebfonts.com/c/240a7cb10b49b02c94ceddc459d385a9?family=Gagalin-Regular" as="style">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" crossorigin="anonymous" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/january-threed" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    
    <!-- internos -->
    <link rel="stylesheet" href="../../src/css/siderbar.css">
    <link rel="stylesheet" href="../../src/css/ialumno.css">
    <link rel="stylesheet" href="../../src/css/normalize.css">
    <link rel="stylesheet" href="../../src/css/referencias.css">
    <link rel="stylesheet" href="../../src/css/siderN.css">


    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
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
            <h2>Añadir nuevo material</h2>
            <form method="POST" action="agregar_material.php" enctype="multipart/form-data">
            <?php
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['id'] == $materia_id_seleccionada) {
                    ?>
                    <p><?php echo htmlspecialchars($row['nombre']); ?></p>
                    <?php
                    $_SESSION['materia_id'] = $row['id'];
                    break;
                }
            }
            ?>
            
            <label class="centrar-texto" for="tema_id">Seleccionar Tema</label>
                <div class="select">
                    <select name="tema_id" id="tema_id">
                        <option value="">-- Selecciona un Tema --</option>
                        <?php foreach ($temas as $tema): ?>
                            <option value="<?= $tema['id_tema'] ?>"><?= $tema['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
        
            <br>
            <!-- Input para el título -->
            <div class="campo">
                <label class="centrar-texto campo__label" for="titulo">Título</label>
                <input  class="campo__field" type="text" name="titulo" id="titulo" required>
            </div>
            <!-- Tipo de material-->
             
                <!-- Dropdown para tipos de material -->
                <label class="centrar-texto" for="tipo_material">Seleccionar Tipo de Material</label>
                <div class="select">
                    <select name="tipo_material" id="tipo_material" onchange="cambiarCampoContenido()">
                        <option value="">-- Selecciona un Tipo de Material --</option>
                        <?php foreach ($tiposMaterial as $tipo): ?>
                            <option value="<?= htmlspecialchars($tipo) ?>">
                                <?= htmlspecialchars($tipo) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <br>
                <!-- Contenedor donde se mostrará el campo de contenido -->
                    <label class="centrar-texto campo__label">Contenido</label>
                    <div id="contenido-wrapper">
                        <input class="campo__f" type="text" name="contenido" id="contenido" required>
                    </div>
             

                <br>
                <br>

                <input class="botonPrincipal" type="submit" value="Añadir material"><br>
                <br>
                <br>
            </form>

        </div>
        <button class="boton--zoom" id="toggleButton">
            <span id="zoom" class="material-symbols-outlined">zoom_in_map</span>
        </button>
    </main>

    <!-- internos -->
    <script src="../../src/js/comprimir_expandir.js"></script>
    <!-- Iconos -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>  
    <script src="../../build/ckeditor.js"></script>
    <script>
    function cambiarCampoContenido() {
        const tipoMaterial = document.getElementById('tipo_material').value;
        const contenidoWrapper = document.getElementById('contenido-wrapper');
        
        if (tipoMaterial === 'Texto') {
            contenidoWrapper.innerHTML = '<textarea name="contenido" id="contenido" rows="4" ></textarea>';
            
            // Inicializar el editor de texto enriquecido
            ClassicEditor.create(document.querySelector('#contenido'))
                .then(editor => {
                    window.editor = editor;
                })
                .catch(error => {
                    console.error('There was un problema inicializando el editor.', error);
                });
        } else {
            contenidoWrapper.innerHTML = '<input class="campo__f" type="text" name="contenido" id="contenido" >';
        }
    }
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
</body>
</html>
