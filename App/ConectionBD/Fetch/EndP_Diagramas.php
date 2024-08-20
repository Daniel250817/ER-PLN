<?php
session_start(); // Inicia la sesión

include __DIR__ . '/../db_connection.php';

$conn = getDbConnection();

// Obtén el ID del usuario logueado desde la sesión
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM Diagramas WHERE IdUsuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$diagramas= array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $diagramas[] = $row;
    }
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($diagramas);
?>