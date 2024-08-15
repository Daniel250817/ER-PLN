<?php
include __DIR__ . '/../db_connection.php';

$conn = getDbConnection();

$sql = "SELECT * FROM Entidades";
$result = $conn->query($sql);

$entidades = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $entidades[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($entidades);
?>