<?php
session_start();
require '../../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'alumno') {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    exit();
}

$materialId = $_GET['id'];

$db = new Database();
$con = $db->conectar();

$stmt = $con->prepare("SELECT nombre, contenido, tipo_material FROM materiales_apoyo WHERE id = ?");
$stmt->execute([$materialId]);
$material = $stmt->fetch(PDO::FETCH_ASSOC);

if ($material) {
    echo json_encode(['success' => true, 'nombre' => $material['nombre'], 'contenido' => $material['contenido'], 'tipo_material' => $material['tipo_material']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Material no encontrado']);
}