<?php
// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión y si es un administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'administrador') {
    header("Location: ../../logout.php");
    exit();
}

// Verifica si existe `id_materia` en la sesión
if (!isset($_SESSION['materia_id'])) {
    echo "ID de materia no establecido en la sesión.";
    exit();
}

// Importa la clase Database
require '../../config/database.php';

// Crea una instancia de la clase Database
$db = new Database();
$con = $db->conectar();

// Función para validar entradas del formulario
function validarEntrada($data) {
    return isset($data) && !empty(trim($data));
}

// Procesa el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene y valida los valores del formulario
    $tema_id = validarEntrada($_POST['tema_id']) ? $_POST['tema_id'] : null;

    $tipo_material = validarEntrada($_POST['tipo_material']) ? $_POST['tipo_material'] : null;
    $nombre = validarEntrada($_POST['titulo']) ? $_POST['titulo'] : null;
    $contenido = validarEntrada($_POST['contenido']) ? $_POST['contenido'] : null;
    $id_materia = $_SESSION['materia_id'];



    // Verifica si todos los campos obligatorios están completos
    if (!$tema_id || !$tipo_material || !$nombre || !$contenido) {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: nuevo_material.php?materia_id=".$id_materia);
        exit();
    }

    // Inserta los datos en la tabla materiales_apoyo
    $stmt = $con->prepare("
        INSERT INTO materiales_apoyo (id_tema, tipo_material, nombre, contenido, id_materia) 
        VALUES (?, ?, ?, ?, ?)
    ");

    // Ejecuta la inserción y verifica el resultado
    if ($stmt->execute([$tema_id, $tipo_material, $nombre, $contenido, $id_materia])) {
        $_SESSION['success'] =  "Material agregado exitosamente.";
        header("Location: material.php?materia_id=".$id_materia);
    } else {
        $_SESSION['error'] = "Error al agregar el material.";
    }
}
