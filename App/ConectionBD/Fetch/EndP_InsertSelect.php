<?php
header('Content-Type: application/json');
session_start();
require '../db_connection.php'; // Archivo que contiene la conexión a la base de datos

// Función para obtener el ID del usuario actual
function getCurrentUserId() {
    return $_SESSION['user_id']; // Asumiendo que el ID del usuario está almacenado en la sesión
}

// Verificar si el índice 'action' está definido en $_GET
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Endpoint para crear una entidad
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create_entity') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nombreEntidad = $data['Entidades'];
    $idUsuario = getCurrentUserId();

    $stmt = $conn->prepare("INSERT INTO Entidades (Entidades, IdUsuario) VALUES (?, ?)");
    $stmt->bind_param("si", $nombreEntidad, $idUsuario);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['status' => 'success']);
    exit();
}

// Endpoint para crear un atributo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create_attribute') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nombreAtributo = $data['Atributos'];
    $idEntidades = $data['idEntidades'];

    $stmt = $conn->prepare("INSERT INTO Atributos (Atributos, IdEntidades) VALUES (?, ?)");
    $stmt->bind_param("si", $nombreAtributo, $idEntidades);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['status' => 'success']);
    exit();
}
?>