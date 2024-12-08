<?php
session_start();
require '../../config/database.php';

// Conexión a la base de datos
$db = new Database();
$con = $db->conectar();

// Obtener el ID del material desde la URL
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID inválido.";
    exit;
}

// Obtener los datos del material
$stmt = $con->prepare("SELECT * FROM materiales_apoyo WHERE id = ?");
$stmt->execute([$id]);
$material = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$material) {
    echo "Material no encontrado.";
    exit;
}

// Obtener los temas y tipos de material
$temasStmt = $con->query("SELECT * FROM temas"); // Ajusta la consulta según la estructura de tu base de datos
$temas = $temasStmt->fetchAll(PDO::FETCH_ASSOC);

$tiposMaterial = ['Video', 'Página web', 'Documento', 'Texto']; // Puedes ajustar esto según los tipos de material que uses

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $contenido = $_POST['contenido'] ?? '';
    $tipo_material = $_POST['tipo_material'] ?? '';
    $tema_id = $_POST['tema_id'] ?? '';

    // Validar y actualizar los datos
    $stmt = $con->prepare("UPDATE materiales_apoyo SET nombre = ?, contenido = ?, tipo_material = ?, id_tema = ? WHERE id = ?");
    $stmt->execute([$titulo, $contenido, $tipo_material, $tema_id, $id]);

    header("Location: material.php"); // Redirige de nuevo a la tabla de materiales después de editar
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo material</title>
    
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



    <script src="../../build/ckeditor.js"></script>
    <script>
    function cambiarCampoContenido() {
        const tipoMaterial = document.getElementById('tipo_material').value;
        const contenidoWrapper = document.getElementById('contenido-wrapper');
        
        if (tipoMaterial === 'Texto') {
            contenidoWrapper.innerHTML = '<textarea name="contenido" id="contenido" rows="4" ><?php echo $material['contenido']; ?></textarea>';
            
            // Inicializar el editor de texto enriquecido
            ClassicEditor.create(document.querySelector('#contenido'))
                .then(editor => {
                    window.editor = editor;
                })
                .catch(error => {
                    console.error('There was un problema inicializando el editor.', error);
                });
        } else {
            contenidoWrapper.innerHTML = '<input class="campo__f" type="text" name="contenido" id="contenido" value="<?php echo htmlspecialchars($material['contenido']); ?>"  >';
        }
    }
    // Inicializar el campo contenido al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
            cambiarCampoContenido();
        });
    </script>
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
        <h2>Editar Material</h2>
    <form method="POST" action="editar_material.php?id=<?php echo htmlspecialchars($id); ?>" enctype="multipart/form-data">
        
        <!-- Seleccionar Tema -->
        <label class="centrar-texto" for="tema_id">Seleccionar Tema</label>
        <div class="select">
            <select name="tema_id" id="tema_id">
                <option value="">-- Selecciona un Tema --</option>
                <?php foreach ($temas as $tema): ?>
                    <option value="<?= $tema['id_tema'] ?>" <?= $tema['id_tema'] == $material['id_tema'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tema['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Input para el título -->
        <div class="campo">
            <label class="centrar-texto campo__label" for="titulo">Título</label>
            <input class="campo__field" type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($material['nombre']); ?>" required>
        </div>

        <!-- Tipo de material -->
        <label class="centrar-texto" for="tipo_material">Seleccionar Tipo de Material</label>
        <div class="select">
            <select name="tipo_material" id="tipo_material" onchange="cambiarCampoContenido()">
                <option value="">-- Selecciona un Tipo de Material --</option>
                <?php foreach ($tiposMaterial as $tipo): ?>
                    <option value="<?= htmlspecialchars($tipo) ?>" <?= $tipo === $material['tipo_material'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tipo) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

                    <!-- Contenedor donde se mostrará el campo de contenido -->
                    <label class="centrar-texto campo__label">Contenido</label>
                    <div id="contenido-wrapper">
                        <input class="campo__f" type="text" name="contenido" id="contenido" required>
                    </div>
                    <br>
        <button class="botonPrincipal" type="submit">Guardar Cambios</button>
    </form>
    <br>
    <br>
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

</body>
</html>
