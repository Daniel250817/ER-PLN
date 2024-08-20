<?php
header('Content-Type: application/json');
session_start();
require '../db_connection.php'; // Ajusta la ruta según sea necesario

$idUsuario = $_SESSION['user_id']; // Asumiendo que el ID del usuario está almacenado en la sesión

// Obtener la conexión a la base de datos
$conn = getDbConnection();

// Verificar si la conexión se estableció correctamente
if (!$conn) {
    die(json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos: ' . $conn->connect_error]));
}

// Obtener entidades y sus relaciones FK
$query = "
    SELECT e.IdEntidades, e.Entidades, a.IdAtributos, a.Atributos, a.IdEntidades AS FK_IdEntidades
    FROM Entidades e
    LEFT JOIN Atributos a ON e.IdEntidades = a.IdEntidades
    WHERE e.IdUsuario = ? 
";

$stmt = $conn->prepare($query);
if ($stmt === false) {
    die(json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta: ' . $conn->error]));
}

$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

$entities = [];
while ($row = $result->fetch_assoc()) {
    $entities[$row['IdEntidades']]['Entidades'] = $row['Entidades'];
    $entities[$row['IdEntidades']]['atributos'][] = [
        'idAtributos' => $row['IdAtributos'],
        'Atributos' => $row['Atributos'],
        'fkIdEntidades' => $row['FK_IdEntidades']
    ];
}

echo json_encode(['status' => 'success', 'data' => $entities]);
?>