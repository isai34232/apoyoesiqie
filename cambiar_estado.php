<?php
// Importa la clase Database
require 'config/database.php';

// Crea una instancia de la clase Database
$db = new Database();
$con = $db->conectar();

// Verifica si se envían los datos esperados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos enviados en formato JSON
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id_alumno']) && isset($data['estado'])) {
        $id_alumno = $data['id_alumno'];
        $estado = $data['estado'];

        // Actualizar el estado del alumno en la base de datos
        $sql = "UPDATE alumnos SET estado = :estado WHERE alumno_id = :id_alumno";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id_alumno', $id_alumno);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Estado actualizado']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar el estado']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
    }
}
