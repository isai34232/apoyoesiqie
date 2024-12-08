<?php
// Importa la clase Database
require '../../config/database.php';

// Crea una instancia de la clase Database
$db = new Database();
$con = $db->conectar();

// Verifica si se ha pasado un ID a través de GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepara la consulta SQL para eliminar la pregunta
    $sql = "DELETE FROM preguntas WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        // Define la ruta de la carpeta que podría contener las imágenes
        $carpeta_imagenes = "../../src/img/preguntas/{$id}";

        // Verifica si la carpeta existe
        if (is_dir($carpeta_imagenes)) {
            // Elimina todos los archivos dentro de la carpeta
            $files = glob($carpeta_imagenes . '/*'); // Obtiene todos los archivos
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); // Elimina el archivo
                }
            }

            // Elimina la carpeta
            rmdir($carpeta_imagenes);
        }
            
        // Redirige a la página principal después de eliminar
        header("Location: preguntas.php");
        exit();
    } else {
        echo "Error al eliminar la pregunta.";
    }
} else {
    echo "ID no especificado.";
}
