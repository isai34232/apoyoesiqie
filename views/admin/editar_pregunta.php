<?php
session_start();

// Verifica si el usuario ha iniciado sesión y si es un administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'administrador') {
    header("Location: ../../logout.php");
    exit();
}

require '../../config/database.php';

$db = new Database();
$con = $db->conectar();

// Verifica si se ha proporcionado un ID de pregunta
if (isset($_GET['id'])) {
    $pregunta_id = intval($_GET['id']);

    // Obtiene los datos de la pregunta
    $sql = "SELECT * FROM preguntas WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $pregunta_id, PDO::PARAM_INT);
    $stmt->execute();
    $pregunta = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica si la pregunta existe
    if (!$pregunta) {
        die("Pregunta no encontrada.");
    }

    // Procesa el formulario si se ha enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pregunta_texto = $_POST['pregunta'];
        $opcion_a = str_replace(['<p>', '</p>', '<h1>', '</h1>'], '', $_POST['opcion_a']);
        $opcion_b = str_replace(['<p>', '</p>', '<h1>', '</h1>'], '', $_POST['opcion_b']);
        $opcion_c = str_replace(['<p>', '</p>', '<h1>', '</h1>'], '', $_POST['opcion_c']);
        $opcion_d = str_replace(['<p>', '</p>', '<h1>', '</h1>'], '', $_POST['opcion_d']);
        $respuesta_correcta = str_replace(['<p>', '</p>', '<h1>', '</h1>'], '', $_POST['respuesta_correcta']);
        
        // Verifica si el usuario desea cambiar la imagen
        if (isset($_POST['cambiar_imagen']) && $_POST['cambiar_imagen'] == '1') {
            // Elimina la imagen actual
            if (!empty($pregunta['imagen']) && file_exists($pregunta['imagen'])) {
                unlink($pregunta['imagen']);
            }
            
            // Maneja la subida de la nueva imagen
            if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] == 0) {
                $directorio_destino = '../../src/img/preguntas/' . $pregunta_id . '/';
                
                // Crea el directorio si no existe
                if (!is_dir($directorio_destino)) {
                    mkdir($directorio_destino, 0777, true);
                }
                
                // Define la ruta completa de la nueva imagen
                $ruta_imagen = $directorio_destino . basename($_FILES['nueva_imagen']['name']);
                
                // Mueve la imagen subida al destino
                if (move_uploaded_file($_FILES['nueva_imagen']['tmp_name'], $ruta_imagen)) {
                    // Actualiza la URL de la imagen en la base de datos
                    $update_img_sql = "UPDATE preguntas SET imagen = :imagen WHERE id = :id";
                    $update_img_stmt = $con->prepare($update_img_sql);
                    $update_img_stmt->bindParam(':imagen', $ruta_imagen);
                    $update_img_stmt->bindParam(':id', $pregunta_id, PDO::PARAM_INT);
                    $update_img_stmt->execute();
                } else {
                    die("Error al subir la nueva imagen.");
                }
            }
        }

           // Procesar opción A
    if (isset($_POST['cambiar_opcion_a']) && $_POST['cambiar_opcion_a'] == '1') {
        if (!empty($pregunta['opcion_a']) && file_exists($pregunta['opcion_a'])) {
            unlink($pregunta['opcion_a']);
        }
        if (isset($_FILES['nueva_opcion_a']) && $_FILES['nueva_opcion_a']['error'] == 0) {
            $ruta_opcion_a = '../../src/img/preguntas/' . $pregunta_id . '/' . basename($_FILES['nueva_opcion_a']['name']);
            move_uploaded_file($_FILES['nueva_opcion_a']['tmp_name'], $ruta_opcion_a);
            $update_img_sql = "UPDATE preguntas SET opcion_a = :opcion_a WHERE id = :id";
            $update_img_stmt = $con->prepare($update_img_sql);
            $update_img_stmt->bindParam(':opcion_a', $ruta_opcion_a);
            $update_img_stmt->bindParam(':id', $pregunta_id, PDO::PARAM_INT);
            $update_img_stmt->execute();
        }
    }

    // Procesar opción B
    if (isset($_POST['cambiar_opcion_b']) && $_POST['cambiar_opcion_b'] == '1') {
        if (!empty($pregunta['opcion_b']) && file_exists($pregunta['opcion_b'])) {
            unlink($pregunta['opcion_b']);
        }
        if (isset($_FILES['nueva_opcion_b']) && $_FILES['nueva_opcion_b']['error'] == 0) {
            $ruta_opcion_b = '../../src/img/preguntas/' . $pregunta_id . '/' . basename($_FILES['nueva_opcion_b']['name']);
            move_uploaded_file($_FILES['nueva_opcion_b']['tmp_name'], $ruta_opcion_b);
            $update_img_sql = "UPDATE preguntas SET opcion_b = :opcion_b WHERE id = :id";
            $update_img_stmt = $con->prepare($update_img_sql);
            $update_img_stmt->bindParam(':opcion_b', $ruta_opcion_b);
            $update_img_stmt->bindParam(':id', $pregunta_id, PDO::PARAM_INT);
            $update_img_stmt->execute();
        }
    }

    // Procesar opción C
    if (isset($_POST['cambiar_opcion_c']) && $_POST['cambiar_opcion_c'] == '1') {
        if (!empty($pregunta['opcion_c']) && file_exists($pregunta['opcion_c'])) {
            unlink($pregunta['opcion_c']);
        }
        if (isset($_FILES['nueva_opcion_c']) && $_FILES['nueva_opcion_c']['error'] == 0) {
            $ruta_opcion_c = '../../src/img/preguntas/' . $pregunta_id . '/' . basename($_FILES['nueva_opcion_c']['name']);
            move_uploaded_file($_FILES['nueva_opcion_c']['tmp_name'], $ruta_opcion_c);
            $update_img_sql = "UPDATE preguntas SET opcion_c = :opcion_c WHERE id = :id";
            $update_img_stmt = $con->prepare($update_img_sql);
            $update_img_stmt->bindParam(':opcion_c', $ruta_opcion_c);
            $update_img_stmt->bindParam(':id', $pregunta_id, PDO::PARAM_INT);
            $update_img_stmt->execute();
        }
    }

    // Procesar opción D
    if (isset($_POST['cambiar_opcion_d']) && $_POST['cambiar_opcion_d'] == '1') {
        if (!empty($pregunta['opcion_d']) && file_exists($pregunta['opcion_d'])) {
            unlink($pregunta['opcion_d']);
        }
        if (isset($_FILES['nueva_opcion_d']) && $_FILES['nueva_opcion_d']['error'] == 0) {
            $ruta_opcion_d = '../../src/img/preguntas/' . $pregunta_id . '/' . basename($_FILES['nueva_opcion_d']['name']);
            move_uploaded_file($_FILES['nueva_opcion_d']['tmp_name'], $ruta_opcion_d);
            $update_img_sql = "UPDATE preguntas SET opcion_d = :opcion_d WHERE id = :id";
            $update_img_stmt = $con->prepare($update_img_sql);
            $update_img_stmt->bindParam(':opcion_d', $ruta_opcion_d);
            $update_img_stmt->bindParam(':id', $pregunta_id, PDO::PARAM_INT);
            $update_img_stmt->execute();
        }
    }

        // Actualiza el resto de la información de la pregunta
        $update_sql = "UPDATE preguntas SET pregunta = :pregunta, opcion_a = :opcion_a, opcion_b = :opcion_b, opcion_c = :opcion_c, opcion_d = :opcion_d, respuesta_correcta = :respuesta_correcta WHERE id = :id";
        $update_stmt = $con->prepare($update_sql);
        $update_stmt->bindParam(':pregunta', $pregunta_texto);
        $update_stmt->bindParam(':opcion_a', $opcion_a);
        $update_stmt->bindParam(':opcion_b', $opcion_b);
        $update_stmt->bindParam(':opcion_c', $opcion_c);
        $update_stmt->bindParam(':opcion_d', $opcion_d);
        $update_stmt->bindParam(':respuesta_correcta', $respuesta_correcta);
        $update_stmt->bindParam(':id', $pregunta_id, PDO::PARAM_INT);
        $update_stmt->execute();

        // Redirige al índice después de la actualización
        header("Location: preguntas.php");
        exit();
    }
} else {
    die("ID de pregunta no proporcionado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pregunta</title>
  <!-- Externas -->
<link rel="preload" href="https://db.onlinewebfonts.com/c/240a7cb10b49b02c94ceddc459d385a9?family=Gagalin-Regular" as="style">
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" crossorigin="anonymous" as="style">

<!-- Preload with crossorigin -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet" crossorigin="anonymous">

<!-- Other external fonts -->
<link href="https://fonts.cdnfonts.com/css/january-threed" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
 

    <!-- internas -->
    <link rel="stylesheet" href="../../src/css/siderbar.css">
    <link rel="stylesheet" href="../../src/css/ialumno.css">
    <link rel="stylesheet" href="../../src/css/normalize.css">
    <link rel="stylesheet" href="../../src/css/siderN.css">



    
    <!-- MathJax -->
    <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script src="../../build/ckeditor.js"></script>
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
        <h1>Editar Pregunta</h1>

        <form method="POST" enctype="multipart/form-data">
            <label for="pregunta">Pregunta:</label><br>
            
                <textarea name="pregunta" id="pregunta" rows="4" cols="50"> <?php echo $pregunta['pregunta']; ?></textarea>
                <?php 
                if ($pregunta['imagen'] != null) {?>
                        <img src="<?php echo $pregunta['imagen']; ?>" alt="Imagen Pregunta">

                        <p>¿Desea cambiar la imagen?</p>
                        <input type="checkbox" id="cambiar_imagen" name="cambiar_imagen" value="1">
                        <label for="cambiar_imagen">Sí, quiero cambiar la imagen</label>
                        <br>
                        <div id="upload_container" style="display:none;">
                            <label for="nueva_imagen">Subir nueva imagen:</label>
                            <input type="file" id="nueva_imagen" name="nueva_imagen" accept="image/*">
                        </div>
                <?php 
                }
                ?>
                <br>
                <p>Opción A:</p>
                <?php 
                if ($pregunta['opcion_a'] != null && strpos($pregunta['opcion_a'], '../../src') === 0) { ?>
                    <img src="<?php echo $pregunta['opcion_a']; ?>" alt="Imagen Opción A"><br>
                    <input type="hidden" name="opcion_a" id="opcion_a" value="<?php echo $pregunta['opcion_a'] ?>">

                    <label for="cambiar_opcion_a">Cambiar imagen:</label>
                    
                    <input type="checkbox" id="cambiar_opcion_a" name="cambiar_opcion_a" value="1">
                    <div id="upload_opcion_a" style="display:none;">
                        <input type="file" name="nueva_opcion_a" accept="image/*">
                    </div>
                <?php 
                } else {?>
                <textarea type="text" name="opcion_a" id="opcion_a" ><p><?php echo $pregunta['opcion_a']; ?></p></textarea><br>
                <script>
                    ClassicEditor.create(document.querySelector('#opcion_a'))
                        .then(editor => {
                            window.editor = editor;
                        })
                        .catch(error => {
                            console.error('There was a problem initializing the editor.', error);
                        });
                </script>
                <?php
                }
                ?>
               <p>Opción B:</p>
                <?php 
                if ($pregunta['opcion_b'] != null && strpos($pregunta['opcion_b'], '../../src') === 0) { ?>
                    <img src="<?php echo $pregunta['opcion_b']; ?>" alt="Imagen Opción B"><br>
                    <input type="hidden" name="opcion_b" id="opcion_b" value="<?php echo $pregunta['opcion_b'] ?>">

                    <label for="cambiar_opcion_b">Cambiar imagen:</label>
                    <input type="checkbox" id="cambiar_opcion_b" name="cambiar_opcion_b" value="1">
                    <div id="upload_opcion_b" style="display:none;">
                        <input type="file" name="nueva_opcion_b" accept="image/*">
                    </div>
                <?php 
                } else {
                ?>
                <textarea type="text" name="opcion_b" id="opcion_b" ><p><?php echo $pregunta['opcion_b']; ?></p></textarea><br>
                <script>
                    ClassicEditor.create(document.querySelector('#opcion_b'))
                        .then(editor => {
                            window.editor = editor;
                        })
                        .catch(error => {
                            console.error('There was a problem initializing the editor.', error);
                        });
                </script>
                <?php
                }
                ?>
                <p>Opción C:</p>
                <?php 
                if ($pregunta['opcion_c'] != null && strpos($pregunta['opcion_c'], '../../src') === 0) { ?>
                    <img src="<?php echo $pregunta['opcion_c']; ?>" alt="Imagen Opción C"><br>
                    <input type="hidden" name="opcion_c" id="opcion_c" value="<?php echo $pregunta['opcion_c'] ?>">

                    <label for="cambiar_opcion_c">Cambiar imagen:</label>
                    <input type="checkbox" id="cambiar_opcion_c" name="cambiar_opcion_c" value="1">
                    <div id="upload_opcion_c" style="display:none;">
                        <input type="file" name="nueva_opcion_c" accept="image/*">
                    </div>
                <?php 
                } else {
                ?>
                <textarea type="text" name="opcion_c" id="opcion_c" ><p><?php echo $pregunta['opcion_c']; ?></p></textarea><br>
                <script>
                    ClassicEditor.create(document.querySelector('#opcion_c'))
                        .then(editor => {
                            window.editor = editor;
                        })
                        .catch(error => {
                            console.error('There was a problem initializing the editor.', error);
                        });
                </script>
                <?php
                }
                ?>
                <p>Opción D:</p>
                <?php 
                if ($pregunta['opcion_d'] != null && strpos($pregunta['opcion_d'], '../../src') === 0) { ?>
                    <img src="<?php echo $pregunta['opcion_d']; ?>" alt="Imagen Opción D"><br>
                    <input type="hidden" name="opcion_d" id="opcion_d" value="<?php echo $pregunta['opcion_d'] ?>">

                    <label for="cambiar_opcion_d">Cambiar imagen: </label>
                    <input type="checkbox" id="cambiar_opcion_d" name="cambiar_opcion_d" value="1">
                    <div id="upload_opcion_d" style="display:none;">
                        <input type="file" name="nueva_opcion_d" accept="image/*">
                    </div>
                    <br>
                <?php 
                } else {
                ?>
                <textarea type="text" name="opcion_d" id="opcion_d" ><p><?php echo $pregunta['opcion_d']; ?></p></textarea><br>
                <script>
                    ClassicEditor.create(document.querySelector('#opcion_d'))
                        .then(editor => {
                            window.editor = editor;
                        })
                        .catch(error => {
                            console.error('There was a problem initializing the editor.', error);
                        });
                </script>
                <?php
                }
                ?>

            <label for="respuesta_correcta">Respuesta Correcta:</label>
            <select name="respuesta_correcta" id="respuesta_correcta" required>
                <option value="">-- Selecciona --</option>
                <option value="1" <?php echo ($pregunta['respuesta_correcta'] == '1') ? 'selected' : ''; ?>>Opción A</option>
                <option value="2" <?php echo ($pregunta['respuesta_correcta'] == '2') ? 'selected' : ''; ?>>Opción B</option>
                <option value="3" <?php echo ($pregunta['respuesta_correcta'] == '3') ? 'selected' : ''; ?>>Opción C</option>
                <option value="4" <?php echo ($pregunta['respuesta_correcta'] == '4') ? 'selected' : ''; ?>>Opción D</option>
            </select><br><br>

            <input class="botonPrincipal" type="submit" value="Actualizar Pregunta"><br><br><br>
        </form>
        </div>
        <button class="boton--zoom" id="toggleButton"><span id="zoom" class=" material-symbols-outlined"> zoom_in_map </span></button>
       </main>

    <script src="../../src/js/comprimir_expandir.js"></script>

    <script>
    document.getElementById('cambiar_imagen').addEventListener('change', function() {
        var uploadContainer = document.getElementById('upload_container');
        if (this.checked) {
            uploadContainer.style.display = 'block';
        } else {
            uploadContainer.style.display = 'none';
        }
    });
    </script>


    <!-- Iconos -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
   
    <script>
        ClassicEditor.create(document.querySelector('#pregunta'))
            .then(editor => {
                window.editor = editor;
            })
            .catch(error => {
                console.error('There was a problem initializing the editor.', error);
            });
    </script>
     
</body>
</html>