<?php
session_start();

// Importa la clase Database
require '../../config/database.php';

// Crea una instancia de la clase Database
$db = new Database();
$con = $db->conectar();

// Obtener los datos del formulario y eliminar etiquetas HTML
$materia_id = $_SESSION['materia_id'];
$pregunta= $_POST['pregunta'];

$respuesta_correcta = strip_tags($_POST['respuesta_correcta']);

// Inicializar variables para las imágenes
$imagen_pregunta = null;
$imagen_opcion_a = null;
$imagen_opcion_b = null;
$imagen_opcion_c = null;
$imagen_opcion_d = null;

// Función para manejar imágenes
function manejarImagen($archivo, $id_pregunta) {
    if (isset($_FILES[$archivo]) && $_FILES[$archivo]['error'] == UPLOAD_ERR_OK) {
        $file_tmp = $_FILES[$archivo]['tmp_name'];
        $file_name = basename($_FILES[$archivo]['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $target_dir = "../../src/img/preguntas/$id_pregunta/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $target_file = $target_dir . uniqid() . '.' . $file_ext;

        if (move_uploaded_file($file_tmp, $target_file)) {
            return $target_file;
        } else {
            echo "Error al subir la imagen.";
            exit();
        }
    }
    return null;
}

// Insertar la nueva pregunta en la base de datos
$query = "INSERT INTO preguntas (materia_id, pregunta, imagen, opcion_a, opcion_b, opcion_c, opcion_d, respuesta_correcta) 
          VALUES (:materia_id, :pregunta, :imagen, :opcion_a, :opcion_b, :opcion_c, :opcion_d, :respuesta_correcta)";

$stmt = $con->prepare($query);

// Vincular los parámetros
$stmt->bindParam(':materia_id', $materia_id, PDO::PARAM_INT);
$stmt->bindParam(':pregunta', $pregunta, PDO::PARAM_STR);
$stmt->bindValue(':imagen', $imagen_pregunta, PDO::PARAM_STR);
$stmt->bindValue(':opcion_a', $opcion_a ?? '', PDO::PARAM_STR);
$stmt->bindValue(':opcion_b', $opcion_b ?? '', PDO::PARAM_STR);
$stmt->bindValue(':opcion_c', $opcion_c ?? '', PDO::PARAM_STR);
$stmt->bindValue(':opcion_d', $opcion_d ?? '', PDO::PARAM_STR);
$stmt->bindParam(':respuesta_correcta', $respuesta_correcta, PDO::PARAM_STR);

// Valores predeterminados para las opciones
$opcion_a = str_replace(['<p>', '</p>', '<h1>', '</h1>'], '', $_POST['opcion_a'] ?? '');
$opcion_b = str_replace(['<p>', '</p>', '<h1>', '</h1>'], '', $_POST['opcion_b'] ?? '');
$opcion_c = str_replace(['<p>', '</p>', '<h1>', '</h1>'], '', $_POST['opcion_c'] ?? '');
$opcion_d = str_replace(['<p>', '</p>', '<h1>', '</h1>'], '', $_POST['opcion_d'] ?? '');


// Ejecutar la consulta
if ($stmt->execute()) {
    // Obtener el ID de la pregunta recién insertada
    $id_pregunta = $con->lastInsertId();

    // Procesar imágenes de las opciones
    if ($_POST["tipo_opcion_a"] == 'imagen') {
        $imagen_opcion_a = manejarImagen("opcion_a_imagen", $id_pregunta);
        $opcion_a = $imagen_opcion_a;
    }

    if ($_POST["tipo_opcion_b"] == 'imagen') {
        $imagen_opcion_b = manejarImagen("opcion_b_imagen", $id_pregunta);
        $opcion_b = $imagen_opcion_b;
    }

    if ($_POST["tipo_opcion_c"] == 'imagen') {
        $imagen_opcion_c = manejarImagen("opcion_c_imagen", $id_pregunta);
        $opcion_c = $imagen_opcion_c;
    }

    if ($_POST["tipo_opcion_d"] == 'imagen') {
        $imagen_opcion_d = manejarImagen("opcion_d_imagen", $id_pregunta);
        $opcion_d = $imagen_opcion_d;
    }

    // Actualizar la pregunta con las opciones y las imágenes
    $update_query = "UPDATE preguntas SET 
                     opcion_a = :opcion_a, opcion_b = :opcion_b, 
                     opcion_c = :opcion_c, opcion_d = :opcion_d
                     WHERE id = :id_pregunta";

    $update_stmt = $con->prepare($update_query);
    $update_stmt->bindValue(':opcion_a', $opcion_a, PDO::PARAM_STR);
    $update_stmt->bindValue(':opcion_b', $opcion_b, PDO::PARAM_STR);
    $update_stmt->bindValue(':opcion_c', $opcion_c, PDO::PARAM_STR);
    $update_stmt->bindValue(':opcion_d', $opcion_d, PDO::PARAM_STR);
    $update_stmt->bindParam(':id_pregunta', $id_pregunta, PDO::PARAM_INT);
    $update_stmt->execute();

    // Manejo de la imagen de la pregunta
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen_pregunta = manejarImagen('imagen', $id_pregunta);

        // Actualizar la URL de la imagen en la base de datos si es necesario
        if ($imagen_pregunta) {
            $update_query = "UPDATE preguntas SET imagen = :imagen WHERE id = :id_pregunta";
            $update_stmt = $con->prepare($update_query);
            $update_stmt->bindParam(':imagen', $imagen_pregunta, PDO::PARAM_STR);
            $update_stmt->bindParam(':id_pregunta', $id_pregunta, PDO::PARAM_INT);
            $update_stmt->execute();
        }
    }

    // Redirige a la página principal después de añadir la pregunta
    header("Location: preguntas.php?materia_id=" . urlencode($materia_id));
    exit();
} else {
    echo "Error al añadir la pregunta.";
}

// Cerrar la conexión
$con = null;
