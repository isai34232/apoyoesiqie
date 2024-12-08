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
    <link rel="stylesheet" href="../../src/css/siderN.css">


    <!-- MathJax -->
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
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
            <h2>Añadir Pregunta</h2>
            <form method="POST" action="agregar_pregunta.php" enctype="multipart/form-data">
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
            <br>
            <label for="pregunta">Pregunta:</label><br>
            <textarea name="pregunta" id="pregunta" rows="4" cols="50"></textarea><br><br>

                <!-- Nueva opción para indicar si la pregunta requiere una imagen -->
                <label for="requiere_imagen">¿La pregunta requiere una imagen?</label>
                <input type="checkbox" name="requiere_imagen" id="requiere_imagen"><br><br>

                <!-- Campo para subir la imagen -->
                <div id="campo_imagen" style="display: none;">
                    <label for="imagen">Subir Imagen:</label><br>
                    <input type="file" name="imagen" id="imagen" accept="image/*"><br><br>
                </div>

                <!-- Tipo de opción A -->
                <label for="tipo_opcion_a">Tipo de Opción A:</label><br>
                <select name="tipo_opcion_a" id="tipo_opcion_a" class="tipo_opcion">
                    <option value="texto">Texto</option>
                    <option value="imagen">Imagen</option>
                </select><br><br>

                <!-- Campo para texto de la opción A -->
                <div id="campo_opcion_a_texto">
                    <label for="opcion_a">Opción A:</label><br>
                    <textarea name="opcion_a" id="opcion_a"></textarea><br><br>
                </div>

                <!-- Campo para subir la imagen de la opción A -->
                <div id="campo_opcion_a_imagen" style="display: none;">
                    <label for="opcion_a_imagen">Subir Imagen Opción A:</label><br>
                    <input type="file" name="opcion_a_imagen" id="opcion_a_imagen" accept="image/*"><br><br>
                </div>

                <!-- Repite la misma estructura para las opciones B, C y D -->
                <!-- Tipo de opción B -->
                <label for="tipo_opcion_b">Tipo de Opción B:</label><br>
                <select name="tipo_opcion_b" id="tipo_opcion_b" class="tipo_opcion">
                    <option value="texto">Texto</option>
                    <option value="imagen">Imagen</option>
                </select><br><br>

                <div id="campo_opcion_b_texto">
                    <label for="opcion_b">Opción B:</label><br>
                    <textarea name="opcion_b" id="opcion_b"></textarea><br><br>
                </div>

                <div id="campo_opcion_b_imagen" style="display: none;">
                    <label for="opcion_b_imagen">Subir Imagen Opción B:</label><br>
                    <input type="file" name="opcion_b_imagen" id="opcion_b_imagen" accept="image/*"><br><br>
                </div>

                <!-- Repite la misma estructura para las opciones C y D -->
                <label for="tipo_opcion_c">Tipo de Opción C:</label><br>
                <select name="tipo_opcion_c" id="tipo_opcion_c" class="tipo_opcion">
                    <option value="texto">Texto</option>
                    <option value="imagen">Imagen</option>
                </select><br><br>

                <div id="campo_opcion_c_texto">
                    <label for="opcion_c">Opción C:</label><br>
                    <textarea name="opcion_c" id="opcion_c"></textarea><br><br>
                </div>

                <div id="campo_opcion_c_imagen" style="display: none;">
                    <label for="opcion_c_imagen">Subir Imagen Opción C:</label><br>
                    <input type="file" name="opcion_c_imagen" id="opcion_c_imagen" accept="image/*"><br><br>
                </div>

                <label for="tipo_opcion_d">Tipo de Opción D:</label><br>
                <select name="tipo_opcion_d" id="tipo_opcion_d" class="tipo_opcion">
                    <option value="texto">Texto</option>
                    <option value="imagen">Imagen</option>
                </select><br><br>

                <div id="campo_opcion_d_texto">
                    <label for="opcion_d">Opción D:</label><br>
                    <textarea name="opcion_d" id="opcion_d"></textarea><br><br>
                </div>

                <div id="campo_opcion_d_imagen" style="display: none;">
                    <label for="opcion_d_imagen">Subir Imagen Opción D:</label><br>
                    <input type="file" name="opcion_d_imagen" id="opcion_d_imagen" accept="image/*"><br><br>
                </div>

                <label for="respuesta_correcta">Respuesta Correcta:</label><br>
                <select name="respuesta_correcta" id="respuesta_correcta" required>
                    <option value="">-- Selecciona --</option>
                    <option value="1">Opción A</option>
                    <option value="2">Opción B</option>
                    <option value="3">Opción C</option>
                    <option value="4">Opción D</option>
                </select><br><br>
                <input class="botonPrincipal" type="submit" value="Añadir Pregunta"><br>
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
    <script>
        document.getElementById('requiere_imagen').addEventListener('change', function() {
            document.getElementById('campo_imagen').style.display = this.checked ? 'block' : 'none';
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const tipoOpciones = document.querySelectorAll('.tipo_opcion');

    tipoOpciones.forEach(function (select) {
        select.addEventListener('change', function () {
            const opcion = select.value;
            const id = select.id.split('_')[2]; // Obtiene A, B, C, o D
            const campoTexto = document.getElementById(`campo_opcion_${id}_texto`);
            const campoImagen = document.getElementById(`campo_opcion_${id}_imagen`);

            if (opcion === 'texto') {
                campoTexto.style.display = 'block';
                campoImagen.style.display = 'none';
            } else if (opcion === 'imagen') {
                campoTexto.style.display = 'none';
                campoImagen.style.display = 'block';
            }
        });
    });
});
    </script>
    <script src="../../build/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector('#pregunta'))
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
    </script>
     <script>
        ClassicEditor.create(document.querySelector('#opcion_a'))
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
    </script>

<script>
        ClassicEditor.create(document.querySelector('#opcion_b'))
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
    </script>
       <script>
        ClassicEditor.create(document.querySelector('#opcion_c'))
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
    </script>
       <script>
        ClassicEditor.create(document.querySelector('#opcion_d'))
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
    </script>
</body>
</html>
