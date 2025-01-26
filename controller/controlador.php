<?php



// Habilita el manejo de errores y establece el encabezado de respuesta JSON
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// Verifica que la solicitud sea POST y que el cuerpo contenga datos JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    // Lee los datos JSON del cuerpo de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);

    // Verifica que los datos no estén vacíos
    if (!empty($data)) {
        // Procesa los datos y genera el reporte (puede ser un archivo CSV, PDF, etc.)
        $reporte = "Reporte generado:\n\n";
        foreach ($data as $row) {
            $reporte .= implode(" ", $row);
        }

        // Guarda el reporte en un archivo
        file_put_contents('C:\xampp\htdocs\bitacora_oriental\asset\txt\dataReport.txt', $reporte);

        // Responde con un mensaje de éxito
        echo json_encode(['status' => 'success', 'message' => 'Reporte generado correctamente.']);
    } else {
        // Responde con un mensaje de error si los datos están vacíos
        echo json_encode(['status' => 'error', 'message' => 'Datos vacíos.']);
    }
} else {
    // Responde con un mensaje de error si la solicitud no es POST o el contenido no es JSON
    echo json_encode(['status' => 'error', 'message' => 'Solicitud inválida.']);
}
?>
