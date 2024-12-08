<?php
// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión y si es un administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'administrador') {
    header("Location: ../../logout.php");
    exit();
}

// Verifica si se ha pasado un ID en la URL
if (!isset($_GET['id'])) {
    echo "No se ha proporcionado un ID de material.";
    exit();
}
// Verifica si existe `id_materia` en la sesión
if (!isset($_SESSION['materia_id'])) {
    echo "ID de materia no establecido en la sesión.";
    exit();
}

// Obtén el ID del material a eliminar
$material_id = $_GET['id'];

// Importa la clase Database
require '../../config/database.php';

// Crea una instancia de la clase Database
$db = new Database();
$con = $db->conectar();

// Prepara la consulta para eliminar el material
$stmt = $con->prepare("DELETE FROM materiales_apoyo WHERE id = ?");

// Ejecuta la consulta y verifica si se eliminó correctamente
if ($stmt->execute([$material_id])) {
    // Redirige a la página anterior o a la lista de materiales después de eliminar
    $_SESSION['success'] =  "Material eliminado exitosamente.";
    header("Location: material.php?materia_id=".$_SESSION['materia_id']);
    exit();
} else {
    echo "Error al eliminar el material.";
    exit();
}

